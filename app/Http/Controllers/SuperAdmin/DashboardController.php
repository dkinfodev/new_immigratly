<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
	var $dropdown;
    public function __construct()
    {
        $this->middleware('super_admin');
    }
    public function dashboard()
    {
       	$viewData['pageTitle'] = "Dashboard";
        return view(roleFolder().'.dashboard',$viewData);
    }
}
