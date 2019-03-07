<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use App\Model\UserHasPermission;
use App\Model\Ticket;
use App\Model\TicketAttahcments;
use PDF;
use Config;
use File;

class Ticket extends Model
{
    protected $table = 'tickets';

    public function saveTicket($request)
    {    
    	if(Auth::guard('company')->check()) {
    		$userData = Auth::guard('company')->user();
    		$getAuthCompanyId = Company::where('email', $userData->email)->first();
    	}

        $id = DB::table('tickets')->insertGetId(
                                                ['code' => $request->input('ticket_code'),
                                                'subject' => $request->input('subject'),
                                                'priority' => $request->input('priority'),
                                                'assign_to' => $request->input('assign_to'),
                                                'details' => $request->input('details'),
                                                'company_id' => $getAuthCompanyId->id,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'updated_at' => date('Y-m-d H:i:s')
                                                ]
                                            );

        if (!file_exists(public_path('/uploads/ticket_attachment'))) {
            mkdir(public_path('/uploads/ticket_attachment'),'0777',false);
        }

        if(isset($request->ticket_attachment) && !empty($request->ticket_attachment))
        {
            foreach ($request->ticket_attachment as $key => $value){
                // $image = $request->file($value);
                $file_attachment = 'ticket_attachment' . time() . '.' . $value->getClientOriginalName();
                $destinationPath = public_path('/uploads/ticket_attachment/');
                $value->move($destinationPath, $file_attachment);

                $file_attachment = DB::table('ticket_attachments')->insertGetId(
                                                ['ticket_id' => $id,
                                                'file_attachment' => $file_attachment,
                                                'created_at' => date('Y-m-d H:i:s'),
                                                'updated_at' => date('Y-m-d H:i:s')
                                                ]
                                            );

            }
        }
        return TRUE;
    }
    
    public function getDepartment()
    {
        $userData = Auth::guard('company')->user();
        $getAuthCompanyId = Company::where('email', $userData->email)->first();

        $arrDepartment = Department::
                            // where('company_id', $company_id)
                            where('company_id', $getAuthCompanyId->id)
                            ->pluck('department_name', 'id')
                            ->toArray();
                
        return $arrDepartment;
    }

    public function getdatatable()
    {
        $requestData = $_REQUEST;
        $userData = Auth::guard('company')->user();
        $companyId = Company::where('email', $userData->email)->first();
        $columns = array(
            // datatable column index  => database column name
            0 => 'tickets.code',
            1 => 'tickets.priority',
            2 => 'tickets.status',
            3 => 'tickets.subject',
            4 => 'tickets.assign_to',
            5 => 'tickets.created_by',
            6 => 'tickets.details',
            7 => 'tickets.updated_by',
            8 => 'tickets.file_attachment'
        );

        $query = Ticket::join('employee','employee.id','tickets.assign_to')->join('comapnies','comapnies.id','tickets.company_id')->with(['ticketAttachments'])->where('tickets.company_id', $companyId->id)->select('tickets.*','employee.name as emp_name', 'comapnies.company_name');
        if (!empty($requestData['search']['value'])) {
            $searchVal = $requestData['search']['value'];
            $query->where(function($query) use ($columns, $searchVal, $requestData) {
                $flag = 0;
                foreach ($columns as $key => $value) {
                    $searchVal = $requestData['search']['value'];
                    if ($requestData['columns'][$key]['searchable'] == 'true') {
                        if ($flag == 0) {
                            $query->where($value, 'like', '%' . $searchVal . '%');
                            $flag = $flag + 1;
                        } else {
                            $query->orWhere($value, 'like', '%' . $searchVal . '%');
                        }
                    }
                }
            });
        }
        
        $temp = $query->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);
        $totalData = count($temp->get());
        $totalFiltered = count($temp->get());
        $resultArr = $query->skip($requestData['start'])
                            ->take($requestData['length'])
                            ->get();

        $data = array();
        foreach ($resultArr as $row) {
            $actionHtml ='';
            // $actionHtml .= '<a href="#deleteModel" data-toggle="modal" data-id="'.$row['id'].'" class="link-black text-sm deleteDepartment" data-toggle="tooltip" data-original-title="Delete" > <i class="fa fa-trash"></i></a>';
            $nestedData = array();
            $nestedData[] = $row["code"];
            $nestedData[] = $row["priority"];
            $nestedData[] = 'sss';
            $nestedData[] = $row["subject"];
            $nestedData[] = $row["emp_name"];
            $nestedData[] = $row["company_name"];
            $nestedData[] = $row["details"];
            $fileAttachmentArr = [];

            foreach ($row->ticketAttachments as $key => $value) {
                // $fileAttachmentArr[] = $value["file_attachment"];
                $fileAttachmentArr[] = '<a href="'.'download-attachment/'.$value["file_attachment"].'" class="link-black text-sm" data-toggle="tooltip" data-original-title="Edit" >'.$value["file_attachment"].'</a>';
            }

            $nestedData[] = implode(', ', $fileAttachmentArr);
            $data[] = $nestedData;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        return $json_data;
    }

    public function ticketAttachments()
    {
        return $this->hasMany('App\Model\TicketAttachments');
    }

    /*public function getNewTaskCount($company_id,$status)
    {
        $statusCount = Ticket::where('company_id', $company_id)
                            ->count();
        return $statusCount;
    }

    public function getInprogressTaskCount($company_id,$status)
    {
        $statusCount = Ticket::where('company_id', $company_id)
                            ->where('status', 'inoprogress')
                            ->count();
        return $statusCount;
    }

    public function getCompletedTaskCount($company_id,$status)
    {
        $statusCount = Ticket::where('company_id', $company_id)
                            ->where('status', 'completed')
                            ->count();
        return $statusCount;
    }*/
}