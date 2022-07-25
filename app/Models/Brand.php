<?php namespace App\Models;

use CodeIgniter\Model;

class Brand extends Model{

    public function getUserDataByID($id){
        $query = "SELECT * FROM ecoex_user_table WHERE `user_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    
    public function getBusinessMainCategoryList(){
        $query = "SELECT * FROM ecoex_business_category WHERE `parent` = '0' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getBusinessSubCategoryList($id){
        $query = "SELECT * FROM ecoex_business_category WHERE `parent` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getUnitList(){
        $query = "SELECT * FROM ecoex_unit WHERE `status` = '0' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getDocumentList($type){
        $query = "SELECT * FROM ecoex_document_list WHERE `documentType` = '".$type."' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getStateList(){
        $query = "SELECT * FROM ecoex_state ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function addTargetData($data){
       $query = "INSERT INTO `ecoex_target` VALUES(null,'".$data['inventory_type']."','".$data['storeId']."','".$data['category']."','".$data['subCategory']."',
       '".$data['product']."','".$data['item']."',
            '".$data['year']."','".$data['month']."','".$data['qty']."','".$data['unit']."','0','".$data['document_required']."',0,0,now(),now()) ";
        $this->db->query($query);
        return $this->db->insertID();
    }
    public function convertTargetToInquiryData($data){
       $query = "INSERT INTO `ecoex_target_inquiry` VALUES(null,'".$data['storeId']."','".$data['target_id']."','".$data['typeOfSale']."','".$data['inquiryStart']."',
            '".$data['inquiryStartTime']."','".$data['inquiryEnd']."','".$data['inquiryEndTime']."','".$data['accessType']."','".$data['inquiryDescription']."',
            '".$data['attachment']."','".$data['documentRequired']."',now(),now()) ";
        $this->db->query($query);
        
       $query = "UPDATE `ecoex_target` SET `inquiry_status` = '1',`updatedAt` = now() WHERE `target_id` = '".$data['target_id']."' ";
        $this->db->query($query);
                        
        return $this->db->insertID();
    }
    public function addTargetByStateData($data){
        
        foreach($data['stateData'] as $key=>$stateValue){
            
            $stateQty = $data['qty'][$key];
            if($stateValue != '' && $stateQty != '0'){
                
                $query = "SELECT * FROM ecoex_target_by_state WHERE `target_id` = '".$data['targetId']."' && `state_id` =  '".$stateValue."'";
                $query=$this->db->query($query);
                $stateTargetData = $query->getRow();
                
                if(isset($stateTargetData->id)){
                    
                    $query = "SELECT SUM(`req_qty`) as allocateQty FROM ecoex_target_by_district WHERE `target_id` = '".$data['targetId']."'  && `state_id` = '".$stateValue."'";
                    $query=$this->db->query($query);
                    $districtTargetSum = $query->getRow();
        
                    if($stateQty < $districtTargetSum->allocateQty){
                       $query = "DELETE FROM `ecoex_target_by_district` WHERE `target_id` = '".$data['targetId']."'   && `state_id` = '".$stateValue."'";
                       $this->db->query($query);
                       $query = "DELETE FROM `ecoex_target_by_city` WHERE `target_id` = '".$data['targetId']."'   && `state_id` = '".$stateValue."'";
                       $this->db->query($query);
                    }
                    
                       $query = "UPDATE `ecoex_target_by_state` SET `req_qty` = '".$stateQty."',`updatedAt` = now() WHERE `target_id` = '".$data['targetId']."' 
                       && `state_id` = '".$stateValue."'";
                        $this->db->query($query);
                } else {
                    $query = "INSERT INTO `ecoex_target_by_state` VALUES(null,'".$data['storeId']."','".$data['targetId']."','".$stateValue."','".$stateQty."',now(),now()) ";
                    $this->db->query($query);
                }
            }
        }
        return true;
    }
    public function addTargetByDistrictData($data){
        
        foreach($data['districtData'] as $key=>$stateValue){
            
            $stateQty = $data['qty'][$key];
            if($stateValue != '' && $stateQty != '0'){
                $query = "SELECT * FROM ecoex_target_by_district WHERE `target_id` = '".$data['targetId']."' && `distrcit_id` =  '".$stateValue."'";
                $query=$this->db->query($query);
                $stateTargetData = $query->getRow();
                
                if(isset($stateTargetData->id)){
                    
                    $query = "SELECT SUM(`req_qty`) as allocateQty FROM ecoex_target_by_city WHERE `target_id` = '".$data['targetId']."'  && `distrcit_id` = '".$stateValue."'";
                    $query=$this->db->query($query);
                    $districtTargetSum = $query->getRow();
        
                    if($stateQty < $districtTargetSum->allocateQty){
                       $query = "DELETE FROM `ecoex_target_by_city` WHERE `target_id` = '".$data['targetId']."'   && `distrcit_id` = '".$stateValue."'";
                       $this->db->query($query);
                    }
                    
                       $query = "UPDATE `ecoex_target_by_district` SET `req_qty` = '".$stateQty."',`updatedAt` = now() WHERE `target_id` = '".$data['targetId']."' 
                       && `distrcit_id` = '".$stateValue."'";
                        $this->db->query($query);
                } else {
               $query = "INSERT INTO `ecoex_target_by_district` VALUES(null,'".$data['storeId']."','".$data['targetId']."','".$data['stateId']."',
               '".$stateValue."','".$stateQty."',now(),now()) ";
                $this->db->query($query);
                }
                
            }
        }
        return true;
    }
    public function addTargetByCityData($data){
        
        foreach($data['cityData'] as $key=>$stateValue){
            
            $stateQty = $data['qty'][$key];
            if($stateValue != '' && $stateQty != '0'){
               $query = "INSERT INTO `ecoex_target_by_city` VALUES(null,'".$data['storeId']."','".$data['targetId']."','".$data['stateId']."','".$data['districtId']."',
               '".$stateValue."','".$stateQty."',now(),now()) ";
                $this->db->query($query);
                
            }
        }
        return true;
    }
    
    public function editTargetData($data){
        if($data['removeQty'] == 'true'){
           $query = "DELETE FROM `ecoex_target_by_state` WHERE `target_id` = '".$data['targetID']."' ";
            $this->db->query($query);
           $query = "DELETE FROM `ecoex_target_by_district` WHERE `target_id` = '".$data['targetID']."' ";
            $this->db->query($query);
           $query = "DELETE FROM `ecoex_target_by_city` WHERE `target_id` = '".$data['targetID']."' ";
            $this->db->query($query);
        }
        $query = "UPDATE `ecoex_target` SET `c_id` = '".$data['storeId']."',`inventory_type` = '".$data['inventory_type']."',`categoryId` = '".$data['category']."',`sucCatId` = '".$data['subCategory']."',
       `productId` = '".$data['product']."',`itemId` = '".$data['item']."',`year` = '".$data['year']."',`month` = '".$data['month']."',`qty` = '".$data['qty']."',`unit` = '".$data['unit']."',`document_required` = '".$data['document_required']."',
       `updatedAt` = now() WHERE `target_id` = '".$data['targetID']."' ";
        $this->db->query($query);        
        return true;
    }
    public function getTargetDataByID($id){
        $query = "SELECT * FROM ecoex_target WHERE `target_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
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
    public function getStateByID($id){
        $query = "SELECT * FROM ecoex_state WHERE `state_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getDistrictByID($id){
        $query = "SELECT * FROM ecoex_district WHERE `districtid` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getCityByID($id){
        $query = "SELECT * FROM ecoex_city WHERE `id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getTargetDataByState($id){
        $query = "SELECT * FROM ecoex_target_by_state WHERE `target_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getDistrictByState($id){
        $query = "SELECT * FROM ecoex_district WHERE `state_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getDistrictByDistrict($id){
        $query = "SELECT * FROM ecoex_city WHERE `districtid` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getTargetDataByStateTarget($stateId,$targetId){
        $query = "SELECT * FROM ecoex_target_by_state WHERE `target_id` = '".$targetId."' &&  `state_id` = '".$stateId."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getDataByDistrictTarget($targetId,$stateId){
        $query = "SELECT * FROM ecoex_target_by_district WHERE `target_id` = '".$targetId."' &&  `state_id` = '".$stateId."' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getTargetList($id){
        $query = "SELECT * FROM ecoex_target WHERE `c_id` = '".$id."' ORDER BY `target_id` DESC";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getAllocateQtyState($id){
        $query = "SELECT SUM(`req_qty`) as allocateQty FROM ecoex_target_by_state WHERE `target_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getAllocateQtyDistrict($id,$stateId){
        $query = "SELECT SUM(`req_qty`) as allocateQty FROM ecoex_target_by_district WHERE `target_id` = '".$id."'  && `state_id` = '".$stateId."'";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getStateAllocateDataByState($target){
        $query = "SELECT * FROM ecoex_target_by_state WHERE `target_id` = '".$target."' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getDistAllocateDataByState($target,$stateId){
        $query = "SELECT * FROM ecoex_target_by_district WHERE `target_id` = '".$target."' && `state_id` = '".$stateId."' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getCityAllocateDataByState($target,$distId){
        $query = "SELECT * FROM ecoex_target_by_city WHERE `target_id` = '".$target."' && `distrcit_id` = '".$distId."' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
}

?>