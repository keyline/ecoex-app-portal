<?php
$session = \Config\Services::session($config);
$userId = $session->get('brandUserId');
use App\Models\CommonModel;
$this->common_model     = new CommonModel();
$userData = $this->common_model->find_data('ecoex_user_table', 'row', ['user_id' => $userId]);
if($userData){  
  $memberType = $this->common_model->find_data('ecoex_member_category', 'row', ['member_id' => $userData->user_membership_type]);
  if($memberType){
    $memberTypeName = $memberType->member_type;
  } else {
    $memberTypeName = 'Collector';
  }
} else {
  $memberTypeName = 'Collector';
}
$site_setting       = $this->common_model->find_data('ecoex_setting', 'row');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?=$site_setting->websiteName?></title>

	<!-- General CSS Files -->
	<link rel="shortcut icon" href="<?php echo site_url('public');?>/assets/client/images/favicon.png">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

	<!-- Important Owl stylesheet -->
	<link rel="stylesheet" href="<?php echo site_url('public');?>/assets/client/css/owl.carousel.css">
    
  <!-- Important toggle button stylesheet -->
	<link rel="stylesheet" href="<?php echo site_url('public');?>/assets/client/css/segment.css">

	<!-- Main Style -->   
  <link href="<?php echo site_url('public');?>/assets/client/css/custom.css" rel="stylesheet" media="screen">
	<link href="<?php echo site_url('public');?>/assets/client/css/local.css" rel="stylesheet" media="screen">
  <!--<link href="css/style.css" rel="stylesheet" media="screen">-->
  <!--<link href="css/components.css" rel="stylesheet" media="screen">-->
  <link href="<?php echo site_url('public');?>/assets/client/css/responsive.css" rel="stylesheet" media="screen">
  <link rel="stylesheet" href="<?php echo site_url('public');?>/assets/jquery.loading.css">
  <link rel="stylesheet" href="<?php echo site_url('public');?>/assets/sweetalert2.min.css">
  <style type="text/css">
    /* TOGGLE STYLING */
    .toggle {
      margin: 0 0 1.5rem;
      box-sizing: border-box;
      font-size: 0;
      display: flex;
      flex-flow: row nowrap;
      justify-content: flex-start;
      align-items: stretch;
    }
    .toggle input {
      width: 0;
      height: 0;
      position: absolute;
      left: -9999px;
    }
    .toggle input + label {
      margin: 0;
      padding: 0.75rem 2rem;
      box-sizing: border-box;
      position: relative;
      display: inline-block;
      border: solid 1px #DDD;
      background-color: #FFF;
      font-size: 1rem;
      line-height: 140%;
      font-weight: 600;
      text-align: center;
      box-shadow: 0 0 0 rgba(255, 255, 255, 0);
      transition: border-color 0.15s ease-out, color 0.25s ease-out, background-color 0.15s ease-out, box-shadow 0.15s ease-out;
      /* ADD THESE PROPERTIES TO SWITCH FROM AUTO WIDTH TO FULL WIDTH */
      /*flex: 0 0 50%; display: flex; justify-content: center; align-items: center;*/
      /* ----- */
    }
    .toggle input + label:first-of-type {
      border-radius: 6px 0 0 6px;
      border-right: none;
    }
    .toggle input + label:last-of-type {
      border-radius: 0 6px 6px 0;
      border-left: none;
    }
    .toggle input:hover + label {
      border-color: #213140;
    }
    .toggle input:checked + label {
      background-color: #48974e;
      color: #FFF;
      box-shadow: 0 0 10px rgba(102, 179, 251, 0.5);
      border-color: #48974e;
      z-index: 1;
    }
    .toggle input:focus + label {
      outline: dotted 1px #CCC;
      outline-offset: 0.45rem;
    }
    @media (max-width: 800px) {
      .toggle input + label {
        padding: 0.75rem 0.25rem;
        flex: 0 0 50%;
        display: flex;
        justify-content: center;
        align-items: center;
      }
    }

    /* STYLING FOR THE STATUS HELPER TEXT FOR THE DEMO */
    .status {
      margin: 0;
      font-size: 1rem;
      font-weight: 400;
    }
    .status span {
      font-weight: 600;
      color: #B6985A;
    }
    .status span:first-of-type {
      display: inline;
    }
    .status span:last-of-type {
      display: none;
    }
    @media (max-width: 800px) {
      .status span:first-of-type {
        display: none;
      }
      .status span:last-of-type {
        display: inline;
      }
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
  <div class="wrapper-page">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar clientdash-navbar">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fa fa-bars"></i></a></li>
            <li><div class="d-sm-none d-lg-inline-block"><h3><i class="fa fa-store"></i> <?=$memberTypeName?></div></h3></li>
          </ul>
        </div>
        
        <ul class="navbar-nav navbar-right align-items-center">          
          <li class="dropdown dropdown-list-toggle"><!-- <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"><i class="fa fa-envelope"></i></a> -->
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Messages
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-message">
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <div class="dropdown-item-avatar">
                    <div class="is-online"></div>
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Kusnaedi</b>
                    <p>Hello, Bro!</p>
                    <div class="time">10 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <div class="dropdown-item-avatar">
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Dedik Sugiharto</b>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                    <div class="time">12 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="../assets/img/avatar/avatar-3.png" class="rounded-circle">
                    <div class="is-online"></div>
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Agung Ardiansyah</b>
                    <p>Sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <div class="time">12 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="../assets/img/avatar/avatar-4.png" class="rounded-circle">
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Ardian Rahardiansyah</b>
                    <p>Duis aute irure dolor in reprehenderit in voluptate velit ess</p>
                    <div class="time">16 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="../assets/img/avatar/avatar-5.png" class="rounded-circle">
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Alfa Zulkarnain</b>
                    <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                    <div class="time">Yesterday</div>
                  </div>
                </a>
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fa fa-chevron-right"></i></a>
              </div>
            </div>
          </li>
          <li class="dropdown dropdown-list-toggle">
            <!-- <a href="javascript:void(0)" onclick="opennotifilterNav()" class="nav-link notification-toggle nav-link-lg beep"><i class="fa fa-bell"></i></a> -->
          </li>
          <li class="dropdown dropdown-list-toggle">
            <h5><a href="<?=base_url()?>" target="_blank" class="nav-link notification-toggle nav-link-lg beep" style="color: var(--primariygreen);"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Visit Marketplace</a></h5>
          </li>
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <div class="d-sm-none d-lg-inline-block">Hi, <?php echo $userData->user_name;?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="<?=base_url('brand/profile-settings')?>" class="dropdown-item has-icon">
                <i class="fa fa-user"></i> Profile Setting
              </a>
              <a href="<?=base_url('brand/change-password')?>" class="dropdown-item has-icon">
                <i class="fa fa-cog"></i> Change Password
              </a>
              <!-- <a href="features-activities.html" class="dropdown-item has-icon">
                <i class="fa fa-bolt"></i> Activities
              </a> -->
              <div class="dropdown-divider"></div>
              <a href="<?php echo base_url('recycler/logout');?>" class="dropdown-item has-icon text-danger">
                <i class="fa fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
<?php 
  $currentURL = explode('/',$_SERVER['REQUEST_URI']);
  $currentContorller = $currentURL['2'];
?>      
      <div class="main-sidebar clientdash_mainsidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand pt-3 mb-3">
            <a href="#"><img src="<?php echo site_url('');?>/writable/uploads/<?=$site_setting->logo?>" alt="<?=$site_setting->websiteName?>"></a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm pt-2 mb-5">
            <a href="#"><img src="<?php echo site_url('public');?>/assets/client/images/logo-icon.png" alt="<?=$site_setting->websiteName?>"></a>
          </div>
          <ul class="sidebar-menu">
              <li class="nav-item <?php if($currentContorller == ''){ echo 'active'; } ?>">
                <a href="<?php echo base_url('brand/');?>" class="nav-link"><i class="fa fa-fire"></i><span>Dashboard</span></a>
              </li>
              <?php if($userData){ if(($userData->user_email_auth)){?>
                <li class="nav-item <?php if($currentContorller == 'targetList'){ echo 'active'; } ?>">
                  <a href="<?php echo base_url('brand/targetList');?>" class="nav-link"><i class="fa fa-chart-bar"></i><span>Targets</span></a>
                </li>
                <!-- <li class="nav-item <?php if($currentContorller == 'manageInquiries'){ echo 'active'; } ?>">
                  <a href="<?php echo base_url('brand/manageInquiries');?>" class="nav-link"><i class="fa fa-question"></i><span>Internal Inquiry</span></a>
                </li> -->
                <li class="nav-item <?php if($currentContorller == 'inquiryList' || $currentContorller == 'editInquiry'){ echo 'active'; } ?>">
                  <a href="<?php echo base_url('brand/inquiryList');?>" class="nav-link"><i class="fa fa-question"></i><span>Manage Inquiries</span></a>
                </li>
              <?php } }?>
              <!-- <li class="nav-item dropdown <?php if($currentContorller == 'marketplace'){ echo 'active'; } ?>">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa fa-store-alt"></i> <span>Marketplace</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="<?php echo base_url('brand/marketplace');?>">Plastic</a></li>
                  <li><a class="nav-link" href="<?php echo base_url('brand/marketplace');?>">E-Waste</a></li>
                  <li><a class="nav-link" href="<?php echo base_url('brand/marketplace');?>">Rubber</a></li>
                </ul>
              </li> -->
              <!-- <li class="nav-item <?php if($currentContorller == 'manageQuotes'){ echo 'active'; } ?>">
                <a href="<?php echo base_url('brand/manageQuotes');?>" class="nav-link"><i class="fa fa-th-large"></i><span>Manage Quotes</span></a>
              </li>
              
              
               <li class="nav-item <?php if($currentContorller == 'manageOrders'){ echo 'active'; } ?>">
                <a href="<?php echo base_url('brand/manageOrders');?>" class="nav-link"><i class="fa fa-sort-amount-up"></i><span>Manage Orders</span></a>
              </li>
              <li class="nav-item <?php if($currentContorller == 'manageInventory'){ echo 'active'; } ?>">
                <a href="<?php echo base_url('brand/manageInventory');?>" class="nav-link"><i class="fa fa-layer-group"></i><span>Manage Inventory</span></a>
              </li>
               <li class="nav-item <?php if($currentContorller == 'manageTeam'){ echo 'active'; } ?>">
                <a href="<?php echo base_url('brand/manageTeam');?>" class="nav-link"><i class="fa fa-users"></i><span>Manage Team</span></a>
              </li>
              <li class="nav-item <?php if($currentContorller == 'companyDetails'){ echo 'active'; } ?>">
                <a href="<?php echo base_url('brand/companyDetails');?>" class="nav-link"><i class="fa fa-building"></i><span>Company Details</span></a>
              </li>
              <li class="nav-item <?php if($currentContorller == 'setting'){ echo 'active'; } ?>">
                <a href="<?php echo base_url('brand/setting');?>" class="nav-link"><i class="fa fa-cog"></i><span>Settings</span></a>
              </li> -->              
              
            </ul>

        </aside>
      </div>