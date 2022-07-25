<?php
namespace App\Controllers\User; // Controller namespace
use App\Controllers\BaseController;
use App\Models\Recycler;
use App\Models\CommonModel;
use App\Models\Company;
class DashboardController extends BaseController
{
	public function index()
	{
        $session = \Config\Services::session($config);
        $userId = $session->get('storeId');
        if(isset($userId)){
            return view('dashboard/index');
        } else {
            return redirect()->to(base_url('login'));
        }
	}	
	public function myDashboard()
	{	    
        $session                = \Config\Services::session();
        $storeId                = $session->get('storeId');
        $userId                 = $session->get('recycleUserId');        
        if(isset($userId)){
            $this->common_model     = new CommonModel();
            $dashboard              = new Recycler();
            $userData               = $dashboard->getUserDataByID($userId);

            /* inquiry data */
            $orderBy[0]                         = ['field' => 'id', 'type' => 'DESC']; 
            $data['submittedInquiries']         = $this->common_model->find_data('ecoex_business_inquiries', 'array', ['seller_id' => $session->get('userId'), 'published' => 0], '', '', '', $orderBy, 5);
            $data['documentUploadedInquiries']  = $this->common_model->find_data('ecoex_business_inquiries', 'array', ['seller_id' => $session->get('userId'), 'published' => 1], '', '', '', $orderBy, 5);
            $data['adminApprovedInquiries']     = $this->common_model->find_data('ecoex_business_inquiries', 'array', ['seller_id' => $session->get('userId'), 'published' => 2], '', '', '', $orderBy, 5);
            /* inquiry data */
          
            $data['userData']                   = $userData;
            $data['contoroller']                = $dashboard;
            $data['common_model']               = $this->common_model;
            return view('user/index',$data);
        } else {
            return redirect()->to(base_url('login'));
        }
	}
	public function sendVerificationLink(){
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
	public function inventory()
	{ 
        $session                = \Config\Services::session($config);
        $storeId                = $session->get('storeId');
        $userId                 = $session->get('recycleUserId');
        $this->common_model     = new CommonModel();
        if(isset($userId)){            
            $dashboard          = new Recycler();
            $userData           = $dashboard->getUserDataByID($userId);
            $categoryData       = $dashboard->getBusinessMainCategoryList();
            $unitData           = $dashboard->getUnitList();
          
            $data['documentRequires']   = $this->common_model->find_data('ecoex_document_list', 'array', ['published' => 1]);
            $data['categoryData']       = $categoryData;
            $data['user_member_type']   = $userData->user_membership_type;
            $data['userData']           = $userData;
            $data['unitData']           = $unitData;
            $data['contoroller']        = $dashboard;
            $data['session']            = $session;
            return view('user/inventory',$data);
        } else {
            return redirect()->to(base_url('login'));
        }
	}	
	public function addInventoryData()
	{ 
	    //echo 'success';exit;
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('recycleUserId');
        if(isset($userId)){
            
          $dashboard =new Recycler();
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
            $inventory_type     = $this->request->getPost('inventory_type');
            $document_required  = (($this->request->getPost('document_required') != '')?$this->request->getPost('document_required'):[]);

            if($inventory_type == 'BUY'){
                if(count($document_required)<=0){
                    $session->setFlashdata('error_message', 'You Have To select At Least One Document !!!');
                    return redirect()->to(base_url('user/inventory'));
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
                    'attachment'        => $uploadedAttachment,
                    'document_required' => json_encode((!empty($document_required)?$this->request->getPost('document_required'):[]))
            ];
            //pr($data);die;
            $lastInsertedInventoryID = $dashboard->addInventoryData($data);          
            $session->set('inventoryID',$lastInsertedInventoryID);          
            return redirect()->to(base_url('user/addInventoryByState'));
        } else {
            return redirect()->to(base_url('login'));
        }
	}	
	public function addInventoryByState()
	{ 
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('recycleUserId');
        $inventoryID = $session->get('inventoryID');
        //echo $inventoryID;die;
        if(isset($userId)){
        
          $dashboard =new Recycler();
          $userData = $dashboard->getUserDataByID($userId);
          $categoryData = $dashboard->getBusinessMainCategoryList();
          $unitData = $dashboard->getUnitList();
          $stateData = $dashboard->getStateList();
          $inventoryData = $dashboard->getInventoryDataByID($inventoryID);
          
          $data['inventoryData'] = $inventoryData;
          $data['categoryData'] = $categoryData;
          
          $data['userData'] = $userData;
          $data['stateData'] = $stateData;
          $data['unitData'] = $unitData;
          $data['contoroller'] = $dashboard;
            return view('user/addInventoryByState',$data);
        } else {
            return redirect()->to(base_url('login'));
        }
	}	
	public function addInventoryByStateData()
	{ 
	    //echo 'success';exit;
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('recycleUserId');
        $inventoryID = $session->get('inventoryID');
        if(isset($userId)){
            
          $stateData =  $this->request->getPost('state');
          $qtyData =  $this->request->getPost('qty');
          $rateData =  $this->request->getPost('rate');
          
          $dashboard =new Recycler();
          
            $data = [
                    'storeId'=>$storeId,
                    'inventoryID'=>$inventoryID,
                    'stateData'=>$stateData,
                    'qty'=>$qtyData,
                    'rate'=>$rateData
            ];
          $lastInsrtInventoryStatID = $dashboard->addInventoryByStateData($data);
          
            return redirect()->to(base_url('user/inventoryList'));
        } else {
            return redirect()->to(base_url('login'));
        }
	}	
	public function inventoryList()
	{ 
        $session                = \Config\Services::session($config);
        $storeId                = $session->get('storeId');
        $userId                 = $session->get('recycleUserId');
        $this->common_model     = new CommonModel();
        if(isset($userId)){            
            $dashboard              = new Recycler();
            $userData               = $dashboard->getUserDataByID($userId);
            $inventoryData          = $dashboard->getInventoryList($storeId);
            $unitData               = $dashboard->getUnitList();          
            $data['inventoryData']  = $inventoryData;          
            $data['userData']       = $userData;
            $data['unitData']       = $unitData;
            $data['contoroller']    = $dashboard;
            $data['common_model']   = $this->common_model;
            return view('user/inventoryList',$data);
        } else {
            return redirect()->to(base_url('login'));
        }
	}	
	public function setInventoryId($id)
	{ 
        $session = \Config\Services::session($config);        
        $session->set('inventoryID',$id);
        return redirect()->to(base_url('user/editInventory'));
	}
	public function setStateInventoryId($id)
	{ 
        $session = \Config\Services::session($config);
        
        $session->set('inventoryID',$id);
        return redirect()->to(base_url('user/addInventoryByState'));
	}	
	public function editInventory()
	{ 
        $session                = \Config\Services::session($config);
        $storeId                = $session->get('storeId');
        $userId                 = $session->get('recycleUserId');
        $inventoryID            = $session->get('inventoryID');
        $this->common_model     = new CommonModel();
        if(isset($userId)){
            
            $dashboard                  = new Recycler();
            $userData                   = $dashboard->getUserDataByID($userId);
            $categoryData               = $dashboard->getBusinessMainCategoryList();
            $unitData                   = $dashboard->getUnitList();
            $inventoryData              = $dashboard->getInventoryDataByID($inventoryID);
            $data['documentRequires']   = $this->common_model->find_data('ecoex_document_list', 'array', ['published' => 1]);
            $data['categoryData']       = $categoryData;
            $data['inventoryData']      = $inventoryData;
            $data['user_member_type']   = $userData->user_membership_type;
            $data['userData']           = $userData;
            $data['unitData']           = $unitData;
            $data['contoroller']        = $dashboard;
            $data['session']            = $session;
            return view('user/editInventory',$data);
        } else {
            return redirect()->to(base_url('login'));
        }
	}
	public function editInventoryData()
	{ 
	    //echo 'success';exit;
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('recycleUserId');
        $inventoryID = $session->get('inventoryID');
        if(isset($userId)){
            
            $dashboard =new Recycler();
            $removeQty = 'false';
            if($this->request->getPost('qty') < $this->request->getPost('stateAllocateValue')){
                $removeQty = 'true';
            }
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
                    'inventoryID'           => $inventoryID,
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
                    'attachment'            => $uploadedAttachment,
                    'rate'                  => $this->request->getPost('rate'),
                    'document_required'     => json_encode((!empty($document_required)?$this->request->getPost('document_required'):[]))
            ];
            //pr($data);
         $dashboard->editInventoryData($data);
          
            return redirect()->to(base_url('user/addInventoryByState'));
        } else {
            return redirect()->to(base_url('login'));
        }
	}	
	public function logout()
	{ 
        $session = \Config\Services::session($config);
        $session->remove('storeId');
        $session->remove('recycleUserId');
	    $session->remove('userId');
        return redirect()->to(base_url('login'));
	}
    /* change password */
    public function changePassword()
    {
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('recycleUserId');
        if(isset($userId)){            
            $this->common_model     = new CommonModel();
            $data['page_header']    = 'Change Password';          
            $data['storeId']        = $storeId;          
            $data['userId']         = $userId;          
            return view('user/change-password',$data);
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
        $userId = $session->get('recycleUserId');
        if(isset($userId)){            
            $this->common_model     = new CommonModel();
            $data['profile']        = $this->common_model->find_data('ecoex_user_table', 'row', ['user_id' => $userId]);
            $data['page_header']    = 'Profile Settings';          
            $data['storeId']        = $storeId;          
            $data['userId']         = $userId;          
            return view('user/profile-settings',$data);
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
    public function changeVisibility(){        
        $inventoryId        = $this->request->getPost('inventoryId');
        $visibilityVal      = $this->request->getPost('visibilityVal');
        $link               = $this->request->getPost('link');
        $apiStatus          = FALSE;
        $apiMessage         = '';
        $apiResponse        = [];
        $this->common_model     = new CommonModel();
        $updatePassword = $this->common_model->save_data('ecoex_inventory', ['visibility' => $visibilityVal], $inventoryId, 'inventory_id');
        $apiStatus = TRUE;
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
        $userId                 = $session->get('recycleUserId');
        if(isset($userId)){
            $this->common_model     = new CommonModel();
            $this->db   = \Config\Database::connect();
            $userId     = $session->get('userId');

            /* inquiry data */
            $orderBy[0]                         = ['field' => 'id', 'type' => 'DESC'];
            $data['allInquiries']               = $this->db->query("SELECT * FROM ecoex_business_inquiries WHERE is_display =1 AND (seller_id = '$userId' OR buyer_id = '$userId') ORDER BY id DESC")->getResult();

            $data['submittedInquiries']         = $this->common_model->find_data('ecoex_business_inquiries', 'array', ['seller_id' => $session->get('userId'), 'published' => 0, 'is_display' => 1], '', '', '', $orderBy);
            $data['documentUploadedInquiries']  = $this->common_model->find_data('ecoex_business_inquiries', 'array', ['seller_id' => $session->get('userId'), 'published' => 1, 'is_display' => 1], '', '', '', $orderBy);

            
            $data['adminApprovedInquiries']     = $this->db->query("SELECT * FROM ecoex_business_inquiries WHERE published = 2 AND is_display =1 AND (seller_id = '$userId' OR buyer_id = '$userId') ORDER BY id DESC")->getResult();
            $data['buyerAcceptInquiries']       = $this->db->query("SELECT * FROM ecoex_business_inquiries WHERE published = 3 AND is_display =1 AND (seller_id = '$userId' OR buyer_id = '$userId') ORDER BY id DESC")->getResult();
            $data['poUploadInquiries']          = $this->db->query("SELECT * FROM ecoex_business_inquiries WHERE published = 4 AND is_display =1 AND (seller_id = '$userId' OR buyer_id = '$userId') ORDER BY id DESC")->getResult();
            $data['poSharedInquiries']          = $this->db->query("SELECT * FROM ecoex_business_inquiries WHERE published = 5 AND is_display =1 AND (seller_id = '$userId' OR buyer_id = '$userId') ORDER BY id DESC")->getResult();            
            $data['adminInvoicesInquiries']       = $this->db->query("SELECT * FROM ecoex_business_inquiries WHERE published = 6 AND is_display =1 AND (seller_id = '$userId' OR buyer_id = '$userId') ORDER BY id DESC")->getResult();
            $data['paymentUploadsInquiries']    = $this->db->query("SELECT * FROM ecoex_business_inquiries WHERE published = 7 AND is_display =1 AND (seller_id = '$userId' OR buyer_id = '$userId') ORDER BY id DESC")->getResult();
            $data['paymentAcceptInquiries']     = $this->db->query("SELECT * FROM ecoex_business_inquiries WHERE published = 8 AND is_display =1 AND (seller_id = '$userId' OR buyer_id = '$userId') ORDER BY id DESC")->getResult();
            /* inquiry data */          
            $data['session']                    = $session;
            $data['common_model']               = $this->common_model;
            return view('user/inquiryList',$data);
        } else {
            return redirect()->to(base_url('login'));
        }
    }
    public function uploadInquiryDocument($id)
    { 
        $session                = \Config\Services::session();
        $storeId                = $session->get('storeId');
        $userId                 = $session->get('recycleUserId');        
        $inquiryId              = decoded($id);
        if(isset($userId)){
            $this->common_model     = new CommonModel();
            $data['common_model']   = $this->common_model;
            $data['attributes']     = $this->common_model->find_data('ecoex_upload_attributes', 'array', ['published' => 1]);
            $data['session']        = $session;
            $data['userId']         = $userId;
            /* inquiry data */
            $data['row']            = $this->common_model->find_data('ecoex_business_inquiries', 'row', ['id' => $inquiryId]);
            /* inquiry data */
            /* inquiry documents upload */
            if($this->request->getPost()){

                /* upload pdf */
                    if($this->request->getPost('mode') == 'pdf_document'){
                        $inquiry_id             = $this->request->getPost('inquiry_id');
                        $inventory_id           = $this->request->getPost('inventory_id');
                        $inventory_details_id   = $this->request->getPost('inventory_details_id');
                        $attr_id                = $this->request->getPost('attr_id');
                        $sl_no                  = $this->request->getPost('sl_no');
                        $file                   = $this->request->getFile('pdf_data');
                        $originalName           = $file->getClientName();
                        $fieldName              = 'pdf_data';
                        if($originalName!='') {
                            $upload_array       = $this->common_model->upload_single_file($fieldName,$originalName,'','pdf');
                            if($upload_array['status']) {
                                $pdf_data   = $upload_array['newFilename'];
                                $this->db   = \Config\Database::connect();                                
                                $this->db->query("update ecoex_business_inquiry_excel_data set attr_value = '$pdf_data' where inquiry_id = '$inquiry_id' and inventory_id = '$inventory_id' and inventory_details_id = '$inventory_details_id' and sl_no = '$sl_no' and attr_id = '$attr_id'");
                                $session->setFlashdata('success_message', 'PDF Files Uploaded Successfully !!!');
                                return redirect()->to(current_url());
                            } else {
                                $session->setFlashdata('error_message', 'Only pdf files are allowed !!!');
                                return redirect()->to(current_url());
                            }
                        } else {
                            $session->setFlashdata('error_message', 'Pdf file is mandatory !!!');
                            return redirect()->to(current_url());
                        }
                    }
                /* upload pdf */
                if($this->request->getPost('mode') == 'csv_document'){
                    /* upload csv file */
                        $file           = $this->request->getFile('excel_data');
                        $originalName   = $file->getClientName();
                        $fieldName      = 'excel_data';
                        if($originalName!='') {
                            $upload_array = $this->common_model->upload_single_file($fieldName,$originalName,'','csv');
                            if($upload_array['status']) {
                                $excel_data = $upload_array['newFilename'];
                                $this->common_model->save_data('ecoex_business_inquiries', ['excel_data' => $excel_data], $this->request->getPost('inquiry_id'), 'id');
                            } else {
                                $session->setFlashdata('error_message', 'Only csv files are allowed !!!');
                                return redirect()->to(current_url());
                            }
                        } else {
                            $session->setFlashdata('error_message', 'CSV file is mandatory !!!');
                            return redirect()->to(current_url());
                        }
                    /* upload csv file */
                    /* extract data from csv */
                        // Validation
                        $input = $this->validate([
                        'file' => 'uploaded[file]|max_size[file,1024]|ext_in[csv],'
                        ]);
                        if($file = $this->request->getFile('excel_data')) {                       
                            // Get random file name
                            $newName        = $file->getRandomName();                            
                            // Store file in public/csvfile/ folder                        
                            $upload_path    = 'writable/uploads/';
                            $temp           = $_FILES['excel_data']["tmp_name"];                            
                            move_uploaded_file($temp,$upload_path.$newName);                            
                            // Reading file
                            $file = fopen('writable/uploads/'.$excel_data,"r");
                            $i              = 0;
                            $numberOfFields = 15; // Total number of fields
                            $importData_arr = array();
                            // Initialize $importData_arr Array                            
                            while (($filedata = fgetcsv($file)) !== FALSE) {
                                $num = count($filedata);                                
                                // Skip first row & check number of fields
                                if($i > 0 && $num == $numberOfFields){ 
                                    // Key names are the insert table field names - name, email, city, and status
                                    $key=1;
                                    for($n=1;$n<$numberOfFields;$n++){
                                        $importData_arr[$i-1][$n]['inquiry_id']            = $this->request->getPost('inquiry_id');
                                        $importData_arr[$i-1][$n]['inventory_id']          = $this->request->getPost('inventory_id');
                                        $importData_arr[$i-1][$n]['inventory_details_id']  = $this->request->getPost('inventory_details_id');
                                        $importData_arr[$i-1][$n]['sl_no']                 = $i;
                                        $importData_arr[$i-1][$n]['attr_id']               = $key;
                                        $importData_arr[$i-1][$n]['attr_value']            = $filedata[$n];
                                        $key++;
                                    }
                                    /* for pdf document */
                                        $importData_arr[$i-1][$n]['inquiry_id']            = $this->request->getPost('inquiry_id');
                                        $importData_arr[$i-1][$n]['inventory_id']          = $this->request->getPost('inventory_id');
                                        $importData_arr[$i-1][$n]['inventory_details_id']  = $this->request->getPost('inventory_details_id');
                                        $importData_arr[$i-1][$n]['sl_no']                 = $i;
                                        $importData_arr[$i-1][$n]['attr_id']               = 15;
                                        $importData_arr[$i-1][$n]['attr_value']            = '';
                                    /* for pdf document */
                                }
                                $i++;
                            }
                            fclose($file);
                            $outerCount = count($importData_arr);
                            // Insert data
                            if( $outerCount>0){
                                for($oc=0;$oc<$outerCount;$oc++){
                                    $innerCount = count($importData_arr[$oc]);
                                    //pr($importData_arr[$oc],false);
                                    if( $innerCount>0){
                                        for($ic=0;$ic<=$innerCount;$ic++){
                                            $postdata = $importData_arr[$oc][$ic];
                                            $this->common_model->save_data('ecoex_business_inquiry_excel_data', $postdata, '', 'id');
                                        }
                                    }
                                }
                            }
                        }                    
                    /* extract data from csv */
                    $session->setFlashdata('success_message', 'File Uploaded & Extract Data From File Successfully !!!');
                    return redirect()->to(current_url());
                }                               
            }
            /* inquiry documents upload */            
            return view('user/uploadInquiryDocument',$data);
        } else {
            return redirect()->to(base_url('login'));
        }
    }
    public function deleteUploadedData($id){
        $session                = \Config\Services::session();
        $storeId                = $session->get('storeId');
        $userId                 = $session->get('recycleUserId');        
        $inquiryId              = decoded($id);
        if(isset($userId)){
            $this->common_model     = new CommonModel();
            $this->common_model->save_data('ecoex_business_inquiries', ['excel_data' => ''], $inquiryId, 'id');
            $this->common_model->delete_data('ecoex_business_inquiry_excel_data', $inquiryId, 'inquiry_id');
            $session->setFlashdata('success_message', 'Uploaded Data Deleted Successfully !!!');
            return redirect()->to(base_url('user/uploadInquiryDocument/'.encoded($inquiryId)));
        } else {
            return redirect()->to(base_url('login'));
        }
    }
    public function notifyAdminApproval($id){
        $session                = \Config\Services::session();
        $storeId                = $session->get('storeId');
        $userId                 = $session->get('recycleUserId');        
        $inquiryId              = decoded($id);
        if(isset($userId)){
            $this->common_model     = new CommonModel();

            /* sent mail to admin for approval */
                $site_setting           = $this->common_model->find_data('ecoex_setting', 'row');
                $fields['site_setting'] = $site_setting;
                $fields['common_model'] = $this->common_model;
                $fields['inventory']    = $this->common_model->find_data('ecoex_business_inquiries', 'row', ['id' => $inquiryId]);
                $html                   = view('email-template/inquiry-document-upload',$fields);
                $subject                = 'New Inquiry Document Verification & Approval :: '.$fields['site_setting']->websiteName;
                $this->common_model->sendEmail((($site_setting)?$site_setting->site_email:''),$subject,$html);
                $this->common_model->save_data('ecoex_business_inquiries', ['published' => 1], $inquiryId, 'id');
            /* sent mail to admin for approval */
            /* insert email logs */
                $insertData = [
                    'userID'    => '',
                    'email'     => $html
                ];
                $this->common_model->save_data('ecoex_email_log', $insertData, '', 'id');
            /* insert email logs */ 
            
            $session->setFlashdata('success_message', 'Approval Notification Send To Admin Successfully !!!');
            return redirect()->to(base_url('user/uploadInquiryDocument/'.encoded($inquiryId)));
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

        /* sent mail to admin */
        $site_setting           = $this->common_model->find_data('ecoex_setting', 'row');
        $fields['site_setting'] = $site_setting;
        $fields['common_model'] = $this->common_model;
        $fields['inventory']    = $this->common_model->find_data('ecoex_business_inquiries', 'row', ['id' => $inquiryId]);
        $html                   = view('email-template/inquiry-document-accepted',$fields);
        //echo $html;die;
        $subject                = 'Inquiry Documents Accepted :: '.$fields['site_setting']->websiteName;
        $this->common_model->sendEmail((($site_setting)?$site_setting->site_email:''),$subject,$html);
        /* sent mail to admin */
        /* insert email logs */
        $insertData = [
            'userID'    => '',
            'email'     => $html
        ];
        $this->common_model->save_data('ecoex_email_log', $insertData, '', 'id');
        /* insert email logs */

        $session->setFlashdata('success_message', 'Inquiry Documents Accepted Successfully !!!');
        return redirect()->to(base_url('user/uploadInquiryDocument/'.encoded($inquiryId)));
    }
    public function uploadPO($id){
        $session                = \Config\Services::session();
        $userId                 = $session->get('userId');
        $inquiryId              = decoded($id);
        $this->common_model     = new CommonModel();        
        $file           = $this->request->getFile('po_documents');
        $originalName   = $file->getClientName();
        $fieldName      = 'po_documents';
        $upload_array   = $this->common_model->upload_single_file($fieldName,$originalName,'','pdf');
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

        $session->setFlashdata('success_message', 'Purchase Order Uploaded Successfully !!!');
        return redirect()->to(base_url('user/uploadInquiryDocument/'.encoded($inquiryId)));
    }
    public function uploadInvoice($id){
        $session                = \Config\Services::session();
        $userId                 = $session->get('userId');
        $inquiryId              = decoded($id);
        $this->common_model     = new CommonModel();        
        $file                   = $this->request->getFile('invoice_from_seller');
        $originalName           = $file->getClientName();
        $fieldName              = 'invoice_from_seller';
        $upload_array           = $this->common_model->upload_single_file($fieldName,$originalName,'','pdf');        
        if($upload_array['status']) {
            $invoice_from_seller = $upload_array['newFilename'];
        } else {
            $invoice_from_seller = '';
        }
        $fields                     =   ['invoice_from_seller' => $invoice_from_seller];
        $this->common_model->save_data('ecoex_business_inquiries', $fields, $inquiryId, 'id');

        /* sent mail to admin from seller invoice */
            $site_setting           = $this->common_model->find_data('ecoex_setting', 'row');
            $fields['site_setting'] = $site_setting;
            $fields['common_model'] = $this->common_model;
            $fields['inventory']    = $this->common_model->find_data('ecoex_business_inquiries', 'row', ['id' => $inquiryId]);
            $html                   = view('email-template/inquiry-seller-invoice-upload',$fields);
            //echo $html;die;                
            $subject                = 'Inquiry Invoice Uploaded From Seller :: '.$fields['site_setting']->websiteName;
            $this->common_model->sendEmail((($site_setting)?$site_setting->site_email:''),$subject,$html);
        /* sent mail to admin from seller invoice */
        /* insert email logs */
            $insertData = [
                'userID'    => '',
                'email'     => $html
            ];
            $this->common_model->save_data('ecoex_email_log', $insertData, '', 'id');
        /* insert email logs */

        $session->setFlashdata('success_message', 'Sale Invoice Uploaded Successfully !!!');
        return redirect()->to(base_url('user/uploadInquiryDocument/'.encoded($inquiryId)));
    }
    public function uploadPayment($id){
        $session                = \Config\Services::session();
        $userId                 = $session->get('userId');
        $inquiryId              = decoded($id);
        $this->common_model     = new CommonModel();        
        
        $fields                     =   [
            'transaction_no'        => $this->request->getPost('transaction_no'),
            'transaction_date'      => $this->request->getPost('transaction_date'),
            'transaction_time'      => $this->request->getPost('transaction_time'),
            'transaction_amount'    => $this->request->getPost('transaction_amount'),
            'published'             => 7,
        ];
        $this->common_model->save_data('ecoex_business_inquiries', $fields, $inquiryId, 'id');

        /* sent mail to admin */
            $site_setting           = $this->common_model->find_data('ecoex_setting', 'row');
            $fields['site_setting'] = $site_setting;
            $fields['common_model'] = $this->common_model;
            $fields['inventory']    = $this->common_model->find_data('ecoex_business_inquiries', 'row', ['id' => $inquiryId]);
            $html                   = view('email-template/inquiry-buyer-payment-upload',$fields);
            //echo $html;die;                
            $subject                = 'Transaction Data Uploaded From Buyer :: '.$fields['site_setting']->websiteName;
            $this->common_model->sendEmail((($site_setting)?$site_setting->site_email:''),$subject,$html);
        /* sent mail to admin */
        /* insert email logs */
            $insertData = [
                'userID'    => '',
                'email'     => $html
            ];
            $this->common_model->save_data('ecoex_email_log', $insertData, '', 'id');
        /* insert email logs */

        $session->setFlashdata('success_message', 'Payment Data Uploaded Successfully !!!');
        return redirect()->to(base_url('user/uploadInquiryDocument/'.encoded($inquiryId)));
    }
    public function uploadInquiryDocument_bkp20072022($id)
    { 
        $session                = \Config\Services::session();
        $storeId                = $session->get('storeId');
        $userId                 = $session->get('recycleUserId');
        
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
                return redirect()->to(base_url('user/inquiryList'));
            }
            /* inquiry documents upload */            
            return view('user/uploadInquiryDocument',$data);
        } else {
            return redirect()->to(base_url('login'));
        }
    }
    /* inquiry module */
}