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
              		<div id="cssmenu" class="order-2">
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
                  $userData = [];
                  $session = \Config\Services::session();                  
                  $userId = $session->get('userId');
                  
                  //pr($userData);
                  if($userId=='') {
                  ?>
                    <ul class="loginbtn_right order-1">
                      <li class="head_register"><a href="/register">Register</a></li>
                      <li class="head_login"><a href="/login">Login</a></li>
                    </ul>
                  <?php } else {?>
                    <?php
                    $userData = $common_model->find_data('ecoex_user_table', 'row', ['user_id' => $userId]);
                    if($userData->user_membership_type == 1){
                      $dashboardUrl = base_url('/brand/');
                      $logoutUrl = base_url('/brand/logout');
                    } else {
                      $dashboardUrl = base_url('/user/');
                      $logoutUrl = base_url('/user/logout');
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
  <div class="productdetails_section">
    <div class="container">
      <div class="row">
        <div class="col-lg-5">
          <div class="productdetails_image mb-3">
            <img src="<?=$itemDetails['image']?>" alt="<?=$itemDetails['item']?>">
          </div>
        </div>
        <div class="col-lg-7">
          <div class="product_info_right">
            <div class="markete_item">
              <div class="market_name">
                <h2>
                  <?=$itemDetails['item']?>
                  <!-- <div class="markete_prodict_item">
                    <div class="marketprod_img">
                      <div class="marketprod_saletag">
                        <?php if($itemDetails['listing_type'] == 'SELL'){?>
                            <div class="tag-text salebg"><?=$itemDetails['listing_type']?></div>
                        <?php }?>
                        <?php if($itemDetails['listing_type'] == 'BUY'){?>
                            <div class="tag-text buybg"><?=$itemDetails['listing_type']?></div>
                        <?php }?>
                      </div>
                    </div>
                  </div> -->

                </h2>
                <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p> -->
                <div class="marketplae_price">
                  Rs <?=$itemDetails['rate']?> /<?=$itemDetails['unit']?>
                </div>
              </div>
              <div class="marketplace_product_info">
                <p>Quantity : <span><?=$itemDetails['qty']?> <?=$itemDetails['unit']?></span></p>
                <p>State : <span><?=$itemDetails['state']?></span></p>
                <p>Collection : <span><?=$itemDetails['month']?> <?=$itemDetails['year']?></span></p>
                  <form id="submitInquiry" method="POST" action="marketPlaceSubmitInquiry">
                    <input type="hidden" name="listing_from" value="<?=$listing_from?>">
                    <input type="hidden" name="listing_id" value="<?=$listing_id?>">
                    <input type="hidden" name="user_id" value="<?=$user_id?>">
                    <input type="hidden" id="max_qty" value="<?=$itemDetails['qty']?>">
                    <div class="form-group">
                      <label for="">Quantity <small>(Min: 1 <?=$itemDetails['unit']?> Max: <?=$itemDetails['qty']?> <?=$itemDetails['unit']?>)</small></label>
                      <input type="text" class="form-control requiredCheckInquiry" id="qty" name="qty" style="max-width:200px;" data-check="Quantity" autocomplete="off">
                      <span class="badge badge-danger" id="qty-err"></span>
                    </div>
                    <div class="form-group">
                      <label for="">Document Needs To Upload</label>
                      <?php if($documentLists){ foreach($documentLists as $documentList){?>
                      <p>
                        <input type="checkbox" class="requiredCheckInquiry" id="document_list<?=$documentList->id?>" name="document_list[]" value="<?=$documentList->id?>" data-check="Documents" autocomplete="off">
                        <label for="document_list<?=$documentList->id?>"><?=$documentList->documentName?></label>
                      </p>
                      <?php } }?>
                    </div>
                    <div class="market_bothbtn">
                      <!-- <a href="product-details-cart.html" class="border_btn">Add to Cart</a> -->
                      <!-- <a href="javascript:void(0);" class="soild_btn">Send Enquiry</a> -->
                      <button type="submit" class="soild_btn">Send Enquiry</button>
                    </div>
                  </form>
                  
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          
        </div>
        <div class="col-lg-12 pt-4">
          <div class="product_detailsinfo">
            <h3>Details</h3>
            <p class="mb-4">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            <h3>Terms & Conditions</h3>
            <p class="mb-4">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
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

  <script>
    function checkNegetiveValue(val){
      let firstChar = Array.from(val)[0];
      let secondChar = Array.from(val)[1];
      let status = false;
      var format = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
      if(format.test(firstChar)){
          status =  false;
      } else {
          if(format.test(secondChar)){
              status =  false;
          } else {
              status =  true;
          }
      }
      if(!status){
          $('#qty').val('');
      }
    }
    function isCharacter(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122)) {
            return false;
        }
        return true;
    }
    function isCharacterNumeric(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }    
  </script>
  <script type="text/javascript">
    $(document).ready(function(){
      $("#myInput").on("input", function() {
        var value = $(this).val().toLowerCase();
        //alert(value);
        $("#item-list .productList").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });

      $('#qty').on('blur', function(){
        let qty     = parseFloat($('#qty').val());
        let max_qty = parseFloat($('#max_qty').val());
        if(qty<0){
          $('#qty-err').show();
          $('#qty-err').text('Quantity Not Less Than Zero !!!');
          $(this).val('');
        } else {
          if(qty>max_qty){
            $('#qty-err').show();
            $('#qty-err').text('Quantity Not Greater Than Maximum Quantity !!!');
            $(this).val('');
          } else {
            $('#qty-err').hide();
            $('#qty-err').text('');
          }          
        }
      });
    });
  </script>
</body>
</html>
