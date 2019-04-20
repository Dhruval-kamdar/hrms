<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Employee;
use App\Model\Company;
use App\Model\SendSMS;
use App\Model\Notification;
use App\Model\Tax;
use App\Model\Department;

class NotificationController extends Controller
{
	public function __construct() {
		parent::__construct();
        $this->middleware('company');
    }

    public function sentNotification(Request $request) 
    {
        $session = $request->session()->all();
       
        $data['pluginjs'] = array('jQuery/jquery.validate.min.js');
        $data['js'] = array('company/notification.js');
        $data['funinit'] = array('Notification.init()');
        $data['css'] = array('');
        $data['header'] = array(
            'title' => 'Sent Notification',
            'breadcrumb' => array(
                'Home' => route("company-dashboard"),
                'Sent Notification' => 'Sent Notification'));
        return view('company.notification.notification-add', $data);
    }

	public function notificationList(Request $request)
	{
		$session = $request->session()->all();
       
        $data['pluginjs'] = array('jQuery/jquery.validate.min.js');
        $data['js'] = array('company/notification.js','jquery.form.min.js');
        $data['funinit'] = array('Notification.init()');
        $data['css'] = array('');
        $data['header'] = array(
            'title' => 'View Notification',
            'breadcrumb' => array(
                'Home' => route("company-dashboard"),
                'Sent Notification' => 'View Notification'));
        return view('company.notification.notification-list', $data);
    }
    
    public function ajaxAction(Request $request) {
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $userID = $this->loginUser;
                $objEmploye=new Employee();
                // $userid=$objEmploye->getUserid($userID->id);
                // print_r($userID);
                // print_r($userid);
                $objNotification = new Notification();
                $demoList = $objNotification->getNotificationDatatable($userID->id);
                echo json_encode($demoList);
                break;
            case 'deleteNotification':
                $result = $this->deleteNotification($request->input('data'));
                break;
        }
    }

    public function deleteNotification($postData) {
        if ($postData) {
            $findAnnounmnt = Notification::where('id', $postData['id'])->first();
            $result = $findAnnounmnt->delete();
            if ($result) {
                $return['status'] = 'success';
                $return['message'] = 'Record deleted successfully.';
                $return['jscode'] = "setTimeout(function(){
                        $('#deleteModel').modal('hide');
                        location.reload();
                    },1000)";
            } else {
                $return['status'] = 'error';
                $return['message'] = 'Something will be wrong.';
            }
            echo json_encode($return);
            exit;
        }
    }
}
