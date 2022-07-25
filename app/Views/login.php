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
            <h2 class="greenheading">Login</h2>
            <?php if(isset($_SESSION['loginError'])){?>
            <p style="text-align: center;color: red;margin-top: 15px;"><?php echo $_SESSION['loginError'];?></p>
            <?php unset($_SESSION['loginError']); } ?>
            <?php if(isset($_SESSION['successMessage'])){?>
            <p style="text-align: center;color: green;margin-top: 15px;"><?php echo $_SESSION['successMessage'];?></p>
            <?php unset($_SESSION['successMessage']); } ?>
            <div class="form_section">
            <form action="storeLogin" method="POST" enctype="multipart/form-data"> 
                    <div class="form-group">
                        <label for="">Email Id <span class="red">*</span></label>
                        <input class="form-control" type="email" name="email" placeholder="Enter email address" required>
                    </div>
                    <div class="form-group">
                        <label for="">Password<span class="red">*</span></label>
                        <div class="input-group" id="show_hide_password">
                            <input class="form-control" type="password" id="password" name="password" placeholder="Enter Password" required>
                            <div class="input-group-addon" style="z-index: 999999;">
                                <i class="fa fa-eye" id="viewPassword" style="cursor:pointer;"></i>
                                <i class="fa fa-eye-slash" id="hidePassword" style="cursor:pointer;display:none"></i>
                            </div>
                        </div>
                    </div>
                    <div class="checkbox_forgot">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input greencheck" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Remember me</label>
                        </div>
                        <div class="form-group">
                            <a href="/forgotPassword" class="forgot_link">Forgot Password</a>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary green">Login</button>
                </form>
            </div>
            <div class="alreadymember bottomshow">
                <div class="alreadymemberlink">Not yet registered? <a href="register">Create an account</a></div>
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
  
<script type='text/javascript'>
        $(document).ready(function(){
            $('#viewPassword').click(function(){
                $('#password').attr('type', 'text');
                $('#viewPassword').css('display', 'none');
                $('#hidePassword').css('display', 'block');
            });
            $('#hidePassword').click(function(){
                $('#password').attr('type', 'password');
                $('#hidePassword').css('display', 'none');
                $('#viewPassword').css('display', 'block');
            });
        });
    </script>
</body>
</html>
        
    