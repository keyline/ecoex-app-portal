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
</head>

<body>
  

  <header>
    <div class="market-header-part">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3 col-lg-2 headeer_logoleft">
            <div class="sidebar-brand pt-3 mb-3">
              <a href=""><img src="<?php echo site_url('public');?>/assets/landing/images/logo.svg" alt="Logo"></a>
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
                  <ul class="loginbtn_right order-1">
                    <li class="head_register"><a href="/register">Register</a></li>
                    <li class="head_login"><a href="/login">Login</a></li>
                  </ul>
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
            <select class="segment-select" id="segment-select" onchange="coming_soon(this.html);">
              <option value="1">Plastic</option>
              <option value="2">E-Waste</option>
              <option value="3">Rubber</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="searh-middle">
            <div class="input-group border rounded-pill p-1">
              <div class="input-group-prepend border-0">
                <button id="button-addon4" type="button" class="btn btn-link text-info"><i class="fa fa-search"></i></button>
              </div>
              <input type="search" placeholder="What're you searching for?" aria-describedby="button-addon4" class="form-control bg-none border-0">
            </div>  
          </div>        
        </div>
        <div class="col-md-3">
          <div class="market_top_sortby">
            <a href="#!">Sort By</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="marketplace_middle_part">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <div class="marketplace_leftmenu">
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
          </div>
        </div>
        <div class="col-md-9">
          <div class="row">
            <div class="col-md-12">
              <div class="makettop_prodcttab">
                <h4>All Products</h4>
              </div>
            </div>
          </div>
          <div class="row">

                    <?php 
                    
                    foreach($inventoryData as $inventory){ 
$inventoryDetail = $contoroller->getInventoryDataByID($inventory['inventory_id']);
if($inventoryDetail->itemId != ''){                        
$item = $contoroller->getItemByID($inventoryDetail->itemId);
} else if($inventoryDetail->sucCatId != ''){                
$item = $contoroller->getItemByID($inventoryDetail->sucCatId);
} else if($inventoryDetail->categoryId != ''){                
$item = $contoroller->getItemByID($inventoryDetail->categoryId);
}
$unit = $contoroller->getUnitByID($inventoryDetail->unit);
$stateData = $contoroller->getStateByID($inventory['state_id']);
$getStateAllocateQty = $contoroller->getAllocateQtyInventoryState($inventoryDetail->inventory_id);
$unallocateQty = $inventoryDetailqty - $getStateAllocateQty->allocateQty;
                    
                    ?>                    
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="markete_prodict_item">
                <div class="marketprod_img">
                  <?php if($inventoryDetail->attachment != ''){?>
                    <img src="<?php echo base_url('writable/uploads/'.$inventoryDetail->attachment); ?>" alt="<?php echo $inventoryDetail->name;?>">
                  <?php } else {?>
                    <img src="<?php echo base_url('public/assets/No_Image_Available.jpg'); ?>" alt="Ecoex">
                  <?php }?>
                </div>
                <div class="market_name">
                  <h2><?php echo $item->name;?></h2>
                  <div class="marketplae_price">
                    Rs <?php echo $inventory['rate'];?> /<?php echo $unit->name;?>
                  </div>
                </div>
                <div class="marketplace_product_info">
                  <p>State : <span><?php echo $stateData->state_title;?></span></p>
                  <p>Collection : <span>June 2022</span></p>
                  <p>Quantity : <span><?php echo $inventory['req_qty'].' '.$unit->name;?></span></p>
                </div>
              </div>
            </div>
<?php } ?>        
            
            

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

</body>
</html>
