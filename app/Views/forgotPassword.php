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
            <div class="toplogo"><img src="<?= base_url('inc/images/logo.svg'); ?>" alt="Logo" class="img-fluid"></div>
            <h2 class="greenheading">Forgot Password</h2>
            <?php if(isset($_SESSION['forgotPassMessage'])){?>
            <p style="text-align: center;color: green;margin-top: 15px;"><?php echo $_SESSION['forgotPassMessage'];?></p>
            <?php unset($_SESSION['forgotPassMessage']); } ?>
            <?php if(isset($_SESSION['forgotPassError'])){?>
            <p style="text-align: center;color: red;margin-top: 15px;"><?php echo $_SESSION['forgotPassError'];?></p>
            <?php unset($_SESSION['forgotPassError']); } ?>
            <div class="form_section">
            <form action="forgotPasswordMobileStep" method="POST" enctype="multipart/form-data"> 
                    <div class="form-group">
                        <label for="">Enter Registered Email Id <span class="red">*</span></label>
                        <input class="form-control" type="email" name="email" placeholder="Enter Registered Email Id" required>
                    </div>
                    <button type="submit" class="btn btn-primary green">Next</button>
                </form>
            </div>

            <div class="alreadymember bottomshow">
                <div class="alreadymemberlink"><a href="login">Click here for Login</a></div>
            </div>
        </div>
    </div>
</div>

<!-- End Content Section ==================================================-->
<!-- ======================= JQuery libs =========================== -->
<!-- Main jQuery --> 
<script src="js/jquery-min.js"></script>
<!-- Carousel -->
<script src="js/owl.carousel.js"></script>
<!-- Bootstrap -->
<script src="js/bootstrap.bundle.min.js"></script>
<!-- ======================= End JQuery libs =========================== -->

<script src="js/custom.js"></script>
  



</body>
</html>

        

    