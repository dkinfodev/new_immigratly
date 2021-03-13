<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Redirect;
use Validator;
use DB;
use Razorpay\Api\Api;
use Image;
use View;
use App\Models\User;
use App\Models\Articles;
use App\Models\ChatGroups;
use App\Models\News;
use App\Models\Professionals;
use App\Models\ChatGroupComments;
use App\Models\Webinar;
use App\Models\VisaServices;

class FrontendController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    public function index(){
        // $db['GOOGLE_CLIENT_ID'] = base64_encode("972372764079-l4dqpfuun15l5oetf070mh6ek60m6jl7.apps.googleusercontent.com");
        // $db['GOOGLE_CLIENT_SECRET'] = base64_encode("YV9PppIZly96PyGTDIXuV4Ly");
        // $db['GOOGLE_URL'] = base64_encode("https://immigratly.com/login/google/callback");
        // echo json_encode($db);
        // exit;
       //$contens = public_path('uploads/files/26531-2stallions-300x300.jpg');
       //$image = \Storage::disk('s3')->put('26531-2stallions-300x300.jpg', $contens);

        // $image = Image::create([
        //     'filename' => public_path('uploads/files/65912-75910-noc_codes.csv'),
        //     'url' => Storage::disk('s3')->url($path)
        // ]);
       
        $now = \Carbon\Carbon::now();
        $articles = Articles::where("status","publish")
                        ->orderBy('id','desc')
                        ->limit(4)
                        ->get();
        $news = News::where(DB::raw("(STR_TO_DATE(news_date,'%d-%m-%Y'))"), ">=",$now)
                    ->orderBy("id",'desc')
                    ->limit(4)
                    ->get();

        $webinars = Webinar::where("status","publish")
                        ->where(DB::raw("(STR_TO_DATE(webinar_date,'%d-%m-%Y'))"), ">=",$now)
                        ->orderBy(DB::raw("(STR_TO_DATE(webinar_date,'%d-%m-%Y'))"),'desc')
                        ->limit(4)
                        ->get();

        $professionals = Professionals::orderBy('id','desc')
                        ->limit(4)
                        ->get();
       
        $viewData['webinars'] = $webinars;
        $viewData['professionals'] = $professionals;
        $viewData['articles'] = $articles;   
        $viewData['news'] = $news;   
        $viewData['pageTitle'] = "Home Page";   
        return view('frontend.index',$viewData);
     
    }

    public function articles($category=''){
        if($category != ''){
            $visa_service = VisaServices::where("slug",$category)->first();
            $articles = Articles::orderBy('id','desc')
                        ->where("category_id",$visa_service->id)
                        ->where("status",'publish')
                        ->paginate();
        }else{
            $articles = Articles::orderBy('id','desc')
                        ->where("status",'publish')
                        ->paginate();
        }
        
        $viewData['articles'] = $articles;   
        $viewData['pageTitle'] = "Articles";   
        $services = VisaServices::whereHas('Articles')->get();
        $viewData['services'] = $services;
        return view('frontend.articles.articles',$viewData);
    }   

    public function articleSingle($slug){
         $article = Articles::where('slug',$slug)->first();
         if(empty($article)){
            return redirect('/');   
         }
         $viewData['article'] = $article;   
         $viewData['pageTitle'] = $article->title;   
         return view('frontend.articles.article-single',$viewData);
    }

    public function webinars($category=''){
        $now = \Carbon\Carbon::now();
        if($category != ''){
            $visa_service = VisaServices::where("slug",$category)->first();
            
            $webinars = Webinar::where("status","publish")
                        ->where(DB::raw("(STR_TO_DATE(webinar_date,'%d-%m-%Y'))"), ">=",$now) 
                        ->where("category_id",$visa_service->id)
                        ->where("status",'publish')
                        ->orderBy(DB::raw("(STR_TO_DATE(webinar_date,'%d-%m-%Y'))"),'desc')
                        ->paginate();
        }else{
            $webinars = Webinar::where("status","publish")
                        ->where(DB::raw("(STR_TO_DATE(webinar_date,'%d-%m-%Y'))"), ">=",$now) 
                        ->where("status",'publish')
                        ->orderBy(DB::raw("(STR_TO_DATE(webinar_date,'%d-%m-%Y'))"),'desc')
                        ->paginate();
        }
        

        $viewData['webinars'] = $webinars;   
        $viewData['pageTitle'] = "Webinars";   
        $services = VisaServices::whereHas('Webinars')->get();
        $viewData['services'] = $services;
        return view('frontend.webinar.webinar',$viewData);
    }   

    public function webinarSingle($slug){
         $webinar = Webinar::where('slug',$slug)->first();
         if(empty($webinar)){
            return redirect('/');   
         }
         $viewData['webinar'] = $webinar;   
         $viewData['pageTitle'] = $webinar->title;   
         return view('frontend.webinar.webinar-single',$viewData);
    }
    public function discussions(){
        $viewData['pageTitle'] = "Discussions Topics";   
        return view('frontend.discussions.discussions',$viewData);
    }

    public function fetchTopics(Request $request){
        $search = $request->input("search");
        $discussions = ChatGroups::with('User')
                                ->where("status","open")
                                ->where(function($query) use($search){
                                    if($search != ''){
                                        $query->where("group_title","LIKE","%$search%");
                                        $query->orWhere("description","LIKE","%$search%");
                                    }
                                })
                                ->paginate(2);

        $viewData['discussions'] = $discussions;
        $view = View::make('frontend.discussions.topic-list',$viewData);
        $contents = $view->render();

        $response['status'] = true;
        $response['contents'] = $contents;
        $response['last_page'] = $discussions->lastPage();
        $response['current_page'] = $discussions->currentPage();
        $next_page = $discussions->currentPage() + 1;
        $response['next_page'] = $next_page;
        $response['total_records'] = $discussions->total();
        return response()->json($response);
    }

    public function topicDetails($slug){
        $viewData['pageTitle'] = "Discussions Topics";   
        $discussions = ChatGroups::with('User')
                                ->where("slug",$slug)
                                ->first();

        $viewData['record'] = $discussions;
        return view('frontend.discussions.topic-detail',$viewData);
    }

    public function fetchComments(Request $request){
        $chat_id = $request->input("chat_id");
        $comments = ChatGroupComments::with('User')->where("chat_id",$chat_id)->get();
        $viewData['comments'] = $comments;
        $view = View::make('frontend.discussions.comments',$viewData);
        $contents = $view->render();

        $response['status'] = true;
        $response['contents'] = $contents;
        return response()->json($response);
    }

    public function sendComment(Request $request){

        $object = new ChatGroupComments();
        $unique_id = randomNumber();
        $object->unique_id = $unique_id;
        $object->chat_id = $request->input("chat_id");
        if($request->input("message")){
            $message = $request->input("message");
            $object->message = $message;
        }
        
        if($file = $request->file('file'))
        {
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension();
            $allowed_extension = allowed_extension();
            if(in_array($extension,$allowed_extension)){
                $newName        = randomNumber(5)."-".$fileName;
                $source_url = $file->getPathName();
                $destinationPath = public_path("/uploads/files");
                if($file->move($destinationPath, $newName)){
                    $object->file_name = $newName;
                }
            }else{
                $response['status'] = false;
                $response['message'] = "File not allowed";
                return response()->json($response);
            } 
        }
        $object->send_by = \Auth::user()->unique_id;
        $object->user_type = "user";
        $object->save();

        $response['status'] = true;
        $response['message'] = "Comment added successfully";

        return response()->json($response);
    }

    public function sendVerifyCode(Request $request){
        $validator = Validator::make($request->all(), [
            'value' => 'required',
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

        $value = $request->input("value");
        $verify_type = explode(":",$value);
        \Session::forget("verify_code");
        \Session::forget("service_code");
        if($verify_type[0] == 'mobile_no'){
            if($request->input("check") == 'user'){
                $checkExists = User::whereRaw("CONCAT(`country_code`, `phone_no`) = ?", [$verify_type[1]])->count();
            }else{
                $checkExists = Professionals::whereRaw("CONCAT(`country_code`, `phone_no`) = ?", [$verify_type[1]])->count();
            }
          
            if($checkExists > 0){
                $response['status'] = false;
                $response['message'] = "Mobile exists try another number";
                return response()->json($response);
            }
            $return = sendVerifyCode($verify_type[1]);
            
            if($return['status'] == 1){
                $response['status'] = true;
                \Session::put("service_code",$return['service_code']);
                $response['message'] = $return['message'];
            }else{
                $response['status'] = false;
                $response['message'] = $return['message'];
            }
            return response()->json($response);
        }else{
            if($request->input("check") == 'user'){
                $checkExists = User::where("email",$verify_type[1])->count();
            }else{
                $checkExists = Professionals::where("email",$verify_type[1])->count();
            }
            
            if($checkExists > 0){
                $response['status'] = false;
                $response['message'] = "Email already exists try another email";
                return response()->json($response);
            }
            \Session::forget("verify_code");
            $verify_code = mt_rand(100000,999999);
            
            $mailData['verify_code'] = $verify_code;
            $view = View::make('emails.verify-code',$mailData);
            $message = $view->render();
            // $parameter['to'] = $verify_type[1];
            $parameter['to'] = 'developertest143@gmail.com';
            $parameter['to_name'] = '';
            $parameter['message'] = $message;
            $parameter['subject'] = companyName()." verfication code";
            // echo $message;
            // exit;
            $parameter['view'] = "emails.verify-code";
            $parameter['data'] = $mailData;
            $mailRes = sendMail($parameter);

            \Session::put("verify_code",$verify_code);
            if($mailRes['status'] == true){
                \Session::put("verify_code",$verify_code);
                $response['status'] = true;
                $response['message'] = "Check your email for verfication code";
            }else{
                $response['status'] = false;
                $response['message'] = $mailRes['message'];
            }
            return response()->json($response);
        }
    }
}
