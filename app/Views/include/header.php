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
<link rel="stylesheet" href="<?php echo site_url('public');?>/assets/frontend/css/jquery.simplefileinput.css">
<!-- Main Style -->   
<link href="<?php echo site_url('public');?>/assets/frontend/css/local.css" rel="stylesheet" media="screen">
<!-- Important Owl stylesheet -->
<link rel="stylesheet" href="<?php echo site_url('public');?>/assets/frontend/css/owl.carousel.css">
<!-- Responsive Style -->
<link href="<?php echo site_url('public');?>/assets/frontend/css/responsive.css" rel="stylesheet" media="screen">
<style>
#msform fieldset:not(:first-of-type) {
    display: none
}

</style>
</head>

<body class="afterlogin_dashboard">

<!-- Start Content Section ==================================================-->

<div class="dashboard_toppart">
    <div class="container-fluid">
        <div class="dashboar_logoleft">
            <img src="<?php echo site_url('public');?>/assets/frontend/images/logo.svg" alt="Logo" class="img-fluid">
        </div>
        <div class="dashboar_logoright" style="position: relative;float: right;margin-top: -73px;">
            <a href="<?php echo base_url('recycler/logout');?>" class="btn btn-danger"><i class="fa fa-sign-out"></i> Logout</a>
        </div>
