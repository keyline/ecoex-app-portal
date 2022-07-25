<?php echo view('admin/layout/header'); ?>
<div class="wrapper-page">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
  <?php echo view('admin/layout/navbar'); ?>
  <?php echo view('admin/layout/sidebar'); ?>
  <!-- Main Content -->
      <div class="main-content">
        <section class="section">
      <div class="container-fluid">
<?php 
    $companyName = $controller->getCompanyName($totalMember->c_id);
    $companyDetail = $controller->getCompanyDetailByID($totalMember->c_id);
    $companyUserDetail = $controller->getmemberDetailByCID($totalMember->c_id);
    $companyAddress = $controller->getCompanyAddressData($totalMember->c_id);
    $cityList = $Comcontroller->getCityListById($companyAddress->c_district);
    $districtList = $Comcontroller->getDistrictListById($companyAddress->c_state);
    $memberType = $controller->getMemberType($companyUserDetail->user_membership_type);
    $companyType = $controller->getCompanyType($companyDetail->companyType);
    
    $companyDetail = $controller->getCompanyDetailById($totalMember->c_id);
    $companyCatData = $companyDetail->c_business_category;
    $companyCatData = explode (",", $companyCatData); 
    $categoryName = '';
    foreach($companyCatData as $cat){
        $category = $controller->getCatNameById($cat);
        $categoryName .= $category->name.',';
    }
                            
?>        
		<div class="row">
        	<div class="col-md-12">
                <form method="post" action="/admin/editMemberDetailsData" enctype="multipart/form-data">
                    <input type="hidden" name="storeID" value="<?php echo $id;?>">
                    <input type="hidden" name="user_membership_type" value="<?php echo $companyUserDetail->user_membership_type;?>">
            	<div class="memberdetails_inner_section">
                    <div class="memberdetl_middle">
                    	<div class="middle-title mb-4">
                        	<h3>Company Details</h3>
                        </div>
                        <div class="member_midle_flex">
                        	<div class="memberdtl_col">
                                <div class="col pl-0">
                                    <h5>Establishment Date</h5>
                                    <input type="date" class="form-control required" value="<?php echo $companyDetail->c_establishDate;?>"
                                    name="establishDate" required>
                                </div>
                                <div class="col pl-0">
                                    <h5>Pan Number</h5>
                                    <input type="text" class="form-control required" value="<?php echo $companyDetail->c_pan;?>"
                                    name="panNumber" id="panNumber" onblur="return isPAN(this.value)" maxlength="10" minlength="10" required style="text-transform: uppercase;">
                                    <span class="text-danger" id="pan-err" style="display:none;font-weight: bold;"></span>
                                    <span class="text-success" id="pan-succ" style="display:none;font-weight: bold;"></span>
                                </div>
                                <div class="col pl-0">
                                    <h5>COI</h5>
                                    <?php if($companyDetail->coiFile != ''){?>
                                        <img src="<?=base_url('writable/uploads/'.$companyDetail->coiFile)?>" class="img-thumbnail" style="width: 100px; height: 100px;"><br>
                                    <?php }?>
                                    <input type="file" class="form-control required" name="COI" accept="image/gif, image/jpeg, image/png">
                                </div>
                            </div>
                            <div class="memberdtl_col">
                                <div class="col">
                                    <h5>Contact Person</h5>
                                    <input type="text" class="form-control required" value="<?php echo $companyDetail->contactName;?>" name="contactPerson" onkeypress="return isCharacter(event)" required style="text-transform: uppercase;">
                                </div>
                                <div class="col">
                                    <h5>Pan Card</h5>
                                    <?php if($companyDetail->c_pan_file != ''){?>
                                        <img src="<?=base_url('writable/uploads/'.$companyDetail->c_pan_file)?>" class="img-thumbnail" style="width: 100px; height: 100px;"><br>
                                    <?php }?>
                                    <input type="file" class="form-control required" name="panCard" accept="image/gif, image/jpeg, image/png">
                                </div>
                                <div class="col">
                                    <h5>Mobile No.</h5>
                                    <input type="text" class="form-control required" value="<?php echo $companyUserDetail->user_mobile;?>"
                                    name="user_mobile" required maxlength="10" onkeypress="return isNumber(event)">
                                </div>
                            </div>
                            <div class="memberdtl_col">
                                <div class="col">
                                    <h5>Member Type</h5>                                   
                                    <select class="form-control" id="member_id" name="member_id" required>
                                        <option value="">Select Member Type</option>
                                        <?php foreach ($membertype as $row) { ?>
                                            <option value="<?php echo $row['member_id'] ?>" 
                                            <?php if($companyUserDetail->user_membership_type == $row['member_id']){ echo 'selected'; } ?>><?php echo $row['member_type'] ?></option>
                                        <?php  }  ?>
                                    </select>                                    
                                </div>
                                <div class="col">
                                    <h5>GST Number</h5>
                                    <input type="text" class="form-control required" value="<?php echo $companyDetail->c_gst;?>"
                                    name="gstNumber" id="gstNumber" onblur="return isGST(this.value)" maxlength="15" minlength="15" required style="text-transform: uppercase;">
                                    <span class="text-danger" id="gst-err" style="display:none;font-weight: bold;"></span>
                                    <span class="text-success" id="gst-succ" style="display:none;font-weight: bold;"></span>
                                </div>
                                <div class="col">
                                    <h5>Alt Mobile No.</h5>
                                    <!--<p><?php echo $companyDetail->alMobileNo;?></p>-->
                                    <input type="text" class="form-control required" value="<?php echo $companyDetail->alMobileNo;?>"
                                    name="alMobile" maxlength="10" onkeypress="return isNumber(event)">
                                    <span class="text-success" id="alt-mobile-succ" style="display:none;font-weight: bold;"><i class="fa fa-check-circle"></i> </span>
                                    <span class="text-danger" id="alt-mobile-err" style="display:none;font-weight: bold;"><i class="fa fa-times-circle"></i> </span>
                                    <p><small>Format: 9876543210</small></p>
                                </div>
                            </div>
                            <div class="memberdtl_col">
                                <div class="col">
                                    <h5>Company Type</h5>
                                    <!--<p><?php echo $companyType->name;?></p>-->
                                    <select class="form-control" name="companyType" required>
                                        <option value="">Select Company Type</option>
                                    <?php foreach($companyList as $company){ ?>
                                    <option value="<?php echo $company['id'];?>" 
                                    <?php if($companyDetail->companyType == $company['id']){ echo 'selected'; } ?>><?php echo $company['name'];?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <h5>GST Number</h5>
                                    <?php if($companyDetail->c_gst_file != ''){?>
                                        <img src="<?=base_url('writable/uploads/'.$companyDetail->c_gst_file)?>" class="img-thumbnail" style="width: 100px; height: 100px;"><br>
                                    <?php }?>
                                    <input type="file" class="form-control required" name="gstCard" accept="image/gif, image/jpeg, image/png">
                                </div>
                                <div class="col">
                                    <h5>Business Category</h5>
                                    <!--<p><?php echo rtrim($categoryName,',');?></p>-->
                                    <div class="form-group pt-2">
                                        <?php foreach($categoryList as $category){ ?>
                                        <div class="form-check form-check-inline clear">
    <?php 
    $allMainCategories = explode(',' ,$companyDetail->c_business_category);
    ?>
                                            <input class="form-check-input greencheck" type="checkbox" name="businessCategory[]" id="checkbox<?php echo $category['id']; ?>" 
                                            value="<?php echo $category['id']; ?>" <?php if(in_array($category['id'], $allMainCategories)){ echo 'checked'; } ?>>
                                            <label class="form-check-label" for="checkbox<?php echo $category['id']; ?>"><?php echo $category['name']; ?></label>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                
    <?php foreach($categoryList as $category){ 
    $totalCategory5 = $Comcontroller->getSubCategoryByParentID($category['id']);
    if(in_array($category['id'], $allMainCategories)){ $checkboxDisplay = "inline"; } else { $checkboxDisplay = "none"; } 
    ?>
                            <div class="col" id="subCategoryCheckbox<?php echo $category['id'];?>" style="display:<?php echo $checkboxDisplay; ?>">
                                <div class="form-group">
                                    <label for=""><?php echo $category['name']; ?></label>
                                    <div class="form-group pt-2">
                                     <?php foreach($totalCategory5 as $category5){ ?>    
                                        <div class="form-check form-check-inline clear">
                                            <input class="form-check-input greencheck" type="checkbox" name="businessCategory[]" id="<?php echo $category5['id']; ?>" 
                                            value="<?php echo $category5['id']; ?>" <?php if(in_array($category5['id'], $allMainCategories)){ echo 'checked'; } ?>>
                                            <label class="form-check-label" for="<?php echo $category5['id']; ?>"><?php echo $category5['name']; ?></label>
                                        </div>
                                    <?php } ?>    
                                    </div>
                                </div>
                            </div>
    <?php } ?>
                            </div>
                            <div class="memberdtl_col">
                                <div class="col">
                                    <h5>Email ID</h5>
                                    <!--<p><?php echo $companyUserDetail->user_email;?></p>-->
                                    <input type="email" class="form-control required" value="<?php echo $companyUserDetail->user_email;?>"
                                    name="user_email" required>
                                </div>
                                <div class="col">
                                    <h5>Alt Email Id</h5>
                                    <!--<p><?php echo $companyDetail->alEmail;?></p>-->
                                    <input type="email" class="form-control required" value="<?php echo $companyUserDetail->alEmail;?>"
                                    name="alEmail">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="memberdetl_address">
                    	<div class="middle-title mb-4">
                        	<h3>Address</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">State <span class="red">*</span> </label>
                                    <select class="form-control" name="state" id="state" required>
                                        <option>Select state </option>
                                        <?php foreach($stateList as $state){ ?>
                                        <option value="<?php echo $state['state_id'];?>"
                                        <?php if($companyAddress->c_state == $state['state_id']){ echo 'selected'; } ?>><?php echo $state['state_title'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">District <span class="red">*</span> </label>
                                    <select class="form-control" name="district" id="district" required>
                                        <option>Select District </option>
                                        <?php foreach($districtList as $district){ ?>
                                        <option value="<?php echo $district['districtid'];?>"
                                        <?php if($companyAddress->c_district == $district['districtid']){ echo 'selected'; } ?>><?php echo $district['district_title'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">City</label>
                                    <select class="form-control" name="city" id="city" required>
                                        <option>Select city</option>
                                        <?php foreach($cityList as $city){ ?>
                                        <option value="<?php echo $city['id'];?>"
                                        <?php if($companyAddress->c_city == $city['id']){ echo 'selected'; } ?>><?php echo $city['name'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Pincode <span class="red">*</span></label>
                                    <input class="form-control" type="text" name="pincode" placeholder="Entry Pincode" 
                                    value="<?php echo $companyAddress->c_pincode;?>" required onkeypress="return isNumber(event)" maxlength="6" minlength="6">
                                </div>
                            </div>            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Address <span class="red">*</span> </label>
                                    <textarea placeholder="Entry Address" name="address" class="form-control" required><?php echo $companyAddress->c_full_address;?></textarea>
                                </div>
                            </div> 
                        </div>                                                   
                    </div>
                    
<?php 
    $companyBankDetailData = $controller->getCompanyBankDetailsByID($totalMember->c_id);
?>
                    <div class="memberdetl_bank">
                    	<div class="middle-title mb-4">
                        	<h3>Bank Details</h3>
                        </div>
                        <div class="member_midle_flex">
                            <div class="memberdtl_col">
                                <div class="col pl-0">
                                    <h5>Account No.</h5>
                                    <!--<p><?php echo $companyBankDetailData->accountNo;?></p>-->
                                    <input class="form-control" type="text" name="accountNo" placeholder="Entry Account No." 
                                    value="<?php echo $companyBankDetailData->accountNo;?>" required>
                                </div>
                                <div class="col pl-0">
                                    <h5>Branch</h5>
                                    <!--<p><?php echo $companyBankDetailData->c_branch_name;?></p>-->
                                    <input class="form-control" type="text" name="branchName" placeholder="Entry Branch" 
                                    value="<?php echo $companyBankDetailData->c_branch_name;?>" required>
                                </div>
                              </div>
                            <div class="memberdtl_col">
                                <div class="col">
                                    <h5>Account Holder Name</h5>
                                    <!--<p><?php echo $companyBankDetailData->c_acct_holder_name;?></p>-->
                                    <input class="form-control" type="text" name="accountHolder" placeholder="Entry Account Holder Name" 
                                    value="<?php echo $companyBankDetailData->c_acct_holder_name;?>" required>
                                </div>
                                <div class="col">
                                    <h5>IFSC Code</h5>
                                    <!--<p><?php echo $companyBankDetailData->c_micr_code;?></p>-->
                                    <input class="form-control" type="text" name="mtcrCode" placeholder="Entry IFSC Code" 
                                    value="<?php echo $companyBankDetailData->c_micr_code;?>" required>
                                </div>
                              </div>
                            <div class="memberdtl_col">
                                <div class="col">
                                    <h5>Cancelled Check</h5>
                                    <!--<?php if($companyBankDetailData->c_cancelled_cheque != ''){?>
                                    <p><a href="/writable/uploads/<?php echo $companyBankDetailData->c_cancelled_cheque;?>" target="_blank" class="viewopenimg">View</a></p>
                                    <?php } ?>-->
                                    <input type="file" class="form-control required" name="cancllledCheque">
                                    
                                </div>
                              </div>
                            <div class="memberdtl_col">
                                <div class="col">
                                    <h5>Account Type</h5>
                                    <!--<p style="text-transform: capitalize;"><?php echo $companyBankDetailData->c_account_type;?></p>-->
                                    <div class="form-group pt-2">
                                        <div class="form-check form-check-inline clear">
                                            <input class="form-check-input" type="radio" name="accountType" id="inlineRadio1" value="current"
                                            <?php if($companyBankDetailData->c_account_type == "current"){ echo 'checked'; } ?> required>
                                            <label class="form-check-label" for="inlineRadio1">Current</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="accountType" id="inlineRadio2" value="saving"
                                            <?php if($companyBankDetailData->c_account_type == "saving"){ echo 'checked'; } ?> required>
                                            <label class="form-check-label" for="inlineRadio2">Savings</label>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            <div class="memberdtl_col">
                                <div class="col">
                                    <h5>Bank Name</h5>
                                    <!--<p><?php echo $companyBankDetailData->c_bank_name;?></p>-->
                                    <input class="form-control" type="text" name="bankName" placeholder="Entry Bank Name" 
                                    value="<?php echo $companyBankDetailData->c_bank_name;?>" required>
                                </div>
                              </div>
                        </div>
                    </div>
                    <?php if($companyUserDetail->user_membership_type == '2'){
                        $companyDetail = $controller->getUnitByStoreID($totalMember->c_id);
                        $unitMaterialDetail = $controller->getUnitMaterialDetailsByUnitID($totalMember->unit_id);                        
                        $stateList = $Comcontroller->getStateList();
                        $districtList = $Comcontroller->getDistrictListById($companyDetail->c_state);
                        $cityList = $Comcontroller->getCityListById($companyDetail->c_district);                            
                    ?>    
                    <div class="memberdetl_bank">
                    	<div class="middle-title mb-4">
                        	<h3 style="float: left;margin-right: 20px;">Unit Creation</h3> 
                        	<a class="btn btn-info" href="/admin/editCompanyUnit/<?php echo encoded($totalMember->c_id).'/'.encoded(0);?>" target="_blank">Add New Unit</a>
                        </div>
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Unit Name</th>
                                            <th>Unit Category</th>
                                            <th>City</th>
                                            <th>District</th>
                                            <th>State</th>
                                            <th>Pincode</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $unitDatas = $controller->getUnitDatasByStoreID($totalMember->c_id);
                                                $cIj = 1;
                                                foreach($unitDatas as $unitData){ 
                                            $unitMatirialName = $controller->getCategoryUnitTypeById($unitData['unit_category']);  
                                            $unitCityName = $controller->getCityByCityID($unitData['c_city']);  
                                            $unitDistName = $controller->getDistByDistID($unitData['c_district']);  
                                            $unitStateName = $controller->getStateByStateID($unitData['c_state']);        
                                        ?>                                            
                                        <tr>
                                            <td><?php echo $cIj;?></td>
                                            <td><?php echo $unitData['unit_name'];?></td>
                                            <td><?php echo $unitMatirialName->name;?></td>
                                            <td><?php echo $unitCityName->name;?></td>
                                            <td><?php echo $unitDistName->district_title;?></td>
                                            <td><?php echo $unitStateName->state_title;?></td>
                                            <td><?php echo $unitData['c_pincode'];?></td>
                                            <td><?php echo $unitData['c_full_address'];?></td>
                                            <td><a class="btn btn-info" href="/admin/editCompanyUnit/<?php echo encoded($unitData['c_id']).'/'.encoded($unitData['unit_id']);?>" target="_blank">Edit Unit</a></td>
                                        </tr>
                                        <?php $cIj++; } ?>                                        
                                    </tbody>
                                </table>                                
                            </div>                            
                        </div>
                    </div>
                    <?php } ?>
                    <input type="submit" name="next" class="btn btn-primary" value="Submit" />
                </div>                
            </form>    
            </div>
        </div>
      </div>
    </section>
    </div>
      <!-- Main Content -->
    </div>
</div>
<?php echo view('admin/layout/footer'); ?>

<script type="text/javascript">
    function isCharacter(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;        
        if (charCode != 32 && (charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122)) {
            return false;
        }
        return true;
    }
    function isCharacterNumeric(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 32 && (charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    function isPAN(valam){
        var panVal = valam;
        if(panVal != ''){
            var regpan = /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/;
            if(regpan.test(panVal)){
               // valid pan card number
               $('#pan-succ').show();
               $('#pan-err').hide();
               $('#pan-succ').text('Valid PAN Format !!!');
            } else {
               // invalid pan card number
               $('#pan-succ').hide();
               $('#pan-err').show();
               $('#panNumber').val('');
               $('#pan-err').text('Invalid PAN Format !!!');
            }
        } else {
            $('#pan-succ').hide();
            $('#pan-err').show();
            $('#pan-err').text('Please Enter PAN Number !!!');
        }        
    }
    function isGST(valam){
        var gstVal = valam;
        if(gstVal != ''){
            var regpan = /^([0-9]){2}([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}([0-9]){1}([a-zA-Z]){1}([0-9a-zA-Z]){1}?$/;
            if(regpan.test(gstVal)){
               // valid GST card number
               $('#gst-succ').show();
               $('#gst-err').hide();
               $('#gst-succ').text('Valid GST Format !!!');
            } else {
               // invalid GST card number
               $('#gst-succ').hide();
               $('#gst-err').show();
               $('#gstNumber').val('');
               $('#gst-err').text('Invalid GST Format !!!');
            }
        } else {
            $('#gst-succ').hide();
            $('#gst-err').show();
            $('#gst-err').text('Please Enter GST Number !!!');
        }        
    }
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
<script>
    $('#click-show-comment, #comment-to-toggle').click(function (e) {
        if ($(e.target).attr('id') != 'close-btn') {
            $('#comment-to-toggle').show();
            event.stopPropagation();
        }
    });
    $(' #close-btn').click(function () {
        $('#comment-to-toggle').hide();
        event.stopPropagation();
    })
</script>

<script>
    $(document).ready(function(){
<?php foreach($categoryList as $category){ ?>        
    $('#checkbox<?php echo $category['id'];?>').change(function(){
        if(this.checked){ 
            $('#subCategoryCheckbox<?php echo $category['id'];?>').show(300);
        }else{
            $('#subCategoryCheckbox<?php echo $category['id'];?>').hide(200);
            $("#subCategoryCheckbox<?php echo $category['id'];?>").find(":checkbox").prop("checked", false);
        }

    });
<?php } ?>   

 $("#state").change(function(){  
    var stateId = $(this).val();
      $.ajax({   
        type: "GET",
        data: { stateId: stateId },
        url: "/getDistrict.php",             
        dataType: "html",   //expect html to be returned                
        success: function(response){
                $("#district").html(response);
        }
    });
 });
 $("#district").change(function(){  
    var distId = $(this).val();
      $.ajax({   
        type: "GET",
        data: { distId: distId },
        url: "/getCity.php",             
        dataType: "html",   //expect html to be returned                
        success: function(response){
                $("#city").html(response);
        }
    });
 });
 
 $("#state1").change(function(){  
    var stateId = $(this).val();
      $.ajax({   
        type: "GET",
        data: { stateId: stateId },
        url: "/getDistrict.php",             
        dataType: "html",   //expect html to be returned                
        success: function(response){
                $("#district1").html(response);
        }
    });
 });
 $("#district1").change(function(){  
    var distId = $(this).val();
      $.ajax({   
        type: "GET",
        data: { distId: distId },
        url: "/getCity.php",             
        dataType: "html",   //expect html to be returned                
        success: function(response){
                $("#city1").html(response);
        }
    });
 });

var member_id = $('#member_id').val();
if(member_id == 1){
    $('#sub_member_type').show();
    $("input[name=user_sub_member_type[]]").attr("required", true);
} else {
    $('#sub_member_type').hide();
    $("input[name=user_sub_member_type[]]").attr("required", false);
}

$('#member_id').on('change', function(){
    var member_id = $('#member_id').val();
    //alert(member_id);
    if(member_id == 1){
        $('#sub_member_type').show();
        $("input[name=user_sub_member_type[]]").attr("required", true);
    } else {
        $('#sub_member_type').hide();
        $("input[name=user_sub_member_type[]]").attr("required", false);
    }
});
 
});
</script>