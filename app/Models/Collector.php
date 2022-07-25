<?php namespace App\Models;

use CodeIgniter\Model;

class Collector extends Model{

   
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
    public function getUnitList(){
        $query = "SELECT * FROM ecoex_unit WHERE `status` = '0' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function getStateList(){
        $query = "SELECT * FROM ecoex_state ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    
    public function addInventoryData($data){
       $query = "INSERT INTO `ecoex_collecter_inventory` VALUES(null,'".$data['inventory_type']."','".$data['storeId']."','".$data['category']."','".$data['subCategory']."','".$data['product']."','".$data['item']."',
            '".$data['year']."','".$data['month']."','".$data['qty']."','".$data['unit']."','".$data['attachment']."','".$data['rate']."',0,now(),now()) ";
        $this->db->query($query);
        
        return $this->db->insertID();
    }
    
    public function getInventoryDataByID($id){
        $query = "SELECT * FROM ecoex_collecter_inventory WHERE `inventory_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getInventoryDataByState($id){
        $query = "SELECT * FROM ecoex_collecter_inventory_by_state WHERE `inventory_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    
    public function addInventoryByStateData($data){
        
        foreach($data['stateData'] as $key=>$stateValue){
            
            $stateQty = $data['qty'][$key];
            $stateLocation = $data['storeLocation'][$key];
            if($stateValue != '' && $stateQty != '0'){
                
                $query = "SELECT * FROM ecoex_collecter_inventory_by_state WHERE `inventory_id` = '".$data['inventoryID']."' && `state_id` =  '".$stateValue."'";
                $query=$this->db->query($query);
                $stateTargetData = $query->getRow();
                
                if(isset($stateTargetData->id)){
                    
                       $query = "UPDATE `ecoex_collecter_inventory_by_state` SET `req_qty` = '".$stateQty."',`storeLocation` = '".$stateLocation."',
                       `updatedAt` = now() WHERE `inventory_id` = '".$data['inventoryID']."' 
                       && `state_id` = '".$stateValue."'";
                        $this->db->query($query);
                } else {
                    $query = "INSERT INTO `ecoex_collecter_inventory_by_state` VALUES(null,'".$data['storeId']."','".$data['inventoryID']."','".$stateValue."','".$stateQty."',
                    '".$stateLocation."',now(),now()) ";
                    $this->db->query($query);
                }
            }
        }
        return true;
    }
    
    public function getInventoryList($id){
        $query = "SELECT * FROM ecoex_collecter_inventory WHERE `c_id` = '".$id."' ORDER BY `inventory_id` DESC";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    
    public function getAllocateQtyInventoryState($id){
        $query = "SELECT SUM(`req_qty`) as allocateQty FROM ecoex_collecter_inventory_by_state WHERE `inventory_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getStateAllocateDataByState($target){
        $query = "SELECT * FROM ecoex_collecter_inventory_by_state WHERE `inventory_id` = '".$target."' ";
        $query=$this->db->query($query);
        return $query->getResultArray();
    }
    public function editInventoryData($data){
       $query = "UPDATE `ecoex_collecter_inventory` SET `c_id` = '".$data['storeId']."',`inventory_type` = '".$data['inventory_type']."',`categoryId` = '".$data['category']."',`sucCatId` = '".$data['subCategory']."',`productId` = '".$data['product']."',
       `itemId` = '".$data['item']."',`year` = '".$data['year']."',`month` = '".$data['month']."',`qty` = '".$data['qty']."',`unit` = '".$data['unit']."',
       `rate` = '".$data['rate']."',`updatedAt` = now() WHERE `inventory_id` = '".$data['inventoryID']."' ";
        $this->db->query($query);
        
        if($data['attachment'] != ''){
           $query = "UPDATE `ecoex_collecter_inventory` SET `attachment` = '".$data['attachment']."' WHERE `inventory_id` = '".$data['inventoryID']."' ";
            $this->db->query($query);
        }
        
        return true;
    }
    
    public function getAllocateQtyDistrict($id,$stateId){
        $query = "SELECT SUM(`req_qty`) as allocateQty FROM ecoex_collecter_inventory_by_district WHERE `inventory_id` = '".$id."'  && `state_id` = '".$stateId."'";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getStateByID($id){
        $query = "SELECT * FROM ecoex_state WHERE `state_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    public function getAllocateQtyState($id){
        $query = "SELECT SUM(`req_qty`) as allocateQty FROM ecoex_collecter_inventory_by_state WHERE `inventory_id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }
    
}

?>