<?php
namespace App\Controllers;
use App\Models\Company;
use App\Models\MemberType;
use App\Models\UserModel;
use App\Models\CommonModel;
class UserController extends BaseController
{
    
    public function register()
    {
        return view('register');
    }

    public function checkEmail(){
        $this->common_model = new CommonModel();
        $email          = $this->request->getPost('email');
        $apiStatus      = TRUE;
        $apiMessage     = "";
        $apiResponse    = [];
        $checkEmail     = $this->common_model->find_data('ecoex_user_table', 'count', ['user_email' => $email]);
        if($checkEmail<=0){
            $apiStatus      = TRUE;
            $apiMessage     = "Email Available !!!";
        } else {
            $apiStatus      = FALSE;
            $apiMessage     = "Email Already Exists !!!";
        }
        $data = ['status' => $apiStatus, 'message' => $apiMessage, 'response' => $apiResponse];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    public function checkMobile(){
        $this->common_model = new CommonModel();
        $mobile          = $this->request->getPost('mobile');
        $apiStatus      = TRUE;
        $apiMessage     = "";
        $apiResponse    = [];
        $checkMobile     = $this->common_model->find_data('ecoex_user_table', 'count', ['user_mobile' => $mobile]);
        if($checkMobile<=0){
            $apiStatus      = TRUE;
            $apiMessage     = "Mobile Available !!!";
        } else {
            $apiStatus      = FALSE;
            $apiMessage     = "Mobile Already Exists !!!";
        }
        $data = ['status' => $apiStatus, 'message' => $apiMessage, 'response' => $apiResponse];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    
    public function storeCompany()
    {
          $company =new Company();
          $companyName = $this->request->getPost('company');
          
          $companyDetailByName = $company->getCompanyDetailByName($companyName);
          
            $companyName = $companyDetailByName[0]['c_name'];
            
            if(!isset($companyName)){
                $data = [
                        'c_name'=>$this->request->getPost('company')
                ];
                $company->insert($data);
                $companyName = $this->request->getPost('company');
            }
            
            $companyDetailByName = $company->getCompanyDetailByName($companyName);
            $data = $companyDetailByName[0]['c_name'];
            
            $companyUserData = $company->getCompanyUserDataByID($companyDetailByName[0]['c_id']);
            $userMobileAuth = $companyUserData[0]['user_mobile_auth'];
            $userEmailAuth = $companyUserData[0]['user_email_auth'];
        
            if($userMobileAuth == '0' || !isset($userMobileAuth)){
                return redirect()->to('company_details/'.$companyDetailByName[0]['c_id']);  
            } else if($userMobileAuth == '1' && $userEmailAuth == '0'){
            $id = $companyDetailByName[0]['c_id'];   
            
            $companyData = $company->getCompanyDetailByID($id);
             
            $companyUserData = $company->getCompanyUserDataByID($id);
          
           
            $emailCode = bin2hex(random_bytes(16));
            $data = [
                    'c_id'=>$companyDetailByName[0]['c_id'],
                    'link'=>$emailCode
            ];

            $company->setEmailCode($data);
            
          $verificationEmailTemplate = $company->getVerificationEmail();
            
            //$to = 'chavdadharmendrasinh05@gmail.com';
            $to = $companyUserData[0]['user_email'];
            
            //$subject = 'Email Verification';
            $subject = $verificationEmailTemplate->subject;
            
            $headers  = "From: Ecoex Portal<chanchal@keylines.net>\r\n";
            //$headers .= "Reply-To: " . strip_tags('chanchal@keylines.net') . "\r\n";
            //$headers .= "CC: susan@example.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";            
            $verificationLink = site_url('').'emailVerify/'.$emailCode;            
            $emailTemplate = str_replace("{name}", $companyUserData[0]['user_name'], $verificationEmailTemplate->content);            
            $emailTemplate1 = str_replace("{company}", $companyData[0]['c_name'], $emailTemplate);            
            $message = str_replace("{link}", $verificationLink, $emailTemplate1);
            mail($to,$subject,$message, $headers);
            $data = [
                    'userID'=>$companyUserData[0]['user_id'],
                    'fromID'=>'',
                    'email'=>$message
            ];            
            $emailLog = $company->addEmailLog($data);
            //echo base_url('otpEmailValidation/'.urlencode(base64_encode($companyDetailByName[0]['c_id'])));die;
            return redirect()->to(base_url('otpEmailValidation/'.$companyDetailByName[0]['c_id']));            
        } 
    }
    public function company_details($id){        
        $company =new Company();
        $membertype =new MemberType();
        $companyData = $company->getCompanyDetailByID($id);
        $companyUserData = $company->getCompanyUserDataByID($id);
        $data['companyName'] = $companyData[0]['c_name'];
        $data['companyID'] = $companyData[0]['c_id'];
        $data['companyEmail'] = !empty($companyUserData)?$companyUserData[0]['user_email']:'';
        $data['companyMobile'] = !empty($companyUserData)?$companyUserData[0]['user_mobile']:'';
        $data['companyMemberType'] = !empty($companyUserData)?$companyUserData[0]['user_membership_type']:'';
        $data['membertype']=$membertype->find();
        $session = \Config\Services::session();
        $otpError = $session->get('error');
        return view('company_details',$data);
    } 
    public function storeCompanyDetails(){
        
        $company =new Company();
        $this->common_model = new CommonModel();
        $companyID = $this->request->getPost('c_id');
        $companyData = $company->getCompanyDetailByID($companyID);
        $companyUserData = $company->getCompanyUserDataByID($companyID);
        $companyUser = $companyUserData[0]['user_email'];
        $insertMobile = $this->request->getPost('mobile');
        $insertEmail = $this->request->getPost('email');
          
        $memberByMobile = $company->getMemberByMobileNo($insertMobile);
        
        if(!isset($memberByMobile->user_mobile_auth) || $memberByMobile->user_mobile_auth == '0'){            
            $memberByEmail = $company->getMemberByEmail($insertEmail);              
            if(!isset($memberByEmail->user_email_auth) || $memberByEmail->user_email_auth == '0'){  
                
                //pr($this->request->getPost());die;
                $user_sub_member_type = json_encode($this->request->getPost('user_sub_member_type'));
                $userModel =new UserModel();
                if(!isset($companyUser)){            
                    $data = [
                            'c_id'=>$this->request->getPost('c_id'),
                            'user_email'            =>$this->request->getPost('email'),
                            'user_mobile'           =>$this->request->getPost('mobile'),
                            'user_membership_type'  =>$this->request->getPost('member_id'),
                            'user_sub_member_type'  =>$user_sub_member_type,
                            'user_password'         =>md5($this->request->getPost('password')),
                            'user_email_auth'       =>'0',
                            'userStatus'            =>'0'
                    ];
                    $userModel->insert($data);
                } else {            
                    $data = [
                            'c_id'                  =>$this->request->getPost('c_id'),
                            'user_email'            =>$this->request->getPost('email'),
                            'user_mobile'           =>$this->request->getPost('mobile'),
                            'user_membership_type'  =>$this->request->getPost('member_id'),
                            'user_sub_member_type'  =>$user_sub_member_type,
                            'user_password'         =>md5($this->request->getPost('password'))
                    ];
                    $company->updateCompanyUserData($data);            
                }
                // pr($data);
                // die;
                $length = '6';
                $key1 = '';
                $keys1 = array_merge(range(0, 9));
                for ($i = 0; $i < $length; $i++) {
                    $key1 .= $keys1[array_rand($keys1)];
                }
                $company->setOTPForMobile($this->request->getPost('mobile'),$key1);
                //$message = "Dear ".$companyData[0]['c_name'].", ".$key1." is your verification OTP for registration at KEYLINE";
                $message = "Dear ".$companyData[0]['c_name'].", ".$key1." is your verification OTP for registration at ECOEX PORTAL. Do not share this OTP with anyone for security reasons.";

                $mobileNo = $this->request->getPost('mobile');
                $this->common_model->sendSMS($mobileNo,$message);                
                return redirect()->to(base_url('otp_validation/'.$this->request->getPost('c_id')));
            } else {                
                $session = \Config\Services::session($config);
                $session->set('error','Email ID Already Registered!');
                return redirect()->to(base_url('company_details/'.$this->request->getPost('c_id'))); 
            }                
        } else {            
            $session = \Config\Services::session($config);
            $session->set('error','Mobile Number Already Registered!');
            return redirect()->to(base_url('company_details/'.$this->request->getPost('c_id'))); 
        }        
    }
    public function sendOTP(){
        $mobile         = $this->request->getPost('mobile');
        $company        = new Company();
        $membertype     = new MemberType();
        $this->common_model = new CommonModel();
        $companyData    = $this->common_model->find_data('ecoex_user_table', 'row', ['user_mobile' => $mobile]);
        $apiStatus      = FALSE;
        $apiMessage     = "";
        $apiResponse    = [];
        
        $length = '6';
        $key1 = '';
        $keys1 = array_merge(range(0, 9));
        for ($i = 0; $i < $length; $i++) {
            $key1 .= $keys1[array_rand($keys1)];
        }        
        $company->setOTPForMobile($mobile,$key1);
        $message = "Dear ".$companyData->user_name.", ".$key1." is your verification OTP for registration at ECOEX PORTAL. Do not share this OTP with anyone for security reasons.";

        $mobileNo = $this->request->getPost('mobile');
        if($this->common_model->sendSMS($mobileNo, $message)){
            $apiStatus      = TRUE;
            $apiMessage     = "OTP Sent To Your Registered Mobile Number !!!";
            $apiResponse    = ['otp' => $key1, 'mobile' => $mobile];
        } else {
            $apiStatus      = FALSE;
            $apiMessage     = "OTP Not Sent !!!";
            $apiResponse    = [];
        }        
        $data = ['status' => $apiStatus, 'message' => $apiMessage, 'response' => $apiResponse];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    public function verifyOTP(){
        $mobile         = $this->request->getPost('mobile');        
        $this->common_model = new CommonModel();
        $companyData    = $this->common_model->save_data('ecoex_user_table', ['user_mobile_auth' => 1], $mobile, 'user_mobile');
        $apiStatus      = TRUE;
        $apiMessage     = "Mobile Verified Successfully !!!";
        $apiResponse    = [];
        $data = ['status' => $apiStatus, 'message' => $apiMessage, 'response' => $apiResponse];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    public function otp_validation($id){
        
          $session = \Config\Services::session($config);
          $company =new Company();
          $companyUserData = $company->getCompanyUserDataByID($id);
          $data['mobileNo'] = $companyUserData[0]['user_mobile'];
          $data['companyID'] = $companyUserData[0]['c_id'];
          $otpError = $session->get('otpError');
        return view('otp_validation',$data);
    }
    public function forgotPassword(){
        
          $session = \Config\Services::session($config);
          $company =new Company();
          $forgotPassError = $session->get('forgotPassError');
          $forgotPassMessage = $session->get('forgotPassMessage');
        return view('forgotPassword');
    }
    public function forgotPasswordMobileStep(){            
        $session = \Config\Services::session($config);
        $company =new Company();
        if($this->request->getPost('email') != ''){
            $email = $this->request->getPost('email');
            $session->set('forgotEmailID',$email);
        } else {
            $email = $session->get('forgotEmailID');
        }
        $userDataByEmail = $company->getUserDataByEmail($email);        
        if(isset($userDataByEmail->user_email)){

            $id                             = $userDataByEmail->c_id;
            $companyData                    = $company->getCompanyDetailByID($id);             
            $companyUserData                = $company->getCompanyUserDataByID($id);           
            
            $emailCode                      = bin2hex(random_bytes(16));
            $data = [
                    'c_id'=>$id,
                    'link'=>$emailCode
            ];
            $company->setEmailCode($data);

            $verificationEmailTemplate      = $company->getVerificationEmail();            
            //$to = 'chavdadharmendrasinh05@gmail.com';
            $to                             = $companyUserData[0]['user_email'];            
            //$subject = 'Email Verification';
            $subject                        = $verificationEmailTemplate->subject;            
            $headers                        = "From: Ecoex Portal<chanchal@keylines.net>\r\n";
            //$headers .= "Reply-To: " . strip_tags('chanchal@keylines.net') . "\r\n";
            //$headers .= "CC: susan@example.com\r\n";
            $headers                        .= "MIME-Version: 1.0\r\n";
            $headers                        .= "Content-Type: text/html; charset=UTF-8\r\n";
            $verificationLink               = site_url('').'emailVerify/'.$emailCode;
            $emailTemplate                  = str_replace("{name}", $companyUserData[0]['user_name'], $verificationEmailTemplate->content);
            $emailTemplate1                 = str_replace("{company}", $companyData[0]['c_name'], $emailTemplate);
            $message                        = str_replace("{link}", $verificationLink, $emailTemplate1);
            mail($to,$subject,$message, $headers);
            $data['mobileNo'] = $userDataByEmail->user_mobile;
            return view('forgotPasswordMobileStep',$data);
        } else {            
            $session->set('forgotPassError','Your Email ID Not Registered With Us!');
            return redirect()->to(base_url('forgotPassword'));
        }
    }
    public function forgotPasswordMobileStepVerify(){
        
          $session = \Config\Services::session($config);
          $company =new Company();
          $email = $session->get('forgotEmailID');
          $userDataByEmail = $company->getUserDataByEmail($email);
          if($this->request->getPost('mobileNo') != ''){
            $mobile = $this->request->getPost('mobileNo');
          } else {
              $mobile = $userDataByEmail->user_mobile;
          }
          
          $userDataByEmail = $company->getMemberByMobileNo($mobile);
          
        if($userDataByEmail->user_mobile == $mobile){
            
            $data['mobileNo'] = $userDataByEmail->user_mobile;
            
        $length = '6';
        $key1 = '';
        $keys1 = array_merge(range(0, 9));
        for ($i = 0; $i < $length; $i++) {
            $key1 .= $keys1[array_rand($keys1)];
        }        
                $company->setOTPForMobile($mobile,$key1);
        $message = "Dear ".$userDataByEmail->user_name.", ".$key1." is your verification OTP for registration at KEYLINE";	
        $mobileNo = $mobile;
        //Your authentication key
        $authKey = 'Cuj0HpSThBwCIWai';
        //Sender ID,While using route4 sender id should be 6 characters long.
        $senderId = 'KEYLNE';
        //Your message to send, Add URL encoding here.
        //Define route 
        $route = "4";
        //Prepare you post parameters
        $postData = array(
            'apikey' => $authKey,
            'number' => $mobileNo,
            'message' => $message,
            'senderid' => $senderId,
            'format' => 'json'
        );
        //API URL
        $url="http://sms.keylines.net/V2/http-api.php";
        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => false,
            CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
        ));
        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //get response
        $output = curl_exec($ch);
        //echo $output;exit;
        //Print error if any
        if(curl_errno($ch))
        {
            echo 'error:' . curl_error($ch);
        }
        curl_close($ch);
                  return view('forgotPasswordOTP',$data);
                } else {
                    
                    $session->set('forgotPassError','Please Enter Valid Mobile Number!');
                    return redirect()->to(base_url('forgotPasswordMobileStep'));
                }
    }    
    public function forgotPasswordOTPVerify(){
        
          $session = \Config\Services::session($config);
          $company =new Company();
          $email = $session->get('forgotEmailID');
          $userDataByEmail = $company->getUserDataByEmail($email);
          
          $data['mobileNo'] = $userDataByEmail->user_mobile;
          $mobileNo = $this->request->getPost('mobileNo');
          $companyOTPData = $company->getOTPDataByMobile($mobileNo);
          $submitedOTP = $this->request->getPost('digit1').''.$this->request->getPost('digit2').''.$this->request->getPost('digit3').''.$this->request->getPost('digit4').''.
          $this->request->getPost('digit5').''.$this->request->getPost('digit6');
          $dbOTP = $companyOTPData[0]['otp'];
          
        if($submitedOTP == $dbOTP){
            
            return redirect()->to(base_url('resetPassword/'));
        } else {
            $session = \Config\Services::session($config);
            
            $session->set('otpError','Please Enter Valid OTP');
            return redirect()->to(base_url('forgotPasswordMobileWrongOTP'));
        }
    }    
    public function forgotPasswordMobileWrongOTP(){        
          $session = \Config\Services::session($config);
          $company =new Company();
          $email = $session->get('forgotEmailID');
          $userDataByEmail = $company->getUserDataByEmail($email);
          if($this->request->getPost('mobileNo') != ''){
            $mobile = $this->request->getPost('mobileNo');
          } else {
              $mobile = $userDataByEmail->user_mobile;
          }
          
          $userDataByEmail = $company->getMemberByMobileNo($mobile);
          
          $data['mobileNo'] = $userDataByEmail->user_mobile;
          $otpError = $session->get('otpError');
          return view('forgotPasswordOTP',$data);        
    }
    public function resetPassword(){        
          $session = \Config\Services::session($config);
          $company =new Company();
          $otpError = $session->get('otpError');
          return view('resetPassword');        
    }
    public function resetPasswordData(){        
          $session = \Config\Services::session($config);
          $company =new Company();
          $email = $session->get('forgotEmailID');
          $userDataByEmail = $company->getUserDataByEmail($email);
          
          $password = $this->request->getPost('password');
          $company->resetPasswordByID($userDataByEmail->user_id,$password);
          
          $session->set('successMessage','Password Changed Successfully!');
          return redirect()->to(base_url('login/'));        
    }
    
    public function forgotPasswordData(){        
        $session              = \Config\Services::session($config);
        $company              = new Company();
        $this->common_model   = new CommonModel();
        $email                = $this->request->getPost('email');          
        $userDataByEmail = $company->getUserDataByEmail($email);          
        if(isset($userDataByEmail->user_email)){
            
          $forgotPasswordEmailTemplate = $company->getForgotPasswordEmail();
            
            //$to = 'chavdadharmendrasinh05@gmail.com';
            $to = $userDataByEmail->user_email;
            
            //$subject = 'Email Verification';
            $subject = $forgotPasswordEmailTemplate->subject;
            $headers  = "From: Ecoex Portal<chanchal@keylines.net>\r\n";
            //$headers .= "Reply-To: " . strip_tags('chanchal@keylines.net') . "\r\n";
            //$headers .= "CC: susan@example.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $verificationLink = site_url('').'emailVerify/'.$emailCode;
            $emailTemplate = $forgotPasswordEmailTemplate->content;
            $emailTemplate1 = str_replace("{name}", $userDataByEmail->user_email, $emailTemplate);
            $emailTemplate2 = str_replace("{customer_email}", $userDataByEmail->user_email, $emailTemplate1);
            $message = str_replace("{password}", md5($userDataByEmail->user_password), $emailTemplate2);
            $session->set('forgotPassMessage','Login Credentials Sent You Successfully To Your Registered Email!');
            //mail($to,$subject,$message, $headers);
            $this->common_model->sendEmail($to,$subject,$message);
            /* insert email logs */
            $insertData = [
                'userID'    => $userDataByEmail->user_id,
                'email'     => $message
            ];
            $this->common_model->save_data('ecoex_email_log', $insertData, '', 'id');
            /* insert email logs */
            
            return redirect()->to(base_url('forgotPassword'));
        } else {            
            $session->set('forgotPassError','Your Email ID Not Registered With Us!');
            return redirect()->to(base_url('forgotPassword'));
        }
    } 
    
    public function otpVerification($id){
        
          $company =new Company();
          $companyID = $this->request->getPost('c_id');
          $mobileNo = $this->request->getPost('mobileNo');
          $companyOTPData = $company->getOTPDataByMobile($mobileNo);
          $submitedOTP = $this->request->getPost('digit1').''.$this->request->getPost('digit2').''.$this->request->getPost('digit3').''.$this->request->getPost('digit4').''.
          $this->request->getPost('digit5').''.$this->request->getPost('digit6');
          $dbOTP = $companyOTPData[0]['otp'];
          
        if($submitedOTP == $dbOTP){
            $data = [
                    'c_id'=>$this->request->getPost('c_id')
            ];
            $company->verifyMobile($data);
            $companyData = $company->getCompanyDetailByID($id);            
            $companyUserData = $company->getCompanyUserDataByID($id);
          
            
            $emailCode = bin2hex(random_bytes(16));
            $data = [
                    'c_id'=>$this->request->getPost('c_id'),
                    'link'=>$emailCode
            ];
            $company->setEmailCode($data);
            
            $verificationEmailTemplate = $company->getVerificationEmail();            
            $to = $companyUserData[0]['user_email'];            
            $subject = $verificationEmailTemplate->subject;
            $headers  = "From: Ecoex Portal<chanchal@keylines.net>\r\n";
            //$headers .= "Reply-To: " . strip_tags('chanchal@keylines.net') . "\r\n";
            $headers .= "CC: subhomoy@keylines.net\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $verificationLink = site_url('').'emailVerify/'.$emailCode;
            $emailTemplate = str_replace("{name}", $companyUserData[0]['user_name'], $verificationEmailTemplate->content);
            $emailTemplate1 = str_replace("{company}", $companyData[0]['c_name'], $emailTemplate);
            $message = str_replace("{link}", $verificationLink, $emailTemplate1);
            //mail($to,$subject,$message, $headers);

            $this->common_model->sendEmail($to,$subject,$message);
            /* insert email logs */        
            $insertData = [
                'userID'    => $companyUserData[0]['user_id'],
                'email'     => $message
            ];
            $this->common_model->save_data('ecoex_email_log', $insertData, '', 'id');
            /* insert email logs */

            return redirect()->to(base_url('otpEmailValidation/'.$this->request->getPost('c_id')));
        } else {
            $session = \Config\Services::session($config);            
            $session->set('otpError','Please Enter Valid OTP');
            return redirect()->to(base_url('otp_validation/'.$this->request->getPost('c_id')));
        }
    }

    public function skipMobileOTP($id){
        $company            = new Company();
        $this->common_model = new CommonModel();
        $companyID          = $id;
        $companyData        = $company->getCompanyDetailByID($id);            
        $companyUserData    = $company->getCompanyUserDataByID($id);
        $emailCode          = bin2hex(random_bytes(16));
        $data               = [
                                'c_id' => $id,
                                'link' => $emailCode
                            ];
        $company->setEmailCode($data);        
        $verificationEmailTemplate  = $company->getVerificationEmail();
        $to                         = $companyUserData[0]['user_email'];            
        $subject                    = $verificationEmailTemplate->subject;        
        $verificationLink           = site_url('').'emailVerify/'.$emailCode;
        $emailTemplate              = str_replace("{name}", $companyUserData[0]['user_name'], $verificationEmailTemplate->content);;
        $emailTemplate1             = str_replace("{company}", $companyData[0]['c_name'], $emailTemplate);
        $message                    = str_replace("{link}", $verificationLink, $emailTemplate1);
        //mail($to,$subject,$message, $headers);
        //echo $message;die;
        $this->common_model->sendEmail($to,$subject,$message);
        /* insert email logs */        
        $insertData = [
            'userID'    => $companyUserData[0]['user_id'],
            'email'     => $message
        ];
        $this->common_model->save_data('ecoex_email_log', $insertData, '', 'id');
        /* insert email logs */        
        return redirect()->to(base_url('otpEmailValidation/'.$id));
    }
    
    public function otpEmailValidation($id){
        
          $company =new Company();
          $companyUserData = $company->getCompanyUserDataByID($id);
          $data['mobileNo'] = $companyUserData[0]['user_email'];
          $data['companyID'] = $companyUserData[0]['c_id'];
        return view('otpEmailValidation',$data);
    }
    
    public function emailVerify($id){
        
        $session = \Config\Services::session($config);
        
        $company =new Company();
        $emailLinkData = $company->getDataByEmailLink($id);
        //pr($emailLinkData);die;  
        if(isset($emailLinkData[0]['status'])){
            if($emailLinkData[0]['status'] == 0){
                $data = ['id'=>$emailLinkData[0]['id'],'c_id'=>$emailLinkData[0]['c_id']];
                $company->verifyEmail($data);
                $session->set('verifySuccess','Congratulations, Your Account Is Verified Successfully!');
            } else {
                $session->set('verifyError','Your Email Verified Already!');
            }
        } else {
                $session->set('verifyError','Your Verification Link Expired! Please Try Again.');
        }
        return redirect()->to(base_url('/emailVerifySuccess'));
    }
    
    public function emailVerifySuccess(){
        $session = \Config\Services::session($config);
        $data['verifySuccess'] = $session->get('verifySuccess');
        return view('emailVerificationSuccess',$data);
    }
    
    public function resendOTP($companyID){
        
          $company =new Company();
          //$companyID = $this->request->getPost('c_id');
          $companyData = $company->getCompanyDetailByID($companyID);
          $companyUserData = $company->getCompanyUserDataByID($companyID);
          $companyUser = $companyUserData[0]['user_email'];
            
          $userModel =new UserModel();
       
            $length = '6';
            $key1 = '';
            $keys1 = array_merge(range(0, 9));
            for ($i = 0; $i < $length; $i++) {
                $key1 .= $keys1[array_rand($keys1)];
            }        
                    $company->setOTPForMobile($companyUserData[0]['user_mobile'],$key1);
            $message = "Dear ".$companyData[0]['c_name'].", ".$key1." is your verification OTP for registration at KEYLINE";	
            $mobileNo = $companyUserData[0]['user_mobile'];
            //Your authentication key
            $authKey = 'Cuj0HpSThBwCIWai';
            //Sender ID,While using route4 sender id should be 6 characters long.
            $senderId = 'KEYLNE';
            //Your message to send, Add URL encoding here.
            //Define route 
            $route = "4";
            //Prepare you post parameters
            $postData = array(
                'apikey' => $authKey,
                'number' => $mobileNo,
                'message' => $message,
                'senderid' => $senderId,
                'format' => 'json'
            );
            //API URL
            $url="http://sms.keylines.net/V2/http-api.php";
            // init the resource
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => false,
                CURLOPT_POSTFIELDS => $postData
                //,CURLOPT_FOLLOWLOCATION => true
            ));
            //Ignore SSL certificate verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            //get response
            $output = curl_exec($ch);
            //echo $output;exit;
            //Print error if any
            if(curl_errno($ch))
            {
                echo 'error:' . curl_error($ch);
            }
            curl_close($ch);
                    
                    return redirect()->to(base_url('otp_validation/'.$companyID));  
    } 
    
    public function resendEmail($companyID){
        
          $company =new Company();
            $id = $companyID;   
            
            $companyData = $company->getCompanyDetailByID($id);
             
            $companyUserData = $company->getCompanyUserDataByID($id);
          
           
            $emailCode = bin2hex(random_bytes(16));
            $data = [
                    'c_id'=>$companyID,
                    'link'=>$emailCode
            ];
            $company->setEmailCode($data);
            
          $verificationEmailTemplate = $company->getVerificationEmail();
            
            //$to = 'chavdadharmendrasinh05@gmail.com';
            $to = $companyUserData[0]['user_email'];
            
            //$subject = 'Email Verification';
            $subject = $verificationEmailTemplate->subject;
            
            $headers  = "From: Ecoex Portal<chanchal@keylines.net>\r\n";
            //$headers .= "Reply-To: " . strip_tags('chanchal@keylines.net') . "\r\n";
            //$headers .= "CC: susan@example.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            
            $verificationLink = site_url('').'emailVerify/'.$emailCode;
            
            $emailTemplate = str_replace("{name}", $companyUserData[0]['user_name'], $verificationEmailTemplate->content);;
            
            $emailTemplate1 = str_replace("{company}", $companyData[0]['c_name'], $emailTemplate);
            
            $message = str_replace("{link}", $verificationLink, $emailTemplate1);
            mail($to,$subject,$message, $headers);
            
            $data = [
                    'userID'=>$companyUserData[0]['user_id'],
                    'fromID'=>'',
                    'email'=>$message
            ];
            
            $emailLog = $company->addEmailLog($data);
            
            return redirect()->to(base_url('otpEmailValidation/'.$companyID));
    }

    public function page($slug){
        $this->common_model = new CommonModel();
        $data['row'] = $this->common_model->find_data('ecoex_static_content', 'row', ['slug' => $slug]);
        return view('static-content',$data);
    }

}
