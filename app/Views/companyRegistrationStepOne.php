<?php 
echo view('include/header.php');
?>
            <div class="dashboard_form_start">
                <ul id="progressbar" class="dashboard_top_tab">
                    <li class="active" id="company">
                        <div class="dashoard_steps">
                            <div class="dash-step-number">1</div>
                            <div class="dash-step-name">
                                <div class="dash-step-icon"><img src="<?php echo site_url('public');?>/assets/frontend/images/company-icon.svg" alt="Icon"></div>
                                <div class="dash-step-info">
                                    <h3>Company Details</h3> 
                                    <h5>In Progress</h5>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li id="address">
                        <div class="dashoard_steps">
                            <div class="dash-step-number">2</div>
                            <div class="dash-step-name">
                                <div class="dash-step-icon"><img src="<?php echo site_url('public');?>/assets/frontend/images/pin-icon.svg" alt="Icon"></div>
                                <div class="dash-step-info">
                                    <h3>Address</h3> 
                                    <h5>Not started</h5>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li id="payment">
                        <div class="dashoard_steps">
                            <div class="dash-step-number">3</div>
                            <div class="dash-step-name">
                                <div class="dash-step-icon"><img src="<?php echo site_url('public');?>/assets/frontend/images/bank-icon.svg" alt="Icon"></div>
                                <div class="dash-step-info">
                                    <h3>Bank Details</h3> 
                                    <h5>Not started</h5>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php if($storeUserData->user_membership_type == '2'){ ?>
                    <li id="payment">
                        <div class="dashoard_steps">
                            <div class="dash-step-number">4</div>
                            <div class="dash-step-name">
                                <div class="dash-step-icon"><img src="<?php echo site_url('public');?>/assets/frontend/images/bank-icon.svg" alt="Icon"></div>
                                <div class="dash-step-info">
                                    <h3>Unit Creation</h3> 
                                    <h5>Not started</h5>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li id="payment">
                        <div class="dashoard_steps">
                            <div class="dash-step-number">5</div>
                            <div class="dash-step-name">
                                <div class="dash-step-icon"><img src="<?php echo site_url('public');?>/assets/frontend/images/bank-icon.svg" alt="Icon"></div>
                                <div class="dash-step-info">
                                    <h3>Complete Registration</h3> 
                                    <h5>Not started</h5>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php } else {?>
                    <li id="payment">
                        <div class="dashoard_steps">
                            <div class="dash-step-number">4</div>
                            <div class="dash-step-name">
                                <div class="dash-step-icon"><img src="<?php echo site_url('public');?>/assets/frontend/images/bank-icon.svg" alt="Icon"></div>
                                <div class="dash-step-info">
                                    <h3>Complete Registration</h3> 
                                    <h5>Not started</h5>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php } ?>
                </ul>          
            </div>
            <div class="dashboard_inner_section">
                <fieldset>
                <form method="post" action="/companyRegistrationStepOneData" enctype="multipart/form-data">
                    <input type="submit" name="next" class="next action-button" value="Save and Continue" />
                    <div class="dashboard_step_part">
                        
                        <div class="dashboard_step_left">
                            <div class="dashboar_leftnum">
                                1
                            </div>
                            <h3>Company Details</h3>
                        </div>
                        <div class="dashboard_step_right">
                            
                        </div>
                    </div>
                    <div class="dashboard_info_inner_section">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Company Name </label>
                                    <input class="form-control" type="text" placeholder="Ecoex Portal" value="<?php echo $storeData->c_name;?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Company Establishment Date <span class="red">*</span> </label>
                                    <input class="form-control" type="date" name="establishDate" placeholder="Entry Company Establishment Date" 
                                    value="<?php echo $companyDetail->c_establishDate;?>" required>
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Contact Person Name <span class="red">*</span> </label>
                                    <input class="form-control" type="text" name="contactPerson" placeholder="Entry Contact Person Name" value="<?php echo $companyDetail->contactName;?>" onkeypress="return isCharacter(event)" required style="text-transform: uppercase;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Company Type <span class="red">*</span> </label>
                                    <select class="form-control" name="companyType" required>
                                        <option value="">Select Company Type</option>
                                        <?php foreach($companyList as $company){ ?>
                                        <option value="<?php echo $company['id'];?>" 
                                        <?php if($companyDetail->companyType == $company['id']){ echo 'selected'; } ?>><?php echo $company['name'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Pan Number <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Entry Pan Number" name="panNumber" id="panNumber"
                                     value="<?php echo $companyDetail->c_pan;?>" onblur="return isPAN(this.value)" maxlength="10" minlength="10" required style="text-transform: uppercase;">
                                    <span class="text-danger" id="pan-err" style="display:none;font-weight: bold;"></span>
                                    <span class="text-success" id="pan-succ" style="display:none;font-weight: bold;"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php if($companyDetail->c_pan_file != ""){?>
                                        <img src="<?=base_url('writable/uploads/'.$companyDetail->c_pan_file)?>" style="width: 100px; height: 100px;"><br>
                                    <?php }?>
                                    <label for="">Upload Pan Card <?php if($companyDetail->c_pan_file != ""){ } else {?><span class="red">*</span><?php } ?>  </label>
                                    <input class="form-control" type="file" id="custom-input-file" placeholder="Entry Pan Number" name="panCard" <?php if($companyDetail->c_pan_file != ""){ } else {?> required <?php } ?> accept="image/gif, image/jpeg, image/png">
                                </div>
                            </div>            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">GST Number <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Entry GST Number" name="gstNumber" id="gstNumber" 
                                    value="<?php echo $companyDetail->c_gst;?>" onblur="return isGST(this.value)" maxlength="15" minlength="15" required style="text-transform: uppercase;">
                                    <span class="text-danger" id="gst-err" style="display:none;font-weight: bold;"></span>
                                    <span class="text-success" id="gst-succ" style="display:none;font-weight: bold;"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php if($companyDetail->c_gst_file != ""){?>
                                        <img src="<?=base_url('writable/uploads/'.$companyDetail->c_gst_file)?>" style="width: 100px; height: 100px;"><br>
                                    <?php }?>
                                    <label for="">Upload GST Document <?php if($companyDetail->c_gst_file != ""){ } else {?><span class="red">*</span><?php } ?> </label>
                                    <input class="form-control" type="file" id="custom-input-file-2" placeholder="Enter GST Number" name="gstCard" <?php if($companyDetail->c_gst_file != ""){ } else {?> required <?php } ?> accept="image/gif, image/jpeg, image/png">
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Alternate Mobile no. </label>
                                    <input class="form-control" type="text" placeholder="Enter alternate mobile no." name="alMobile" id="alMobile" value="<?php echo $companyDetail->alMobileNo;?>" maxlength="10" onkeypress="return isNumber(event)">
                                    <span class="text-success" id="alt-mobile-succ" style="display:none;font-weight: bold;"><i class="fa fa-check-circle"></i> </span>
                                    <span class="text-danger" id="alt-mobile-err" style="display:none;font-weight: bold;"><i class="fa fa-times-circle"></i> </span>
                                    <p><small>Format: 9876543210</small></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Alternate Email Id </label>
                                    <input class="form-control" type="email" placeholder="Enter alternate email id" name="alEmail"
                                    value="<?php echo $companyDetail->alEmail;?>" >
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php if($companyDetail->coiFile != ""){?>
                                        <img src="<?=base_url('writable/uploads/'.$companyDetail->coiFile)?>" style="width: 100px; height: 100px;"><br>
                                    <?php }?>
                                    <label for="">Optional Document upload (COI)</label>
                                    <input class="form-control" type="file" id="custom-input-file-3" placeholder="Entry GST Number" name="COI" accept="image/gif, image/jpeg, image/png">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Business Category</label>
                                    <div class="form-group pt-2">
                                        <?php foreach($categoryList as $category){ ?>
                                        <div class="form-check form-check-inline clear">
                                            <?php $allMainCategories = explode(',' ,$companyDetail->c_business_category);?>
                                            <input class="form-check-input greencheck" type="checkbox" name="businessCategory[]" id="checkbox<?php echo $category['id']; ?>" 
                                            value="<?php echo $category['id']; ?>" <?php if(in_array($category['id'], $allMainCategories)){ echo 'checked'; } ?>>
                                            <label class="form-check-label" for="checkbox<?php echo $category['id']; ?>"><?php echo $category['name']; ?></label>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            $secondCat=array();
                            foreach($categoryList as $category){ 
                            $totalCategory5 = $controller->getSubCategoryByParentID($category['id']);
                            if(in_array($category['id'], $allMainCategories)){ $checkboxDisplay = "inline"; } else { $checkboxDisplay = "none"; } 
                            ?>
                            <div class="col-md-6" id="subCategoryCheckbox<?php echo $category['id'];?>" style="display:<?php echo $checkboxDisplay; ?>">
                                <div class="form-group">
                                    <label for=""><?php echo $category['name']; ?></label>
                                    <div class="form-group pt-2">
                                     <?php foreach($totalCategory5 as $category5){ 
                                     array_push($secondCat,$category5['id']);
                                     ?>    
                                        <div class="form-check form-check-inline clear">
                                            <input class="form-check-input greencheck" type="checkbox" name="businessCategory[]" id="ck1_<?php echo $category5['id']; ?>" 
                                            value="<?php echo $category5['id']; ?>" <?php if(in_array($category5['id'], $allMainCategories)){ echo 'checked'; } ?>>
                                            <label class="form-check-label" for="<?php echo $category5['id']; ?>"><?php echo $category5['name']; ?></label>
                                        </div>
                                    <?php } ?>    
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
    
                            <?php 
                            $thirdCat=array();
                            foreach($secondCat as $category){ 
                            $totalCategory5 = $controller->getSubCategoryByParentID($category);
                            $catData = $controller->getCategoryByID($category);
                            if(in_array($category, $allMainCategories)){ $checkboxDisplay = "inline"; } else { $checkboxDisplay = "none"; } 
                            ?>
                            <div class="col-md-6" id="subCategoryCheckbox1<?php echo $category;?>" style="display:<?php echo $checkboxDisplay; ?>">
                                <div class="form-group">
                                    <label for=""><?php echo $catData->name; ?></label>
                                    <div class="form-group pt-2">
                                     <?php foreach($totalCategory5 as $category5){
                                     array_push($thirdCat,$category5['id']);
                                     ?>    
                                        <div class="form-check form-check-inline clear">
                                            <input class="form-check-input greencheck" type="checkbox" name="businessCategory[]" id="ck2_<?php echo $category5['id']; ?>" 
                                            value="<?php echo $category5['id']; ?>" <?php if(in_array($category5['id'], $allMainCategories)){ echo 'checked'; } ?>>
                                            <label class="form-check-label" for="<?php echo $category5['id']; ?>"><?php echo $category5['name']; ?></label>
                                        </div>
                                    <?php } ?>    
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
    
                            <?php 
                            foreach($thirdCat as $category){ 
                            $totalCategory5 = $controller->getSubCategoryByParentID($category);
                            $catData = $controller->getCategoryByID($category);
                            if(in_array($category, $allMainCategories)){ $checkboxDisplay = "inline"; } else { $checkboxDisplay = "none"; } 
                            ?>
                            <div class="col-md-6" id="subCategoryCheckbox2<?php echo $category;?>" style="display:<?php echo $checkboxDisplay; ?>">
                                <div class="form-group">
                                    <label for=""><?php echo $catData->name; ?></label>
                                    <div class="form-group pt-2">
                                     <?php foreach($totalCategory5 as $category5){
                                     array_push($secondCat,$category5['id']);
                                     ?>    
                                        <div class="form-check form-check-inline clear">
                                            <input class="form-check-input greencheck" type="checkbox" name="businessCategory[]" id="ck2_<?php echo $category5['id']; ?>" 
                                            value="<?php echo $category5['id']; ?>" <?php if(in_array($category5['id'], $allMainCategories)){ echo 'checked'; } ?>>
                                            <label class="form-check-label" for="<?php echo $category5['id']; ?>"><?php echo $category5['name']; ?></label>
                                        </div>
                                    <?php } ?>    
                                    </div>
                                </div>
                            </div>
                            <?php } ?>                            
                        </div>
                    </div>                
                </form>    
                </fieldset>          
            </div>        
    </div>  
</div>

<?php echo view('include/footer.php');?>
<script>

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
<?php foreach($secondCat as $category){ ?>        
    $('#ck1_<?php echo $category;?>').change(function(){
        if(this.checked){ 
            $('#subCategoryCheckbox1<?php echo $category;?>').show(300);
        }else{
            $('#subCategoryCheckbox1<?php echo $category;?>').hide(200);
            $("#subCategoryCheckbox1<?php echo $category;?>").find(":checkbox").prop("checked", false);
        }

    });
<?php } ?>   

<?php foreach($thirdCat as $category){ ?>        
    $('#ck2_<?php echo $category;?>').change(function(){
        if(this.checked){ 
            $('#subCategoryCheckbox2<?php echo $category;?>').show(300);
        }else{
            $('#subCategoryCheckbox2<?php echo $category;?>').hide(200);
            $("#subCategoryCheckbox2<?php echo $category;?>").find(":checkbox").prop("checked", false);
        }

    });
<?php } ?> 
});
</script>