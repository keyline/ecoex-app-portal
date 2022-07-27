<?php
namespace App\Controllers;
use App\Models\Company;
use App\Models\CommonModel;
class CompanyController extends BaseController
{
    
    public function storeLogin()
	{
        $session = \Config\Services::session();            
        $company =new Company();       
        $data = [
                'email'=>$this->request->getPost('email'),
                'password'=>$this->request->getPost('password')
        ];
        $storeDetail = $company->getStoreLogin($data);
        //pr($storeDetail);
		if(isset($storeDetail->user_id)){
		    
            $userMobileAuth = $storeDetail->user_mobile_auth;
            $userEmailAuth = $storeDetail->user_email_auth;
            $id = $storeDetail->c_id;
            
            $companyData = $company->getCompanyDetailByID($id);
            $companyUserAdminData = $company->getCompanyUserDataByID($id);             
            $companyUserData = $company->getCompanyUserDataByID($id);
            
            // if($userMobileAuth == '0'){
            //     return redirect()->to('company_details/'.$storeDetail->c_id);  
            // } else 

            if($companyData[0]['c_status'] == '2' && $userMobileAuth == '1' && $userEmailAuth == '1'){
                $emailCode = bin2hex(random_bytes(16));
                $data = [
                        'c_id'=>$id,
                        'link'=>$emailCode
                ];
                $company->setEmailCode($data);                
                $verificationEmailTemplate = $company->getVerificationEmail();
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
                //mail($to,$subject,$message, $headers);

                $session->set('storeId',$storeDetail->c_id);
                // if($companyUserData[0]['user_membership_type'] == '1'){
                //     $session->set('brandUserId',$companyUserData[0]['user_id']);
                //     $session->set('userId',$companyUserData[0]['user_id']);
                //     return redirect()->to(base_url('brand/'));
                // } else if($companyUserData[0]['user_membership_type'] == '1'){
                //     $session->set('recycleUserId',$companyUserData[0]['user_id']);
                //     $session->set('userId',$companyUserData[0]['user_id']);
                //     return redirect()->to(base_url('recycler/'));
                // } else if($companyUserData[0]['user_membership_type'] == '4'){
                //     $session->set('recycleUserId',$companyUserData[0]['user_id']);
                //     $session->set('collectorUserId',$companyUserData[0]['user_id']);
                //     $session->set('userId',$companyUserData[0]['user_id']);
                //     return redirect()->to(base_url('collector/'));
                // } else {
                //     $session->set('recycleUserId',$companyUserData[0]['user_id']);
                //     $session->set('userId',$companyUserData[0]['user_id']);
                //     return redirect()->to(base_url('recycler/'));
                // }

                if($companyUserData[0]['user_membership_type'] == '1'){
                    $session->set('brandUserId',$companyUserData[0]['user_id']);
                    $session->set('userId',$companyUserData[0]['user_id']);
                    $session->set('userType','MEMBER');
                    return redirect()->to(base_url('brand/'));
                } else {
                    $session->set('recycleUserId',$companyUserData[0]['user_id']);
                    $session->set('userId',$companyUserData[0]['user_id']);
                    $session->set('userType','MEMBER');
                    return redirect()->to(base_url('user/'));
                }
                
                //return redirect()->to(base_url('otpEmailValidation/'.$id));
            
            } else if($companyData[0]['c_status'] == '2') {
                $session->set('storeId',$storeDetail->c_id);
                // if($companyUserData[0]['user_membership_type'] == '1'){
                //     $session->set('brandUserId',$companyUserData[0]['user_id']);
                //     return redirect()->to(base_url('brand/'));
                // } else if($companyUserData[0]['user_membership_type'] == '1'){
                //     $session->set('recycleUserId',$companyUserData[0]['user_id']);
                //     return redirect()->to(base_url('recycler/'));
                // } else if($companyUserData[0]['user_membership_type'] == '4'){
                //     $session->set('recycleUserId',$companyUserData[0]['user_id']);
                //     $session->set('collectorUserId',$companyUserData[0]['user_id']);
                //     return redirect()->to(base_url('collector/'));
                // } else {
                //     $session->set('recycleUserId',$companyUserData[0]['user_id']);
                //     return redirect()->to(base_url('recycler/'));
                // }

                if($companyUserData[0]['user_membership_type'] == '1'){
                    $session->set('brandUserId',$companyUserData[0]['user_id']);
                    $session->set('userId',$companyUserData[0]['user_id']);
                    return redirect()->to(base_url('brand/'));
                } else {
                    $session->set('recycleUserId',$companyUserData[0]['user_id']);
                    $session->set('userId',$companyUserData[0]['user_id']);
                    return redirect()->to(base_url('user/'));
                }
                
            } else if($companyData[0]['c_status'] == '1') {
                $session->set('storeId',$storeDetail->c_id);
                $session->set('storeUserId',$companyUserData[0]['user_id']);
                return redirect()->to(base_url('companyRegistration/5'));
            } else {
                $session->set('storeId',$storeDetail->c_id);
                $session->set('storeUserId',$companyUserData[0]['user_id']);
                return redirect()->to(base_url('companyRegistration/1'));
            }
		} else {		    
            $session->set('loginError','Invalid Login Credentials');
            return redirect()->to(base_url('/login'));
		}
	}    
    public function companyRegistration($id)
    {
        
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        if(isset($storeId)){
           
          $company =new Company();
          $this->common_model = new CommonModel();
            $storeUserDetail = $company->getStoreUserDetail($storeId);
            $storeDetail = $company->getStoreDetail($storeUserDetail->c_id);
            $companyList = $company->getCompanyTypeList();
            $businessCategoryList = $company->getParentCategoryList();
            $data['storeUserData'] = $storeUserDetail;
            $data['storeData'] = $storeDetail;
            $data['companyList'] = $companyList;
            $data['categoryList'] = $businessCategoryList;
            $data['districtList'] = array();
            $data['cityList'] = array();
            $data['controller'] = $company; 
            if($id=='1'){
                $companyDetail = $company->getCompanyDetail($storeId);
                $data['companyDetail'] = $companyDetail;
                return view('companyRegistrationStepOne',$data);
            } else if($id=='2'){
                $companyDetail = $company->getAddressDetail($storeId);
                if(isset($companyDetail->c_state)){
                    $data['districtList'] = $company->getDistrictListById($companyDetail->c_state);
                    $data['cityList'] = $company->getCityListById($companyDetail->c_district);
                }
                $data['companyDetail'] = $companyDetail;
                $data['stateList'] = $company->getStateList();
                return view('companyRegistrationStepTwo',$data);
            }else if($id=='3'){
                $companyDetail = $company->getBankDetail($storeId);
                $data['companyDetail'] = $companyDetail;
                return view('companyRegistrationStepThree',$data);
            }else if($id=='4'){
                $unitDetail = $company->getUnitDetail($storeId);
                $categoryUnitDetail = $company->getCategoryUnitTypeList();
                $materialDetail = $company->getSubCategoryByParentID(3);
                $data['categoryUnitDetail'] = $categoryUnitDetail;                
                $data['materialDetail'] = $materialDetail;
                $data['companyDetail'] = $unitDetail;
                $data['companyUnitDetails'] = $this->common_model->find_data('ecoex_unit_material_detail', 'array', ['c_id' => $storeId]);
                //pr($data['companyUnitDetails']);
                if(isset($unitDetail->c_state)){
                    $data['districtList'] = $company->getDistrictListById($unitDetail->c_state);
                    $data['cityList'] = $company->getCityListById($unitDetail->c_district);
                }
                $data['stateList'] = $company->getStateList();
                $data['unitImages'] = $this->common_model->find_data('ecoex_unit_details_images', 'array', ['c_id' => $storeId, 'type' => 0]);
                $data['unitVideos'] = $this->common_model->find_data('ecoex_unit_details_images', 'array', ['c_id' => $storeId, 'type' => 1]);
                return view('companyRegistrationStepFour',$data);
            }else{
                return view('companyRegistrationSuccess',$data);
            }
        } else{
            $session->set('loginError','Session Time Out');
            return redirect()->to(base_url('login'));
        }
       
    }    
    public function companyRegistrationStepOneData()
    {
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $storeUserId = $session->get('storeUserId');
        if(isset($storeId)){
           
          $company =new Company();
          $businessCatChecked = $this->request->getPost('businessCategory');
          $uploadedPancard = '';$uploadedGSTcard = '';$uploadedCOIcard = '';
          if(is_array($businessCatChecked)){
            foreach($businessCatChecked as $val)
            {
            $busiCat[] = (int) $val;
            }
            $busiCat = implode(',', $busiCat);
        } else {
            $busiCat = '';
        }
            if($imagefile = $this->request->getFiles())
            {
                if($img = $imagefile['panCard'])
                {
                    if ($img->isValid() && ! $img->hasMoved())
                    {
                        $uploadedPancard = $img->getRandomName(); //This is if you want to change the file name to encrypted name
                        $img->move(WRITEPATH.'uploads', $uploadedPancard);
                    }
                }
                if($img = $imagefile['gstCard'])
                {
                    if ($img->isValid() && ! $img->hasMoved())
                    {
                        $uploadedGSTcard = $img->getRandomName(); //This is if you want to change the file name to encrypted name
                        $img->move(WRITEPATH.'uploads', $uploadedGSTcard);
                    }
                }
                if($img = $imagefile['COI'])
                {
                    if ($img->isValid() && ! $img->hasMoved())
                    {
                        $uploadedCOIcard = $img->getRandomName(); //This is if you want to change the file name to encrypted name
                        $img->move(WRITEPATH.'uploads', $uploadedCOIcard);
                    }
                }
            }
            $data = [
                    'storeID'           => $storeId,
                    'establishDate'     => $this->request->getPost('establishDate'),
                    'contactPerson'     => strtoupper($this->request->getPost('contactPerson')),
                    'companyType'       => $this->request->getPost('companyType'),
                    'panNumber'         => strtoupper($this->request->getPost('panNumber')),
                    'gstNumber'         => strtoupper($this->request->getPost('gstNumber')),
                    'alMobile'          => $this->request->getPost('alMobile'),
                    'alEmail'           => $this->request->getPost('alEmail'),
                    'businessCategory'  => $busiCat,
                    'panCard'           => $uploadedPancard,
                    'GSTCard'           => $uploadedGSTcard,
                    'COICard'           => $uploadedCOIcard
            ];
            //print_r($data);exit;
            $storeUserDetail = $company->storeCompanyRegStepOne($data);
            $dataNew = [
                    'storeID'=>$storeId,
                    'storeUserId'=>$storeUserId,
                    'contactPerson'=>$this->request->getPost('contactPerson')
            ];
            //print_r($data);exit;
            //$storeUserDetail = $company->storeCompanyUserUpdate($data);            
            return redirect()->to(base_url('companyRegistration/2'));
        } else{
            $session->set('loginError','Session Time Out');
            return redirect()->to(base_url('login'));
        }
       
    }    
    public function companyRegistrationStepTwoData()
    {
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        if(isset($storeId)){
           
          $company =new Company();
            $data = [
                    'storeID'=>$storeId,
                    'country'=>$this->request->getPost('country'),
                    'state'=>$this->request->getPost('state'),
                    'district'=>$this->request->getPost('district'),
                    'city'=>$this->request->getPost('city'),
                    'pincode'=>$this->request->getPost('pincode'),
                    'address'=>$this->request->getPost('address')
            ];
            //print_r($data);exit;
            $storeAddressDetail = $company->storeCompanyRegStepTwo($data);
            
            return redirect()->to(base_url('companyRegistration/3'));
        } else{
            $session->set('loginError','Session Time Out');
            return redirect()->to(base_url('login'));
        }
       
    }    
    public function companyRegistrationStepThreeData()
    {
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        if(isset($storeId)){
           
          $company =new Company();
          
          $companyData = $company->getCompanyUserDataByID($storeId);
            
          $cancelledCheque = '';
            if($imagefile = $this->request->getFiles())
            {
                if($img = $imagefile['cancllledCheque'])
                {
                    if ($img->isValid() && ! $img->hasMoved())
                    {
                        $cancelledCheque = $img->getRandomName(); //This is if you want to change the file name to encrypted name
                        $img->move(WRITEPATH.'uploads', $cancelledCheque);
                    }
                }
            }
            $data = [
                    'storeID'=>$storeId,
                    'accountType'=>$this->request->getPost('accountType'),
                    'bankName'=>$this->request->getPost('bankName'),
                    'accountNo'=>$this->request->getPost('accountNo'),
                    'branchName'=>$this->request->getPost('branchName'),
                    'accountHolder'=>$this->request->getPost('accountHolder'),
                    'mtcrCode'=>$this->request->getPost('mtcrCode'),
                    'cancelledCheque'=>$cancelledCheque,
                    'userType'=>$companyData[0]['user_membership_type']
            ];
            //print_r($data);exit;
            $storeBankDetail = $company->storeCompanyRegStepThree($data);
            
            if($companyData[0]['user_membership_type'] == '2') {
                return redirect()->to(base_url('companyRegistration/4'));
            } else {
                return redirect()->to(base_url('companyRegistration/5'));
            }
        } else{
            $session->set('loginError','Session Time Out');
            return redirect()->to(base_url('login'));
        }
       
    }    
    public function companyRegistrationStepFourData()
    {
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        if(isset($storeId)){
           
          $company =new Company();
          
          $cancelledCheque = '';
            if($imagefile = $this->request->getFiles())
            {
                if($img = $imagefile['consent_document'])
                {
                    if ($img->isValid() && ! $img->hasMoved())
                    {
                        $consent_document = $img->getRandomName(); //This is if you want to change the file name to encrypted name
                        $img->move(WRITEPATH.'uploads', $consent_document);
                    }
                }
                if($img = $imagefile['pwm_document'])
                {
                    if ($img->isValid() && ! $img->hasMoved())
                    {
                        $pwm_document = $img->getRandomName(); //This is if you want to change the file name to encrypted name
                        $img->move(WRITEPATH.'uploads', $pwm_document);
                    }
                }
                if($img = $imagefile['cpcb_document'])
                {
                    if ($img->isValid() && ! $img->hasMoved())
                    {
                        $cpcb_document = $img->getRandomName(); //This is if you want to change the file name to encrypted name
                        $img->move(WRITEPATH.'uploads', $cpcb_document);
                    }
                }
            }
            $data = [
                    'storeID'=>$storeId,
                    'unit_name'=>$this->request->getPost('unit_name'),
                    'unit_category'=>$this->request->getPost('unit_category'),
                    'typeOfMaterial'=>$this->request->getPost('typeOfMaterial'),
                    'materialFullName'=>$this->request->getPost('materialFullName'),
                    'monthlyCapicity'=>$this->request->getPost('monthlyCapicity'),
                    'annualCapicity'=>$this->request->getPost('annualCapicity'),
                    'consent_cert_no'=>$this->request->getPost('consent_cert_no'),
                    'consent_valid_from'=>$this->request->getPost('consent_valid_from'),
                    'consent_valid_upto'=>$this->request->getPost('consent_valid_upto'),
                    'consent_document'=>$consent_document,
                    'pwm_cert_no'=>$this->request->getPost('pwm_cert_no'),
                    'pwm_valid_from'=>$this->request->getPost('pwm_valid_from'),
                    'pwm_valid_upto'=>$this->request->getPost('pwm_valid_upto'),
                    'pwm_document'=>$pwm_document,
                    'cpcb_cert_no'=>$this->request->getPost('cpcb_cert_no'),
                    'cpcb_valid_from'=>$this->request->getPost('cpcb_valid_from'),
                    'cpcb_valid_upto'=>$this->request->getPost('cpcb_valid_upto'),
                    'cpcb_document'=>$cpcb_document,
                    'state'=>$this->request->getPost('c_state'),
                    'district'=>$this->request->getPost('c_district'),
                    'city'=>$this->request->getPost('c_city'),
                    'c_pincode'=>$this->request->getPost('c_pincode'),
                    'c_full_address'=>$this->request->getPost('c_full_address')
            ];

            $storeBankDetail = $company->storeCompanyRegStepFour($data);
            //echo $storeBankDetail;die;
            //pr($this->request->getFileMultiple('plant_images'), false);
            //pr($this->request->getFileMultiple('plant_videos'));

            if ($this->request->getFileMultiple('plant_images')) {    
                foreach($this->request->getFileMultiple('plant_images') as $file)
                {   
                    if ($file->isValid() && ! $file->hasMoved())
                    {
                        $dynamicImageName = $file->getRandomName();
                        $file->move(WRITEPATH . 'uploads', $dynamicImageName);
                        $data = [
                            'storeID'=>$storeId,
                            'unitID' => $storeBankDetail,
                            'type' => '0',
                            'file_name' =>  $dynamicImageName,
                            'file_type'  => $file->getClientMimeType()
                        ];    
                        $company->addUnitPlantImages($data);
                    }                
                }
            }
            if ($this->request->getFileMultiple('plant_videos')) {    
                foreach($this->request->getFileMultiple('plant_videos') as $file)
                {   
                    if ($file->isValid() && ! $file->hasMoved())
                    {
                        $dynamicImageName = $file->getRandomName();
                        $file->move(WRITEPATH . 'uploads', $dynamicImageName);
                        $data = [
                            'storeID'=>$storeId,
                            'unitID' => $storeBankDetail,
                            'type' => '1',
                            'file_name' =>  $dynamicImageName,
                            'file_type'  => $file->getClientMimeType()
                        ];    
                        $company->addUnitPlantImages($data);
                    }                
                }
            }

            return redirect()->to(base_url('companyRegistration/5'));
        } else{
            $session->set('loginError','Session Time Out');
            return redirect()->to(base_url('login'));
        }
       
    }
}
