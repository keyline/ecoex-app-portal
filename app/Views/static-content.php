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
</head>
<body class="loginbody">    
    <!-- Start Content Section ==================================================-->
    <div class="loginmain_section">
        <div class="loginmain_leftimg"></div>
        <div class="rightdash_img">
            <div class="rightsection_form">
                <div class="toplogo"><img src="<?= base_url('inc/images/logo.svg') ?>" alt="Logo" class="img-fluid"></div>
                <h2 class="greenheading"><?=!empty($row)?$row->title:''?></h2>
                <!-- <p class="greenheading"><?=!empty($row)?$row->description:''?></p> -->
                <p>
                <object data="<?=base_url('writable/uploads/'.$row->content_file)?>" type="application/pdf" width="100%" height="500">                  
                </object>
                </p>
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
</body>
</html>
        
    
    