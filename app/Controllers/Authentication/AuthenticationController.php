<?php

namespace App\Controllers\Authentication;

use CodeIgniter\Controller;
use App\Models\AuthenticationModel;
use App\Models\CommonModel;

class AuthenticationController extends Controller
{

    public function __construct()
    {
        $this->authentication    = new AuthenticationModel();
        $this->common            = new CommonModel();
        $this->time_zone  = session()->get('time_zone');
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        if (isset($_SESSION['_ci_previous_url'])) {
            $str = $_SESSION['_ci_previous_url'];
            $pattern = "/dashboard/i";
            $flag =  preg_match($pattern, $str);
            if ($flag == 1) {
                $this->logout();
            }
        }
        $this->check_remember_me();
        
        $data['title'] = 'Authentication';
        return view('Common/Authentication', ['data' => $data]);
    }

    public function register()
    {
        $data['title'] = 'Register';
        return view('Common/register', ['data' => $data]);
    }

    public function my_profile()
    {
        $data['title'] = 'My Profile';

        return view('Admin/my_profile', ['data' => $data]);
    }

    public function change_password()
    {
        $data['title'] = 'Change Password';
        return view('Admin/change_password', ['data' => $data]);
    }

    public function forgot_password()
    {
        $data['title'] = 'Recover Password';
        return view('Common/forgot_password', ['data' => $data]);
    }

    public function check_remember_me()
    {
        $session = session();
        if (!isset($session->logged_in) && isset($_COOKIE['remember_me'])) {
            $token = $_COOKIE['remember_me'];
            $data = $this->authentication->where('remember_token', $token)->first();

            if ($data) {
                $ses_data = [
                    'user_id'       => $data['id'],
                    'user_name'     => $data['username'],
                    'user_email'    => $data['email'],
                    'is_email_verified'  => $data['isEmailVerified'],
                    'profile_picture' => $data['profileImage'],
                    'user_role'     => 3,
                    'logged_in'     => TRUE,
                    'time_zone'     => $this->request->getVar('time_zone'),
                ];

                $session->sess_expiration = '0';
                $session->set($ses_data);
            }
        }
    }
 
    public function user_login()
    {

        $session = session();
        $email = $this->request->getVar('email_id');
        $password = $this->request->getVar('password');

        $rememberMe = $this->request->getVar('remember_me');

        $data = $this->authentication->where('email', $email)->first();
          //   echo $this->db->getLastQuery(); die;
        if ($data) {

            if ($data['isDelete'] == 1)
                echo UNAUTH_CODE;
            else {
                $pass = $data['password'];
                $password = md5($password);
                $verify_pass = strcmp($password, $pass);

                if ($verify_pass == 0) {
                    if ($data['isEmailVerified'] == 0) {
                        echo json_encode(PENDING_VERIFY);
                    } 
                    else 
                    {
                        $ses_data = [
                            'user_id'       => $data['id'],
                            'user_name'     => $data['username'],
                            'user_email'    => $data['email'],
                            'is_email_verified'  => $data['isEmailVerified'],
                            'profile_picture' => $data['profileImage'],
                            'user_role'     => 3,
                            'logged_in'     => TRUE,
                            'time_zone'     => $this->request->getVar('time_zone'),
                        ];

                        if ($rememberMe) 
                        {
                            // Generate a random token
                            $token = bin2hex(random_bytes(16));
                            // Store the token in the database
                            $this->authentication->update($data['id'], ['remember_token' => $token]);
                            // Store the token in a cookie
                            setcookie('remember_me', $token, time() + (86400 * 30), "/"); // 30 days
                        }
                        
                        $session->sess_expiration = '0';
                        $session->set($ses_data);
                        echo json_encode(SUCCESS_CODE);
                    }
                } else {
                    echo json_encode(FAILD_CODE);
                    $session->setFlashdata('msg', 'Please Enter Valid Password.');
                }   
            }
        } else {
            echo json_encode(EXIST_CODE);
            $session->setFlashdata('msg', 'Please enter valid email.');
        }
    }

     public function password_recovery()
    {

      //  $to = $this->request->getVar('email_id');
        $to = 'vishalezacus@gmail.com';

        $uniqidStr = md5(uniqid(mt_rand()));;

        //update data with forgot pass code
        $conditions = array(
            'email' => $this->request->getVar('email_id')
        );
        $data = array(
            'forgot_pass_identity' => $uniqidStr
        );
        $update = $this->authentication->set($data)->where($conditions)->update();

        if ($update) {

            $resetPassLink = RESET_PASSWORD . $uniqidStr;
            //echo $resetPassLink; die;
            //get user details
            $user_details = $this->authentication->where('email', $this->request->getVar('email_id'))->first();

            if ($user_details) 
            {

                $message = '<br>
                    Dear ' . $user_details['username'] . ', 
                    <br/><p>Recently a request was submitted to reset a password for your account. If this was a mistake, just ignore this email and nothing will happen.
                    <br/>To reset your password, visit the following link: <a href="' . $resetPassLink . '">' . $resetPassLink . '</a></p>
                    <br/><b>Regards</b>,
                    <br/>TradeLogic<br><br><img src="' . base_url(EMAIL_LOGO) . '" height="100px">';

                $subject = "Password Update Request";

                $email = \Config\Services::email();

                // $email = \Config\Services::email();

                // Load email library configurations from .env
                $email->initialize([
                    'SMTPHost' => getenv('SMTP_EMAIL_HOST'),
                    'SMTPUser' => getenv('SMTP_EMAIL_USER'),
                    'SMTPPass' => getenv('SMTP_EMAIL_PASSWORD'),
                    'SMTPPort' => '465',
                    'SMTPCrypto' => 'SSL',
                    'mailType' => 'html',
                    'charset' => 'utf-8',
                    'newline' => "\r\n",
                ]);

                $email->setTo($to);
                $email->setFrom(getenv('SMTP_EMAIL_USER'), 'TradeLogic');

                $email->setSubject($subject);
                $email->setMessage($message); 

                if ($email->send()) {
                    echo SUCCESS_CODE;
                } else {
                    echo FAILD_CODE;
                    $data = $email->printDebugger(['headers']);
                    // print_r($data);
                }
            }else{
                 echo '400';
            }


        }else{
            echo FAILD_CODE;
        }
    }

    public function logout()
    {
        $session = session();

        if ($session->get('is_verify') == 3)
            $this->common->user_log($session->get('user_id'), 'logout');

        $session->destroy();
        return redirect()->to('/admin');
    }

    public function password_change()
    {
        $data['title'] = 'Change Password';
        return view('Common/password_change', ['data' => $data]);
    }

    public function set_new_password()
    {
        $fp_code = $this->request->getVar('fp_code');
        $new_password = $this->request->getVar('new_password');


        $getData =  $this->authentication->where('forgot_pass_identity', $fp_code)->first();

        if (!empty($getData)) {
            //update data with new password
            $conditions = array(
                'forgot_pass_identity' => $fp_code
            );
            $data = array(
                'password' => md5($new_password)
            );
            $update = $this->authentication->set($data)->where($conditions)->update();
            if ($update) {
                echo SUCCESS_CODE;
                $this->authentication->set(['forgot_pass_identity' => ''])->where($conditions)->update();
            } else {
                echo FAILD_CODE;
            }
        } else {
            echo UNAUTH_CODE;
        }
    }

    public function setting_change_password()
    {
        $session = session();
        $uid = $session->get('user_id');
        $curr_pass = md5($this->request->getVar('current_password'));
        $new_pass = md5($this->request->getVar('new_password'));

        $res = $this->authentication->where(['id' => $uid, 'password' => $curr_pass])->first();

        if (empty($res)) {
            echo UNAUTH_CODE;
        } else {
            $res = $this->authentication->set(['password' => $new_pass])->where('id', $uid)->update();

            if ($res > 0)
                echo SUCCESS_CODE;
            else
                echo FAILD_CODE;
        }
    }

    public function getProfileList()
    {
        $session = session();
        $uid = $session->get('user_id');

        $res = $this->authentication->where(['id' => $uid, 'isDelete' => '0'])->first();

        echo json_encode($res);
    }

    public function update_profile()
    {   
        $session = session();
        $uid = $session->get('user_id');
        $business_image = "";
        if ($file = $this->request->getFile('business_image')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = time().$file->getName();
                $file->move(USER_UPLOAD_IMAGE, $newName);
                $business_image =  $newName;
            }
        } else {
            $business_image = "";
        }

        $data = [
            "username"              => $this->request->getVar('user_name'),
            "email"                 => $this->request->getVar("email_id"),
            "phoneNumber"           => $this->request->getVar('phone_number'),
            "isTestData"           => TEST_DATA,
            "updatedAt"         => CURRENT_DATE,
        ];

        if ($business_image != "")
            $data["profileImage"]  =  $business_image;

        $res = $this->authentication->set($data)->where('id',$uid)->update();
        if ($res > 0) {

            $session->set('user_name', $data['username']);
            if ($business_image != "") {
                $session->set('profile_picture', $data['profileImage']);
            }

            echo SUCCESS_CODE;
        } else {
            echo FAILD_CODE;
        }
        
    }

    public function getCountry()
    {
        $res = $this->country->select('id,name')->findAll();
        return json_encode($res);
    }

    public function getState()
    {
        if ($this->request->getVar('country_id') == "") {
            $res = $this->state->findAll();
        } else {
            $res = $this->state->where('country_id', $this->request->getVar('country_id'))->findAll();
        }
        return json_encode($res);
    }

    public function getCity()
    {
        $res = $this->city->where('state_id', $this->request->getVar('state_id'))->findAll();
        return json_encode($res);
    }


    public function notification()
    {
        $data['title'] = 'Notifications';
        return view('Admin/notification', ['data' => $data]);
    }

    public function changeMapStatus()
    {
        $status = $this->request->getVar('status');
        $business_id = session()->get('business_id');
        // echo $business_id;
        if ($status == 1)
            $upd_status = "0";
        else
            $upd_status = "1";

        $data = ['is_restaurant_location_on' => $upd_status];

        $res = $this->business->set($data)->where('id', $business_id)->update();

        if ($res > 0)
            echo SUCCESS_CODE;
        else
            echo FAILD_CODE;
    }

    public function getMapStatus()
    {
        $business_id = session()->get('business_id');
        $restaurant_status = $this->business->select('is_restaurant_location_on')->where('id', $business_id)->first();
        echo $restaurant_status['is_restaurant_location_on'];
    }

  

  
}
