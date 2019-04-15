<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\chat;
use Illuminate\Support\Facades\Auth;
use App\Model\Company;



class ChatController extends Controller{
    
    public function index(){
        
        $data['header'] = array(
            'title' => 'Chat',
            'breadcrumb' => array(
                'Home' => route("company-dashboard"),
                'Chat view' => 'Chat view'));
        $data['js'] = array('company/chat.js');
        return view('company.chat.chat',$data);
    }
    
    public function ajaxAction(Request $request){
        
        $action = $request->input('action');
        switch($action){
            case 'fetch_user':
                $userData = Auth::guard('company')->user();
                $getAuthCompanyId = Company::where('email', $userData->email)->first();
                $logeduserId = $getAuthCompanyId->id;
                $chatObj = new chat();
                $user_fetch = $chatObj->fetch_user($logeduserId);
                return json_encode($user_fetch);
                break;
            case 'update_last_activity':
                $updateActivity = new chat();
                $last_active = $updateActivity->update_last_activity();
                return json_encode($last_active);
                break;
            case 'insert_chat':
                $insertChat = new chat();
                $insertData = $insertChat->insert_chat($request);
                return json_encode($insertData);
                break;
            case '':
        }
        
    }
    
}

