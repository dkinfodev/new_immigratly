<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Models\BackupSettings;
use App\Models\User;
use App\Models\FilesManager;

class CronController extends Controller
{
    public function __construct(Request $request)
    {
    	
    }

    public function backupFilesToGdrive(){
        $back_settings = BackupSettings::where('gdrive_duration',"!=","none")->get();
        foreach($back_settings as $setting){
            $user = User::where('unique_id',$setting->user_id)->first();
            if(!empty($user)){
               
                $last_sync_time = $setting->gdrive_last_sync;
                $current_date = date("Y-m-d");
                $flag = 0;
                if($last_sync_time != ''){
                    if($setting->gdrive_duration == 'daily'){
                        $last_sync_date = date("Y-m-d",strtotime($last_sync_time));
                        $diff = date_difference($last_sync_time,$current_date);
                        if($diff > 0){
                            $flag = 1;
                        }
                    }
                    
                    if($setting->gdrive_duration == 'weekly'){
                        $week_day = date('l', strtotime($current_date));
                        $week_day = strtolower($week_day);
                        if($week_day  == 'sunday'){
                            $flag = 1;
                        }
                    }

                    if($setting->gdrive_duration == 'montly'){
                        $last_date = date("Y-m-t", strtotime($current_date));;
                        if($current_date  == $last_date){
                            $flag = 1;
                        }
                    }
                    
                }else{
                    $flag = 1;
                }
                if($flag == 1){
                    if($setting->gdrive_parent_folder != ''){
                        $gdrive_parent_folder = $setting->gdrive_parent_folder;
                    }else{
                        $gdrive_parent_folder = create_gdrive_folder("immigratly");
                    }
                    $user_files = FilesManager::where("user_id",$user->unique_id)
                                            ->where(function($query) use($last_sync_time){
                                                if($last_sync_time != ''){
                                                    $query->whereDate("created_at",">=",$last_sync_time);
                                                }
                                            })
                                            ->limit(5)
                                            ->get();
                    
                    foreach($user_files as $file){
                        $file_path = userDir($file->user_id)."/documents/".$file->file_name;
                        if(file_exists($file_path)){
                        
                            $is_success = gdrive_file_export($file_path,$file->original_name,$gdrive_parent_folder);
                            if($is_success){
                                echo "<h1>Success</h1> File Uploaded Successfully <Br>";
                            }else{
                                echo "<h1>Error</h1> File Uploaded Failed <Br>";
                            }
                        }
                    }
                    $last_sync_time = date("Y-m-d H:i:s");
                    $update['gdrive_last_sync'] = $last_sync_time;
                    BackupSettings::where("id",$setting->id)->update($update);
                }
            }
        }
        
    }
}
