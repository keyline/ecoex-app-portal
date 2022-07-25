<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Ecoex Portal</title>
  	<!-- General CSS Files -->
	<link rel="shortcut icon" href="<?php echo site_url('public');?>/assets/landing/images/favicon.png">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  	<!-- Important Owl stylesheet -->
	<link rel="stylesheet" href="<?php echo site_url('public');?>/assets/landing/css/owl.carousel.css">
  	<!-- Important toggle button stylesheet -->
	<link rel="stylesheet" href="<?php echo site_url('public');?>/assets/landing/css/segment.css">
    
    <!-- Important menu maker stylesheet -->
	<link rel="stylesheet" href="<?php echo site_url('public');?>/assets/landing/css/menumaker.css">
  	<!-- Main Style -->   
	<link href="<?php echo site_url('public');?>/assets/landing/css/local.css" rel="stylesheet" media="screen">
  <link href="<?php echo site_url('public');?>/assets/landing/css/responsive.css" rel="stylesheet" media="screen">
  <link rel="stylesheet" href="<?php echo site_url('public');?>/assets/jquery.loading.css">
  <link rel="stylesheet" href="<?php echo site_url('public');?>/assets/sweetalert2.min.css">
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
  <header>
    <div class="market-header-part">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3 col-lg-2 headeer_logoleft">
            <div class="sidebar-brand pt-3 mb-3">
              <a href="<?=base_url()?>"><img src="<?php echo site_url('public');?>/assets/landing/images/logo.svg" alt="Logo"></a>
            </div>
          </div>
          <div class="col-md-9 col-lg-10 headeer_menuright">
              <div class="header_nav">
              		<div id="cssmenu">
                    <ul class="topmenu">
                       <li><a href="https://www.ecoex.market/about-us/" target="_blank">About Us</a></li>
                      <li><a href="https://www.ecoex.market/product/" target="_blank">Product</a></li>
                      <li><a href="https://www.ecoex.market/process/" target="_blank">Process</a></li>
                      <li><a href="https://www.ecoex.market/membership/" target="_blank">Membership</a></li>
                      <li><a href="https://www.ecoex.market/resources/" target="_blank">Resources</a></li>
                      <li><a href="https://www.ecoex.market/media/" target="_blank">Media</a></li>
                      <li><a href="https://www.ecoex.market/market-watch/" target="_blank">Market Watch</a></li>
                      <li><a href="#!" target="_blank">Marketplace</a></li>
                    </ul>
                  </div>
                  <?php
                  $userData   = [];
                  $session    = \Config\Services::session();
                  $userId     = $session->get('userId');
                  $userData   = $common_model->find_data('ecoex_user_table', 'row', ['user_id' => $userId]);
                  if($session->get('userType') == 'ADMIN'){
                    $userData = [
                      'user_name' => 'ADMIN'
                    ];
                    $userData = (object)$userData;
                  }
                  if(empty($userData)) {
                  ?>
                    <ul class="loginbtn_right">
                      <li class="head_register"><a href="/register">Register</a></li>
                      <li class="head_login"><a href="/login">Login</a></li>
                    </ul>
                  <?php } else {?>
                    <?php
                    if($session->get('userType') == 'MEMBER'){
                      if($userData->user_membership_type == 1){
                        $dashboardUrl = base_url('/brand/');
                        $logoutUrl = base_url('/brand/logout');
                      } else {
                        $dashboardUrl = base_url('/user/');
                        $logoutUrl = base_url('/user/logout');
                      }
                    } else {
                      $dashboardUrl = base_url('/admin/dashboard');
                      $logoutUrl = base_url('/admin/logout');
                    }                    
                    ?>
                    <ul class="loginbtn_right order-1">                    
                    <li class="head_register"><a href="<?=$dashboardUrl?>">Hi, <?=$userData->user_name?></a></li>
                    <li class="head_login"><a href="<?=$logoutUrl?>">Logout</a></li>
                  </ul>
                  <?php }?>
              </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <div class="header_below_section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-3 text-center">
          <img src="<?php echo site_url('public');?>/assets/landing/images/home_headbelow_img.png" alt="Product">
        </div>
        <div class="col-md-9">
          <div class="head_belowconte">
            <h1>Ecoex Marketplace</h1>
            <h3>Enabling transactions to bridge demand-supply gaps</h3>
            <p>Ecoex Marketplace is an online platfrom for buying and selling recyclable items like plastics, paper, e-wastes etc. Ecoex Marketplace connects bulk waste generators, waste aggregators and recyclers enabling transactions to bring transparency, traceability to the ecosystem.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="marketplace_middle_top">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-md-3">
          <div class="market-togglebtn">
            <!-- <select class="segment-select" id="segment-select" onchange="coming_soon(this.html);">
              <option value="1">Plastic</option>
              <option value="2">E-Waste</option>
              <option value="3">Rubber</option>
            </select> -->
          </div>
        </div>
        <div class="col-md-6">
          <div class="searh-middle">
            <div class="input-group border rounded-pill p-1">
              <div class="input-group-prepend border-0">
                <button id="button-addon4" type="button" class="btn btn-link text-info"><i class="fa fa-search"></i></button>
              </div>
              <input type="search" id="myInput" placeholder="What're you searching for?" aria-describedby="button-addon4" class="form-control bg-none border-0">
            </div>  
          </div>        
        </div>
        <div class="col-md-3">
          <div class="market_top_sortby">
            <!-- <form action="#" method="get"> -->
              <!--  onchange="this.form.submit()" -->
              <select class="form-control" id="package_request_sorting" onchange="getFilter(this.value);">
                <option value="" selected="selected">Sort By</option>
                <option value="name-asc">Name (A-Z)</option>
                <option value="name-desc">Name (Z-A)</option>
                <option value="rate-asc">Rate (A-Z)</option>
                <option value="rate-desc">Rate (Z-A)</option>
              </select>                          
            <!-- </form> -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="marketplace_middle_part">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <!-- <div class="marketplace_leftmenu">
            <h3>Plastic Categories</h3>
            <ul class="list-unstyled components">
                  <li>
                      <a href="#eprSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">EPR</a>
                      <ul class="collapse list-unstyled active show" id="eprSubmenu">
                    <?php                
                    $cateData = $contoroller->getBusinessSubCategoryList('2');
                    foreach($cateData as $cate){ 
                    ?>
                        <li><a href="#"><?php echo $cate['name'];?></a></li>
                    <?php } ?>                        
                      </ul>
                  </li>      
                  <li>
                      <a href="#rawSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Raw Material</a>
                      <ul class="collapse list-unstyled" id="rawSubmenu">
                    <?php                
                    $cateData = $contoroller->getBusinessSubCategoryList('3');
                    foreach($cateData as $cate){ 
                    ?>
                        <li><a href="#"><?php echo $cate['name'];?></a></li>
                    <?php } ?>                        
                      </ul>
                  </li>         
                  <li>
                      <a href="#finishedSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Finished Goods</a>
                      <ul class="collapse list-unstyled" id="finishedSubmenu">
                  <?php                
                  $cateData = $contoroller->getBusinessSubCategoryList('4');
                    foreach($cateData as $cate){ 
                  ?>
                        <li><a href="#"><?php echo $cate['name'];?></a></li>
                  <?php } ?>                        
                      </ul>
                  </li> 
            </ul>
          </div> -->
          <div class="marketplace_leftmenu">
            <h3>Filter</h3>
            <ul class="list-unstyled components">
              <?php if($maincats){ $i=1;foreach($maincats as $maincat){?>
              <li>
                  <a href="#eprSubmenu<?=$maincat->id?>" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><?=$maincat->name?></a>
                  <ul class="collapse list-unstyled <?=(($i==1)?'active show':'')?>" id="eprSubmenu<?=$maincat->id?>">
                    <?php
                    $subcats = $common_model->find_data('ecoex_business_category', 'array', ['parent' => $maincat->id]);
                    if($subcats){ $j=1;foreach($subcats as $subcat){
                    ?>
                      <li>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input greencheck" type="checkbox" name="subcat" id="subcat<?=$subcat->id?>" value="<?=$subcat->id?>" onclick="getFilter(this.value);">
                            <label class="form-check-label" for="subcat<?=$subcat->id?>"><?=$subcat->name?></label>
                        </div>
                      </li>
                    <?php $j++;} }?>
                  </ul>
              </li>      
              <?php $i++;} }?>
              <li>
                  <a href="#finishedSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="text-transform: uppercase;">Inventory Type</a>
                  <ul class="collapse list-unstyled" id="finishedSubmenu">
                    <li>
                      <div class="form-check form-check-inline ">
                          <input class="form-check-input greencheck" type="checkbox" name="inventoryType" id="inventoryType1" value="BUY" onclick="getFilter(this.value);">
                          <label class="form-check-label" for="inventoryType1">BUY</label>
                      </div>
                    </li>
                    <li>
                      <div class="form-check form-check-inline ">
                          <input class="form-check-input greencheck" type="checkbox" name="inventoryType" id="inventoryType2" value="SELL" onclick="getFilter(this.value);">
                          <label class="form-check-label" for="inventoryType2">SELL</label>
                      </div>
                    </li>
                  </ul>
              </li> 
               <li>
                  <a href="#stateSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="text-transform: uppercase;">State</a>
                  <ul class="collapse list-unstyled" id="stateSubmenu">
                    <?php if($states){ foreach($states as $state){?>
                      <li>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input greencheck" type="checkbox" name="state" id="state<?=$state->state_id?>" value="<?=$state->state_id?>" onclick="getFilter(this.value);">
                            <label class="form-check-label" for="state<?=$state->state_id?>"><?=$state->state_title?></label>
                        </div>
                      </li>
                    <?php } }?>
                  </ul>
              </li>    
            </ul>  
          </div>
        </div>
        <div class="col-md-9">
          <div class="row">
            <div class="col-md-12">
              <div class="makettop_prodcttab">
                <h4>All Posts</h4>
              </div>
            </div>
          </div>
          <div class="row" id="item-list">
            <?php //pr($listingData);?>
            <?php if($listingData) { foreach($listingData as $row){?>
              <?php if($storeId != '') { if($storeId != $row['listing_company']){?>              
                <div class="col-lg-4 col-md-6 col-sm-6 productList">
                  <div class="markete_prodict_item">
                    <div class="marketprod_img">
                      <img src="<?=$row['image']?>" alt="<?=$row['item']?>">
          						<div class="marketprod_saletag">
                        <?php if($row['listing_type'] == 'SELL'){?>
                            <div class="tag-text salebg"><?=$row['listing_type']?></div>
                        <?php }?>
                        <?php if($row['listing_type'] == 'BUY'){?>
                            <div class="tag-text buybg"><?=$row['listing_type']?></div>
                        <?php }?>
                      </div>
                      <div class="marketprod_membertag">
                        <div class="membername-text"><?=$row['listing_from']?></div>
                      </div>
                    </div>
                    <div class="market_name">
                      <h2><?=$row['item']?></h2>
                      <div class="marketplae_price">
                        Rs <?=$row['rate']?> /<?=$row['unit']?>
                      </div>
                    </div>
                    <div class="marketplace_product_info">
                      <p>State : <span><?=$row['state']?></span></p>
                      <p>Collection : <span><?=$row['month']?> <?=$row['year']?></span></p>
                      <p>Quantity : <span><?=$row['qty']?><?=$row['unit']?></span></p>
                      <?php
                      $listing_from = urlencode(base64_encode($row['listing_from']));
                      $listing_id   = urlencode(base64_encode($row['listing_id']));
                      ?>
                      <p><a href="<?=base_url('item-details/'.$listing_from.'/'.$listing_id)?>" style="float: right;margin-top: -26px;">View Details</a></p>
                      <!-- <div class="marketpro_timetogo">
                        <div class="marketpro_timeinfo">
                          <i class="fa fa-clock"></i> <?=time_difference($row['posting_datetime'])?> Ago
                        </div>
                      </div> -->
                    </div>
                    <?php if($session->get('userType') == 'ADMIN'){?>
                      <div class="for-admin-only" style="border:1px solid #0e0d0d24; padding: 10px;">
                        <p>Company name : <span style="font-weight: bold;"><?=$row['listing_company_name'];?></span> </p>
                        <p>Contact person name : <span style="font-weight: bold;"><?=$row['listing_company_person'];?></span> </p>
                        <p>Phone number : <span style="font-weight: bold;"><?=$row['listing_company_phone'];?></span> </p>
                        <p>Email id : <span style="font-weight: bold;"><?=$row['listing_company_email'];?></span> </p>
                        <p>Date of posting : <span style="font-weight: bold;"><?=date_format(date_create($row['posting_datetime']), "M d, Y h:i A");?></span> </p>
                      </div>
                    <?php }?>
                  </div>
                </div>
              <?php } } else { ?>
                <div class="col-lg-4 col-md-6 col-sm-6 productList">
                  <div class="markete_prodict_item">
                    <div class="marketprod_img">
                      <img src="<?=$row['image']?>" alt="<?=$row['item']?>">
          						<div class="marketprod_saletag">
                        <?php if($row['listing_type'] == 'SELL'){?>
                            <div class="tag-text salebg"><?=$row['listing_type']?></div>
                        <?php }?>
                        <?php if($row['listing_type'] == 'BUY'){?>
							              <div class="tag-text buybg"><?=$row['listing_type']?></div>
                        <?php }?>
          						</div>
          						<div class="marketprod_membertag">
          							<div class="membername-text"><?=$row['listing_from']?></div>
          						</div>
                    </div>
                    <div class="market_name">
                      <h2><?=$row['item']?></h2>
                      <div class="marketplae_price">
                        Rs <?=$row['rate']?> /<?=$row['unit']?>
                      </div>
                    </div>
                    <div class="marketplace_product_info">
                      <p>State : <span><?=$row['state']?></span></p>
                      <p>Collection : <span><?=$row['month']?> <?=$row['year']?></span></p>
                      <p>Quantity : <span><?=$row['qty']?><?=$row['unit']?></span></p>
                      <?php
                      $listing_from = urlencode(base64_encode($row['listing_from']));
                      $listing_id   = urlencode(base64_encode($row['listing_id']));
                      ?>
                      <p><a href="<?=base_url('item-details/'.$listing_from.'/'.$listing_id)?>" style="float: right;margin-top: -26px;">View Details</a></p>
				              <!-- <div class="marketpro_timetogo">
                        <div class="marketpro_timeinfo">
                          <i class="fa fa-clock"></i> <?=time_difference($row['posting_datetime'])?> Ago
                        </div>
                      </div> -->
                    </div>
                    <?php if($session->get('userType') == 'ADMIN'){?>
                      <div class="for-admin-only" style="border:1px solid #0e0d0d24; padding: 10px;">
                        <p>Company name : <span style="font-weight: bold;"><?=$row['listing_company_name'];?></span> </p>
                        <p>Contact person name : <span style="font-weight: bold;"><?=$row['listing_company_person'];?></span> </p>
                        <p>Phone number : <span style="font-weight: bold;"><?=$row['listing_company_phone'];?></span> </p>
                        <p>Email id : <span style="font-weight: bold;"><?=$row['listing_company_email'];?></span> </p>
                        <p>Date of posting : <span style="font-weight: bold;"><?=date_format(date_create($row['posting_datetime']), "M d, Y h:i A");?></span> </p>
                      </div>
                    <?php }?>
                  </div>
                </div>
              <?php }?>
            <?php } }?>            
          </div>
        </div>
    </div>
    </div>
  </div>  
  <footer class="footer-section">
      <div class="footer-contact-info py-3 text-left">
        <div class="container">
          <div class="textwidget custom-html-widget">
            <div class="row">
              <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-3 mb-lg-0 justify-content-lg-start justify-content-sm-center justify-content-center"><img src="<?php echo site_url('public');?>/assets/landing/images/address.png"> <span> 5C, 5th Floor, Hansalaya Building, Barakhamba Road, New Delhi-110001 </span></div>
              <div class="col-12 col-sm-6 col-md-6 col-lg-3 justify-content-lg-center justify-content-start mb-3 mb-sm-0"> <img src="images/email.png"> <span> For queries - <a href="mailto:info@ecoex.market">info@ecoex.market</a></span></div>
              <div class="col-12 col-sm-6 col-md-6 col-lg-3 justify-content-lg-end justify-content-sm-center justify-content-start"><img src="<?php echo site_url('public');?>/assets/landing/images/phone.png"><span> For personal assistance - <a href="tel:7042704664">8447767568</a> </span></div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-last">
        <div class="text-center">© <?=date('Y')?> EcoEX. All rights reserved.</div>
      </div>
  </footer>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Coming Soon</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          This Item Will Coming Soon !!!
        </div>      
      </div>
    </div>
  </div>
  <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Coming Soon</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          This Item Will Coming Soon !!!
        </div>      
      </div>
    </div>
  </div>
  <!-- General JS Scripts -->
  <script src="<?php echo site_url('public');?>/assets/landing/js/jquery-min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="<?php echo site_url('public');?>/assets/landing/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
 
  <!-- Toggle button JS Scripts -->
  <script src="<?php echo site_url('public');?>/assets/landing/js/segment.js"></script>
  
  <!-- Toggle menumaker JS Scripts -->
  <script src="<?php echo site_url('public');?>/assets/landing/js/menumaker.js"></script>
 <!-- Template JS File -->
  <script src="<?php echo site_url('public');?>/assets/landing/js/scripts.js"></script>
  <script src="<?php echo site_url('public');?>/assets/landing/js/custom.js"></script>
  <script>
    $(document).ready(function () {
      $(".marketplace_leftmenu li ul").filter(function () {
          return $(this).find('li').length >= 8
      }).addClass("overlayheight");
    });
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="<?php echo site_url('public');?>/assets/jquery.loading.js"></script>
  <script src="<?php echo site_url('public');?>/assets/sweetalert2.all.min.js"></script>
  <script src="<?php echo site_url('public');?>/assets/common-function.js"></script>
  <script src="<?php echo site_url('public');?>/assets/ecoex.js"></script>

  

  <script type="text/javascript">
    $(document).ready(function(){
      $("#myInput").on("input", function() {
        var value = $(this).val().toLowerCase();
        //alert(value);
        $("#item-list .productList").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
  </script>
</body>
</html>
