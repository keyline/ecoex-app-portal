<?php
namespace App\Controllers\Collector; // Controller namespace
use App\Controllers\BaseController;
use App\Models\Collector;
use App\Models\CommonModel;
class DashboardController extends BaseController
{
	public function index()
	{
        $session = \Config\Services::session();
        $userId = $session->get('storeId');
        if(isset($userId)){
            return view('dashboard/index');
        } else {
            return redirect()->to(base_url('login'));
        }
	}
	
	public function myDashboard()
	{
        $session = \Config\Services::session();
        $storeId = $session->get('storeId');
        $userId = $session->get('recycleUserId');
        $this->common_model = new CommonModel();
        if(isset($userId)){            
            $dashboard =new Collector();
            $userData = $dashboard->getUserDataByID($userId);
            $data['userData'] = $userData;
            $data['contoroller'] = $dashboard;          
            return view('collector/index',$data);
        } else {
            return redirect()->to(base_url('login'));
        }
	}
	
	public function inventory()
	{ 
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('recycleUserId');
        if(isset($userId)){
            
          $dashboard =new Collector();
          $userData = $dashboard->getUserDataByID($userId);
          $categoryData = $dashboard->getBusinessMainCategoryList();
          $unitData = $dashboard->getUnitList();
          
          $data['categoryData'] = $categoryData;
          $data['user_member_type'] = $userData->user_membership_type;
          $data['userData'] = $userData;
          $data['unitData'] = $unitData;
          $data['contoroller'] = $dashboard;
          
            return view('collector/inventory',$data);
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
            
          $dashboard =new Collector();
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
          
          
            $data = [
                    'storeId'=>$storeId,
                    'inventory_type'=>$this->request->getPost('inventory_type'),
                    'category'=>$this->request->getPost('category'),
                    'subCategory'=>$this->request->getPost('subCategory'),
                    'product'=>$this->request->getPost('product'),
                    'item'=>$this->request->getPost('item'),
                    'year'=>$this->request->getPost('year'),
                    'month'=>$this->request->getPost('month'),
                    'qty'=>$this->request->getPost('qty'),
                    'unit'=>$this->request->getPost('unit'),
                    'attachment'=>$uploadedAttachment,
                    'rate'=>$this->request->getPost('rate')
            ];
          $lastInsertedInventoryID = $dashboard->addInventoryData($data);
          
          $session->set('inventoryID',$lastInsertedInventoryID);
          
            return redirect()->to(base_url('collector/addInventoryByState'));
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
        if(isset($userId)){
        
          $dashboard =new Collector();
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
            return view('collector/addInventoryByState',$data);
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
          $storeLocationData =  $this->request->getPost('storeLocation');
          
          $dashboard =new Collector();
          
            $data = [
                    'storeId'=>$storeId,
                    'inventoryID'=>$inventoryID,
                    'stateData'=>$stateData,
                    'qty'=>$qtyData,
                    'storeLocation'=>$storeLocationData
            ];
          $lastInsrtInventoryStatID = $dashboard->addInventoryByStateData($data);
          
            return redirect()->to(base_url('collector/inventoryList'));
        } else {
            return redirect()->to(base_url('login'));
        }
	}
	
	public function inventoryList()
	{ 
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('recycleUserId');
        if(isset($userId)){
            
            $dashboard =new Collector();
            $userData = $dashboard->getUserDataByID($userId);
            $inventoryData = $dashboard->getInventoryList($storeId);
            $unitData = $dashboard->getUnitList();
          
            $data['inventoryData'] = $inventoryData;
          
            $data['userData'] = $userData;
            $data['unitData'] = $unitData;
            $data['contoroller'] = $dashboard;
            //pr($data['inventoryData']);
            return view('collector/inventoryList',$data);
        } else {
            return redirect()->to(base_url('login'));
        }
	}
	
	public function setInventoryId($id)
	{ 
        $session = \Config\Services::session($config);
        
        $session->set('inventoryID',$id);
        return redirect()->to(base_url('collector/editInventory'));
	}
	public function setStateInventoryId($id)
	{ 
        $session = \Config\Services::session($config);
        
        $session->set('inventoryID',$id);
        return redirect()->to(base_url('collector/addInventoryByState'));
	}
	
	public function editInventory()
	{ 
        $session = \Config\Services::session($config);
        $storeId = $session->get('storeId');
        $userId = $session->get('recycleUserId');
        $inventoryID = $session->get('inventoryID');
        if(isset($userId)){
            
          $dashboard =new Collector();
          $userData = $dashboard->getUserDataByID($userId);
          $categoryData = $dashboard->getBusinessMainCategoryList();
          $unitData = $dashboard->getUnitList();
          $inventoryData = $dashboard->getInventoryDataByID($inventoryID);
          
          $data['categoryData'] = $categoryData;
          $data['inventoryData'] = $inventoryData;
          $data['user_member_type'] = $userData->user_membership_type;
          $data['userData'] = $userData;
          $data['unitData'] = $unitData;
          $data['contoroller'] = $dashboard;
          
            return view('collector/editInventory',$data);
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
            
            $dashboard =new Collector();
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
            $data = [
                    'storeId'=>$storeId,
                    'inventoryID'=>$inventoryID,
                    'inventory_type'=>$this->request->getPost('inventory_type'),
                    'category'=>$this->request->getPost('category'),
                    'subCategory'=>$this->request->getPost('subCategory'),
                    'product'=>$this->request->getPost('product'),
                    'item'=>$this->request->getPost('item'),
                    'year'=>$this->request->getPost('year'),
                    'month'=>$this->request->getPost('month'),
                    'qty'=>$this->request->getPost('qty'),
                    'unit'=>$this->request->getPost('unit'),
                    'removeQty'=>$removeQty,
                    'attachment'=>$uploadedAttachment,
                    'rate'=>$this->request->getPost('rate')
            ];
         $dashboard->editInventoryData($data);
          
            return redirect()->to(base_url('collector/addInventoryByState'));
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
            return view('collector/change-password',$data);
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
            return view('collector/profile-settings',$data);
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
        $updatePassword = $this->common_model->save_data('ecoex_collecter_inventory', ['visibility' => $visibilityVal], $inventoryId, 'inventory_id');
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
}