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
<?php if(isset($_POST['district'])){

$stateName = $contoroller->getStateByID($_POST['state']);
$districtName = $contoroller->getDistrictByID($_POST['district']);
$districtByStateTarget = $contoroller->getTargetDataByStateTarget($_POST['state'],$targetData->target_id);

$targetDataByDistrict = $contoroller->getDataByDistrictTarget($targetData->target_id,$_POST['state']);
?>
                  <h2>Select <?php echo $item->name;?> <?php echo $districtByStateTarget->req_qty;?> <?php echo $unit->name;?> Target For 
                  <?php echo $districtName->district_title;?> Cities</h2>
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
                  <form role="form" id="addUser" action="" method="post" >
                        <div class="box-body">  
                            <div class="row">  
                                <div class="col-md-6">                                
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
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Select District *</label>
                                        <select class="form-control required" name="district" id="district" required>
                                            <option value="">Select District</option>
                                            <?php if(isset($_POST['state'])){ ?>
                                            <?php foreach($targetDataByDistrict as $district){ 
$distName = $contoroller->getDistrictByID($district['distrcit_id']);?>
                                                <option value="<?php echo $district['distrcit_id'];?>" <?php if($_POST['district'] == $district['distrcit_id']){ echo 'selected'; } ?>>
                                                    <?php echo $distName->district_title;?></option>
                                            <?php } } ?>
                                        </select>    
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="hidden" name="targetId" id="targetId" value="<?php echo $targetData->target_id;?>">
                            <input type="submit" class="btn btn-primary" name="submit" value="Search City">
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>

<?php if(isset($_POST['district'])){ 
$cityByState = $contoroller->getDistrictByDistrict($_POST['district']);
?>
          <div class="row">
            <div class="col-md-12">
              <div class="dashboard_white_panel mt-3">
                <div class="d-flex justify-content-between pt-3 pb-3 pl-3 pr-3 align-items-center">
                  <form role="form" id="addUser" action="addTargetByCityData" method="post" >
                        <div class="box-body">  
                            <div class="row">  
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Select District *</label>
                                        <select class="form-control required" name="city[]" id="city" required>
                                            <option value="">Select City</option>
                                            <?php foreach($cityByState as $city){ ?>
                                                <option value="<?php echo $city['id'];?>"><?php echo $city['name'];?></option>
                                            <?php } ?>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Enter Target Qty *</label>
                                        <input type="number" class="form-control required stateQty" name="qty[]" value="0" required>
                                    </div>
                                </div>
                            </div>
                            <?php for($i=1;$i<=4;$i++){ ?>  
                            <div class="row">  
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <select class="form-control required" name="city[]" id="city">
                                            <option value="">Select City</option>
                                            <?php foreach($cityByState as $city){ ?>
                                                <option value="<?php echo $city['id'];?>"><?php echo $city['name'];?></option>
                                            <?php } ?>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
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
    
                        <div class="box-footer">
                            <input type="hidden" name="stateId" id="stateId" value="<?php echo $_POST['state'];?>">
                            <input type="hidden" name="districtId" id="districtId" value="<?php echo $_POST['district'];?>">
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
 $("#state").change(function(){  
    var stateId = $(this).val();
    var targetId = $("#targetId").val();
      $.ajax({   
        type: "GET",
        data: { stateId: stateId,targetId:targetId },
        url: "/getDistrictByTarget.php",             
        dataType: "html",   //expect html to be returned                
        success: function(response){
                $("#district").html(response);
        }
    });
 });

});
</script> 
  