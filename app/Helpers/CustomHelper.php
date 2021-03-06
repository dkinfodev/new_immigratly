<?php
require dirname(__DIR__)."/../library/subdomain/init.php";
require dirname(__DIR__)."/../library/twilio/twilio.php";
require dirname(__DIR__)."/../library/google-api/vendor/autoload.php";
require dirname(__DIR__)."/../library/dropbox/demo-lib.php";
require dirname(__DIR__)."/../library/dropbox/DropboxClient.php";

use Illuminate\Support\Str;

use App\Models\Settings;
use App\Models\DomainDetails;
use App\Models\Documents;
use App\Models\Professionals;
use App\Models\RolePrivileges;
use App\Models\Notifications;
use App\Models\Cities;
use App\Models\States;
use App\Models\Countries;
use App\Models\LanguageProficiency;
use App\Models\ClientExperience;
use App\Models\ClientEducations;
use App\Models\StaffPrivileges;
use App\Models\UserDetails;

if (! function_exists('getFileType')) {
    function getFileType($ext) {
        $file_type = array(
            array("image"=>array("jpg","jpeg","png","gif","svg")),
            array("pdf"=>array("pdf")),
            array("doc"=>array("doc","docx","odt")),
        );
        $file_ext = '';
        foreach($file_type as $type){
            foreach($type as $key => $file){
                if(in_array($ext,$file)){
                    $file_ext =$key;
                }
            }
        }
        return $file_ext;
    }
}
if (! function_exists('allowed_extension')) {
    function allowed_extension(){
        $ext = array("doc","docx","xls","xlsx","csv","ppt","pptx","pdf","jpg","jpeg","png","gif");
        return $ext;
    }
}
if (! function_exists('pre')) {
    function pre($value,$exists=0) {
        echo "<pre>";
        print_r($value);
        echo "</pre>";
        if($exists == 1){
            die();
        }
    }
}

if (! function_exists('roleFolder')) {
    function roleFolder() {
        if(Auth::check()){
            $role = Auth::user()->role;
            $role = str_replace("_","-",$role);
            
        }else{
            $role = '';
        }
        return $role;
    }
}

if (! function_exists('baseUrl')) {
    function baseUrl($url) {
        if(Auth::check()){
            $role = Auth::user()->role;
            $role = str_replace("_","-",$role);
            if (strpos($url, '/') === 0) {
                $base_url = url($role.$url);
            }else{
                $base_url = url($role.'/'.$url);
            }
        }else{
            $base_url = url($url);
        }
        
        return $base_url;
    }
}

if (! function_exists('resizeImage')) {
    function resizeImage($source_url, $destination_url, $maxWidth, $maxHeight, $quality=80) {

        $imageDimensions = getimagesize($source_url);
        $imageWidth = $imageDimensions[0];
        $imageHeight = $imageDimensions[1];
        $imageSize['width'] = $imageWidth;
        $imageSize['height'] = $imageHeight;
        if($imageWidth > $maxWidth || $imageHeight > $maxHeight)
        {
            if ( $imageWidth > $imageHeight ) {
                $imageSize['height'] = floor(($imageHeight/$imageWidth)*$maxWidth);
                $imageSize['width']  = $maxWidth;
            } else {
                $imageSize['width']  = floor(($imageWidth/$imageHeight)*$maxHeight);
                $imageSize['height'] = $maxHeight;
            }
        }

        $width = $imageSize['width'];
        $height = $imageSize['height'];

        $info = getimagesize($source_url);
        if ($info['mime'] == 'image/jpeg')
        $source = imagecreatefromjpeg($source_url);

        elseif ($info['mime'] == 'image/gif')
        $source = imagecreatefromgif($source_url);

        elseif ($info['mime'] == 'image/png')
        $source = imagecreatefrompng($source_url);


        $thumb = imagecreatetruecolor($width, $height);
        //$source = imagecreatefromjpeg($source_url);

        list($org_width, $org_height) = getimagesize($source_url);

        imagecopyresized($thumb, $source, 0, 0, 0, 0, $width, $height, $org_width, $org_height);
        $filename = mt_rand(0,9999);
        imagejpeg($thumb, $destination_url);
        return $destination_url;
    }
}
if (! function_exists('profileImage')) {
    function profileImage($image,$size='l') {
        $url = '';
        switch($size){
            case 'l':
                $url = "public/uploads/profile/".$image;
            break;
            case 'm':
                $url = "public/uploads/profile/medium/".$image;
            break;
            case 't':
                $url = "public/uploads/profile/thumb/".$image;
            break;
        }
        return $url;

    }
}

if (! function_exists('dateFormat')) {
    function dateFormat($date,$format = "M d, Y") {
        $date = date($format,strtotime($date));
        return $date;
    }
}

if(!function_exists("fileIcon")){
    function fileIcon($filename){
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $icon = '<img class="avatar avatar-xs avatar-4by3" src="assets/svg/brands/google-docs.svg" alt="Doc File">';
        if(in_array($ext,array("doc","docx"))){
            $icon = '<img class="avatar avatar-xs avatar-4by3" src="assets/svg/brands/word.svg" alt="Doc File">';
        }
        if(in_array($ext,array("xls","xlsx"))){
            $icon = '<img class="avatar avatar-xs avatar-4by3" src="assets/svg/brands/google-sheets.svg" alt="Doc File">';
        }
        if(in_array($ext,array("pdf"))){
            $icon = '<img class="avatar avatar-xs avatar-4by3" src="assets/svg/brands/pdf.svg" alt="Image Description">';
        }
        if(in_array($ext,array("jpg","jpeg","png","gif"))){
            $icon = '<img class="avatar avatar-xs avatar-4by3" src="assets/svg/brands/google-slides.svg" alt="Image Description">';
        }
        return $icon;
    }
}
if(!function_exists("fileExtension")){
    function fileExtension($filename){
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $type = '';
        if(in_array($ext,array("doc","docx"))){
            $type = 'doc';
        }
        if(in_array($ext,array("xls","xlsx"))){
            $type = 'xls';
        }
        if(in_array($ext,array("pdf"))){
            $type = 'pdf';
        }
        if(in_array($ext,array("jpg","jpeg","png","gif"))){
            $type = 'image';
        }
        return $type;
    }
}
if(!function_exists("file_size")){
    function file_size($file){
        if(file_exists($file)){
            $size = filesize($file);
            $bytes = $size;
            if ($size >= 1073741824)
            {
                $bytes = number_format($bytes / 1073741824, 2) . ' GB';
            }
            elseif ($bytes >= 1048576)
            {
                $bytes = number_format($bytes / 1048576, 2) . ' MB';
            }
            elseif ($bytes >= 1024)
            {
                $bytes = number_format($bytes / 1024, 2) . ' KB';
            }
            elseif ($bytes > 1)
            {
                $bytes = $bytes . ' bytes';
            }
            elseif ($bytes == 1)
            {
                $bytes = $bytes . ' byte';
            }
            else
            {
                $bytes = '0 bytes';
            }

            $file_size = $bytes;
        }else{
            $file_size = '0 bytes';
        }
        return $file_size;
    }
}
if(!function_exists("companyName")){
    function companyName(){
        $company = 'Immigratly';
        return $company;
    }
}
if(!function_exists("currencyFormat")){
    function currencyFormat($price = ''){
        if($price != ''){
            $price = "₹".$price;
        }else{
            $price = "₹";
        }
        return $price;
    }
}
if(!function_exists("bankList")){
    function bankList() { 
        $netbanking = DB::table(MAIN_DATABASE.".netbankings")->get();
        return $netbanking;
    }
}

if(!function_exists("WalletList")){
    function WalletList() { 
        $wallet_list = DB::table(MAIN_DATABASE.".wallet_list")->get();
        return $wallet_list;
    }
}

if(!function_exists("authorFollowed")){
    function authorFollowed($author_id,$user_id) { 
        $is_followed = AuthorFollowers::where("user_id",$user_id)->where("author_id",$author_id)->count();
        return $is_followed;
    }
}
if(!function_exists("isArticleBookmark")){
    function isArticleBookmark($article_id,$user_id) { 
        $count = UserArticlesBookmark::where("article_id",$article_id)->where("user_id",$user_id)->count();
        return $count;
    }
}

if(!function_exists("paginateInfo")){
    function paginateInfo($records) { 
        $html ='<div class="page-info">Showing <span>'.$records->currentPage().' of '.$records->lastPage().' <small>('.$records->total().' records)</small></span></div>';
        return $html;
    }
}

if (! function_exists('getFileTypeIcon')) {
    function getFileTypeIcon($filename) {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $file_type = array(
            array("image"=>array("jpg","jpeg","png","gif","svg")),
            array("pdf"=>array("pdf")),
            array("doc"=>array("doc","docx","odt")),
        );
        $file_icon = array(
            'pdf'=>"fa fa-file-pdf-o",
            'doc'=>"fa fa-file-word-o",
            'image'=>"fa fa-file-image-o",
        );
        $file_ext = '';
        foreach($file_type as $type){
            foreach($type as $key => $file){
                if(in_array($ext,$file)){
                    $file_ext = $key;
                }
            }
        }
        if($file_ext != '')
        $icon = $file_icon[$file_ext];
        else
        $icon = 'fa fa-file';
        return $icon;
    }
}

if(!function_exists("sendMail")){
    function sendMail($parameter){

        if(!isset($parameter['from'])){
            $parameter['from'] = mailFrom("email");
        }
        if(!isset($parameter['from_name'])){
            $parameter['from_name'] =mailFrom("name");
        }
        if(!isset($parameter['to_name'])){
            $parameter['to_name'] ='';
        }
        try{
            $data = array();
            if(isset($parameter['data'])){
               $data = $parameter['data']; 
            }
            // Mail::raw([], function ($m) use ($parameter) {
             $res = Mail::send($parameter['view'], $data, function ($m) use($parameter){
                $m->from($parameter['from'],$parameter['from_name']);
                // $m->setBody($parameter['message'], 'text/html' );
                // $m->setBody("<h1>Hello User</h1>", 'text/html' );
                $m->to($parameter['to'],$parameter['to_name'])->subject($parameter['subject']);
                if(isset($parameter['attachment'])){
                    $attachment = $parameter['attachment'];
                    for($i=0;$i < count($attachment);$i++){
                        $m->attach($attachment[$i]);
                    }
                }
            });
            $response['status'] = true;
            $response['message'] ="Mail send successfully";    
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return $response;
    }
}

if(!function_exists("sendSms")){
    function sendSms($parameter){
        try{
            
            $apiKey = urlencode(env("TEXT_LOCAL_KEY"));
            $message = strip_tags($parameter['message']);
            
            $numbers = $parameter['phone_no'];
            $sender = urlencode('TXTLCL');
            
            $numbers = $numbers;
         
            $data = array('apikey' => $apiKey,
                 'numbers' => $numbers,
                 "sender" => $sender,
                 "message" => $message,
                 // 'test'=>true
             );
           
            // Send the POST request with cURL
            $ch = curl_init('https://api.textlocal.in/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($result,true);
    
            if(isset($result['errors'])){
                $errMsg = '';
                foreach($result['errors'] as $err){
                    if(isset($err['message'])){
                        $errMsg .="\n".$err['message'];
                    }
                }
                $response['status'] = false;
                $response['message'] = $errMsg;
            }else{
                $response['status'] = true;
                $response['message'] = "Sms send successfully";    
            }
            
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return $response;
    }
}   

if(!function_exists("sendToWhatsApp")){
    function sendToWhatsApp($parameter){
        
        // $twilio = new TwilioApi(env('TWILIO_AID'),env('TWILIO_TOKEN'));
        // $response = $twilio->sendWhatsMessage($parameter);
        // return $response;
        try{
            
            $messages = array(
                'send_channel' => 'whatsapp',
                'messages' => array(
                    array(
                        'number' => str_replace("+","",$parameter['phone_no']),
                        'template' => array(
                            'id' => '446209',
                            'merge_fields' => array(
                                'FirstName' => $parameter['first_name'],
                                'LastName' => $parameter['last_name'],
                                'Custom1' => $parameter['message'],
                                'Custom2' => 'tesata',
                                'Custom3' => 'test',

                            )
                        )
                    )
                )
            );
            pre($messages);
            exit;

            // Prepare data for POST request
            $data = array(
                'apikey' => env("TEXT_LOCAL_KEY"),
                'data' => json_encode($messages),
                // 'test'=> true
            );
             
            // Send the POST request with cURL
            $ch = curl_init('https://api.textlocal.in/bulk_json/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($result,true);
            $response['status'] = true;
            pre($result);
            exit;
            if($result['status'] == 'success'){
                $response['status'] = true;
                $response['message'] = "Message send successfully";
            }
            
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return $response;
    }
}

if(!function_exists("mailFrom")){
    function mailFrom($key = '') { 
        $fromData['name'] = companyName();
        $fromData['email'] = "noreply@immigratly.com";
        if($key != ''){
            return $fromData[$key];
        }else{
            return $fromData;
        }

    }
}
if(!function_exists("checkSetting")){
    function checkSetting($key = '') { 
        $setting = Settings::where("meta_key",$key)->first();
        $meta_value ='';
        if(!empty($setting)){
            $meta_value = $setting->meta_value;
        }
        return $meta_value;
    }
}
if(!function_exists("runBackground")){
    function runBackground($url){
        $cmd  = "curl --max-time 60 ";
        $cmd .= "'" . $url . "'";
        $cmd .= " > /dev/null 2>&1 &";
        exec($cmd, $output, $exit);
        
        // exec($cmd . " > /dev/null &");   
    }
}
if(!function_exists("set_cookie")){
    function set_cookie($key,$value){
        
        setcookie($key, $value, mktime(24, 0, 0) - time());
   }
}

if(!function_exists("get_cookie")){
    function get_cookie($key){
        if(isset($_COOKIE[$key])){
            return $_COOKIE[$key];
        }else{
            return '';
        }
   }
}
if(!function_exists("generateString")){
    function generateString($n=15) { 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
      
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
      
        return $randomString; 
    } 
}
if(!function_exists("randomNumber")){
    function randomNumber($n=10) { 
        $characters = '1123456789'; 
        $randomString = ''; 
        $randomString = substr(str_shuffle($characters), 0, $n);     
        return $randomString; 
    } 
}
if(!function_exists("userInitial")){
    function userInitial($user) { 
       $first_name = substr($user->first_name,0,1);
       $last_name = substr($user->last_name,0,1);
       $init = $first_name.$last_name;
       $init = strtoupper($init);
       
       return $init;
    }
}

if(!function_exists("createSubDomain")){
    function createSubDomain($subdomain,$dbname){
        $rootdomain = Settings::where("meta_key",'rootdomain')->first();
        $rootdomain = $rootdomain->meta_value;

        $root_dir = Settings::where("meta_key",'root_dir')->first();
        $root_dir = $root_dir->meta_value;

        $db_username = Settings::where("meta_key",'db_username')->first();
        $db_username = $db_username->meta_value;

        $parameters = [
            'domain' => $subdomain,
            'rootdomain' => $rootdomain,
            'dir' => $root_dir,
            'disallowdot' => 1,
        ];
        $cPanel = new cPanel("immigratly", "Immigratly@", "138.197.137.123");
        $result = $cPanel->execute('api2',"SubDomain", "addsubdomain" , $parameters);
        if (isset($result->cpanelresult->error)) {
            $response['status'] = "error";
            $message = "Cannot add sub domain : {$result->cpanelresult->error}";
            $response['message'] = $message;
            return $response;
        }else{
            $response['status'] = "success";
            $message = "Subdomain created successfully";
        }
        $parameter = array();
        $parameter = [ 'name' => $dbname];
        $result = $cPanel->execute('uapi', 'Mysql', 'create_database', $parameter);
        if (!$result->status == 1) {
            $message = "Cannot create database : {$result->errors[0]}";
            $response['message'] = $message;
            return $response;
        }
        
        $set_dbuser_privs = $cPanel->execute('uapi',
            'Mysql', 'set_privileges_on_database',
            array(
                'user'       => $db_username,
                'database'   => $dbname,
                'privileges' => 'ALL PRIVILEGES',
            )
        );
        $response['message'] = "Panel create successfully";
        return $response;
    }
}
if(!function_exists("curlRequest")){
    function curlRequest($url,$data=array()){
        $client_key = DomainDetails::first();
        // $subdomain = array_first(explode('.', request()->getHost()));
        $host = explode('.', request()->getHost());
        $subdomain = $host[0];
        $site_url = DB::table(MAIN_DATABASE.".settings")->where("meta_key","site_url")->first();
        $site_url = $site_url->meta_value;
        if($subdomain == 'localhost'){
            $api_url = url('/api/main');
        }else{
            $api_url = $site_url."api/main";
        }
        $token = $client_key->client_secret;
      
        $ch = curl_init($api_url."/".$url);
       
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
           'Content-Type: application/json',
           'subdomain:'.\Session::get("subdomain"),
           'Authorization:' . $token
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        if(count($data) > 0){
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        $response = curl_exec($ch);

        $info = curl_getinfo($ch);
        curl_close($ch);
       
        $curl_response = json_decode($response,true);
        // echo $response;
        // if($curl_response->status == 'api_error'){
        //     if($curl_response->error == 'account_disabled'){
        //         Auth::logout();
        //     }
        // }
        return $curl_response;
    }
}
if(!function_exists("professionalCurl")){
    function professionalCurl($url,$subdomain,$data=array(),$return=''){
       
        $professional = DB::table(MAIN_DATABASE.".professionals")->where("subdomain",$subdomain)->first();
        
        $rootdomain = DB::table(MAIN_DATABASE.".settings")->where("meta_key",'rootdomain')->first();
        $rootdomain = $rootdomain->meta_value;

        
        $host = explode('.', request()->getHost());
        $host = $host[0];
        $site_url = DB::table(MAIN_DATABASE.".settings")->where("meta_key","site_url")->first();
        $site_url = $site_url->meta_value;
        if($host == 'localhost'){
            $api_url = url('/api/professional');
        }else{
            $api_url = "http://".$subdomain.".".$rootdomain."/api/professional";
        }
        $token = $professional->client_secret;
        
        $ch = curl_init($api_url."/".$url); 
       
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
           'Content-Type: application/json',
           'subdomain:'.$subdomain,
           'Authorization:' . $token
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        if(count($data) > 0){
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        $response = curl_exec($ch);
        // echo $response;
        $info = curl_getinfo($ch);
        curl_close($ch);
        $curl_response = json_decode($response,true);
        if($return == 'print'){
            echo $response;
        }
        return $curl_response;
    }
}

if(!function_exists("domain")){
    function domain(){
        $site_url = DB::table(MAIN_DATABASE.".settings")->where("meta_key","site_url")->first();
        $site_url = $site_url->meta_value;
        if($_SERVER['SERVER_NAME'] == 'localhost'){
            $domain = url('/');
        }else{
            $domain = $site_url;
        }
        return $domain;
    }
}
if(!function_exists("sendVerifyCode")){
    function sendVerifyCode($phoneno){
        $twilio = new TwilioApi(env('TWILIO_SID'),env('TWILIO_TOKEN'),env('TWILIO_AID'));
        $response = $twilio->verifyPhone($phoneno);
        pre($response);
        return $response;
    }
}
if(!function_exists("verifyCode")){
    function verifyCode($service_code,$verify_code,$phoneno){

        $twilio = new TwilioApi(env('TWILIO_SID'),env('TWILIO_TOKEN'),env('TWILIO_AID'));
        $response = $twilio->verifyCode($service_code,$verify_code,$phoneno);
        return $response;
    }
}
if(!function_exists("str_slug")){
    function str_slug($string){
        $slug = Str::slug($string, '-');
        return $slug;
    }
}


if(!function_exists("subdomain")){
    function subdomain($subdomain){
        $rootdomain = Settings::where("meta_key",'rootdomain')->first();
        $rootdomain = $rootdomain->meta_value;
        $domain = $subdomain.".".$rootdomain;
        return $domain;
    }
}

if(!function_exists("checkProfileStatus")){
    function checkProfileStatus($subdomain){
        $db_prefix = Settings::where("meta_key","database_prefix")->first();
        $db_prefix = $db_prefix->meta_value;
        $database = $db_prefix.$subdomain;
        
        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?";
        $db = DB::select($query, [$database]);
       
        if (empty($db)) {
            $response['status'] = "failed";
            $response['message'] = "Panel Database not exists";
        } else {
            $response['status'] = "success";
            $professional = DB::table($database.".domain_details")->first();
            $response['professional'] = $professional;
        }
        return $response;
    }
}
if(!function_exists("db_prefix")){
    function db_prefix(){
        $db_prefix = Settings::where("meta_key","database_prefix")->first();
        $db_prefix = $db_prefix->meta_value;
        return $db_prefix;
    }
}
if(!function_exists("professionalDir")){
    function professionalDir($domain = ''){
        if($domain == ''){
            $domain = \Session::get("subdomain");
        }
        $dir = public_path("uploads/professional/".$domain);

        return $dir;
    }
}

if(!function_exists("professionalDirUrl")){
    function professionalDirUrl($domain = ''){
        if($domain == ''){
            $domain = \Session::get("subdomain");
        }
        // $dir = asset("public/uploads/professional/".$domain);
        $dir = site_url()."public/uploads/professional/".$domain;
        
        return $dir;
    }
}
if(!function_exists("professionalProfile")){
    function professionalProfile($unique_id = '',$size='r',$domain = ''){
        if($domain == ''){
            $domain = \Session::get("subdomain");
        }
        if($unique_id == ''){
            $unique_id = \Auth::user()->unique_id;
        }
        
        $user = DB::table(PROFESSIONAL_DATABASE.$domain.".users")->where("unique_id",$unique_id)->first();
      
        $profile_image = $user->profile_image;
        $profile_dir = professionalDir($domain)."/profile/".$profile_image;
        if($profile_image == '' || !file_exists($profile_dir)){
            $url = asset("/public/uploads/users/default.jpg");
            return $url;
        }
        $original = asset("/public/uploads/professional/".$domain."/profile/".$profile_image);
        $url = '';
        if($size == 'r'){
            $url = asset("/public/uploads/professional/".$domain."/profile/".$profile_image);
        }
        if($size == 'm'){
            if(file_exists(professionalDir($domain)."/profile/medium/".$profile_image)){
                $url = asset("/public/uploads/professional/".$domain."/profile/medium/".$profile_image);
            }else{
                $url = $original;
            }
        }
        if($size == 't'){
            if(file_exists(professionalDir($domain)."/profile/thumb/".$profile_image)){
                $url = asset("public/uploads/professional/".$domain."/profile/thumb/".$profile_image);
            }else{
                $url = $original;
            }
        }
        if($url == ''){
            $url = $original;
        }
        return $url;
    }
}
if(!function_exists("professionalDetail")){
    function professionalDetail($domain = ''){
        if($domain == ''){
            $domain = \Session::get("subdomain");
        }
        $database = PROFESSIONAL_DATABASE.$domain;
        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?";
        $db = DB::select($query, [$database]);

        if (!empty($db)) {
            $user = DB::table($database.".professional_details")->first();
            return $user;
        }else{
            return array();
        }
    }
}
if(!function_exists("professionalLogo")){
    function professionalLogo($size='r',$domain = ''){
        if($domain == ''){
            $domain = \Session::get("subdomain");
        }
        $user = DB::table(PROFESSIONAL_DATABASE.$domain.".professional_details")->first();
        $profile_image = $user->company_logo;
        $profile_dir = professionalDir($domain)."/profile/".$profile_image;
        if($profile_image == '' || !file_exists($profile_dir)){
            $url = asset("public/uploads/users/default.jpg");
            return $url;
        }
        $original = asset("public/uploads/professional/".$domain."/profile/".$profile_image);
        $url = '';
        if($size == 'r'){
            $url = asset("public/uploads/professional/".$domain."/profile/".$profile_image);
        }
        if($size == 'm'){
            if(file_exists(professionalDir($domain)."/profile/medium/".$profile_image)){
                $url = asset("public/uploads/professional/".$domain."/profile/medium/".$profile_image);
            }else{
                $url = $original;
            }
        }
        if($size == 't'){
            if(file_exists(professionalDir($domain)."/profile/thumb/".$profile_image)){
                $url = asset("public/uploads/professional/".$domain."/profile/thumb/".$profile_image);
            }else{
                $url = $original;
            }
        }
        if($url == ''){
            $url = $original;
        }
        return $url;
    }
}
if(!function_exists("userDir")){
    function userDir($unique_id = ''){
        if($unique_id == ''){
            $unique_id = \Auth::user()->unique_id;
        }
        $dir = public_path("uploads/users/".$unique_id);

        return $dir;
    }
}

if(!function_exists("userDirUrl")){
    function userDirUrl($unique_id = ''){
        if($unique_id == ''){
            $unique_id = \Auth::user()->unique_id;
        }
        $dir = asset("public/uploads/users/".$unique_id);
        
        return $dir;
    }
}
if(!function_exists("userProfile")){
    function userProfile($unique_id = '',$size='r'){
        
        if($unique_id == ''){
           $unique_id = \Auth::user()->unique_id;
        }
        $user = DB::table(MAIN_DATABASE.".users")
                ->where("unique_id",$unique_id)
                ->first();
        $profile_image = $user->profile_image;
        $profile_dir = userDir($unique_id)."/profile/".$profile_image;
        if($profile_image == '' || !file_exists($profile_dir)){
            $url = asset("public/uploads/users/default.jpg?u=".$unique_id);
            return $url;
        }
        $original = asset("public/uploads/users/".$unique_id."/profile/".$profile_image);
        $url = '';
        if($size == 'r'){
            $url = asset("public/uploads/users/".$unique_id."/profile/".$profile_image);
        }
        if($size == 'm'){
            if(file_exists(userDir($unique_id)."/profile/medium/".$profile_image)){
                $url = asset("public/uploads/users/".$unique_id."/profile/medium/".$profile_image);
            }else{
                $url = $original;
            }
        }
        if($size == 't'){
            if(file_exists(userDir($unique_id)."/profile/thumb/".$profile_image)){
                $url = asset("public/uploads/users/".$unique_id."/profile/thumb/".$profile_image);
            }else{
                $url = $original;
            }
        }
        if($url == ''){
            $url = $original;
        }
        return $url;
    }
}
if(!function_exists("superAdminDir")){
    function superAdminDir(){

        $dir = public_path("uploads/admin");

        return $dir;
    }
}

if(!function_exists("superAdminDirUrl")){
    function superAdminDirUrl(){

        $dir = asset("public/uploads/admin");
        
        return $dir;
    }
}
if(!function_exists("superAdminProfile")){
    function superAdminProfile($unique_id = '',$size='r'){
        
        if($unique_id == ''){
            $unique_id = \Auth::user()->unique_id;
        }
        
        $user = DB::table(MAIN_DATABASE.".users")->where("unique_id",$unique_id)->first();
        $profile_image = $user->profile_image;
        $profile_dir = superAdminDir()."/profile/".$profile_image;
        if($profile_image == '' || !file_exists($profile_dir)){
            $url = asset("public/uploads/users/default.jpg");
            return $url;
        }
        $original = superAdminDirUrl()."/profile/".$profile_image;
        $url = '';
        if($size == 'r'){
            $url = superAdminDirUrl()."/profile/".$profile_image;
        }
        if($size == 'm'){
            if(file_exists(superAdminDir()."/profile/medium/".$profile_image)){
                $url = superAdminDirUrl()."/profile/medium/".$profile_image;
            }else{
                $url = $original;
            }
        }
        if($size == 't'){
            if(file_exists(superAdminDir()."/profile/thumb/".$profile_image)){
                $url = superAdminDirUrl()."/profile/thumb/".$profile_image;
            }else{
                $url = $original;
            }
        }
        if($url == ''){
            $url = $original;
        }
        return $url;
    }
}
if(!function_exists("docChatSendBy")){
    function docChatSendBy($send_by,$user_id,$subdomain=''){
        if($send_by == 'client'){
            $user = DB::table(MAIN_DATABASE.".users")->where("unique_id",$user_id)->first();
        }else{
            if($subdomain == ''){
                $subdomain = \Session::get("subdomain");
            }
            $user = DB::table(PROFESSIONAL_DATABASE.$subdomain.".users")->where("unique_id",$user_id)->first();
        }
        return $user;
    }
}

if(!function_exists("role_permission")){
    function role_permission($module,$action,$role=''){
        if($role == ''){
            $role = \Auth::user()->role;
        }
        $check_exists = RolePrivileges::where("role",$role)->where("module",$module)->where("action",$action)->count();
        if($check_exists > 0){
            return true;
        }else{
            return false;
        }
    }
}
if(!function_exists("sendNotification")){
    function sendNotification($data,$send_to,$subdomain=''){
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['updated_at'] = date("Y-m-d H:i:s");

        $other_data = array();
        if(isset($data['other_data'])){
            $other_data = $data['other_data'];
            unset($data['other_data']);
        }
        if($send_to == 'professional'){
            if($subdomain == ''){
                $subdomain = \Session::get("subdomain");
            }
            DB::table(PROFESSIONAL_DATABASE.$subdomain.".notifications")->insert($data);

            if(!empty($other_data)){
                $id = DB::getPdo()->lastInsertId();
                foreach($other_data as $value){
                    $ins_data['meta_key'] = $value['key'];
                    $ins_data['meta_value'] = $value['value'];
                    $ins_data['notification_id'] = $id;
                    $ins_data['send_by'] = $data['send_by'];
                    $ins_data['added_by'] = $data['added_by'];
                    $ins_data['created_at'] = date("Y-m-d H:i:s");
                    $ins_data['updated_at'] = date("Y-m-d H:i:s");
                    DB::table(PROFESSIONAL_DATABASE.$subdomain.".notification_data")->insert($ins_data);    
                }
            }
        }else{
            DB::table(MAIN_DATABASE.".notifications")->insert($data);
            if(!empty($other_data)){
                $id = DB::getPdo()->lastInsertId();
                foreach($other_data as $value){
                    $ins_data['meta_key'] = $value['key'];
                    $ins_data['meta_value'] = $value['value'];
                    $ins_data['notification_id'] = $id;
                    $ins_data['send_by'] = $data['send_by'];
                    $ins_data['added_by'] = $data['added_by'];
                    $ins_data['created_at'] = date("Y-m-d H:i:s");
                    $ins_data['updated_at'] = date("Y-m-d H:i:s");
                    DB::table(MAIN_DATABASE.".notification_data")->insert($ins_data);    
                }
            }
        }
        return true;
    }
}
if(!function_exists("chatNotifications")){
    function chatNotifications(){
        $notifications = array();
        
        if(\Session::get("login_to") == 'professional_panel'){
            $notifications = Notifications::where('type','chat')
                        ->whereDoesntHave("Read")
                        ->where("added_by","!=",\Auth::user()->unique_id)
                        ->orderBy("id","desc")
                        ->get();
        }else{
            $notifications = Notifications::where('type','chat')
                        ->whereDoesntHave("Read")
                        ->where("user_id",\Auth::user()->unique_id)
                        ->where("added_by","!=",\Auth::user()->unique_id)
                        ->orderBy("id","desc")
                        ->get();
        }
        return $notifications;
    }
}
if(!function_exists("otherNotifications")){
    function otherNotifications(){
        $notifications = array();
        
        if(\Session::get("login_to") == 'professional_panel'){
            $notifications = Notifications::where('type','other')
                        ->whereDoesntHave("Read")
                        ->where("added_by","!=",\Auth::user()->unique_id)
                        ->orderBy("id","desc")
                        ->get();
        }else{
            $notifications = Notifications::where('type','other')
                        ->whereDoesntHave("Read")
                        ->where("user_id",\Auth::user()->unique_id)
                        ->where("added_by","!=",\Auth::user()->unique_id)
                        ->orderBy("id","desc")
                        ->get();
        }
        return $notifications;
    }
}
if (! function_exists('getCityName')) {
    function getCityName($id) {
        $cityName = Cities::where('id',$id)->first();
        return $cityName->name;
    }
}

if (! function_exists('getStateName')) {
    function getStateName($id) {
        $stateName = States::where('id',$id)->first();
        return $stateName->name;
    }
}

if (! function_exists('getCountryName')) {
    function getCountryName($id) {
        $countryName = Countries::where('id',$id)->first();
        return $countryName->name;
    }
}

if(!function_exists("employee_permission")){
    function employee_permission($module,$action,$user_id=''){
        if($user_id == ''){
            $user_id = \Auth::user()->id;
        }
        $check_exists = StaffPrivileges::where("user_id",$user_id)->where("module",$module)->where("action",$action)->count();
        if($check_exists > 0){
            return true;
        }else{
            return false;
        }
    }
}


if(!function_exists("cv_progress")){
    function cv_progress($module='',$user_id=''){
        if($user_id == ''){
            $user_id = \Auth::user()->unique_id;
        }
        $language_proficiency = LanguageProficiency::where("user_id",$user_id)->count();
        $work_expirence = ClientExperience::where("user_id",$user_id)->orderBy('id','desc')->count();
        $educations = ClientEducations::where("user_id",$user_id)->orderBy('id','desc')->count();
        $count = 1;
        if($language_proficiency > 0){
            $count++;
        }
        if($work_expirence > 0){
            $count++;
        }
        if($educations > 0){
            $count++;
        }
        $total = 4;

        $percentage = ($count/$total)*100;
        if($module == ''){
            return $percentage;
        }else{
            if($module == 'language_proficiency'){
                return $language_proficiency;
            }   
            if($module == 'work_expirences'){
                return $work_expirence;
            }  
            if($module == 'educations'){
                return $educations;
            }  
        }
        
    }
}

if(!function_exists("profession_profile")){
    function profession_profile(){
        $setting = DomainDetails::first();
        if($setting->profile_status == 2){
            return true;
        }else{
            return false;
        }
    }
}
if(!function_exists("generateUUID")){
    function generateUUID(){
        $uuid = Str::uuid()->toString();
        return $uuid;
    }
}

if(!function_exists("google_doc_viewer")){
    function google_doc_viewer($ext){
        $extensions = array("doc","docx","xlsx","xls");
        if(in_array($ext,$extensions)){
            return true;
        }else{
            return false;
        }
    }
}
if(!function_exists("site_url")){
    function site_url(){
        if($_SERVER['HTTP_HOST'] == 'localhost'){
            $url = url('/');
        }else{
            $domain = get_domaininfo(url('/'));
            $url = "http://".$domain['domain'];
        }
        return $url;
    }
}
if(!function_exists("google_auth_url")){
    function google_auth_url(){
        
        $client = new Google_Client();
        $config_file = base_path("library/google-api/credentials.json");
        $client->setAuthConfigFile($config_file);
        $gurl = site_url().'/google-callback';
        
        $client->setRedirectUri($gurl);
        $client->addScope("https://www.googleapis.com/auth/userinfo.profile");
        $client->addScope("https://www.googleapis.com/auth/userinfo.email");
        $client->addScope(Google_Service_Drive::DRIVE_FILE);
        $client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
        $client->addScope(Google_Service_Drive::DRIVE_PHOTOS_READONLY);
        $client->addScope(Google_Service_Drive::DRIVE_READONLY);
        $client->setAccessType('offline');
        $client->setState($_SERVER['HTTP_HOST']);

        $data = array();
        $url = $client->createAuthUrl();
       
        return $url;
    } 
}  
if(!function_exists("google_callback")){
    function google_callback($code){
        $server_arr = explode('.', $_SERVER['HTTP_HOST']);
        array_shift($server_arr);
        $gurl = site_url().'/google-callback';
        $client = new Google_Client();
        
        $config_file = base_path("library/google-api/credentials.json");
        $client->setAuthConfigFile($config_file);
        $client->setRedirectUri($gurl);
        $client->addScope("https://www.googleapis.com/auth/userinfo.profile");
        $client->addScope("https://www.googleapis.com/auth/userinfo.email");
        $client->addScope(Google_Service_Drive::DRIVE_FILE);
        $client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
        $client->addScope(Google_Service_Drive::DRIVE_PHOTOS_READONLY);
        $client->setAccessType('offline');
        $client->authenticate($code);
        $access_token = $client->getAccessToken();
        if(!isset($access_token['error'])){
            $client->setAccessToken($access_token['access_token']);
            $google_service = new Google_Service_Oauth2($client);
            $user_info = $google_service->userinfo->get();
            if(isset($user_info['email'])){
                $response['user_email'] = $user_info['email'];
                $response['access_token'] = $access_token;    
            }else{
                $response['status'] = "failed";
            }
        }else{
            $response['status'] = "failed";
        }
        return $response;
        
    }
}

if(!function_exists("get_domaininfo")){
    function get_domaininfo($url){
        preg_match("/^(https|http|ftp):\/\/(.*?)\//", "$url/" , $matches);
        $parts = explode(".", $matches[2]);
        $tld = array_pop($parts);
        $host = array_pop($parts);
        if ( strlen($tld) == 2 && strlen($host) <= 3 ) {
            $tld = "$host.$tld";
            $host = array_pop($parts);
        }
        if($_SERVER['HTTP_HOST'] == 'localhost'){
            $domain = "localhost";
        }else{
            $domain = "$host.$tld";
        }
        return array(
            'protocol' => $matches[1],
            'subdomain' => implode(".", $parts),
            'domain' => $domain,
            'host'=>$host,'tld'=>$tld
        );
    }
}
if(!function_exists("get_gdrive_folder")){
    function get_gdrive_folder($drive,$f_id='',$folder='') {
        try {
            $data = array();
            $data['gdrive_files'] = array();
            $pageToken = null;
            $query = '';

            $mime_types = '';
            if ($folder == '1') {
                $mime_types = "(mimeType = 'application/vnd.google-apps.folder')";
            } else {
                $mime_types= array(
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'application/pdf',
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                    'image/bmp',
                    'text/plain',
                    'application/msword',
                    'application/octet-stream',
                    'application/vnd.google-apps.folder'
                );
                $types = array();
                for($i=0;$i < count($mime_types);$i++){
                    $types[] = "mimeType = '".$mime_types[$i]."'";
                }
                $m_types = implode(" or ",$types);
                $mime_types = "($m_types)";
                // echo $m_types;
                // exit;
                // $mime_types = "(mimeType = 'application/vnd.google-apps.folder' or mimeType = 'image/jpeg' or mimeType = 'image/png' or mimeType = 'image/jpg' or mimeType = 'image/heif')";
                // $mime_types = "(mimeType = 'application/vnd.ms-excel' or mimeType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' or mimeType = 'application/pdf' or mimeType = 'image/jpeg' or mimeType = 'image/png' or mimeType = 'image/gif' or mimeType = 'image/bmp' or mimeType = 'text/plain' or mimeType = 'application/msword' or mimeType = 'application/octet-stream' or mimeType = 'application/vnd.google-apps.folder')";
            }

            if ($f_id != '') {
                $query = "parents = '" . $f_id . "' and " . $mime_types . " and trashed = false";
            } else {
                $query = "parents = 'root' and " . $mime_types . " and trashed = false";
            }
            // echo $f_id;
            do {
                $response = $drive->files->listFiles(array(
                    'q' => $query,
                    'spaces' => 'drive',
                    'pageSize'=>500,
                    'pageToken' => $pageToken,
                    'fields' => 'nextPageToken, files(id, name, parents, mimeType, description, thumbnailLink)',
                    'orderBy' => 'folder, name'
                ));
                
                foreach ($response->files as $file) {
                    
                    $data['gdrive_files'][] = array(
                        'id' => $file->id,
                        'name' => $file->getName(),
                        'description' => $file->getDescription(),
                        'mimetype' => $file->getMimeType(),
                        'thumbnailLink' => "https://drive.google.com/thumbnail?id=".trim($file->id),
                        'parents' => $file->parents[0]
                    );
                }
                $pageToken = $response->pageToken;
            } while ($pageToken != null);
            return $data;
        } catch (Exception $e) {
            pre($e->getMessage());
        }
    }
}
if(!function_exists("create_crm_gservice")){
    function create_crm_gservice($access_token) {
        try {
            $gurl = site_url().'/google-callback';
            $client = new Google_Client();
            $config_file = base_path("library/google-api/credentials.json");
            $client->setAuthConfigFile($config_file);
            $client->setRedirectUri($gurl);
            
            $client->addScope("https://www.googleapis.com/auth/userinfo.profile");
            $client->addScope("https://www.googleapis.com/auth/userinfo.email");
            $client->addScope(Google_Service_Drive::DRIVE_FILE);
            $client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
            $client->addScope(Google_Service_Drive::DRIVE_PHOTOS_READONLY);

            if (isset($access_token['access_token'])) {
                if ($client->isAccessTokenExpired()) {
                    $client->refreshToken($access_token['refresh_token']);
                    $client->setAccessToken($access_token['access_token']);
                }else{
                    $client->setAccessToken($access_token['access_token']);
                }
                $drive = new Google_Service_Drive($client);
                return $drive;
            } else {
                $client->refreshToken($access_token['refresh_token']);
                $access_token['access_token'] = $client->getAccessToken();
             
                $client->setAccessToken($access_token['access_token']);
                $drive = new Google_Service_Drive($client);
                return $drive;
            }
        } catch (Exception $e) {
            pre($e->getMessage());
        }
    }
}
if(!function_exists("refresh_google_token")){
    function refresh_google_token() {
        try {
            $user_details = UserDetails::where("user_id",\Auth::user()->unique_id)->first();
            if(empty($user_details->google_drive_auth)){
                return false;
            }
            $gurl = site_url().'/google-callback';
            $client = new Google_Client();
            $config_file = base_path("library/google-api/credentials.json");
            $client->setAuthConfigFile($config_file);
            $client->setRedirectUri($gurl);
            
            $client->addScope("https://www.googleapis.com/auth/userinfo.profile");
            $client->addScope("https://www.googleapis.com/auth/userinfo.email");
            $client->addScope(Google_Service_Drive::DRIVE_FILE);
            $client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
            $client->addScope(Google_Service_Drive::DRIVE_PHOTOS_READONLY);
            $google_drive_auth = json_decode($user_details->google_drive_auth,true);
            $access_token = $google_drive_auth['access_token'];
            
            if(isset($access_token['access_token'])){
                if ($client->isAccessTokenExpired()) {
                    $client->refreshToken($access_token['refresh_token']);
                    $access_token = $client->getAccessToken();

                    $google_drive_auth['access_token']['access_token'] = $access_token['access_token'];
                    $updata['google_drive_auth'] = json_encode($google_drive_auth);
                 
                    UserDetails::where("user_id",\Auth::user()->unique_id)->update($updata);
                }
            }
            $response['status'] = "success";
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = "Error while refresh google account";
        }
    }
}

if(!function_exists("google_auth_url")){
    function google_auth_url(){
        
        $client = new Google_Client();
        $config_file = base_path("library/google-api/credentials.json");
        $client->setAuthConfigFile($config_file);
        $gurl = site_url().'/google-callback';
        
        $client->setRedirectUri($gurl);
        $client->addScope("https://www.googleapis.com/auth/userinfo.profile");
        $client->addScope("https://www.googleapis.com/auth/userinfo.email");
        $client->addScope(Google_Service_Drive::DRIVE_FILE);
        $client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
        $client->addScope(Google_Service_Drive::DRIVE_PHOTOS_READONLY);
        $client->addScope(Google_Service_Drive::DRIVE_READONLY);
        $client->setAccessType('offline');
        $client->setState($_SERVER['HTTP_HOST']);

        $data = array();
        $url = $client->createAuthUrl();
       
        return $url;
    } 
}  

if(!function_exists("dropbox_auth_url")){
    function dropbox_auth_url(){
        $dropbox = new DropboxClient(array(
            'app_key' => env('DROPBOX_APP_KEY'),
            'app_secret' => env('DROPBOX_APP_SECRET'),
            'app_full_access' => true,
        )); 
        // $return_url = "https://" . $url . "/login/dropbox_return/?auth_redirect=1";
        $return_url = site_url().'/dropbox-callback';
        $url = $dropbox->BuildAuthorizeUrl($return_url, $_SERVER['HTTP_HOST']);
        return $url;
    }
}
if(!function_exists("dropbox_callback")){
    function dropbox_callback($code){
        try{
            $dropbox = new DropboxClient(array(
                'app_key' => env('DROPBOX_APP_KEY'),
                'app_secret' => env('DROPBOX_APP_SECRET'),
                'app_full_access' => true,
            )); 
            $server_arr = explode('.', $_SERVER['HTTP_HOST']);
            array_shift($server_arr);
            $url = implode('.', $server_arr);
            $return_url = site_url().'/dropbox-callback';
            $bearer_token = $dropbox->GetBearerToken($code, $return_url);
            $account = $dropbox->getAccountInfo();
            if(isset($account->email)){
                $response['user_email'] = $account->email;
                $response['dropbox_account_id'] = $account->account_id;
                
                $response['access_token'] = $bearer_token;    
            }else{
                $response['status'] = "failed";
                $response['message'] = "Dropbox linking failed. Try again.";
            }
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return $response;
    }
}

if(!function_exists("dropbox_files_list")){
    function dropbox_files_list($access_token,$path=''){
        try{
            $dropbox = new DropboxClient(array(
                'app_key' => env('DROPBOX_APP_KEY'),
                'app_secret' => env('DROPBOX_APP_SECRET'),
                'app_full_access' => true,
            )); 
            $bearer_token = array();
            $bearer_token['t'] = $access_token['access_token']['t'];
            $bearer_token['account_id'] = $access_token['dropbox_account_id'];
            $dropbox->SetBearerToken($bearer_token);
            $files = $dropbox->GetFiles($path, false);
            $dropbox_array = array();
            $i = 0;
            $us = $dropbox->getAccountInfo();
            
            $extenstion_array = array("JPG", "jpg", "PNG", "png", "jpeg", "JPEG");
            foreach ($files as $key => $value) {
                $name = $value->name;
                $extenstion = explode('.', $name);
                
                // if ($value->is_dir || in_array(end($extenstion), $extenstion_array)) {
                    
                   
                    $dropbox_array[$i] = (array) $value;
                    if($dropbox_array[$i]['.tag'] == 'file'){
                        $filelink = $dropbox->GetLink($value, false);
                        // pre($value->id);
                        // echo $filelink."<br>";
                        // echo $filelink."<br>";
                        // echo "https://dl.dropboxusercontent.com/s/".$value->id."/".$value->name."<br>";
                        $dropbox_array[$i]['download_link'] = $filelink;
                    }
                    $i++;
                // }
            }
            $response['status'] = "success";
            $response['dropbox_files'] = $dropbox_array;
          
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return $response;
    }
}
if(!function_exists("dropbox_file_download")){
    function dropbox_file_download($access_token,$source_path,$destination){
        try{
            $dropbox = new DropboxClient(array(
                'app_key' => env('DROPBOX_APP_KEY'),
                'app_secret' => env('DROPBOX_APP_SECRET'),
                'app_full_access' => true,
            )); 
            $bearer_token = array();
            $bearer_token['t'] = $access_token['access_token']['t'];
            $bearer_token['account_id'] = $access_token['dropbox_account_id'];
            $dropbox->SetBearerToken($bearer_token);
            $files = $dropbox->DownloadFile($source_path, $destination);
            
            $response['status'] = "success";
            $response['dropbox_files'] = $files;
          
        } catch (Exception $e) {
            $response['status'] = "error";
            $response['message'] = $e->getMessage();
        }
        return $response;
    }
}
if(!function_exists("site_url")){
    function site_url($site_url){
        $domain = get_domaininfo(url('/'));
        if($_SERVER['HTTP_HOST'] == 'localhost'){
            $domain = "localhost";
            $url = url('/');
        }else{
            $url = "http://".$domain['domain']."/";
        }
        
        return $url;
    }
}

if(!function_exists("professionalService")){
    function professionalService($subdomain,$service_id){
        $service = DB::table(PROFESSIONAL_DATABASE.$subdomain.".professional_services")->where("service_id",$service_id)->first();
        if(!empty($service)){
            return $service;
        }else{
            return array();
        }
    }
}
