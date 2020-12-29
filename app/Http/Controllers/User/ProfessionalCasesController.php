<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use View;

use App\Models\User;
use App\Models\UserDetails;
use App\Models\Countries;
use App\Models\Languages;
use App\Models\UserWithProfessional;
use App\Models\UserFolders;
use App\Models\UserFiles;
use App\Models\FilesManager;


class ProfessionalCasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }
    
    public function cases()
    {
       	$viewData['pageTitle'] = "Cases";
        $professionals = UserWithProfessional::where('user_id',\Auth::user()->unique_id)->get();
        
        $viewData['professionals'] = $professionals;
        return view(roleFolder().'.cases.lists',$viewData);
    }
    
    public function view($subdomain,$case_id){
        $data['case_id'] = $case_id;
        $case = professionalCurl('cases/view',$subdomain,$data);
        if(isset($case['status']) && $case['status'] == 'success'){
            $record = $case['data'];
        }else{
            $record = array();
        }
        $viewData['subdomain'] = $subdomain;
        $viewData['pageTitle'] = "View Case";
        $viewData['record'] = $record;
        $viewData['visa_services'] = array();
        return view(roleFolder().'.cases.view',$viewData);
    } 

    public function caseDocuments($subdomain,$case_id){

        $data['case_id'] = $case_id;
        $case = professionalCurl('cases/documents',$subdomain,$data);

        $record = array();
        $service = array();
        $case_folders = array();
        $documents = array();
        $viewData['pageTitle'] = "Documents";
        if(isset($case['status']) && $case['status'] == 'success'){
            $data = $case['data'];
            $record = $data['record'];
            $service = $data['service'];
            $case_folders = $data['case_folders'];
            $documents = $data['documents'];
            $viewData['pageTitle'] = "Documents for ".$service['MainService']['name'];
        }
        $viewData['case_id'] = $case_id;
        $viewData['subdomain'] = $subdomain;
        $viewData['service'] = $service;
        $viewData['documents'] = $documents;
        $viewData['case_folders'] = $case_folders;
        $viewData['record'] = $record;
        return view(roleFolder().'.cases.document-folders',$viewData);
    }

    public function defaultDocuments($subdomain,$case_id,$doc_id){
        
        $data['case_id'] = $case_id;
        $data['doc_id'] = $doc_id;
        $data['doc_type'] = "default";

        $record = array();
        $document = array();
        $case_documents = array();
        
        $api_response = professionalCurl('cases/default-documents',$subdomain,$data);
        $result = $api_response['data'];

        $service = $result['service'];
        $record = $result['record'];
        $case_documents = $result['case_documents'];
        $document = $result['document'];
        $folder_id = $document['unique_id'];
        
        $viewData['case_id'] = $case_id;
        $viewData['doc_id'] = $doc_id;
        $viewData['subdomain'] = $subdomain;
        $viewData['service'] = $service;
        $viewData['case_documents'] = $case_documents;
        $viewData['document'] = $document;
        $viewData['pageTitle'] = "Files List for ".$document['name'];
        $viewData['record'] = $record;
        $viewData['doc_type'] = "default";
        $file_url = $result['file_url'];
        $file_dir = $result['file_dir'];
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        return view(roleFolder().'.cases.document-files',$viewData);
    }
    public function otherDocuments($subdomain,$case_id,$doc_id){

        $data['case_id'] = $case_id;
        $data['doc_id'] = $doc_id;
        $data['doc_type'] = "default";

        $record = array();
        $document = array();
        $case_documents = array();
        
        $case = professionalCurl('cases/other-documents',$subdomain,$data);

        $result = $case['data'];

        $service = $result['service'];
        $record = $result['record'];
        $case_documents = $result['case_documents'];
        $document = $result['document'];
        $folder_id = $document['unique_id'];

        $viewData['case_id'] = $case_id;
        $viewData['doc_id'] = $doc_id;
        $viewData['subdomain'] = $subdomain;
        $viewData['service'] = $service;
        $viewData['case_documents'] = $case_documents;
        $viewData['document'] = $document;
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Files List for ".$document['name'];
        $viewData['doc_type'] = "other";
        $file_url = $result['file_url'];
        $file_dir = $result['file_dir'];

        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        return view(roleFolder().'.cases.document-files',$viewData);
    }
    public function extraDocuments($subdomain,$case_id,$doc_id){

        $data['case_id'] = $case_id;
        $data['doc_id'] = $doc_id;
        $data['doc_type'] = "extra";

        $record = array();
        $document = array();
        $case_documents = array();
        
        $api_response = professionalCurl('cases/extra-documents',$subdomain,$data);
        
        $result = $api_response['data'];

        $service = $result['service'];
        $record = $result['record'];
        $case_documents = $result['case_documents'];

        $document = $result['document'];
        $folder_id = $document['unique_id'];

        $viewData['case_id'] = $case_id;
        $viewData['doc_id'] = $doc_id;
        $viewData['subdomain'] = $subdomain;
        $viewData['service'] = $service;
        $viewData['case_documents'] = $case_documents;
        $viewData['document'] = $document;
        $viewData['record'] = $record;
        $viewData['pageTitle'] = "Files List for ".$document['name'];
        $viewData['doc_type'] = "extra";
        $file_url = $result['file_url'];
        $file_dir = $result['file_dir'];
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;

        return view(roleFolder().'.cases.document-files',$viewData);
    }
    public function uploadDocuments($id,Request $request){
        $case_id = $id;
        $folder_id = $request->input("folder_id");
        $subdomain = $request->input("subdomain");

        $data['case_id'] = $case_id;
        $case = professionalCurl('cases/view',$subdomain,$data);
        $record = $case['data'];

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
                $destinationPath = professionalDir($subdomain)."/documents";

                if($file->move($destinationPath, $newName)){
                    $unique_id = randomNumber();

                    $insData['newName'] = $newName;
                    $insData['case_id'] = $case_id;
                    $insData['original_name'] = $fileName;
                    $insData['created_by'] = \Auth::user()->id;
                    $insData['document_type'] = $document_type;
                    $insData['folder_id'] = $folder_id;

                    $api_response = professionalCurl('cases/upload-documents',$subdomain,$insData);
                    
                    if($api_response['status'] == 'success'){
                        $response['status'] = true;
                        $response['message'] = 'File uploaded!';
                    }else{
                        $response['status'] = false;
                        $response['message'] = 'File not uploaded!';
                    }
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

    public function documentsExchanger($subdomain,$case_id){

        $data['case_id'] = $case_id;
        $api_response = professionalCurl('cases/documents-exchanger',$subdomain,$data);
        $result = $api_response['data'];
        
        $record = $result['record'];
        $service = $result['service'];
        $documents = $result['documents'];
        $case_folders = $result['case_folders'];
        
        $file_url = $result['file_url'];
        $file_dir = $result['file_dir'];
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        $viewData['subdomain'] = $subdomain;
        $viewData['service'] = $service;
        $viewData['documents'] = $documents;
        $viewData['case_folders'] = $case_folders;
        $viewData['record'] = $record;
        $viewData['case_id'] = $record['id'];
        $viewData['pageTitle'] = "Documents Exchanger";

        return view(roleFolder().'.cases.documents-exchanger',$viewData);
    }

    public function saveExchangeDocuments(Request $request){
        $doc_type = $request->input("document_type");
        $folder_id = $request->input("folder_id");
        $case_id = $request->input("case_id");
        $files = $request->input("files");
        $subdomain = $request->input("subdomain");

        $data['document_type'] = $doc_type;
        $data['folder_id'] = $folder_id;
        $data['case_id'] = $case_id;
        $data['files'] = $files;
        $result = professionalCurl('cases/save-exchange-documents',$subdomain,$data);
        if(isset($result['status']) && $result['status'] == 'success'){
            $response['status'] = true;
            $response['message'] = "File transfered successfully";
        }else{
            $response['status'] = false;
            $response['message'] = "Issue in file transfer, try again";
        }
        return response()->json($response); 
    }

    public function myDocumentsExchanger($subdomain,$case_id){

        $data['case_id'] = $case_id;
        $api_response = professionalCurl('cases/documents-exchanger',$subdomain,$data);
        $result = $api_response['data'];
        
        if(!isset($api_response['status'])){
            return redirect()->back()->with("success","Some issue while fetching data try again");
        }else{
            if($api_response['status'] != 'success'){
                return redirect()->back()->with("success",$api_response['message']);
            }
        }
        $record = $result['record'];
        $service = $result['service'];
        $documents = $result['documents'];
        $case_folders = $result['case_folders'];
        
        $file_url = $result['file_url'];
        $file_dir = $result['file_dir'];
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        $viewData['subdomain'] = $subdomain;
        $viewData['service'] = $service;
        $viewData['documents'] = $documents;
        $viewData['case_folders'] = $case_folders;
        $viewData['record'] = $record;
        $viewData['case_id'] = $record['id'];
        $viewData['pageTitle'] = "Export from My Documents";

        $user_id = \Auth::user()->unique_id;
        $user_folders = UserFolders::where("user_id",$user_id)->get();
        
        $user_file_url = userDirUrl()."/documents";
        $user_file_dir = userDir()."/documents";
        $viewData['user_file_url'] = $user_file_url;
        $viewData['user_file_dir'] = $user_file_dir;
        $viewData['user_folders'] = $user_folders;

        return view(roleFolder().'.cases.my-documents-exchanger',$viewData);
    }

    public function exportMyDocuments(Request $request){
        $doc_type = $request->input("document_type");
        $folder_id = $request->input("folder_id");
        $case_id = $request->input("case_id");
        $files = $request->input("files");
        $subdomain = $request->input("subdomain");
        
        $user_files = FilesManager::select("unique_id","original_name","file_name","user_id")->whereIn("unique_id",$files)->get();
        if(!empty($user_files)){
            $user_files = $user_files->toArray();
        }else{
            $user_files = array();
        }
        $data['document_type'] = $doc_type;
        $data['folder_id'] = $folder_id;
        $data['case_id'] = $case_id;
        $data['files'] = $files;
        $data['user_files'] = $user_files;
        $data['created_by'] = \Auth::user()->unique_id;
        
        $api_response = professionalCurl('cases/exchange-user-documents',$subdomain,$data);
        if(isset($api_response['status']) && $api_response['status'] == 'success'){
            $response['status'] = true;
            $response['message'] = "File transfered successfully";
        }else{
            $response['status'] = false;
            $response['message'] = "Issue in file transfer, try again";
        }
        return response()->json($response); 
    }

    public function removeCaseDocument(Request $request){
        $doc_type = $request->input("document_type");
        $folder_id = $request->input("folder_id");
        $case_id = $request->input("case_id");
        $file_id = $request->input("file_id");
        $subdomain = $request->input("subdomain");

        $data['document_type'] = $doc_type;
        $data['folder_id'] = $folder_id;
        $data['case_id'] = $case_id;
        $data['file_id'] = $file_id;
        
        $api_response = professionalCurl('cases/remove-case-document',$subdomain,$data);

        if(isset($api_response['status']) && $api_response['status'] == 'success'){
            $response['status'] = true;
            $response['message'] = "File removed successfully";
        }else{
            $response['status'] = false;
            $response['message'] = "Issue in file removed, try again";
        }
        return response()->json($response); 
    }

    public function viewDocument($case_id,$doc_id,Request $request){
        $url = $request->get("url");
        $filename = $request->get("file_name");
        $ext = fileExtension($filename);
        $subdomain = $request->get("p");

        $viewData['url'] = $url;
        $viewData['extension'] = $ext;
        $viewData['subdomain'] = $subdomain;
        $viewData['case_id'] = $case_id;
        $viewData['document_id'] = $doc_id;
        $viewData['pageTitle'] = "View Documents";
        return view(roleFolder().'.cases.view-documents',$viewData);
    }

    public function fileMoveTo($subdomain,$id,$case_id,$doc_id){
        $id = base64_decode($id);
        $case_id = base64_decode($case_id);
        $doc_id = base64_decode($doc_id);
        $case = Cases::find($case_id);

        $data['case_id'] = $case_id;
        $api_response = professionalCurl('cases/documents-exchanger',$subdomain,$data);
        $result = $api_response['data'];

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

    public function deleteDocument($subdomain,$id){
        $data = array();
        $data['document_id'] = $id;   

        $api_response = professionalCurl('cases/case-document-detail',$subdomain,$data);
        $result = $api_response['data'];
        $document = $result['record'];
       
        $data = array();
        $data['document_type'] = $document['document_type'];
        $data['folder_id'] = $document['folder_id'];
        $data['case_id'] = $document['case_id'];
        $data['file_id'] = $document['file_detail']['shared_id'];
        
        $api_response = professionalCurl('cases/remove-case-document',$subdomain,$data);
       
        if(isset($api_response['status']) && $api_response['status'] == 'success'){
            return redirect()->back()->with("success","File removed successfully");
        }else{
            return redirect()->back()->with("error","Issue in file removed, try again");
        }
    }
    public function deleteMultipleDocuments(Request $request){
        $ids = explode(",",$request->input("ids"));
        $subdomain = $request->input("subdomain");
        for($i = 0;$i < count($ids);$i++){
            $data = array();
            $data['document_id'] = $ids[$i];       
            $api_response = professionalCurl('cases/case-document-detail',$subdomain,$data);
            $result = $api_response['data'];
            $document = $result['record'];
            $data = array();
            $data['document_type'] = $document['document_type'];
            $data['folder_id'] = $document['folder_id'];
            $data['case_id'] = $document['case_id'];
            $data['file_id'] = $document['file_id'];
            
            $api_response = professionalCurl('cases/remove-case-document',$subdomain,$data);

        }
        $response['status'] = true;
        \Session::flash('success', 'Documents deleted successfully'); 
        return response()->json($response);
    }

    public function importToMyDocuments($subdomain,$case_id){

        $data['case_id'] = $case_id;
        $api_response = professionalCurl('cases/documents-exchanger',$subdomain,$data);
        $result = $api_response['data'];
        
        

        if(!isset($api_response['status'])){
            return redirect()->back()->with("success","Some issue while fetching data try again");
        }else{
            if($api_response['status'] != 'success'){
                return redirect()->back()->with("success",$api_response['message']);
            }
        }
        $record = $result['record'];
        $service = $result['service'];
        $documents = $result['documents'];
        $case_folders = $result['case_folders'];
     

        $file_url = $result['file_url'];
        $file_dir = $result['file_dir'];
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        $viewData['subdomain'] = $subdomain;
        $viewData['service'] = $service;
        $viewData['documents'] = $documents;
        $viewData['case_folders'] = $case_folders;
        $viewData['record'] = $record;
        $viewData['case_id'] = $record['id'];
        $viewData['pageTitle'] = "Import from case to My Documents";

        $user_id = \Auth::user()->unique_id;
        $user_folders = UserFolders::where("user_id",$user_id)->get();
        
        $user_file_url = userDirUrl()."/documents";
        $user_file_dir = userDir()."/documents";
        $viewData['user_file_url'] = $user_file_url;
        $viewData['user_file_dir'] = $user_file_dir;
        $viewData['user_folders'] = $user_folders;

        return view(roleFolder().'.cases.import-documents',$viewData);
    }

    public function saveImportDocuments(Request $request){

        $folder_id = $request->input("folder_id");
        $subdomain = $request->input("subdomain");
        $files = $request->input("files");
        for($i=0;$i < count($files);$i++){
            $data['document_id'] = $files[$i];
            $api_response = professionalCurl('cases/document-detail',$subdomain,$data);
            
            $result = $api_response['data'];
            $document = $result['record'];
           
            $file_dir = $result['file_dir'];
            $file_check = FilesManager::where("user_id",\Auth::user()->unique_id)
                                    ->where("is_shared",1)
                                    ->where("shared_id",$document['unique_id'])
                                    ->where("shared_from",$subdomain)
                                    ->first();
            $source = $file_dir."/".$document['file_name'];
            $destination = $file_dir."/".$document['file_name'];
            $new_name = randomNumber(5)."-".$document['original_name'];
            $destination = userDir()."/documents/".$new_name;
            if(!empty($file_check)){
                $unique_id = $file_check->unique_id;
            }else{
                copy($source, $destination);
                $unique_id = randomNumber();
                $object = new FilesManager();
                $object->file_name = $new_name;
                $object->original_name = $document['original_name'];
                $object->user_id = \Auth::user()->unique_id;
                $object->unique_id = $unique_id;
                $object->is_shared = 1;
                $object->shared_id = $document['unique_id'];
                $object->shared_from = $subdomain;
                $object->created_by = \Auth::user()->unique_id;
                $object->save();
            }

            $check_user_file = UserFiles::where("folder_id",$folder_id)->where("file_id",$unique_id)->count();
            if($check_user_file <= 0){
                $object2 = new UserFiles();
                $object2->user_id = \Auth::user()->unique_id;
                $object2->folder_id = $folder_id;
                $object2->file_id = $unique_id;
                $object2->unique_id = randomNumber();
                $object2->save(); 
            }
        }
        $response['status'] = true;
        $response['message'] = "File uploaded!";
        return response()->json($response);
    }

    public function removeUserDocument(Request $request){

        $file_id = $request->input("file_id");
        $folder_id = $request->input("folder_id");
        $file = FilesManager::where("shared_id",$file_id)->first();

        UserFiles::where("file_id",$file->unique_id)->where("folder_id",$folder_id)->delete();

        $check = UserFiles::where("file_id",$file_id)->count();
        
        $dir = userDir()."/documents/".$file->file_name;
        if($check <= 0){
            
            if(file_exists($dir)){
                unlink($dir);
                FilesManager::where("unique_id",$file->unique_id)->delete();
            }
        }

        $response['status'] = true;
        $response['dir'] = $dir;
        $response['message'] = "File removed succcessfully!";
        return response()->json($response);
    }

    public function fetchDocumentChats(Request $request){
        $case_id = $request->input("case_id");
        $document_id = $request->input("document_id");
        $subdomain = $request->input("subdomain");
        $viewData['case_id'] = $case_id;
        $viewData['document_id'] = $document_id;

        $data = array();
        $data['case_id'] = $case_id;
        $data['document_id'] = $document_id;
        $data['type'] = $request->input("type");
        $data['subdomain'] = $subdomain;
        $api_response = professionalCurl('cases/fetch-document-chats',$subdomain,$data);
        $chats = array();
        if($api_response['status'] == 'success'){
            $chats = $api_response['data']['chats'];
        }
        $viewData['chats'] = $chats;
        $viewData['subdomain'] = $subdomain;
        $view = View::make(roleFolder().'.cases.document-chats',$viewData);
        $contents = $view->render();

        $response['status'] = true;
        $response['html'] = $contents;
        return response()->json($response);
    }

    public function saveDocumentChat(Request $request){
        $subdomain = $request->input("subdomain");
        $data['document_id'] = $request->input("document_id");
        $api_data = professionalCurl('cases/case-document-detail',$subdomain,$data);
        $result = $api_data['data'];
        $document = $result['record'];
        $folder_id = $document['folder_id'];

        $data = array();
        $data['case_id'] = $request->input("case_id");
        $data['document_id'] = $request->input("document_id");
        $data['message'] = $request->input("message");
        $data['created_by'] = \Auth::user()->unique_id;
       
        
        $data['type'] = $request->input("type");
        $api_response = professionalCurl('cases/save-document-chat',$subdomain,$data);
        if($api_response['status'] == 'success'){
            $not_data['send_by'] = 'client';
            $not_data['added_by'] = \Auth::user()->unique_id;
            $not_data['type'] = "chat";
            $not_data['notification_type'] = "document_chat";
            $not_data['title'] = "Message on document by Client ".\Auth::user()->first_name." ".\Auth::user()->last_name;
            $not_data['comment'] = $request->input("message");
            if($request->input("doc_type") == 'extra'){
                $not_data['url'] = "cases/case-documents/extra/".$request->input("case_id")."/".$folder_id;
            }
            if($request->input("doc_type") == 'other'){
                $not_data['url'] = "cases/case-documents/other/".$request->input("case_id")."/".$folder_id;
            }
            if($request->input("doc_type") == 'default'){
                $not_data['url'] = "cases/case-documents/default/".$request->input("case_id")."/".$folder_id;
            }
            
            $other_data[] = array("key"=>"case_id","value"=>$request->input("case_id"));
            $other_data[] = array("key"=>"doc_type","value"=>$request->input("doc_type"));
            $other_data[] = array("key"=>"document_id","value"=>$request->input("document_id"));
            
            $not_data['other_data'] = $other_data;
            
            sendNotification($not_data,"professional",$subdomain);
            
            $response['status'] = true;
            $response['message'] = $api_response['message'];
        }else{
            $response['status'] = false;
            $response['message'] = "Message send failed";
        }
        return response()->json($response);
    }

    public function saveDocumentChatFile(Request $request){

        if ($file = $request->file('attachment')){
            $subdomain = $request->input("subdomain");
            $data['document_id'] = $request->input("document_id");
            $api_data = professionalCurl('cases/case-document-detail',$subdomain,$data);
            $result = $api_data['data'];
            $document = $result['record'];
            $folder_id = $document['folder_id'];

            $data = array();
            $data['case_id'] = $request->input("case_id");
            $data['document_id'] = $request->input("document_id");
            
            $fileName  = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $newName = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            $destinationPath = professionalDir($subdomain)."/documents";
            
            
            if($file->move($destinationPath, $newName)){
                $data['message'] = $fileName;
                $data['created_by'] = \Auth::user()->unique_id;
                $data['original_name'] = $fileName;
                $data['file_name'] = $newName;
                
                $data['type'] = 'file';
                $api_response = professionalCurl('cases/save-document-chat',$subdomain,$data);
                if($api_response['status'] == 'success'){

                    $not_data['send_by'] = 'client';
                    $not_data['added_by'] = \Auth::user()->unique_id;
                    $not_data['type'] = "chat";
                    $not_data['notification_type'] = "document_chat";
                    $not_data['title'] = "Message on document by Client ".\Auth::user()->first_name." ".\Auth::user()->last_name;
                    $not_data['comment'] = "Document sent by client";
                    if($request->input("doc_type") == 'extra'){
                        $not_data['url'] = "cases/case-documents/extra/".$request->input("case_id")."/".$folder_id;
                    }
                    if($request->input("doc_type") == 'other'){
                        $not_data['url'] = "cases/case-documents/other/".$request->input("case_id")."/".$folder_id;
                    }
                    if($request->input("doc_type") == 'default'){
                        $not_data['url'] = "cases/case-documents/default/".$request->input("case_id")."/".$folder_id;
                    }
                    
                    $other_data[] = array("key"=>"case_id","value"=>$request->input("case_id"));
                    $other_data[] = array("key"=>"doc_type","value"=>$request->input("doc_type"));
                    $other_data[] = array("key"=>"document_id","value"=>$request->input("document_id"));
                    
                    $not_data['other_data'] = $other_data;
                    
                    sendNotification($not_data,"professional",$subdomain);
                    
                    $response['status'] = true;
                    $response['message'] = $api_response['message'];
                }else{
                    $response['status'] = false;
                    $response['message'] = "File send failed, try again!";
                }                   
            }else{
                $response['status'] = true;
                $response['message'] = "File send failed, try again!";
            }
        }else{
            $response['status'] = false;
            $response['message'] = "File not selected!";
        }
        
        return response()->json($response);
    }

    public function chats($subdomain,$case_id,Request $request){
        $data['case_id'] = $case_id;
        $api_response = professionalCurl('cases/view',$subdomain,$data);
        $case = $api_response['data'];

        if($request->get("type")){
            $chat_type = $request->get("type");
            $sub_title = $case['case_title'];
        }else{
            $chat_type = 'general';
            $sub_title = "General Chats";
        }
        $viewData['chat_type'] = $chat_type;
        $viewData['sub_title'] = $sub_title;
        $data['case_id'] = $case_id;
        $api_response = professionalCurl('cases/fetch-case-documents',$subdomain,$data);
        if(isset($api_response['data'])){
            $documents = $api_response['data'];
        }else{
            $documents = array();
        }

        if(!isset($api_response['status'])){
            return redirect()->back()->with("success","Some issue while fetching data try again");
        }else{
            if($api_response['status'] != 'success'){
                return redirect()->back()->with("success",$api_response['message']);
            }
        }
        
        $viewData['documents'] = $documents;
        $viewData['case'] = $case;
        $viewData['pageTitle'] = "Chats";
        $viewData['case_id'] = $case_id;
        $viewData['subdomain'] = $subdomain;
        return view(roleFolder().'.cases.chats',$viewData);
    }

    public function fetchChats(Request $request){
        $case_id = $request->input("case_id");
        $chat_type = $request->input("chat_type");
        $subdomain = $request->input("subdomain");
        $viewData['case_id'] = $case_id;
        $viewData['chat_type'] = $chat_type;

        $data = array();
        if($request->input("chat_type") == 'case_chat'){
            $data['case_id'] = $case_id;
        }
        $data['client_id'] = \Auth::user()->unique_id;
        $data['chat_type'] = $chat_type;
        $data['subdomain'] = $subdomain;
        $api_response = professionalCurl('cases/fetch-chats',$subdomain,$data);
        $chats = array();
        if($api_response['status'] == 'success'){
            $chats = $api_response['data']['chats'];
        }
        $viewData['chats'] = $chats;
        $viewData['subdomain'] = $subdomain;
        $view = View::make(roleFolder().'.cases.chat-list',$viewData);
        $contents = $view->render();

        $response['status'] = true;
        $response['html'] = $contents;
        return response()->json($response);
    }

    public function saveChat(Request $request){
        $data['case_id'] = $request->input("case_id");
        $data['chat_type'] = $request->input("chat_type");
        $data['message'] = $request->input("message");
        $data['type'] = "text";
        $data['client_id'] = \Auth::user()->unique_id;
        $subdomain = $request->input("subdomain");


        $api_response = professionalCurl('cases/save-chat',$subdomain,$data);
        if($api_response['status'] == 'success'){
            $not_data['send_by'] = 'client';
            $not_data['added_by'] = \Auth::user()->unique_id;
            $not_data['type'] = "chat";
            $not_data['notification_type'] = "case_chat";
            $not_data['title'] = "Message by Client ".\Auth::user()->first_name." ".\Auth::user()->last_name;
            $not_data['comment'] = $request->input("message");
            if($request->input("chat_type") == 'general'){
                $not_data['notification_type'] = "general";
                $not_data['url'] = "cases/chats/".$request->input("case_id");
            }else{
                $not_data['notification_type'] = "case_chat";
                $not_data['url'] = "cases/chats/".$request->input("case_id")."?chat_type=case_chat";
            }
            
            $other_data[] = array("key"=>"chat_type","value"=>$request->input("chat_type"));
            if($request->input("chat_type") == 'case_chat'){
                $other_data[] = array("key"=>"case_id","value"=>$request->input("case_id"));
            }
            $not_data['other_data'] = $other_data;
            
            sendNotification($not_data,"professional",$subdomain);
            
            $response['status'] = true;
            $response['message'] = $api_response['message'];
        }else{
            $response['status'] = false;
            $response['message'] = "Message send failed";
        }
        return response()->json($response);
    }

    public function saveChatFile(Request $request){

        if ($file = $request->file('attachment')){
            $data['case_id'] = $request->input("case_id");
            $subdomain = $request->input("subdomain");
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $newName        = mt_rand(1,99999)."-".$fileName;
            $source_url = $file->getPathName();
            $destinationPath = professionalDir($subdomain)."/documents";
            
            
            if($file->move($destinationPath, $newName)){
                $data['message'] = $fileName;
                $data['client_id'] = \Auth::user()->unique_id;
                $data['original_name'] = $fileName;
                $data['file_name'] = $newName;
                $data['chat_type'] = $request->input("chat_type");
                $data['type'] = 'file';
                $api_response = professionalCurl('cases/save-chat',$subdomain,$data);
                if($api_response['status'] == 'success'){
                    $not_data['send_by'] = 'client';
                    $not_data['added_by'] = \Auth::user()->unique_id;
                    $not_data['type'] = "chat";
                    $not_data['notification_type'] = "case_chat";
                    $not_data['title'] = "Message by Client ".\Auth::user()->first_name." ".\Auth::user()->last_name;
                    $not_data['comment'] = "Document sent in chat";
                    if($request->input("chat_type") == 'general'){
                        $not_data['url'] = "cases/chats/".$request->input("case_id");
                    }else{
                        $not_data['url'] = "cases/chats/".$request->input("case_id")."?chat_type=case_chat";
                    }
                    $other_data[] = array("key"=>"chat_type","value"=>$request->input("chat_type"));
                    if($request->input("chat_type") == 'case_chat'){
                        $other_data[] = array("key"=>"case_id","value"=>$request->input("case_id"));
                    }
                    $not_data['other_data'] = $other_data;                   
                    sendNotification($not_data,"professional",$subdomain);
                    
                    $response['status'] = true;
                    $response['message'] = $api_response['message'];
                }else{
                    $response['status'] = false;
                    $response['message'] = "File send failed, try again!";
                }                   
            }else{
                $response['status'] = false;
                $response['message'] = "File send failed, try again!";
            }
        }else{
            $response['status'] = false;
            $response['message'] = "File not selected!";
        }
        
        return response()->json($response);
    }

    public function chatdemo(){
        $viewData['pageTitle'] = "Chats";
        return view(roleFolder().'.cases.chat-demo',$viewData);
    }

    public function caseInvoices($subdomain,$case_id)
    {   $data['case_id'] = $case_id;
        $api_response = professionalCurl('cases/view',$subdomain,$data);
        $case = $api_response['data'];
        $viewData['case'] = $case;
        $viewData['pageTitle'] = "Case Invoices";
        $viewData['subdomain'] = $subdomain;
        return view(roleFolder().'.cases.invoices',$viewData);
    } 

    public function getCaseInvoice($subdomain,Request $request)
    {
        $data = $request->input();
        $api_response = professionalCurl('cases/fetch-case-invoices',$subdomain,$data);

        if($api_response['status'] != 'success'){
            $response['status'] = "error";
            $response['message'] = "Issue while finding invoice";
            return response()->json($response);
        }
        $data = $api_response['data'];
        $viewData['records'] = $data['records'];
        $viewData['subdomain'] = $subdomain;
        $view = View::make(roleFolder().'.cases.invoices-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $data['last_page'];
        $response['current_page'] = $data['current_page'];
        $response['total_records'] = $data['total_records'];
        return response()->json($response);
    }

    public function viewCaseInvoice($subdomain,$invoice_id){

        $data['invoice_id'] = $invoice_id;
        $api_response = professionalCurl('cases/view-case-invoice',$subdomain,$data);

        if($api_response['status'] != 'success'){
            $response['status'] = "error";
            return redirect()->back()->with("error","Issue while finding invoice");
        }
        $data = $api_response['data'];
        $id = base64_decode($invoice_id);
        $invoice = $data['invoice'];
        $case = $data['case'];
        $client = $data['client'];
        if($client['unique_id'] != \Auth::user()->unique_id){
            return redirect(baseUrl('/'));
        }
        $professional = $data['professional'];
        $viewData['professional'] = $professional;
        $viewData['case'] = $case;
        $viewData['client'] = $client;
        $viewData['record'] = $invoice;
        $viewData['subdomain'] = $subdomain;
        $viewData['pageTitle'] = "View Invoice";
        return view(roleFolder().'.cases.view-invoice',$viewData);
    }

    public function payNow(Request $request){
        $viewData['pageTitle'] = "Pay Now";
        return view(roleFolder().'.pay-now',$viewData);   
    }

    public function professionalProfile($subdomain){
        $data['subdomain'] = $subdomain;
        $api_data = professionalCurl('information',$subdomain,$data);
        if(isset($api_data['status']) && $api_data['status'] == 'success'){
            $data = $api_data['data'];
            $company = $data['company'];
            $admin = $data['admin'];
            $services = $data['services'];
        }else{
            return redirect()->back()->with("error","Professional profile not found");
        }
        //print_r($company);
        //print_r($admin);
        //exit;
        $viewData['services'] = $services;
        $viewData['company'] = $company;
        $viewData['admin'] = $admin;
        return view(roleFolder().'.cases.professional-profile',$viewData);
    }
}
