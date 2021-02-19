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
use App\Models\Articles;
use App\Models\ChatGroups;
use App\Models\News;
use App\Models\Professionals;
use App\Models\ChatGroupComments;
use App\Models\Webinar;

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

    public function articles(){
        $articles = Articles::get();
        $viewData['articles'] = $articles;   
        $viewData['pageTitle'] = "Articles";   
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
}
