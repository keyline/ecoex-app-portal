<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\AdminAuth;
use App\Models\CommonModel;
use App\Models\Company;
class ReportController extends BaseController
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
    public function memberTypeWiseReport()
    {
        $this->common_model     = new CommonModel();
        $this->session          = \Config\Services::session($config);
        $data['session']        = $this->session;
        $data['common_model']   = $this->common_model;
        $userId                 = $this->session->get('userId');
        if(isset($userId)){
            $data['member_category']    = $this->common_model->find_data('ecoex_member_category', 'array');
            $data['states']             = $this->common_model->find_data('ecoex_state', 'array', ['published' => 1]);
            $data['items']              = $this->common_model->find_data('ecoex_business_category', 'array', ['parent' => 0]);
            if($this->request->getGet()){
                $member_type_id = encoded($this->request->getGet('member_type_id'));
                $state          = encoded($this->request->getGet('state'));
                $item_id        = encoded($this->request->getGet('item_id'));
                $redirecturl = base_url('admin/memberTypeWiseReportView/'.$member_type_id.'/'.$state.'/'.$item_id);
                return redirect()->to($redirecturl);
            }
            return view('admin/layout/reports/memberTypeWiseReport',$data);
        } else {
            return redirect()->to(base_url('admin/login'));
        }
    }
    public function memberTypeWiseReportView($member_type_id, $state, $item_id){
        $this->common_model     = new CommonModel();
        $member_type_id         = decoded($member_type_id);
        $state                  = decoded($state);
        $item_id                = decoded($item_id);
        $response               = [];
        $data['common_model']   = $this->common_model;
        if($member_type_id==1){
            $parentTable = 'ecoex_target';
            $parentField = 'target_id';
            $childTable = 'ecoex_target_by_state';
            $childField = 'target_id';
        } else {
            $parentTable = 'ecoex_inventory';
            $parentField = 'inventory_id';
            $childTable = 'ecoex_inventory_by_state';
            $childField = 'inventory_id';
        }

        $join[0]                = ['table' => $childTable, 'field' => $childField, 'table_master' => $parentTable, 'field_table_master' => $parentField, 'type' => 'INNER'];
        $join[1]                = ['table' => 'ecoex_user_table', 'field' => 'c_id', 'table_master' => $parentTable, 'field_table_master' => 'c_id', 'type' => 'INNER'];
        $join[2]                = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => $parentTable, 'field_table_master' => 'c_id', 'type' => 'INNER'];
        $condition              = ['ecoex_user_table.user_membership_type' => $member_type_id, $parentTable.'.categoryId' => $item_id, $childTable.'.state_id' => $state];
        //$select                 = 'ecoex_target.*,ecoex_company.c_name,ecoex_user_table.user_name,ecoex_user_table.user_email,ecoex_user_table.user_mobile,ecoex_user_table.user_membership_type,ecoex_unit.name AS unit_name';
        $orderBy[0]             = ['field' => $childTable.'.id', 'type' => 'DESC'];
        $rows                   = $this->common_model->find_data($parentTable, 'array', $condition, '', $join, '', $orderBy);
        //$this->db = \Config\Database::connect();
        //echo $this->db->getLastQuery();die;
        if($rows){
            foreach($rows as $row){
                $category      = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->categoryId], 'name');
                $subcategory   = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->sucCatId], 'name');
                $product       = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->productId], 'name');
                $item          = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $row->itemId], 'name');
                $state         = $this->common_model->find_data('ecoex_state', 'row', ['state_id' => $row->state_id], 'state_title');
                $unit          = $this->common_model->find_data('ecoex_unit', 'row', ['id' => $row->unit], 'name');

                $join2[0] = ['table' => 'ecoex_business_category', 'field' => 'id', 'table_master' => 'ecoex_unit_material_detail', 'field_table_master' => 'typeOfMaterial', 'type' => 'INNER'];
                $unitMaterials = $this->common_model->find_data('ecoex_unit_material_detail', 'array', ['ecoex_unit_material_detail.c_id' => $row->c_id], 'ecoex_unit_material_detail.*,ecoex_business_category.name', $join2);
                $response[] = [
                    'c_name'            => $row->c_name,
                    'user_name'         => $row->user_name,
                    'user_email'        => $row->user_email,
                    'user_mobile'       => $row->user_mobile,
                    'category'          => (($category)?$category->name:''),
                    'subcategory'       => (($subcategory)?$subcategory->name:''),
                    'product'           => (($product)?$product->name:''),
                    'item'              => (($item)?$item->name:''),
                    'type'              => $row->inventory_type,
                    'month'             => $this->common_model->monthName($row->month),
                    'year'              => $row->year,
                    'post_status'       => $row->published,
                    'unitMaterials'     => $unitMaterials,
                ];
            }
        }
        //pr($response);
        $data['response'] = $response;
        return view('admin/layout/reports/memberTypeWiseReportView',$data);
    }
	public function transactionReport()
    {
        $this->common_model     = new CommonModel();
        $this->session          = \Config\Services::session($config);
        $data['session']        = $this->session;
        $data['common_model']   = $this->common_model;
        $userId                 = $this->session->get('userId');
        if(isset($userId)){
            $data['member_category']    = $this->common_model->find_data('ecoex_member_category', 'array');
            $data['states']             = $this->common_model->find_data('ecoex_state', 'array', ['published' => 1]);
            $data['items']              = $this->common_model->find_data('ecoex_business_category', 'array', ['parent' => 0]);
            if($this->request->getGet()){
                $fdate          = encoded($this->request->getGet('fdate'));
                $tdate          = encoded($this->request->getGet('tdate'));
                $redirecturl    = base_url('admin/transactionReportView/'.$fdate.'/'.$tdate);
                return redirect()->to($redirecturl);
            }
            return view('admin/layout/reports/transactionReport',$data);
        } else {
            return redirect()->to(base_url('admin/login'));
        }
    }
    public function transactionReportView($fdate, $tdate){
        $this->common_model     = new CommonModel();
        $fdate                  = date_format(date_create(decoded($fdate)), "Y-m-d");
        $tdate                  = date_format(date_create(decoded($tdate)), "Y-m-d");
        $tdate                  = date('Y-m-d', strtotime("+1 day", strtotime($tdate)));        
        $response               = [];
        $data['common_model']   = $this->common_model;
        $orderBy[0]             = ['field' => 'id', 'type' => 'DESC'];
        $inquiries              = $this->common_model->find_data('ecoex_business_inquiries', 'array', ['created_at>=' => $fdate, 'created_at<=' => $tdate], '', '', '', $orderBy);
        $data['fdate']          = $fdate;
        $data['tdate']          = $tdate;
        if($inquiries){
            foreach($inquiries as $inquiry){
                $join[0]            = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                $conditions        = ['ecoex_user_table.user_id' => $inquiry->buyer_id];
                $buyer             = $this->common_model->find_data('ecoex_user_table', 'row', $conditions, 'ecoex_user_table.*,ecoex_company.c_name', $join);

                $join[0]            = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                $conditions        = ['ecoex_user_table.user_id' => $inquiry->seller_id];
                $seller            = $this->common_model->find_data('ecoex_user_table', 'row', $conditions, 'ecoex_user_table.*,ecoex_company.c_name', $join);

                /* inventory */
                    if($inquiry->seller_type == 'Brand'){
                        $parentTable = 'ecoex_target';
                        $parentField = 'target_id';
                        $childTable = 'ecoex_target_by_state';
                        $childField = 'target_id';
                    } else {
                        $parentTable = 'ecoex_inventory';
                        $parentField = 'inventory_id';
                        $childTable = 'ecoex_inventory_by_state';
                        $childField = 'inventory_id';
                    }

                    $join[0]                = ['table' => $childTable, 'field' => $childField, 'table_master' => $parentTable, 'field_table_master' => $parentField, 'type' => 'INNER'];
                    $condition              = [$childTable.'.id' => $inquiry->inventory_details_id];
                    $inventory              = $this->common_model->find_data($parentTable, 'row', $condition, '', $join);
                /* inventory */
                $category       = [];
                $subcategory    = [];
                $product        = [];
                $item           = [];
                $state          = [];
                $unit           = [];
                if($inventory){
                    $category      = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $inventory->categoryId], 'name');
                    $subcategory   = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $inventory->sucCatId], 'name');
                    $product       = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $inventory->productId], 'name');
                    $item          = $this->common_model->find_data('ecoex_business_category', 'row', ['id' => $inventory->itemId], 'name');
                    $state         = $this->common_model->find_data('ecoex_state', 'row', ['state_id' => $inventory->state_id], 'state_title');
                    $unit          = $this->common_model->find_data('ecoex_unit', 'row', ['id' => $inventory->unit], 'name');
                }
                

                $response[] = [
                    'inquiry_no'            => $inquiry->inquiry_no,
                    'buyer_type'            => $inquiry->buyer_type,
                    'buyer_company'         => (($buyer)?$buyer->c_name:''),
                    'buyer_name'            => (($buyer)?$buyer->user_name:''),
                    'buyer_email'           => (($buyer)?$buyer->user_email:''),
                    'buyer_phone'           => (($buyer)?$buyer->user_mobile:''),
                    'seller_type'           => $inquiry->seller_type,
                    'seller_company'        => (($seller)?$seller->c_name:''),
                    'seller_name'           => (($seller)?$seller->user_name:''),
                    'seller_email'          => (($seller)?$seller->user_email:''),
                    'seller_phone'          => (($seller)?$seller->user_mobile:''),
                    'inquiry_type'          => (($inventory)?$inventory->inventory_type:''),
                    'category'              => (($category)?$category->name:''),
                    'subcategory'           => (($subcategory)?$subcategory->name:''),
                    'product'               => (($product)?$product->name:''),
                    'item'                  => (($item)?$item->name:''),
                    'month'                 => $this->common_model->monthName((($inventory)?$inventory->month:'')),
                    'year'                  => (($inventory)?$inventory->year:''),
                    'post_status'           => (($inquiry)?$inquiry->published:0),
                    'state'                 => (($state)?$state->state_title:''),
                    'required_qty'          => (($inquiry)?$inquiry->require_qty:''),
                    'unit'                  => (($unit)?$unit->name:''),
                    'inquiry_date'          => (($inquiry)?$inquiry->created_at:''),
                ];
            }
        }
        //pr($response);
        $data['response'] = $response;
        return view('admin/layout/reports/transactionReportView',$data);
    }
}