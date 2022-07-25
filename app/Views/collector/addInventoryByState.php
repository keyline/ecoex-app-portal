<?php echo view('collector/inc/header'); 

$item = $contoroller->getItemByID($inventoryData->itemId);
$unit = $contoroller->getUnitByID($inventoryData->unit);

?>
      <!-- Main Content -->
      <div class="main-content"> 
        <section class="section">
          <div class="row">
            <div class="col-lg-12">
              <div class="toptile_search">
                <div class="page-title">
                  <h2>Select <?php echo $item->name;?> <?php echo $inventoryData->qty;?> <?php echo $unit->name;?> Inventory For State</h2>
                </div>
              </div>

            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="dashboard_white_panel mt-3">
                <div class="d-flex justify-content-between pt-3 pb-3 pl-3 pr-3 align-items-center">
                  <form role="form" id="addTarget" action="addInventoryByStateData" method="post" >
                        <div class="box-body"> 
                            <?php 
                            $insertedStateData = $contoroller->getInventoryDataByState($inventoryData->inventory_id);
                            $i=1;
                            ?>
                            <?php foreach($insertedStateData as $insertState){ 
                            $stateName = $contoroller->getStateByID($insertState['state_id']);
                            ?> 
                            <div class="row">  
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                    <?php if($i==1){?>    
                                        <label for="fname">Select State *</label>
                                    <?php } ?>    
                                        <select class="form-control required" name="state[]" id="state" required>
                                            <option value="">Select State</option>
                                            <?php foreach($stateData as $state){ ?>
                                                <option value="<?php echo $state['state_id'];?>" <?php if($state['state_id'] == $stateName->state_id){ echo 'selected'; } ?> >
                                                    <?php echo $state['state_title'];?></option>
                                            <?php } ?>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                    <?php if($i==1){?>    
                                        <label for="fname">Enter Inventory Qty *</label>
                                    <?php } ?>    
                                        <input type="number" class="form-control required stateQty" name="qty[]" value="<?php echo $insertState['req_qty'];?>" required>
                                    </div>
                                </div>
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                    <?php if($i==1){?>    
                                        <label for="fname">Location/Area/City *</label>
                                    <?php } ?>
                                        <input type="text" class="form-control required" name="storeLocation[]" value="<?php echo $insertState['storeLocation'];?>">
                                    </div>
                                </div>
                        </div>
                            <?php $i++; } ?>
                            <?php for($j=$i;$j<=20;$j++){
                            $newJ = $j + 1;
                            ?>  
                            <div class="row" <?php if($j!=$i){?> style="display:none;" <?php } ?> id="inventoryFormDiv<?php echo $j;?>">  
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                    <?php if($j==1){?>    
                                        <label for="fname">Select State *</label>
                                    <?php } ?>    
                                        <select class="form-control required" name="state[]" id="state">
                                            <option value="">Select State</option>
                                            <?php foreach($stateData as $state){ ?>
                                                <option value="<?php echo $state['state_id'];?>"><?php echo $state['state_title'];?></option>
                                            <?php } ?>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                    <?php if($j==1){?>    
                                        <label for="fname">Enter Inventory Qty *</label>
                                    <?php } ?>    
                                        <input type="text" class="form-control required stateQty" name="qty[]" value="0">
                                    </div>
                                </div>
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                    <?php if($j==1){?>    
                                        <label for="fname">Location/Area/City *</label>
                                    <?php } ?>
                                        <input type="text" class="form-control required" name="storeLocation[]">
                                    </div>
                                </div>
                                <div class="col-md-1">                                
                                    <div class="form-group">
                                    <i class="fa fa-plus-circle fa-2x text-success incrementClass" data-id="<?php echo $newJ;?>" aria-hidden="true" 
                                    <?php if($j==1){?> style="margin-top: 35px;" <?php } ?>   ></i>
                                    </div>
                                </div>
                                <div class="col-md-1">                                
                                    <div class="form-group">
                                    <?php if($j==$i){?>   
                                    <?php } else { ?>    
                                    <i class="fa fa-minus-circle fa-2x text-danger decrementClass" data-id="<?php echo $j;?>" aria-hidden="true"></i>
                                    <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>   
                            <div class="row">  
                                <div class="col-md-7">                                
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="fname">Total Qty</label>
                                        <label for="fname"><span class="total">0</span></label>
                                    </div>
                                </div>
                            </div> 
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="hidden" name="maxTargetQty" id="maxTargetQty" value="<?php echo $inventoryData->qty;?>">
                            <input type="submit" class="btn btn-primary" name="submit" value="Submit Inventory">
                        </div>
                    </form>
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
  
  <?php echo view('collector/inc/footer'); ?>

<script>
$(document).ready(function(){ 
    
     this.value = 0;
    var total = 0;
    var $changeInputs = $('input.stateQty');
    $changeInputs.each(function(idx, el) {
      total += Number($(el).val());
      });
    $('.total').text(total.toFixed(2));
    
 $('body').on('keyup', 'input.stateQty', UpdateTotal);

function UpdateTotal() {
    var total = 0;
    var $changeInputs = $('input.stateQty');
    $changeInputs.each(function(idx, el) {
      total += Number($(el).val());
      });
  var maxTargetQty = $("#maxTargetQty").val();
  if(total <= maxTargetQty){
        $('.total').text(total.toFixed(2));
  } else {      
        alert('You Entered More Then Required Qty!');
        this.value = 0;
        var total = 0;
        var $changeInputs = $('input.stateQty');
        $changeInputs.each(function(idx, el) {
            total += Number($(el).val());
        });
    $('.total').text(total.toFixed(2));
  }
}

 $("#addTarget").submit(function(){
        //if(!confirm('Are You Enter Quantity Less Than Allocate Quantity! You Loss District,City Entered Data!')){
        //    event.preventDefault();
        //}
});
$(".incrementClass").click(function(){
    $("#inventoryFormDiv"+$(this).attr("data-id")).css('display','flex');
});
$(".decrementClass").click(function(){
    $("#inventoryFormDiv"+$(this).attr("data-id")).css('display','none');
});
});
</script> 

  