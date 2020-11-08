<?php
require dirname(__DIR__)."/../library/subdomain/init.php";
require dirname(__DIR__)."/../library/twilio/twilio.php";

use App\Models\Settings;
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
        $icon = "<i class='fa fa-file-code-o fa-2x'></i>";
        if(in_array($ext,array("doc","docx"))){
            $icon = "<i class='fa fa-file-word-o fa-2x'></i>";
        }
        if(in_array($ext,array("xls","xlsx"))){
            $icon = "<i class='fa fa-file-word-o fa-2x'></i>";
        }
        if(in_array($ext,array("pdf"))){
            $icon = "<i class='fa fa-file-pdf-o fa-2x'></i>";
        }
        if(in_array($ext,array("jpg","jpeg","png","gif"))){
            $icon = "<i class='fa fa-file-image-o fa-2x'></i>";
        }
        return $icon;
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
        $netbanking = Netbanking::get();
        return $netbanking;
    }
}

if(!function_exists("WalletList")){
    function WalletList() { 
        $wallet_list = WalletList::get();
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
if(!function_exists("getNotificationByType")){
    function getNotificationByType($meta_key,$meta_value){
        $notifications = NotificationData::where("user_id",\Auth::user()->id)
                            ->where("is_read",0)
                            ->where("meta_key",$meta_key)
                            ->where("meta_value",$meta_value)
                            ->count();
        $response['count'] = $notifications;
        return $notifications;

   }
}
if(!function_exists("markAsRead")) {
    function markAsRead($type){
        try{

            if(!is_array($type)){
                $types[] = $type;
            }else{
                $types = $type;
            }
            

            $ids = Notifications::where("user_id",\Auth::user()->id)
                            ->where("is_read",0)
                            ->whereIn("type",$types)
                            ->pluck('id');
                 
            if(count($ids) > 0){
                $ids = $ids->toArray();
                $data['is_read'] = 1;
                $notifications = Notifications::where("user_id",\Auth::user()->id)
                            ->where("is_read",0)
                            ->whereIn("type",$types)
                            ->update($data);

                $notifications = NotificationData::where("user_id",\Auth::user()->id)
                            ->where("is_read",0)
                            ->whereIn("notification_id",$ids)
                            ->update($data);
            }
            $response['status'] = true;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return $response;
   }
}
if(! function_exists('setNotification')){
    function setNotification($type,$title,$comment,$user_id,$url = '',$otherData = array()){
        try{

            $object = new Notifications();
            $object->type = $type;
            $object->title = $title;
            $object->comment = $comment;
            $object->user_id = $user_id;
            $object->url = $url;
            $object->is_read=0;
            $object->save();
            $id = $object->id;
            if(count($otherData) > 0){

                foreach($otherData as $data){
                
                    $object2 = new NotificationData();
                    $object2->notification_id = $id;
                    $object2->user_id = $user_id;
                    $object2->meta_key = $data['meta_key'];
                    $object2->meta_value = $data['meta_value'];
                    $object2->save();
                }
            }
            $response['status'] = true;
            $response['message'] = "Notification added successfully";

        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return $response;
        
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
    function randomNumber($n=8) { 
        $characters = '0123456789'; 
        $randomString = ''; 
      
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
      
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
                'user'       => 'immigrat_casestudy',
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
        $client_key = ApiKeys::first();
        // $subdomain = array_first(explode('.', request()->getHost()));
        $host = explode('.', request()->getHost());
        $subdomain = $host[0];
        if($subdomain == 'localhost'){
            $api_url = url('/api');
        }else{
            $api_url = "http://immigratly.com/api";
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
       
        $curl_response = json_decode($response);
        
        if($curl_response->status == 'api_error'){
            if($curl_response->error == 'account_disabled'){
                Auth::logout();
            }
        }
        return $curl_response;
    }
}

if(!function_exists("userApi")){
    function userApi($url,$data=array()){
        $client_key = ApiKeys::first();
        $subdomain = array_first(explode('.', request()->getHost()));
        $api_url = userPanelUrl()."/api/user";

        $token = 'MlyOAzpD8JpLMFhG82Bd4eLPjkAzyLOlbrEMuHnmW0SH0ps7rl';
        $ch = curl_init($api_url."/".$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
           'Content-Type: application/json',
           'Authorization:' . $token
        ));
        curl_setopt($ch, CURLOPT_POST, 1);

        if(count($data) > 0){
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
       
        $curl_response = json_decode($response);
        if($curl_response->status == 'api_error'){
            if($curl_response->error == 'account_disabled'){
                Auth::logout();
            }
        }
        return $curl_response;
    }
}

if(!function_exists("mainApi")){
    function mainApi($url,$data=array()){
        $client_key = ApiKeys::first();
        $subdomain = array_first(explode('.', request()->getHost()));
        $api_url = userPanelUrl()."/api/main";

        $token = 'MlyOAzpD8JpLMFhG82Bd4eLPjkAzyLOlbrEMuHnmW0SH0ps7rl';
        $ch = curl_init($api_url."/".$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
           'Content-Type: application/json',
           'Authorization:' . $token
        ));
        curl_setopt($ch, CURLOPT_POST, 1);

        if(count($data) > 0){
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
      
        $curl_response = json_decode($response);
        if($curl_response->status == 'api_error'){
            if($curl_response->error == 'account_disabled'){
                Auth::logout();
            }
        }else{
            if($curl_response->status != 'success'){
                echo $response;
                exit;
            }
        }
        return $curl_response;
    }
}
if(!function_exists("professionalApi")){
    function professionalApi($url,$professional_id,$data=array()){
        $professional = ProfessionalPanel::where("user_id",$professional_id)->first();
        $host = explode('.', request()->getHost());
        $subdomain = $host[0];
        if($subdomain == 'localhost'){
            $api_url = url('/api/professional');
        }else{
            $api_url = "https://immigratly.com/api/professional";
        }

        $token = $professional->client_secret;
    
        $ch = curl_init($api_url."/".$url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
           'Content-Type: application/json',
           'subdomain:'.$professional->subdomain,
           'callfor:professional',
           'Authorization:' . $token
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        if(count($data) > 0){
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        $response = curl_exec($ch);
        
        $info = curl_getinfo($ch);
        curl_close($ch);
       
        $curl_response = json_decode($response);
       
        if($curl_response->status == 'api_error'){
            if($curl_response->error == 'account_disabled'){
                Auth::logout();
            }
        }
        return $curl_response;
    }
}
if(!function_exists("domain")){
    function domain(){
        if($_SERVER['SERVER_NAME'] == 'localhost'){
            $domain = url('/');
        }else{
            $domain = 'https://immigratly.com';
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