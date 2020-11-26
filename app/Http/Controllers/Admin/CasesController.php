<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use View;
use DB;

use App\Models\Cases;
use App\Models\ProfessionalServices;
use App\Models\ServiceDocuments;
use App\Models\Leads;
use App\Models\User;
use App\Models\CaseTeams;
use App\Models\CaseDocuments;
use App\Models\DocumentFolder;
use App\Models\CaseFolders;
use App\Models\Documents;

class CasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function cases(Request $request){
        $viewData['pageTitle'] = "Cases";
        return view(roleFolder().'.cases.lists',$viewData);
    }

    public function getAjaxList(Request $request)
    {
        $search = $request->input("search");
        $records = Cases::orderBy('id',"desc")
                        ->where(function($query) use($search){
                            if($search != ''){
                                $query->where("case_title","LIKE","%$search%");
                            }
                        })
                        ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.cases.ajax-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function createClient(Request $request){
       
        $viewData['pageTitle'] = "Create Client";
        $countries = DB::table(MAIN_DATABASE.".countries")->get();
        $viewData['countries'] = $countries;
        $view = View::make(roleFolder().'.cases.modal.new-client',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function createNewClient(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'country_code' => 'required',
            'phone_no' => 'required',
        ]);

        if ($validator->fails()) {
            $response['status'] = false;
            $response['error_type'] = 'validation';
            $error = $validator->errors()->toArray();
            $errMsg = array();
            
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        $data = array();
        $data['first_name'] = $request->input('first_name');
        $data['last_name'] = $request->input('last_name');
        $data['email'] = $request->input('email');
        $data['country_code'] = $request->input('country_code');
        $data['phone_no'] = $request->input('phone_no');
        $postData['data'] = $data;
        $result = curlRequest("create-client",$postData);
       
        if($result['status'] == 'error'){
            $response['status'] = false;
            $response['error_type'] = 'process_error';
            $response['message'] = $result['message'];
        }elseif($result['status'] == 'success'){
            $clients = User::ProfessionalClients(\Session::get("subdomain"));
            $options = '<option value="">Select Client</option>';
            foreach($clients as $client){
                $options .='<option '.($client->email == $request->input('email'))?'selected':''.' value="'.$client->unique_id.'">'.$client->first_name.' '.$client->last_name.'</option>';
            }
            $response['status'] = true;
            $response['options'] = $options;
        }else{
            $response['status'] = false;
            $response['error_type'] = 'process_error';
            $response['message'] = "Issue while creating client";
        }
        return response()->json($response);
    }
    public function add(){
        $viewData['pageTitle'] = "Create Case";
        $viewData['staffs'] = User::where("role","!=","admin")->get();
        $viewData['clients'] = User::ProfessionalClients(\Session::get('subdomain'));
        $viewData['visa_services'] = ProfessionalServices::orderBy('id',"asc")->get();
        return view(roleFolder().'.cases.add',$viewData);
    } 
    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'case_title' => 'required',
            'start_date' => 'required',
            'visa_service_id'=>'required',
        ]);

        if ($validator->fails()) {
            $response['status'] = false;
            $error = $validator->errors()->toArray();
            $errMsg = array();
            
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }

        $object = new Cases();
        $object->client_id = $request->input("client_id");
        $object->case_title = $request->input("case_title");
        $object->start_date = $request->input("start_date");
        $object->unique_id = randomNumber();
        if($request->input("end_date")){
            $object->end_date = $request->input("end_date");
        }
        if($request->input("description")){
            $object->description = $request->input("description");
        }
        $object->visa_service_id = $request->input("visa_service_id");
        $object->created_by = \Auth::user()->id;
        $object->save();

        $case_id = $object->id;
        $assign_teams = $request->input("assign_teams");
        if(!empty($assign_teams)){
            for($i=0;$i < count($assign_teams);$i++){
                $object2 = new CaseTeams();
                $object2->unique_id = randomNumber();
                $object2->user_id = $assign_teams[$i];
                $object2->case_id = $case_id;
                $object2->save();
            }
        }
        $response['status'] = true;
        $response['message'] = "Case created successfully";
        $response['redirect_back'] = baseUrl('cases');
        return response()->json($response);
    }
    public function deleteSingle($id){
        $id = base64_decode($id);
        Cases::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            Cases::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }

    public function edit($id){
        $id = base64_decode($id);
        $record = Cases::with('AssingedMember')->find($id);
        $assignedMember = $record->AssingedMember;
        $viewData['record'] = $record;
        $viewData['assignedMember'] = $assignedMember;
        $viewData['staffs'] = User::where("role","!=","admin")->get();
        $viewData['clients'] = User::ProfessionalClients(\Session::get('subdomain'));
        $viewData['visa_services'] = ProfessionalServices::orderBy('id',"asc")->get();
        $viewData['pageTitle'] = "Edit Case";
        return view(roleFolder().'.cases.edit',$viewData);
    }

    public function update($id,Request $request){
        $id = base64_decode($id);
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'case_title' => 'required',
            'start_date' => 'required',
            'visa_service_id'=>'required',
        ]);

        if ($validator->fails()) {
            $response['status'] = false;
            $error = $validator->errors()->toArray();
            $errMsg = array();
            
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }

        $object = Cases::find($id);
        $object->client_id = $request->input("client_id");
        $object->case_title = $request->input("case_title");
        $object->start_date = $request->input("start_date");
        if($request->input("end_date")){
            $object->end_date = $request->input("end_date");
        }
        if($request->input("description")){
            $object->description = $request->input("description");
        }
        $object->visa_service_id = $request->input("visa_service_id");
        $object->created_by = \Auth::user()->id;
        $object->save();

        $case_id = $object->id;
        $assign_teams = $request->input("assign_teams");
        if(!empty($assign_teams)){
            $checkRemoved = CaseTeams::whereNotIn("user_id",$assign_teams)->where("case_id",$case_id)->get();
            if(!empty($checkRemoved)){
                foreach($checkRemoved as $rec){
                    CaseTeams::deleteRecord($rec->id);
                }
            }
            for($i=0;$i < count($assign_teams);$i++){
                $checkExists = CaseTeams::where("user_id",$assign_teams[$i])->where("case_id",$case_id)->count();
                if($checkExists == 0){
                    $object2 = new CaseTeams();
                    $object2->unique_id = randomNumber();
                    $object2->user_id = $assign_teams[$i];
                    $object2->case_id = $case_id;
                    $object2->save();
                }
            }
        }
        $response['status'] = true;
        $response['message'] = "Case edited successfully";
        $response['redirect_back'] = baseUrl('cases');
        return response()->json($response);
    }

    public function pinnedFolder(Request $request){
        $validator = Validator::make($request->all(), [
            'folder_id' => 'required',
            'case_id' => 'required',
            'doc_type' => 'required',
        ]);
        $case_id = $request->input("case_id");
        $folder_id = $request->input("folder_id");
        $doc_type =  $request->input("doc_type");
        $case = Cases::find($case_id);
        $pinned_folders = $case->pinned_folders;
        if($pinned_folders != ''){
            $pinned_folders = json_decode($pinned_folders,true);
        }
        if(isset($pinned_folders[$doc_type])){
            $folders = $pinned_folders[$doc_type];
            if(!in_array($folder_id,$folders)){
                $folders[] = $folder_id;    
            }
        }else{
            $folders[] = $folder_id;
        }
        $pinned_folders[$doc_type] = $folders;
        
        $case->pinned_folders = json_encode($pinned_folders);
        $case->save();
        $response['status'] = true;
        $response['message'] = "Folder pinned!";
        \Session::flash('success', 'Folder pinned!');
        return response()->json($response);
    }

    public function unpinnedFolder(Request $request){
        $validator = Validator::make($request->all(), [
            'folder_id' => 'required',
            'case_id' => 'required',
            'doc_type' => 'required',
        ]);
        $case_id = $request->input("case_id");
        $folder_id = $request->input("folder_id");
        $doc_type =  $request->input("doc_type");
        $case = Cases::find($case_id);
        $pinned_folders = $case->pinned_folders;
        if($pinned_folders != ''){
            $pinned_folders = json_decode($pinned_folders,true);
        }
        if(isset($pinned_folders[$doc_type])){
            $folders = $pinned_folders[$doc_type];
            $key = array_search($folder_id, $folders);
            if (false !== $key) {
                unset($folders[$key]);
            }
            $pinned_folders[$doc_type] = $folders;
        }
        $case->pinned_folders = json_encode($pinned_folders);
        $case->save();
        $response['status'] = true;
        $response['message'] = "Folder unpinned!";
        \Session::flash('success', 'Folder unpinned!');
        return response()->json($response);
    }

    public function caseDocuments($id){
        $id = base64_decode($id);
        $record = Cases::find($id);
        $service = ProfessionalServices::where("id",$record->visa_service_id)->first();
        $documents = ServiceDocuments::where("service_id",$record->visa_service_id)->get();
        $case_folders = CaseFolders::where("case_id",$record->id)->get();
        $pinned_folders = $record->pinned_folders;
        if($pinned_folders != ''){
            $pinned_folders = json_decode($pinned_folders,true);
            $is_pinned = true;
        }else{
            $pinned_folders = array('default'=>array(),"other"=>array(),"extra"=>array());
            $is_pinned = false;
        }
        $viewData['is_pinned'] = $is_pinned;
        $viewData['pinned_folders'] = $pinned_folders;
        $viewData['service'] = $service;
        $viewData['documents'] = $documents;
        $viewData['case_folders'] = $case_folders;
        $viewData['record'] = $record;
        $viewData['case_id'] = $record->id;
        $viewData['pageTitle'] = "Documents for ".$service->Service($service->service_id)->name;

        return view(roleFolder().'.cases.document-folders',$viewData);
    }

    public function defaultDocuments($case_id,$doc_id){
        $case_id = base64_decode($case_id);
        $doc_id = base64_decode($doc_id);
        $record = Cases::find($case_id);
        $document = DB::table(MAIN_DATABASE.".documents_folder")->where("id",$doc_id)->first();
        $folder_id = $document->unique_id;
        $service = ProfessionalServices::where("id",$record->visa_service_id)->first();
        $case_documents = CaseDocuments::with('FileDetail')->where("case_id",$case_id)
                                        ->where("folder_id",$folder_id)
                                        ->get();
        $viewData['service'] = $service;
        $viewData['case_documents'] = $case_documents;
        $viewData['document'] = $document;
        $viewData['pageTitle'] = "Files List for ".$document->name;
        $viewData['record'] = $record;
        $viewData['doc_type'] = "default";
        $file_url = professionalDirUrl()."/documents";
        $file_dir = professionalDir()."/documents";
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        return view(roleFolder().'.cases.document-files',$viewData);
    }
    public function otherDocuments($case_id,$doc_id){
        $case_id = base64_decode($case_id);
        $doc_id = base64_decode($doc_id);
        $record = Cases::find($case_id);
        $document = ServiceDocuments::where("id",$doc_id)->first();
        $folder_id = $document->unique_id;
        $service = ProfessionalServices::where("id",$record->visa_service_id)->first();
        $case_documents = CaseDocuments::where("case_id",$case_id)
                                        ->where("folder_id",$folder_id)
                                        ->get();
        $viewData['service'] = $service;
        $viewData['case_documents'] = $case_documents;
        $viewData['document'] = $document;
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Files List for ".$document->name;
        $viewData['doc_type'] = "other";
        $file_url = professionalDirUrl()."/documents";
        $file_dir = professionalDir()."/documents";
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        return view(roleFolder().'.cases.document-files',$viewData);
    }
    public function extraDocuments($case_id,$doc_id){
        $case_id = base64_decode($case_id);
        $doc_id = base64_decode($doc_id);
        $record = Cases::find($case_id);
        $document = CaseFolders::where("id",$doc_id)->first();
        $folder_id = $document->unique_id;
        $service = ProfessionalServices::where("id",$record->visa_service_id)->first();
        $case_documents = CaseDocuments::where("case_id",$case_id)
                                        ->where("folder_id",$folder_id)
                                        ->get();
        $viewData['service'] = $service;
        $viewData['case_documents'] = $case_documents;
        $viewData['document'] = $document;
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Files List for ".$document->name;
        $viewData['doc_type'] = "extra";
        $file_url = professionalDirUrl()."/documents";
        $file_dir = professionalDir()."/documents";
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;

        return view(roleFolder().'.cases.document-files',$viewData);
    }
    public function uploadDocuments($id,Request $request){
        $id = base64_decode($id);
        $folder_id = $request->input("folder_id");
        $record = Cases::find($id);
        $document_type = $request->input("doc_type");
        $failed_files = array();
        if($file = $request->file('file'))
        {
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension();
            $allowed_extension = allowed_extension();
            if(in_array($extension,$allowed_extension)){
                $newName        = randomNumber(5)."-".$fileName;
                $source_url = $file->getPathName();
                $destinationPath = professionalDir()."/documents";
                if($file->move($destinationPath, $newName)){
                    $unique_id = randomNumber();
                    $object = new Documents();
                    $object->file_name = $newName;
                    $object->original_name = $fileName;
                    $object->unique_id = $unique_id;
                    $object->created_by = \Auth::user()->id;
                    $object->save();

                    $object2 = new CaseDocuments();
                    $object2->case_id = $id;
                    $object2->unique_id = randomNumber();
                    $object2->folder_id = $folder_id;
                    $object2->file_id = $unique_id;
                    $object2->created_by = \Auth::user()->id;
                    $object2->document_type = $document_type;
                    $object2->save();
                    $response['status'] = true;
                    $response['message'] = 'File uploaded!';
                }else{
                    $response['status'] = false;
                    $response['message'] = 'File not uploaded!';
                }
            }else{
                $response['status'] = false;
                $response['message'] = "File not allowed";
            }
            return response()->json($response);
        }
    }

    public function removeDocuments(Request $request){
        $files = $request->input("files");
        pre($files);
        exit;
    }

    public function addFolder($id,Request $request){
        // $id = base64_decode($id);
        $viewData['case_id'] = $id;
        $viewData['pageTitle'] = "Add Folder";
        $view = View::make(roleFolder().'.cases.modal.add-folder',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);        
    }

    public function createFolder($id,Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        $id = base64_decode($id);
        if ($validator->fails()) {
            $response['status'] = false;
            $error = $validator->errors()->toArray();
            $errMsg = array();
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        $object = new CaseFolders();
        $object->case_id = $id;
        $object->name = $request->input("name");
        $object->unique_id = randomNumber();
        $object->created_by = \Auth::user()->id;
        $object->save();
        
        $response['status'] = true;
        $response['message'] = "Folder added successfully";
        
        return response()->json($response);
    }

    public function editFolder($id,Request $request){
        $id = base64_decode($id);
        $record = CaseFolders::find($id);
        $viewData['case_id'] = $id;
        $viewData['pageTitle'] = "Edit Folder";
        $viewData['record'] = $record;
        $view = View::make(roleFolder().'.cases.modal.edit-folder',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);        
    }

    public function updateFolder($id,Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        $id = base64_decode($id);
        if ($validator->fails()) {
            $response['status'] = false;
            $error = $validator->errors()->toArray();
            $errMsg = array();
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        $object = CaseFolders::find($id);
        $object->name = $request->input("name");
        $object->created_by = \Auth::user()->id;
        $object->save();
        
        $response['status'] = true;
        $response['message'] = "Folder edited successfully";
        
        return response()->json($response);
    }

    public function deleteFolder($id){
        $id = base64_decode($id);
        CaseFolders::deleteRecord($id);
        return redirect()->back()->with("success","Folder has been deleted!");
    }

    public function deleteDocument($id){
        $id = base64_decode($id);
        CaseDocuments::deleteRecord($id);
        return redirect()->back()->with("success","Document has been deleted!");
    }
    public function deleteMultipleDocuments(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            CaseDocuments::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Documents deleted successfully'); 
        return response()->json($response);
    }

    public function fileMoveTo($id,$case_id,$doc_id){
        $id = base64_decode($id);
        $case_id = base64_decode($case_id);
        $doc_id = base64_decode($doc_id);
        $case = Cases::find($case_id);
        $documents = ServiceDocuments::where("service_id",$case->visa_service_id)->get();
        $document = ServiceDocuments::where("id",$doc_id)->first();
        $folder_id = $document->unique_id;
        $service = ProfessionalServices::where("id",$case->visa_service_id)->first();
        
        $case_folders = CaseFolders::where("case_id",$case->id)->get();
        $viewData['service'] = $service;
        $viewData['case'] = $case;
        $viewData['documents'] = $documents;
        $viewData['case_folders'] = $case_folders;
        $viewData['document'] = $document;
        $record = CaseDocuments::find($id);
        $viewData['id'] = $id;
        $viewData['pageTitle'] = "Move File";
        $viewData['record'] = $record;
        $view = View::make(roleFolder().'.cases.modal.move-to',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);        
    }

    public function moveFileToFolder(Request $request){
        $id = base64_decode($request->input("id"));
        $folder_id = $request->input("folder_id");
        $doc_type = $request->input("doc_type");

        $data['document_type'] = $doc_type;
        $data['folder_id'] = $folder_id;
        CaseDocuments::where("id",$id)->update($data);

        $response['status'] = true;
        $response['message'] = "File moved to folder successfully";
        \Session::flash('success', 'File moved to folder successfully'); 
        return response()->json($response);       
    }

    public function documentsExchanger($case_id){
        $id = base64_decode($case_id);
        $record = Cases::find($id);
        $service = ProfessionalServices::where("id",$record->visa_service_id)->first();
        $documents = ServiceDocuments::where("service_id",$record->visa_service_id)->get();
        $case_folders = CaseFolders::where("case_id",$record->id)->get();
        
        $file_url = professionalDirUrl()."/documents";
        $file_dir = professionalDir()."/documents";
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        $viewData['service'] = $service;
        $viewData['documents'] = $documents;
        $viewData['case_folders'] = $case_folders;
        $viewData['record'] = $record;
        $viewData['case_id'] = $record->id;
        $viewData['pageTitle'] = "Documents Exchanger";

        return view(roleFolder().'.cases.documents-exchanger',$viewData);
    }

    public function saveExchangeDocuments(Request $request){
        $doc_type = $request->input("document_type");
        $folder_id = $request->input("folder_id");
        $case_id = base64_decode($request->input("case_id"));
        $files = $request->input("files");
        $existing_files = CaseDocuments::where("case_id",$case_id)
                        ->where("document_type",$doc_type)
                        ->where("folder_id",$folder_id)
                        ->pluck("file_id");
        if(!empty($existing_files)){
            $existing_files = $existing_files->toArray();
            $new_files = array_diff($files,$existing_files);
            $new_files = array_values($new_files);
        }else{
            $new_files = $files;
        }
        for($i=0;$i < count($new_files);$i++){
            $data = array();
            $data['folder_id'] = $folder_id;
            $data['document_type'] = $doc_type;
            CaseDocuments::where("file_id",$new_files[$i])->update($data);
        }

        $response['status'] = true;
        $response['message'] = "File transfered successfully";
        return response()->json($response); 
    }
}