<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use View;

use App\Models\User;
use App\Models\UserDetails;
use App\Models\FilesManager;
use App\Models\UserFolders;
use App\Models\UserFiles;

class MyDocumentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }
    public function myFolders()
    {
       	$viewData['pageTitle'] = "My Documents";
        $user_folders = UserFolders::where("user_id",\Auth::user()->unique_id)->get();
        $viewData['user_folders'] = $user_folders;
        return view(roleFolder().'.documents.folders',$viewData);
    }
    public function addFolder(Request $request){
        $viewData['pageTitle'] = "Add Folder";
        $view = View::make(roleFolder().'.documents.modal.add-folder',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);        
    }

    public function createFolder(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
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
        $object = new UserFolders();
        $object->user_id = \Auth::user()->unique_id;
        $object->name = $request->input("name");
        $object->slug = str_slug($request->input("name"));
        $object->unique_id = randomNumber();
        $object->save();
        
        $response['status'] = true;
        $response['message'] = "Folder added successfully";
        
        return response()->json($response);
    }

    public function editFolder($id,Request $request){
        $id = base64_decode($id);
        $record = UserFolders::find($id);
        $viewData['pageTitle'] = "Edit Folder";
        $viewData['record'] = $record;
        $view = View::make(roleFolder().'.documents.modal.edit-folder',$viewData);
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
        $object = UserFolders::find($id);
        $object->name = $request->input("name");
        $object->slug = str_slug($request->input("name"));
        $object->save();
        
        $response['status'] = true;
        $response['message'] = "Folder edited successfully";
        
        return response()->json($response);
    }

    public function deleteFolder($id){
        $id = base64_decode($id);
        UserFolders::deleteRecord($id);
        return redirect()->back()->with("success","Folder has been deleted!");
    }

    public function folderFiles($id){

        $user_id = \Auth::user()->unique_id;
        $document = UserFolders::where("unique_id",$id)->first();
        $user_documents = UserFiles::with('FileDetail')
                                    ->where("folder_id",$id)
                                    ->where("user_id",$user_id)
                                    ->orderBy("id","desc")
                                    ->get();
        $user_detail = UserDetails::where("user_id",$user_id)->first();
        $viewData['user_detail'] = $user_detail;
        $viewData['user_documents'] = $user_documents;
        $viewData['pageTitle'] = "Files List for ".$document->name;
 
        $file_url = userDirUrl()."/documents";
        $file_dir = userDir()."/documents";
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        $viewData['document'] = $document;
        return view(roleFolder().'.documents.files',$viewData);
    }

    public function uploadDocuments(Request $request){
        try{
            $id = \Auth::user()->unique_id;
            $folder_id = $request->input("folder_id");
            $failed_files = array();
            if($file = $request->file('file'))
            {
                $fileName        = $file->getClientOriginalName();
                $extension       = $file->getClientOriginalExtension();
                $allowed_extension = allowed_extension();
                if(in_array($extension,$allowed_extension)){
                    $newName        = randomNumber(5)."-".$fileName;
                    $source_url = $file->getPathName();
                    $destinationPath = userDir()."/documents";
                    if($file->move($destinationPath, $newName)){
                        $unique_id = randomNumber();
                        $object = new FilesManager();
                        $object->file_name = $newName;
                        $object->original_name = $fileName;
                        $object->user_id = $id;
                        $object->unique_id = $unique_id;
                        $object->created_by = \Auth::user()->unique_id;
                        $object->save();

                        $object2 = new UserFiles();
                        $object2->user_id = $id;
                        $object2->folder_id = $folder_id;
                        $object2->file_id = $unique_id;
                        $object2->unique_id = randomNumber();
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
            }else{
                $response['status'] = false;
                $response['message'] = 'Please select the file';
            }
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function fileMoveTo($id){
        $user_id = \Auth::user()->unique_id;
        $user_folders = UserFolders::where("user_id",$user_id)->get();
        $record = UserFiles::where("unique_id",$id)->first();
        $viewData['user_folders'] = $user_folders;

        $viewData['id'] = $id;
        $viewData['pageTitle'] = "Move File";
        $viewData['record'] = $record;
        $view = View::make(roleFolder().'.documents.modal.move-to',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);        
    }

    public function moveFileToFolder(Request $request){
        $id = $request->input("id");
        $folder_id = $request->input("folder_id");
        $data['folder_id'] = $folder_id;
        UserFiles::where("unique_id",$id)->update($data);

        $response['status'] = true;
        $response['message'] = "File moved to folder successfully";
        \Session::flash('success', 'File moved to folder successfully'); 
        return response()->json($response);       
    }

    public function documentsExchanger(){
        $user_id = \Auth::user()->unique_id;
        $user_folders = UserFolders::where("user_id",$user_id)->get();
        
        $file_url = userDirUrl()."/documents";
        $file_dir = userDir()."/documents";
        $viewData['file_url'] = $file_url;
        $viewData['file_dir'] = $file_dir;
        $viewData['user_folders'] = $user_folders;
        $viewData['pageTitle'] = "Documents Exchanger";

        return view(roleFolder().'.documents.documents-exchanger',$viewData);
    }

    public function saveExchangeDocuments(Request $request){
        $folder_id = $request->input("folder_id");
        $user_id = \Auth::user()->unique_id;
        $files = $request->input("files");
        $existing_files = UserFiles::where("user_id",$user_id)
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
            UserFiles::where("file_id",$new_files[$i])->update($data);
        }

        $response['status'] = true;
        $response['message'] = "File transfered successfully";
        return response()->json($response); 
    }

    public function viewDocument($file_id,Request $request){
        $url = $request->get("url");
        $filename = $request->get("file_name");
        $folder_id = $request->get("folder_id");
        $ext = fileExtension($filename);
        $subdomain = $request->get("p");

        $viewData['url'] = $url;
        $viewData['extension'] = $ext;
        $viewData['document_id'] = $file_id;
        $viewData['folder_id'] = $folder_id;
        $viewData['pageTitle'] = "View Documents";
        return view(roleFolder().'.documents.view-documents',$viewData);
    }
    public function deleteDocument($id){
        $id = base64_decode($id);
        UserFiles::deleteRecord($id);
        return redirect()->back()->with("success","Document has been deleted!");
    }
    public function deleteMultipleDocuments(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            UserFiles::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Documents deleted successfully'); 
        return response()->json($response);
    }
    public function fetchGoogleDrive($folder_id,Request $request){

        $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
        $google_drive_auth = json_decode($user_detail->google_drive_auth,true);
        
        $drive = create_crm_gservice($google_drive_auth['access_token']);
        $drive_folders = get_gdrive_folder($drive);
        if(isset($drive_folders['gdrive_files'])){
            $drive_folders = $drive_folders['gdrive_files'];
        }else{
            $drive_folders = array();
        }
        $viewData['pageTitle'] = "Google Drive Folders";
        $viewData['drive_folders'] = $drive_folders;
        $viewData['folder_id'] = $folder_id;
        $view = View::make(roleFolder().'.documents.modal.google-drive',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);  
    }

    public function googleDriveFilesList(Request $request){
        $folder_id = $request->input("folder_id");
        $folder = $request->input("folder_name");
        $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
        $google_drive_auth = json_decode($user_detail->google_drive_auth,true);
       
        $drive = create_crm_gservice($google_drive_auth['access_token']);
        $drive_folders = get_gdrive_folder($drive,$folder_id,$folder);
        if(isset($drive_folders['gdrive_files'])){
            $drive_folders = $drive_folders['gdrive_files'];
        }else{
            $drive_folders = array();
        }
        $viewData['drive_folders'] = $drive_folders;
        $view = View::make(roleFolder().'.documents.modal.google-files',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);   
    }

    public function uploadFromGdrive(Request $request){
        
        if($request->input("files")){
            $files = $request->input("files");
            $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
            $google_drive_auth = json_decode($user_detail->google_drive_auth,true);
            $access_token = $google_drive_auth['access_token'];
            $folder_id = $request->input("folder_id");
            foreach($files as $key => $fileId){
                $i = $key;
                $ch = curl_init();
                $method = "GET";
                // get file type
                $endpoint = 'https://www.googleapis.com/drive/v3/files/'.$fileId;
                curl_setopt($ch, CURLOPT_URL,$endpoint);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST,$method);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer ".$access_token['access_token']));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $curl_response = curl_exec($ch);
                $err = curl_error($ch);
                curl_close($ch);
                $file = json_decode($curl_response,true);
                // get file base64 format
                $ch = curl_init();
                $endpoint = 'https://www.googleapis.com/drive/v3/files/'.$fileId.'?alt=media';
                curl_setopt($ch, CURLOPT_URL,$endpoint);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST,$method);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer ".$access_token['access_token']));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $api_response = curl_exec($ch);
                $err = curl_error($ch);
                curl_close($ch);
                $base64_code = $api_response;
                $original_name = $file['name'];
                
                $newName = time()."-".$original_name;
                if (!file_exists(userDir())) {
                    mkdir(userDir(), 0777, true);
                }
                $path = userDir()."/documents";
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $destinationPath = $path.'/thumb';
                
                if(file_put_contents($path."/".$newName, $base64_code)){
                    $unique_id = randomNumber();
                    $object = new FilesManager();
                    $object->file_name = $newName;
                    $object->original_name = $original_name;
                    $object->user_id = \Auth::user()->unique_id;
                    $object->unique_id = $unique_id;
                    $object->created_by = \Auth::user()->unique_id;
                    $object->save();

                    $object2 = new UserFiles();
                    $object2->user_id = \Auth::user()->unique_id;
                    $object2->folder_id = $folder_id;
                    $object2->file_id = $unique_id;
                    $object2->unique_id = randomNumber();
                    $object2->save();
                }
            }
            $response['status'] = true;
            $response['message'] = 'File uploaded from google drive successfully!';
        }else{
            $response['status'] = false;
            $response['error_type'] = 'no_files';
            $response['message'] = "No Files selected";
        }
        return response()->json($response);
    }

    public function fetchDropboxFolder($folder_id,Request $request){

        $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
        $dropbox_auth = json_decode($user_detail->dropbox_auth,true);
        $drive_folders = dropbox_files_list($dropbox_auth);
        
        if(isset($drive_folders['dropbox_files'])){
            $drive_folders = $drive_folders['dropbox_files'];
        }else{
            $drive_folders = array();
        }
        $viewData['pageTitle'] = "Dropbox Folders";
        $viewData['drive_folders'] = $drive_folders;
        $viewData['folder_id'] = $folder_id;
        $view = View::make(roleFolder().'.documents.modal.dropbox-folder',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);  
    }

    public function dropboxFilesList(Request $request){
        $folder_id = $request->input("folder_id");
        $folder = $request->input("folder_name");
        $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
        $dropbox_auth = json_decode($user_detail->dropbox_auth,true);
        $drive_folders = dropbox_files_list($dropbox_auth,$folder_id);
        
        if(isset($drive_folders['dropbox_files'])){
            $drive_folders = $drive_folders['dropbox_files'];
        }else{
            $drive_folders = array();
        }
        // pre($drive_folders);
        $viewData['drive_folders'] = $drive_folders;
        $view = View::make(roleFolder().'.documents.modal.dropbox-files',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);   
    }

    public function uploadFromDropbox(Request $request){
        
        if($request->input("files")){
            $files = $request->input("files");
            $user_detail = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
            $dropbox_auth = json_decode($user_detail->dropbox_auth,true);
            $folder_id = $request->input("folder_id");
            foreach($files as $key => $fileId){
                $i = $key;
                $fileinfo = explode(":::",$fileId);
                $original_name = $fileinfo[1];
                $file_path = $fileinfo[0];
                $newName = time()."-".$original_name;
                $path = userDir()."/documents";
                $destinationPath = $path."/".$newName;
                
                $is_download = dropbox_file_download($dropbox_auth,$file_path,$destinationPath);

                if(file_exists($destinationPath)){
                    $unique_id = randomNumber();
                    $object = new FilesManager();
                    $object->file_name = $newName;
                    $object->original_name = $original_name;
                    $object->user_id = \Auth::user()->unique_id;
                    $object->unique_id = $unique_id;
                    $object->created_by = \Auth::user()->unique_id;
                    $object->save();

                    $object2 = new UserFiles();
                    $object2->user_id = \Auth::user()->unique_id;
                    $object2->folder_id = $folder_id;
                    $object2->file_id = $unique_id;
                    $object2->unique_id = randomNumber();
                    $object2->save();
                }
            }
            $response['status'] = true;
            $response['message'] = 'File uploaded from google drive successfully!';
        }else{
            $response['status'] = false;
            $response['error_type'] = 'no_files';
            $response['message'] = "No Files selected";
        }
        return response()->json($response);
    }
}

