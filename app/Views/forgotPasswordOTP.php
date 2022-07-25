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
            <h2 class="greenheading">OTP Verification</h2>
            <h3 class="otpmoble_send">Please enter the verification code we sent to<br>Mobile Number <?php echo $mobileNo;?></h3>
            <?php if(isset($_SESSION['otpError'])){ ?>
                    <p style="color: red;text-align: center;font-size: 18px;"><?php echo $_SESSION['otpError'];?></p>
            <?php unset($_SESSION['otpError']); } ?>
            <div class="form_section">
                <form method="post" action="<?php echo site_url('forgotPasswordOTPVerify') ?>">
                    <input type="hidden" class="form-control" id="mobileNo" name="mobileNo" value="<?php echo $mobileNo; ?>" >
                    <div class="otpinputbox d-flex flex-wrap flex-row justify-content-center mt-2 digit-group">
                        <input type="text" class="m-4 text-center form-control rounded" id="digit-1" name="digit1" data-next="digit-2" autocomplete="off" required/>
                        <input type="text" class="m-4 text-center form-control rounded" id="digit-2" name="digit2" data-next="digit-3" data-previous="digit-1" autocomplete="off" required/>
                        <input type="text" class="m-4 text-center form-control rounded" id="digit-3" name="digit3" data-next="digit-4" data-previous="digit-2" autocomplete="off" required/>
                        <input type="text" class="m-4 text-center form-control rounded" id="digit-4" name="digit4" data-next="digit-5" data-previous="digit-3" autocomplete="off" required/>
                        <input type="text" class="m-4 text-center form-control rounded" id="digit-5" name="digit5" data-next="digit-6" data-previous="digit-4" autocomplete="off" required/>
                        <input type="text" class="m-4 text-center form-control rounded" id="digit-6" name="digit6" data-previous="digit-5" autocomplete="off" required/>
                    </div>
                    
                    <button type="submit" class="btn btn-primary green mt-4">Submit</button>
                    <div class="form-group" id="timerSecond">
                        <p class="resendcode text-right pt-3">Resend code in <span id="time">60</span> Seconds</p>
                    </div>
                    <div class="form-group">
                        <a class="text-left" href="<?php echo site_url('resetPassword') ?>" style="font-size: 20px;color: #48974e;float: left;">Skip For Now</a>
                    </div>
                    <div class="form-group" id="resendOTP" style="display:none;">
                        <a class="text-right pt-3" href="<?php echo site_url('resendForgotOTP/') ?>" style="font-size: 20px;color: #48974e;float: right;">Resend code</a>
                    </div>
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
var counter = 60;
var interval = setInterval(function() {
    counter--;
    // Display 'counter' wherever you want to display it.
    if (counter <= 0) {
     		clearInterval(interval);
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


    