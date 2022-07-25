<?php
namespace App\Controllers\Admin; // Controller namespace

use App\Controllers\BaseController;
use App\Models\AdminAuth;
use App\Models\CommonModel;
use App\Models\Company;
class MemberController extends BaseController
{
	public function index()
	{
        $session = \Config\Services::session($config);
        $userId = $session->get('userId');
        if(isset($userId)){
            return view('admin/layout/index');
        } else {
            return redirect()->to(base_url('admin/login'));
        }
	}
	public function memberAdd()
	{
        $commonModel            = new CommonModel();
        $session                = \Config\Services::session($config);
        $userId                 = $session->get('userId');
        if(isset($userId)){
            $data = [];
            if($this->request->getPost('mode') == 'member'){                
                $postData1 = [
                    'c_name'            => $this->request->getPost('c_name'),
                    'c_status'          => 2,
                    'c_approved_by'     => 1,
                    'c_approvedTime'    => date('Y-m-d H:i:s')
                ];
                $c_id = $commonModel->save_data('ecoex_company', $postData1, '', 'c_id');
                $user_sub_member_type = json_encode($this->request->getPost('user_sub_member_type'));
                $postData2 = [
                    'c_id'                          => $c_id,
                    'user_name'                     => '',
                    'user_email'                    => $this->request->getPost('user_email'),
                    'user_email_auth'               => 1,
                    'user_email_verified_at'        => date('Y-m-d H:i:s'),
                    'user_mobile'                   => $this->request->getPost('user_mobile'),
                    'user_mobile_auth'              => 1,
                    'user_mobile_verified_at'       => date('Y-m-d H:i:s'),
                    'user_membership_type'          => $this->request->getPost('user_membership_type'),
                    'user_sub_member_type'          => $user_sub_member_type,
                    'user_password'                 => md5($this->request->getPost('user_password')),
                    'userStatus'                    => 2
                ];
                $user_id = $commonModel->save_data('ecoex_user_table', $postData2, '', 'user_id');
                $session->set('success_message','Member Registered Successfully !!!');
                return redirect()->to(base_url('admin/memberCompanyProfile/'.$c_id));
            }            
            $data['memberTypes']    = $commonModel->find_data('ecoex_member_category', 'array');            
            return view('admin/layout/addMember',$data);
        } else {
            return redirect()->to(base_url('admin/login'));
        }
	}
    public function memberCompanyProfile($id)
    {
        $commonModel            = new CommonModel();
        $session                = \Config\Services::session($config);
        $userId                 = $session->get('userId');
        $storeId                = $id;
        if(isset($userId)){
            
            $company                = new Company();
            $storeUserDetail        = $company->getStoreUserDetail($storeId);
            $storeDetail            = $company->getStoreDetail($storeUserDetail->c_id);
            $companyList            = $company->getCompanyTypeList();
            $businessCategoryList   = $company->getParentCategoryList();
            $data['storeUserData']  = $storeUserDetail;
            $data['storeData']      = $storeDetail;
            $data['companyList']    = $companyList;
            $data['categoryList']   = $businessCategoryList;
            $data['districtList']   = [];
            $data['cityList']       = [];
            $data['controller']     = $company; 
            $data['companyDetail']  = $companyDetail;
                        
            $data['memberTypes']    = $commonModel->find_data('ecoex_member_category', 'array');            
            return view('admin/layout/memberCompanyProfile',$data);
        } else {
            return redirect()->to(base_url('admin/login'));
        }
    }
    public function memberCompanyProfileStore()
    {
        $session        = \Config\Services::session($config);
        $storeId        = $this->request->getPost('storeId');
        $storeUserId    = $this->request->getPost('storeUserId');
        if(isset($storeId)){
           
          $company              = new Company();
          $businessCatChecked   = $this->request->getPost('businessCategory');
          $uploadedPancard      = '';
          $uploadedGSTcard      = '';
          $uploadedCOIcard      = '';
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
                    'storeID'=> $storeId,
                    'establishDate'         => $this->request->getPost('establishDate'),
                    'contactPerson'         => $this->request->getPost('contactPerson'),
                    'companyType'           => $this->request->getPost('companyType'),
                    'panNumber'             => $this->request->getPost('panNumber'),
                    'gstNumber'             => $this->request->getPost('gstNumber'),
                    'alMobile'              => $this->request->getPost('alMobile'),
                    'alEmail'               => $this->request->getPost('alEmail'),
                    'businessCategory'      => $busiCat,
                    'panCard'               => $uploadedPancard,
                    'GSTCard'               => $uploadedGSTcard,
                    'COICard'               => $uploadedCOIcard
            ];            
            $storeUserDetail = $company->storeCompanyRegStepOne($data);
            $dataNew = [
                    'storeID'=>$storeId,
                    'storeUserId'=>$storeUserId,
                    'contactPerson'=>$this->request->getPost('contactPerson')
            ];
            $storeUserDetail = $company->storeCompanyUserUpdate($data);            
            return redirect()->to(base_url('admin/memberAddressProfile/'.$storeId));
        } else{
            $session->set('loginError','Session Time Out');
            return redirect()->to(base_url('login'));
        }       
    }
    public function memberAddressProfile($id)
    {
        $commonModel            = new CommonModel();
        $session                = \Config\Services::session($config);
        $userId                 = $session->get('userId');
        $storeId                = $id;
        if(isset($userId)){
            
            $company                = new Company();
            $storeUserDetail        = $company->getStoreUserDetail($storeId);
            $storeDetail            = $company->getStoreDetail($storeUserDetail->c_id);
            $companyList            = $company->getCompanyTypeList();
            $businessCategoryList   = $company->getParentCategoryList();
            $data['storeUserData']  = $storeUserDetail;
            $data['storeData']      = $storeDetail;
            $data['companyList']    = $companyList;
            $data['categoryList']   = $businessCategoryList;
            $data['districtList']   = [];
            $data['cityList']       = [];
            $companyDetail          = $company->getAddressDetail($storeId);
            if(isset($companyDetail->c_state)){
                $data['districtList']   = $company->getDistrictListById($companyDetail->c_state);
                $data['cityList']       = $company->getCityListById($companyDetail->c_district);
            }            
            $data['stateList']          = $company->getStateList();

            $data['controller']     = $company; 
            $data['companyDetail']  = $companyDetail;
                        
            $data['memberTypes']    = $commonModel->find_data('ecoex_member_category', 'array');            
            return view('admin/layout/memberAddressProfile',$data);
        } else {
            return redirect()->to(base_url('admin/login'));
        }
    }
    public function memberAddressProfileStore()
    {
        $session = \Config\Services::session($config);
        $storeId = $this->request->getPost('storeId');
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
            $storeAddressDetail = $company->storeCompanyRegStepTwo($data);            
            return redirect()->to(base_url('admin/memberBankProfile/'.$storeId));
        } else{
            $session->set('loginError','Session Time Out');
            return redirect()->to(base_url('login'));
        }       
    }
    public function memberBankProfile($id)
    {
        $commonModel            = new CommonModel();
        $session                = \Config\Services::session($config);
        $userId                 = $session->get('userId');
        $storeId                = $id;
        if(isset($userId)){            
            $company                = new Company();
            $storeUserDetail        = $company->getStoreUserDetail($storeId);
            $storeDetail            = $company->getStoreDetail($storeUserDetail->c_id);
            $companyList            = $company->getCompanyTypeList();
            $businessCategoryList   = $company->getParentCategoryList();
            $data['storeUserData']  = $storeUserDetail;
            $data['storeData']      = $storeDetail;
            $data['companyList']    = $companyList;
            $data['categoryList']   = $businessCategoryList;
            $data['controller']     = $company; 
            $data['companyDetail']  = $companyDetail;                        
            $data['memberTypes']    = $commonModel->find_data('ecoex_member_category', 'array');            
            return view('admin/layout/memberBankProfile',$data);
        } else {
            return redirect()->to(base_url('admin/login'));
        }
    }
    public function memberBankProfileStore()
    {
        $session = \Config\Services::session($config);
        $storeId = $this->request->getPost('storeId');
        if(isset($storeId)){           
          $company =new Company();          
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
                    'cancelledCheque'=>$cancelledCheque
            ];            
            $storeBankDetail = $company->storeCompanyRegStepThree($data);            
            return redirect()->to(base_url('admin/approvalRequest'));
        } else{
            $session->set('loginError','Session Time Out');
            return redirect()->to(base_url('login'));
        }       
    }

	public function checkCompanyName(){
        $commonModel            = new CommonModel();
        $c_name                 = $this->request->getPost('c_name');
        $checkCompanyExist      = $commonModel->find_data('ecoex_company', 'count', ['c_name' => $c_name]);
        $apiStatus              = TRUE;
        $apiMessage             = "";
        $apiResponse            = [];
        if($checkCompanyExist <= 0){
            $apiStatus  = TRUE;
            $apiMessage = "Company Name Available !!!";
        } else {
            $apiStatus  = FALSE;
            $apiMessage = "Company Name Already Exist !!!";
        }
        $data = [ 'status' => $apiStatus, 'message' => $apiMessage, 'response' => $apiResponse ];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    public function checkMemberEmail(){
        $commonModel            = new CommonModel();
        $user_email             = $this->request->getPost('user_email');
        $checkCompanyExist      = $commonModel->find_data('ecoex_user_table', 'count', ['user_email' => $user_email]);
        $apiStatus              = TRUE;
        $apiMessage             = "";
        $apiResponse            = [];
        if($checkCompanyExist <= 0){
            $apiStatus  = TRUE;
            $apiMessage = "Email Available !!!";
        } else {
            $apiStatus  = FALSE;
            $apiMessage = "Email Already Exist !!!";
        }
        $data = [ 'status' => $apiStatus, 'message' => $apiMessage, 'response' => $apiResponse ];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    public function checkMemberPhone(){
        $commonModel            = new CommonModel();
        $user_mobile            = $this->request->getPost('user_mobile');
        $checkCompanyExist      = $commonModel->find_data('ecoex_user_table', 'count', ['user_mobile' => $user_mobile]);
        $apiStatus              = TRUE;
        $apiMessage             = "";
        $apiResponse            = [];
        if($checkCompanyExist <= 0){
            $apiStatus  = TRUE;
            $apiMessage = "Mobile Available !!!";
        } else {
            $apiStatus  = FALSE;
            $apiMessage = "Mobile Already Exist !!!";
        }
        $data = [ 'status' => $apiStatus, 'message' => $apiMessage, 'response' => $apiResponse ];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }
	
}