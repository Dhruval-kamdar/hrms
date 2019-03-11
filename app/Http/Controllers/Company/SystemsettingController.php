<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Route;
use Config;
use APP;
use App\User;
use App\Model\Users;
use App\Model\Systemsetting;
use App\Model\Company;

class SystemsettingController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('company');
    }

    public function index(Request $request) {
        if ($request->isMethod('post')) {
            $userId = $this->loginUser->id;
            $companyId = Company::select('id')->where('user_id', $userId)->first();
            $objCompany = new Systemsetting();
            //echo '<pre>';
            //print_r($request->input());exit;
            $ret = $objCompany->addSystemSetting($request, $companyId->id);

            if ($ret) {
                $return['status'] = 'success';
                $return['message'] = 'System Setting Updated successfully.';
                $return['redirect'] = route('system-setting');
            } else {
                $return['status'] = 'error';
                $return['message'] = 'Somethin went wrong while creating new task!';
            }
            echo json_encode($return);
            exit;
        }
        $data['pluginjs'] = array('jQuery/jquery.validate.min.js');
        $data['js'] = array('company/systemsetting.js', 'ajaxfileupload.js', 'jquery.form.min.js');
        $data['funinit'] = array('SysSetting.init()');
        $data['css'] = array('plugins/jasny/jasny-bootstrap.min.css');
        $data['header'] = array(
            'title' => 'System-Setting',
            'breadcrumb' => array(
                'Home' => route("company-dashboard"),
                'System-setting' => 'System-setting'));

        return view('company.system-setting.set-system-settings', $data);
    }

}
