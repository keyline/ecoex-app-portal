<!doctype html>
<html>
<head>
<!-- Meta Tag -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Title -->
<title>Ecoex Portal</title>
 <!-- Favicons -->
<link rel="shortcut icon" href="<?= base_url('inc/images/favicon.png'); ?>">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" media="screen">
<!-- Main Style -->   
<link href="<?= base_url('inc/css/local.css'); ?>" rel="stylesheet" media="screen">
<!-- Important Owl stylesheet -->
<link rel="stylesheet" href="css/owl.carousel.css">
<!-- Responsive Style -->
<link href="<?= base_url('inc/css/responsive.css'); ?>" rel="stylesheet" media="screen">
<style>
    /* body,html {
    height:100%;
    min-height: 100%;
    width: 100%;
    margin: 0 0;
    display: flex;
    align-items: flex-start;
    justify-content: flex-start
}
@media (max-width: 1024px) {
    body, html {
        height: 100%;
    }
} */
</style>
</head>
<body class="loginbody">
    
<!-- Start Content Section ==================================================-->
<div class="loginmain_section">
    <div class="loginmain_leftimg"></div>
    <div class="rightdash_img">
        <div class="rightsection_form">
            <div class="toplogo"><img src="<?= base_url('inc/images/logo.svg') ?>" alt="Logo" class="img-fluid"></div>
            <h2 class="greenheading">Registration</h2>
            <?php if(isset($_SESSION['error'])){?>
            <p style="text-align: center;color: red;margin-top: 15px;"><?php echo $_SESSION['error'];?></p>
            <?php unset($_SESSION['error']); } ?>
            <div class="form_section">
            <form action="<?php echo site_url('storeCompanyDetails') ?>" method="POST" enctype="multipart/form-data" id="companyDetailForm">   
                    <div class="form-group">
                        <label for="">Company Name </label>  
                        <input type="text" class="form-control" id="c_id" name="c_name" value="<?php echo $companyName; ?>"  readonly>
                        <input type="hidden" class="form-control" id="c_id" name="c_id" value="<?php echo $companyID; ?>"  readonly>
                        <!-- <input class="form-control" type="text" placeholder="Ecoex Portal" readonly> -->
                    </div>
                    <div class="form-group">
                        <label for="">Email Id <span class="red">*</span></label>
                        <input class="form-control" type="email" name="email" id="email" placeholder="Enter email address" value="<?php echo $companyEmail; ?>" required autofill="off">
                        <span class="text-success" id="email-succ" style="display:none;font-weight: bold;"><i class="fa fa-check-circle"></i></span>
                        <span class="text-danger" id="email-err" style="display:none;font-weight: bold;"><i class="fa fa-times-circle"></i></span>
                    </div>
                    <div class="form-group">
                        <label for="">Mobile No. <span class="red">*</span></label>
                        <input class="form-control" type="text" name="mobile" id="mobileNo" placeholder="Enter mobile no." value="<?php echo $companyMobile; ?>" pattern="[0-9]{10}" maxlength="10" required onkeypress="return isNumber(event)">
                        <span class="text-success" id="mobile-succ" style="display:none;font-weight: bold;"><i class="fa fa-check-circle"></i> </span>
                        <span class="text-danger" id="mobile-err" style="display:none;font-weight: bold;"><i class="fa fa-times-circle"></i> </span>
                        <p><small>Format: 9876543210</small></p>
                    </div>
                    <div class="form-group">
                        <label for="">Member Type <span class="red">*</span></label>
                        <select class="form-control" id="member_id" name="member_id" required>
                            <option value="">Select</option>
                            <?php
                            foreach ($membertype as $row) {
                            ?>
                                <option value="<?php echo $row['member_id'] ?>" 
                                <?php if($companyMemberType == $row['member_id']){ echo 'selected'; } ?>><?php echo $row['member_type'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group" id="sub_member_type" style="display: none;">
                        <label for="">Sub Member Type <span class="red">*</span></label>
                        <div class="form-group form-check">
                            <input type="checkbox" name="user_sub_member_type[]" class="form-check-input greencheck myCB" id="user_sub_member_type1" value="Producer">
                            <label class="form-check-label" for="user_sub_member_type1">Producer</label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" name="user_sub_member_type[]" class="form-check-input greencheck myCB" id="user_sub_member_type2" value="Importer">
                            <label class="form-check-label" for="user_sub_member_type2">Importer</label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" name="user_sub_member_type[]" class="form-check-input greencheck myCB" id="user_sub_member_type3" value="Brand Owner">
                            <label class="form-check-label" for="user_sub_member_type3">Brand Owner</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Password<span class="red">*</span></label>
                        <div class="input-group" id="show_hide_password">
                            <input class="form-control" type="password" name="password" id="password" required>
                          </div>
                    </div>
                    <div class="form-group">
                        <label for="">Confirm Password<span class="red">*</span></label>
                        <div class="input-group" id="show_hide_password" >
                            <input class="form-control" type="password" name="confirm_password" id="cpassword"required>                            
                        </div>
                        <span class="text-success" id="pwd-succ" style="display:none;font-weight: bold;"><i class="fa fa-check-circle"></i></span>
                        <span class="text-danger" id="pwd-err" style="display:none;font-weight: bold;"><i class="fa fa-times-circle"></i></span>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input greencheck" id="exampleCheck1" required>
                        <label class="form-check-label" for="exampleCheck1">By registration, you agree to ECOEX,s <a href="<?=base_url('page/terms-conditions')?>" target="_blank">Terms & Conditions</a></label>
                    </div>
                    <!-- <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input greencheck" id="exampleCheck2" required>
                        <label class="form-check-label" for="exampleCheck2">Lorem ipsum dolor sit amet, ECOEX,s Membership undertaking</label>
                    </div> -->
                    <button type="submit" class="btn btn-primary green">Register</button>
                </form>
            </div>
            <div class="alreadymember">
                <div class="alreadymemberlink">Already a member? <a href="<?php echo site_url('') ?>">Login</a></div>
            </div>
        </div>
    </div>
</div>
<!-- End Content Section ==================================================-->
<!-- ======================= JQuery libs =========================== -->
    <!-- Main jQuery -->
    <script src="<?= base_url('inc/js/jquery-min.js'); ?>"></script>
    <!-- Carousel -->
    <script src="<?= base_url('inc/js/owl.carousel.js'); ?>"></script>
    <!-- Bootstrap -->
    <script src="<?= base_url('inc/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- ======================= End JQuery libs =========================== -->
    <script src="<?= base_url('inc/js/custom.js'); ?>"></script>
    
<script>
$(document).ready(function(){
    $("#password").blur(function(){     
        var password = $("#password").val();
        var password1 = $("#cpassword").val();
        if(password1.length > 0){
            if(password == password1){                
                $('#pwd-succ').show();
                $('#pwd-succ').html('<i class="fa fa-check-circle"></i> Password And Confirm Password Matched !!!');
                $('#pwd-err').hide();
                $("#password").focus();
            } else {
                $('#password').val('');
                $('#cpassword').val('');
                $("#password").focus();
                $('#pwd-err').show();
                $('#pwd-err').html('<i class="fa fa-times-circle"></i> Password And Confirm Password Not Matched !!!');
                $('#pwd-succ').hide();
            }
        }
    });   
    $("#cpassword").blur(function(){     
        var password = $("#password").val();
        var password1 = $("#cpassword").val();
        if(password.length > 0){
            if(password == password1){                
                $('#pwd-succ').show();
                $('#pwd-succ').html('<i class="fa fa-check-circle"></i> Password And Confirm Password Matched !!!');
                $('#pwd-err').hide();
                $("#password").focus();
            } else {
                $('#password').val('');
                $('#cpassword').val('');
                $("#password").focus();
                $('#pwd-err').show();
                $('#pwd-err').html('<i class="fa fa-times-circle"></i> Password And Confirm Password Not Matched !!!');
                $('#pwd-succ').hide();
            }
        }
    });
    $('#member_id').on('change', function(){
        var member_id = $('#member_id').val();
        if(member_id == 1){
            $('#sub_member_type').show();
            $("input[name=user_sub_member_type[]]").attr("required", true);
        } else {
            $('#sub_member_type').hide();
            $("input[name=user_sub_member_type[]]").attr("required", false);
        }
    });
    $('#email').on('blur', function(){
        let email = $('#email').val();
        if(email != ''){
            let baseUrl = '<?=base_url()?>';
            $.ajax({
                type: "POST",
                data: { email: email },
                url: baseUrl+"/checkEmail",
                dataType: "JSON",
                success: function(res){
                    if(res.status){
                        $('#email-succ').show();
                        $('#email-succ').html('<i class="fa fa-check-circle"></i> '+res.message);
                        $('#email-err').hide();
                    } else {
                        $('#email').val('');
                        $('#email-err').show();
                        $('#email-err').html('<i class="fa fa-times-circle"></i> '+res.message);
                        $('#email-succ').hide();
                    }
                }
            });
        } else {
            $('#email').val('');
            $('#email-err').show();
            $('#email-err').html('<i class="fa fa-times-circle"></i> Please Enter Email Address !!!');
            $('#email-succ').hide();
        }        
    })
    $('#mobileNo').on('blur', function(){
        let mobile = $('#mobileNo').val();
        if(mobile != ''){
            let baseUrl = '<?=base_url()?>';
            $.ajax({
                type: "POST",
                data: { mobile: mobile },
                url: baseUrl+"/checkMobile",
                dataType: "JSON",
                success: function(res){
                    if(res.status){
                        $('#mobile-succ').show();
                        $('#mobile-succ').html('<i class="fa fa-check-circle"></i> '+res.message);
                        $('#mobile-err').hide();
                    } else {
                        $('#mobileNo').val('');
                        $('#mobile-err').show();
                        $('#mobile-err').html('<i class="fa fa-times-circle"></i> '+res.message);
                        $('#mobile-succ').hide();
                    }
                }
            });
        } else {
            $('#mobile').val('');
            $('#mobile-err').show();
            $('#mobile-err').html('<i class="fa fa-times-circle"></i> Please Enter Mobile Number !!!');
            $('#mobile-succ').hide();
        }        
    })
});

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
</script>
</body>
</html>
        
    
    