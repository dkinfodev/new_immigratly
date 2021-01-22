<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UserWithProfessional;
use App\Models\DomainDetails;
use App\Models\ProfessionalPrivileges;
use App\Models\PrivilegesActions;
use App\Models\Roles;
use App\Models\UserDetails;
use App\Models\Articles;
use App\Models\ArticleTags;
use App\Models\Webinar;
use App\Models\WebinarTags;
use App\Models\WebinarTopics;

class MasterApiController extends Controller
{
	var $subdomain;
    public function __construct(Request $request)
    {
    	$headers = $request->header();
        $this->subdomain = $headers['subdomain'][0];
        $this->middleware('curl_api');
    }
    public function createClient(Request $request)
    {
    	try{
    		$postData = $request->input();
            $request->request->add($postData);
            $password = "demo@123";
            $user = $postData['data'];

            $checkExists = User::where("email",$user['email'])
                                ->where("phone_no",$user['phone_no'])
                                ->first();
            if(!empty($checkExists)){
                $response['status'] = 'error';
                $response['error'] = "email_exists";
                $response['message'] = "Client account with email ".$user['email']." and ".$user['phone_no']." already exists";
                return response()->json($response);
            }

            $checkExists = User::where("email",$user['email'])->first();
            $is_exists = 0;
            if(!empty($checkExists)){
            	$response['status'] = 'error';
            	$response['error'] = "email_exists";
            	$response['message'] = "Client account with email ".$user['email']." already exists";
                $is_exists = 1;
                $unique_id = $checkExists->unique_id;
        		// return response()->json($response);
            }

            $checkExists = User::where("phone_no",$user['phone_no'])->first();
            if(!empty($checkExists)){
            	$response['status'] = 'error';
            	$response['error'] = "phone_exists";
            	$response['message'] = "Phone no already exists";
            	return response()->json($response);
            }
            if($is_exists == 0){
                $unique_id = randomNumber();
    	       	$object = new User();
    	        $object->first_name = $user['first_name'];
    	        $object->last_name = $user['last_name'];
    	        $object->email =  $user['email'];
    	        $object->password = bcrypt($password);
    	        $object->country_code = $user['country_code'];
    	        $object->phone_no = $user['phone_no'];
                
    	        $object->role = "user";
                $object->unique_id = $unique_id;
    	        $object->is_active = 1;
    	        $object->is_verified = 1;
    	        $object->save();

    	        $user_id = $object->id;

                $object = new UserDetails();
                $object->user_id = $unique_id;
                if(isset($user['date_of_birth'])){
                    $object->date_of_birth = $user['date_of_birth'];
                }
                if(isset($user['gender'])){
                    $object->gender = $user['gender'];
                }
                if(isset($user['country_id'])){
                    $object->country_id = $user['country_id'];
                }
                if(isset($user['state_id'])){
                    $object->state_id = $user['state_id'];
                }
                if(isset($user['city_id'])){
                    $object->city_id = $user['city_id'];
                }
                if(isset($user['address'])){
                    $object->address = $user['address'];
                }
                if(isset($user['zip_code'])){
                    $object->zip_code = $user['zip_code'];
                }
                $object->save();
            }

	        $object2 = new UserWithProfessional();
	        $object2->user_id = $unique_id;
	        $object2->professional= $this->subdomain;
	        $object2->status = 1;
	        $object2->save();

	        $response['user_id'] = $unique_id;
	        $response['post_data'] = $postData;
	        $response['message'] = "Client has been created successfully";
	        $response['status'] = 'success';
       	} catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function roles(Request $request){
        try{
            $avoid = array("admin","user");
            $roles = Roles::whereNotIn("slug",$avoid)->get();
            $data = $roles;

            $response['status'] = 'success';
            $response['data'] = $data;


        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function privilegesList(Request $request){
        try{
            $privileges = ProfessionalPrivileges::with("Actions")->get();
            $data = $privileges;

            $response['status'] = 'success';
            $response['data'] = $data;


        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function fetchArticles(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $search = $request->input("search");
            $records = Articles::with(['Category'])
                            ->where("professional",$this->subdomain)
                            ->where(function($query) use($search){
                                if($search != ''){
                                    $query->where("title","LIKE","%$search%");
                                }
                            })
                            ->where("status",$request->input("status"))
                            ->orderBy("id","desc")
                            ->paginate();
            
            foreach($records as $record){
                $record->professional_info = $record->ProfessionalDetail($record->professional);
            }
            $data = $records;

            $response['status'] = 'success';
            $response['data'] = $data;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    public function saveArticle(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            
            $unique_id = randomNumber();
            $check_name_count = Articles::where("title",$request->input('title'))->count();
            $slug = str_slug($request->input("title"));
            if($check_name_count > 0){
                $slug = $slug."-".($check_name_count+1);
            }
            $object = new Articles();
            $object->unique_id = $unique_id;
            $object->title = $request->input("title");
            $object->slug = $slug;
            $object->description = $request->input("description");
            $object->short_description = $request->input("short_description");
            $object->category_id = $request->input("category_id");
            $object->share_with = $request->input("share_with");
            // $object->status = $request->input("status");
            // if($request->input("content_block")){
            //     $object->content_block = $request->input("content_block");
            // }
            $object->professional= $this->subdomain;
            $object->added_by = $request->input("added_by");
            if($request->input("timestamp")){
                $timestamp = $request->input("timestamp");
                $files = glob(public_path()."/uploads/temp/". $timestamp."/*");
                $filename = array();
                for($f = 0; $f < count($files);$f++){
                    $file_arr = explode("/",$files[$f]);
                    $filename[] = end($file_arr);
                    $file_name =  end($file_arr);
                    $destinationPath = public_path("/uploads/articles/".$file_name);
                    copy($files[$f], $destinationPath);
                    unlink($files[$f]);
                }
                if(file_exists(public_path()."/uploads/temp/". $timestamp)){
                    rmdir(public_path()."/uploads/temp/". $timestamp);
                }
                if(!empty($filename)){
                    $object->images = implode(",",$filename);
                }
            }
            $object->save();
            $id  = $object->id;
            if($request->input("tags")){
                $tags = $request->input("tags");
                for($i=0;$i < count($tags);$i++){
                    $object2 = new ArticleTags();
                    $object2->article_id = $id;
                    $object2->tag_id = $tags[$i];
                    $object2->save();
                }
            }
            $response['status'] = 'success';
            $response['message'] = "Article saved successfully";

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function deleteArticle(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $record = Articles::where("professional",$this->subdomain)
                            ->where("unique_id",$request->input("article_id"))
                            ->first();
            Articles::deleteRecord($record->id);
            $response['status'] = 'success';
            $response['message'] = 'Article deleted successfully';

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    public function deleteArticleImage(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $image = $request->input("image");
            $article = Articles::where("unique_id",$request->input("article_id"))->first();
            $images = explode(",",$article->images);
            if(file_exists(public_path('uploads/articles/'.$image))){
                unlink(public_path('uploads/articles/'.$image));
            }
            if (($key = array_search($image, $images)) !== false) {
                unset($images[$key]);
                array_values($images);
            }
            $article->images = implode(",",$images);
            $article->save();

            $response['status'] = 'success';
            $response['message'] = "Article image removed successfully";
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    public function articlesCount(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $publish = Articles::with(['Category','ArticleTags'])
                            ->where("professional",$this->subdomain)
                            ->where("status","publish")
                            ->count();
            
            $draft = Articles::with(['Category','ArticleTags'])
                            ->where("professional",$this->subdomain)
                            ->where("status","draft")
                            ->count();
            $data['publish'] = $publish;
            $data['draft'] = $draft;

            $response['status'] = 'success';
            $response['data'] = $data;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    public function fetchArticle(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $record = Articles::with(['Category','ArticleTags'])
                            ->where("professional",$this->subdomain)
                            ->where("unique_id",$request->input("article_id"))
                            ->first();
          
            $data = $record;

            $response['status'] = 'success';
            $response['data'] = $data;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function updateArticle(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $article_id = $request->input("article_id");
            $object = Articles::where('unique_id',$article_id)
                                ->where("professional",$this->subdomain)
                                ->first();
            $images = $object->images;
            $check_name_count = Articles::where("title",$request->input('title'))
                                        ->where("unique_id","!=",$article_id)
                                        ->count();
            $slug = str_slug($request->input("title"));
            if($check_name_count > 0){
                $slug = $slug."-".($check_name_count+1);
            }
            $object->title = $request->input("title");
            $object->slug = $slug;
            $object->description = $request->input("description");
            $object->short_description = $request->input("short_description");
            $object->category_id = $request->input("category_id");
            $object->share_with = $request->input("share_with");
            // if($request->input("content_block")){
            //     $object->content_block = $request->input("content_block");
            // }
            $object->professional= $this->subdomain;
            $object->added_by = $request->input("added_by");
            if($request->input("timestamp")){
                $timestamp = $request->input("timestamp");
                $files = glob(public_path()."/uploads/temp/". $timestamp."/*");
                $filename = array();
                for($f = 0; $f < count($files);$f++){
                    $file_arr = explode("/",$files[$f]);
                    $filename[] = end($file_arr);
                    $file_name =  end($file_arr);
                    $destinationPath = public_path("/uploads/articles/".$file_name);
                    copy($files[$f], $destinationPath);
                    unlink($files[$f]);
                }
                if(file_exists(public_path()."/uploads/temp/". $timestamp)){
                    rmdir(public_path()."/uploads/temp/". $timestamp);
                }
                if(!empty($filename)){
                    if($images != ''){
                        $images .=",".implode(",",$filename);
                    }
                    $object->images = $images;
                }
            }
            $object->save();
            $id  = $object->id;
            if($request->input("tags")){
                ArticleTags::where("article_id",$id)->delete();
                $tags = $request->input("tags");
                for($i=0;$i < count($tags);$i++){
                    $object2 = new ArticleTags();
                    $object2->article_id = $id;
                    $object2->tag_id = $tags[$i];
                    $object2->save();
                }
            }
            $response['status'] = 'success';
            $response['message'] = "Article saved successfully";

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    
    public function saveWebinar(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            
            $unique_id = randomNumber();
            $check_name_count = Webinar::where("title",$request->input('title'))->count();
            $slug = str_slug($request->input("title"));
            if($check_name_count > 0){
                $slug = $slug."-".($check_name_count+1);
            }
            $object = new Webinar();
            $object->unique_id = $unique_id;
            $object->title = $request->input("title");
            $object->slug = $slug;
            $object->description = $request->input("description");
            $object->short_description = $request->input("short_description");
            $object->category_id = $request->input("category_id");
            $object->level = $request->input("level");
            $object->webinar_date = $request->input("webinar_date");
            $object->start_time = $request->input("start_time");
            $object->end_time = $request->input("end_time");
            $object->total_seats = $request->input("total_seats");
            $object->level = $request->input("level");
            $object->language_id = $request->input("language_id");
            if($request->input("paid_event")){
                $object->paid_event = 1;
                $object->event_cost = $request->input("event_cost");
                $object->price_group = $request->input("price_group");
            }else{
                $object->paid_event = 0;
                $object->event_cost = 0;
                $object->price_group = '';
            }

            if($request->input("offline_event")){
                $object->offline_event = 1;
                $object->address = $request->input("address");
                $object->country_id = $request->input("country_id");
                $object->state_id = $request->input("state_id");
                $object->city_id = $request->input("city_id");
                $object->online_event_link = '';
            }else{
                $object->offline_event = 0;
                $object->address = '';
                $object->country_id = 0;
                $object->state_id = 0;
                $object->city_id = 0;
                $object->online_event_link = $request->input("online_event_link");
            }
            $object->status = 'publish';

            $object->professional= $this->subdomain;
            $object->added_by = $request->input("added_by");
            if($request->input("timestamp")){
                $timestamp = $request->input("timestamp");
                if(is_dir(public_path()."/uploads/temp/". $timestamp)){
                    $files = glob(public_path()."/uploads/temp/". $timestamp."/*");
                    $filename = array();
                    for($f = 0; $f < count($files);$f++){
                        $file_arr = explode("/",$files[$f]);
                        $filename[] = end($file_arr);
                        $file_name =  end($file_arr);
                        $destinationPath = public_path("/uploads/webinars/".$file_name);
                        copy($files[$f], $destinationPath);
                        unlink($files[$f]);
                    }
                    if(file_exists(public_path()."/uploads/temp/". $timestamp)){
                        rmdir(public_path()."/uploads/temp/". $timestamp);
                    }
                    if(!empty($filename)){
                        $object->images = implode(",",$filename);
                    }
                }
            }
            $object->save();
            $id  = $object->id;
            if($request->input("tags")){
                $tags = $request->input("tags");
                for($i=0;$i < count($tags);$i++){
                    $object2 = new WebinarTags();
                    $object2->webinar_id = $id;
                    $object2->tag_id = $tags[$i];
                    $object2->save();
                }
            }
            if($request->input("topics")){
                $topics = $request->input("topics");
                foreach($topics as $topic){
                    $object2 = new WebinarTopics();
                    $object2->webinar_id = $id;
                    $object2->topic_name = $topic['topic_name'];
                    $object2->topic_list = implode(",",$topic['topic_list']);
                    $object2->save();
                }
            }
            $response['status'] = 'success';
            $response['message'] = "Webinar saved successfully";

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function fetchWebinars(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $search = $request->input("search");
            $records = Webinar::with(['Category'])
                            ->where("professional",$this->subdomain)
                            ->where(function($query) use($search){
                                if($search != ''){
                                    $query->where("title","LIKE","%$search%");
                                }
                            })
                            ->where("status",$request->input("status"))
                            ->orderBy("id","desc")
                            ->paginate();
            
            foreach($records as $record){
                $record->professional_info = $record->ProfessionalDetail($record->professional);
            }
            $data = $records;

            $response['status'] = 'success';
            $response['data'] = $data;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function fetchWebinar(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $record = Webinar::with(['Category','WebinarTags','WebinarTopics'])
                            ->where("professional",$this->subdomain)
                            ->where("unique_id",$request->input("webinar_id"))
                            ->first();
          
            $data = $record;

            $response['status'] = 'success';
            $response['data'] = $data;

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function updateWebinar(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $webinar_id = $request->input("webinar_id");
            $check_name_count = Webinar::where("title",$request->input('title'))
                                        ->where("unique_id",$webinar_id)
                                        ->count();
            $slug = str_slug($request->input("title"));
            if($check_name_count > 0){
                $slug = $slug."-".($check_name_count+1);
            }
            $object = Webinar::where("unique_id",$webinar_id)->first();
            $images = $object->images;
            $object->title = $request->input("title");
            $object->slug = $slug;
            $object->description = $request->input("description");
            $object->short_description = $request->input("short_description");
            $object->category_id = $request->input("category_id");
            $object->level = $request->input("level");
            $object->webinar_date = $request->input("webinar_date");
            $object->start_time = $request->input("start_time");
            $object->end_time = $request->input("end_time");
            $object->total_seats = $request->input("total_seats");
            $object->level = $request->input("level");
            $object->language_id = $request->input("language_id");
            if($request->input("paid_event")){
                $object->paid_event = 1;
                $object->event_cost = $request->input("event_cost");
                $object->price_group = $request->input("price_group");
            }else{
                $object->paid_event = 0;
                $object->event_cost = 0;
                $object->price_group = '';
            }

            if($request->input("offline_event")){
                $object->offline_event = 1;
                $object->address = $request->input("address");
                $object->country_id = $request->input("country_id");
                $object->state_id = $request->input("state_id");
                $object->city_id = $request->input("city_id");
                $object->online_event_link = '';
            }else{
                $object->offline_event = 0;
                $object->address = '';
                $object->country_id = 0;
                $object->state_id = 0;
                $object->city_id = 0;
                $object->online_event_link = $request->input("online_event_link");
            }
            if($request->input("timestamp")){
                $timestamp = $request->input("timestamp");
                if(is_dir(public_path()."/uploads/temp/". $timestamp)){
                    $files = glob(public_path()."/uploads/temp/". $timestamp."/*");
                    $filename = array();
                    for($f = 0; $f < count($files);$f++){
                        $file_arr = explode("/",$files[$f]);
                        $filename[] = end($file_arr);
                        $file_name =  end($file_arr);
                        $destinationPath = public_path("/uploads/webinars/".$file_name);
                        copy($files[$f], $destinationPath);
                        unlink($files[$f]);
                    }
                    if(file_exists(public_path()."/uploads/temp/". $timestamp)){
                        rmdir(public_path()."/uploads/temp/". $timestamp);
                    }
                    if(!empty($filename)){
                        if($images != ''){
                            $images .=",".implode(",",$filename);
                        }
                        $object->images = $images;
                    }
                }
            }
            $object->save();
            $id  = $object->id;
            if($request->input("tags")){
                WebinarTags::where("webinar_id",$id)->delete();
                $tags = $request->input("tags");
                for($i=0;$i < count($tags);$i++){
                    $object2 = new WebinarTags();
                    $object2->webinar_id = $id;
                    $object2->tag_id = $tags[$i];
                    $object2->save();
                }
            }
            if($request->input("topics")){
                $topics = $request->input("topics");
                WebinarTopics::where("webinar_id",$id)->delete();
                foreach($topics as $topic){
                    $object2 = new WebinarTopics();
                    $object2->webinar_id = $id;
                    $object2->topic_name = $topic['topic_name'];
                    $object2->topic_list = implode(",",$topic['topic_list']);
                    $object2->save();
                }
            }
            $response['status'] = 'success';
            $response['message'] = "Webinar updated successfully";

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function deleteWebinar(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);

            $record = Webinar::where("professional",$this->subdomain)
                            ->where("unique_id",$request->input("webinar_id"))
                            ->first();
            Webinar::deleteRecord($record->id);
            $response['status'] = 'success';
            $response['message'] = 'Webinar deleted successfully';

        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
    public function deleteWebinarImage(Request $request){
        try{
            $postData = $request->input();
            $request->request->add($postData);
            $image = $request->input("image");
            $record = Webinar::where("unique_id",$request->input("webinar_id"))->first();
            $images = explode(",",$record->images);
            if(file_exists(public_path('uploads/webinars/'.$image))){
                unlink(public_path('uploads/webinars/'.$image));
            }
            if (($key = array_search($image, $images)) !== false) {
                unset($images[$key]);
                array_values($images);
            }
            $record->images = implode(",",$images);
            $record->save();

            $response['status'] = 'success';
            $response['message'] = "Webinar image removed successfully";
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }
}
