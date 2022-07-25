<?php
namespace App\Controllers\Admin; // Controller namespace

use App\Controllers\BaseController;
use App\Models\AdminAuth;
use App\Models\CommonModel;
use App\Models\Company;
use App\Models\MemberType;
class AdminController extends BaseController
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
	
	public function login()
	{
        $session = \Config\Services::session($config);
        $loginError = $session->get('loginError');
        
		return view('admin/auth/login');
	}
  
  public function loginCheck()
	{
       $session = \Config\Services::session($config);
            
       $adminAuth =new AdminAuth();
       
            $data = [
                    'username'=>$this->request->getPost('username'),
                    'password'=>$this->request->getPost('password')
            ];
          $adminAuthData = $adminAuth->getAdminDetails($data);
	    
		if($adminAuthData[0]['status'] == "0"){
      $session->set('userId',$adminAuthData[0]['id']);
      $session->set('userType','ADMIN');
      return redirect()->to(base_url('admin/dashboard'));
		} else {		    
      $session->set('loginError','Invalid Login Credentials');
      return redirect()->to(base_url('admin/login'));
		}
	}
	
	public function dashboard()
	{
    $session = \Config\Services::session($config);
    $userId = $session->get('userId');
    if(isset($userId)){
        
      $adminAuth =new AdminAuth();
   
      $totalBrand = $adminAuth->getTotalBrand()->totalBrand;
      $totalRecycler = $adminAuth->getTotalRecycle()->totalRecycler;
      $data['totalBrand'] = $totalBrand;
      $data['totalRecycler'] = $totalRecycler;

      $data['commonModel'] = new CommonModel();
      $data['totalCategory'] = $adminAuth->getTotalMemberCategory();
      $data['controller'] = $adminAuth;
      $parentCategory = $adminAuth->getBusinessParentCategory();
      $data['parentCategory'] = $parentCategory;
      
      return view('admin/layout/index',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
	}
	public function category()
	{
    $session = \Config\Services::session($config);
    $userId = $session->get('userId');
    if(isset($userId)){        
      $adminAuth =new AdminAuth();   
      $totalCategory = $adminAuth->getTotalBusinessCategory();
      $data['totalCategory'] = $totalCategory;
      $data['controller'] = $adminAuth;
      $totalCategory = $adminAuth->getBusinessParentCategory();
      $data['parentCategory'] = $totalCategory;
      return view('admin/layout/category',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
	}
	
	public function memberCategory()
	{
        $session = \Config\Services::session($config);
        $userId = $session->get('userId');
        if(isset($userId)){
            
          $adminAuth =new AdminAuth();
          $model = new CommonModel();
          $data['commonModel'] = $model;
          $totalCategory = $adminAuth->getTotalMemberCategory();
          $data['totalCategory'] = $totalCategory;
          
            return view('admin/layout/memberCategory',$data);
        } else {
            return redirect()->to(base_url('admin/login'));
        }
	}
  public function documentList()
  {
    $session                = \Config\Services::session($config);
    $userId                 = $session->get('userId');
    if(isset($userId)){
      $model                = new CommonModel();
      $data['commonModel']  = $model;
      $order_by[0]          = ['field' => 'id', 'type' => 'DESC'];
      $data['rows']         = $model->find_data('ecoex_document_list', 'array', ['published!=' => 3], '', '', '', $order_by);          
      return view('admin/layout/documentList',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }
  public function addDocumentList()
  {
    $session = \Config\Services::session($config);
    $userId = $session->get('userId');
    $this->common_model = new CommonModel();
    if(isset($userId)){
      if($this->request->getPost()){
        $postData = [
                  'documentName'          => $this->request->getPost('documentName'),
                  'documentType'          => $this->request->getPost('documentType'),
                ];
        $this->common_model->save_data('ecoex_document_list', $postData, '', 'id');
        return redirect()->to(base_url('admin/documentList'));
      }
      $data['row'] = [];
      return view('admin/layout/addEditDocumentList',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }
  public function updateDocumentList($id)
  {
    $session = \Config\Services::session($config);
    $userId = $session->get('userId');
    $this->common_model = new CommonModel();
    if(isset($userId)){
      if($this->request->getPost()){
        $postData = [
                  'documentName'          => $this->request->getPost('documentName'),
                  'documentType'          => $this->request->getPost('documentType'),
                ];
        $this->common_model->save_data('ecoex_document_list', $postData, $id, 'id');
        return redirect()->to(base_url('admin/documentList'));
      }
      $data['row'] = $this->common_model->find_data('ecoex_document_list', 'row', ['id' => $id]);
      return view('admin/layout/addEditDocumentList',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }
  /* state */
  public function stateList()
  {
    $session                = \Config\Services::session($config);
    $userId                 = $session->get('userId');
    if(isset($userId)){
      $model                = new CommonModel();
      $data['commonModel']  = $model;
      $order_by[0]          = ['field' => 'state_id', 'type' => 'DESC'];
      $data['rows']         = $model->find_data('ecoex_state', 'array', ['published!=' => 3], '', '', '', $order_by);          
      return view('admin/layout/stateList',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }
  public function addStateList()
  {
    $session = \Config\Services::session($config);
    $userId = $session->get('userId');
    $this->common_model = new CommonModel();
    if(isset($userId)){
      if($this->request->getPost()){
        $postData = [
                  'state_title'          => $this->request->getPost('state_title')
                ];
        $this->common_model->save_data('ecoex_state', $postData, '', 'state_id');
        return redirect()->to(base_url('admin/stateList'));
      }
      $data['row'] = [];
      return view('admin/layout/addEditStateList',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }
  public function updateStateList($id)
  {
    $session = \Config\Services::session($config);
    $userId = $session->get('userId');
    $this->common_model = new CommonModel();
    if(isset($userId)){
      if($this->request->getPost()){
        $postData = [
                  'state_title'          => $this->request->getPost('state_title')
                ];
        $this->common_model->save_data('ecoex_state', $postData, $id, 'state_id');
        return redirect()->to(base_url('admin/stateList'));
      }
      $data['row'] = $this->common_model->find_data('ecoex_state', 'row', ['state_id' => $id]);
      return view('admin/layout/addEditStateList',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }
  /* state */
  /* district */
  public function districtList()
  {
    $session                = \Config\Services::session($config);
    $userId                 = $session->get('userId');
    if(isset($userId)){
      $this->common_model   = new CommonModel();
      $data['commonModel']  = $model;
      $order_by[0]          = ['field' => 'districtid', 'type' => 'DESC'];
      $data['rows']         = $this->common_model->find_data('ecoex_district', 'array', ['published!=' => 3], '', '', '', $order_by);
      $data['common_model'] = $this->common_model;
      return view('admin/layout/districtList',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }
  public function addDistrictList()
  {
    $session = \Config\Services::session($config);
    $userId = $session->get('userId');
    $this->common_model = new CommonModel();
    if(isset($userId)){
      if($this->request->getPost()){
        $postData = [
                  'state_id'          => $this->request->getPost('state_id'),
                  'district_title'          => $this->request->getPost('district_title'),
                ];
        $this->common_model->save_data('ecoex_district', $postData, '', 'districtid');
        return redirect()->to(base_url('admin/districtList'));
      }
      $data['row'] = [];
      $data['states'] = $this->common_model->find_data('ecoex_state', 'array', ['published' => 1]);
      return view('admin/layout/addEditDistrictList',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }
  public function updateDistrictList($id)
  {
    $session = \Config\Services::session($config);
    $userId = $session->get('userId');
    $this->common_model = new CommonModel();
    if(isset($userId)){
      if($this->request->getPost()){
        $postData = [
                  'state_id'          => $this->request->getPost('state_id'),
                  'district_title'          => $this->request->getPost('district_title'),
                ];
        $this->common_model->save_data('ecoex_district', $postData, $id, 'districtid');
        return redirect()->to(base_url('admin/districtList'));
      }
      $data['row'] = $this->common_model->find_data('ecoex_district', 'row', ['districtid' => $id]);
      $data['states'] = $this->common_model->find_data('ecoex_state', 'array', ['published' => 1]);
      return view('admin/layout/addEditDistrictList',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }
  /* district */
  /* city */
  public function cityList()
  {
    $session                = \Config\Services::session($config);
    $userId                 = $session->get('userId');
    if(isset($userId)){
      $this->common_model   = new CommonModel();
      $data['commonModel']  = $model;
      $order_by[0]          = ['field' => 'id', 'type' => 'DESC'];
      $data['rows']         = $this->common_model->find_data('ecoex_city', 'array', ['published!=' => 3], '', '', '', $order_by);
      $data['common_model'] = $this->common_model;
      return view('admin/layout/cityList',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }
  public function addCityList()
  {
    $session = \Config\Services::session($config);
    $userId = $session->get('userId');
    $this->common_model = new CommonModel();
    if(isset($userId)){
      if($this->request->getPost()){
        $postData = [
                  'state_id'          => $this->request->getPost('state_id'),
                  'districtid'          => $this->request->getPost('districtid'),
                  'name'          => $this->request->getPost('name'),
                ];
        $this->common_model->save_data('ecoex_city', $postData, '', 'id');
        return redirect()->to(base_url('admin/cityList'));
      }
      $data['row'] = [];
      $data['states'] = $this->common_model->find_data('ecoex_state', 'array', ['published' => 1]);
      $data['districts'] = $this->common_model->find_data('ecoex_district', 'array', ['published' => 1]);
      return view('admin/layout/addEditCityList',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }
  public function updateCityList($id)
  {
    $session = \Config\Services::session($config);
    $userId = $session->get('userId');
    $this->common_model = new CommonModel();
    if(isset($userId)){
      if($this->request->getPost()){
        $postData = [
                  'state_id'          => $this->request->getPost('state_id'),
                  'districtid'          => $this->request->getPost('districtid'),
                  'name'          => $this->request->getPost('name'),
                ];
        $this->common_model->save_data('ecoex_city', $postData, $id, 'id');
        return redirect()->to(base_url('admin/cityList'));
      }
      $data['row'] = $this->common_model->find_data('ecoex_city', 'row', ['id' => $id]);
      $data['states'] = $this->common_model->find_data('ecoex_state', 'array', ['published' => 1]);
      $data['districts'] = $this->common_model->find_data('ecoex_district', 'array', ['published' => 1]);
      return view('admin/layout/addEditCityList',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }
  /* city */
  /* upload attribute */
    public function uploadAttributeList()
    {
      $session                = \Config\Services::session($config);
      $userId                 = $session->get('userId');
      if(isset($userId)){
        $model                = new CommonModel();
        $data['commonModel']  = $model;
        $order_by[0]          = ['field' => 'attr_id', 'type' => 'DESC'];
        $data['rows']         = $model->find_data('ecoex_upload_attributes', 'array', ['published!=' => 3],'','','',$order_by);
        return view('admin/layout/uploadAttributeList',$data);
      } else {
        return redirect()->to(base_url('admin/login'));
      }
    }
    public function addUploadAttribute()
    {
      $session = \Config\Services::session($config);
      $userId = $session->get('userId');
      $this->common_model = new CommonModel();
      if(isset($userId)){
        if($this->request->getPost()){
          $postData = [
                    'attr_name'          => strtoupper($this->request->getPost('attr_name')),
                    'share_nature'       => $this->request->getPost('share_nature'),
                  ];
          $this->common_model->save_data('ecoex_upload_attributes', $postData, '', 'attr_id');
          return redirect()->to(base_url('admin/uploadAttributeList'));
        }
        $data['row'] = [];
        return view('admin/layout/addEditUploadAttribute',$data);
      } else {
        return redirect()->to(base_url('admin/login'));
      }
    }
    public function updateUploadAttribute($id)
    {
      $session = \Config\Services::session($config);
      $userId = $session->get('userId');
      $this->common_model = new CommonModel();
      if(isset($userId)){
        if($this->request->getPost()){
          $postData = [
                    'attr_name'          => strtoupper($this->request->getPost('attr_name')),
                    'share_nature'       => $this->request->getPost('share_nature'),
                  ];
          $this->common_model->save_data('ecoex_upload_attributes', $postData, $id, 'attr_id');
          return redirect()->to(base_url('admin/uploadAttributeList'));
        }
        $data['row'] = $this->common_model->find_data('ecoex_upload_attributes', 'row', ['attr_id' => $id]);
        return view('admin/layout/addEditUploadAttribute',$data);
      } else {
        return redirect()->to(base_url('admin/login'));
      }
    }
  /* upload attribute */
  /* static content */
  public function staticContentList()
  {
        $session = \Config\Services::session($config);
        $userId = $session->get('userId');
        if(isset($userId)){
            
          $adminAuth =new AdminAuth();
          $model = new CommonModel();
          $data['commonModel'] = $model;
          $orderBy[0] = ['field' => 'id', 'type' => 'DESC'];
          $data['rows'] = $model->find_data('ecoex_static_content', 'array', ['published' => 1], '', '', '', $orderBy);
          return view('admin/layout/staticContentList',$data);
        } else {
          return redirect()->to(base_url('admin/login'));
        }
  }
  public function addStaticContent()
  {
        $session = \Config\Services::session($config);
        $userId = $session->get('userId');
        if(isset($userId)){
          $model = new CommonModel();
          if($this->request->getPost()){
            /* content file upload */
              $file = $this->request->getFile('content_file');
              $originalName = $file->getClientName();
              $fieldName = 'content_file';
              if($originalName!='') {
                  $upload_array = $model->upload_single_file($fieldName,$originalName,'','pdf');
                  if($upload_array['status']) {
                    $content_file = $upload_array['newFilename'];
                  } else {
                    $this->session->setFlashdata('msg1', $upload_array['message']);
                    return redirect()->to(current_url());
                  }
              } else {
                  $this->session->setFlashdata('msg1', 'Please upload content');                
                  return redirect()->to(current_url());
              }
            /* content file upload */
            $postData = [
                      'title'           => $this->request->getPost('title'),
                      'slug'            => strtolower($model->clean($this->request->getPost('title'))),
                      'description'     => $this->request->getPost('description'),
                      'content_file'    => $content_file
                    ];
            //pr($postData);
            $model->save_data('ecoex_static_content', $postData, '', 'id');
            return redirect()->to(base_url('admin/staticContentList'));
          }
          $data['row'] = [];
          return view('admin/layout/addEditStaticContent',$data);
        } else {
          return redirect()->to(base_url('admin/login'));
        }
  }
  public function updateStaticContent($id)
  {
        $session = \Config\Services::session($config);
        $userId = $session->get('userId');
        if(isset($userId)){
          $model = new CommonModel();
          if($this->request->getPost()){
            $data['row'] = $model->find_data('ecoex_static_content', 'row', ['id' => $id]);
            /* content file upload */
              $file = $this->request->getFile('content_file');
              $originalName = $file->getClientName();
              $fieldName = 'content_file';
              if($originalName!='') {
                  $upload_array = $model->upload_single_file($fieldName,$originalName,'','pdf');
                  if($upload_array['status']) {
                    $content_file = $upload_array['newFilename'];
                  } else {
                    $content_file = $data['row']->content_file;
                  }
              } else {
                  $content_file = $data['row']->content_file;
              }
            /* content file upload */
            $postData = [
                      'title'           => $this->request->getPost('title'),
                      'slug'            => strtolower($model->clean($this->request->getPost('title'))),
                      'description'     => $this->request->getPost('description'),
                      'content_file'    => $content_file
                    ];
            //pr($postData);
            $model->save_data('ecoex_static_content', $postData, $id, 'id');
            return redirect()->to(base_url('admin/staticContentList'));
          }
          $data['row'] = $model->find_data('ecoex_static_content', 'row', ['id' => $id]);
          return view('admin/layout/addEditStaticContent',$data);
        } else {
          return redirect()->to(base_url('admin/login'));
        }
  }
  public function deleteStaticContent($id)
  {
        $session = \Config\Services::session($config);
        $userId = $session->get('userId');
        if(isset($userId)){
          $model = new CommonModel();
          $model->delete_data('ecoex_static_content', $id, 'id');
          return redirect()->to(base_url('admin/staticContentList'));
        } else {
          return redirect()->to(base_url('admin/login'));
        }
  }
  /* static content */
	public function logout()
	{
    $session = \Config\Services::session($config);
    $session->remove('userId');
    $session->remove('userType');
    return redirect()->to(base_url('admin/login'));
	}
	
	public function addBusinessCategory()
	{
    $session                  = \Config\Services::session($config);
    $userId                   = $session->get('userId');
    if(isset($userId)){            
      $adminAuth              = new AdminAuth();
      $this->common_model     = new CommonModel();
      $totalCategory          = $adminAuth->getBusinessParentCategory();
      $data['totalCategory']  = $totalCategory;
      $data['controller']     = $adminAuth;
      $data['member_types']   = $this->common_model->find_data('ecoex_member_category', 'array');
      return view('admin/layout/addBusinessCategory',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
	}
	public function addBusinessCategoryData()
	{
    $adminAuth =new AdminAuth();
    $this->common_model     = new CommonModel();    
    $member_category_id     = $this->request->getPost('member_category_id');    
    $fields1 = [
            'parent'  => $this->request->getPost('category'),
            'name'    => strtoupper($this->request->getPost('name'))
    ];
    $addCat = $this->common_model->save_data('ecoex_business_category', $fields1, '', 'id');    
    if(count($member_category_id)>0){
      for($k=0;$k<count($member_category_id);$k++){
        $options                = $this->request->getPost('options'.$member_category_id[$k]);
        $fields2 = [
                'category_id'           => $addCat,
                'member_category_id'    => $member_category_id[$k],
                'options'               => (($options!='')?json_encode($options):json_encode(array())),
        ];
        $this->common_model->save_data('ecoex_business_category_options', $fields2, '', 'id');
        //$db = \Config\Database::connect();
        //echo $db->getLastQuery();die;
      }
    }
    return redirect()->to(base_url('admin/category'));
	}
	
	public function editBusinessCategory($id)
	{
    $session = \Config\Services::session($config);
    $userId = $session->get('userId');
    if(isset($userId)){
        
      $adminAuth =new AdminAuth();
      $this->common_model       = new CommonModel();
      $data['common_model']     = $this->common_model;
      $data['id']               = $id;
      $totalCategory            = $adminAuth->getBusinessParentCategory();
      $getCategoryData          = $adminAuth->getCategoryParent($id);
      $data['totalCategory']    = $totalCategory;
      $data['getCategoryData']  = $getCategoryData;
      $data['totalCategory']    = $totalCategory;
      $data['controller']       = $adminAuth; 
      $data['member_types']     = $this->common_model->find_data('ecoex_member_category', 'array');
      return view('admin/layout/editBusinessCategory',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
	}
	public function editBusinessCategoryData()
	{
    $adminAuth              = new AdminAuth();
    $this->common_model     = new CommonModel();    
    $member_category_id     = $this->request->getPost('member_category_id');    
    $fields1 = [
            'parent'  => $this->request->getPost('category'),
            'name'    => strtoupper($this->request->getPost('name'))
    ];
    $addCat = $this->common_model->save_data('ecoex_business_category', $fields1, $this->request->getPost('id'), 'id');
    $this->common_model->delete_data('ecoex_business_category_options', $this->request->getPost('id'), 'category_id');
    if(count($member_category_id)>0){
      for($k=0;$k<count($member_category_id);$k++){
        $options                = $this->request->getPost('options'.$member_category_id[$k]);
        $fields2 = [
                'category_id'           => $this->request->getPost('id'),
                'member_category_id'    => $member_category_id[$k],
                'options'               => (($options!='')?json_encode($options):json_encode(array())),
        ];
        $this->common_model->save_data('ecoex_business_category_options', $fields2, '', 'id');        
      }
    }
    return redirect()->to(base_url('admin/category'));
	}
	public function addMemberType()
	{
    $session            = \Config\Services::session($config);
    $userId             = $session->get('userId');
    $this->common_model = new CommonModel();
    if(isset($userId)){
      if($this->request->getPost()){
        $postData = [
                  'member_type'         => $this->request->getPost('member_type'),
                  'short_name'          => $this->request->getPost('member_type'),
                ];
        $this->common_model->save_data('ecoex_member_category', $postData, '', 'member_id');
        return redirect()->to(base_url('admin/memberCategory'));
      }
      $data['row'] = [];
      return view('admin/layout/addEditMemberType',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
	}
  public function updateMemberType($id)
  {
    $session            = \Config\Services::session($config);
    $userId             = $session->get('userId');
    $this->common_model = new CommonModel();
    if(isset($userId)){
      if($this->request->getPost()){
        $postData = [
                  'member_type'         => $this->request->getPost('member_type'),
                  'short_name'          => $this->request->getPost('member_type'),
                ];
        $this->common_model->save_data('ecoex_member_category', $postData, $id, 'member_id');
        return redirect()->to(base_url('admin/memberCategory'));
      }
      $data['row'] = $this->common_model->find_data('ecoex_member_category', 'row', ['member_id' => $id]);
      return view('admin/layout/addEditMemberType',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }
	public function deleteMemberType($id)
	{
        $session = \Config\Services::session($config);
        $userId = $session->get('userId');
        if(isset($userId)){
          $adminAuth =new AdminAuth();
          $addCat = $adminAuth->deleteMemberCategory($id);
        return redirect()->to(base_url('admin/memberCategory'));
        } else {
            return redirect()->to(base_url('admin/login'));
        }
	}
	public function deleteBusinessCategory($id)
	{
        $session = \Config\Services::session($config);
        $userId = $session->get('userId');
        if(isset($userId)){
          $adminAuth =new AdminAuth();
          $addCat = $adminAuth->deleteBusinessCategory($id);
        return redirect()->to(base_url('admin/category'));
        } else {
            return redirect()->to(base_url('admin/login'));
        }
	}
	public function memberList()
	{
    $session = \Config\Services::session($config);
    $userId = $session->get('userId');
    if(isset($userId)){            
      $adminAuth                = new AdminAuth();
      $data['common_model']     = new CommonModel();
      $totalData                = $adminAuth->getApprovedMemberList();
      $totalPendingSum          = $adminAuth->getTotalApprovedRequest();
      $data['totalMember']      = $totalData;
      $data['controller']       = $adminAuth; 
      $data['totalPendingSum']  = $totalPendingSum->totalApprovedRequest;          
      return view('admin/layout/memberList',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
	}
  public function memberTypeWiseList($id)
  {
    $session = \Config\Services::session($config);
    $userId = $session->get('userId');
    if(isset($userId)){        
      $adminAuth                = new AdminAuth();       
      $totalData                = $adminAuth->getApprovedMemberListByType($id);
      $totalPendingSum          = $adminAuth->getTotalApprovedRequest();
      $data['totalMember']      = $totalData;
      $data['controller']       = $adminAuth;
      $data['common_model']     = new CommonModel();
      $data['totalPendingSum']  = count($totalData);          
      return view('admin/layout/memberList',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }
	public function approvalRequest()
	{
    $session = \Config\Services::session($config);
    $userId = $session->get('userId');
    if(isset($userId)){            
      $adminAuth                  = new AdminAuth();
      $data['common_model']       = new CommonModel();
      $totalData                  = $adminAuth->getPendingMemberList();
      $totalPendingSum            = $adminAuth->getTotalPendingRequest();
      $data['totalMember']        = $totalData;
      $data['controller']         = $adminAuth; 
      $data['totalPendingSum']    = $totalPendingSum->totalPendingRequest;
      return view('admin/layout/approvalRequest',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
	}
	
	public function memberDetail($id)
	{
    $session                    = \Config\Services::session($config);
    $userId                     = $session->get('userId');
    if(isset($userId)){
      $id                       = decoded($id);
      $adminAuth                = new AdminAuth();       
      $editUserMessage          = $session->get('editUserMessage');
      $totalData                = $adminAuth->getCompanyDetailData($id);
      $totalCommentData         = $adminAuth->getCompanyCommentData($id);
      $data['editUserMessage']  = $editUserMessage;
      $data['totalMember']      = $totalData;
      $data['totalCommentData'] = $totalCommentData;
      $data['controller']       = $adminAuth;


      $company =new Company();
      $membertype =new MemberType();
      $totalData = $adminAuth->getCompanyDetailData($id);
      $totalCommentData = $adminAuth->getCompanyCommentData($id);
      $companyList = $company->getCompanyTypeList();
      $businessCategoryList = $company->getParentCategoryList();
      $data['stateList'] = $company->getStateList();
      $data['districtList'] = $company->getDistrictListById($companyDetail->c_state);
      $data['cityList'] = $company->getCityListById($companyDetail->c_district);
      $data['categoryList'] = $businessCategoryList;
      $data['membertype']=$membertype->find();
      $data['Comcontroller'] = $company; 
      $data['companyList'] = $companyList;
      $data['id'] = $id;
    
      $unitDetail = $company->getUnitDetail($id);
      $categoryUnitDetail = $company->getCategoryUnitTypeList();
      $materialDetail = $company->getSubCategoryByParentID(3);
      $data['categoryUnitDetail'] = $categoryUnitDetail;
      $data['materialDetail'] = $materialDetail;
      $data['companyDetail'] = $unitDetail;
      if(isset($unitDetail->c_state)){
          $data['districtList'] = $company->getDistrictListById($unitDetail->c_state);
          $data['cityList'] = $company->getCityListById($unitDetail->c_district);
      }
      $data['stateList'] = $company->getStateList();

      return view('admin/layout/memberDetail',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
	}
  public function memberDelete($id)
  {
    $session = \Config\Services::session();
    $userId = $session->get('userId');
    if(isset($userId)){            
      $commonModel      = new CommonModel();
      $commonModel->delete_data('ecoex_company_bank_details', $id, 'c_id');
      $commonModel->delete_data('ecoex_company_address', $id, 'c_id');
      $commonModel->delete_data('ecoex_company_details', $id, 'c_id');
      $commonModel->delete_data('ecoex_user_table', $id, 'c_id');
      $commonModel->delete_data('ecoex_company', $id, 'c_id');
      return redirect()->to(base_url('admin/memberList'));
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }

	public function approveCompanyData($id)
	{
    $session = \Config\Services::session($config);
    $userId = $session->get('userId');
    if(isset($userId)){            
      $adminAuth        = new AdminAuth();
      $commonModel      = new CommonModel();
      $company          = new Company();
      $totalData        = $adminAuth->approveCompanyDataFnct($id,$userId);
      $companyData      = $company->getCompanyDetailByID($id);
      $companyUserData  = $company->getCompanyUserDataByID($id);
      /* password set email sent upon approve */
        $emailTemplate = $commonModel->find_data('ecoex_email_template', 'row', ['id' => 2]);
        $to = $companyUserData[0]['user_email'];
        $subject = "Password Reset :: Ecoex";
        $verificationLink = base_url('forgotPassword');
        $emailTemplate    = str_replace("{name}", $companyUserData[0]['user_name'], $emailTemplate->content);
        $emailTemplate1   = str_replace("{company}", $companyData[0]['c_name'], $emailTemplate);
        $message          = str_replace("{link}", $verificationLink, $emailTemplate1);        
        $commonModel->sendEmail($to,$subject,$message);
      /* password set email sent upon approve */
      /* save copy of admin email */
      $insertData = [
        'userID'      => $companyUserData[0]['user_id'],
        'email'       => $message,
        'createdAt'   => date('Y-m-d H:i:s')
      ];
      $commonModel->save_data('ecoex_email_log', $insertData, '', 'id');
      /* save copy of admin email */

      /* welcome email sent upon approve */
        $emailTemplate      = $commonModel->find_data('ecoex_email_template', 'row', ['id' => 10]);
        $to2                = $companyUserData[0]['user_email'];
        $subject2           = "Welcome On Board :: Ecoex";
        $message2           = $emailTemplate->content;        
        $commonModel->sendEmail($to2,$subject2,$message2);
      /* welcome email sent upon approve */
      /* save copy of admin email */
      $insertData2 = [
        'userID'      => $companyUserData[0]['user_id'],
        'email'       => $message2,
        'createdAt'   => date('Y-m-d H:i:s')
      ];
      $commonModel->save_data('ecoex_email_log', $insertData2, '', 'id');
      /* save copy of admin email */
      return redirect()->to(base_url('admin/memberDetail/'.encoded($id)));
    } else {
      return redirect()->to(base_url('admin/login'));
    }
	}
	public function setting()
	{
    $session = \Config\Services::session($config);
    $userId = $session->get('userId');
    if(isset($userId)){        
      $adminAuth              = new AdminAuth();
      $this->common_model     = new CommonModel();   
      $settingData            = $adminAuth->getAdminMemberDetailData($userId);
      $data['settingData']    = $settingData;
      $data['controller']     = $adminAuth; 
      $data['profileData']    = $this->common_model->find_data('ecoex_admin_user', 'row', ['id' => 1]);      
      $success = $session->get('success');      
      return view('admin/layout/setting',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
	}
	public function adminSettingData()
	{
    $session = \Config\Services::session($config);
    $this->common_model = new CommonModel();
    $siteSetting = $this->common_model->find_data('ecoex_setting', 'row');
    if($imagefile = $this->request->getFiles())
    {
        if($img = $imagefile['logo'])
        {
            if ($img->isValid() && ! $img->hasMoved())
            {
                $uploadedPancard = $img->getRandomName(); //This is if you want to change the file name to encrypted name
                $img->move(WRITEPATH.'uploads', $uploadedPancard);
            }
        }
    } else {
      $uploadedPancard = $siteSetting->logo;
    }
    $data = [
            'websiteName'           => $this->request->getPost('websiteName'),
            'site_email'            => $this->request->getPost('site_email'),
            'site_phone'            => $this->request->getPost('site_phone'),
            'site_whatsapp_no'      => $this->request->getPost('site_whatsapp_no'),
            'site_address'          => $this->request->getPost('site_address'),
            'site_state'            => $this->request->getPost('site_state'),
            'site_statecode'        => $this->request->getPost('site_statecode'),
            'site_gst'              => $this->request->getPost('site_gst'),
            'site_pan'              => $this->request->getPost('site_pan'),
            'establishment_year'    => $this->request->getPost('establishment_year'),
            'facebook_link'         => $this->request->getPost('facebook_link'),
            'twitter_link'          => $this->request->getPost('twitter_link'),
            'linkedin_link'         => $this->request->getPost('linkedin_link'),
            'instagram_link'        => $this->request->getPost('instagram_link'),
            'youtube_link'          => $this->request->getPost('youtube_link'),
            'keywords'              => $this->request->getPost('keywords'),
            'logo'                  => $uploadedPancard,
            'description'           => $this->request->getPost('description')
    ];
    $addCat = $this->common_model->save_data('ecoex_setting', $data, 1, 'id');
    $session->set('success','General Setting Updated Successfully!');
    return redirect()->to(base_url('admin/setting'));
	}
  public function profileSettingData()
  {
    $session = \Config\Services::session($config);
    $this->common_model = new CommonModel();
    $profileSetting = $this->common_model->find_data('ecoex_admin_user', 'row');
    if($this->request->getPost('password') != '')
    {
      $password = md5($this->request->getPost('password'));
    } else {
      $password = $profileSetting->password;
    }
    $data = [
            'name'           => $this->request->getPost('name'),
            'mobileNo'       => $this->request->getPost('mobileNo'),
            'username'       => $this->request->getPost('username'),
            'password'       => $password
    ];
    $addCat = $this->common_model->save_data('ecoex_admin_user', $data, 1, 'id');
    $session->set('success','Profile Setting Updated Successfully!');
    return redirect()->to(base_url('admin/setting'));
  }
  public function emailSettingData()
  {
    $session = \Config\Services::session($config);
    $this->common_model = new CommonModel();    
    $data = [
            'from_email'                => $this->request->getPost('from_email'),
            'from_name'                 => $this->request->getPost('from_name'),
            'smtp_host'                 => $this->request->getPost('smtp_host'),
            'smtp_username'             => $this->request->getPost('smtp_username'),
            'smtp_password'             => $this->request->getPost('smtp_password'),
            'smtp_port'                 => $this->request->getPost('smtp_port'),
    ];
    $addCat = $this->common_model->save_data('ecoex_setting', $data, 1, 'id');
    $session->set('success','Email Setting Updated Successfully!');
    return redirect()->to(base_url('admin/setting'));
  }
  public function paymentSettingData()
  {
    $session = \Config\Services::session($config);
    $this->common_model = new CommonModel();    
    $data = [
            'payment_gateway_mode'            => $this->request->getPost('payment_gateway_mode'),
            'sandbox_secret_key'              => $this->request->getPost('sandbox_secret_key'),
            'sandbox_publishable_key'         => $this->request->getPost('sandbox_publishable_key'),
            'live_secret_key'                 => $this->request->getPost('live_secret_key'),
            'live_publishable_key'            => $this->request->getPost('live_publishable_key'),
    ];
    $addCat = $this->common_model->save_data('ecoex_setting', $data, 1, 'id');
    $session->set('success','Payment Setting Updated Successfully!');
    return redirect()->to(base_url('admin/setting'));
  }
  public function smsSettingData()
  {
    $session = \Config\Services::session($config);
    $this->common_model = new CommonModel();    
    $data = [
            'authentication_key'        => $this->request->getPost('authentication_key'),
            'sender_id'                 => $this->request->getPost('sender_id'),
            'base_url'                  => $this->request->getPost('base_url'),
    ];
    $addCat = $this->common_model->save_data('ecoex_setting', $data, 1, 'id');
    $session->set('success','SMS Setting Updated Successfully!');
    return redirect()->to(base_url('admin/setting'));
  }
  public function bankSettingData()
  {
    $session = \Config\Services::session($config);
    $this->common_model = new CommonModel();    
    $data = [
            'bank_name'        => $this->request->getPost('bank_name'),
            'bank_branch'      => $this->request->getPost('bank_branch'),
            'account_no'       => $this->request->getPost('account_no'),
            'ifsc_code'        => $this->request->getPost('ifsc_code'),
    ];
    $addCat = $this->common_model->save_data('ecoex_setting', $data, 1, 'id');
    $session->set('success','Bank Setting Updated Successfully!');
    return redirect()->to(base_url('admin/setting'));
  }
  
	
  public function companyComment()
	{
        $session = \Config\Services::session($config);
        $userId = $session->get('userId');
        if(isset($userId)){
       $adminAuth =new AdminAuth();
            $id = $this->request->getPost('c_id');
            $data = [
                    'commentBox'=>$this->request->getPost('commentBox'),
                    'c_id'=>$this->request->getPost('c_id')
            ];
          $adminAuth->addCompanyComment($data);
	    
            return redirect()->to(base_url('admin/memberDetail/'.encoded($id)));
		} else {
            return redirect()->to(base_url('admin/login'));
		}
	}
  public function emailSetting()
	{
        $session = \Config\Services::session($config);
        $userId = $session->get('userId');
        if(isset($userId)){
        $adminAuth =new AdminAuth();
            
          $totalEmailTemplate = $adminAuth->getEmailSetting();
          $data['totalEmailTemplate'] = $totalEmailTemplate;
          $data['controller'] = $adminAuth; 
          
            return view('admin/layout/emailTemplate',$data);
            
		} else {
            return redirect()->to(base_url('admin/login'));
		}
	}
  public function emailLogs()
	{
        $session = \Config\Services::session($config);
        $userId = $session->get('userId');
        if(isset($userId)){
        $adminAuth =new AdminAuth();
            
          $totalEmailLogs = $adminAuth->getEmailLogs();
          $data['totalEmailLogs'] = $totalEmailLogs;
          $data['controller'] = $adminAuth; 
          
            return view('admin/layout/emailLogs',$data);
            
		} else {
            return redirect()->to(base_url('admin/login'));
		}
	}

  public function enquiryApp()
  {
    $session = \Config\Services::session($config);
    $userId = $session->get('userId');
    if(isset($userId)){
      $adminAuth                = new AdminAuth();
      $this->common_model       = new CommonModel();      
      $data['common_model']     = $this->common_model;
      $order_by[0]              = ['field' => 'id', 'type' => 'DESC'];
      $data['rows']             = $this->common_model->find_data('ecoex_temp_posting', 'array', ['published' => 1], '', '', '', $order_by);
      //pr($data['rows']);
      return view('admin/layout/enquiryApp',$data);            
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }

	public function editEmailTemplate($id)
	{
        $session = \Config\Services::session($config);
        $userId = $session->get('userId');
        if(isset($userId)){
            
          $adminAuth =new AdminAuth();
       
          $emailData = $adminAuth->getEmailDataByID($id);
          $data['emailData'] = $emailData;
          $data['controller'] = $adminAuth; 
          
          $success = $session->get('success');
          
            return view('admin/layout/editEmailTemplate',$data);
        } else {
            return redirect()->to(base_url('admin/login'));
        }
	}
	public function adminEmailData()
	{
        $session = \Config\Services::session($config);
          $adminAuth =new AdminAuth();
        $emailID = $this->request->getPost('emailID');
            $data = [
                    'subject'=>$this->request->getPost('subject'),
                    'content'=>$this->request->getPost('content'),
                    'emailID'=>$this->request->getPost('emailID')
            ];
            
            $session->set('success','Email Template Updated Successfully!');
            
          $addCat = $adminAuth->editTemplateData($data);
        return redirect()->to(base_url('admin/editEmailTemplate/'.$emailID));
	}
	public function manageEnquiry()
	{
        $session = \Config\Services::session($config);
        $userId = $session->get('userId');
        if(isset($userId)){
            
          $adminAuth =new AdminAuth();
       
          $targetData = $adminAuth->getTotalEnquiry();
          $data['targetData'] = $targetData;
          $data['controller'] = $adminAuth; 
          
          $success = $session->get('success');
          
            return view('admin/layout/manageEnquiry',$data);
        } else {
            return redirect()->to(base_url('admin/login'));
        }
	}
	
	public function editCompany($id)
	{
        $session = \Config\Services::session($config);
        $userId = $session->get('userId');
        if(isset($userId)){
          $id = decoded($id);
          $adminAuth =new AdminAuth();
       
          $company =new Company();
          $membertype =new MemberType();
          $totalData = $adminAuth->getCompanyDetailData($id);
          $totalCommentData = $adminAuth->getCompanyCommentData($id);
          $companyList = $company->getCompanyTypeList();
          $businessCategoryList = $company->getParentCategoryList();
          $data['stateList'] = $company->getStateList();
          $data['districtList'] = $company->getDistrictListById($companyDetail->c_state);
          $data['cityList'] = $company->getCityListById($companyDetail->c_district);
          $data['categoryList'] = $businessCategoryList;
          $data['membertype']=$membertype->find();
          $data['totalMember'] = $totalData;
          $data['totalCommentData'] = $totalCommentData;
          $data['controller'] = $adminAuth; ;
          $data['Comcontroller'] = $company; 
          $data['companyList'] = $companyList;
          $data['id'] = $id;
        
          $unitDetail = $company->getUnitDetail($id);
          $categoryUnitDetail = $company->getCategoryUnitTypeList();
          $materialDetail = $company->getSubCategoryByParentID(3);
          $data['categoryUnitDetail'] = $categoryUnitDetail;
          $data['materialDetail'] = $materialDetail;
          $data['companyDetail'] = $unitDetail;
          if(isset($unitDetail->c_state)){
              $data['districtList'] = $company->getDistrictListById($unitDetail->c_state);
              $data['cityList'] = $company->getCityListById($unitDetail->c_district);
          }
          $data['stateList'] = $company->getStateList();
        
          return view('admin/layout/editCompanyDetails',$data);
        } else {
            return redirect()->to(base_url('admin/login'));
        }
	}
	public function editMemberDetailsData()
	{
    $session = \Config\Services::session($config);
    $storeId =  $this->request->getPost('storeID');   
    $adminAuth =new AdminAuth();
    $company = new Company();
    $this->common_model = new CommonModel();
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
    $userData = ['user_membership_type' => $this->request->getPost('member_id')];
    $this->common_model->save_data('ecoex_user_table', $userData, $storeId, 'c_id');
    $data = [
            'storeID'=>$storeId,
            'user_mobile'=>$this->request->getPost('user_mobile'),
            'user_email'=>$this->request->getPost('user_email'),
            'establishDate'=>$this->request->getPost('establishDate'),
            'contactPerson'=>strtoupper($this->request->getPost('contactPerson')),
            'member_id'=>$this->request->getPost('member_id'),
            'companyType'=>$this->request->getPost('companyType'),
            'panNumber'=>strtoupper($this->request->getPost('panNumber')),
            'gstNumber'=>strtoupper($this->request->getPost('gstNumber')),
            'alMobile'=>$this->request->getPost('alMobile'),
            'alEmail'=>$this->request->getPost('alEmail'),
            'businessCategory'=>$busiCat,
            'panCard'=>$uploadedPancard,
            'GSTCard'=>$uploadedGSTcard,
            'COICard'=>$uploadedCOIcard
    ];
    //pr($data);exit;
    $storeUserDetail = $company->storeCompanyRegStepOne($data);
           
    $data = [
            'storeID'=>$storeId,
            'country'=>'1',
            'state'=>$this->request->getPost('state'),
            'district'=>$this->request->getPost('district'),
            'city'=>$this->request->getPost('city'),
            'pincode'=>$this->request->getPost('pincode'),
            'address'=>$this->request->getPost('address')
    ];
    //print_r($data);exit;
    $storeAddressDetail = $company->storeCompanyRegStepTwo($data);
            
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
    $storeBankDetail = $adminAuth->storeCompanyRegStepThree($data);
            
    $session->set('editUserMessage','Details Updated Successfully!');
    return redirect()->to(base_url('admin/memberDetail/'.encoded($storeId)));
	}
	
	public function editCompanyUnit($id,$unitId)
	{ 
        $session = \Config\Services::session($config);
        $userId = $session->get('userId');
        if(isset($userId)){
          $id = decoded($id);
          $unitId = decoded($unitId);
          $adminAuth =new AdminAuth();
       
          $company =new Company();
          $membertype =new MemberType();
          $totalData = $adminAuth->getCompanyDetailData($id);
          $totalCommentData = $adminAuth->getCompanyCommentData($id);
          $companyList = $company->getCompanyTypeList();
          $businessCategoryList = $company->getParentCategoryList();
          $data['stateList'] = $company->getStateList();
          $data['districtList'] = $company->getDistrictListById($companyDetail->c_state);
          $data['cityList'] = $company->getCityListById($companyDetail->c_district);
          $data['categoryList'] = $businessCategoryList;
          $data['membertype']=$membertype->find();
          $data['totalMember'] = $totalData;
          $data['totalCommentData'] = $totalCommentData;
          $data['controller'] = $adminAuth; ;
          $data['Comcontroller'] = $company; 
          $data['companyList'] = $companyList;
          $data['id'] = $id;
          $data['unitId'] = $unitId;
          
          $unitDetail = $company->getUnitDetail($unitId);
          $categoryUnitDetail = $company->getCategoryUnitTypeList();
          $materialDetail = $company->getSubCategoryByParentID(3);
          $data['categoryUnitDetail'] = $categoryUnitDetail;
          $data['materialDetail'] = $materialDetail;
          $data['companyDetail'] = $unitDetail;
          if(isset($unitDetail->c_state)){
              $data['districtList'] = $company->getDistrictListById($unitDetail->c_state);
              $data['cityList'] = $company->getCityListById($unitDetail->c_district);
          }
          $data['stateList'] = $company->getStateList();
          $data['commonModel'] = new CommonModel();
          return view('admin/layout/editCompanyUnit',$data);
        } else {
          return redirect()->to(base_url('admin/login'));
        }
	}
	
	public function editCompanyUnitData()
	{
        $session = \Config\Services::session($config);
        $storeId =  $this->request->getPost('storeID');  
        $unitId =  $this->request->getPost('unitID');   
        $adminAuth = new AdminAuth();
        $company = new Company();
        
          if($this->request->getPost('user_membership_type') == '2'){                   
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
                    'unitID'=>$unitId,
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
                    'state'=>$this->request->getPost('c_state1'),
                    'district'=>$this->request->getPost('c_district1'),
                    'city'=>$this->request->getPost('c_city1'),
                    'c_pincode'=>$this->request->getPost('c_pincode'),
                    'c_full_address'=>$this->request->getPost('c_full_address')
            ];
            //pr($data);
            $unitID = $adminAuth->storeCompanyRegStepFour($data);            
            if ($this->request->getFileMultiple('plant_images')) {    
              foreach($this->request->getFileMultiple('plant_images') as $file)
              {   
                if ($file->isValid() && ! $file->hasMoved())
                {
                  $dynamicImageName = $file->getRandomName();
                  $file->move(WRITEPATH . 'uploads', $dynamicImageName);
                  $data = [
                      'storeID'=>$storeId,
                      'unitID' => $unitID,
                      'type' => '0',
                      'file_name' =>  $dynamicImageName,
                      'file_type'  => $file->getClientMimeType()
                  ];
                  $adminAuth->addUnitPlantImages($data);
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
                      'unitID' => $unitID,
                      'type' => '1',
                      'file_name' =>  $dynamicImageName,
                      'file_type'  => $file->getClientMimeType()
                  ];
                  $adminAuth->addUnitPlantImages($data);
                }              
              }
            }
          }
          $session->set('editUserMessage','Details Updated Successfully!');
          return redirect()->to(base_url('admin/memberDetail/'.encoded($storeId)));
	}

  /* manage listing page */
  public function manageListingPage()
  {
    $session = \Config\Services::session($config);
    $userId = $session->get('userId');
    if(isset($userId)){        
      $this->common_model   = new CommonModel();
      $data['common_model'] = $this->common_model;
      $data['memberTypes']  = $this->common_model->find_data('ecoex_member_category', 'array');
      return view('admin/layout/listing-page',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }
  public function editManageListingpage($id)
  {
    $session = \Config\Services::session($config);
    $userId = $session->get('userId');
    if(isset($userId)){        
      $this->common_model     = new CommonModel();
      $data['common_model']   = $this->common_model;
      $data['id']             = $id;
      $data['memberTypeRow']  = $this->common_model->find_data('ecoex_member_category', 'row', ['member_id' => $id]);
      $data['memberTypes']    = $this->common_model->find_data('ecoex_member_category', 'array');
      if($this->request->getMethod() == 'post') {
        $postdata = $this->request->getPost();
        $reference_member_id = $postdata['reference_member_id'];
        $this->common_model->delete_data('ecoex_listing_access', $id, 'member_id');
        if(count($reference_member_id)>0){
          for($i=0;$i<count($reference_member_id);$i++){
            if(array_key_exists("subcat".$reference_member_id[$i],$postdata)){
              $postvalue = $postdata['subcat'.$reference_member_id[$i]];
              if(count($postvalue)){
                for($j=0;$j<count($postvalue);$j++){
                  $mainSubValue = explode("/",$postvalue[$j]);
                  $maincat = $mainSubValue[1];
                  $subcat = $mainSubValue[0];
                  $fields = [
                    'member_id' => $id,
                    'reference_member_id' => $reference_member_id[$i],
                    'maincat' => $maincat,
                    'subcat' => $subcat
                  ];
                  $this->common_model->save_data('ecoex_listing_access', $fields, '', 'id');
                }
              }
            }
          }
        }
        $session->set('editUserMessage','Details Updated Successfully!');
        return redirect()->to(base_url('admin/manageListingPage/'));
      }
      return view('admin/layout/editListingPage',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }
  public function updateManageListingpage($id)
  {
    $session = \Config\Services::session($config);
    $userId = $session->get('userId');
    if(isset($userId)){
      $this->common_model     = new CommonModel();
      
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }
  /* manage listing page */
  /* manage inventory inquiry */
  public function inquiryList()
  {
    $session                              = \Config\Services::session($config);
    $userId                               = $session->get('userId');
    if(isset($userId)){        
      $this->common_model                 = new CommonModel();
      /* inquiry data */
      $orderBy[0]                         = ['field' => 'id', 'type' => 'DESC']; 
      $data['submittedInquiries']         = $this->common_model->find_data('ecoex_business_inquiries', 'array', ['published' => 0], '', '', '', $orderBy);
      $data['documentUploadedInquiries']  = $this->common_model->find_data('ecoex_business_inquiries', 'array', ['published' => 1], '', '', '', $orderBy);
      //$data['adminApprovedInquiries']     = $this->common_model->find_data('ecoex_business_inquiries', 'array', ['published' => 2], '', '', '', $orderBy);

      $this->db   = \Config\Database::connect();      
      $data['adminApprovedInquiries']     = $this->db->query("SELECT * FROM ecoex_business_inquiries WHERE published = 2 ORDER BY id DESC")->getResult();
      $data['buyerAcceptInquiries']       = $this->db->query("SELECT * FROM ecoex_business_inquiries WHERE published = 3 ORDER BY id DESC")->getResult();
      $data['poUploadInquiries']          = $this->db->query("SELECT * FROM ecoex_business_inquiries WHERE published = 4 ORDER BY id DESC")->getResult();
      $data['poSharedInquiries']          = $this->db->query("SELECT * FROM ecoex_business_inquiries WHERE published = 5 ORDER BY id DESC")->getResult();
      $data['adminInvoicesInquiries']     = $this->db->query("SELECT * FROM ecoex_business_inquiries WHERE published = 6 ORDER BY id DESC")->getResult();
      $data['paymentUploadsInquiries']    = $this->db->query("SELECT * FROM ecoex_business_inquiries WHERE published = 7 ORDER BY id DESC")->getResult();
      $data['paymentAcceptInquiries']     = $this->db->query("SELECT * FROM ecoex_business_inquiries WHERE published = 8 ORDER BY id DESC")->getResult();
      //pr($data['adminInvoicesInquiries']);
      /* inquiry data */      
      $data['session']                    = $session;
      $data['common_model']               = $this->common_model;
      return view('admin/layout/inquiryList',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }    
  }
  public function inquiryDetails($id)
  { 
      $session                = \Config\Services::session();
      $userId                 = $session->get('userId');
      $inquiryId              = decoded($id);
      if(isset($userId)){
          $this->common_model     = new CommonModel();
          $data['common_model']   = $this->common_model;
          $data['session']        = $session;
          $data['attributes']     = $this->common_model->find_data('ecoex_upload_attributes', 'array', ['published' => 1]);
          /* inquiry data */
          $data['row']            = $this->common_model->find_data('ecoex_business_inquiries', 'row', ['id' => $inquiryId]);
          /* inquiry data */
          if($this->request->getPost()){
            //pr($this->request->getPost());
            $inquiry_id                     = $this->request->getPost('inquiry_id');
            $inventory_id                   = $this->request->getPost('inventory_id');           
            $inventory_details_id           = $this->request->getPost('inventory_details_id');
            $is_share                       = $this->request->getPost('is_share');
            if(count($is_share)){
              for($i=0;$i<count($is_share);$i++){
                $this->db = \Config\Database::connect();
                $this->db->query("update ecoex_business_inquiry_excel_data set published = 1 where inquiry_id = '$inquiry_id' and inventory_id = '$inventory_id' and inventory_details_id = '$inventory_details_id' and attr_id = '$is_share[$i]'");
              }
            }
            $this->common_model->save_data('ecoex_business_inquiries', ['published' => 2], $inquiry_id, 'id');

            /* sent mail to buyer for approved docs */
              $site_setting           = $this->common_model->find_data('ecoex_setting', 'row');
              $fields['site_setting'] = $site_setting;
              $fields['common_model'] = $this->common_model;
              $fields['inventory']    = $this->common_model->find_data('ecoex_business_inquiries', 'row', ['id' => $inquiry_id]);
              $buyer                  = $this->common_model->find_data('ecoex_user_table', 'row', ['user_id' => $fields['inventory']->buyer_id]);
              $html                   = view('email-template/inquiry-admin-approved',$fields);
              $subject                = 'Inquiry Uploaded Document Approved :: '.$fields['site_setting']->websiteName;
              $this->common_model->sendEmail((($buyer)?$buyer->user_email:''),$subject,$html);
            /* sent mail to buyer for approved docs */
            /* insert email logs */
              $insertData = [
                  'userID'    => $fields['inventory']->buyer_id,
                  'email'     => $html
              ];
              $this->common_model->save_data('ecoex_email_log', $insertData, '', 'id');
            /* insert email logs */

            $session->setFlashdata('success_message', 'Inquiry Documents Approved & Share To Buyer Successfully !!!');
            return redirect()->to(current_url());
          }
          return view('admin/layout/inquiryDetails',$data);
      } else {
          return redirect()->to(base_url('admin/login'));
      }
  }
  public function sharePO($id){
    $session                = \Config\Services::session();
    $userId                 = $session->get('userId');
    $inquiryId              = decoded($id);
    $this->common_model     = new CommonModel();
    $this->common_model->save_data('ecoex_business_inquiries', ['published' => 5], $inquiryId, 'id');

    /* sent mail to seller */
      $site_setting           = $this->common_model->find_data('ecoex_setting', 'row');
      $fields['site_setting'] = $site_setting;
      $fields['common_model'] = $this->common_model;
      $fields['inventory']    = $this->common_model->find_data('ecoex_business_inquiries', 'row', ['id' => $inquiryId]);
      $seller                 = $this->common_model->find_data('ecoex_user_table', 'row', ['user_id' => $fields['inventory']->seller_id]);
      $html                   = view('email-template/inquiry-admin-po-share',$fields);      
      $subject                = 'Buyer Uploaded Purchase Order Shared With Seller :: '.$fields['site_setting']->websiteName;
      $this->common_model->sendEmail((($seller)?$seller->user_email:''),$subject,$html);
    /* sent mail to seller */
    /* insert email logs */
      $insertData = [
          'userID'    => $fields['inventory']->seller_id,
          'email'     => $html
      ];
      $this->common_model->save_data('ecoex_email_log', $insertData, '', 'id');
    /* insert email logs */

    $session->setFlashdata('success_message', 'Purchase Order Shared To Seller Successfully !!!');
    return redirect()->to(base_url('admin/inquiryDetails/'.encoded($inquiryId)));
  }
  public function uploadInvoices($id)
  {
      $session                = \Config\Services::session();
      $userId                 = $session->get('userId');
      $inquiryId              = decoded($id);
      $this->common_model     = new CommonModel();
      /* invoice from seller */
        $file           = $this->request->getFile('seller_invoice_from_admin');
        $originalName   = $file->getClientName();
        $fieldName      = 'seller_invoice_from_admin';
        $upload_array   = $this->common_model->upload_single_file($fieldName,$originalName,'','pdf');        
        if($upload_array['status']) {
            $seller_invoice_from_admin = $upload_array['newFilename'];
        } else {
            $seller_invoice_from_admin = '';
        }
      /* invoice from seller */
      /* invoice from buyer */
        $file           = $this->request->getFile('buyer_invoice_from_admin');
        $originalName   = $file->getClientName();
        $fieldName      = 'buyer_invoice_from_admin';
        $upload_array   = $this->common_model->upload_single_file($fieldName,$originalName,'','pdf');        
        if($upload_array['status']) {
            $buyer_invoice_from_admin = $upload_array['newFilename'];
        } else {
            $buyer_invoice_from_admin = '';
        }
      /* invoice from buyer */
      $fields =   [
                      'seller_invoice_from_admin'             => $seller_invoice_from_admin,
                      'buyer_invoice_from_admin'              => $buyer_invoice_from_admin,
                      'published'                             => 6
                  ];
      $this->common_model->save_data('ecoex_business_inquiries', $fields, $inquiryId, 'id');
      
      $site_setting           = $this->common_model->find_data('ecoex_setting', 'row');
      $fields['site_setting'] = $site_setting;
      $fields['common_model'] = $this->common_model;
      $fields['inventory']    = $this->common_model->find_data('ecoex_business_inquiries', 'row', ['id' => $inquiryId]);
      $fields['seller']       = $this->common_model->find_data('ecoex_user_table','row',['user_id' =>$fields['inventory']->seller_id]);
      $fields['buyer']        = $this->common_model->find_data('ecoex_user_table','row',['user_id' =>$fields['inventory']->buyer_id]);        
      /* seller email */
        $html1                = view('email-template/inquiry-seller-invoice',$fields);
        //echo $html1;die;                
        $subject1             = 'Inquiry '.$fields['inventory']->inquiry_no.' Invoice :: '.$fields['site_setting']->websiteName;
        $filepath             = 'writable/uploads/';
        $fileName             = FCPATH.$filepath.$seller_invoice_from_admin;
        $this->common_model->sendEmail((($fields['seller'])?$fields['seller']->user_email:''),$subject1,$html1,$fileName);          
        /* insert email logs */
        $insertData = [
            'userID'    => '',
            'email'     => $html1
        ];
        $this->common_model->save_data('ecoex_email_log', $insertData, '', 'id');
        /* insert email logs */
      /* seller email */
      /* buyer email */
        $html2                = view('email-template/inquiry-buyer-invoice',$fields);
        //echo $html2;die;
        $subject2             = 'Inquiry '.$fields['inventory']->inquiry_no.' Invoice :: '.$fields['site_setting']->websiteName;
        $filepath             = 'writable/uploads/';
        $fileName             = FCPATH.$filepath.$buyer_invoice_from_admin;
        $this->common_model->sendEmail((($fields['buyer'])?$fields['buyer']->user_email:''),$subject2,$html2,$fileName);          
        /* insert email logs */
          $insertData = [
              'userID'    => '',
              'email'     => $html2
          ];
          $this->common_model->save_data('ecoex_email_log', $insertData, '', 'id');
        /* insert email logs */
      /* buyer email */
      $session->setFlashdata('success_message', 'Seller & Buyer Invoices Uploaded Successfully !!!');
      return redirect()->to(base_url('admin/inquiryDetails/'.encoded($inquiryId)));
    }

    public function acceptPayment($id){
        $session                = \Config\Services::session();
        $userId                 = $session->get('userId');
        $inquiryId              = decoded($id);
        $this->common_model     = new CommonModel();
        
        $fields =   [
                        'published'                             => 8
                    ];
        $this->common_model->save_data('ecoex_business_inquiries', $fields, $inquiryId, 'id');
        
        $site_setting           = $this->common_model->find_data('ecoex_setting', 'row');
        $fields['site_setting'] = $site_setting;
        $fields['common_model'] = $this->common_model;
        $fields['inventory']    = $this->common_model->find_data('ecoex_business_inquiries', 'row', ['id' => $inquiryId]);
        $fields['seller']       = $this->common_model->find_data('ecoex_user_table','row',['user_id' =>$fields['inventory']->seller_id]);
        $fields['buyer']        = $this->common_model->find_data('ecoex_user_table','row',['user_id' =>$fields['inventory']->buyer_id]);        
        
        /* buyer email */
          $html2                = view('email-template/inquiry-buyer-payment-accept',$fields);
          //echo $html2;die;
          $subject2             = 'Inquiry '.$fields['inventory']->inquiry_no.' Payment Accept :: '.$fields['site_setting']->websiteName;         
          $this->common_model->sendEmail((($fields['buyer'])?$fields['buyer']->user_email:''),$subject2,$html2);          
          /* insert email logs */
            $insertData = [
                'userID'    => $fields['inventory']->buyer_id,
                'email'     => $html2
            ];
            $this->common_model->save_data('ecoex_email_log', $insertData, '', 'id');
          /* insert email logs */
        /* buyer email */
        $session->setFlashdata('success_message', 'Buyer Uploaded Payment Data Accepted By EcoEx Successfully !!!');
        return redirect()->to(base_url('admin/inquiryDetails/'.encoded($inquiryId)));
    }
  /* manage inventory inquiry */
	
}