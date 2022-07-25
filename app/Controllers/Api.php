<?php
namespace App\Controllers;
use App\Models\Recycler;
use App\Models\CommonModel;
class Api extends BaseController
{    
    public function signin()
    {
        $this->isJSON(file_get_contents('php://input'));
        $postData = $this->extract_json(file_get_contents('php://input'));        
        $requiredFields =['email', 'password'];
        if (!$this->validateArray($requiredFields, $postData)):
            $this->response_to_json(FALSE, "All data are not present");
        endif;
        $this->db                       = \Config\Database::connect();
        $this->common_model             = new CommonModel();
        $apiStatus                      = TRUE;
        $apiMessage                     = '';
        $apiResponse                    = [];             
        $checkLogin                     = $this->common_model->find_data('ecoex_user_table', 'row', ['user_email' => $postData['email'], 'user_password' => md5($postData['password']), 'user_membership_type' => 2]);
        if($checkLogin){
            $apiStatus                      = TRUE;
            $apiMessage                     = 'SignIn Successfully !!!';
            $apiResponse                    = $checkLogin;
        } else {
            $apiStatus                      = FALSE;
            $apiMessage                     = 'Invalid Credentials !!!';
        }
        $this->response_to_json($apiStatus ,$apiMessage, $apiResponse);
    }
    public function inventoryListing()
    {
        $this->isJSON(file_get_contents('php://input'));
        $postData = $this->extract_json(file_get_contents('php://input'));        
        $requiredFields =['user_id'];
        if (!$this->validateArray($requiredFields, $postData)):
            $this->response_to_json(FALSE, "All data are not present");
        endif;
        $this->db                       = \Config\Database::connect();
        $this->common_model             = new CommonModel();
        $apiStatus                      = TRUE;
        $apiMessage                     = '';
        $apiResponse                    = [];             
        $listingData                    = [];             
        /* from collector panel */
        $join[0]            = ['table' => 'ecoex_inventory_by_state', 'field' => 'inventory_id', 'table_master' => 'ecoex_inventory', 'field_table_master' => 'inventory_id', 'type' => 'INNER'];
        $order_by[0]        = ['field' => 'ecoex_inventory_by_state.id', 'type' => 'DESC'];
        $conditions         = ['ecoex_inventory.visibility' => 0];
        $collectorData      = $this->common_model->find_data('ecoex_inventory', 'array', $conditions, '', $join, '', $order_by);
        if($collectorData){
            foreach($collectorData as $row){
                $state          = $this->common_model->find_data('ecoex_state', 'row', ['state_id' => $row->state_id], 'state_title');
                $unit           = $this->common_model->find_data('ecoex_unit', 'row', ['id' => $row->unit], 'name');
                $category       = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->categoryId], 'name');
                $subcategory    = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->sucCatId], 'name');
                $product        = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->productId], 'name');
                $item           = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->itemId], 'name');
                $listingData[]            = [
                    'listing_from'  => 'Collector',
                    'listing_type'  => $row->inventory_type,
                    'listing_id'    => $row->id,
                    'c_id'          => $row->c_id,
                    'category'      => $category->name,
                    'subcategory'   => $subcategory->name,
                    'product'       => $product->name,
                    'item'          => $item->name,
                    'state'         => $state->state_title,
                    'rate'          => number_format($row->rate,2),
                    'qty'           => $row->req_qty,
                    'unit'          => $unit->name,
                    'month'         => $this->common_model->monthName($row->month),
                    'year'          => $row->year,
                    'image'         => (($row->attachment!='')?base_url('/writable/uploads/'.$row->attachment):base_url('/public/assets/No_Image_Available.jpg')),
                ];
            }
        }
        /* from collector panel */
        $apiResponse = $listingData;
        $this->response_to_json($apiStatus ,$apiMessage, $apiResponse);
    }
    public function inventoryDetails()
    {
        $this->isJSON(file_get_contents('php://input'));
        $postData = $this->extract_json(file_get_contents('php://input'));        
        $requiredFields =['user_id', 'c_id', 'listing_id'];
        if (!$this->validateArray($requiredFields, $postData)):
            $this->response_to_json(FALSE, "All data are not present");
        endif;
        $this->db                       = \Config\Database::connect();
        $this->common_model             = new CommonModel();
        $apiStatus                      = TRUE;
        $apiMessage                     = '';
        $apiResponse                    = [];             
        $listingData                    = [];             
        /* from collector panel */
        $join[0]            = ['table' => 'ecoex_inventory_by_state', 'field' => 'inventory_id', 'table_master' => 'ecoex_inventory', 'field_table_master' => 'inventory_id', 'type' => 'INNER'];
        $order_by[0]        = ['field' => 'ecoex_inventory_by_state.id', 'type' => 'DESC'];
        $conditions         = ['ecoex_inventory.visibility' => 0, 'ecoex_inventory_by_state.id' => $postData['listing_id']];
        $row                = $this->common_model->find_data('ecoex_inventory', 'row', $conditions, '', $join, '', $order_by);
        if($row){            
            $state          = $this->common_model->find_data('ecoex_state', 'row', ['state_id' => $row->state_id], 'state_title');
            $unit           = $this->common_model->find_data('ecoex_unit', 'row', ['id' => $row->unit], 'name');
            $category       = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->categoryId], 'name');
            $subcategory    = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->sucCatId], 'name');
            $product        = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->productId], 'name');
            $item           = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->itemId], 'name');

            $conditions2    = [
                'recycler_id'   => $postData['user_id'],
                'c_id'          => $postData['c_id'],
                'inventory_id'  => $postData['listing_id'],
            ];
            $uploadedDocument = $this->common_model->find_data('ecoex_temp_posting', 'row', $conditions2);
            if($uploadedDocument){
                $aadhar     = (($uploadedDocument->aadhar_file!='')?base_url('/writable/uploads/'.$uploadedDocument->aadhar_file):base_url('/public/assets/No_Image_Available.jpg'));
                $votar      = (($uploadedDocument->votar_file!='')?base_url('/writable/uploads/'.$uploadedDocument->votar_file):base_url('/public/assets/No_Image_Available.jpg'));
                $pan        = (($uploadedDocument->pan_file!='')?base_url('/writable/uploads/'.$uploadedDocument->pan_file):base_url('/public/assets/No_Image_Available.jpg'));
                $document   = (($uploadedDocument->document_file!='')?base_url('/writable/uploads/'.$uploadedDocument->document_file):base_url('/public/assets/No_Image_Available.jpg'));
                $upload_status = $uploadedDocument->published;
            } else {
                $aadhar     = base_url('/public/assets/No_Image_Available.jpg');
                $votar      = base_url('/public/assets/No_Image_Available.jpg');
                $pan        = base_url('/public/assets/No_Image_Available.jpg');
                $document   = base_url('/public/assets/No_Image_Available.jpg');
                $upload_status = 0;
            }
            $listingData[]            = [
                'listing_from'  => 'Collector',
                'listing_type'  => $row->inventory_type,
                'listing_id'    => $row->id,
                'c_id'          => $row->c_id,
                'category'      => $category->name,
                'subcategory'   => $subcategory->name,
                'product'       => $product->name,
                'item'          => $item->name,
                'state'         => $state->state_title,
                'rate'          => number_format($row->rate,2),
                'qty'           => $row->req_qty,
                'unit'          => $unit->name,
                'month'         => $this->common_model->monthName($row->month),
                'year'          => $row->year,
                'image'         => (($row->attachment!='')?base_url('/writable/uploads/'.$row->attachment):base_url('/public/assets/No_Image_Available.jpg')),
                'uploaded_documents' => [
                    'aadhar'    => $aadhar,
                    'votar'     => $votar,
                    'pan'       => $pan,
                    'document'  => $document,
                ],
                'upload_status'  => $upload_status
            ];            
        }
        /* from collector panel */
        $apiResponse = $listingData;
        $this->response_to_json($apiStatus ,$apiMessage, $apiResponse);
    }
    public function documentUpload(){
        $this->isJSON(file_get_contents('php://input'));
        $postData = $this->extract_json(file_get_contents('php://input'));        
        $requiredFields =['user_id', 'c_id', 'listing_id', 'field_name', 'upload_file'];
        if (!$this->validateArray($requiredFields, $postData)):
            $this->response_to_json(FALSE, "All data are not present");
        endif;
        $this->db                       = \Config\Database::connect();
        $this->common_model             = new CommonModel();
        $apiStatus                      = TRUE;
        $apiMessage                     = '';
        $apiResponse                    = [];
        $listingData                    = [];
        /* upload document code */        
        $upload_file    = $postData['upload_file'];        
        $img            = $upload_file['base64'];
        $img            = str_replace('data:image/jpeg;base64,', '', $img);
        $img            = str_replace(' ', '+', $img);
        $data           = base64_decode($img);
        $fileName       = uniqid() . '.jpg';
        $file           = 'writable/uploads/' . $fileName;
        $success        = file_put_contents($file, $data);
        
        /* upload document code */
        $conditions2    = [
                'recycler_id'   => $postData['user_id'],
                'c_id'          => $postData['c_id'],
                'inventory_id'  => $postData['listing_id'],
            ];
        $uploadedDocument = $this->common_model->find_data('ecoex_temp_posting', 'row', $conditions2);
        if($uploadedDocument){
            $fields = [
                $postData['field_name']                 => $fileName,
                $postData['field_name'].'_upload'       => date('Y-m-d H:i:s')
            ];
            //pr($fields);
            $this->common_model->save_data('ecoex_temp_posting', $fields, $uploadedDocument->id, 'id');
        } else {
            $fields = [
                'recycler_id'                           => $postData['user_id'],
                'c_id'                                  => $postData['c_id'],
                'inventory_id'                          => $postData['listing_id'],
                $postData['field_name']                 => $fileName,
                $postData['field_name'].'_upload'       => date('Y-m-d H:i:s')
            ];
            //pr($fields);
            $this->common_model->save_data('ecoex_temp_posting', $fields, '', 'id');
        }
        /* check all document uploaded or not */
        $conditions3    = [
            'recycler_id'   => $postData['user_id'],
            'c_id'          => $postData['c_id'],
            'inventory_id'  => $postData['listing_id'],
        ];
        $uploadedDocumentFinal = $this->common_model->find_data('ecoex_temp_posting', 'row', $conditions3);
        if($uploadedDocumentFinal){
            $aadhar         = (($uploadedDocument->aadhar_file!='')?1:0);
            $votar          = (($uploadedDocument->votar_file!='')?1:0);
            $pan            = (($uploadedDocument->pan_file!='')?1:0);
            $document       = (($uploadedDocument->document_file!='')?1:0);
        } else {
            $aadhar     = FALSE;
            $votar      = FALSE;
            $pan        = FALSE;
            $document   = FALSE;
        }
        // echo $aadhar.'<br>';
        // echo $votar.'<br>';
        // echo $pan.'<br>';
        // echo $document.'<br>';
        // die;
        if($aadhar == 1 && $votar == 1 && $pan == 1 && $document == 1){
            $uploadStatus = 1;            
        } else {
            $uploadStatus = 0;
        }
        //echo $uploadStatus;die;
        $this->common_model->save_data('ecoex_temp_posting', ['published' => $uploadStatus], $uploadedDocument->id, 'id');
        /* check all document uploaded or not */        
        $apiResponse['uploaded_document']   = $uploadedDocumentFinal;
        $apiResponse['uploadStatus']        = $uploadStatus;
        $apiStatus                          = TRUE;
        $apiMessage                         = 'Document Uploaded Successfully !!!';
        $this->response_to_json($apiStatus ,$apiMessage, $apiResponse);
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
        $userId = $session->get('userId');
        if($userId){
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


                            $sql = "SELECT * FROM ".$parentTable." as a INNER JOIN ".$childTable." as b ON b.".$childField."=a.".$parentField." WHERE a.visibility=0 AND a.categoryId = '$accessList->maincat' AND a.sucCatId = '$accessList->subcat' ".$whereConditions;
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
                                $listingData[]            = [
                                    'listing_from'  => $inventorySource,
                                    'listing_type'  => $row->inventory_type,
                                    'category'      => $category->name,
                                    'subcategory'   => $subcategory->name,
                                    'product'       => $product->name,
                                    'item'          => $item->name,
                                    'state'         => $state->state_title,
                                    'rate'          => $rateValue,
                                    'qty'           => $row->req_qty,
                                    'unit'          => $unit->name,
                                    'month'         => $this->common_model->monthName($row->month),
                                    'year'          => $row->year,
                                    'image'         => $imageLink
                                ];
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
                $sql = "SELECT * FROM ecoex_target as a INNER JOIN ecoex_target_by_state as b ON b.target_id=a.target_id WHERE a.visibility=0 ".$whereConditions;
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
                            'listing_from'  => 'Brand',
                            'listing_type'  => $row->inventory_type,
                            'category'      => $category->name,
                            'subcategory'   => $subcategory->name,
                            'product'       => $product->name,
                            'item'          => $item->name,
                            'state'         => $state->state_title,
                            'rate'          => 0,
                            'qty'           => $row->req_qty,
                            'unit'          => $unit->name,
                            'month'         => $this->common_model->monthName($row->month),
                            'year'          => $row->year,
                            'image'         => base_url('/public/assets/No_Image_Available.jpg'),
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
                $sql = "SELECT * FROM ecoex_inventory as a INNER JOIN ecoex_inventory_by_state as b ON b.inventory_id=a.inventory_id WHERE a.visibility=0 ".$whereConditions;
                $recyclerData          = $this->db->query($sql)->getResult();
                if($recyclerData){
                    foreach($recyclerData as $row){
                        $state          = $this->common_model->find_data('ecoex_state', 'row', ['state_id' => $row->state_id], 'state_title');
                        $unit           = $this->common_model->find_data('ecoex_unit', 'row', ['id' => $row->unit], 'name');
                        $category       = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->categoryId], 'name');
                        $subcategory    = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->sucCatId], 'name');
                        $product        = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->productId], 'name');
                        $item           = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->itemId], 'name');
                        $listingData[]            = [
                            'listing_from'  => 'Recycler',
                            'listing_type'  => $row->inventory_type,
                            'category'      => $category->name,
                            'subcategory'   => $subcategory->name,
                            'product'       => $product->name,
                            'item'          => $item->name,
                            'state'         => $state->state_title,
                            'rate'          => $row->rate,
                            'qty'           => $row->req_qty,
                            'unit'          => $unit->name,
                            'month'         => $this->common_model->monthName($row->month),
                            'year'          => $row->year,
                            'image'         => (($row->attachment!='')?base_url('/writable/uploads/'.$row->attachment):base_url('/public/assets/No_Image_Available.jpg')),
                        ];
                    }
                }
            /* from recycler panel */
            /* from collector panel */
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
                $sql = "SELECT * FROM ecoex_collecter_inventory as a INNER JOIN ecoex_collecter_inventory_by_state as b ON b.inventory_id=a.inventory_id WHERE a.visibility=0 ".$whereConditions;
                $collectorData          = $this->db->query($sql)->getResult();
                if($collectorData){
                    foreach($collectorData as $row){
                        $state          = $this->common_model->find_data('ecoex_state', 'row', ['state_id' => $row->state_id], 'state_title');
                        $unit           = $this->common_model->find_data('ecoex_unit', 'row', ['id' => $row->unit], 'name');
                        $category       = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->categoryId], 'name');
                        $subcategory    = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->sucCatId], 'name');
                        $product        = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->productId], 'name');
                        $item           = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->itemId], 'name');
                        $listingData[]            = [
                            'listing_from'  => 'Collector',
                            'listing_type'  => $row->inventory_type,
                            'category'      => $category->name,
                            'subcategory'   => $subcategory->name,
                            'product'       => $product->name,
                            'item'          => $item->name,
                            'state'         => $state->state_title,
                            'rate'          => $row->rate,
                            'qty'           => $row->req_qty,
                            'unit'          => $unit->name,
                            'month'         => $this->common_model->monthName($row->month),
                            'year'          => $row->year,
                            'image'         => (($row->attachment!='')?base_url('/writable/uploads/'.$row->attachment):base_url('/public/assets/No_Image_Available.jpg')),
                        ];
                    }
                }
            /* from collector panel */
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
}
