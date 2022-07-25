<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\AdminAuth;
use App\Models\CommonModel;
use App\Models\Company;
class PostController extends BaseController
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
    public function unapprovedPost()
    {
        $this->common_model     = new CommonModel();
        $this->session          = \Config\Services::session($config);
        $data['session']        = $this->session;
        $data['common_model']   = $this->common_model;
        $userId                 = $this->session->get('userId');
        if(isset($userId)){
            $data['member_category']    = $this->common_model->find_data('ecoex_member_category', 'array', ['member_id>'=>1]);
            // brand data
                $join[0]                = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_target', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                $join[1]                = ['table' => 'ecoex_user_table', 'field' => 'c_id', 'table_master' => 'ecoex_target', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                $join[2]                = ['table' => 'ecoex_unit', 'field' => 'id', 'table_master' => 'ecoex_target', 'field_table_master' => 'unit', 'type' => 'INNER'];
                $condition              = ['ecoex_target.published' => 0, 'ecoex_user_table.user_membership_type' => 1];
                $select                 = 'ecoex_target.*,ecoex_company.c_name,ecoex_user_table.user_name,ecoex_user_table.user_email,ecoex_user_table.user_mobile,ecoex_user_table.user_membership_type,ecoex_unit.name AS unit_name';
                $orderBy1[0]             = ['field' => 'ecoex_target.target_id', 'type' => 'DESC'];
                $data['userData1']      = $this->common_model->find_data('ecoex_target', 'array', $condition, $select, $join, '', $orderBy);
            // brand data
            // other user data                
                if($data['member_category']){
                    foreach($data['member_category'] as $memberCat){
                        $join[0]                = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_inventory', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                        $join[1]                = ['table' => 'ecoex_user_table', 'field' => 'c_id', 'table_master' => 'ecoex_inventory', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                        $join[2]                = ['table' => 'ecoex_unit', 'field' => 'id', 'table_master' => 'ecoex_inventory', 'field_table_master' => 'unit', 'type' => 'INNER'];
                        $condition              = ['ecoex_inventory.published' => 0, 'ecoex_user_table.user_membership_type' => $memberCat->member_id];
                        $select                 = 'ecoex_inventory.*,ecoex_company.c_name,ecoex_user_table.user_name,ecoex_user_table.user_email,ecoex_user_table.user_mobile,ecoex_user_table.user_membership_type,ecoex_unit.name AS unit_name';
                        $orderBy[0]             = ['field' => 'ecoex_inventory.inventory_id', 'type' => 'DESC'];
                        $data['userData'][$memberCat->member_id]      = $this->common_model->find_data('ecoex_inventory', 'array', $condition, $select, $join, '', $orderBy);
                    }
                }
            // other user data            
            //pr($data);
            return view('admin/layout/unapprovedPost',$data);
        } else {
            return redirect()->to(base_url('admin/login'));
        }
    }
	public function currentPost()
	{
        $this->common_model     = new CommonModel();
        $this->session          = \Config\Services::session($config);
        $data['session']        = $this->session;
        $data['common_model']   = $this->common_model;
        $userId                 = $this->session->get('userId');
        if(isset($userId)){
            $data['member_category']    = $this->common_model->find_data('ecoex_member_category', 'array', ['member_id>'=>1]);
            // brand data
                $join[0]                = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_target', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                $join[1]                = ['table' => 'ecoex_user_table', 'field' => 'c_id', 'table_master' => 'ecoex_target', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                $join[2]                = ['table' => 'ecoex_unit', 'field' => 'id', 'table_master' => 'ecoex_target', 'field_table_master' => 'unit', 'type' => 'INNER'];
                $condition              = ['ecoex_target.published' => 1, 'ecoex_user_table.user_membership_type' => 1];
                $select                 = 'ecoex_target.*,ecoex_company.c_name,ecoex_user_table.user_name,ecoex_user_table.user_email,ecoex_user_table.user_mobile,ecoex_user_table.user_membership_type,ecoex_unit.name AS unit_name';
                $orderBy1[0]             = ['field' => 'ecoex_target.target_id', 'type' => 'DESC'];
                $data['userData1']      = $this->common_model->find_data('ecoex_target', 'array', $condition, $select, $join, '', $orderBy1);
            // brand data
            // other user data                
                if($data['member_category']){
                    foreach($data['member_category'] as $memberCat){
                        $join[0]                = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_inventory', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                        $join[1]                = ['table' => 'ecoex_user_table', 'field' => 'c_id', 'table_master' => 'ecoex_inventory', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                        $join[2]                = ['table' => 'ecoex_unit', 'field' => 'id', 'table_master' => 'ecoex_inventory', 'field_table_master' => 'unit', 'type' => 'INNER'];
                        $condition              = ['ecoex_inventory.published' => 1, 'ecoex_user_table.user_membership_type' => $memberCat->member_id];
                        $select                 = 'ecoex_inventory.*,ecoex_company.c_name,ecoex_user_table.user_name,ecoex_user_table.user_email,ecoex_user_table.user_mobile,ecoex_user_table.user_membership_type,ecoex_unit.name AS unit_name';
                        $orderBy[0]             = ['field' => 'ecoex_inventory.inventory_id', 'type' => 'DESC'];
                        $data['userData'][$memberCat->member_id]      = $this->common_model->find_data('ecoex_inventory', 'array', $condition, $select, $join, '', $orderBy);
                    }
                }
            // other user data            
            //pr($data);
            return view('admin/layout/currentPost',$data);
        } else {
            return redirect()->to(base_url('admin/login'));
        }
	}
    public function expiredPost()
    {
        $this->common_model     = new CommonModel();
        $this->session          = \Config\Services::session($config);
        $data['session']        = $this->session;
        $data['common_model']   = $this->common_model;
        $userId                 = $this->session->get('userId');
        if(isset($userId)){
            $data['member_category']    = $this->common_model->find_data('ecoex_member_category', 'array', ['member_id>'=>1]);
            // brand data
                $join[0]                = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_target', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                $join[1]                = ['table' => 'ecoex_user_table', 'field' => 'c_id', 'table_master' => 'ecoex_target', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                $join[2]                = ['table' => 'ecoex_unit', 'field' => 'id', 'table_master' => 'ecoex_target', 'field_table_master' => 'unit', 'type' => 'INNER'];
                $condition              = ['ecoex_target.published' => 3, 'ecoex_user_table.user_membership_type' => 1];
                $select                 = 'ecoex_target.*,ecoex_company.c_name,ecoex_user_table.user_name,ecoex_user_table.user_email,ecoex_user_table.user_mobile,ecoex_user_table.user_membership_type,ecoex_unit.name AS unit_name';
                $orderBy1[0]             = ['field' => 'ecoex_target.target_id', 'type' => 'DESC'];
                $data['userData1']      = $this->common_model->find_data('ecoex_target', 'array', $condition, $select, $join, '', $orderBy);
            // brand data
            // other user data                
                if($data['member_category']){
                    foreach($data['member_category'] as $memberCat){
                        $join[0]                = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_inventory', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                        $join[1]                = ['table' => 'ecoex_user_table', 'field' => 'c_id', 'table_master' => 'ecoex_inventory', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                        $join[2]                = ['table' => 'ecoex_unit', 'field' => 'id', 'table_master' => 'ecoex_inventory', 'field_table_master' => 'unit', 'type' => 'INNER'];
                        $condition              = ['ecoex_inventory.published' => 3, 'ecoex_user_table.user_membership_type' => $memberCat->member_id];
                        $select                 = 'ecoex_inventory.*,ecoex_company.c_name,ecoex_user_table.user_name,ecoex_user_table.user_email,ecoex_user_table.user_mobile,ecoex_user_table.user_membership_type,ecoex_unit.name AS unit_name';
                        $orderBy[0]             = ['field' => 'ecoex_inventory.inventory_id', 'type' => 'DESC'];
                        $data['userData'][$memberCat->member_id]      = $this->common_model->find_data('ecoex_inventory', 'array', $condition, $select, $join, '', $orderBy);
                    }
                }
            // other user data            
            //pr($data);
            return view('admin/layout/expiredPost',$data);
        } else {
            return redirect()->to(base_url('admin/login'));
        }
    }
    public function postViewDetails($listingId,$memberTypeId)
    {
        $this->common_model     = new CommonModel();
        $this->session          = \Config\Services::session($config);
        $data['session']        = $this->session;
        $data['common_model']   = $this->common_model;
        $userId                 = $this->session->get('userId');
        $listingId              = decoded($listingId);
        $memberTypeId           = decoded($memberTypeId);
        if(isset($userId)){
            if($memberTypeId<=1){
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
            $join[0]                = ['table' => $childTable, 'field' => 'id', 'table_master' => 'post_view', 'field_table_master' => 'post_id', 'type' => 'INNER'];
            $condition              = ['post_view.post_id' => $listingId];
            $orderBy[0]             = ['field' => 'post_view.id', 'type' => 'DESC'];
            $data['post_view_list']    = $this->common_model->find_data('post_view', 'array', $condition, '', $join, '', $orderBy);
            //$this->db = \Config\Database::connect();
            //echo $this->db->getLastQuery();die;
            //pr($data['post_view_list']);
            return view('admin/layout/postViewDetails',$data);
        } else {
            return redirect()->to(base_url('admin/login'));
        }
    }
    public function postApprove($listingId,$memberTypeId){
        $listingId = decoded($listingId);
        $memberTypeId = decoded($memberTypeId);
        if($memberTypeId<=1){
            $tableName = 'ecoex_target';
            $fieldName = 'target_id';
        } else {
            $tableName = 'ecoex_inventory';
            $fieldName = 'inventory_id';
        }
        $this->common_model     = new CommonModel();
        $this->session          = \Config\Services::session($config);
        $data['session']        = $this->session;
        $data['common_model']   = $this->common_model;
        $this->common_model->save_data($tableName, ['published' => 1], $listingId, $fieldName);

        /* inventory */
            if($memberTypeId<=1){
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
            $conditions               = [$parentTable.'.'.$fieldName => $listingId];
            $inventory                = $this->common_model->find_data($parentTable, 'array', $conditions, '', $join2);
            // $db = \Config\Database::connect();
            // echo $db->getLastQuery();
            // pr($inventory);
            // die;
        /* inventory */
        /* send email */
            $fields['site_setting'] = $this->common_model->find_data('ecoex_setting', 'row');
            $fields['common_model'] = $this->common_model;
            $fields['inventory']    = $inventory;
            $fields['header_msg']   = "Inventory Post Has Been Successfully Marked As Approved By Admin !!!";
            $html                   = view('email-template/admin-post-status-change',$fields);
            $subject                = 'Inventory Post Approved By Admin:: '.$fields['site_setting']->websiteName;
            $seller_id              = $inventory[0]->c_id;
            $join[0]                = ['table' => 'ecoex_member_category', 'field' => 'member_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'user_membership_type', 'type' => 'INNER'];
            $conditions             = ['ecoex_user_table.user_id' => $seller_id];
            $seller                 = $this->common_model->find_data('ecoex_user_table', 'row', $conditions, 'ecoex_user_table.*,ecoex_member_category.member_type', $join);
            $this->common_model->sendEmail((($seller)?$seller->user_email:''),$subject,$html);
        /* send email */
        $this->session->setFlashdata('success_message', 'Post Has Been Marked As Approved !!! Go To Approve Post To Check The Post !!!');
        return redirect()->to(base_url('admin/unapprovedPost'));
    }
    public function postExpire($listingId,$memberTypeId){
        $listingId = decoded($listingId);
        $memberTypeId = decoded($memberTypeId);
        if($memberTypeId<=1){
            $tableName = 'ecoex_target';
            $fieldName = 'target_id';
        } else {
            $tableName = 'ecoex_inventory';
            $fieldName = 'inventory_id';
        }
        $this->common_model     = new CommonModel();
        $this->session          = \Config\Services::session($config);
        $data['session']        = $this->session;
        $data['common_model']   = $this->common_model;
        $this->common_model->save_data($tableName, ['published' => 3], $listingId, $fieldName);

        /* inventory */
            if($memberTypeId<=1){
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
            $conditions               = [$parentTable.'.'.$fieldName => $listingId];
            $inventory                = $this->common_model->find_data($parentTable, 'array', $conditions, '', $join2);
            // $db = \Config\Database::connect();
            // echo $db->getLastQuery();
            // pr($inventory);
            // die;
        /* inventory */
        /* send email */
            $fields['site_setting'] = $this->common_model->find_data('ecoex_setting', 'row');
            $fields['common_model'] = $this->common_model;
            $fields['inventory']    = $inventory;
            $fields['header_msg']   = "Inventory Post Has Been Successfully Marked As Expired By Admin !!!";
            $html                   = view('email-template/admin-post-status-change',$fields);
            $subject                = 'Inventory Post Expired By Admin :: '.$fields['site_setting']->websiteName;
            $seller_id              = $inventory[0]->c_id;
            $join[0]                = ['table' => 'ecoex_member_category', 'field' => 'member_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'user_membership_type', 'type' => 'INNER'];
            $conditions             = ['ecoex_user_table.user_id' => $seller_id];
            $seller                 = $this->common_model->find_data('ecoex_user_table', 'row', $conditions, 'ecoex_user_table.*,ecoex_member_category.member_type', $join);
            $this->common_model->sendEmail((($seller)?$seller->user_email:''),$subject,$html);
        /* send email */

        $this->session->setFlashdata('success_message', 'Post Has Been Marked As Expired !!! Go To Expired Post To Check The Post !!!');
        return redirect()->to(base_url('admin/currentPost'));
    }
    public function postDetails($listingId,$memberTypeId){
        $listingId = decoded($listingId);
        $memberTypeId = decoded($memberTypeId);
        if($memberTypeId<=1){
            $tableName = 'ecoex_target';
            $fieldName = 'target_id';
        } else {
            $tableName = 'ecoex_inventory';
            $fieldName = 'inventory_id';
        }
        $this->common_model     = new CommonModel();
        $this->session          = \Config\Services::session($config);
        $data['session']        = $this->session;
        $data['common_model']   = $this->common_model;

        /* inventory */
            if($memberTypeId<=1){
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
            $data['memberTypeId']     = $memberTypeId;
            $join2[0]                 = ['table' => $childTable, 'field' => $childField, 'table_master' => $parentTable, 'field_table_master' => $parentField, 'type' => 'INNER'];
            $conditions               = [$parentTable.'.'.$fieldName => $listingId];
            $data['inventory']                = $this->common_model->find_data($parentTable, 'array', $conditions, '', $join2);

            $seller_id              = $data['inventory'] [0]->c_id;
            $join[0]                = ['table' => 'ecoex_member_category', 'field' => 'member_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'user_membership_type', 'type' => 'INNER'];
            $join[1]                = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'c_id', 'type' => 'INNER'];
            $conditions             = ['ecoex_user_table.user_id' => $seller_id];
            $data['seller']         = $this->common_model->find_data('ecoex_user_table', 'row', $conditions, 'ecoex_user_table.*,ecoex_member_category.member_type,ecoex_company.c_name', $join);
        /* inventory */
        //pr($data['inventory']);
        return view('admin/layout/postDetails',$data);
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
}