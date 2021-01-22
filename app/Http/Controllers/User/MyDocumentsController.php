<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use View;

use App\Models\User;
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
}
