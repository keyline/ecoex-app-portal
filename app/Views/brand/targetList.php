<?php echo view('brand/inc/header'); ?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="row">
            <div class="col-lg-12">
              <div class="toptile_search">
                <div class="page-title">
                  <h2>Targets</h2>
                </div>
                <!-- <div class="search-container">
                    <div class="form-group has-search">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input type="text" class="form-control" placeholder="Search">
                  </div>
                </div> -->
              </div>
            </div>
          </div>



          <div class="row align-items-center mt-3">
            <?php if($session->getFlashdata('success_message')) {?>
            <div class="col-md-12">
              <span class="alert alert-success"><?=$session->getFlashdata('success_message')?></span>
            </div>
          <?php }?>
            <div class="col-md-6">
              <!-- <div class="market-traget_topleft">
                <div class="segmet_select">
                  <select class="segment-select">
                    <option value="1">Plastic</option>
                    <option value="2">E-Waste</option>
                    <option value="2">Rubber</option>
                  </select>
                </div>
                <div class="targetyears_select">
                  <select class="form-control">
                    <option selected>Years</option>
                    <option value="2122">2021-22</option>
                    <option value="2223">2022-23</option>
                    <option value="2324">2023-24</option>
                    <option value="2425">2024-25</option>
                  </select>
                </div>
              </div> -->
            </div>
            <div class="col-md-6">
              <div class="market_tagettop_btn">
                <a href="<?=base_url('/brand/target/')?>" class="nav-link greenbtn"> Add New</a>
                <!-- <a href="javascript:void(0)" onclick="openNavTablefilter()" class="nav-link filter_btn"><i class="fa fa-bell"></i> Filter</a> -->
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="dashboard_white_panel mt-3">
                <div class="target_dashland_details">
                  <!-- <ul class="targe_platic_tab">
                    <li class="active"><a href="#!"> Rigid</a></li>
                    <li><a href="#!">Flexi</a></li>
                    <li><a href="#!">MLP</a></li>
                  </ul> -->
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead class="thead-light">
                        <tr>
                          <th scope="col">Type</th>
                          <th scope="col">Item</th>
                          <th scope="col">Document Required</th>
                          <th scope="col">State</th>
                          <th scope="col">Quantity</th>
                          <th scope="col" style="text-align: center;">Action</th>
                        </tr>
                      </thead>
                      <tbody>
            
                    <?php
                    foreach($targetData as $target){ 
                    if($target['itemId'] != ''){                        
                    $item = $contoroller->getItemByID($target['itemId']);
                    } else if($target['sucCatId'] != ''){                
                    $item = $contoroller->getItemByID($target['sucCatId']);
                    } else if($target['categoryId'] != ''){                
                    $item = $contoroller->getItemByID($target['categoryId']);
                    }
                    $unit = $contoroller->getUnitByID($target['unit']);
                    $getStateAllocateQty = $contoroller->getAllocateQtyState($target['target_id']);
                    $unallocateQty = $target['qty'] - $getStateAllocateQty->allocateQty;
                    if($getStateAllocateQty->allocateQty == ''){
                        $allocatedQty = '0';
                    } else {
                        $allocatedQty = $getStateAllocateQty->allocateQty;
                    }                    
                    ?>                  
                        <tr>
                          <td rowspan="2">
                            <div class="target_table_itme">
                              <span class="targe_table_pname" <?=(($target['inventory_type'] == 'BUY')?'':'style="color:red;"')?>><?=$target['inventory_type']?></span>
                              <br>
                              <?php if($target['published'] == 0){?>
                                <span class="badge badge-warning">PENDING</span>
                              <?php } else if($target['published'] == 1){?>
                                <span class="badge badge-success">APPROVED</span>
                              <?php } else if($target['published'] == 3){?>
                                <span class="badge badge-danger">REJECTED</span>
                              <?php }?>
                            </div>
                          </td>
                          <td rowspan="2"><div class="target_table_itme"><span class="targe_table_pname"><?php echo $item->name;?> 
                          </span> <span class="targe_table_pweight"><?php echo $target['qty'].''.$unit->name;?></span></div>	</td>
                          <td rowspan="2">
                            <ul class="list-group">
                              <?php $document_required = json_decode($target['document_required']); ?>
                              <?php if(count($document_required)>0){ for($d=0;$d<count($document_required);$d++){?>
                                <?php $document = $common_model->find_data('ecoex_document_list', 'row', ['id' => $document_required[$d]]);?>
                                <li class="list-group-item"><?=(($document)?$document->documentName:'')?></li>
                              <?php } }?>
                            </ul>
                          </td>
                          <td>Unallocated 
                          <?php if($target['inquiry_status'] == '0'){ ?>
                          <a href="setStateTargetId/<?php echo $target['target_id'];?>"><i class="fa fa-pen"></i></a>
                          <?php } ?>
                          </td>
                          <td><?php echo number_format($unallocateQty,2).''.$unit->name;?></td>
                          <td rowspan="2">
                            <div class="taget_table_button text-center">
                              <!-- <a href="#!" class="greenbtn">Order Details</a> -->
                              <?php if($target['inquiry_status'] == '0'){ ?>
                                <a href="setTargetId/<?php echo $target['target_id'];?>" class="filter_btn">Edit</a>
                                <a href="targetToInquiry/<?php echo encoded($target['target_id']);?>" class="filter_btn">Convert To Inquiry</a>
                              <?php } else {?>
                                <p style="color: #48974e; font-weight: bold;">Already Converted To Inquiry</p>
                                <!-- <p>
                                  <a class="btn btn-outline-info" data-toggle="modal" data-target="#exampleModal<?=$target['target_id']?>">Inquiry Share List</a>
                                </p> -->
                              <?php }?>
                              <?php if(!$target['visibility']){?>
                                <!-- <a href="javascript:void(0);" data-id="<?=$target['target_id']?>" data-visibility="1" data-link="brand/targetList" data-action="brand/changeVisibility" class="btn btn-success visibility">Public</a> -->
                                <!-- <a href="javascript:void(0);" data-toggle="modal" data-target="#privateModal<?=$target['target_id']?>" class="btn btn-success visibility">Public</a> -->
                              <?php } else {?>
                                <!-- <a href="javascript:void(0);" data-id="<?=$target['target_id']?>" data-visibility="0" data-link="brand/targetList" data-action="brand/changeVisibility" class="btn btn-danger visibility">Private</a> -->
                              <?php }?>
                            </div>
                          </td>
                        </tr>
                        <?php if($allocatedQty != 0){ ?>
                        <tr data-toggle="collapse" data-target="#demo<?php echo $target['target_id'];?>" class="accordion-toggle">
                          <td><button class="btn btn-default btn-xs p-0">Allocated <i class="fa fa-angle-down"></i></button></td>
                          <td><?php echo number_format($allocatedQty,2).''.$unit->name;?></td>
                        </tr>
                            <?php } else { ?>
                        <tr>
                          <td><button class="btn btn-default btn-xs p-0">Allocated </button></td>
                          <td><?php echo number_format($allocatedQty,2).''.$unit->name;?></td>
                        </tr>
                            <?php } ?>    

                        
                        <tr>
                          <td colspan="4" class="tablehiddenRow">
                            <div class="accordian-body collapse" id="demo<?php echo $target['target_id'];?>">
                              <table class="table width-half">
                                <thead>
                                  <tr class="table-success">
                                    <th colspan="2">State</th>
                                    <th>Quantity</th>
                                  </tr>
                                </thead>
                                <tbody>                                    
                                  <?php 
                                  $stateAllocateData = $contoroller->getStateAllocateDataByState($target['target_id']);
                                                      foreach($stateAllocateData as $stateTarget){ 
                                  $stateName = $contoroller->getStateByID($stateTarget['state_id']);
                                  $getDistrictAllocateQty = $contoroller->getAllocateQtyDistrict($target['target_id'],$stateTarget['state_id']);
                                  $unallocateQty = $stateTarget['req_qty'] - $getDistrictAllocateQty->allocateQty;
                                  ?>
                                  <tr>
                                    <td rowspan="2"><?php echo $stateName->state_title;?> / <?php echo $stateTarget['req_qty'].''.$unit->name;?></td>
                                    <td>Complete</td>
                                    <td><?php echo number_format($unallocateQty,2).''.$unit->name;?></td>
                                  </tr>
                                  <tr>
                                    <td>Incomplete</td>
                                    <td>0.00</td>
                                  </tr>
                                  

                    <?php } ?>    
                                </tbody>
                              </table>
                            </div>
                          </td>
                        </tr>
            
            <?php } ?>      
                    
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            
            
          </div>
          
          
          
        </section>
      </div>
      <!-- <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2022 <div class="bullet"></div> 
        </div>
        <div class="footer-right">
         Develop By <a href="https://keylines.net/" target="_blank">Keyline DigiTech</a>
        </div>
      </footer> -->
    </div>
  </div>
  
<div id="tablefilter" class="filtersidenav">
	<div class="filtersidetop">
    	<h4>Fiters</h4>
  		<a href="javascript:void(0)" class="closebtn" onclick="closeNavTablefilter()">&times;</a>
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
</div>

<?php if($targetData){ foreach($targetData as $target){?>
  
  <!-- Inquiry Share List Modal -->
  <div class="modal fade" id="exampleModal<?=$target['target_id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><h4>Inquiry Share List</h4></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php
          $target_id = $target['target_id'];
          $group_by[0] = 'seller_id';
          $getPostShareList = $common_model->find_data('ecoex_business_inquiries', 'array', ['buyer_type' => 'Brand', 'buyer_id' => $userId, 'inventory_id' => $target_id, 'is_display' => 1], '', '', $group_by);
          // $db = \Config\Database::connect();
          // echo $db->getLastQuery();
          // pr($getPostShareList,false);
          ?>
          <div style="height:400px; overflow-x: scroll;">
            <table class="table table-stripped table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Member Type</th>
                  <th>Company Name</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
                <?php if($getPostShareList){ $sl=1;foreach($getPostShareList as $getPostShare){?>
                  <?php
                  $user = $common_model->getUserByUserId($getPostShare->seller_id);
                  ?>
                  <tr>
                    <td><?=$sl++?></td>
                    <td><?=$getPostShare->seller_type?></td>
                    <td><?=(($user)?$user->c_name:'')?></td>
                    <td><a href="mailto:<?=(($user)?$user->user_email:'')?>"><?=(($user)?$user->user_email:'')?></a></td>
                  </tr>
                <?php } }?>
              </tbody>
            </table>
          </div>        
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="privateModal<?=$target['target_id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><h4>Inquiry Share List</h4></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="post">
            <input type="hidden" name="target_id" value="<?=$target_id?>">
            <?php
            $target_id = $target['target_id'];
            $group_by[0] = 'seller_id';
            $getPostShareList = $common_model->find_data('ecoex_business_inquiries', 'array', ['buyer_type' => 'Brand', 'buyer_id' => $userId, 'inventory_id' => $target_id], '', '', $group_by);
            ?>
            <button type="submit" class="btn btn-danger">Make Private</button>
            <div style="height:400px; overflow-x: scroll;">
              <table class="table table-stripped table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Sl No.</th>
                    <th>Member Type</th>
                    <th>Company Name</th>
                    <th>Email</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if($getPostShareList){ $sl=1;foreach($getPostShareList as $getPostShare){?>
                    <?php
                    $user = $common_model->getUserByUserId($getPostShare->seller_id);
                    ?>
                    <tr>
                      <td><input type="checkbox" name="user_id[]" value="<?=$getPostShare->seller_id?>" <?=(($getPostShare->is_display)?'checked':'')?>></td>
                      <td><?=$sl++?></td>
                      <td><?=$getPostShare->seller_type?></td>
                      <td><?=(($user)?$user->c_name:'')?></td>
                      <td><a href="mailto:<?=(($user)?$user->user_email:'')?>"><?=(($user)?$user->user_email:'')?></a></td>
                    </tr>
                  <?php } }?>
                </tbody>
              </table>
            </div>
          </form>        
        </div>
      </div>
    </div>
  </div>
<?php } }?>

<script>
function opennotifilterNav() {
  document.getElementById("notifilter").style.width = "300px";
}

function closenotifilterNav() {
  document.getElementById("notifilter").style.width = "0";
}

function openNavTablefilter() {
  document.getElementById("tablefilter").style.width = "250px";
}

function closeNavTablefilter() {
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

  