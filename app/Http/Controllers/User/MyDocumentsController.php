<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use App\Models\User;
use App\Models\UserFolders;
use App\Models\UserDocuments;
use App\Models\FilesManager;

class MyDocumentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function documents(){
        $id = \Auth::user()->id;
        $documents = UserFolders::where('user_id',$id)->get();
        $viewData['documents_folders'] = $documents;
        $viewData['pageTitle'] = "My Documents";
        return view(roleFolder().'.documents.document-folders',$viewData);
    }

    public function addFolder(Request $request){
        // $id = base64_decode($id);
        $viewData['pageTitle'] = "Add Folder";
        $view = View::make(roleFolder().'.modal.add-folder',$viewData);
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
        $object->user_id = \Auth::user()->id;
        $object->name = $request->input("name");
        $object->unique_id = randomNumber(6);
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
        $view = View::make(roleFolder().'.modal.edit-folder',$viewData);
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
    
    public function viewDocuments(){
        $viewData['pageTitle'] = "Documents";
        $viewData['record'] = FilesManager::get();
        /*($file_dir = userDir()."/documents/";
        /$viewData['file_dir'] = $file_dir;*/
        return view(roleFolder().'.documents.document-files',$viewData);
    }  

    public function uploadDocuments(Request $request){
        //$document_type = $request->input("doc_type");
        $failed_files = array();
        if($file = $request->file('file'))
        {
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension();
            $allowed_extension = allowed_extension();
            if(in_array($extension,$allowed_extension)){
                $newName        =  time().".".$extension;
                $source_url = $file->getPathName();
                $destinationPath = userDir()."/documents";
                if($file->move($destinationPath, $newName)){
                    $object = new FilesManager();
                    //$object->folder_id = $folder_id;
                    $unique_id = randomNumber(10);
                    $object->file_name = $newName;
                    $object->unique_id = $unique_id;
                    $object->original_name = $fileName;
                    $object->user_id = \Auth::user()->unique_id;
                    $object->save();

                    //$object->id;                    
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
}
