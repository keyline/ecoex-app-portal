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
                <form method="post" action="/companyRegistrationStepThreeData" enctype="multipart/form-data">
                    <input type="submit" name="next" class="next action-button" value="Submit" />
                    <a type="button" name="previous" class="previous action-button-previous" href="/companyRegistration/2">Back</a>
                    <div class="dashboard_step_part">
                        
                        <div class="dashboard_step_left">
                            <div class="dashboar_leftnum">
                                3
                            </div>
                            <h3>Bank Details</h3>
                        </div>
                        <div class="dashboard_step_right">
                            
                        </div>
                    </div>
                    
                    <div class="dashboard_info_inner_section">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Account Type <span class="red">*</span></label>
                                    <div class="form-group pt-2">
                                        <div class="form-check form-check-inline clear">
                                            <input class="form-check-input" type="radio" name="accountType" id="inlineRadio1" value="current"
                                            <?php if($companyDetail->c_account_type == "current"){ echo 'checked'; } ?> required>
                                            <label class="form-check-label" for="inlineRadio1">Current</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="accountType" id="inlineRadio2" value="saving"
                                            <?php if($companyDetail->c_account_type == "saving"){ echo 'checked'; } ?> required>
                                            <label class="form-check-label" for="inlineRadio2">Savings</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Bank Name <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Entry Bank Name" name="bankName" value="<?php echo $companyDetail->c_bank_name;?>" onkeypress="return isCharacter(event)" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Account Number <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Entry Account Number" name="accountNo" 
                                    value="<?php echo $companyDetail->accountNo;?>" onkeypress="return isNumber(event)" required>
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Branch Name <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Entry Branch Name" name="branchName" value="<?php echo $companyDetail->c_branch_name;?>" onkeypress="return isCharacter(event)" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Account Holder Name <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Entry Account Holder Name" name="accountHolder"
                                    value="<?php echo $companyDetail->c_acct_holder_name;?>" onkeypress="return isCharacter(event)" required>
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php if($companyDetail->c_cancelled_cheque != ""){?>
                                        <img src="<?=base_url('writable/uploads/'.$companyDetail->c_cancelled_cheque)?>" style="width: 100px; height: 100px;"><br>
                                    <?php }?>
                                    <label for="">Cancelled Cheque <span class="red">*</span> </label>
                                    <input class="form-control" type="file" id="custom-input-file-4" placeholder="Entry GST Number" name="cancllledCheque" 
                                    <?php if($companyDetail->c_cancelled_cheque != ""){ } else {?> required <?php } ?> accept="image/jpeg,image/jpg,image/png,image/gif,image/svg">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">IFSC Code <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Entry IFSC Code" name="mtcrCode" value="<?php echo $companyDetail->c_micr_code;?>" required>
                                </div>
                            </div>
                            
                        </div>
                    </div>
          </form>
                </fieldset>
            </div>
        
    </div>  
</div>
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
</script>
<?php echo view('include/footer.php');?>