<?php echo view('recycler/inc/header'); ?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="row">
            <div class="col-lg-12">
              <div class="toptile_search">
                <div class="page-title">
                  <h2>List Inventory</h2>
                </div>
                <a href="/recycler/inventory/">Add New Inventory</a>
              </div>

            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="dashboard_white_panel mt-3">
                <div class="d-flex justify-content-between pt-3 pb-3 pl-3 pr-3 align-items-center">
                  <table style="width: 100%;">
                      <thead>
                          <tr>
                              <th>Item</th>
                              <th>State</th>
                              <!--<th>District</th>
                              <th>City</th>-->
                              <th></th>
                              <th></th>
                              <th>Quantity</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                    <?php 
                    
                    foreach($inventoryData as $inventory){ 
if($inventory['itemId'] != ''){                        
$item = $contoroller->getItemByID($inventory['itemId']);
} else if($inventory['sucCatId'] != ''){                
$item = $contoroller->getItemByID($inventory['sucCatId']);
} else if($inventory['categoryId'] != ''){                
$item = $contoroller->getItemByID($inventory['categoryId']);
}
$unit = $contoroller->getUnitByID($inventory['unit']);
$getStateAllocateQty = $contoroller->getAllocateQtyInventoryState($inventory['inventory_id']);
$unallocateQty = $inventory['qty'] - $getStateAllocateQty->allocateQty;
                    
                    ?>      
                          <tr>
                              <td> <?php echo $item->name.' '.$inventory['qty'].''.$unit->name;?> </td>
                              <td> Unallocated <a href="setStateInventoryId/<?php echo $inventory['inventory_id'];?>">Modify State Inventory</a></td>
                              <td></td>
                              <td></td>
                              <td> <?php echo $unallocateQty.''.$unit->name;?> </td>
                              <td></td>
                          </tr>
                          <tr>
                              <td></td>
                              <td colspan="4"> Allocated </td>
                              <td><a href="setInventoryId/<?php echo $inventory['inventory_id'];?>">Edit</a></td>
                          </tr>
<?php 
$stateAllocateData = $contoroller->getStateAllocateDataByState($inventory['inventory_id']);
                    foreach($stateAllocateData as $stateTarget){ 
$stateName = $contoroller->getStateByID($stateTarget['state_id']);
$getDistrictAllocateQty = $contoroller->getAllocateQtyDistrict($inventory['inventory_id'],$stateTarget['state_id']);
$unallocateQty = $stateTarget['req_qty'] - $getDistrictAllocateQty->allocateQty;
                        ?>
                          <tr>
                              <td></td>
                              <td> <?php echo $stateName->state_title.' '.$stateTarget['req_qty'].''.$unit->name;?> </td>
                              <td> Uncomplete </td>
                              <td></td>
                              <td><?php echo $unallocateQty.''.$unit->name;?> </td>
                              <td></td>
                          </tr>
                          <tr>
                              <td></td>
                              <td></td>
                              <td>Complete</td>
                              <td colspan="2"><?php echo '0'.''.$unit->name;?></td>
                          </tr>
<?php 
/*
$districtAllocateData = $contoroller->getDistAllocateDataByState($inventory['inventory_id'],$stateTarget['state_id']);
                    foreach($districtAllocateData as $distTarget){ 
$distName = $contoroller->getDistrictByID($distTarget['distrcit_id']);
?>
                          <tr>
                              <td></td>
                              <td></td>
                              <td><?php echo $distName->district_title.' '.$distTarget['req_qty'].''.$unit->name;?>  </td>
                              <td colspan="2">Complete </td>
                              <td></td>
                          </tr>

<?php 
$cityAllocateData = $contoroller->getCityAllocateDataByState($inventory['inventory_id'],$distTarget['distrcit_id']);

if(is_array($cityAllocateData)) {
                    foreach($cityAllocateData as $cityTarget){ 
$cityName = $contoroller->getCityByID($cityTarget['city_id']);
?>                          
                          <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td><?php echo $cityName->name;?> </td>
                              <td><?php echo $cityTarget['req_qty'].''.$unit->name;?> </td>
                              <td></td>
                          </tr>
                          
                    <?php } } ?>
                    <?php } */ ?>    
                    <?php } ?>    
                    <?php } ?>      
                      </tbody>
                  </table>
                </div>
              </div>
            </div>
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

  