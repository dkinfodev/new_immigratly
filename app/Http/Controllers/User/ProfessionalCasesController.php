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
}
