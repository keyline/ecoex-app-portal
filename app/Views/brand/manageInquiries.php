<?php echo view('brand/inc/header'); ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Main Content -->
    <div class="main-content">
    	<div class="manage-quotes-top">
      	<div class="manage-quotes-page">
          	<div class="row">
              <div class="col-lg-12">
                <div class="toptile_search">
                  <div class="page-title">
                    <h2>Manage Inquiries</h2>
                  </div>
                  <div class="search-container">
                      <div class="form-group has-search">
                      <span class="fa fa-search form-control-feedback"></span>
                      <input type="text" class="form-control" placeholder="Search">
                    </div>
                  </div>                  
                </div>
                <div class="manage-quotes-topbar">
                  <div class="container-fluid">
                   <div class="row"> 
                     	<div class="manage-quotes-info manage-inquiries-info">
                        <div class="limited-part">
                          <div class="manage-inquiries-inner">
                            <div class="centeredContent">
                              <!-- <select class="segment-select">
                              	<option value="1">Live</option>
                              	<option value="2">Past</option>
                                <option value="3">Future</option>
                              </select> -->
                                                               
                            </div>
                            <!-- <div class="drafts-action">
                              <a href="./recyclerFlow-manageInquiries-draftInquries.html" class="drafts-btn">drafts<span class="badge">22</span></a>
                            </div> -->
                          </div>
                          <!-- <div class="filter-part">    
                            <div class="sort-action">
                              <a href="javascript:void(0)" onclick="openNav()" class="sort-btn"><i class="fa fa-filter" aria-hidden="true"></i>Filter</a>
                            </div>
                          </div> -->
                        </div>
                     	</div>
                   </div> 
                  </div>
                </div>
              </div>
            </div>        		
          	<div class="container-fluid">
              <div class="row">
                <div class="col-md-12">

                  <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home" class="greenbtn">Current</a></li>
                    <li><a data-toggle="tab" href="#menu1" class="greenbtn">Past</a></li>
                  </ul>

                  <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                      <h3>Current Inquires</h3>
                      <div class="manage-quotes-inner">
                        <div class="table-part inquiries-table">
                          <table>
                            <thead>
                              <tr>
                                <th>S.No.</th>
                                <th>Inquiry Id</th>
                                <th>Created At</th>
                                <th>Inquiry Type</th>
                                <th>Access Type</th>
                                <th>Category</th>
                                <th>Sub-Category</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              if($currentInquiries){ foreach($currentInquiries as $row){
                                $subCategory      = $commonModel->find_data('ecoex_business_category', 'row', ['id' => $row->sucCatId], 'name');
                                $subSubCategory   = $commonModel->find_data('ecoex_business_category', 'row', ['id' => $row->productId], 'name');
                                $item             = $commonModel->find_data('ecoex_business_category', 'row', ['id' => $row->itemId], 'name');
                              ?>
                                <tr>
                                  <td class="manage-number">1</td>
                                  <td>#<?=$row->inquiry_no?></td>
                                  <td><?=date_format(date_create($row->createdAt), "d-m-Y")?></td>
                                  <td><?=$row->typeOfSale?></td>
                                  <td><?=$row->accessType?></td>
                                  <td><?=$row->categoryName?></td>
                                  <td class="manage-rigid">
                                      <p><?=!empty($subCategory)?$subCategory->name:''?></p>
                                      <p><?=!empty($subSubCategory)?$subSubCategory->name:''?></p>
                                      <p><?=!empty($item)?$item->name:''?></p>
                                  </td>
                                   <td>
                                      <p><?=date_format(date_create($row->inquiryStart), "d-m-Y")?></p>
                                      <p><?=date_format(date_create($row->inquiryStartTime), "h:i A")?></p>
                                  </td>
                                  <td>
                                      <p><?=date_format(date_create($row->inquiryEnd), "d-m-Y")?></p>
                                      <p><?=date_format(date_create($row->inquiryEndTime), "h:i A")?></p>
                                  </td>
                                  <td>
                                    <a target="_blank" href="<?php echo base_url();?>/brand/manageInquiriesDetails/<?=$row->inquiry_id?>" class="view-btn">View Details</a><br><br>
                                    <a href="<?php echo base_url();?>/brand/closeInquiry/<?=$row->inquiry_id?>" class="view-btn" onclick="return confirm('Do You Want To Close This Inquiry ?');">Close Inquiry</a>
                                  </td>  
                                </tr>
                              <?php } } else {?>
                                <tr>
                                  <td colspan="10" style="text-align: center;">No Inquiries Found !!!</td>
                                </tr>
                              <?php }?>                  
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                      <h3>Past Inquiries</h3>
                      <div class="manage-quotes-inner">
                        <div class="table-part inquiries-table">
                          <table>
                            <thead>
                              <tr>
                                <th>S.No.</th>
                                <th>Inquiry Id</th>
                                <th>Created At</th>
                                <th>Inquiry Type</th>
                                <th>Access Type</th>
                                <th>Category</th>
                                <th>Sub-Category</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              if($pastInquiries){ foreach($pastInquiries as $row){
                                $subCategory      = $commonModel->find_data('ecoex_business_category', 'row', ['id' => $row->sucCatId], 'name');
                                $subSubCategory   = $commonModel->find_data('ecoex_business_category', 'row', ['id' => $row->productId], 'name');
                                $item             = $commonModel->find_data('ecoex_business_category', 'row', ['id' => $row->itemId], 'name');
                              ?>
                                <tr>
                                  <td class="manage-number">1</td>
                                  <td>#<?=$row->inquiry_no?></td>
                                  <td><?=date_format(date_create($row->createdAt), "d-m-Y")?></td>
                                  <td><?=$row->typeOfSale?></td>
                                  <td><?=$row->accessType?></td>
                                  <td><?=$row->categoryName?></td>
                                  <td class="manage-rigid">
                                      <p><?=!empty($subCategory)?$subCategory->name:''?></p>
                                      <p><?=!empty($subSubCategory)?$subSubCategory->name:''?></p>
                                      <p><?=!empty($item)?$item->name:''?></p>
                                  </td>
                                   <td>
                                      <p><?=date_format(date_create($row->inquiryStart), "d-m-Y")?></p>
                                      <p><?=date_format(date_create($row->inquiryStartTime), "h:i A")?></p>
                                  </td>
                                  <td>
                                      <p><?=date_format(date_create($row->inquiryEnd), "d-m-Y")?></p>
                                      <p><?=date_format(date_create($row->inquiryEndTime), "h:i A")?></p>
                                  </td>
                                  <td><a target="_blank" href="<?php echo base_url();?>/brand/manageInquiriesDetails/<?=$row->inquiry_id?>" class="view-btn">View Details</a></td>  
                                </tr>
                              <?php } } else {?>
                                <tr>
                                  <td colspan="10" style="text-align: center;">No Inquiries Found !!!</td>
                                </tr>
                              <?php }?>                  
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                </div>                
              </div>
            </div>            	
        </div>
      </div>        
		</div>
  </div>
</div>
<!-- <div id="tablefilter" class="filtersidenav">
	<div class="filtersidetop">
    	<h4>Fiters</h4>
  		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  	</div>
  
  <div class="accordion" id="accordionExample">
      <div class="card">
        <div class="card-header" id="headingOne">
          <h2 class="mb-0">
            <button class="btn accordion-button" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Business Categroy
            </button>
          </h2>
        </div>
    
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body">
           <div class="form-check">
              <label class="form-check-label" for="Plastic">
                Plastic
              </label>
              <input class="form-check-input greencheck" type="checkbox" value="" id="Plastic">
            </div>
            <div class="form-check">
              <label class="form-check-label" for="EWaste">
                E-Waste
              </label>
              <input class="form-check-input greencheck" type="checkbox" value="" id="EWaste">
            </div>
            <div class="form-check">
              <label class="form-check-label" for="Rubber">
                Rubber
              </label>
              <input class="form-check-input greencheck" type="checkbox" value="" id="Rubber">
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingTwo">
          <h2 class="mb-0">
            <button class="btn accordion-button" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Member Type
            </button>
          </h2>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
          <div class="card-body">
            <div class="form-check">
              <label class="form-check-label" for="Brand">
                Brand
              </label>
              <input class="form-check-input greencheck" type="checkbox" value="" id="Brand">
            </div>
            <div class="form-check">
              <label class="form-check-label" for="Recycler">
                Recycler
              </label>
              <input class="form-check-input greencheck" type="checkbox" value="" id="Recycler">
            </div>
            <div class="form-check">
              <label class="form-check-label" for="Waste">
                Waste Collertor
              </label>
              <input class="form-check-input greencheck" type="checkbox" value="" id="Waste">
            </div>
            <div class="form-check">
              <label class="form-check-label" for="EOL">
                EOL
              </label>
              <input class="form-check-input greencheck" type="checkbox" value="" id="EOL">
            </div>
          </div>
        </div>
      </div>
  </div>
  
  
    <div class="filterside_bottom">
    	<div class="filderside_botlink">
        	<a href="#">Clear</a>
            <a href="#" class="appylybtn">Apply</a>
        </div>
    </div>
</div> -->
 <script>
function openNav() {
  document.getElementById("tablefilter").style.width = "250px";
}

function closeNav() {
  document.getElementById("tablefilter").style.width = "0";
}
</script>
  
  <?php echo view('brand/inc/footer'); ?>

<script>
$(document).ready(function(){ 
 $("#category").change(function(){   
    var catId = $(this).val();
      $.ajax({   
        type: "GET",
        data: { parent: catId,name:'Sub Category' },
        url: "/getBusinessCategory.php",             
        dataType: "html",   //expect html to be returned                
        success: function(response){
                $("#subCategory").html(response);
        }
    });
 });
 $("#subCategory").change(function(){  
    var subCatId = $(this).val();
      $.ajax({   
        type: "GET",
        data: { parent: subCatId,name:'Item' },
        url: "/getBusinessCategory.php",             
        dataType: "html",   //expect html to be returned                
        success: function(response){
                $("#item").html(response);
        }
    });
 });

});
</script> 

  