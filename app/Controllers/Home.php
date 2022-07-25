<?php
namespace App\Controllers;
use App\Models\Recycler;
use App\Models\CommonModel;
class Home extends BaseController
{
    /* change test */
    public function index()
    {
        $session                = \Config\Services::session();
        $loginError             = $session->get('loginError');
        $successMessage         = $session->get('successMessage');
        $dashboard              = new Recycler();
        $this->common_model     = new CommonModel();
        $inventoryData          = $dashboard->getAllInventoryList();
        $unitData               = $dashboard->getUnitList();
        $data['inventoryData']  = $inventoryData;
        $data['unitData']       = $unitData;
        $data['contoroller']    = $dashboard;
        $data['common_model']   = $this->common_model;
        $listingData            = [];
        $conditions = [];
        /* check login */
        $userType = $session->get('userType');
        $userId = $session->get('userId');
        if(!empty($userId) && ($userType == 'MEMBER')){
            $userData           = $this->common_model->find_data('ecoex_user_table', 'row', ['user_id' => $userId]);
            if($userData){
                $memberType     = $userData->user_membership_type;
                $accessLists    = $this->common_model->find_data('ecoex_listing_access', 'array', ['member_id' => $memberType, 'published' => 1]);
                //pr($accessLists);
                if($accessLists){
                    foreach($accessLists as $accessList){
                        $getParentChildTableField = $this->common_model->getParentChildTableField($accessList->reference_member_id);
                        if($getParentChildTableField['parentTable'] != ''){
                            $conditions     = [
                                $getParentChildTableField['parentTable'].'.visibility'  => 0,
                                $getParentChildTableField['parentTable'].'.published'   => 1,
                                $getParentChildTableField['parentTable'].'.categoryId'  => $accessList->maincat,
                                $getParentChildTableField['parentTable'].'.sucCatId'    => $accessList->subcat,
                            ];
                            $join[0]        = ['table' => $getParentChildTableField['childTable'], 'field' => $getParentChildTableField['childField'], 'table_master' => $getParentChildTableField['parentTable'], 'field_table_master' => $getParentChildTableField['parentField'], 'type' => 'INNER'];
                            $brandData      = $this->common_model->find_data($getParentChildTableField['parentTable'], 'array', $conditions, '', $join);
                            //$db = \Config\Database::connect();
                            //echo $db->getLastQuery();
                            //pr($brandData, false);
                            $inventorySource = $getParentChildTableField['inventorySource'];
                            //echo $inventorySource;die;
                        } else {
                            $brandData = [];
                            $inventorySource = '';
                        }
                        
                        if($brandData){
                            foreach($brandData as $row){
                                $state          = $this->common_model->find_data('ecoex_state', 'row', ['state_id' => $row->state_id], 'state_title');
                                $unit           = $this->common_model->find_data('ecoex_unit', 'row', ['id' => $row->unit], 'name');
                                $category       = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->categoryId], 'name');
                                $subcategory    = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->sucCatId], 'name');
                                $product        = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->productId], 'name');
                                $item           = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->itemId], 'name');
                                if(array_key_exists("attachment",$row)){
                                    $imageLink = (($row->attachment!='')?base_url('/writable/uploads/'.$row->attachment):base_url('/public/assets/No_Image_Available.jpg'));
                                } else {
                                    $imageLink = base_url('/public/assets/No_Image_Available.jpg');
                                }
                                if(array_key_exists("rate",$row)){
                                    $rateValue = (($row->rate>0)?$row->rate:0.00);
                                } else {
                                    $rateValue = 0.00;
                                }

                                $join2[0]        = ['table' => 'ecoex_user_table', 'field' => 'c_id', 'table_master' => 'ecoex_company', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                                $join2[1]        = ['table' => 'ecoex_member_category', 'field' => 'member_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'user_membership_type', 'type' => 'INNER'];
                                $company        = $this->common_model->find_data('ecoex_company', 'row', ['ecoex_company.c_id' => $row->c_id], 'ecoex_company.c_id,ecoex_company.c_name,ecoex_user_table.*,ecoex_member_category.member_type', $join2);
                                $inventoryId = (($row)?$row->id:'');

                                $joinCompany[0]         = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                                $companyData            = $this->common_model->find_data('ecoex_user_table', 'row', ['ecoex_user_table.c_id' => $row->c_id], 'ecoex_user_table.user_name,ecoex_user_table.user_email,ecoex_user_table.user_mobile,ecoex_company.c_name', $joinCompany);

                                $dataSubjectsValue = array_column($listingData, 'listing_id');
                                if (!in_array($inventoryId, $dataSubjectsValue)) {
                                    $listingData[]            = [
                                        'listing_from'      => $inventorySource,                                    
                                        'listing_id'        => $inventoryId,
                                        'listing_type'      => $row->inventory_type,
                                        'listing_company_name'      => (($companyData)?$companyData->c_name:''),
                                        'listing_company_email'     => (($companyData)?$companyData->user_email:''),
                                        'listing_company_phone'     => (($companyData)?$companyData->user_mobile:''),
                                        'listing_company_person'    => (($companyData)?$companyData->user_name:''),
                                        'listing_company'   => $row->c_id,
                                        'category'          => $category->name,
                                        'subcategory'       => $subcategory->name,
                                        'product'           => $product->name,
                                        'item'              => $item->name,
                                        'state'             => $state->state_title,
                                        'rate'              => number_format($rateValue,2),
                                        'qty'               => $row->req_qty,
                                        'unit'              => $unit->name,
                                        'month'             => $this->common_model->monthName($row->month),
                                        'year'              => $row->year,
                                        'image'             => $imageLink,
                                        'posting_datetime'  => $row->createdAt,
                                    ];
                                }

                                
                            }
                        }
                        
                    }

                    //die;
                }                
            } else {
                $userData = [];
            }
        } else {
            /* from brand panel */
            $join[0]            = ['table' => 'ecoex_target_by_state', 'field' => 'target_id', 'table_master' => 'ecoex_target', 'field_table_master' => 'target_id', 'type' => 'INNER'];
            $order_by[0]        = ['field' => 'ecoex_target_by_state.id', 'type' => 'DESC'];
            $conditions         = ['ecoex_target.visibility' => 0, 'ecoex_target.published' => 1];
            $brandData          = $this->common_model->find_data('ecoex_target', 'array', $conditions, '', $join, '', $order_by);        
            if($brandData){
                foreach($brandData as $row){
                    $state          = $this->common_model->find_data('ecoex_state', 'row', ['state_id' => $row->state_id], 'state_title');
                    $unit           = $this->common_model->find_data('ecoex_unit', 'row', ['id' => $row->unit], 'name');
                    $category       = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->categoryId], 'name');
                    $subcategory    = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->sucCatId], 'name');
                    $product        = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->productId], 'name');
                    $item           = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->itemId], 'name');
                    // $join[0]        = ['table' => 'ecoex_user_table', 'field' => 'c_id', 'table_master' => 'ecoex_company', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                    // $join[1]        = ['table' => 'ecoex_member_category', 'field' => 'member_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'user_membership_type', 'type' => 'INNER'];
                    // $company        = $this->common_model->find_data('ecoex_company', 'row', ['ecoex_company.c_id' => $row->c_id], 'ecoex_company.c_id,ecoex_company.c_name,ecoex_user_table.*,ecoex_member_category.member_type', $join);
                    $joinCompany[0]         = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                    $companyData            = $this->common_model->find_data('ecoex_user_table', 'row', ['ecoex_user_table.c_id' => $row->c_id], 'ecoex_user_table.user_name,ecoex_user_table.user_email,ecoex_user_table.user_mobile,ecoex_company.c_name', $joinCompany);
                    $listingData[]            = [
                        'listing_from'      => 'Brand',
                        'listing_id'        => (($row)?$row->id:''),
                        'listing_type'      => $row->inventory_type,
                        'listing_company_name'      => (($companyData)?$companyData->c_name:''),
                        'listing_company_email'     => (($companyData)?$companyData->user_email:''),
                        'listing_company_phone'     => (($companyData)?$companyData->user_mobile:''),
                        'listing_company_person'    => (($companyData)?$companyData->user_name:''),
                        'listing_company'   => $row->c_id,
                        'category'          => $category->name,
                        'subcategory'       => $subcategory->name,
                        'product'           => $product->name,
                        'item'              => $item->name,
                        'state'             => $state->state_title,
                        'rate'              => number_format(0,2),
                        'qty'               => $row->req_qty,
                        'unit'              => $unit->name,
                        'month'             => $this->common_model->monthName($row->month),
                        'year'              => $row->year,
                        'image'             => base_url('/public/assets/No_Image_Available.jpg'),
                        'posting_datetime'  => $row->createdAt,
                    ];
                }
            }
            /* from brand panel */
            /* from all other user panel */
            $join[0]            = ['table' => 'ecoex_inventory_by_state', 'field' => 'inventory_id', 'table_master' => 'ecoex_inventory', 'field_table_master' => 'inventory_id', 'type' => 'INNER'];
            $order_by[0]        = ['field' => 'ecoex_inventory_by_state.id', 'type' => 'DESC'];
            $conditions         = ['ecoex_inventory.visibility' => 0, 'ecoex_inventory.published' => 1];
            $recyclerData       = $this->common_model->find_data('ecoex_inventory', 'array', $conditions, '', $join, '', $order_by);
            //$this->db = \Config\Database::connect();
            //echo $this->db->getLastQuery();die;
            //pr($recyclerData);
            if($recyclerData){
                foreach($recyclerData as $row){
                    $state          = $this->common_model->find_data('ecoex_state', 'row', ['state_id' => $row->state_id], 'state_title');
                    $unit           = $this->common_model->find_data('ecoex_unit', 'row', ['id' => $row->unit], 'name');
                    $category       = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->categoryId], 'name');
                    $subcategory    = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->sucCatId], 'name');
                    $product        = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->productId], 'name');
                    $item           = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->itemId], 'name');
                    $join[0]        = ['table' => 'ecoex_user_table', 'field' => 'c_id', 'table_master' => 'ecoex_company', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                    $join[1]        = ['table' => 'ecoex_member_category', 'field' => 'member_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'user_membership_type', 'type' => 'INNER'];
                    $company        = $this->common_model->find_data('ecoex_company', 'row', ['ecoex_company.c_id' => $row->c_id], 'ecoex_company.c_id,ecoex_company.c_name,ecoex_user_table.*,ecoex_member_category.member_type', $join);

                    $joinCompany[0]         = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                    $companyData            = $this->common_model->find_data('ecoex_user_table', 'row', ['ecoex_user_table.c_id' => $row->c_id], 'ecoex_user_table.user_name,ecoex_user_table.user_email,ecoex_user_table.user_mobile,ecoex_company.c_name', $joinCompany);
                    $listingData[]            = [
                        'listing_from'      => (($company)?$company->member_type:''),
                        'listing_id'        => (($row)?$row->id:''),
                        'listing_type'      => $row->inventory_type,
                        'listing_company_name'      => (($companyData)?$companyData->c_name:''),
                        'listing_company_email'     => (($companyData)?$companyData->user_email:''),
                        'listing_company_phone'     => (($companyData)?$companyData->user_mobile:''),
                        'listing_company_person'    => (($companyData)?$companyData->user_name:''),
                        'listing_company'   => $row->c_id,
                        'category'          => $category->name,
                        'subcategory'       => $subcategory->name,
                        'product'           => $product->name,
                        'item'              => $item->name,
                        'state'             => $state->state_title,
                        'rate'              => number_format($row->rate,2),
                        'qty'               => $row->req_qty,
                        'unit'              => $unit->name,
                        'month'             => $this->common_model->monthName($row->month),
                        'year'              => $row->year,
                        'image'             => (($row->attachment!='')?base_url('/writable/uploads/'.$row->attachment):base_url('/public/assets/No_Image_Available.jpg')),
                        'posting_datetime'  => $row->createdAt,
                    ];
                }
            }
            /* from all other user panel */            
        }
        
        //pr($listingData);
        $data['listingData']    = $listingData;
        $data['states']         = $this->common_model->find_data('ecoex_state', 'array');
        $data['maincats']       = $this->common_model->find_data('ecoex_business_category', 'array', ['parent' => 0]);
        $data['storeId']        = $session->get('storeId'); 
        //pr($listingData);
        return view('landingPage',$data);
    }
    public function login()
    {
        $session = \Config\Services::session();
        $loginError = $session->get('loginError');
        $successMessage = $session->get('successMessage');
        return view('login');
    }
    public function getFilterData(){
        $session                        = \Config\Services::session();
        $this->db                       = \Config\Database::connect();
        $this->common_model             = new CommonModel();
        $apiStatus                      = TRUE;
        $apiMessage                     = '';
        $apiResponse                    = [];
        $listingData                    = [];
        $postData                       = $this->request->getPost();        
        //pr($postData);        
        $package_request_sorting        = $postData['package_request_sorting'];
        $userType = $session->get('userType');
        $userId = $session->get('userId');
        if(!empty($userId) && ($userType == 'MEMBER')){
            $userData           = $this->common_model->find_data('ecoex_user_table', 'row', ['user_id' => $userId]);
            if($userData){
                $memberType     = $userData->user_membership_type;
                $accessLists    = $this->common_model->find_data('ecoex_listing_access', 'array', ['member_id' => $memberType, 'published' => 1]);
                if($accessLists){
                    foreach($accessLists as $accessList){
                        $getParentChildTableField = $this->common_model->getParentChildTableField($accessList->reference_member_id);
                        if($getParentChildTableField['parentTable'] != ''){

                            $whereConditions                = '';
                            $subcatConditions               = '';
                            if(array_key_exists("subcatAttributeArray",$postData)){
                                $subcats = [];
                                if(count($postData['subcatAttributeArray'])>0){
                                    for($i=0;$i<count($postData['subcatAttributeArray']);$i++){
                                        $subcats[] = "'".$postData['subcatAttributeArray'][$i]."'";
                                    }
                                }
                                $subcatAttributeArray           = implode(",",$subcats);
                                $subcatConditions               = " AND a.sucCatId IN ($subcatAttributeArray)";
                                $whereConditions                .= $subcatConditions;
                            }
                            $inventoryTypeConditions = '';
                            if(array_key_exists("inventoryTypeAttributeArray",$postData)){
                                $inventorytypes = [];
                                if(count($postData['inventoryTypeAttributeArray'])>0){
                                    for($i=0;$i<count($postData['inventoryTypeAttributeArray']);$i++){
                                        $inventorytypes[] = "'".$postData['inventoryTypeAttributeArray'][$i]."'";
                                    }
                                }
                                $inventoryTypeAttributeArray    = implode(",",$inventorytypes);
                                $inventoryTypeConditions        = " AND a.inventory_type IN ($inventoryTypeAttributeArray)";
                                $whereConditions                .= $inventoryTypeConditions;
                            }
                            $stateConditions = '';
                            if(array_key_exists("stateAttributeArray",$postData)){
                                $states = [];
                                if(count($postData['stateAttributeArray'])>0){
                                    for($i=0;$i<count($postData['stateAttributeArray']);$i++){
                                        $states[] = "'".$postData['stateAttributeArray'][$i]."'";
                                    }
                                }
                                $stateAttributeArray            = implode(",",$states);
                                $stateConditions                = " AND b.state_id IN ($stateAttributeArray)";
                                $whereConditions                .= $stateConditions;
                            }

                            $parentTable    = $getParentChildTableField['parentTable'];
                            $parentField    = $getParentChildTableField['parentField'];
                            $childTable     = $getParentChildTableField['childTable'];
                            $childField     = $getParentChildTableField['childField'];

                            // $conditions     = [
                            //     $getParentChildTableField['parentTable'].'.visibility'  => 0,
                            //     $getParentChildTableField['parentTable'].'.categoryId'  => $accessList->maincat,
                            //     $getParentChildTableField['parentTable'].'.sucCatId'    => $accessList->subcat,
                            // ];


                            $sql = "SELECT * FROM ".$parentTable." as a INNER JOIN ".$childTable." as b ON b.".$childField."=a.".$parentField." WHERE a.visibility=0 AND a.published=1 AND a.categoryId = '$accessList->maincat' AND a.sucCatId = '$accessList->subcat' ".$whereConditions;
                            //echo $sql;
                            //die;
                            $brandData          = $this->db->query($sql)->getResult();
                            $inventorySource    = $getParentChildTableField['inventorySource'];
                        } else {
                            $brandData = [];
                            $inventorySource = '';
                        }                        
                        if($brandData){
                            foreach($brandData as $row){
                                $state          = $this->common_model->find_data('ecoex_state', 'row', ['state_id' => $row->state_id], 'state_title');
                                $unit           = $this->common_model->find_data('ecoex_unit', 'row', ['id' => $row->unit], 'name');
                                $category       = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->categoryId], 'name');
                                $subcategory    = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->sucCatId], 'name');
                                $product        = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->productId], 'name');
                                $item           = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->itemId], 'name');
                                if(array_key_exists("attachment",$row)){
                                    $imageLink = (($row->attachment!='')?base_url('/writable/uploads/'.$row->attachment):base_url('/public/assets/No_Image_Available.jpg'));
                                } else {
                                    $imageLink = base_url('/public/assets/No_Image_Available.jpg');
                                }
                                if(array_key_exists("rate",$row)){
                                    $rateValue = (($row->rate>0)?$row->rate:0.00);
                                } else {
                                    $rateValue = 0.00;
                                }

                                $join[0]        = ['table' => 'ecoex_user_table', 'field' => 'c_id', 'table_master' => 'ecoex_company', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                                $join[1]        = ['table' => 'ecoex_member_category', 'field' => 'member_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'user_membership_type', 'type' => 'INNER'];
                                $company        = $this->common_model->find_data('ecoex_company', 'row', ['ecoex_company.c_id' => $row->c_id], 'ecoex_company.c_id,ecoex_company.c_name,ecoex_user_table.*,ecoex_member_category.member_type', $join);

                                $dataSubjectsValue = array_column($listingData, 'listing_id');
                                if (!in_array($inventoryId, $dataSubjectsValue)) {
                                    $listingData[]            = [
                                        'listing_from'      => $inventorySource,
                                        'listing_id'        => $inventoryId,
                                        'listing_type'      => $row->inventory_type,
                                        'category'          => $category->name,
                                        'subcategory'       => $subcategory->name,
                                        'product'           => $product->name,
                                        'item'              => $item->name,
                                        'state'             => $state->state_title,
                                        'rate'              => $rateValue,
                                        'qty'               => $row->req_qty,
                                        'unit'              => $unit->name,
                                        'month'             => $this->common_model->monthName($row->month),
                                        'year'              => $row->year,
                                        'image'             => $imageLink,
                                        'posting_datetime'  => time_difference($row->createdAt),
                                    ];
                                }                                
                            }
                        }
                        
                    }
                }                
            } else {
                $userData = [];
            }
        } else {
            /* from brand panel */            
                $whereConditions                = '';
                $subcatConditions               = '';
                if(array_key_exists("subcatAttributeArray",$postData)){
                    $subcats = [];
                    if(count($postData['subcatAttributeArray'])>0){
                        for($i=0;$i<count($postData['subcatAttributeArray']);$i++){
                            $subcats[] = "'".$postData['subcatAttributeArray'][$i]."'";
                        }
                    }
                    $subcatAttributeArray           = implode(",",$subcats);
                    $subcatConditions               = " AND a.sucCatId IN ($subcatAttributeArray)";
                    $whereConditions                .= $subcatConditions;
                }
                $inventoryTypeConditions = '';
                if(array_key_exists("inventoryTypeAttributeArray",$postData)){
                    $inventorytypes = [];
                    if(count($postData['inventoryTypeAttributeArray'])>0){
                        for($i=0;$i<count($postData['inventoryTypeAttributeArray']);$i++){
                            $inventorytypes[] = "'".$postData['inventoryTypeAttributeArray'][$i]."'";
                        }
                    }
                    $inventoryTypeAttributeArray    = implode(",",$inventorytypes);
                    $inventoryTypeConditions        = " AND a.inventory_type IN ($inventoryTypeAttributeArray)";
                    $whereConditions                .= $inventoryTypeConditions;
                }
                $stateConditions = '';
                if(array_key_exists("stateAttributeArray",$postData)){
                    $states = [];
                    if(count($postData['stateAttributeArray'])>0){
                        for($i=0;$i<count($postData['stateAttributeArray']);$i++){
                            $states[] = "'".$postData['stateAttributeArray'][$i]."'";
                        }
                    }
                    $stateAttributeArray            = implode(",",$states);
                    $stateConditions                = " AND b.state_id IN ($stateAttributeArray)";
                    $whereConditions                .= $stateConditions;
                }
                $sql = "SELECT * FROM ecoex_target as a INNER JOIN ecoex_target_by_state as b ON b.target_id=a.target_id WHERE a.published=1 AND a.visibility=0 ".$whereConditions;
                $brandData          = $this->db->query($sql)->getResult();
                if($brandData){
                    foreach($brandData as $row){
                        $state          = $this->common_model->find_data('ecoex_state', 'row', ['state_id' => $row->state_id], 'state_title');
                        $unit           = $this->common_model->find_data('ecoex_unit', 'row', ['id' => $row->unit], 'name');
                        $category       = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->categoryId], 'name');
                        $subcategory    = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->sucCatId], 'name');
                        $product        = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->productId], 'name');
                        $item           = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->itemId], 'name');
                        $listingData[]            = [
                            'listing_from'      => urlencode(base64_encode('Brand')),
                            'listing_id'        => urlencode(base64_encode((($row)?$row->id:''))),
                            'listing_type'      => $row->inventory_type,
                            'category'          => $category->name,
                            'subcategory'       => $subcategory->name,
                            'product'           => $product->name,
                            'item'              => $item->name,
                            'state'             => $state->state_title,
                            'rate'              => 0,
                            'qty'               => $row->req_qty,
                            'unit'              => $unit->name,
                            'month'             => $this->common_model->monthName($row->month),
                            'year'              => $row->year,
                            'image'             => base_url('/public/assets/No_Image_Available.jpg'),
                            'posting_datetime'  => time_difference($row->createdAt),
                        ];
                    }
                }
            /* from brand panel */
            /* from recycler panel */
                $whereConditions                = '';
                $subcatConditions               = '';
                if(array_key_exists("subcatAttributeArray",$postData)){
                    $subcats = [];
                    if(count($postData['subcatAttributeArray'])>0){
                        for($i=0;$i<count($postData['subcatAttributeArray']);$i++){
                            $subcats[] = "'".$postData['subcatAttributeArray'][$i]."'";
                        }
                    }
                    $subcatAttributeArray           = implode(",",$subcats);
                    $subcatConditions               = " AND a.sucCatId IN ($subcatAttributeArray)";
                    $whereConditions                .= $subcatConditions;
                }
                $inventoryTypeConditions = '';
                if(array_key_exists("inventoryTypeAttributeArray",$postData)){
                    $inventorytypes = [];
                    if(count($postData['inventoryTypeAttributeArray'])>0){
                        for($i=0;$i<count($postData['inventoryTypeAttributeArray']);$i++){
                            $inventorytypes[] = "'".$postData['inventoryTypeAttributeArray'][$i]."'";
                        }
                    }
                    $inventoryTypeAttributeArray    = implode(",",$inventorytypes);
                    $inventoryTypeConditions        = " AND a.inventory_type IN ($inventoryTypeAttributeArray)";
                    $whereConditions                .= $inventoryTypeConditions;
                }
                $stateConditions = '';
                if(array_key_exists("stateAttributeArray",$postData)){
                    $states = [];
                    if(count($postData['stateAttributeArray'])>0){
                        for($i=0;$i<count($postData['stateAttributeArray']);$i++){
                            $states[] = "'".$postData['stateAttributeArray'][$i]."'";
                        }
                    }
                    $stateAttributeArray            = implode(",",$states);
                    $stateConditions                = " AND b.state_id IN ($stateAttributeArray)";
                    $whereConditions                .= $stateConditions;
                }
                $sql = "SELECT * FROM ecoex_inventory as a INNER JOIN ecoex_inventory_by_state as b ON b.inventory_id=a.inventory_id WHERE a.published=1 AND a.visibility=0 ".$whereConditions;
                $recyclerData          = $this->db->query($sql)->getResult();
                if($recyclerData){
                    foreach($recyclerData as $row){
                        $state          = $this->common_model->find_data('ecoex_state', 'row', ['state_id' => $row->state_id], 'state_title');
                        $unit           = $this->common_model->find_data('ecoex_unit', 'row', ['id' => $row->unit], 'name');
                        $category       = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->categoryId], 'name');
                        $subcategory    = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->sucCatId], 'name');
                        $product        = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->productId], 'name');
                        $item           = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->itemId], 'name');

                        $join[0]        = ['table' => 'ecoex_user_table', 'field' => 'c_id', 'table_master' => 'ecoex_company', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                        $join[1]        = ['table' => 'ecoex_member_category', 'field' => 'member_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'user_membership_type', 'type' => 'INNER'];
                        $company        = $this->common_model->find_data('ecoex_company', 'row', ['ecoex_company.c_id' => $row->c_id], 'ecoex_company.c_id,ecoex_company.c_name,ecoex_user_table.*,ecoex_member_category.member_type', $join);

                        $listingData[]            = [
                            'listing_from'      => urlencode(base64_encode((($company)?$company->member_type:''))),
                            'listing_id'        => urlencode(base64_encode((($row)?$row->id:''))),
                            'listing_type'      => $row->inventory_type,
                            'category'          => $category->name,
                            'subcategory'       => $subcategory->name,
                            'product'           => $product->name,
                            'item'              => $item->name,
                            'state'             => $state->state_title,
                            'rate'              => $row->rate,
                            'qty'               => $row->req_qty,
                            'unit'              => $unit->name,
                            'month'             => $this->common_model->monthName($row->month),
                            'year'              => $row->year,
                            'image'             => (($row->attachment!='')?base_url('/writable/uploads/'.$row->attachment):base_url('/public/assets/No_Image_Available.jpg')),
                            'posting_datetime'  => time_difference($row->createdAt),
                        ];
                    }
                }
            /* from recycler panel */
        }

        /* sorting */
        if($package_request_sorting != ''){
            $sortingArray   = explode("-", $package_request_sorting);
            $soringField    = $sortingArray[0];
            $soringType     = $sortingArray[1];
            if($soringField == 'name' && $soringType == 'asc'){
                $sort_field = 'item';
                $sort_type = SORT_ASC;
            } elseif($soringField == 'name' && $soringType == 'desc'){
                $sort_field = 'item';
                $sort_type = SORT_DESC;
            } elseif($soringField == 'rate' && $soringType == 'asc'){
                $sort_field = 'rate';
                $sort_type = SORT_ASC;
            } elseif($soringField == 'rate' && $soringType == 'desc'){
                $sort_field = 'rate';
                $sort_type = SORT_DESC;
            }
            $price = array();
            foreach ($listingData as $key => $row)
            {
                $price[$key] = $row[$sort_field];
            }
            array_multisort($price, $sort_type, $listingData);
        }
        /* sorting */
        
        //pr($listingData);
        $apiResponse    = $listingData;
        $data           = ['status' => $apiStatus, 'message' => $apiMessage, 'response' => $apiResponse];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    public function itemDetails($listingFrom,$listingId){
        $session                = \Config\Services::session();
        //pr($session->get());        
        $loginError             = $session->get('loginError');
        $successMessage         = $session->get('successMessage');
        $dashboard              = new Recycler();
        $this->common_model     = new CommonModel();
        $inventoryData          = $dashboard->getAllInventoryList();
        $unitData               = $dashboard->getUnitList();
        $data['inventoryData']  = $inventoryData;
        $data['unitData']       = $unitData;
        $data['contoroller']    = $dashboard;
        $data['common_model']   = $this->common_model;
        $listingData            = [];
        $conditions             = [];
        $listing_from           = base64_decode(urldecode($listingFrom));
        $listing_id             = base64_decode(urldecode($listingId));

        /* gather view count */
            $userId     = $session->get('userId');
            $user_id    = ((!empty($userId))?$userId:0);
            $checkPostView = $this->common_model->find_data('post_view', 'row', ['post_id' => $listing_id, 'user_id' => $user_id, 'ip_address' => $this->request->getIPAddress()]);
            //$this->db = \Config\Database::connect();
            //echo $this->db->getLastQuery();
            //pr($checkPostView);
            if($checkPostView){
                // $fieldsView = [
                //     'post_id'       => $listing_id,
                //     'user_id'       => $user_id,
                //     'ip_address'    => $this->request->getIPAddress(),
                //     'updated_at'    => date('Y-m-d H:i:s')
                // ];
                // $this->common_model->save_data('post_view', $fieldsView, $checkPostView->id, 'id');
            } else {
                $fieldsView = [
                    'post_id'       => $listing_id,
                    'user_id'       => $user_id,
                    'ip_address'    => $this->request->getIPAddress()
                ];
                $this->common_model->save_data('post_view', $fieldsView, '', 'id');
            }
        /* gather view count */
        
        if($listing_from == 'Brand'){
            $parentTable    = 'ecoex_target';
            $parentfield    = 'target_id';
            $childTable     = 'ecoex_target_by_state';
            $childField     = 'target_id';
        } else {
            $parentTable    = 'ecoex_inventory';
            $parentfield    = 'inventory_id';
            $childTable     = 'ecoex_inventory_by_state';
            $childField     = 'inventory_id';
        }
        
        $join[0]            = ['table' => $childTable, 'field' => $childField, 'table_master' => $parentTable, 'field_table_master' => $parentfield, 'type' => 'INNER'];
        $order_by[0]        = ['field' => $childTable.'.id', 'type' => 'DESC'];
        $conditions         = [$childTable.'.id' => $listing_id];
        $row                = $this->common_model->find_data($parentTable, 'row', $conditions, '', $join, '', $order_by);
        if($row){            
            $state          = $this->common_model->find_data('ecoex_state', 'row', ['state_id' => $row->state_id], 'state_title');
            $unit           = $this->common_model->find_data('ecoex_unit', 'row', ['id' => $row->unit], 'name');
            $category       = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->categoryId], 'name');
            $subcategory    = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->sucCatId], 'name');
            $product        = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->productId], 'name');
            $item           = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->itemId], 'name');

            $listingData            = [
                'listing_from'              => 'Collector',
                'listing_type'              => $row->inventory_type,
                'listing_id'                => $row->id,
                'c_id'                      => $row->c_id,
                'category'                  => $category->name,
                'subcategory'               => $subcategory->name,
                'product'                   => $product->name,
                'item'                      => $item->name,
                'state'                     => $state->state_title,
                'rate'                      => number_format($row->rate,2),
                'qty'                       => $row->req_qty,
                'unit'                      => $unit->name,
                'month'                     => $this->common_model->monthName($row->month),
                'year'                      => $row->year,
                'document_required'         => $row->document_required,
                'image'                     => (($row->attachment!='')?base_url('/writable/uploads/'.$row->attachment):base_url('/public/assets/No_Image_Available.jpg')),               
            ];            
        }
        //pr($listingData);
        $data['itemDetails']            = $listingData;
        $data['documentLists']          = $this->common_model->find_data('ecoex_document_list', 'array', ['published' => 1]);
        $data['listing_from']           = base64_decode(urldecode($listingFrom));
        $data['listing_id']             = base64_decode(urldecode($listingId));
        $data['user_id']                = $session->get('userId');
        return view('item-details',$data);
    }
    public function testMail(){
        echo "test mail";
        $this->common_model     = new CommonModel();
        $msgBody = '<h1>test mail on 21-06-2022</h1>';
        $this->common_model->sendEmail2('subhomoy@keylines.net', 'Test mail 21062022', $msgBody);
    }
    public function marketPlaceSubmitInquiry(){
        $session                = \Config\Services::session();        
        $this->common_model     = new CommonModel();        
        $data['common_model']   = $this->common_model;
        $apiStatus              = FALSE; 
        $apiMessage             = ""; 
        $apiResponse            = [];
        $listing_from           = $this->request->getPost('listing_from');
        $listing_id             = $this->request->getPost('listing_id');
        $user_id                = $this->request->getPost('user_id');
        $qty                    = $this->request->getPost('qty');
        $document_list          = $this->request->getPost('document_list');
        
        if($user_id){
            if($document_list != ''){
                /* buyer */
                    $join[0]            = ['table' => 'ecoex_member_category', 'field' => 'member_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'user_membership_type', 'type' => 'INNER'];
                    $conditions         = ['ecoex_user_table.user_id' => $user_id];
                    $buyer              = $this->common_model->find_data('ecoex_user_table', 'row', $conditions, 'ecoex_user_table.*,ecoex_member_category.member_type', $join);
                /* buyer */

                /* inventory */
                    if($listing_from == 'Brand'){
                        $parentTable          = 'ecoex_target';
                        $parentField          = 'target_id';
                        $childTable           = 'ecoex_target_by_state';
                        $childField           = 'target_id';
                    } else {
                        $parentTable          = 'ecoex_inventory';
                        $parentField          = 'inventory_id';
                        $childTable           = 'ecoex_inventory_by_state';
                        $childField           = 'inventory_id';
                    }
                    $join2[0]                 = ['table' => $childTable, 'field' => $childField, 'table_master' => $parentTable, 'field_table_master' => $parentField, 'type' => 'INNER'];
                    $conditions               = [$childTable.'.id' => $listing_id];
                    $inventory                = $this->common_model->find_data($parentTable, 'row', $conditions, '', $join2);
                    //$db = \Config\Database::connect();
                    //echo $db->getLastQuery();
                    //pr($inventory);
                    //die;
                /* inventory */

                /* seller */
                    $join3[0]               = ['table' => 'ecoex_member_category', 'field' => 'member_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'user_membership_type', 'type' => 'INNER'];
                    $join3[1]               = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                    $conditions             = ['ecoex_company.c_id' => (($inventory)?$inventory->c_id:'')];
                    $seller                 = $this->common_model->find_data('ecoex_user_table', 'row', $conditions, 'ecoex_user_table.*,ecoex_member_category.member_type', $join3);
                /* seller */
                /* inquiry number generate */
                $orderBy[0] = ['field' => 'id', 'type' => 'DESC'];
                $checkInquiry = $this->common_model->find_data('ecoex_business_inquiries', 'row', '', '', '', '', $orderBy);
                if($checkInquiry){
                    $slNo = $checkInquiry->sl_no+1;
                    $inquiry_no = str_pad($slNo,7,0,STR_PAD_LEFT);
                } else {
                    $slNo = 1;
                    $inquiry_no = str_pad($slNo,7,0,STR_PAD_LEFT);
                }
                /* inquiry number generate */

                if($inventory->inventory_type == 'SELL'){
                    $require_documents  = json_encode($document_list);
                    $buyer_type         = (($buyer)?$buyer->member_type:'');
                    $buyer_id           = $user_id;
                    $seller_type        = (($seller)?$seller->member_type:'');
                    $seller_id          = (($seller)?$seller->user_id:'');
                } else {
                    $require_documents  = $inventory->document_required;
                    $buyer_type         = (($seller)?$seller->member_type:'');
                    $buyer_id           = (($seller)?$seller->user_id:'');
                    $seller_type        = (($buyer)?$buyer->member_type:'');
                    $seller_id          = $user_id;
                }

                $fields = [
                    'sl_no'                 => $slNo,
                    'inquiry_no'            => $inquiry_no,
                    'buyer_type'            => $buyer_type,
                    'buyer_id'              => $buyer_id,
                    'seller_type'           => $seller_type,
                    'seller_id'             => $seller_id,
                    'inventory_id'          => (($inventory)?$inventory->$childField:0),
                    'inventory_details_id'  => $listing_id,
                    'require_qty'           => $qty,
                    'require_documents'     => $require_documents,
                ];
                //pr($fields);
                $this->common_model->save_data('ecoex_business_inquiries', $fields, '', 'id');
                $fields['site_setting'] = $this->common_model->find_data('ecoex_setting', 'row');
                $fields['common_model'] = $this->common_model;
                $fields['inventory']    = $inventory;
                //pr($fields);
                $html                   = view('email-template/inquiry-request',$fields);                
                $subject                = 'New Inquiry :: '.$fields['site_setting']->websiteName;
                $this->common_model->sendEmail((($seller)?$seller->user_email:''),$subject,$html);

                /* insert email logs */
                $insertData = [
                    'userID'    => (($seller)?$seller->user_id:''),
                    'email'     => $html
                ];
                $this->common_model->save_data('ecoex_email_log', $insertData, '', 'id');
                /* insert email logs */

                $apiStatus                          = TRUE;
                $apiMessage                         = "Your Inquiry Submitted Successfully. We Will Contact You Soon !!!";
                $apiResponse['login_status']        = 1;
            } else {
                $apiStatus                          = FALSE;
                $apiMessage                         = "You Need To Select At Least One Document !!!";
                $apiResponse['login_status']        = 1;
            }            
        } else {
            $apiStatus                          = FALSE;
            $apiMessage                         = "Please register to send an inquiry, if already registered, please sign in. !!!";
            $apiResponse['login_status']        = 0;
        }
        $data           = ['status' => $apiStatus, 'message' => $apiMessage, 'response' => $apiResponse];
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        //pr($this->request->getPost());
    }
}
