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
                <form method="post" action="/companyRegistrationStepTwoData" enctype="multipart/form-data">
                    <input type="submit" name="next" class="next action-button" value="Save and Continue" />
                    <a type="button" name="previous" class="previous action-button-previous" href="/companyRegistration/1">Back</a>
                    
                    <div class="dashboard_step_part">
                        
                        <div class="dashboard_step_left">
                            <div class="dashboar_leftnum">
                                2
                            </div>
                            <h3>Address</h3>
                        </div>
                        <div class="dashboard_step_right">
                            
                        </div>
                    </div>
                    
                    <div class="dashboard_info_inner_section">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Country <span class="red">*</span> </label>
                                    <select class="form-control" name="country" required>
                                        <option value="1">India</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">State <span class="red">*</span> </label>
                                    <select class="form-control" name="state" id="state" required>
                                        <option>Select state </option>
                                        <?php foreach($stateList as $state){ ?>
                                        <option value="<?php echo $state['state_id'];?>"
                                        <?php if($companyDetail->c_state == $state['state_id']){ echo 'selected'; } ?>><?php echo $state['state_title'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">District <span class="red">*</span> </label>
                                    <select class="form-control" name="district" id="district" required>
                                        <option>Select District </option>
                                        <?php foreach($districtList as $district){ ?>
                                        <option value="<?php echo $district['districtid'];?>"
                                        <?php if($companyDetail->c_district == $district['districtid']){ echo 'selected'; } ?>><?php echo $district['district_title'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">City </label>
                                    <select class="form-control" name="city" id="city">
                                        <option>Select city</option>
                                        <?php foreach($cityList as $city){ ?>
                                        <option value="<?php echo $city['id'];?>"
                                        <?php if($companyDetail->c_city == $city['id']){ echo 'selected'; } ?>><?php echo $city['name'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Pincode <span class="red">*</span></label>
                                    <input class="form-control" type="text" name="pincode" placeholder="Entry Pincode" value="<?php echo $companyDetail->c_pincode;?>" onkeypress="return isNumber(event)" maxlength="6" minlength="6" required>
                                </div>
                            </div>
            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Address <span class="red">*</span> </label>
                                    <textarea placeholder="Entry Address" name="address" class="form-control" required><?php echo $companyDetail->c_full_address;?></textarea>
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
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
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

});
</script> 