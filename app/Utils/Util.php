<?php
namespace App\Utils;
use App\Employee;
use App\Appointment;

class Util{


    public function genreateAppointmentOtp($appointment_id)
    {
        $appointment = Appointment::find($appointment_id);
        if($appointment)
        {
            $appointment->update([
                'otp' => rand(11111, 99999)
            ]);
            $otp = $appointment->otp;
            return $otp;
        }
        else{
            return response(['status' => '0', 'message' => 'error', 'error' => [
                'employee' => 'the Appointment is not found'
            ]], 404);
        }
    }

        /**
     * generate sms id to send in request of sms
     * @return SMSID '52d2d256302d2d'
     */
    public function generateSMSID(){
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        $SMSID = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

        return $SMSID;
    }

    /**
     * send sms of otp
     * @param $phone text
     * @param $type enum 'appointment', 'employee'
     * @return $appointment Appointment
     */
    public function sendSMS($phone , $type, $planID=null){
        $SMSID = $this->generateSMSID();

        if($type == 'appointment'){
            $otp = $this->genreateAppointmentOtp($planID);
            $receivePhone = $phone;

        }else if($type == 'employee'){
            $employee = Employee::where('phone', $phone)->first();
            if(!$employee){
                return false;
            }else{
                $receivePhone = $employee->phone;
                $otp = rand(11111, 99999);
                $employee->update([
                    'otp' =>$otp
                ]);
            }

        }else{
            return response()->json(
                [
                    'status' => 0,
                    'msg' => 'you should entery the type',
                ]);
        }
        // API URL
        $url = 'https://smsvas.vlserv.com/VLSMSPlatformResellerAPI/NewSendingAPI/api/SMSSender/SendSMS';

        // Create a new cURL resource
        $ch = curl_init($url);

        // Setup request to send json via POST
        $data = array(
            'UserName'      => 'SphinxatAPI',
            'Password'      => 'w>|*WVHq%3',
            'SMSText'       => 'your code is '. $otp,
            'SMSLang'       => 'E',
            'SMSSender'     => 'AI attend',
            'SMSReceiver'   => $receivePhone,
            'SMSID'         => $SMSID,
        );
        $payload = json_encode($data);
        // $payloadObj = (object) $payload;

        // return $payload;

        // Attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        // Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        // Return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the POST request
        $result = curl_exec($ch);

        // Close cURL resource
        curl_close($ch);
        // return $result;
        return $otp;
    }

    ///firebase notification
  public static function firebaseNotification($tokens, $data = [])
  {

      $registrationIDs = $tokens;

      $fcmMsg = array(
          "title" => $data['title_ar'],
          "title_en" => $data['title_en'] ,
          "body" =>   $data['body_ar'],
          "body_en" => $data['body_en'],
          'click_action' => "",
          'sound' => "default",
          'color' => "#203E78"
      );


     $fcmFields = array(
          'registration_ids' => $registrationIDs,
          'priority' => 'high',
          'notification' => $fcmMsg,
          'data' => $data
      );

      
    //   Ai Attend Key //
    // AAAAMSITzcs:APA91bHKmcfzx1NlySLbUYG_S4sTKCf_7nvZKFnbroGrELrmn4WmRaKR9uJ0lZRX8ucfB3e_4zAIANLs3bntnUTL3q_4XISQ301Twg-ddAvGbaBQtV54oOyF7uXBi0jYGSsvjtM-aUqr
      
    $headers = array(
          'Authorization: key=AAAAJ-5BzWE:APA91bFx7fIXpbvrkrfvvhNevsOhXpMGiLM2TGuvaJBjkScb1SAcSm1TNJUGg4hBDMXBkgyVNaBGdocuRW9wFCABsLByiviDtBKC4mJKtPx2JpFfqoXfJNTVnfZp-b2Jgyy2-vP78tvT',
          'Content-Type: application/json'
      );

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmFields));
      $result = curl_exec($ch);
      curl_close($ch);
      return $result;
  }



  /*
    // Import the functions you need from the SDKs you need
    import { initializeApp } from "firebase/app";
    import { getAnalytics } from "firebase/analytics";
    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries

    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    const firebaseConfig = {
    apiKey: "AIzaSyBR61BmiHZPccsV4U3qjzprxZX7AdNRGLU",
    authDomain: "ai-attend.firebaseapp.com",
    projectId: "ai-attend",
    storageBucket: "ai-attend.appspot.com",
    messagingSenderId: "211025120715",
    appId: "1:211025120715:web:615e6d1ae56be4d4ed7a4e",
    measurementId: "G-76CPSJ79NZ"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const analytics = getAnalytics(app);
  */
}
