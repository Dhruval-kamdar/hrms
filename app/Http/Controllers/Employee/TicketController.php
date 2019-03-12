<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use App\Model\ManageTimeChangeRequest;
use App\Model\Ticket;
use App\Model\Employee;
use App\Model\Company;
use App\Model\Attendance;
use App\Model\Designation;
use Config;
use Auth;
use Route;
class TicketController extends Controller
{
    public function __construct() {
        parent::__construct();
        $this->middleware('employee');
    }

    public function index(Request $request)
    {
        $session = $request->session()->all();
        $userID = $this->loginUser->id;
        $empId = Employee::select('id')->where('user_id', $userID)->first();
        $objTicketList = new Ticket();
        /*Don't remove this code*/
        /*$data['arrNewCount'] = $objTicketList->getNewTaskCount($companyId->id, 'new');
        $data['arrInprogressCount'] = $objTicketList->getInprogressTaskCount($companyId->id, 'inprogress');
        $data['arrCompletedCount'] = $objTicketList->getCompletedTaskCount($companyId->id, 'completed');*/
        $data['arrNewCount'] = 0;
        $data['arrInprogressCount'] = 0;
        $data['arrCompletedCount'] = 0;
        $data['pluginjs'] = array('jQuery/jquery.validate.min.js');
        $data['js'] = array('employee/ticket.js');
        $data['funinit'] = array('Ticket.init()');
        $data['css'] = array('');
        $data['header'] = array(
            'title' => 'Ticket List',
            'breadcrumb' => array(
                'Home' => route("employee-dashboard"),
                'Tickets' => 'Tickets'));

        return view('employee.ticket.ticket-list', $data);
    }
    
    public function add(Request $request){
        $session = $request->session()->all();

        if ($request->isMethod('post')) {
            $objTicket = new Ticket();
            $result = $objTicket->saveTicket($request);
            if($result) {
                $return['status'] = 'success';
                $return['message'] = 'Ticket created successfully.';
                $return['redirect'] = route('ticket-list-emp');
            } else {
                $return['status'] = 'error';
                $return['message'] = 'Something will be wrong.';
            }

            echo json_encode($return);
            exit;
        }

        // $objEmployee = new Employee();
        // $userid = $this->loginUser->id;
        // $companyId = Company::select('id')->where('user_id', $userid)->first();
        // $employee_list = $objEmployee->getEmployeeList($companyId->id);

        $session = $request->session()->all();
        $data['pluginjs'] = array('jQuery/jquery.validate.min.js');
        $data['js'] = array('employee/ticket.js', 'jquery.form.min.js');
        $data['funinit'] = array('Ticket.add()');
        $data['css'] = array('plugins/jasny/jasny-bootstrap.min.css');
        $data['css_plugin'] = array(
                                  'bootstrap-fileinput/bootstrap-fileinput.css',  
                                );
        $data['header'] = array(
            'title' => 'Ticket',
            'breadcrumb' => array(
                'Home' => route("employee-dashboard"),
                'Tickets' => route("ticket-list-emp"),
                'Add Ticket'=>'Add Ticket'));
        return view('employee.ticket.ticket-add', $data);
    }

    public function ajaxAction(Request $request) 
    {
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objTicket = new Ticket();
                $ticketList = $objTicket->getdatatable();
                echo json_encode($ticketList);
            break;
            /*case 'deleteDepartment':
                $result = $this->deleteDepartment($request->input('data'));
                break;*/
        }
    }

    public function downloadAttachment(Request $request,$file_name)
    {
        // echo "<pre>"; print_r($file_name); exit();
        $file = public_path(). "/uploads/ticket_attachment/".$file_name;
        if(file_exists($file))
        {
            // $headers = array(
            //           'Content-Type: application:image/png',
            //         );
            return Response::download($file,$file_name);
        }
        else
        {
            return redirect('employee/ticket-list')->with('status', 'file not found!');
        }
    }
}