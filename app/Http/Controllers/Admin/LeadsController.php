<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;

use App\Models\Leads;

class LeadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function newLeads(Request $request){
    	$viewData['total_leads'] = Leads::count();
        $viewData['new_leads'] =  Leads::count();
        $viewData['assigned_leads'] =  Leads::count();
       	$viewData['pageTitle'] = "New Leads";
        return view(roleFolder().'.leads.lists',$viewData);
    }

    public function getNewList(Request $request)
    {
        $records = Leads::orderBy('id',"desc")->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.leads.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }
}
