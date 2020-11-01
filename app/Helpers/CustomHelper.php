<?php
require dirname(__DIR__)."/../library/subdomain/init.php";
require dirname(__DIR__)."/../library/twilio/twilio.php";
// require dirname(__DIR__)."/../library/mailgun/vendor/autoload.php";
// use Mailgun\Mailgun;
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


if(!function_exists("categoryCaseStudy")){
    function categoryCaseStudy($category_name){
        $case_study = CaseStudy::whereRaw("find_in_set('".$category_name."',category)")->count();
        return $case_study;
    }
}

if(!function_exists("tagCaseStudy")){
    function tagCaseStudy($tag_name){
        $case_study = CaseStudy::whereRaw("find_in_set('".$tag_name."',tags)")->count();
        return $case_study;
    }
}


if(!function_exists("categoryGeneralNote")){
    function categoryGeneralNote($category_id,$user_id  = ''){
        if($user_id != ''){
            $count = GeneralNoteCategory::with("Note")
                    ->where("category_id",$category_id)
                    ->whereHas("Note",function($query) use($user_id){
                        $query->where("added_by",$user_id);
                    })
                    ->count();
        }else{
            $count = GeneralNoteCategory::where("category_id",$category_id)->count();
        }
        // if($user_id == ''){
        //     $case_study = GeneralNotes::whereRaw("find_in_set('".$category_name."',category)")->count();
        // }else{
        //     $case_study =  GeneralNotes::with('SharedUsers')
        //             ->whereHas("SharedUsers",function($query) use($user_id){
        //                 $query->where("user_id",$user_id);
        //             })
        //             ->whereRaw("find_in_set('".$category_name."',category)")
        //             ->count();
        // }
        return $count;
    }
}

if(!function_exists("tagGeneralNote")){
    function tagGeneralNote($tag_id,$user_id=''){
        // if($user_id == ''){
        //     $case_study = GeneralNotes::whereRaw("find_in_set('".$tag_name."',tags)")->count();
        // }else{
        //     $case_study =  GeneralNotes::whereHas("SharedUsers",function($query) use($user_id){
        //                 $query->where("user_id",$user_id);
        //             })
        //             ->whereRaw("find_in_set('".$tag_name."',tags)")
        //             ->count();
        // }
        if($user_id != ''){
            $count = GeneralNoteTags::with("Note")
                    ->where("tag_id",$tag_id)
                    ->whereHas("Note",function($query) use($user_id){
                        $query->where("added_by",$user_id);
                    })
                    ->count();
        }else{
            $count = GeneralNoteTags::where("tag_id",$tag_id)->count();
        }
        return $count;
    }
}


if(!function_exists("publicNotes")){
    function publicNotes(){
        $notes =  GeneralNotes::where("share_with","public")->where("status","publish")->get();
        return $notes;
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

if(!function_exists("isEventBooked")){
    function isEventBooked($event_id,$user_id,$author_id) { 
        $is_booked = EventBooked::where('event_id',$event_id)
                    ->where('user_id',$user_id)
                    ->where("author_id",$author_id)
                    ->count();
        return $is_booked;
    }
}

if(!function_exists("isServiceBooked")){
    function isServiceBooked($service_id,$user_id,$author_id) { 
        $is_booked = ServiceBooked::where('service_id',$service_id)
                    ->where("author_id",$author_id)
                    ->where('user_id',$user_id)->count();
        return $is_booked;
    }
}

if(!function_exists("author_slug")){
    function author_slug($author,$return = 'return') { 
        $slug = str_slug($author->first_name."-".$author->last_name)."-".$author->id;
        return $slug;
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
if(!function_exists("isProfileComplete")){
    function isProfileComplete($user_id) { 
        $complete = 1;
        $user = User::where("id",$user_id)->first();
        $education = ClientEducation::where("client_id",$user_id)->count();
        $expirence = ClientExperience::where("client_id",$user_id)->count();
        $lp = LanguageProficency::where("user_id",$user_id)->count();
        if($user->about_author == ''){
            $complete = 0;
        }
        if($education == 0){
            $complete = 0;
        }
        if($expirence == 0){
            $complete = 0;
        }
        if($lp == 0){
            $complete = 0;
        }
        return $complete;
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

if(!function_exists("visaDocumetRequired")){
    function visaDocumetRequired($document_id,$visa_type_id){
        $document = VisaDocuments::where("document_id",$document_id)->where("visa_type_id",$visa_type_id)->first();
        if(!empty($document)){
            return $document->is_required;
        }else{
            return 0;
        }
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


if(!function_exists("fetchTemplate")){
    function fetchTemplate($template_for,$template_type){
        $mail_template = Templates::where("template_for",$template_for)
                        ->where("template_type",$template_type)
                        ->first();
        if(!empty($mail_template)){
            $mail_template = $mail_template->toArray();
        }
        return $mail_template;
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


if(!function_exists("visaDocumetRequired")){
    function visaDocumetRequired($document_id,$visa_type_id){
        $document = VisaDocuments::where("document_id",$document_id)->where("visa_type_id",$visa_type_id)->first();
        if(!empty($document)){
            return $document->is_required;
        }else{
            return 0;
        }
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
if(!function_exists("getVisaType")){
    function getVisaType($id){
        if(is_array($id)){
            $visatype = VisaTypes::whereIn("id",$id)->get();
        }else{
            $visatype = VisaTypes::where("id",$id)->first();
        }
        return $visatype;
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
if(!function_exists("getTemplateType")){
    function getTemplateType() { 
        $types = TemplateType::get();
        return $types;
    }
}

if(!function_exists("getLeadCategory")){
    function getLeadCategory() { 
        $types = LeadCategory::get();
        return $types;
    }
}

if(!function_exists("getCommentTags")){
    function getCommentTags() { 
        $types = LeadCommentTags::get();
        return $types;
    }
}
if(!function_exists("LeadRead")){
    function LeadRead($lead_id) { 
        $read_by = \Auth::user()->id;

        $is_read = isLeadRead($lead_id,$read_by);
        if(count($is_read) <= 0){
            $object = new LeadRead();
            $object->lead_id = $lead_id;
            $object->read_by = $read_by;
            $object->save();
        }
    }
}
if(!function_exists("isLeadRead")){
    function isLeadRead($lead_id,$read_by = '') { 
        // $read_by = \Auth::user()->id;
        $is_read = LeadRead::where("lead_id",$lead_id)
                    ->where(function($query) use($read_by){
                        if($read_by != ''){
                            $query->where("read_by",$read_by);
                        }
                    })
                    ->with("ReadByUser")
                    ->get();
        return $is_read;
    }
}

if(!function_exists("getDocuments")){
    function getDocuments($ids,$type) { 
        $documents = array();
        if($type == 'visa_document'){
            $ids = explode(",",$ids);
            $documents = Documents::whereIn("id",$ids)->get();
        }
        if($type == 'user_document'){
            $ids = explode(",",$ids);
            $documents = OtherDocuments::whereIn("id",$ids)->get();
        }
        return $documents;
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
if(!function_exists("getNotifications")){
    function getNotifications(){
        $notifications = Notifications::where("user_id",\Auth::user()->id)->where("is_read",0)->orderBy('id','desc')->get();
        $viewData['notifications'] = $notifications;
        $view = View::make('layouts.notifications',$viewData);
        $contents = $view->render();

        $response['notifications'] = $contents;
        $response['count'] = count($notifications);
        return $response;

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
if(!function_exists("dropDown")){
    function dropDown($options=array(),$callfrom = 'professional' ){
        $apiData['options'] = $options; 
        if($callfrom == 'user'){
            $curl_response = mainApi("dropdown",$apiData);
        }else{
            $curl_response = curlRequest("dropdown",$apiData);
        }
        if($curl_response->status != 'success'){
            $response['error'] = $curl_response->message;
        }else{
            $response = $curl_response->data;
        }
        return $response;
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
if(!function_exists("userPanelUrl")){
    function userPanelUrl(){
        if($_SERVER['SERVER_NAME'] == 'localhost'){
            $api_url = 'http://localhost/jw/case-study/live-immigrately';
        }else{
            $api_url = 'http://users.immigratly.com';
        }
        return $api_url;
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
if(!function_exists("serviceCategory")){
    function serviceCategory($category_id){
        $apiData['category_id'] = $category_id; 
        $curl_response = curlRequest("service-category",$apiData);
        if($curl_response->status != 'success'){
            $response['error'] = $curl_response->message;
        }else{
            $response = $curl_response->data;
        }
        return $response;
    }
}
if(!function_exists("VisaType")){
    function VisaType($id){
        $apiData['id'] = $id; 
        $curl_response = curlRequest("visa-type",$apiData);
        if($curl_response->status != 'success'){
            $response['error'] = $curl_response->message;
            $data = array();
        }else{
            $data = $curl_response->data;
        }
        return $data;
    }
}

if(!function_exists("serviceDetail")){
    function serviceDetail($apiData,$professional){
        $curl_response = professionalApi("service",$professional,$apiData);
        if($curl_response->status != 'success'){
            $viewData['api_error'] = $curl_response->message;
            $service = array();
        }else{
            $data = $curl_response->data;
            $service = $data;
        }

        return $service;
    }
}
if(!function_exists("authorDetail")){
    function authorDetail($user_id){
        $user = User::with('ProfessionalPanel')->find($user_id);
        return $user;
    }
}

if(!function_exists("serviceInfo")){
    function serviceInfo($service_id){
        $service = Services::where("id",$service_id)->first();
        return $service;
    }
}
if(!function_exists("professionalDomain")){
    function professionalDomain($value,$search_by){
        $data = array();
        if($search_by == 'id'){
            $data = ProfessionalPanel::where("user_id",$value)->first();
            $return = $data->subdomain;
        }
        if($search_by == 'domain'){
            $data = ProfessionalPanel::with(['Company','User'])->where("subdomain",$value)->first();
            $return = $data;
        }
        return $return;
    }
}
if(!function_exists("ServiceWithProfessional")){
    function ServiceWithProfessional($user_id,$professional_id){
        $service = UserServices::where("user_id",$user_id)
                ->where("professional_id",$professional_id)
                ->get();
        return $service;
    }
}
if(!function_exists("generalTags")){
    function generalTags($id){
        if(is_array($id)){
            $tags = GeneralTags::whereIn("id",$id)->get();
        }else{
            $tags = GeneralTags::where("id",$id)->first();
        }
        return $tags;
   }
}
if(!function_exists("emailRequest")){
    function emailRequest($user_id){
        $count = ChangeEmail::where("user_id",$user_id)->count();
        return $count;
   }
}
if(!function_exists("allVisaTypes")){
    function allVisaTypes(){
        $visatypes = VisaTypes::get();
        return $visatypes;
   }
}

if(!function_exists("client_documents")){
    function client_documents($user_id,$document_id,$type){
        $documents = ClientDocuments::where("user_id",$user_id)
                    ->where("document_id",$document_id)
                    ->where("doc_type",$type)
                    ->get();
        return $documents;        
   }
}

if(!function_exists("documents_sharing")){
    function documents_sharing($user_id,$document_id,$professional_id,$type){
        $documents = DocumentsSharing::where("user_id",$user_id)
                    ->where("document_id",$document_id)
                    ->where("professional_id",$professional_id)
                    ->where("doc_type",$type)
                    ->get();
        $final_documents = array();
        // pre($documents->toArray());
        foreach($documents as $doc){
        
            $client_documents = ClientDocuments::where("user_id",$user_id)
                    ->where("id",$doc->user_doc_id)
                    // ->where("professional_id",$professional_id)
                    // ->where("doc_type",$type)
                    ->first();
            $final_documents[] = $client_documents;
        }
        return $final_documents;        
   }
}

if(!function_exists("count_documents")){
    function count_documents($user_id,$document_id,$professional_id,$doc_type){
        $documents = DocumentsSharing::where("user_id",$user_id)
                ->where("document_id",$document_id)
                ->where("professional_id",$professional_id)
                ->where("doc_type",$doc_type)
                ->get();
        return $documents;
   }
}

if(!function_exists("user_assigned_to")){
    function user_assigned_to($user_id,$type){
        $users = LeadAssignedTo::with(['Telecaller','Manager'])
                            ->where("user_id",$user_id)
                            ->where("user_type",$type)
                            ->get();
        return $users;
    }
}

if(!function_exists("professional_admin")){
    function professional_admin(){
        $admin = User::where("role","admin")->first();
        return $admin;
    }
}

if(!function_exists("timeline_stages")){
    function timeline_stages(){
        $timeline_stages = array("Upload Pre Determined Documents","Ask for Documents","Send Documents and Ask for Upload","Send Documents","Send Custom Message","Ask for Payment");
    }
}
if(!function_exists("str_slug")){
    function str_slug($string){
        $slug = Str::slug($string, '-');
        return $slug;
    }
}
if(!function_exists("cv_sections")){
    function cv_sections(){
        $sections = array("age","expirences","education","language");
        return $sections;
    }
}
if(!function_exists("prefill_answer")){
    function prefill_answer($id,$options){
        $question = PredefinedQuestions::where("id",$id)->first();
        $value = '';

        if($question->cv_section == 'age'){
            $bday = new DateTime(\Auth::user()->dob);
            $today = new Datetime(date('Y-m-d'));
            $diff = $today->diff($bday);
            $age = $diff->y;
            foreach($options as $opt){
                if(strpos($opt->value, ':') !== false){
                    $exp_options = explode(":",$opt->value);
                    // pre($exp_options);
                    if($age >= $exp_options[0] && $age <= $exp_options[1]){
                        $value = $opt->value;
                    }
                }

                if($value == '' && strpos($opt->value, '>') !== false){
                    $exp_options = explode(">",$opt->value);
                    
                    if($age >= $exp_options[1]){
                        $value = $opt->value;
                    }
                }
                if($value == '' && strpos($opt->value, '<') !== false){
                    $exp_options = explode("<",$opt->value);
                    
                    if($age <= $exp_options[1]){
                        $value = $opt->value;
                    }
                }

                if($value == ''){
                    if($age == $opt->value){
                        $value = $opt->value;
                    }
                }
            }
        }
        if($question->cv_section == 'education'){
            $education = ClientEducation::where("client_id",\Auth::user()->id)
                            ->where("is_highest_degree","1")
                            ->first();
            if(!empty($education)){
                foreach($options as $opt){
                    if($opt->value == $education->Degree->name){
                        $value = $opt->value;
                    }
                }
            }

        }
        return $value;
    }
}