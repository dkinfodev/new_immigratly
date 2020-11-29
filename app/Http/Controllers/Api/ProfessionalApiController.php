<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

use App\Models\User;
use App\Models\DomainDetails;
use App\Models\Cases;
use App\Models\ProfessionalServices;
use App\Models\ServiceDocuments;
use App\Models\CaseTeams;
use App\Models\CaseDocuments;
use App\Models\DocumentFolder;
use App\Models\CaseFolders;
use App\Models\Documents;

class ProfessionalApiController extends Controller
{
    var $subdomain;
    public function __construct(Request $request)
    {
    	$headers = $request->header();
        $this->subdomain = $headers['subdomain'][0];
        $this->middleware('professional_curl');
        \Config::set('database.connections.mysql.database',PROFESSIONAL_DATABASE.$this->subdomain);
    }
    public function clientCases(Request $request)
    {
    	try{
    		$postData = $request->input();
            $request->request->add($postData);

	       	$cases = Cases::with(['AssingedMember','VisaService'])->where("client_id",$request->input("client_id"))->get();
	       	$data = array();
	       	foreach($cases as $key => $record){
	       		$temp = $record;
	       		$temp->MainService = $record->Service($record->VisaService->service_id);
	       		$data[] = $temp;
	       	}

	        $response['data'] = $data;
	        $response['status'] = 'success';
       	} catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function caseDetail(Request $request)
    {
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $record = Cases::with(['AssingedMember','VisaService'])->where("unique_id",$request->input("case_id"))->first();
            
            $temp = $record;
            $temp->MainService = $record->Service($record->VisaService->service_id);
            $data = $temp;
            

            $response['data'] = $data;
            $response['status'] = 'success';
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function caseDocuments(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $id = $request->input("case_id");
            $record = Cases::where("unique_id",$id)->first();
            $service = ProfessionalServices::where("id",$record->visa_service_id)->first();
            $documents = ServiceDocuments::where("service_id",$record->visa_service_id)->get();
            $case_folders = CaseFolders::where("case_id",$record->id)->get();
            $service->MainService = $service->Service($service->service_id);
            $default_documents = $service->DefaultDocuments($service->service_id);
            foreach($default_documents as $document){
                $document->files_count = $record->caseDocuments($record->unique_id,$document->unique_id,'count');
            }
            foreach($documents as $document){
                $document->files_count = $record->caseDocuments($record->unique_id,$document->unique_id,'count');
            }
            foreach($case_folders as $document){
                $document->files_count = $record->caseDocuments($record->unique_id,$document->unique_id,'count');
            }
            $service->Documents = $default_documents;
            $data['service'] = $service;
            $data['documents'] = $documents;
            $data['case_folders'] = $case_folders;
            $data['record'] = $record;

            $response['data'] = $data;
            $response['status'] = "success";
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function defaultDocuments(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $case_id = $request->input("case_id");
            $doc_id = $request->input("doc_id");
            $record = Cases::where("unique_id",$case_id)->first();
            $document = DB::table(MAIN_DATABASE.".documents_folder")->where("unique_id",$doc_id)->first();
            $folder_id = $document->unique_id;
            $service = ProfessionalServices::where("id",$record->visa_service_id)->first();
            $service->MainService = $service->Service($service->service_id);
            $case_documents = CaseDocuments::with('FileDetail')->where("case_id",$case_id)
                                            ->where("folder_id",$folder_id)
                                            ->get();
            $data['service'] = $service;
            $data['case_documents'] = $case_documents;
            $data['document'] = $document;
            $data['record'] = $record;
            $data['doc_type'] = "default";
            $file_url = professionalDirUrl($this->subdomain)."/documents";
            $file_dir = professionalDir($this->subdomain)."/documents";
            $data['file_url'] = $file_url;
            $data['file_dir'] = $file_dir;

            $response['status'] = "success";
            $response['data'] = $data;
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    public function otherDocuments(Request $request){
        try{

            $postData = $request->input();
            $request->request->add($postData);

            $case_id = $request->input("case_id");
            $doc_id = $request->input("doc_id");
            $record = Cases::where("unique_id",$case_id)->first();

            $document = ServiceDocuments::where("unique_id",$doc_id)->first();
            $folder_id = $document->unique_id;
            $service = ProfessionalServices::where("id",$record->visa_service_id)->first();
            $service->MainService = $service->Service($service->service_id);
            $case_documents = CaseDocuments::with('FileDetail')->where("case_id",$case_id)
                                            ->where("folder_id",$folder_id)
                                            ->get();
            $data['service'] = $service;
            $data['case_documents'] = $case_documents;
            $data['document'] = $document;
            $data['record'] = $record;
            $data['doc_type'] = "other";
            $file_url = professionalDirUrl($this->subdomain)."/documents";
            $file_dir = professionalDir($this->subdomain)."/documents";
            $data['file_url'] = $file_url;
            $data['file_dir'] = $file_dir;

            $response['status'] = "success";
            $response['data'] = $data;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    public function extraDocuments(Request $request){
        try{

            $postData = $request->input();
            $request->request->add($postData);

            $case_id = $request->input("case_id");
            $doc_id = $request->input("doc_id");
            $record = Cases::where("unique_id",$case_id)->first();

            $document = CaseFolders::where("id",$doc_id)->first();
            $folder_id = $document->unique_id;
            $service = ProfessionalServices::where("id",$record->visa_service_id)->first();
            $service->MainService = $service->Service($service->service_id);
            $case_documents = CaseDocuments::with('FileDetail')->where("case_id",$case_id)
                                            ->where("folder_id",$folder_id)
                                            ->get();
            $data['service'] = $service;
            $data['case_documents'] = $case_documents;
            $data['document'] = $document;
            $data['record'] = $record;
            $data['pageTitle'] = "Files List for ".$document->name;
            $data['doc_type'] = "extra";
            $file_url = professionalDirUrl($this->subdomain)."/documents";
            $file_dir = professionalDir($this->subdomain)."/documents";
            $data['file_url'] = $file_url;
            $data['file_dir'] = $file_dir;

            $response['status'] = "success";
            $response['data'] = $data;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function uploadDocuments(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $case_id = $request->input("case_id");
            $folder_id = $request->input("folder_id");
            $record = Cases::where("unique_id",$case_id)->first();
            $document_type = $request->input("document_type");
            $original_name  = $request->input("original_name");
            $newName = $request->input("newName");

            $unique_id = randomNumber();
            $object = new Documents();
            $object->file_name = $newName;
            $object->original_name = $original_name;
            $object->unique_id = $unique_id;
            $object->created_by = $request->input("created_by");
            $object->save();

            $object2 = new CaseDocuments();
            $object2->case_id = $record->unique_id;
            $object2->unique_id = randomNumber();
            $object2->folder_id = $folder_id;
            $object2->file_id = $unique_id;
            $object2->created_by = $request->input("created_by");
            $object2->document_type = $document_type;
            $object2->save();

            $response['status'] = "success";
            $response['message'] = "File uploaded!";

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    
    public function saveDocumentsExchanger(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $case_id = $request->input("case_id");
            $record = Cases::where("unique_id",$case_id)->first();
            $service = ProfessionalServices::where("id",$record->visa_service_id)->first();
            $default_documents = $service->DefaultDocuments($service->service_id);

            foreach($default_documents as $document){
                $document->files = $record->caseDocuments($record->unique_id,$document->unique_id);
            }
            

            $service->Documents = $default_documents;
            $service->MainService = $service->Service($service->service_id);
            $documents = ServiceDocuments::where("service_id",$record->visa_service_id)->get();
            $case_folders = CaseFolders::where("case_id",$record->unique_id)->get();
            foreach($documents as $document){
                $document->files = $record->caseDocuments($record->unique_id,$document->unique_id);
            }
            foreach($case_folders as $document){
                $document->files = $record->caseDocuments($record->unique_id,$document->unique_id);
            }
            $file_url = professionalDirUrl($this->subdomain)."/documents";
            $file_dir = professionalDir($this->subdomain)."/documents";
            $data['file_url'] = $file_url;
            $data['file_dir'] = $file_dir;
            $data['service'] = $service;
            $data['documents'] = $documents;
            $data['case_folders'] = $case_folders;
            $data['record'] = $record;
            
            $response['status'] = "success";
            $response['data'] = $data;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function saveExchangeDocuments(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $doc_type = $request->input("document_type");
            $folder_id = $request->input("folder_id");
            $case_id = $request->input("case_id");
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
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response); 
    }
}
