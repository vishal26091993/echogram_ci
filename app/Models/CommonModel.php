<?php

namespace App\Models;

use CodeIgniter\Model;

class CommonModel extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    // Database fields match duplicate or not.
    public function exist_value($table, $key, $value)
    {
        $res = $this->db->table($table)->where([$key => $value, 'is_delete' => IS_DELETE, 'is_testdata' =>  TEST_DATA]);
        if ($res->countAllResults() >= 1) {
            return 1;
        } else {
            return 0;
        }
    }

    // get IP address
    function getClientIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;

    }

    // Super Admin user log 
    function user_log($user_id, $status)
    {

        helper(["app"]);
        $ip = $this->getClientIpAddress();
        $log = $this->user_log_entry($ip, $user_id, $status);
    }

    // user log entry in DB
    public function user_log_entry($ip, $user_id, $status)
    {
        $apiURL = "https://api.ipgeolocation.io/ipgeo?apiKey=bc534621490e467b8f55f81a1d200858&ip=" . $ip;

        // Make HTTP GET request using cURL 
        $ch = curl_init($apiURL);
        curl_setopt($ch, CURLOPT_URL, $apiURL);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: ' . $_SERVER['HTTP_USER_AGENT']
        ));
        $apiResponse = curl_exec($ch);
        if ($apiResponse === FALSE) {
            $msg = curl_error($ch);
            curl_close($ch);
            return false;
        }
        curl_close($ch);

        // Retrive IP data from API response 
        $ipData = json_decode($apiResponse, true);
      
        if ($ipData != "" && isset($ipData['latitude'])) {
            $latitude = $ipData['latitude'];
            $longitude = $ipData['longitude'];

            if ($ipData['country_name'] != "")
                $location = $ipData['city'] . ', ' . $ipData['state_prov'] . ', ' . $ipData['country_name'] . ', ' . $ipData['zipcode'];
            else
                $location = '';

            $user_id = $user_id;
            $status = $status;

            $data = [
                'user_id' => $user_id,
                'ip_address' => $ip,
                'location' => $location,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'other_details' => '',
                'status' => $status,
                'created_date' => CURRENT_DATE,
                'is_testdata' => TEST_DATA
            ];
            $res =  $this->db->table('user_log')->insert($data);
        }
    }

    // generate unique id
    public function getGUID()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((float)microtime() * 10000);
            $charid = md5(uniqid(rand(), true));
            $hyphen = chr(45); // "-"
            $uuid = substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12);
            return $uuid;
        }
    }

    // Generate random password
    public function generatePassword()
    {
        $comb = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $shfl = str_shuffle($comb);
        $pwd = substr($shfl, 0, 8);
        return $pwd;
    }

    //Push notification Android
    function send_fcm_notify($reg_id, $isNotificationType, $payload, $dataArray, $type)
    {
        //send notification to customer app
        $firebase_api_key = getenv('FIREBASE_API_KEY');

        $firebase_fcm_url = "https://fcm.googleapis.com/fcm/send";

        $fields = array();

        //$isNotificationType is Boolean value
        if ($isNotificationType) {

            if (is_array($reg_id)) {
                $fields['registration_ids'] = $reg_id;
            } else {
                $fields['to'] = $reg_id;
            }

            $fields['priority'] = "high";
            $fields['notification'] = $payload;
            $fields['data'] = $dataArray;
        } else {
            if (is_array($reg_id)) {
                $fields['registration_ids'] = $reg_id;
            } else {
                $fields['to'] = $reg_id;
            }

            $fields['priority'] = "high";
            $fields['data'] = $payload;
        }

        $headers = array(
            'Authorization: key=' . $firebase_api_key,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $firebase_fcm_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);

        curl_close($ch);
       // $result;
       /*  echo '<pre>';
        print_r($result);
        echo '<pre>'; */
    }

    //Push notification IOS  
    function sendPushiOSbkold($device_token,$bodyy_1,$file_name,$topic,$password)
    {
        $title = $bodyy_1;
        $id = '';
        $bodyy = '';
        $pem_file = $file_name;
        $pem_secret = $password;
        $apns_topic = $topic;
        $body['aps'] = array(
            'alert' => array(
                'body' => !empty($bodyy['body']) ? $bodyy['body'] : '',
                'title' => $title,
                'action-loc-key' => 'LunchHub Break',
            ),
            'badge' => 1,
            'sound' => 'christmas.caf',
            //'id' => array_merge($id,$bodyy),
        );

        //        if ($development) {
        // $url = "https://api.development.push.apple.com/3/device/$device_token";
        //        } else {
        if (is_array($device_token)) {
            foreach ($device_token as $key => $value) {
                if ($value) {
                    // code...
                }
                $url = "https://api.push.apple.com/3/device/$value";
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
                curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("apns-topic: $apns_topic"));
                curl_setopt($ch, CURLOPT_SSLCERT, $pem_file);
                curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $pem_secret);
                $response = curl_exec($ch);
                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            }
        } else {
            //$url = "https://api.development.push.apple.com/3/device/526539c25605383d2412cf7214c9311db2856777bd0cab61a562dd4deee5419e";
            $url = "https://api.push.apple.com/3/device/$device_token";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("apns-topic: $apns_topic"));
            curl_setopt($ch, CURLOPT_SSLCERT, $pem_file);
            curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $pem_secret);
            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        }

        //        }



        //On successful response you should get true in the response and a status code of 200
        //A list of responses and status codes is available at
        //https://developer.apple.com/library/ios/documentation/NetworkingInternet/Conceptual/RemoteNotificationsPG/Chapters/TheNotificationPayload.html#//apple_ref/doc/uid/TP40008194-CH107-SW1

         /*  var_dump($response);
         var_dump($httpcode);  */
        if ($response) {
            return true;
        } else {
            return false;
        }
    }

    //($value['device_token'], $message,$topic,$password);

    public function sendPushiOS($deviceTokens,$message,$title,$type) 
    {
                
        $development = false;
        $keyfile = base_url().'/public/AuthKey_A7KNB778AZ.p8';
        $keyid = 'A7KNB778AZ';
        $teamid = 'HQY5J5U2AU';
        $badge = 1;
        $sound = 'default';

      /*  if($type == APPLICATION_TYPE::CUSTOMER) 
        { */
            $bundleid = $type;
       /* } 
        else 
        {
            $bundleid = 'com.lunchhub.driver';
        } */

        $payload = array();
        $payload['aps'] = array('alert' => $message,
            'badge' => intval($badge),
            'sound' => $sound,
            'title' => $title,
            'body' => $message);

        $payload = json_encode($payload);
       // print_r($payload); die;

        if (is_array($device_token)) 
        {
            foreach ($device_token as $key => $deviceToken) 
            {

                if ($development) 
                {
                    $url = "https://api.development.push.apple.com/3/device/$deviceToken";
                } else {
                    $url = "https://api.push.apple.com/3/device/$deviceToken";
                }

                $token_key =  file_get_contents($keyfile);

                $jwt_header = [
                    'alg' => 'ES256',
                    'kid' => $keyid
                ];

                $jwt_payload = [
                    'iss' => $teamid,
                    'iat' => time()
                ];

                $raw_token_data = $this->b64($jwt_header, true).".".$this->b64($jwt_payload, true);

                $signature = '';
                openssl_sign($raw_token_data, $signature, $token_key, 'SHA256');
                $jwt = $raw_token_data.".".$this->b64($signature);

                // only needed for PHP prior to 5.5.24
                if (!defined('CURL_HTTP_VERSION_2_0')) {
                    define('CURL_HTTP_VERSION_2_0', 3);
                }

                $ch = curl_init($url);
                curl_setopt_array($ch, [
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $payload,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => [
                    "content-type: application/json",
                        "authorization: bearer $jwt",
                        "apns-topic: $bundleid"
                    ]
                ]);
                $response = curl_exec($ch);
                curl_close($ch);

            }
        }
        else
        {
                if ($development) 
                {
                    $url = "https://api.development.push.apple.com/3/device/$deviceTokens";
                } else {
                    $url = "https://api.push.apple.com/3/device/$deviceTokens";
                }

                $token_key =  file_get_contents($keyfile);

                $jwt_header = [
                    'alg' => 'ES256',
                    'kid' => $keyid
                ];

                $jwt_payload = [
                    'iss' => $teamid,
                    'iat' => time()
                ];

                $raw_token_data = $this->b64($jwt_header, true).".".$this->b64($jwt_payload, true);

                $signature = '';
                openssl_sign($raw_token_data, $signature, $token_key, 'SHA256');
                $jwt = $raw_token_data.".".$this->b64($signature);

                // only needed for PHP prior to 5.5.24
                if (!defined('CURL_HTTP_VERSION_2_0')) {
                    define('CURL_HTTP_VERSION_2_0', 3);
                }

                $ch = curl_init($url);
                curl_setopt_array($ch, [
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $payload,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => [
                    "content-type: application/json",
                        "authorization: bearer $jwt",
                        "apns-topic: $bundleid"
                    ]
                ]);
                $response = curl_exec($ch);
                curl_close($ch);

        }
    }



    function b64($raw, $json=false)
    {
        if($json) $raw = json_encode($raw);
        return str_replace('=', '', strtr(base64_encode($raw), '+/', '-_'));
    }

    function get_access_token($user_id,$user_type){
        $get_tokens  = $this->db->query("select GROUP_CONCAT(device_token) as device_token, GROUP_CONCAT(device_type) as device_type FROM app_tokens where user_id = '$user_id' and user_type = '$user_type' ");
        $res1  = $get_tokens->getRow();
        $device_token = explode(',',$res1->device_token);
        $device_type = explode(',',$res1->device_type);
        $result['device_token'] = $device_token;
        $result['device_type'] = $device_type;
        return $result;
    }
}
