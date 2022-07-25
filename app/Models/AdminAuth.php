<?php namespace App\Models;

use CodeIgniter\Model;

class AdminAuth extends Model{

    public function getAdminDetails($data){
        $query = "SELECT * FROM ecoex_admin_user WHERE `username` = '".$data['username']."' && `password` = '".md5($data['password'])."' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    
    public function getTotalBrand(){
        $query = "SELECT count(*) as totalBrand FROM ecoex_user_table WHERE `user_membership_type` = '1' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getTotalRecycle(){
        $query = "SELECT count(*) as totalRecycler FROM ecoex_user_table WHERE `user_membership_type` = '2' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    
    public function getTotalBusinessCategory(){
        $query = "SELECT * FROM ecoex_business_category ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    
    public function getEmailLogs(){
        $query = "SELECT * FROM ecoex_email_log ORDER BY `id` DESC ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getTotalMemberCategory(){
        $query = "SELECT * FROM ecoex_member_category ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getCategoryParent($id){
        $query = "SELECT * FROM ecoex_business_category WHERE `id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getTotalChild($id){
        $query = "SELECT count(`id`) as `totalChild` FROM ecoex_business_category WHERE `parent` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getBusinessParentCategory(){
        $query = "SELECT * FROM ecoex_business_category WHERE `parent` = '0' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getBusinessCategoryByParentId($parent){
        $query = "SELECT * FROM ecoex_business_category WHERE `parent` = '".$parent."' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function addBusinessCategory($data){
        $query = "INSERT INTO `ecoex_business_category` VALUES(null,'".$data['name']."','".$data['category']."',now(),now()) ";
        $this->db->query($query);
        return true;
    }
    public function editBusinessCategory($data){
        $query = "UPDATE `ecoex_business_category` SET `name` = '".$data['name']."',`parent` = '".$data['category']."',
        `updated_at` = now() WHERE `id` = '".$data['id']."' ";
        $this->db->query($query);
        return true;
    }
    public function addMemberCategory($data){
        $query = "INSERT INTO `ecoex_member_category` VALUES(null,'".$data['name']."',now(),now()) ";
        $this->db->query($query);
        return true;
    }
    public function updateMemberCategory($data){
        $query = "UPDATE `ecoex_member_category` SET `member_type` = '".$data['member_type']."' WHERE `member_id` = '".$data['member_id']."' ";
        $this->db->query($query);        
        return true;
    }
    public function deleteMemberCategory($id){
        $query = "DELETE FROM `ecoex_member_category` WHERE `member_id` = '".$id."' ";
        $this->db->query($query);
        return true;
    }
    public function deleteBusinessCategory($id){
        $query = "DELETE FROM `ecoex_business_category` WHERE `id` = '".$id."' ";
        $this->db->query($query);
        return true;
    }
    public function getmemberList(){
        $query = "SELECT * FROM ecoex_user_table WHERE `userStatus` = '2' ORDER BY `user_id` DESC";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getPendingMemberList(){
        $query = "SELECT * FROM ecoex_company WHERE  `c_status` = '1' ORDER BY `c_id` DESC";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getApprovedMemberList(){
        $query = "SELECT * FROM ecoex_company WHERE  `c_status` = '2' ORDER BY `c_id` DESC";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getApprovedMemberListByType($id){
        $query = "SELECT * FROM ecoex_company AS a INNER JOIN ecoex_user_table AS b ON b.c_id = a.c_id WHERE  a.`c_status` = '2' AND b.user_membership_type = '$id' ORDER BY b.`user_id` DESC";
        //echo $query;die;
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getTotalPendingRequest(){
        $query = "SELECT count(*) as totalPendingRequest FROM ecoex_company WHERE  `c_status` = '1' ORDER BY `c_id` DESC";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getTotalApprovedRequest(){
        $query = "SELECT count(*) as totalApprovedRequest FROM ecoex_company WHERE  `c_status` = '2' ORDER BY `c_id` DESC";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getCompanyName($id){
        $query = "SELECT * FROM ecoex_company WHERE `c_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getMemberType($id){
        $query = "SELECT * FROM ecoex_member_category WHERE `member_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getCompanyType($id){
        $query = "SELECT `name` FROM ecoex_company_type WHERE `id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getmemberDetailData($id){
        $query = "SELECT * FROM ecoex_user_table WHERE `user_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getmemberDetailByCID($id){
        $query = "SELECT * FROM ecoex_user_table WHERE `c_id` = '".$id."' && `user_role_type` = '0' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getCompanyDetailData($id){
        $query = "SELECT * FROM ecoex_user_table WHERE `c_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getCompanyDetailById($id){
        $query = "SELECT * FROM ecoex_company_details WHERE `c_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    
    public function getCatNameById($id){
        $query = "SELECT * FROM ecoex_business_category WHERE `id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getAdminMemberDetailData($id){
        $query = "SELECT * FROM ecoex_setting WHERE `id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getCompanyAddressData($id){
        $query = "SELECT * FROM ecoex_company_address WHERE `c_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function editSettingData($data){
        $query = "UPDATE `ecoex_setting` SET `websiteName` = '".$data['websiteName']."',`keywords` = '".$data['keywords']."',
        `description` = '".$data['description']."',`updatedAt` = now() WHERE `id` = '1' ";
        $this->db->query($query);
        if($data['logo'] != ''){
            $query = "UPDATE `ecoex_setting` SET `logo` = '".$data['logo']."' WHERE `id` = '1' ";
            $this->db->query($query);
        }
        return true;
    }
    public function getCityByCityID($id){
        $query = "SELECT * FROM ecoex_city WHERE `id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getDistByDistID($id){
        $query = "SELECT * FROM ecoex_district WHERE `districtid` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getStateByStateID($id){
        $query = "SELECT * FROM ecoex_state WHERE `state_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getCompanyBankDetailsByID($id){
        $query = "SELECT * FROM ecoex_company_bank_details WHERE `c_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function approveCompanyDataFnct($id,$adminID){
        
        $query = "UPDATE `ecoex_company` SET `c_status` = '2',`c_approved_by` = '".$adminID."',`c_approvedTime` = now() WHERE `c_id` = '".$id."' ";
        $this->db->query($query);
        return true;
    }
    public function addCompanyComment($data){
        $query = "INSERT INTO `ecoex_comment` VALUES(null,'".$data['c_id']."','1','".$data['commentBox']."',now()) ";
        $this->db->query($query);
        
         $query = "UPDATE `ecoex_company` SET `c_lastCommentTime` = now() WHERE `c_id` = '".$data['c_id']."' ";
         $this->db->query($query);
    
        return true;
    }
    public function getCompanyCommentData($id){
        $query = "SELECT * FROM ecoex_comment WHERE `c_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getEmailSetting(){
        $query = "SELECT * FROM ecoex_email_template  ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getEmailDataByID($id){
        $query = "SELECT * FROM ecoex_email_template WHERE `id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function editTemplateData($data){
         $query = "UPDATE `ecoex_email_template` SET `subject` = '".addslashes($data['subject'])."',`content` = '".addslashes($data['content'])."' 
         WHERE `id` = '".$data['emailID']."' ";
         $this->db->query($query);
         return true;
    }
    
    public function getTotalEnquiry(){
        $query = "SELECT * FROM ecoex_target";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getItemByID($id){
        $query = "SELECT * FROM ecoex_business_category WHERE `id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getUnitByID($id){
        $query = "SELECT * FROM ecoex_unit WHERE `id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getAllocateQtyState($id){
        $query = "SELECT SUM(`req_qty`) as allocateQty FROM ecoex_target_by_state WHERE `target_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getCompanyByID($id){
        $query = "SELECT * FROM ecoex_company WHERE `c_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getCompanyUserByID($id){
        $query = "SELECT * FROM ecoex_user_table WHERE `c_id` = '".$id."' ORDER BY `user_id` ASC ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getStateAllocateDataByState($target){
        $query = "SELECT * FROM ecoex_target_by_state WHERE `target_id` = '".$target."' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getStateByID($id){
        $query = "SELECT * FROM ecoex_state WHERE `state_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getInventoryDataByState($stateId,$item,$catVariable){
        $query = "SELECT ecoex_inventory_by_state.* FROM ecoex_inventory_by_state INNER JOIN ecoex_inventory ON ecoex_inventory.inventory_id=ecoex_inventory_by_state.inventory_id &&
        ecoex_inventory_by_state.state_id = '".$stateId."'";
        if($catVariable == 'itemId'){
            $query .= " && ecoex_inventory.itemId = '".$item."'";
        }else if($catVariable == 'sucCatId'){
            $query .= " && ecoex_inventory.sucCatId = '".$item."'";
        }else if($catVariable == 'categoryId'){
            $query .= " && ecoex_inventory.itemId = '".$item."'";
        }
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    
    public function storeCompanyRegStepThree($data){

        $query = "SELECT * FROM ecoex_company_bank_details WHERE `c_id` = '".$data['storeID']."' ";
        $query=$this->db->query($query);
        $storeDetail = $query->getRow();
        if(isset($storeDetail->company_bank_id)){
            $query = "UPDATE `ecoex_company_bank_details` SET `c_account_type` = '".$data['accountType']."',`c_bank_name` = '".$data['bankName']."',`accountNo` = '".$data['accountNo']."',
            `c_branch_name` = '".$data['branchName']."',`c_acct_holder_name` = '".$data['accountHolder']."',`c_micr_code` = '".$data['mtcrCode']."'
            ,`updated_at` = now() WHERE c_id = '".$data['storeID']."' ";
            $this->db->query($query);
        } else {
            $query = "INSERT INTO `ecoex_company_bank_details` VALUES(null,'".$data['storeID']."','".$data['accountType']."','".$data['bankName']."','".$data['accountNo']."',
            '".$data['branchName']."','".$data['accountHolder']."','','".$data['mtcrCode']."',now(),now()) ";
            $this->db->query($query);
        }

        if($data['cancelledCheque'] != ''){
            $query = "UPDATE `ecoex_company_bank_details` SET `c_cancelled_cheque` = '".$data['cancelledCheque']."' WHERE c_id = '".$data['storeID']."' ";
            $this->db->query($query);

        }
        return true;
    }
    
    public function storeCompanyRegStepFour($data){
        $query = "SELECT * FROM ecoex_unit_details WHERE `unit_id` = '".$data['unitID']."' ";
        $query=$this->db->query($query);
        $storeDetail = $query->getRow();
        if(isset($storeDetail->unit_name)){
            $unitID = $storeDetail->unit_id;
            $query = "UPDATE `ecoex_unit_details` SET `unit_name` = '".$data['unit_name']."',`unit_category` = '".$data['unit_category']."',`consent_cert_no` = '".$data['consent_cert_no']."',
            `consent_valid_from` = '".$data['consent_valid_from']."',`consent_valid_upto` = '".$data['consent_valid_upto']."',`consent_document` = '".$data['consent_document']."',
            `pwm_cert_no` = '".$data['pwm_cert_no']."',`pwm_valid_from` = '".$data['pwm_valid_from']."',`pwm_valid_upto` = '".$data['pwm_valid_upto']."',
            `cpcb_cert_no` = '".$data['cpcb_cert_no']."',`cpcb_valid_from` = '".$data['cpcb_valid_from']."',`cpcb_valid_upto` = '".$data['cpcb_valid_upto']."',
            `c_state` = '".$data['state']."',`c_city` = '".$data['city']."',`c_district` = '".$data['district']."',`c_pincode` = '".$data['c_pincode']."'
            ,`c_full_address` = '".$data['c_full_address']."',`updated_at` = now() WHERE `unit_id` = '".$data['unitID']."' ";
            $this->db->query($query);
            $unitID = $data['unitID'];
        } else {
            $query = "INSERT INTO `ecoex_unit_details` VALUES(null,'".$data['storeID']."','".$data['unit_name']."','".$data['unit_category']."','".$data['consent_cert_no']."',
            '".$data['consent_valid_from']."','".$data['consent_valid_upto']."','','".$data['pwm_cert_no']."','".$data['pwm_valid_from']."','".$data['pwm_valid_upto']."'
            ,'','".$data['cpcb_cert_no']."','".$data['cpcb_valid_from']."','".$data['cpcb_valid_upto']."',''
            ,'".$data['state']."','".$data['city']."','".$data['district']."','".$data['c_pincode']."','".$data['c_full_address']."',now(),now()) ";
            $this->db->query($query);
            $unitID = $this->db->insertID();
        }

        if($data['consent_document'] != ''){
            $query = "UPDATE `ecoex_unit_details` SET `consent_document` = '".$data['consent_document']."' WHERE `unit_id` = '".$unitID."' ";
            $this->db->query($query);
        }
        
        if($data['pwm_document'] != ''){
            $query = "UPDATE `ecoex_unit_details` SET `pwm_document` = '".$data['pwm_document']."' WHERE `unit_id` = '".$unitID."' ";
            $this->db->query($query);
        }
        
        if($data['cpcb_document'] != ''){
            $query = "UPDATE `ecoex_unit_details` SET `cpcb_document` = '".$data['cpcb_document']."' WHERE `unit_id` = '".$unitID."' ";
            $this->db->query($query);
        }

        $c_id = $data['storeID'];
        $this->db->query("DELETE FROM `ecoex_unit_material_detail` WHERE `c_id`='$c_id' AND `unit_id`='$unitID'");        
        foreach($data['typeOfMaterial'] as $key=>$material){
            $materialFullName = $data['materialFullName'][$key];
            $monthlyCapicity = $data['monthlyCapicity'][$key];
            $annualCapicity = $data['annualCapicity'][$key];            
            if($materialFullName != '' && $monthlyCapicity != '' && $annualCapicity != ''){                
                $query = "SELECT * FROM ecoex_unit_material_detail WHERE `unit_id` = '".$unitID."' && `typeOfMaterial` =  '".$material."'";
                $query=$this->db->query($query);
                $materialData = $query->getRow();                
                if(isset($materialData->material_id)){                    
                    $query = "UPDATE `ecoex_unit_material_detail` SET `materialFullName` = '".$stateQty."',`monthlyCapicity` = '".$stateLocation."',
                       `annualCapicity` = '".$stateLocation."',`updatedAt` = now() WHERE `material_id` = '".$materialData->id."' ";
                    $this->db->query($query);
                } else {
                    $query = "INSERT INTO `ecoex_unit_material_detail` VALUES(null,'".$data['storeID']."','".$unitID."','".$material."','".$materialFullName."',
                    '".$monthlyCapicity."','".$annualCapicity."') ";
                    $this->db->query($query);
                }
            }            
        }
            
        return $unitID;

    }
    
    public function addUnitPlantImages($data){
            $query = "INSERT INTO `ecoex_unit_details_images` VALUES(null,'".$data['storeID']."','".$data['unitID']."',
            '".$data['file_name']."','".$data['type']."',now()) ";
            $this->db->query($query);
        return true;

    }

    public function getUnitByStoreID($id){
        $query = "SELECT * FROM ecoex_unit_details WHERE `c_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getUnitDetailUnitID($id){
        $query = "SELECT * FROM ecoex_unit_details WHERE `unit_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getUnitMaterialDetailsByUnitID($id){
        $query = "SELECT * FROM ecoex_unit_material_detail WHERE `unit_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getUnitDatasByStoreID($id){
        $query = "SELECT * FROM ecoex_unit_details WHERE `c_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getCategoryUnitTypeById($id){
        $query = "SELECT * FROM ecoex_material_type WHERE `id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    
    
}

?>