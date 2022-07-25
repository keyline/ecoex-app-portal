<?php
use App\Models\CommonModel;
$this->common_model = new CommonModel();
$site_setting       = $this->common_model->find_data('ecoex_setting', 'row');
?>
<!DOCTYPE html>
<html>
    <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title><?=$site_setting->websiteName?></title>
            <!-- Tell the browser to be responsive to screen width -->
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <!-- Font Awesome -->
            <link rel="stylesheet" href="<?php echo site_url('public');?>/assets/plugins/fontawesome-free/css/all.min.css">
            <!-- Ionicons -->
            <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
            <!-- Tempusdominus Bbootstrap 4 -->
            <!-- plugins -->
                <!-- iCheck -->
                <link rel="stylesheet" href="<?php echo site_url('public');?>/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
                <!-- JQVMap -->
                <link rel="stylesheet" href="<?php echo site_url('public');?>/assets/plugins/jqvmap/jqvmap.min.css">
                <!-- Select2 -->
                <link rel="stylesheet" href="<?php echo site_url('public');?>/assets/plugins/select2/css/select2.min.css">
                <link rel="stylesheet" href="<?php echo site_url('public');?>/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
                <!-- Toastr -->
                <link rel="stylesheet" href="<?php echo site_url('public');?>/assets/plugins/toastr/toastr.min.css">
                <!-- overlayScrollbars -->
                <link rel="stylesheet" href="<?php echo site_url('public');?>/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
                <!-- Daterange picker -->
                <link rel="stylesheet" href="<?php echo site_url('public');?>/assets/plugins/daterangepicker/daterangepicker.css">
                <!-- summernote -->
                <link rel="stylesheet" href="<?php echo site_url('public');?>/assets/plugins/summernote/summernote-bs4.css">
            <!-- plugins -->
            <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"> -->
            
            <!-- Theme style -->
            <!-- <link rel="stylesheet" href="<?php echo site_url('public');?>/assets/css/adminlte.min.css"> -->
            

            <!-- styles -->
                <!-- Important Owl stylesheet -->
                <link rel="stylesheet" href="<?php echo site_url('public/assets/newadmin/css/');?>owl.carousel.css">
                <link rel="stylesheet" media="screen" href="<?php echo site_url('public/assets/newadmin/css/');?>local.css">
                <link rel="stylesheet" href="<?php echo site_url('public/assets/newadmin/css/');?>responsive.css">

                <!-- <link rel="stylesheet" href="<?php echo site_url('public/assets/newadmin/css/');?>style.css"> -->
            <!-- styles -->
            

            <!-- Google Font: Source Sans Pro -->
            <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">          
            <link rel="shortcut icon" href="<?php echo site_url('');?>/inc/images/favicon.png">  
          
            <!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet"> -->
            <style type="text/css">
                .tree, .tree ul {
                    margin:0;
                    padding:0;
                    list-style:none
                }
                .tree ul {
                    margin-left:1em;
                    position:relative
                }
                .tree ul ul {
                    margin-left:.5em
                }
                .tree ul:before {
                    content:"";
                    display:block;
                    width:0;
                    position:absolute;
                    top:0;
                    bottom:0;
                    left:0;
                    border-left:1px solid
                }
                .tree li {
                    margin:0;
                    padding:0 1em;
                    line-height:2em;
                    color:var(--primariygreen)!important;
                    font-weight:700;
                    position:relative
                }
                .tree ul li:before {
                    content:"";
                    display:block;
                    width:10px;
                    height:0;
                    border-top:1px solid;
                    margin-top:-1px;
                    position:absolute;
                    top:1em;
                    left:0
                }
                .tree ul li:last-child:before {
                    background:#fff;
                    height:auto;
                    top:1em;
                    bottom:0
                }
                .indicator {
                    margin-right:5px;
                }
                .tree li a {
                    text-decoration: none;
                    color:var(--primariygreen)!important;
                }
                .tree li button, .tree li button:active, .tree li button:focus {
                    text-decoration: none;
                    color:var(--primariygreen)!important;
                    border:none;
                    background:transparent;
                    margin:0px 0px 0px 0px;
                    padding:0px 0px 0px 0px;
                    outline: 0;
                }
                .page-item.active .page-link {
                    z-index: 3;
                    color: #fff;
                    background-color: #28a745;
                    border-color: #28a745;
                }
            </style>
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=G-9QBKZBPFSG"></script>
            <script>
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());

              gtag('config', 'G-9QBKZBPFSG');
            </script>
    </head>
<body>