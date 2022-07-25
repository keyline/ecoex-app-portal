<?php

namespace App\Controllers\Brand; // Controller namespace

use App\Controllers\BaseController;
use App\Models\Brand;
use App\Models\CommonModel;
use App\Models\Company;
class DashboardController extends BaseController
{
	public function index()
	{
        $session = \Config\Services::session($config);
        $userId = $session->get('storeId');
        if(isset($userId)){
            return view('brand/index');
        } else {
            return redirect()->to(base_url('login'));
        }
	}	
	public function myDashboard()
	{	    
    $session = \Config\Services::session($config);
    $storeId = $session->get('storeId');
    $userId = $session->get('brandUserId');
    if(isset($userId)){
        
      $dashboard =new Brand();
      $userData = $dashboard->getUserDataByID($userId);      
      $data['userData'] = $userData;
      $data['contoroller'] = $dashboard;

      $commonModel              = new CommonModel();
      $data['commonModel']      = $commonModel;
      $join[0]                  = ['table' => 'ecoex_target', 'field' => 'target_id', 'table_master' => 'ecoex_target_inquiry', 'field_table_master' => 'target_id', 'type' => 'INNER'];
      $join[1]                  = ['table' => 'ecoex_business_category', 'field' => 'id', 'table_master' => 'ecoex_target', 'field_table_master' => 'categoryId', 'type' => 'INNER'];      
      $data['currentInquiries'] = $commonModel->find_data('ecoex_target_inquiry', 'array', ['ecoex_target_inquiry.inquiry_status' => 0, 'ecoex_target_inquiry.c_id' => $userId], 'ecoex_target_inquiry.*, ecoex_target.*, ecoex_business_category.name AS categoryName', $join);
      $data['pastInquiries'] = $commonModel->find_data('ecoex_target_inquiry', 'array', ['ecoex_target_inquiry.inquiry_status' => 1, 'ecoex_target_inquiry.c_id' => $userId], 'ecoex_target_inquiry.*, ecoex_target.*, ecoex_business_category.name AS categoryName', $join);
      //pr($data);
      
      return view('brand/index',$data);
    } else {
      return redirect()->to(base_url('login'));
    }
	}
  public function sendVerificationLink()
  {
    $email                  = $this->request->getPost('email');
    $linkType               = $this->request->getPost('linkType');
    $company                = new Company(); 
    $this->common_model     = new CommonModel();
    $user                   = $this->common_model->find_data('ecoex_user_table', 'row', ['user_email' => $email]);
    $emailCode              = bin2hex(random_bytes(16));
    $data = [
            'c_id' => $user->user_id,
            'link' => $emailCode
    ];
    $company->setEmailCode($data);                
    $verificationEmailTemplate  = $company->getVerificationEmail();
    $to                         = $companyUserData[0]['user_email'];
    $subject                    = $verificationEmailTemplate->subject;                      
    $verificationLink           = site_url('').'emailVerify/'.$emailCode;                
    $emailTemplate              = str_replace("{name}", $companyUserData[0]['user_name'], $verificationEmailTemplate->content);
    $emailTemplate1             = str_replace("{company}", $companyData[0]['c_name'], $emailTemplate);                
    $mailBody                   = str_replace("{link}", $verificationLink, $emailTemplate1);
    $this->common_model->sendEmail($email, $subject, $mailBody);
    $apiStatus                  = TRUE;
    $apiMessage                 = 'Verification Email Sent To Your Registered Email Address Successfully !!!';
    $apiResponse                = ['linkType' => $linkType];
    $data                       = ['status' => $apiStatus, 'message' => $apiMessage, 'response' => $apiResponse];
    header('Content-type: application/json');
    echo json_encode($data);
  }
	public function target()
	{ 
    $session                = \Config\Services::session($config);
    $storeId                = $session->get('storeId');
    $userId                 = $session->get('brandUserId');
    $this->common_model     = new CommonModel();
    if(isset($userId)){
        
      $dashboard                  = new Brand();
      $userData                   = $dashboard->getUserDataByID($userId);
      $categoryData               = $dashboard->getBusinessMainCategoryList();
      $unitData                   = $dashboard->getUnitList();
      $data['documentRequires']   = $this->common_model->find_data('ecoex_document_list', 'array', ['published' => 1]);
      $data['categoryData']       = $categoryData;
      $data['user_member_type']   = $userData->user_membership_type;
      $data['userData']           = $userData;
      $data['unitData']           = $unitData;
      $data['contoroller']        = $dashboard;
      $data['session']            = $session;
      return view('brand/target',$data);
    } else {
      return redirect()->to(base_url('login'));
    }
	}	
	public function targetList()
	{ 
    $session = \Config\Services::session($config);
    $storeId = $session->get('storeId');
    $userId = $session->get('brandUserId');
    $this->common_model  = new CommonModel();
    if(isset($userId)){
        
      $dashboard =new Brand();
      $userData = $dashboard->getUserDataByID($userId);
      $targetData = $dashboard->getTargetList($storeId);
      $unitData = $dashboard->getUnitList();
      
      $data['targetData'] = $targetData;
      $data['userId'] = $userId;
      $data['userData'] = $userData;
      $data['unitData'] = $unitData;
      $data['contoroller'] = $dashboard;
      $data['common_model'] = $this->common_model;
      $data['session'] = $session;

      if($this->request->getPost()){
        $target_id = $this->request->getPost('target_id');
        $user_id = $this->request->getPost('user_id');
        $this->db = \Config\Database::connect();
        $this->db->query("UPDATE ecoex_business_inquiries SET is_display = 0 WHERE `buyer_type` = 'Brand' AND `inventory_id` = '$target_id'");
        if(count($user_id)>0){
          for($u=0;$u<count($user_id);$u++){
            $this->db->query("UPDATE ecoex_business_inquiries SET is_display = 1 WHERE `buyer_type` = 'Brand' AND `inventory_id` = '$target_id' AND  `seller_id` = '$user_id[$u]'");
          }
        }
        $this->db->query("UPDATE ecoex_target SET visibility = 1 WHERE `target_id` = '$target_id'");
        $session->setFlashdata('success_message', 'Post Successfully Mark As Private !!!');
        return redirect()->to(base_url('/brand/targetList'));
      }

      return view('brand/targetList',$data);
    } else {
      return redirect()->to(base_url('login'));
    }
	}
	public function addTargetByState()
	{ 
    $session = \Config\Services::session($config);
    $storeId = $session->get('storeId');
    $userId = $session->get('brandUserId');
    $targetID = $session->get('targetID');
    if(isset($userId)){
        
      $dashboard =new Brand();
      $userData = $dashboard->getUserDataByID($userId);
      $categoryData = $dashboard->getBusinessMainCategoryList();
      $unitData = $dashboard->getUnitList();
      $stateData = $dashboard->getStateList();
      $targetData = $dashboard->getTargetDataByID($targetID);
      
      $data['targetData'] = $targetData;
      $data['categoryData'] = $categoryData;
      
      $data['userData'] = $userData;
      $data['stateData'] = $stateData;
      $data['unitData'] = $unitData;
      $data['contoroller'] = $dashboard;
      
      return view('brand/addTargetByState',$data);
    } else {
      return redirect()->to(base_url('login'));
    }
	}	
	public function addTargetByDistrict()
	{ 
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('brandUserId');
        $targetID = $session->get('targetID');
        if(isset($userId)){
            
          $dashboard =new Brand();
          $userData = $dashboard->getUserDataByID($userId);
          $categoryData = $dashboard->getBusinessMainCategoryList();
          $unitData = $dashboard->getUnitList();
          $targetDataByState = $dashboard->getTargetDataByState($targetID);
          $targetData = $dashboard->getTargetDataByID($targetID);
          
          $data['targetData'] = $targetData;
          $data['targetDataByState'] = $targetDataByState;
          $data['categoryData'] = $categoryData;
          
          $data['userData'] = $userData;
          $data['stateData'] = $stateData;
          $data['unitData'] = $unitData;
          $data['contoroller'] = $dashboard;
          
            return view('brand/addTargetByDistrict',$data);
        } else {
            return redirect()->to(base_url('login'));
        }
	}
	public function addTargetByCity()
	{ 
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('brandUserId');
        $targetID = $session->get('targetID');
        if(isset($userId)){
            
          $dashboard =new Brand();
          $userData = $dashboard->getUserDataByID($userId);
          $categoryData = $dashboard->getBusinessMainCategoryList();
          $unitData = $dashboard->getUnitList();
          $targetDataByState = $dashboard->getTargetDataByState($targetID);
          $targetData = $dashboard->getTargetDataByID($targetID);
          
          $data['targetData'] = $targetData;
          $data['targetDataByState'] = $targetDataByState;
          $data['categoryData'] = $categoryData;
          
          $data['userData'] = $userData;
          $data['stateData'] = $stateData;
          $data['unitData'] = $unitData;
          $data['contoroller'] = $dashboard;
          
            return view('brand/addTargetByCity',$data);
        } else {
            return redirect()->to(base_url('login'));
        }
	}
	public function addTargetData()
	{
    $session = \Config\Services::session($config);
    $storeId = $session->get('storeId');
    $userId = $session->get('brandUserId');
    if(isset($userId)){
        
      $dashboard = new Brand();
      $inventory_type = $this->request->getPost('inventory_type');
      $document_required = (($this->request->getPost('document_required') != '')?$this->request->getPost('document_required'):[]);

      if($inventory_type == 'BUY'){
          if(count($document_required)<=0){
              $session->setFlashdata('error_message', 'You Have To select At Least One Document !!!');
              return redirect()->to(base_url('brand/target'));
          }
      }
      
      $data = [
              'storeId'           => $storeId,
              'inventory_type'    => $this->request->getPost('inventory_type'),
              'category'          => $this->request->getPost('category'),
              'subCategory'       => $this->request->getPost('subCategory'),
              'product'           => $this->request->getPost('product'),
              'item'              => $this->request->getPost('item'),
              'year'              => $this->request->getPost('year'),
              'month'             => $this->request->getPost('month'),
              'qty'               => $this->request->getPost('qty'),
              'unit'              => $this->request->getPost('unit'),
              'document_required' => json_encode((!empty($document_required)?$this->request->getPost('document_required'):[]))
      ];
      //pr($data);
      $lastInsertedTargetID = $dashboard->addTargetData($data);          
      $session->set('targetID',$lastInsertedTargetID);          
      return redirect()->to(base_url('brand/addTargetByState'));
    } else {
      return redirect()->to(base_url('login'));
    }
	}
	public function addTargetByStateData()
	{
    $session = \Config\Services::session($config);
    $storeId = $session->get('storeId');
    $userId = $session->get('brandUserId');
    $targetID = $session->get('targetID');
    if(isset($userId)){
        
      $stateData =  $this->request->getPost('state');
      $qtyData =  $this->request->getPost('qty');
      
      $dashboard =new Brand();
      
      $data = [
              'storeId'=>$storeId,
              'targetId'=>$targetID,
              'stateData'=>$stateData,
              'qty'=>$qtyData
      ];
      //pr($data);die;
      $lastInsrtTrgtStatID = $dashboard->addTargetByStateData($data);
      
      return redirect()->to(base_url('brand/targetList'));
    } else {
      return redirect()->to(base_url('login'));
    }
	}
	public function addTargetByDistrictData()
	{ 
	    //echo 'success';exit;
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('brandUserId');
        $targetID = $session->get('targetID');
        if(isset($userId)){
            
          $stateId =  $this->request->getPost('stateId');
          $districtData =  $this->request->getPost('district');
          $qtyData =  $this->request->getPost('qty');
          
          $dashboard =new Brand();
          
            $data = [
                    'storeId'=>$storeId,
                    'targetId'=>$targetID,
                    'stateId'=>$stateId,
                    'districtData'=>$districtData,
                    'qty'=>$qtyData
            ];
          $lastInsrtTrgtDistrictID = $dashboard->addTargetByDistrictData($data);
          
            return redirect()->to(base_url('brand/addTargetByCity'));
        } else {
            return redirect()->to(base_url('login'));
        }
	}
	public function addTargetByCityData()
	{ 
	    //echo 'success';exit;
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('brandUserId');
        $targetID = $session->get('targetID');
        if(isset($userId)){
            
          $stateId =  $this->request->getPost('stateId');
          $districtId =  $this->request->getPost('districtId');
          $cityData =  $this->request->getPost('city');
          $qtyData =  $this->request->getPost('qty');
          
          $dashboard =new Brand();
          
            $data = [
                    'storeId'=>$storeId,
                    'targetId'=>$targetID,
                    'stateId'=>$stateId,
                    'districtId'=>$districtId,
                    'cityData'=>$cityData,
                    'qty'=>$qtyData
            ];
          $lastInsrtTrgtCityID = $dashboard->addTargetByCityData($data);
          
            return redirect()->to(base_url('brand/addTargetByCity'));
        } else {
            return redirect()->to(base_url('login'));
        }
	}
	public function setTargetId($id)
	{ 
        $session = \Config\Services::session($config);
        
        $session->set('targetID',$id);
        return redirect()->to(base_url('brand/editTarget'));
	}
	public function setStateTargetId($id)
	{ 
        $session = \Config\Services::session($config);
        
        $session->set('targetID',$id);
        return redirect()->to(base_url('brand/addTargetByState'));
	}
	public function editTarget()
	{ 
    $session                      = \Config\Services::session($config);
    $storeId                      = $session->get('storeId');
    $userId                       = $session->get('brandUserId');
    $targetID                     = $session->get('targetID');
    $this->common_model           = new CommonModel();
    if(isset($userId)){
        
      $dashboard                  = new Brand();
      $userData                   = $dashboard->getUserDataByID($userId);
      $categoryData               = $dashboard->getBusinessMainCategoryList();
      $unitData                   = $dashboard->getUnitList();
      $targetData                 = $dashboard->getTargetDataByID($targetID);
      $data['documentRequires']   = $this->common_model->find_data('ecoex_document_list', 'array', ['published' => 1]);
      $data['categoryData']       = $categoryData;
      $data['targetData']         = $targetData;
      $data['user_member_type']   = $userData->user_membership_type;
      $data['userData']           = $userData;
      $data['unitData']           = $unitData;
      $data['contoroller']        = $dashboard;
      $data['session']            = $session;
      return view('brand/editTarget',$data);
    } else {
      return redirect()->to(base_url('login'));
    }
	}
	public function editTargetData()
	{ 
    //echo 'success';exit;
    $session = \Config\Services::session($config);
    $storeId = $session->get('storeId');
    $userId = $session->get('brandUserId');
    $targetID = $session->get('targetID');
    if(isset($userId)){
            
      $dashboard = new Brand();
      $removeQty = 'false';
      if($this->request->getPost('qty') < $this->request->getPost('stateAllocateValue')){
          $removeQty = 'true';
      }

      $inventory_type     = $this->request->getPost('inventory_type');
      $document_required  = (($this->request->getPost('document_required') != '')?$this->request->getPost('document_required'):[]);
      if($inventory_type == 'BUY'){
          if(count($document_required)<=0){
              $session->setFlashdata('error_message', 'You Have To select At Least One Document !!!');
              return redirect()->to(base_url('user/inventory'));
          }
      }
          
      $data = [
              'storeId'               => $storeId,
              'targetID'              => $targetID,
              'inventory_type'        => $this->request->getPost('inventory_type'),
              'category'              => $this->request->getPost('category'),
              'subCategory'           => $this->request->getPost('subCategory'),
              'product'               => $this->request->getPost('product'),
              'item'                  => $this->request->getPost('item'),
              'year'                  => $this->request->getPost('year'),
              'month'                 => $this->request->getPost('month'),
              'qty'                   => $this->request->getPost('qty'),
              'unit'                  => $this->request->getPost('unit'),
              'removeQty'             => $removeQty,
              'document_required'     => json_encode((!empty($document_required)?$this->request->getPost('document_required'):[]))
            ];
     $dashboard->editTargetData($data);          
      return redirect()->to(base_url('brand/addTargetByState'));
    } else {
      return redirect()->to(base_url('login'));
    }
	}
	public function logout()
	{ 
    $session = \Config\Services::session($config);
    $session->remove('storeId');
    $session->remove('brandUserId');
    $session->remove('userId');
    return redirect()->to(base_url('login'));
	}	
	public function manageQuotes()
	{ 
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('brandUserId');
        if(isset($userId)){
            
          $dashboard =new Brand();
          
            return view('brand/manageQuotes');
        } else {
            return redirect()->to(base_url('login'));
        }
	}
	public function manageQuotesInquiry($id)
	{ 
    $session = \Config\Services::session($config);
    $storeId = $session->get('storeId');
    $userId = $session->get('brandUserId');
    if(isset($userId)){            
      $dashboard = new Brand();          
      return view('brand/manageQuotesInquiry');
    } else {
      return redirect()->to(base_url('login'));
    }
	}
	public function manageQuotesBid($id)
	{ 
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('brandUserId');
        if(isset($userId)){
            
          $dashboard =new Brand();
          
            return view('brand/manageQuotesBid');
        } else {
            return redirect()->to(base_url('login'));
        }
	}
	public function marketplace()
	{ 
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('brandUserId');
        if(isset($userId)){
            
          $dashboard =new Brand();
          
            return view('brand/marketplace');
        } else {
            return redirect()->to(base_url('login'));
        }
	}	
	public function manageOrders()
	{ 
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('brandUserId');
        if(isset($userId)){
            
          $dashboard =new Brand();
          
            return view('brand/manageOrders');
        } else {
            return redirect()->to(base_url('login'));
        }
	}
	public function manageInventory()
	{ 
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('brandUserId');
        if(isset($userId)){
            
          $dashboard =new Brand();
          
            return view('brand/manageInventory');
        } else {
            return redirect()->to(base_url('login'));
        }
	}
	public function manageTeam()
	{ 
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('brandUserId');
        if(isset($userId)){
            
          $dashboard =new Brand();
          
            return view('brand/manageTeam');
        } else {
            return redirect()->to(base_url('login'));
        }
	}
	public function companyDetails()
	{ 
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('brandUserId');
        if(isset($userId)){
            
          $dashboard =new Brand();
          
            return view('brand/companyDetails');
        } else {
            return redirect()->to(base_url('login'));
        }
	}
	public function setting()
	{ 
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('brandUserId');
        if(isset($userId)){
            
          $dashboard =new Brand();
          
            return view('brand/setting');
        } else {
            return redirect()->to(base_url('login'));
        }
	}
	public function targetToInquiry($id)
	{ 
    $session                = \Config\Services::session($config);
    $this->common_model     = new CommonModel();
    $storeId                = $session->get('storeId');
    $userId                 = $session->get('brandUserId');
    $id                     = decoded($id);
    if(isset($userId)){        
      $dashboard        = new Brand();
      $userData         = $dashboard->getUserDataByID($userId);
            
      $data['documentRequireds'] = $this->common_model->find_data('ecoex_document_list', 'array', ['published' => 1]);      
      $data['targetID'] = $id;
      $data['target_details_ids'] = $this->common_model->find_data('ecoex_target_by_state', 'array', ['target_id' => $id], 'id');
      $data['userData'] = $userData;
      $data['contoroller'] = $dashboard;      
      return view('brand/targetToInquiry',$data);
    } else {
      return redirect()->to(base_url('login'));
    }
	}	
	public function targetToInquiryData()
	{
    $session = \Config\Services::session($config);
    $storeId = $session->get('storeId');
    $userId = $session->get('brandUserId');
    $this->common_model  = new CommonModel();
    if(isset($userId)){            
      $dashboard =new Brand();          
      $uploadedAttachment = '';
      if($imagefile = $this->request->getFiles())
      {
          if($img = $imagefile['attachment'])
          {
              if ($img->isValid() && ! $img->hasMoved())
              {
                $uploadedAttachment = $img->getRandomName(); //This is if you want to change the file name to encrypted name
                $img->move(WRITEPATH.'uploads', $uploadedAttachment);
              }
          }
      }
      //pr($this->request->getPost());
      $documentRequired = json_encode($this->request->getPost('requiredDocument'));
      $member_type      = $this->request->getPost('member_type');
      $target_state_wise_ids = explode(",", $this->request->getPost('target_state_wise_ids'));
      if(count($target_state_wise_ids)>0){
        for($p=0;$p<count($target_state_wise_ids);$p++){

          if(count($member_type)>0){
            for($q=0;$q<count($member_type);$q++){
              $getMembers = $this->common_model->find_data('ecoex_user_table', 'array', ['user_membership_type' => $member_type[$q], 'userStatus' => 2]);
              if($getMembers){
                foreach($getMembers as $getMember){

                  /* inquiry number generate */                    
                    $orderBy[0]   = ['field' => 'id', 'type' => 'DESC'];
                    $checkInquiry = $this->common_model->find_data('ecoex_business_inquiries', 'row', '', '', '', '', $orderBy);
                    if($checkInquiry){
                      $slNo = $checkInquiry->sl_no+1;
                      $inquiry_no = str_pad($slNo,6,0,STR_PAD_LEFT);
                    } else {
                      $slNo = 1;
                      $inquiry_no = str_pad($slNo,6,0,STR_PAD_LEFT);
                    }
                  /* inquiry number generate */
                  $getTargetDetails = $this->common_model->find_data('ecoex_target_by_state', 'row', ['id' => $target_state_wise_ids[$p]]);
                  $getMemberTypeName = $this->common_model->find_data('ecoex_member_category', 'row', ['member_id' => $getMember->user_membership_type]);
                  $fields = [
                          'sl_no'                   => $slNo,
                          'inquiry_no'              => $inquiry_no,
                          'buyer_type'              => 'Brand',
                          'buyer_id'                => $userId,
                          'seller_type'             => (($getMemberTypeName)?$getMemberTypeName->member_type:''),
                          'seller_id'               => $getMember->user_id,
                          'inventory_id'            => $this->request->getPost('target_id'),
                          'inventory_details_id'    => $target_state_wise_ids[$p],
                          'require_qty'             => (($getTargetDetails)?$getTargetDetails->req_qty:0),
                          'inquiry_start_date'      => date_format(date_create($this->request->getPost('inquiry_start_date')), "Y-m-d"),
                          'inquiry_start_time'      => date_format(date_create($this->request->getPost('inquiry_start_time')), "H:i:s"),
                          'inquiry_end_date'        => date_format(date_create($this->request->getPost('inquiry_end_date')), "Y-m-d"),
                          'inquiry_end_time'        => date_format(date_create($this->request->getPost('inquiry_end_time')), "H:i:s"),
                          'description'             => $this->request->getPost('description'),
                          'attachment'              => $uploadedAttachment,
                          'require_documents'       => $documentRequired
                  ];
                  //pr($fields,false);
                  $this->common_model->save_data('ecoex_business_inquiries', $fields, '', 'id');
                  
                  /* inventory */                      
                      $join2[0]                 = ['table' => 'ecoex_target_by_state', 'field' => 'target_id', 'table_master' => 'ecoex_target', 'field_table_master' => 'target_id', 'type' => 'INNER'];
                      $conditions               = ['ecoex_target_by_state'.'.id' => $target_state_wise_ids[$p]];
                      $inventory                = $this->common_model->find_data('ecoex_target', 'row', $conditions, '', $join2);
                      //$db = \Config\Database::connect();
                      //echo $db->getLastQuery();
                      //pr($inventory);
                      //die;
                  /* inventory */

                  /* business inquiry email */
                    $fields['site_setting'] = $this->common_model->find_data('ecoex_setting', 'row');
                    $fields['common_model'] = $this->common_model;
                    $fields['inventory']    = $inventory;
                    $html                   = view('email-template/inquiry-request',$fields);
                    $subject                = 'New Inquiry '.$inquiry_no.' :: '.$fields['site_setting']->websiteName;
                    //echo $html;
                    $this->common_model->sendEmail((($getMember)?$getMember->user_email:''),$subject,$html);
                  /* business inquiry email */

                  /* insert email logs */
                    $insertData = [
                        'userID'    => (($getMember)?$getMember->user_id:''),
                        'email'     => $html
                    ];
                    $this->common_model->save_data('ecoex_email_log', $insertData, '', 'id');
                  /* insert email logs */

                }
              }
            }
          }

        }
      }
      $updatetarget = $this->common_model->save_data('ecoex_target', ['inquiry_status' => 1], $this->request->getPost('target_id'), 'target_id');
      return redirect()->to(base_url('brand/targetList'));
    } else {
      return redirect()->to(base_url('login'));
    }
	}
	public function manageInquiries()
  { 
    $session = \Config\Services::session($config);
    $storeId = $session->get('storeId');
    $userId = $session->get('brandUserId');    
    if(isset($userId)){        
      $commonModel              = new CommonModel();
      $data['commonModel']      = $commonModel;
      $join[0]                  = ['table' => 'ecoex_target', 'field' => 'target_id', 'table_master' => 'ecoex_target_inquiry', 'field_table_master' => 'target_id', 'type' => 'INNER'];
      $join[1]                  = ['table' => 'ecoex_business_category', 'field' => 'id', 'table_master' => 'ecoex_target', 'field_table_master' => 'categoryId', 'type' => 'INNER'];
      $order[0]                 = ['field' => 'ecoex_target_inquiry.inquiry_id', 'type' => 'DESC'];
      $data['currentInquiries'] = $commonModel->find_data('ecoex_target_inquiry', 'array', ['ecoex_target_inquiry.inquiry_status' => 0, 'ecoex_target_inquiry.c_id' => $userId], 'ecoex_target_inquiry.*, ecoex_target.*, ecoex_business_category.name AS categoryName', $join,'',$order);
      $data['pastInquiries'] = $commonModel->find_data('ecoex_target_inquiry', 'array', ['ecoex_target_inquiry.inquiry_status' => 1, 'ecoex_target_inquiry.c_id' => $userId], 'ecoex_target_inquiry.*, ecoex_target.*, ecoex_business_category.name AS categoryName', $join,'',$order);
      //pr($data);
      return view('brand/manageInquiries', $data);
    } else {
      return redirect()->to(base_url('login'));
    }
  }
  public function manageInquiriesDetails($inquiry_id)
  { 
    $session = \Config\Services::session($config);
    $storeId = $session->get('storeId');
    $userId = $session->get('brandUserId');
    if(isset($userId)){        
      $dashboard              =  new Brand();
      $this->common_model     = new CommonModel();
      $data['common_model']   = $this->common_model;
      $join[0]                = ['table' => 'ecoex_target', 'field' => 'target_id', 'table_master' => 'ecoex_target_inquiry', 'field_table_master' => 'target_id', 'type' => 'INNER'];
      $select                 = 'ecoex_target_inquiry.*, ecoex_target.*';
      $data['inquiryDetail']  = $this->common_model->find_data('ecoex_target_inquiry', 'row', ['ecoex_target_inquiry.inquiry_id' => $inquiry_id], $select, $join);
      if(!empty($data['inquiryDetail'])){
        $data['user'] = $this->common_model->find_data('ecoex_company', 'row', ['c_id' => $data['inquiryDetail']->c_id]);
      } else {
        $data['user'] = [];
      }
      //pr($data['inquiryDetail']);
      return view('brand/manageInquiriesDetails', $data);
    } else {
      return redirect()->to(base_url('login'));
    }
  }
  public function closeInquiry($inquiry_id)
  {   
    $session = \Config\Services::session($config);
    $storeId = $session->get('storeId');
    $userId = $session->get('brandUserId');
    if(isset($userId)){
      $this->common_model     = new CommonModel();      
      $this->common_model->save_data('ecoex_target_inquiry', ['inquiry_status' => 1], $inquiry_id, 'inquiry_id');      
      return redirect()->to(base_url('brand/manageInquiries'));
    } else {
      return redirect()->to(base_url('login'));
    }
  }
  /* change password */
    public function changePassword()
    {
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('brandUserId');
        if(isset($userId)){            
            $this->common_model     = new CommonModel();            
            $data['page_header']    = 'Change Password';          
            $data['storeId']        = $storeId;          
            $data['userId']         = $userId;          
            return view('brand/change-password',$data);
        } else {
            return redirect()->to(base_url('login'));
        }
    }
    public function updateChangePassword(){        
        $user_id = $this->request->getPost('user_id');
        $old_password = $this->request->getPost('old_password');
        $new_password = $this->request->getPost('new_password');
        $confirm_confirm = $this->request->getPost('confirm_confirm');
        $apiStatus = FALSE;
        $apiMessage = '';
        $apiResponse = [];
        $this->common_model     = new CommonModel();
        $user                   = $this->common_model->find_data('ecoex_user_table', 'row', ['user_id' => $user_id]);
        if($user){
            if($user->user_password != ''){                
                if($user->user_password == md5($old_password)){
                    if($new_password == $confirm_confirm){
                        $updatePassword = $this->common_model->save_data('ecoex_user_table', ['user_password' => md5($new_password)], $user_id, 'user_id');
                        $apiStatus = TRUE;
                        $apiMessage = 'Password Changed Successfully !!!';
                    } else {
                        $apiStatus = FALSE;
                        $apiMessage = 'Password Not Matched !!!';
                    }
                } else {
                    $apiStatus = FALSE;
                    $apiMessage = 'Old Password Is Incorrect !!!';
                }
            } else {
                $apiStatus = TRUE;
                $apiMessage = 'Password Yet Not Set By User. Please Set Password !!!';
            }            
        } else {
            $apiStatus = FALSE;
            $apiMessage = 'User Not Found !!!';
        }
        $data = ['status' => $apiStatus, 'message' => $apiMessage, 'response' => $apiResponse];
        header('Content-type: application/json');
        echo json_encode($data);
    }
  /* change password */
  /* profile setting */
    public function profileSettings()
    {
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('brandUserId');
        if(isset($userId)){            
            $this->common_model     = new CommonModel();
            $data['profile']        = $this->common_model->find_data('ecoex_user_table', 'row', ['user_id' => $userId]);
            $data['page_header']    = 'Profile Settings';          
            $data['storeId']        = $storeId;          
            $data['userId']         = $userId;          
            return view('brand/profile-settings',$data);
        } else {
            return redirect()->to(base_url('login'));
        }
    }
    public function updateProfileSettings(){        
        $user_id = $this->request->getPost('user_id');
        $user_name = $this->request->getPost('user_name');
        $user_email = $this->request->getPost('user_email');
        $user_mobile = $this->request->getPost('user_mobile');
        $apiStatus = FALSE;
        $apiMessage = '';
        $apiResponse = [];
        $this->common_model     = new CommonModel();
        $checkEmail             = $this->common_model->find_data('ecoex_user_table', 'row', ['user_id!=' => $user_id, 'user_email' => $user_email]);
        if($checkEmail){
            $apiStatus = FALSE;
            $apiMessage = 'Email Already Exists !!!';
        } else {
            $checkMobile        = $this->common_model->find_data('ecoex_user_table', 'row', ['user_id!=' => $user_id, 'user_mobile' => $user_mobile]);
            if($checkMobile){
                $apiStatus = FALSE;
                $apiMessage = 'Mobile Already Exists !!!';
            } else {
                $updatePassword = $this->common_model->save_data('ecoex_user_table', ['user_name' => $user_name, 'user_email' => $user_email, 'user_mobile' => $user_mobile], $user_id, 'user_id');
                $apiStatus = TRUE;
                $apiMessage = 'Profile Updated Successfully !!!';
            }
        }
        $data = ['status' => $apiStatus, 'message' => $apiMessage, 'response' => $apiResponse];
        header('Content-type: application/json');
        echo json_encode($data);
    }
  /* profile setting */
  /* change visibility */
    public function changeVisibility()
    {        
      $inventoryId        = $this->request->getPost('inventoryId');
      $visibilityVal      = $this->request->getPost('visibilityVal');
      $link               = $this->request->getPost('link');
      $apiStatus          = FALSE;
      $apiMessage         = '';
      $apiResponse        = [];
      $this->common_model     = new CommonModel();
      $updatePassword = $this->common_model->save_data('ecoex_target', ['visibility' => $visibilityVal], $inventoryId, 'target_id');
      $apiStatus = TRUE;
      $this->db = \Config\Database::connect();
      $this->db->query("UPDATE ecoex_business_inquiries SET is_display = 1 WHERE `buyer_type` = 'Brand' AND `inventory_id` = '$inventoryId'");

      if($visibilityVal){
          $apiMessage = 'Inventory Visible To Only Registered Users !!!';
      } else {
          $apiMessage = 'Inventory Visible To All Users !!!';
      }
      $apiResponse['link'] = $link;
      $data = ['status' => $apiStatus, 'message' => $apiMessage, 'response' => $apiResponse];
      header('Content-type: application/json');
      echo json_encode($data);
    }
  /* change visibility */
  /* get main category */
    public function getMainCategory(){
        $apiStatus              = TRUE;
        $apiMessage             = '';
        $apiResponse            = [];
        $this->common_model     = new CommonModel();
        $inventoryType          = $this->request->getGet('inventoryType');
        $memberType             = $this->request->getGet('memberType');
        $this->db               = \Config\Database::connect();
        $sql                    = "SELECT bc.id,bc.name FROM `ecoex_business_category_options` AS bco INNER JOIN ecoex_business_category AS bc ON bc.id=bco.category_id WHERE bco.`member_category_id` = '$memberType' AND bco.`options` LIKE '%$inventoryType%' AND bc.`parent` = 0";
        $mainCats               = $this->db->query($sql)->getResult();        
        $apiResponse            = $mainCats;
        $data = ['status' => $apiStatus, 'message' => $apiMessage, 'response' => $apiResponse];
        header('Content-type: application/json');
        echo json_encode($data);
    }
  /* get main category */

  /* inquiry module */
    public function inquiryList()
    { 
        $session                = \Config\Services::session();
        $storeId                = $session->get('storeId');
        $userId                 = $session->get('brandUserId');        
        if(isset($userId)){
            $this->common_model     = new CommonModel();

            /* inquiry data */
            $orderBy[0]                         = ['field' => 'id', 'type' => 'DESC']; 
            $data['submittedInquiries']         = $this->common_model->find_data('ecoex_business_inquiries', 'array', ['seller_id' => $session->get('userId'), 'published' => 0, 'is_display' => 1], '', '', '', $orderBy);
            $data['documentUploadedInquiries']  = $this->common_model->find_data('ecoex_business_inquiries', 'array', ['seller_id' => $session->get('userId'), 'published' => 1, 'is_display' => 1], '', '', '', $orderBy);

            $this->db   = \Config\Database::connect();
            $userId     = $session->get('userId');
            $data['adminApprovedInquiries']     = $this->db->query("SELECT * FROM ecoex_business_inquiries WHERE published = 2 AND is_display =1 AND (seller_id = '$userId' OR buyer_id = '$userId') ORDER BY id DESC")->getResult();
            $data['buyerAcceptInquiries']       = $this->db->query("SELECT * FROM ecoex_business_inquiries WHERE published = 3 AND is_display =1 AND (seller_id = '$userId' OR buyer_id = '$userId') ORDER BY id DESC")->getResult();
            $data['poUploadInquiries']          = $this->db->query("SELECT * FROM ecoex_business_inquiries WHERE published = 4 AND is_display =1 AND (seller_id = '$userId' OR buyer_id = '$userId') ORDER BY id DESC")->getResult();
            $data['poSharedInquiries']          = $this->db->query("SELECT * FROM ecoex_business_inquiries WHERE published = 5 AND is_display =1 AND (seller_id = '$userId' OR buyer_id = '$userId') ORDER BY id DESC")->getResult();
            $data['adminInvoicesInquiries']       = $this->db->query("SELECT * FROM ecoex_business_inquiries WHERE published = 6 AND is_display =1 AND (seller_id = '$userId' OR buyer_id = '$userId') ORDER BY id DESC")->getResult();
            /* inquiry data */          
            $data['session']                    = $session;
            $data['common_model']               = $this->common_model;
            return view('brand/inquiryList',$data);
        } else {
            return redirect()->to(base_url('login'));
        }
    }
    public function uploadInquiryDocument($id)
    { 
        $session                = \Config\Services::session();
        $storeId                = $session->get('storeId');
        $userId                 = $session->get('brandUserId');
        
        $inquiryId              = decoded($id);
        if(isset($userId)){
            $this->common_model     = new CommonModel();
            $data['common_model']   = $this->common_model;
            $data['session']        = $session;
            $data['userId']         = $userId;
            /* inquiry data */
            $data['row']            = $this->common_model->find_data('ecoex_business_inquiries', 'row', ['id' => $inquiryId]);
            /* inquiry data */
            /* inquiry documents upload */
            if($this->request->getPost()){                
                $inquiry_document_array  = $this->request->getFiles('inquiry_document')['inquiry_document'];
                $uploadedDocuments       = $this->common_model->commonFileArrayUpload('writable/uploads/', $inquiry_document_array, 'image');                
                $document_id = $this->request->getPost('document_id');
                $this->common_model->delete_data('ecoex_business_inquiry_documents', $this->request->getPost('inquiry_id'), 'inquiry_id');
                if(count($document_id)>0){
                    for($d=0;$d<count($document_id);$d++){
                        $fields = [
                            'inquiry_id'                => $this->request->getPost('inquiry_id'),
                            'inventory_details_id'      => $this->request->getPost('inventory_details_id'),
                            'document_id'               => $document_id[$d],
                            'inquiry_document'          => $uploadedDocuments[$d]
                        ];
                        $this->common_model->save_data('ecoex_business_inquiry_documents', $fields, '', 'id');                        
                    }
                }
                $this->common_model->save_data('ecoex_business_inquiries', ['published' => 1], $this->request->getPost('inquiry_id'), 'id');
                /* sent mail to admin for approval */
                $site_setting           = $this->common_model->find_data('ecoex_setting', 'row');
                $fields['site_setting'] = $site_setting;
                $fields['common_model'] = $this->common_model;
                $fields['inventory']    = $this->common_model->find_data('ecoex_business_inquiries', 'row', ['id' => $this->request->getPost('inquiry_id')]);;
                $html                   = view('email-template/inquiry-document-upload',$fields);                
                $subject                = 'Inquiry Document Uploaded :: '.$fields['site_setting']->websiteName;
                $this->common_model->sendEmail((($site_setting)?$site_setting->site_email:''),$subject,$html);
                /* sent mail to admin for approval */
                /* insert email logs */
                $insertData = [
                    'userID'    => '',
                    'email'     => $html
                ];
                $this->common_model->save_data('ecoex_email_log', $insertData, '', 'id');
                /* insert email logs */

                $session->setFlashdata('success_message', 'Documents Uploaded Successfully. Wait For Admin Approval !!!');
                return redirect()->to(base_url('brand/inquiryList'));
            }
            /* inquiry documents upload */            
            return view('brand/uploadInquiryDocument',$data);
        } else {
            return redirect()->to(base_url('login'));
        }
    }
    public function inquiryAcceptDocument($id){
        $session                = \Config\Services::session();
        $userId                 = $session->get('userId');
        $inquiryId              = decoded($id);
        $this->common_model     = new CommonModel();
        $this->common_model->save_data('ecoex_business_inquiries', ['published' => 3], $inquiryId, 'id');

        /* sent mail to admin for approval */
        $site_setting           = $this->common_model->find_data('ecoex_setting', 'row');
        $fields['site_setting'] = $site_setting;
        $fields['common_model'] = $this->common_model;
        $fields['inventory']    = $this->common_model->find_data('ecoex_business_inquiries', 'row', ['id' => $inquiryId]);
        $html                   = view('email-template/inquiry-document-accepted',$fields);
        //echo $html;die;
        $subject                = 'Inquiry Documents Accepted :: '.$fields['site_setting']->websiteName;
        $this->common_model->sendEmail((($site_setting)?$site_setting->site_email:''),$subject,$html);
        /* sent mail to admin for approval */
        /* insert email logs */
        $insertData = [
            'userID'    => '',
            'email'     => $html
        ];
        $this->common_model->save_data('ecoex_email_log', $insertData, '', 'id');
        /* insert email logs */

        $session->setFlashdata('success_message', 'Inquiry Documents Accepted Successfully !!!');
        return redirect()->to(base_url('brand/uploadInquiryDocument/'.encoded($inquiryId)));
    }
    public function uploadPO($id){
        $session                = \Config\Services::session();
        $userId                 = $session->get('userId');
        $inquiryId              = decoded($id);
        $this->common_model     = new CommonModel();        
        $file           = $this->request->getFile('po_documents');
        $originalName   = $file->getClientName();
        $fieldName      = 'po_documents';
        $upload_array   = $this->common_model->upload_single_file($fieldName,$originalName,'','image');
        //pr($upload_array);
        if($upload_array['status']) {
            $po_documents = $upload_array['newFilename'];
        } else {
            $po_documents = '';
        }
        $fields =   [
                        'po_documents'                  => $po_documents,
                        'published'                     => 4
                    ];
        $this->common_model->save_data('ecoex_business_inquiries', $fields, $inquiryId, 'id');

        /* sent mail to admin for approval */
        $site_setting           = $this->common_model->find_data('ecoex_setting', 'row');
        $fields['site_setting'] = $site_setting;
        $fields['common_model'] = $this->common_model;
        $fields['inventory']    = $this->common_model->find_data('ecoex_business_inquiries', 'row', ['id' => $inquiryId]);
        $html                   = view('email-template/inquiry-po-upload',$fields);
        //echo $html;die;                
        $subject                = 'Inquiry PO Uploaded :: '.$fields['site_setting']->websiteName;
        $this->common_model->sendEmail((($site_setting)?$site_setting->site_email:''),$subject,$html);
        /* sent mail to admin for approval */
        /* insert email logs */
        $insertData = [
            'userID'    => '',
            'email'     => $html
        ];
        $this->common_model->save_data('ecoex_email_log', $insertData, '', 'id');
        /* insert email logs */

        $session->setFlashdata('success_message', 'PO Uploaded Successfully !!!');
        return redirect()->to(base_url('brand/inquiryList'));
    }
    public function uploadInvoice($id){
        $session                = \Config\Services::session();
        $userId                 = $session->get('userId');
        $inquiryId              = decoded($id);
        $this->common_model     = new CommonModel();        
        $file           = $this->request->getFile('invoice_from_seller');
        $originalName   = $file->getClientName();
        $fieldName      = 'invoice_from_seller';
        $upload_array   = $this->common_model->upload_single_file($fieldName,$originalName,'','pdf');
        //pr($upload_array);
        if($upload_array['status']) {
            $invoice_from_seller = $upload_array['newFilename'];
        } else {
            $invoice_from_seller = '';
        }
        $fields =   [
                        'invoice_from_seller'                   => $invoice_from_seller
                    ];
        $this->common_model->save_data('ecoex_business_inquiries', $fields, $inquiryId, 'id');

        /* sent mail to admin for approval */
        $site_setting           = $this->common_model->find_data('ecoex_setting', 'row');
        $fields['site_setting'] = $site_setting;
        $fields['common_model'] = $this->common_model;
        $fields['inventory']    = $this->common_model->find_data('ecoex_business_inquiries', 'row', ['id' => $inquiryId]);
        $html                   = view('email-template/inquiry-seller-invoice-upload',$fields);
        //echo $html;die;                
        $subject                = 'Inquiry Invoice Uploaded :: '.$fields['site_setting']->websiteName;
        $this->common_model->sendEmail((($site_setting)?$site_setting->site_email:''),$subject,$html);
        /* sent mail to admin for approval */
        /* insert email logs */
        $insertData = [
            'userID'    => '',
            'email'     => $html
        ];
        $this->common_model->save_data('ecoex_email_log', $insertData, '', 'id');
        /* insert email logs */

        $session->setFlashdata('success_message', 'Invoice Uploaded Successfully !!!');
        return redirect()->to(base_url('brand/inquiryList'));
    }
  /* inquiry module */
}