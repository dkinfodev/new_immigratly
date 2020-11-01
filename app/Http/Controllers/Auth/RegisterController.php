<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Countries;
use App\Models\VerificationCode;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function userSignup(Request $request){
        if(\Auth::check()){
            return Redirect::to(baseUrl('/'));
        }
        $viewData['pageTitle'] = 'Sign Up as User';
        $viewData['countries'] = Countries::get();
        return view('auth.user-signup',$viewData);   
    }

    public function registerUser(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
            'country_code' => 'required',
            'phone_no' => 'required',
            'verify_by'=>'required',
            // 'verification_code'=>'required',
        ]);

        
        session(['redirect_back' => $request->input('redirect_back')]);
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
        

        $phone = $request->input("country_code").$request->input("phone_no");
        
        if($request->input("verify_by") == 'sms'){
            // $res = verifyCode(\Session::get("service_code"),$request->input('verification_code'),$phone);

            // if($res['status'] == false){
            //     $response['status'] = false;
            //     $response['message'] = 'OTP Verification code entered is invalid';
            //     return response()->json($response);
            // }
        }else{
            $date = date("Y-m-d H:i:s");
            $match_code = VerificationCode::where("verify_by","email")
                        ->where("match_string",$request->input("email"))
                        ->where("verify_code",$request->input("verification_code"))
                        ->whereDate("expiry_time","<",$date)
                        ->count();
            // if($request->input("verification_code") != \Session::get("verify_code")){
           if($match_code <= 0){
                return redirect()->back()
                        ->with("verification_code","Verification code entered is invalid")
                        ->withInput();
            }
            VerificationCode::where("match_string",$request->input("email"))->delete();
        }
        $object = new User();
        $object->first_name = $request->input("first_name");
        $object->last_name = $request->input("last_name");
        $object->email = $request->input("email");
        $object->password = bcrypt($request->input("password"));
        $object->country_code = $request->input("country_code");
        $object->phone_no = $request->input("phone_no");
        $object->role = "user";
        $object->is_active = 1;
        $object->is_verified = 1;
        
        $object->save();
        $user_id = $object->id;
        \Auth::loginUsingId($user_id);
        \Session::forget("verify_code");
        $response['status'] = true;
        if(!empty($request->input('redirect_back'))){
            $response['redirect_back']= $request->input('redirect_back');    
        }else{
            $response['redirect_back'] = url('home');  
        }

        return response()->json($response);
    }

    public function professionalSignup(Request $request){
        if(\Auth::check()){
            return Redirect::to(baseUrl('/'));
        }
        $viewData['pageTitle'] = 'Sign Up as Professional';
        $viewData['countries'] = Countries::get();
        return view('auth.professional-signup',$viewData);   
    }

    public function registerProfessional(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|confirmed|min:4',
            'password_confirmation' => 'required|min:4',
            'country_code' => 'required',
            'phone_no' => 'required',
            'verify_by'=>'required',
            // 'verification_code'=>'required',
        ]);

        
        session(['redirect_back' => $request->input('redirect_back')]);
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
        

        $phone = $request->input("country_code").$request->input("phone_no");
        
        if($request->input("verify_by") == 'sms'){
            // $res = verifyCode(\Session::get("service_code"),$request->input('verification_code'),$phone);

            // if($res['status'] == false){
            //     $response['status'] = false;
            //     $response['message'] = 'OTP Verification code entered is invalid';
            //     return response()->json($response);
            // }
        }else{
            $date = date("Y-m-d H:i:s");
            $match_code = VerificationCode::where("verify_by","email")
                        ->where("match_string",$request->input("email"))
                        ->where("verify_code",$request->input("verification_code"))
                        ->whereDate("expiry_time","<",$date)
                        ->count();
            // if($request->input("verification_code") != \Session::get("verify_code")){
           if($match_code <= 0){
                return redirect()->back()
                        ->with("verification_code","Verification code entered is invalid")
                        ->withInput();
            }
            VerificationCode::where("match_string",$request->input("email"))->delete();
        }
        $object = new User();
        $object->first_name = $request->input("first_name");
        $object->last_name = $request->input("last_name");
        $object->email = $request->input("email");
        $object->password = bcrypt($request->input("password"));
        $object->country_code = $request->input("country_code");
        $object->phone_no = $request->input("phone_no");
        $object->role = "professional";
        $object->is_active = 1;
        $object->is_verified = 1;
        
        $object->save();
        $user_id = $object->id;
        \Auth::loginUsingId($user_id);
        \Session::forget("verify_code");
        $response['status'] = true;
        if(!empty($request->input('redirect_back'))){
            $response['redirect_back']= $request->input('redirect_back');    
        }else{
            $response['redirect_back'] = url('home');  
        }

        return response()->json($response);
    }
}
