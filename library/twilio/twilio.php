<?php
require_once __DIR__."/autoload.php";
use Twilio\Rest\Client;
Class TwilioApi{
	var $sid;
	var $token;
	var $acid;
	public function __construct($sid,$token,$acid)
    {
        $this->sid    = $sid;
		$this->token  = $token;
		$this->acid   = $acid;
    }

    public function verifyPhone($mobileno){
    	try{	
			$sid    = $this->sid;
			$token  = $this->token;
			$acid   = $this->acid;
			$twilio = new Client($acid, $token);

			$service = $twilio->verify->v2->services->create("Immigratly");
			$verification = $twilio->verify->v2->services($service->sid)
			                                   ->verifications
			                                   ->create($mobileno, "sms");
			$response['status'] = true;
			$response['verify_code'] = $verification->sid;
			$response['service_code'] = $service->sid;
			$response['message'] = "OTP send to your mobile number";
		} catch (Exception $e) {
		    $response['status'] = false;
		    $response['message'] = $e->getMessage();
		}
		return $response;
    }

    public function verifyCode($service_code,$verify_code,$phone){

    	try{	
			$sid    = $this->sid;
			$token  = $this->token;
			$acid   = $this->acid;
			$twilio = new Client($acid, $token);
			// $verification = $twilio->verify->v2->services($service_code)
   //                                 ->verifications($verify_code)
   //                                 ->fetch();
			
            $verification_check = $twilio->verify->v2->services($service_code)
                                         ->verificationChecks
                                         ->create($verify_code,
                                                  ["to" => $phone]
                                         );
            if($verification_check->status == 'approved'){
            	$response['status'] = true;
				$response['message'] = "OTP verified successfully";	
            }else{
            	$response['status'] = false;
				$response['message'] = "Invalid OTP entered";	
            }
		} catch (Exception $e) {
		    $response['status'] = false;
		    $response['message'] = $e->getMessage();
		}
		return $response;
    }

    public function sendWhatsMessage($parameter){
    	$sid    = $this->sid;
		$token  = $this->token;
		$twilio = new Client($sid, $token);
		$message = $twilio->messages
                          ->create("whatsapp:".$parameter['phone_no'], // to
                                   [
                                       "from" => "whatsapp:+123456780",
                                       "body" => "Hello there!"
                                   ]
                          );
      pre($message);
        exit;
        print($message->sid);
    }
}
