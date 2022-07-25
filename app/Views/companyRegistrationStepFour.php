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
                    <li class="active" id="address">
                        <div class="dashoard_steps">
                            <div class="dash-step-number">2</div>
                            <div class="dash-step-name">
                                <div class="dash-step-icon"><img src="<?php echo site_url('public');?>/assets/frontend/images/pin-icon.svg" alt="Icon"></div>
                                <div class="dash-step-info">
                                    <h3>Address</h3> 
                                    <h5>In Progress</h5>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="active" id="payment">
                        <div class="dashoard_steps">
                            <div class="dash-step-number">3</div>
                            <div class="dash-step-name">
                                <div class="dash-step-icon"><img src="<?php echo site_url('public');?>/assets/frontend/images/bank-icon.svg" alt="Icon"></div>
                                <div class="dash-step-info">
                                    <h3>Bank Details</h3> 
                                    <h5>In Progress</h5>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php if($storeUserData->user_membership_type == '2'){ ?>
                    <li class="active" id="payment">
                        <div class="dashoard_steps">
                            <div class="dash-step-number">4</div>
                            <div class="dash-step-name">
                                <div class="dash-step-icon"><img src="<?php echo site_url('public');?>/assets/frontend/images/bank-icon.svg" alt="Icon"></div>
                                <div class="dash-step-info">
                                    <h3>Unit Creation</h3> 
                                    <h5>In Progress</h5>
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
                <form method="post" action="/companyRegistrationStepFourData" enctype="multipart/form-data" id="unitCreationForm">
                    <input type="submit" name="next" class="next action-button" value="Submit" />
                    <a type="button" name="previous" class="previous action-button-previous" href="/companyRegistration/3">Back</a>
                    <div class="dashboard_step_part">                        
                        <div class="dashboard_step_left">
                            <div class="dashboar_leftnum">
                                4
                            </div>
                            <h3>Unit Creation</h3>
                        </div>
                        <div class="dashboard_step_right">                            
                        </div>
                    </div>                    
                    <div class="dashboard_info_inner_section">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Unit Name <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Entry Unit Name" name="unit_name" value="<?php echo $companyDetail->unit_name;?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Unit Category <span class="red">*</span></label>
                                    <div class="form-group pt-2">
                                    <select class="form-control" name="unit_category" required>
                                        <option value="">Select Unit Category</option>
                                        <?php foreach($categoryUnitDetail as $company){ ?>
                                        <option value="<?php echo $company['id'];?>" 
                                        <?php if($companyDetail->unit_category == $company['id']){ echo 'selected'; } ?>><?php echo $company['name'];?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </div>
                            </div>                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Material Details </label>
                                </div>
                            </div>                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Type Of Material <span class="red">*</span> </label>
                                    <select class="form-control" name="typeOfMaterial[]" required>
                                        <option value="">Select Material</option>
                                        <?php foreach($materialDetail as $company){ ?>
                                        <option value="<?php echo $company['id'];?>" 
                                        <?php if($companyUnitDetails[0]->typeOfMaterial == $company['id']){ echo 'selected'; } ?>><?php echo $company['name'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Type Of Material Full Name <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Entry Material Full Name" name="materialFullName[]" value="<?=$companyUnitDetails[0]->materialFullName?>" onkeypress="return isCharacter(event)" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Monthly Capacity(MT) <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Monthly Capacity" name="monthlyCapicity[]" value="<?=$companyUnitDetails[0]->monthlyCapicity?>" required oninput="calculateAnnualCapacity(this.value,1)" onkeypress="return isNumber2(event)" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Annual Capacity <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Annual Capacity" name="annualCapicity[]"
                                    value="<?=$companyUnitDetails[0]->annualCapicity?>" required id="annualCapicity1" readonly>
                                </div>
                            </div>                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="form-control" name="typeOfMaterial[]" required>
                                        <option value="">Select Material</option>
                                        <?php foreach($materialDetail as $company){ ?>
                                        <option value="<?php echo $company['id'];?>" 
                                        <?php if($companyUnitDetails[1]->typeOfMaterial == $company['id']){ echo 'selected'; } ?>><?php echo $company['name'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Entry Material Full Name" name="materialFullName[]" value="<?=$companyUnitDetails[1]->materialFullName?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Monthly Capacity" name="monthlyCapicity[]" value="<?=$companyUnitDetails[1]->monthlyCapicity?>" required oninput="calculateAnnualCapacity(this.value,2)" onkeypress="return isNumber2(event)" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Annual Capacity" name="annualCapicity[]"
                                    value="<?=$companyUnitDetails[1]->annualCapicity?>" required id="annualCapicity2" readonly>
                                </div>
                            </div>

            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Consent to Operate </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Certificate No. <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Certificate Number" name="consent_cert_no" value="<?php echo $companyDetail->consent_cert_no;?>" required>
                                </div>
                            </div>
            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Valid From <span class="red">*</span> </label>
                                    <input class="form-control" type="date" placeholder="Entry Material Full Name" name="consent_valid_from" value="<?php echo $companyDetail->consent_valid_from;?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Valid Upto <span class="red">*</span> </label>
                                    <input class="form-control" type="date" placeholder="Monthly Capacity" name="consent_valid_upto" value="<?php echo $companyDetail->consent_valid_upto;?>" required>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php if($companyDetail->consent_document != ""){?>
                                        <img src="<?=base_url('writable/uploads/'.$companyDetail->consent_document)?>" style="width: 100px; height: 100px;"><br>
                                    <?php }?>
                                    <label for="">Upload <span class="red">*</span> </label>
                                    <input class="form-control" type="file" id="custom-input-file-4" placeholder="Choose file" name="consent_document" <?php if($companyDetail->consent_document != ""){ } else {?> required <?php } ?> accept="image/jpeg,image/jpg,image/png,image/gif,image/svg, application/pdf">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">PWM Certificate </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Certificate No. <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Certificate Number" name="pwm_cert_no" value="<?php echo $companyDetail->pwm_cert_no;?>" required>
                                </div>
                            </div>            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Valid From <span class="red">*</span> </label>
                                    <input class="form-control" type="date" placeholder="Entry Material Full Name" name="pwm_valid_from" value="<?php echo $companyDetail->pwm_valid_from;?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Valid Upto <span class="red">*</span> </label>
                                    <input class="form-control" type="date" placeholder="Monthly Capacity" name="pwm_valid_upto" value="<?php echo $companyDetail->pwm_valid_upto;?>" required>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php if($companyDetail->pwm_document != ""){?>
                                        <img src="<?=base_url('writable/uploads/'.$companyDetail->pwm_document)?>" style="width: 100px; height: 100px;"><br>
                                    <?php }?>
                                    <label for="">Upload <span class="red">*</span> </label>
                                    <input class="form-control" type="file" id="custom-input-file-4" placeholder="Choose file" name="pwm_document" <?php if($companyDetail->pwm_document != ""){ } else {?> required <?php } ?> accept="image/jpeg,image/jpg,image/png,image/gif,image/svg, application/pdf">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">CPCB/SPCB</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Certificate No. <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Certificate Number" name="cpcb_cert_no" value="<?php echo $companyDetail->cpcb_cert_no;?>" required>
                                </div>
                            </div>            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Valid From <span class="red">*</span> </label>
                                    <input class="form-control" type="date" placeholder="Entry Material Full Name" name="cpcb_valid_from" value="<?php echo $companyDetail->cpcb_valid_from;?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Valid Upto <span class="red">*</span> </label>
                                    <input class="form-control" type="date" placeholder="Monthly Capacity" name="cpcb_valid_upto" value="<?php echo $companyDetail->cpcb_valid_upto;?>" required>
                                </div>
                            </div>                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php if($companyDetail->cpcb_document != ""){?>
                                        <img src="<?=base_url('writable/uploads/'.$companyDetail->cpcb_document)?>" style="width: 100px; height: 100px;"><br>
                                    <?php }?>
                                    <label for="">Upload <span class="red">*</span> </label>
                                    <input class="form-control" type="file" id="custom-input-file-4" placeholder="Choose file" name="cpcb_document" <?php if($companyDetail->cpcb_document != ""){ } else {?> required <?php } ?> accept="image/jpeg,image/jpg,image/png,image/gif,image/svg, application/pdf">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Images & Videos of Plant</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <?php if($unitImages){ foreach($unitImages as $unitImage){?>
                                            <div class="col-md-3">
                                                <img src="<?=base_url('writable/uploads/'.$unitImage->unit_image)?>" class="img-thumbnail mb-3" style="width: 100%; height: 100px;">
                                            </div>
                                        <?php } }?>
                                    </div>
                                    <label for="">Plant Images(Max 5) <!-- <span class="red">*</span>  --></label>
                                    <input class="form-control" type="file" id="plant_images" placeholder="Choose file" name="plant_images[]" multiple accept="image/jpeg,image/jpg,image/png,image/gif,image/svg">
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <?php if($unitVideos){ foreach($unitVideos as $unitVideo){?>
                                            <div class="col-md-3">
                                                <img src="<?=base_url('writable/uploads/'.$unitVideo->unit_image)?>" class="img-thumbnail mb-3" style="width: 100%; height: 100px;">
                                            </div>
                                        <?php } }?>
                                    </div>
                                    <label for="">Plant Video <!-- <span class="red">*</span>  --></label>
                                    <input class="form-control" type="file" id="custom-input-file-4" placeholder="Choose file" name="plant_videos[]" multiple accept="video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Address</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">State <span class="red">*</span> </label>
                                    <select class="form-control" name="c_state" id="state" required>
                                        <option>Select state </option>
                                        <?php foreach($stateList as $state){ ?>
                                        <option value="<?php echo $state['state_id'];?>"
                                        <?php if($companyDetail->c_state == $state['state_id']){ echo 'selected'; } ?>><?php echo $state['state_title'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">District <span class="red">*</span> </label>
                                    <select class="form-control" name="c_district" id="district" required>
                                        <option>Select District </option>
                                        <?php foreach($districtList as $district){ ?>
                                        <option value="<?php echo $district['districtid'];?>"
                                        <?php if($companyDetail->c_district == $district['districtid']){ echo 'selected'; } ?>><?php echo $district['district_title'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">City </label>
                                    <select class="form-control" name="c_city" id="city">
                                        <option>Select city</option>
                                        <?php foreach($cityList as $city){ ?>
                                        <option value="<?php echo $city['id'];?>"
                                        <?php if($companyDetail->c_city == $city['id']){ echo 'selected'; } ?>><?php echo $city['name'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Pincode <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Enter Pincode" name="c_pincode" value="<?php echo $companyDetail->c_pincode;?>" required onkeypress="return isNumber(event)" maxlength="6" minlength="6">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Address <span class="red">*</span> </label>
                                    <textarea class="form-control" type="text" name="c_full_address" required><?php echo $companyDetail->c_full_address;?></textarea>
                                </div>
                            </div>
                            
                            
                            
                        </div>
                    </div>
          </form>
                </fieldset>
            </div>
        
    </div>  
</div>

<?php echo view('include/footer.php');?>
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
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    function calculateAnnualCapacity(val,counter){        
        //$('.monthlyCapicity').closest( ".annualCapicity" ).val( val*12 );
        var annualCapicity = val*12;
        $('#annualCapicity'+counter).val(annualCapicity.toFixed(2));
    }
    function isNumber2(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
<script>
$(document).ready(function(){ 
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
 
$("#unitCreationForm").submit(function(){
        var $fileUpload = $("#plant_images");
        if (parseInt($fileUpload.get(0).files.length)>5){
         alert("You can only upload a maximum of 5 Plant Images");
         return false;
        }
    });     

});
</script> 