<?php

namespace App\Http\Controllers\Company;

use App\User;
use App\Model\Users;
use App\Http\Controllers\Controller;
use Auth;
use Route;
use APP;
use Illuminate\Http\Request;

class HolidayReportController extends Controller {

    public function __construct() {
        // parent::__construct();
        $this->middleware('company');
    }
    
    public function index(Request $request){
        $session = $request->session()->all();
        $data['pluginjs'] = array('jQuery/jquery.validate.min.js');
        $data['js'] = array('company/holiday-report.js');
        $data['funinit'] = array('HolidayReport.init()');
        $data['css'] = array('');
        $data['header'] = array(
            'title' => 'Holiday Report',
            'breadcrumb' => array(
                'Home' => route("dashboard"),
                'Report List' => route("report-list"),
                'Holiday Report' => 'holiday-report'));
        return view('company.holiday-report.holiday-report', $data);
    }

}