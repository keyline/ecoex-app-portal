<?php echo view('brand/inc/header'); ?>
      <!-- Main Content -->
      <div class="main-content">
      	<div class="manage-quotes-top">
        	<div class="manage-quotes-page">
            	<div class="row">
            <div class="col-lg-12">
              <div class="toptile_search">
                <div class="page-title">
                  <h2>Inquiries</h2>
                </div>
                <!--<div class="search-container">
                    <div class="form-group has-search">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input type="text" class="form-control" placeholder="Search">
                  </div>
              	</div>-->
                
              </div>
              
            </div>
          </div>
          		<div class="manage-quotes-topbar">
                <div class="container-fluid">
                    <div class="row">
                        <div class="manage-quotes-info">
                            <div class="inquiry-details">
                                <p>Manage Inquiries</p> <span>/</span>
                                <p>Inquiries</p> <span class="in-black">/</span>
                                <p class="in-black">Inquiry Details</p>
                            </div>
                            <!------------|| NAV BAR STARTS ||------------>
                            <div class="topPanel">
                                <div class="topPanel-no">
                                    #<?=(!empty($inquiryDetail)?$inquiryDetail->inquiry_no:'')?>
                                </div>
                                <nav class="navbar navbar-expand-xl navbar-light w-100">
                                    <a class="navbar-brand" href="<?php echo $database->base_url; ?>">
                                        <img src="<?php echo $database->base_url; ?>images/logo.svg" alt="" class="logo img-fluid">
                                    </a>
                                    <button class="navbar-toggler x collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>

                                    <div class="collapse navbar-collapse h-md-100" id="navbarSupportedContent">
                                        <ul class="navbar-nav h-md-100" id="nav">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="javascript:void(0);">Inquiry Details</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="javascript:void(0);">Queries</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="javascript:void(0);">Bid</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="javascript:void(0);">Audit Log</a>
                                            </li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>

                            <!------------|| NAV BAR ENDS ||------------>
                        </div>
                    </div>
                </div>
            </div>
            	
            	<div class="generalInfo-inner">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="manageInquiries-inquiryDetails-inner manageInquiries-inquiryDetails-inner-2">
                            <div class="manageInquiries-inquiryDetails-general">
                                <h3>General Info</h3>
                            </div>
                            <div class="manageInquiries-inquiryDetails-button">

                                <div class="ellipsis-action">
                                    <a href="#" class="ellipsis-btn"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="generalInfo-info general-border-box manageInquiries-inquiryDetails-borderBox">
                            <div class="row">
                                <div class="col-lg-2 col-md-6">
                                    <div class="generalInfo-box">
                                        <h5>Inquiry for</h5>
                                        <p><?=(!empty($user)?$user->c_name:'')?></p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="generalInfo-box">
                                        <h5>Type of Inquiry</h5>
                                        <p><?=(!empty($inquiryDetail)?$inquiryDetail->typeOfSale:'')?></p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="generalInfo-box">
                                        <h5>Inquiry Start Date</h5>
                                        <p><?=(!empty($inquiryDetail)?date_format(date_create($inquiryDetail->inquiryStart), "d-m-Y"):'')?></p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="generalInfo-box">
                                        <h5>Inquiry Start Time</h5>
                                        <p><?=(!empty($inquiryDetail)?date_format(date_create($inquiryDetail->inquiryStartTime), "h:i A"):'')?></p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="generalInfo-box">
                                        <h5>Inquiry End Date</h5>
                                        <p><?=(!empty($inquiryDetail)?date_format(date_create($inquiryDetail->inquiryEnd), "d-m-Y"):'')?></p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="generalInfo-box">
                                        <h5>Inquiry End Time</h5>
                                        <p><?=(!empty($inquiryDetail)?date_format(date_create($inquiryDetail->inquiryEndTime), "h:i A"):'')?></p>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="generalInfo-box">
                                        <h5>Inquiry Description</h5>
                                        <p><?=(!empty($inquiryDetail)?$inquiryDetail->inquiryDescription:'')?></p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="generalInfo-box">
                                        <h5>Inquiry Access Type</h5>
                                        <p><?=(!empty($inquiryDetail)?$inquiryDetail->accessType:'')?></p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="generalInfo-box">
                                        <h5>Attach Document</h5>
                                        <p><a href="<?=base_url('/writable/uploads/'.(!empty($inquiryDetail)?$inquiryDetail->attachment:''))?>" target="_blank" class="label label-success">View</a></p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="generalInfo-box">
                                        <h5>Documents Required</h5>
                                        <ul>
                                            <?php
                                            $documentRequired = (!empty($inquiryDetail)?json_decode($inquiryDetail->documentRequired):[]);
                                            if(count($documentRequired)>0){ for($d=0;$d<count($documentRequired);$d++){
                                                $document = $common_model->find_data('ecoex_document_list', 'row', ['id' => $documentRequired[$d]]);
                                            ?>
                                            <li><?=(!empty($document)?$document->documentName:'')?></li>
                                            <?php } }?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="generalInfo-inner manageInquiry-inner">
                    <div class="row">
                        <div class="col-lg-12">
                            <bid class="bid-inner">
                                <div class="manage-quotes-inner">
                                    <div class="table-part manageInquiry-tabble manageInquiry-tabble-2">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sub-Category</th>
                                                    <th>Item</th>
                                                    <th>Total Qty</th>
                                                    <th>Bidding UOM</th>
                                                    <th>State</th>
                                                    <th>Quantity</th>
                                                    <th>Milestone(Month)</th>
                                                    <th>Milestone(Qty)</th>
                                                    <!-- <th>Payment</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $subCategory    = $common_model->find_data('ecoex_business_category', 'row', ['id' => $inquiryDetail->sucCatId]);
                                                $subSubCategory = $common_model->find_data('ecoex_business_category', 'row', ['id' => $inquiryDetail->productId]);
                                                $item           = $common_model->find_data('ecoex_business_category', 'row', ['id' => $inquiryDetail->itemId]);
                                                $unit           = $common_model->find_data('ecoex_unit', 'row', ['id' => $inquiryDetail->unit]);
                                                $inquiryStateWises           = $common_model->find_data('ecoex_target_by_state', 'array', ['target_id' => $inquiryDetail->target_id]);
                                                if($inquiryStateWises) { $i=1; foreach($inquiryStateWises as $inquiryStateWise){
                                                    $state           = $common_model->find_data('ecoex_state', 'row', ['state_id' => $inquiryStateWise->state_id]);
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php if($i==1){?>
                                                            <span><?=(!empty($subCategory)?$subCategory->name:'')?></span><br>
                                                            <span><?=(!empty($subSubCategory)?$subSubCategory->name:'')?></span>
                                                        <?php }?>
                                                    </td>
                                                    <td>
                                                        <?php if($i==1){?>
                                                            <?=(!empty($item)?$item->name:'')?>
                                                        <?php }?>
                                                    </td>
                                                    <td>
                                                        <?php if($i==1){?>
                                                            <?=(!empty($inquiryDetail)?$inquiryDetail->qty:'')?> <?=(!empty($unit)?$unit->name:'')?>
                                                        <?php }?>
                                                    </td>
                                                    <td>
                                                        <?php if($i==1){?>
                                                            <?=(!empty($unit)?$unit->name:'')?>
                                                        <?php }?>
                                                    </td>
                                                    <td class="form-border-2"><?=(!empty($state)?$state->state_title:'')?></td>
                                                    <td><?=(!empty($inquiryStateWise)?$inquiryStateWise->req_qty:'')?> <?=(!empty($unit)?$unit->name:'')?></td>
                                                    <td><?=(!empty($inquiryDetail)?$common_model->monthName($inquiryDetail->month):'')?></td>
                                                    <td><?=(!empty($inquiryStateWise)?$inquiryStateWise->req_qty:'')?> <?=(!empty($unit)?$unit->name:'')?></td>
                                                    <!-- <td>20%</td> -->
                                                </tr>
                                                <?php $i++; } }?>
                                                <!-- <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border-2"></td>
                                                    <td></td>
                                                    <td>Feburary</td>
                                                    <td>100KG</td>
                                                    <td>20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border-2"></td>
                                                    <td></td>
                                                    <td>March</td>
                                                    <td>100KG</td>
                                                    <td>20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border form-border-2"></td>
                                                    <td class="form-border"></td>
                                                    <td class="form-border">April</td>
                                                    <td class="form-border">100KG</td>
                                                    <td class="form-border">20%</td>
                                                </tr> -->                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </bid>
                        </div>
                    </div>
                </div>
               <div class="generalInfo-inner manageInquiry-inner">
                        <div class="row">
                            <div class="col-lg-12">
                                <bid class="bid-inner">
                                    <bid class="bid-submit">
                                        <div class="bid-plastic invited-sellers">
                                            <p>Invited Sellers</p>
                                        </div>
                                    </bid>
                                    <div class="manage-quotes-inner">
                                        <div class="table-part manageInquiry-tabble">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th class="table-fix">Company Name</th>
                                                        <th>Deal In</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    <tr>
                                                        
                                                        <td class="table-fix"><?=(!empty($user)?$user->c_name:'')?></td>
                                                        <td>
                                                            <?php
                                                            $catName = [];
                                                            $companyDetails = $common_model->find_data('ecoex_company_details', 'row', ['c_id' => $inquiryDetail->c_id]);
                                                            if($companyDetails){
                                                                $c_business_category = explode(",", $companyDetails->c_business_category);
                                                                if(count($c_business_category)>0){
                                                                    for($c=0;$c<count($c_business_category);$c++){
                                                                        $businesscat = $common_model->find_data('ecoex_business_category', 'row', ['id' => $c_business_category[$c]]);
                                                                        $catName[] = (!empty($businesscat)?$businesscat->name:'');
                                                                    }
                                                                }
                                                                if(!empty($catName)){
                                                                    echo implode(",", $catName);
                                                                }                                                                
                                                            }
                                                            
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </bid>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
      
        
  		</div>
  
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

  