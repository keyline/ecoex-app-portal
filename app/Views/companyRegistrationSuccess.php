<?php 
echo view('include/header.php');
?>
        <form>
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
                    <li class="active" id="payment">
                        <div class="dashoard_steps">
                            <div class="dash-step-number">5</div>
                            <div class="dash-step-name">
                                <div class="dash-step-icon"><img src="<?php echo site_url('public');?>/assets/frontend/images/bank-icon.svg" alt="Icon"></div>
                                <div class="dash-step-info">
                                    <h3>Complete Registration</h3> 
                                    <h5>In Progress</h5>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php } else {?>
                    <li class="active" id="payment">
                        <div class="dashoard_steps">
                            <div class="dash-step-number">4</div>
                            <div class="dash-step-name">
                                <div class="dash-step-icon"><img src="<?php echo site_url('public');?>/assets/frontend/images/bank-icon.svg" alt="Icon"></div>
                                <div class="dash-step-info">
                                    <h3>Complete Registration</h3> 
                                    <h5>In Progress</h5>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php } ?>
                </ul>          
            </div>
            <div class="dashboard_inner_section">
                <fieldset>
                    <div class="dashboard_info_inner_section mt-5 pt-5">
                        <div class="form-card">
                            <h2 class="fs-title text-center">Success !</h2>
                            <div class="row justify-content-center">
                                <div class="col-md-12 text-center"> <img src="https://img.icons8.com/color/96/000000/ok--v2.png" class="fit-image"> </div>
                            </div> 
                            <div class="row justify-content-center">
                                <div class="col-7 text-center">
                                    <h5>You Have Successfully Create Account</h5>
                                    <h5>The account is pending for approval.</h5>
                                    
                                    <!-- <div class="alreadymember bottomshow">
                                        <div class="alreadymemberlink">Click here to <a href="<?php echo site_url('login') ?>">Login</a></div>
                                    </div> -->
                                </div>                                
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
          </form>
        
    </div>  
</div>

<?php echo view('include/footer.php');?>