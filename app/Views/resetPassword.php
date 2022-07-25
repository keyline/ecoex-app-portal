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
            <h2 class="greenheading">Reset Password</h2>
            <?php if(isset($_SESSION['error'])){?>
            <p style="text-align: center;color: red;margin-top: 15px;"><?php echo $_SESSION['error'];?></p>
            <?php unset($_SESSION['error']); } ?>
            <div class="form_section">
            <form action="<?php echo site_url('resetPasswordData') ?>" method="POST">   
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
                    </div>
                    
                    <button type="submit" class="btn btn-primary green">Reset Password</button>
                </form>
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
        if(password != password1){
            alert("Password And Confirm Password Not Match!");     
            $("#password").val('');
            $("#cpassword").val('');
            $("#password").focus();
        }
    }
 });   
 $("#cpassword").blur(function(){     
    var password = $("#password").val();
    var password1 = $("#cpassword").val();
    if(password.length > 0){
        if(password != password1){
            alert("Password And Confirm Password Not Match!");
            $("#password").val('');
            $("#cpassword").val('');
            $("#password").focus();
        }
    }
 }); 
});
</script>




</body>
</html>

        

    

    