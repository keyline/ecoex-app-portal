<?php namespace App\Models;



use CodeIgniter\Model;



class Company extends Model{



    protected $table ='ecoex_company';

    protected $primaryKey='c_id';

    protected $allowedFields =[

        'c_name',

        'created_at',

        'updated_at'     

    ];

    

    public function getCompanyDetailByName($companyName){

        $query = "SELECT * FROM ecoex_company WHERE c_name = '".$companyName."' ";

        $query=$this->db->query($query);

        return $query->getResultArray();

    }

    

    public function getVerificationEmail(){

        $query = "SELECT * FROM ecoex_email_template where `id` = '2' ";

        $query=$this->db->query($query);

        return $query->getRow();

    }

    

    public function getForgotPasswordEmail(){

        $query = "SELECT * FROM ecoex_email_template where `id` = '9' ";

        $query=$this->db->query($query);

        return $query->getRow();

    }

    public function getMemberByMobileNo($mobileNo){

        $query = "SELECT * FROM ecoex_user_table where `user_mobile` = '".$mobileNo."' ";

        $query=$this->db->query($query);

        return $query->getRow();

    }

    public function getMemberByEmail($email){

        $query = "SELECT * FROM ecoex_user_table where `user_email` = '".$email."' ";

        $query=$this->db->query($query);

        return $query->getRow();

    }

    public function getCompanyDetailByID($id){

        $query = "SELECT * FROM ecoex_company WHERE c_id = '".$id."' ";

        $query=$this->db->query($query);

        return $query->getResultArray();

    }

    public function getCompanyUserDataByID($id){

        $query = "SELECT * FROM ecoex_user_table WHERE c_id = '".$id."' ";

        $query=$this->db->query($query);

        return $query->getResultArray();

    }

    public function updateCompanyUserData($data){

        $query = "UPDATE `ecoex_user_table` SET `user_email` = '".$data['user_email']."',`user_mobile` = '".$data['user_mobile']."',

        `user_membership_type` = '".$data['user_membership_type']."',`user_password` = '".md5($data['user_password'])."' WHERE c_id = '".$data['c_id']."' ";

        $this->db->query($query);

        return true;

    }

    public function setOTPForMobile($mobileNo,$otp){

        $query = "INSERT INTO `ecoex_mobileOTP` VALUES(null,'".$mobileNo."','".$otp."',now()) ";

        $this->db->query($query);

        return true;

    }

    

    public function getOTPDataByMobile($mobileNo){

        $query = "SELECT * FROM ecoex_mobileOTP WHERE `mobileNo` = '".$mobileNo."' ORDER BY `id` DESC LIMIT 0,1";

        $query=$this->db->query($query);

        return $query->getResultArray();

    }

    public function getUserDataByEmail($email){

        $query = "SELECT * FROM ecoex_user_table WHERE `user_email` = '".$email."'";

        $query=$this->db->query($query);

        return $query->getRow();

    }

    

    public function verifyMobile($data){

        $query = "UPDATE `ecoex_user_table` SET `user_mobile_auth` = '1',`user_mobile_verified_at` = now(),`updated_at` = now() WHERE c_id = '".$data['c_id']."' ";

        $this->db->query($query);

        return true;

    }

    public function setEmailCode($data){

        $query = "DELETE FROM `ecoex_emailVerification` WHERE `c_id` = '".$data['c_id']."' ";

        $this->db->query($query);

        

        $query = "INSERT INTO `ecoex_emailVerification` VALUES(null,'".$data['c_id']."','".$data['link']."','0',now(),now()) ";

        $this->db->query($query);

        return true;

    }

    

    public function getDataByEmailLink($link){

        $query = "SELECT * FROM ecoex_emailVerification WHERE `link` = '".$link."' ORDER BY `id` DESC LIMIT 0,1";

        $query=$this->db->query($query);

        return $query->getResultArray();

    }

    public function verifyEmail($data){

        $query = "UPDATE `ecoex_user_table` SET `user_email_auth` = '1',`user_email_verified_at` = now(),`updated_at` = now() WHERE user_id = '".$data['c_id']."' ";

        $this->db->query($query);

        

        $query = "UPDATE `ecoex_emailVerification` SET `status` = '1',`updatedAt` = now() WHERE id = '".$data['id']."' ";

        $this->db->query($query);

        return true;

    }
    
    public function addEmailLog($data){
            $query = "INSERT INTO `ecoex_email_log` VALUES(null,'".$data['userID']."','".$data['fromID']."','".$data['email']."',now()) ";
            $this->db->query($query);
        return true;
    }


    public function getStoreLogin($data){

        $query = "SELECT * FROM ecoex_user_table WHERE `user_email` = '".$data['email']."' && `user_password` = '".md5($data['password'])."' ";

        $query=$this->db->query($query);

        return $query->getRow();

    }

    public function getStoreUserDetail($id){

        $query = "SELECT * FROM ecoex_user_table WHERE `c_id` = '".$id."' ";

        $query=$this->db->query($query);

        return $query->getRow();

    }

    public function getStoreDetail($id){

        $query = "SELECT * FROM ecoex_company WHERE `c_id` = '".$id."' ";

        $query=$this->db->query($query);

        return $query->getRow();

    }

    public function getCompanyDetail($id){

        $query = "SELECT * FROM ecoex_company_details WHERE `c_id` = '".$id."' ";

        $query=$this->db->query($query);

        return $query->getRow();

    }

    public function getAddressDetail($id){

        $query = "SELECT * FROM ecoex_company_address WHERE `c_id` = '".$id."' ";

        $query=$this->db->query($query);

        return $query->getRow();

    }

    public function getBankDetail($id){

        $query = "SELECT * FROM ecoex_company_bank_details WHERE `c_id` = '".$id."' ";

        $query=$this->db->query($query);

        return $query->getRow();

    }

    public function getUnitDetail($id){

        $query = "SELECT * FROM ecoex_unit_details WHERE `c_id` = '".$id."' ";

        $query=$this->db->query($query);

        return $query->getRow();

    }

    public function getCompanyTypeList(){

        $query = "SELECT * FROM ecoex_company_type ";

        $query=$this->db->query($query);

        return $query->getResultArray();

    }
    
    public function getCategoryUnitTypeList(){

        $query = "SELECT * FROM ecoex_material_type ";

        $query=$this->db->query($query);

        return $query->getResultArray();

    }

    public function getBusinessCategoryList(){

        $query = "SELECT * FROM ecoex_business_category ";

        $query=$this->db->query($query);

        return $query->getResultArray();

    }

    public function getParentCategoryList(){

        $query = "SELECT * FROM ecoex_business_category WHERE `parent` = '0' ";

        $query=$this->db->query($query);

        return $query->getResultArray();

    }

    public function getSubCategoryByParentID($id){

        $query = "SELECT * FROM ecoex_business_category WHERE `parent` = '".$id."' ";

        $query=$this->db->query($query);

        return $query->getResultArray();

    }
    public function getCategoryByID($id){
        $query = "SELECT * FROM ecoex_business_category WHERE `id` = '".$id."' ";
        $query=$this->db->query($query);
        return $query->getRow();
    }

    

    public function storeCompanyRegStepOne($data){        
        $query = "SELECT * FROM ecoex_company_details WHERE `c_id` = '".$data['storeID']."' ";
        $query=$this->db->query($query);
        $storeDetail = $query->getRow();
        //$query = "UPDATE `ecoex_user_table` SET `user_email` = '".$data['user_email']."',`user_mobile` = '".$data['user_mobile']."',`user_membership_type` = '".$data['member_id']."' WHERE c_id = '".$data['storeID']."'";
        //$this->db->query($query);
        if(isset($storeDetail->company_details_id)){
            $query = "UPDATE `ecoex_company_details` SET `c_establishDate` = '".$data['establishDate']."',`contactName` = '".$data['contactPerson']."',

            `companyType` = '".$data['companyType']."',`c_pan` = '".$data['panNumber']."',`c_gst` = '".$data['gstNumber']."',`alMobileNo` = '".$data['alMobile']."',

            `alEmail` = '".$data['alEmail']."',`c_business_category` = '".$data['businessCategory']."',`updated_at` = now() WHERE c_id = '".$data['storeID']."' ";
            $this->db->query($query);
        } else {
            $query = "INSERT INTO `ecoex_company_details` VALUES(null,'".$data['storeID']."','".$data['establishDate']."','".$data['contactPerson']."','".$data['companyType']."',
            '".$data['panNumber']."','','".$data['gstNumber']."','','".$data['alMobile']."','".$data['alEmail']."','','".$data['businessCategory']."',now(),now()) ";
            $this->db->query($query);
        }
        if($data['panCard'] != ''){
            $query = "UPDATE `ecoex_company_details` SET `c_pan_file` = '".$data['panCard']."' WHERE c_id = '".$data['storeID']."' ";
            $this->db->query($query);
        }
        if($data['GSTCard'] != ''){
            $query = "UPDATE `ecoex_company_details` SET `c_gst_file` = '".$data['GSTCard']."' WHERE c_id = '".$data['storeID']."' ";
            $this->db->query($query);
        }
        if($data['COICard'] != ''){
            $query = "UPDATE `ecoex_company_details` SET `coiFile` = '".$data['COICard']."' WHERE c_id = '".$data['storeID']."' ";
            $this->db->query($query);
        }
        $query = "UPDATE `ecoex_company` SET `updated_at` = now() WHERE c_id = '".$data['storeID']."' ";
        $this->db->query($query);
        return true;
    }

    

    public function storeCompanyUserUpdate($data){
        $query = "UPDATE `ecoex_user_table` SET `user_name` = '".$data['contactPerson']."',`updated_at` = now() WHERE 

            c_id = '".$data['storeID']."' && `user_role_type` = '0' ";
        $this->db->query($query);
        return true;
    }

    public function storeCompanyRegStepTwo($data){

        $query = "SELECT * FROM ecoex_company_address WHERE `c_id` = '".$data['storeID']."' ";

        $query=$this->db->query($query);

        $storeDetail = $query->getRow();

        

        if(isset($storeDetail->company_address_id)){

            $query = "UPDATE `ecoex_company_address` SET `c_country` = '".$data['country']."',`c_state` = '".$data['state']."',

            `c_city` = '".$data['city']."',`c_district` = '".$data['district']."',`c_pincode` = '".$data['pincode']."',`c_full_address` = '".$data['address']."',

            `updated_at` = now() WHERE c_id = '".$data['storeID']."' ";

            $this->db->query($query);

        } else {

            $query = "INSERT INTO `ecoex_company_address` VALUES(null,'".$data['storeID']."','".$data['country']."','".$data['state']."','".$data['city']."',

            '".$data['district']."','".$data['pincode']."','".$data['address']."',now(),now()) ";

            $this->db->query($query);

        }

            $query = "UPDATE `ecoex_company` SET `updated_at` = now() WHERE c_id = '".$data['storeID']."' ";

            $this->db->query($query);

        return true;

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

            if($data['userType'] != '2'){
                $query = "UPDATE `ecoex_company` SET `c_status` = '1',`updated_at` = now() WHERE c_id = '".$data['storeID']."' ";
                $this->db->query($query);
            }

            

        return true;

    }

    public function storeCompanyRegStepFour($data){
        $query = "SELECT * FROM ecoex_unit_details WHERE `c_id` = '".$data['storeID']."' ";
        $query=$this->db->query($query);
        $storeDetail = $query->getRow();

        if(isset($storeDetail->unit_name)){
            $unitID = $storeDetail->unit_id;
            $query = "UPDATE `ecoex_unit_details` SET `unit_name` = '".$data['unit_name']."',`unit_category` = '".$data['unit_category']."',`consent_cert_no` = '".$data['consent_cert_no']."',
            `consent_valid_from` = '".$data['consent_valid_from']."',`consent_valid_upto` = '".$data['consent_valid_upto']."',`consent_document` = '".$data['consent_document']."',
            `pwm_cert_no` = '".$data['pwm_cert_no']."',`pwm_valid_from` = '".$data['pwm_valid_from']."',`pwm_valid_upto` = '".$data['pwm_valid_upto']."',
            `cpcb_cert_no` = '".$data['cpcb_cert_no']."',`cpcb_valid_from` = '".$data['cpcb_valid_from']."',`cpcb_valid_upto` = '".$data['cpcb_valid_upto']."',
            `c_state` = '".$data['c_state']."',`c_city` = '".$data['c_city']."',`c_district` = '".$data['c_district']."',`c_pincode` = '".$data['c_pincode']."'
            ,`c_full_address` = '".$data['c_full_address']."',`updated_at` = now() WHERE c_id = '".$data['storeID']."' ";
            $this->db->query($query);
        } else {

            $query = "INSERT INTO `ecoex_unit_details` VALUES(null,'".$data['storeID']."','".$data['unit_name']."','".$data['unit_category']."','".$data['consent_cert_no']."',
            '".$data['consent_valid_from']."','".$data['consent_valid_upto']."','','".$data['pwm_cert_no']."','".$data['pwm_valid_from']."','".$data['pwm_valid_upto']."'
            ,'','".$data['cpcb_cert_no']."','".$data['cpcb_valid_from']."','".$data['cpcb_valid_upto']."',''
            ,'".$data['state']."','".$data['city']."','".$data['district']."','".$data['c_pincode']."','".$data['c_full_address']."',now(),now()) ";
            $this->db->query($query);
            $unitID = $this->db->insertID();
        }

        if($data['consent_document'] != ''){
            $query = "UPDATE `ecoex_unit_details` SET `consent_document` = '".$data['consent_document']."' WHERE c_id = '".$data['storeID']."' ";
            $this->db->query($query);
        }
        
        if($data['pwm_document'] != ''){
            $query = "UPDATE `ecoex_unit_details` SET `pwm_document` = '".$data['pwm_document']."' WHERE c_id = '".$data['storeID']."' ";
            $this->db->query($query);
        }
        
        if($data['cpcb_document'] != ''){
            $query = "UPDATE `ecoex_unit_details` SET `cpcb_document` = '".$data['cpcb_document']."' WHERE c_id = '".$data['storeID']."' ";
            $this->db->query($query);
        }
        
        foreach($data['typeOfMaterial'] as $key=>$material){
            $materialFullName = $data['materialFullName'][$key];
            $monthlyCapicity = $data['monthlyCapicity'][$key];
            $annualCapicity = $data['annualCapicity'][$key];
            
            if($materialFullName != '' && $monthlyCapicity != '' && $annualCapicity != ''){
                
                $query = "SELECT * FROM ecoex_unit_material_detail WHERE `c_id` = '".$data['storeID']."' && `typeOfMaterial` =  '".$material."'";
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
        $query = "UPDATE `ecoex_company` SET `c_status` = '1',`updated_at` = now() WHERE c_id = '".$data['storeID']."' ";
        $this->db->query($query);
        $c_id = $data['storeID'];
        $unit_details = $this->db->query("select * from ecoex_unit_details where c_id  = '$c_id'")->getRow();
        return $unit_details->unit_id;
    }

    public function addUnitPlantImages($data){
            $query = "INSERT INTO `ecoex_unit_details_images` VALUES(null,'".$data['storeID']."','".$data['unitID']."',
            '".$data['file_name']."','".$data['type']."',now()) ";
            $this->db->query($query);
        return true;

    }

    public function getStateList(){

        $query = "SELECT * FROM ecoex_state order by state_title ASC";

        $query=$this->db->query($query);

        return $query->getResultArray();

    }

    public function getDistrictListById($id){

        $query = "SELECT * FROM ecoex_district where `state_id` = '".$id."' ";

        $query=$this->db->query($query);

        return $query->getResultArray();

    }

    public function getCityListById($id){

        $query = "SELECT * FROM ecoex_city where `districtid` = '".$id."' ";

        $query=$this->db->query($query);

        return $query->getResultArray();

    }

    

    public function resetPasswordByID($id,$password){

        $query = "UPDATE `ecoex_user_table` SET `user_password` = '".md5($password)."',`updated_at` = now() WHERE `user_id` = '".$id."' ";

        $this->db->query($query);

        return true;

    }

    

}



?>