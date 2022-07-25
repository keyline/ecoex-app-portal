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
    body,html {
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
}
</style>
</head>

<body class="loginbody">
<!-- Start Content Section ==================================================-->


<div class="loginmain_section">
    <div class="loginmain_leftimg"></div>
    <div class="rightdash_img">
        <div class="rightsection_form loginfrom_center">
            <div class="toplogo"><img src="<?= base_url('inc/images/logo.svg') ?>" alt="Logo" class="img-fluid"></div>
            <h2 class="greenheading">Email Verification</h2>
            <h3 class="otpmoble_send">Click on the verification link sent on <?php echo $mobileNo;?> to verify your account.</h3>
            <h3 class="otpmoble_send"><a class="btn btn-default" href="<?=base_url('login')?>">Login</a></h3>            
            <div class="form_section">
                <div class="form-group" id="timerSecond">
                    <p class="resendcode text-right pt-3">Resend code in <span id="time">60</span> Seconds</h3>
                </div>
                <div class="form-group" id="resendOTP" style="display:none;">
                    <a class="text-right pt-3" href="<?php echo site_url('resendEmail/'.$companyID) ?>" style="font-size: 20px;color: #48974e;float: right;">Resend code</a>
                </div>
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
var counter = 60;
var interval = setInterval(function() {
    counter--;
    // Display 'counter' wherever you want to display it.
    if (counter <= 0) {
     		clearInterval(interval);
      	$('#timer').html("<h3>Count down complete</h3>");  
      	$('#timerSecond').css("display","none"); 
      	$('#resendOTP').css("display","block");
        return;
    }else{
    	$('#time').text(counter);
      console.log("Timer --> " + counter);
    }
}, 1000);
</script> 
</body>
</html>


    