<?php echo view('brand/inc/header');
$item = $contoroller->getItemByID($targetData->itemId);
$unit = $contoroller->getUnitByID($targetData->unit);
?>
<div class="main-content"> 
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="toptile_search">
                    <div class="page-title">
                      <h2>Select <?php echo $item->name;?> <?php echo $targetData->qty;?> <?php echo $unit->name;?> Target For State</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="dashboard_white_panel mt-3">
                    <div class="d-flex justify-content-between pt-3 pb-3 pl-3 pr-3 align-items-center">
                      <form role="form" id="addTarget" action="addTargetByStateData" method="post" >
                            <div class="box-body"> 
                                <?php 
                                $insertedStateData = $contoroller->getTargetDataByState($targetData->target_id);
                                $i=1;
                                ?>
                                <?php foreach($insertedStateData as $insertState){
                                $stateName = $contoroller->getStateByID($insertState['state_id']);
                                ?> 
                                <div class="row">  
                                    <div class="col-md-6">                                
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
                                    <div class="col-md-6">                                
                                        <div class="form-group">
                                        <?php if($i==1){?>    
                                            <label for="fname">Enter Target Qty *</label>
                                        <?php } ?>    
                                            <input type="number" class="form-control required stateQty" name="qty[]" value="<?php echo $insertState['req_qty'];?>" required min="1" onkeypress="return isNumber(event)">
                                        </div>
                                    </div>
                            </div>
                                <?php $i++; } ?>
                                <div class="field_wrapper">
                                    <div class="row">  
                                        <div class="col-md-6">
                                            <div class="form-group">                                        
                                                <label for="fname">Select State *</label>                                        
                                                <select class="form-control required" name="state[]" id="state">
                                                    <option value="">Select State</option>
                                                    <?php if($stateData){foreach($stateData as $state){ ?>
                                                        <option value="<?php echo $state['state_id'];?>"><?php echo $state['state_title'];?></option>
                                                    <?php } }?>
                                                </select>    
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="fname">Enter Target Qty *</label>
                                                <input type="number" class="form-control required stateQty" name="qty[]" value="1" min="1" onkeypress="return isNumber(event)">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group" style="margin-top: 30px;">
                                                <a href="javascript:void(0);" class="add_button" title="Add field"><i class="fa fa-plus-circle fa-2x text-success"></i></a>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">  
                                    <div class="col-md-6">                                
                                        <div class="form-group">
                                            <input type="hidden" id="actual_total" value="<?php echo $targetData->qty;?>">
                                            <label for="fname" style="font-weight: bold;">Remaining Qty</label>
                                            <label for="fname"><span class="remaintotal"><?php echo $targetData->qty;?></span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">                                
                                        <div class="form-group">
                                            <label for="fname" style="font-weight: bold;">Total Qty</label>
                                            <label for="fname"><span class="total">0</span></label>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="box-footer">
                                <input type="hidden" name="maxTargetQty" id="maxTargetQty" value="<?php echo $targetData->qty;?>">
                                <input type="submit" class="btn btn-primary" name="submit" value="Submit Target">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>          
    </section>
</div>
</div>
</div>  
<?php echo view('brand/inc/footer'); ?>
<script type="text/javascript">

    function checkNegetiveValue(val){
        if(val<=0){
            $('#qty-err').show();
            $('#qty-err').html('Qty can not be less than or equal zero');
            $('#qty').val('');
        } else {
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
            $('#qty-err').hide();
            $('#qty-err').html('');
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
    
    $(document).ready(function(){
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div class="row">\
                            <div class="col-md-6">\
                                <div class="form-group">\
                                    <select class="form-control required" name="state[]" id="state">\
                                        <option value="">Select State</option>\
                                        <?php if($stateData){foreach($stateData as $state){ ?>
                                            <option value="<?php echo $state['state_id'];?>"><?php echo $state['state_title'];?></option>\
                                        <?php } }?>
                                    </select>\
                                </div>\
                            </div>\
                            <div class="col-md-4">\
                                <div class="form-group">\
                                    <input type="text" class="form-control required stateQty" name="qty[]" value="0">\
                                </div>\
                            </div>\
                            <div class="col-md-2">\
                                <div class="form-group">\
                                    <a href="javascript:void(0);" class="remove_button" title="Remove field"><i class="fa fa-minus-circle fa-2x text-danger"></i></a>\
                                </div>\
                            </div>\
                        </div>'; //New input field html 
        var x = 1; //Initial field counter is 1
        
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){ 
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });
        
        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').parent('div').parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
</script>
<script>
    $(document).ready(function(){
        this.value = 0;
        var total = 0;
        var remaintotal = 0;
        var actual_total = parseFloat($('#actual_total').val());
        var $changeInputs = $('input.stateQty');
        $changeInputs.each(function(idx, el) {
          total += Number($(el).val());
          });
        $('.total').text(total.toFixed(2));
        $('.remaintotal').text((actual_total-total).toFixed(2));
        $('body').on('keyup', 'input.stateQty', UpdateTotal);

        function UpdateTotal() {
            var total = 0;
            var actual_total = parseFloat($('#actual_total').val());
            var $changeInputs = $('input.stateQty');
            $changeInputs.each(function(idx, el) {
              total += Number($(el).val());
            });
            var maxTargetQty = $("#maxTargetQty").val();
            if(total <= maxTargetQty){
                $('.total').text(total.toFixed(2));
                $('.remaintotal').text((actual_total-total).toFixed(2));
            } else {          
                alert('You Entered More Then Required Qty!');
                this.value = 0;
                var total = 0;
                var $changeInputs = $('input.stateQty');
                $changeInputs.each(function(idx, el) {
                    total += Number($(el).val());
                });
                $('.total').text(total.toFixed(2));
                $('.remaintotal').text((actual_total-total).toFixed(2));
            }
        }
        $("#addTarget").submit(function(){
            //if(!confirm('Are You Enter Quantity Less Than Allocate Quantity! You Loss District,City Entered Data!')){
            //    event.preventDefault();
            //}
        });
    });
</script>

  