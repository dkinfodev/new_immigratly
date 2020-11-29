<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

use App\Models\User;
use App\Models\UserDetails;
use App\Models\Countries;
use App\Models\Languages;
use App\Models\UserWithProfessional;
use App\Models\UserFolders;
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
        
        $case = professionalCurl('cases/default-documents',$subdomain,$data);
        
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
        $data['doc_type'] = "default";

        $record = array();
        $document = array();
        $case_documents = array();
        
        $case = professionalCurl('cases/extra-documents',$subdomain,$data);
        
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
        $case = professionalCurl('cases/documents-exchanger',$subdomain,$data);
        $result = $case['data'];
        
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
        $case = professionalCurl('cases/documents-exchanger',$subdomain,$data);
        $result = $case['data'];
        
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
        $user_files = UserFiles::whereIn("unique_id",$files)->get();
        pre($user_files);
        exit;
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
}
