<?php echo view('brand/inc/header'); 

$item = $contoroller->getItemByID($targetData->itemId);
$unit = $contoroller->getUnitByID($targetData->unit);

?>
      <!-- Main Content -->
      <div class="main-content"> 
        <section class="section">
            
          <div class="row">
            <div class="col-lg-12">
              <div class="toptile_search">
                <div class="page-title">
<?php if(isset($_POST['state'])){

$stateName = $contoroller->getStateByID($_POST['state']);
$districtByStateTarget = $contoroller->getTargetDataByStateTarget($_POST['state'],$targetData->target_id);
?>
                  <h2>Select <?php echo $item->name;?> <?php echo $districtByStateTarget->req_qty;?> <?php echo $unit->name;?> Target For <?php echo $stateName->state_title;?> District</h2>
<?php } else { ?>
                  <h2>Select <?php echo $item->name;?> <?php echo $targetData->qty;?> <?php echo $unit->name;?> Target For District</h2>
<?php } ?>                  
                </div>
              </div>

            </div>
          </div>
          
          <div class="row">
            <div class="col-md-12">
              <div class="dashboard_white_panel mt-3">
                <div class="d-flex justify-content-between pt-3 pb-3 pl-3 pr-3 align-items-center">
                  <!--<form role="form" id="addUser" action="" method="post" >
                        <div class="box-body">  
                            <div class="row">  
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="fname">Select State *</label>
                                        <select class="form-control required" name="state" id="state" required>
                                            <option value="">Select State</option>
                                            <?php foreach($targetDataByState as $state){ 
$stateName = $contoroller->getStateByID($state['state_id']);?>
                                                <option value="<?php echo $state['state_id'];?>" <?php if(isset($_POST['state'])){ ?>
                                                <?php if($_POST['state'] == $state['state_id']){ echo 'selected'; } } ?>><?php echo $stateName->state_title;?></option>
                                            <?php } ?>
                                        </select>    
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" name="submit" value="Select State">
                        </div>
                    </form>--->
                    
            <div class="col-md-12">
              <div class="dashboard_white_panel mt-3">
                <div class="d-flex justify-content-between pt-3 pb-3 pl-3 pr-3 align-items-center">
                  <table style="width: 100%;">
                      <thead>
                          <tr>
                              <th>State</th>
                              <th>Target Quantity</th>
                              <th>Allocate Quantity</th>
                              <th>Unallocate Quantity</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                    <?php 
                    foreach($targetDataByState as $state){ 
$stateName = $contoroller->getStateByID($state['state_id']);

$districtByStateTarget = $contoroller->getTargetDataByStateTarget($state['state_id'],$targetData->target_id);
$getDistrictAllocateQty = $contoroller->getAllocateQtyDistrict($targetData->target_id,$state['state_id']);
$unallocateQty = $districtByStateTarget->req_qty - $getDistrictAllocateQty->allocateQty;
                    ?>      
                          <tr>
                              <td><?php echo $stateName->state_title;?></td>
                              <td><?php echo $districtByStateTarget->req_qty;?> <?php echo $unit->name;?> </td>
                              <td><?php echo $getDistrictAllocateQty->allocateQty;?> <?php echo $unit->name;?>  </td>
                              <td><?php echo $unallocateQty;?> <?php echo $unit->name;?>  </td>
                              <td><form role="form" id="addUser" action="" method="post" >
                                    <input type="hidden" name="state" value="<?php echo $state['state_id'];?>">
                                    <input type="submit" class="btn btn-primary" name="submit" value="Select State" style="margin-bottom: 10px;">
                                    </form> 
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
            </div>
          </div>

<?php if(isset($_POST['state'])){ 
$districtByState = $contoroller->getDistrictByState($_POST['state']);
?>
          <div class="row">
            <div class="col-md-12">
              <div class="dashboard_white_panel mt-3">
                <div class="d-flex justify-content-between pt-3 pb-3 pl-3 pr-3 align-items-center">
                  <form role="form" id="addUser" action="addTargetByDistrictData" method="post" >
                        <div class="box-body"> 

<?php 
$insertedDistrictData = $contoroller->getDataByDistrictTarget($targetData->target_id,$_POST['state']);
$i=1;
?>                            
                            <?php foreach($insertedDistrictData as $insertedDistrict){ 
                            $distName = $contoroller->getDistrictByID($insertedDistrict['distrcit_id']);
                            ?>  
                            <div class="row">  
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                    <?php if($i==1){?>    
                                        <label for="fname">Select District *</label>
                                    <?php } ?>    
                                        <select class="form-control required" name="district[]" id="state" required>
                                            <option value="">Select District</option>
                                            <?php foreach($districtByState as $district){ ?>
                                                <option value="<?php echo $district['districtid'];?>"<?php if($district['districtid'] == $distName->districtid){ echo 'selected'; } ?> >
                                                    <?php echo $district['district_title'];?></option>
                                            <?php } ?>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                    <?php if($i==1){?>    
                                        <label for="fname">Enter Target Qty *</label>
                                    <?php } ?>    
                                        <input type="number" class="form-control required stateQty" name="qty[]" value="<?php echo $insertedDistrict['req_qty'];?>" required>
                                    </div>
                                </div>
                            </div>
                            <?php $i++; } ?>
                            <?php for($j=$i;$j<=10;$j++){ ?>  
                            <div class="row">  
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                    <?php if($j==1){?>    
                                        <label for="fname">Select District *</label>
                                    <?php } ?>    
                                        <select class="form-control required" name="district[]" id="state">
                                            <option value="">Select District</option>
                                            <?php foreach($districtByState as $district){ ?>
                                                <option value="<?php echo $district['districtid'];?>"><?php echo $district['district_title'];?></option>
                                            <?php } ?>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                    <?php if($j==1){?>    
                                        <label for="fname">Enter Target Qty *</label>
                                    <?php } ?>    
                                        <input type="number" class="form-control required stateQty" name="qty[]" value="0">
                                    </div>
                                </div>
                            </div>
                            <?php } ?>   
                            <div class="row">  
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Total Qty</label>
                                        <label for="fname"><span class="total">0</span></label>
                                    </div>
                                </div>
                            </div> 
                        </div><!-- /.box-body -->
<?php 
$districtByStateTarget = $contoroller->getTargetDataByStateTarget($_POST['state'],$targetData->target_id);
?>
                        <div class="box-footer">
                            <input type="hidden" name="stateId" id="stateId" value="<?php echo $_POST['state'];?>">
                            <input type="hidden" name="maxTargetQty" id="maxTargetQty" value="<?php echo $districtByStateTarget->req_qty;?>">
                            <input type="submit" class="btn btn-primary" name="submit" value="Add Target">
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
          
<?php } ?>
          
          
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
 $('body').on('keyup', 'input.stateQty', UpdateTotal);

function UpdateTotal() {
    var total = 0;
    var $changeInputs = $('input.stateQty');
    $changeInputs.each(function(idx, el) {
      total += Number($(el).val());
      });
  var maxTargetQty = $("#maxTargetQty").val();
  if(total <= maxTargetQty){
    $('.total').text(total);
  } else {
      
      alert('You Entered More Then Required Qty!');
     this.value = 0;
    var total = 0;
    var $changeInputs = $('input.stateQty');
    $changeInputs.each(function(idx, el) {
      total += Number($(el).val());
      });
    $('.total').text(total);
  }
}

});
</script> 

  