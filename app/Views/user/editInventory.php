<?php echo view('user/inc/header'); ?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="row">
            <div class="col-lg-12">
              <div class="toptile_search">
                <div class="page-title">
                  <h2>Edit Inventory</h2>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="dashboard_white_panel mt-3">
                <?php if($session->getFlashdata('error_message')){?>
                    <p class="alert alert-danger"><?=$session->getFlashdata('error_message')?></p>
                <?php }?>
                <div class="d-flex justify-content-between pt-3 pb-3 pl-3 pr-3 align-items-center">
                  <form role="form" id="editTarget" action="editInventoryData" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">&nbsp;</div>
                                <div class="col-md-6">                                    
                                    <label>Inventory Type *</label>
                                    <div class="toggle">
                                        <input type="radio" name="inventory_type" value="BUY" id="inventory_type1" <?=(($inventoryData->inventory_type == 'BUY')?'checked':'')?> required onclick="getMainCategory('BUY',<?=$user_member_type?>,'user/getMainCategory/');"/>
                                        <label for="inventory_type1">I Want To <b>BUY</b></label>
                                        <input type="radio" name="inventory_type" value="SELL" id="inventory_type2" <?=(($inventoryData->inventory_type == 'SELL')?'checked':'')?> required onclick="getMainCategory('SELL',<?=$user_member_type?>,'user/getMainCategory/');"/>
                                        <label for="inventory_type2">I Want To <b>SELL</b></label>
                                    </div>
                                </div>
                                <div class="col-md-3">&nbsp;</div>

                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="category">Select Category *</label>
                                        <select class="form-control" name="category" id="category" required>
                                            <option value="">Select Category</option>
                                            <?php foreach($categoryData as $category){ ?>
                                                <!-- <option value="<?php echo $category['id'];?>" <?php if($inventoryData->categoryId == $category['id']){ echo 'selected'; } ?>>
                                                    <?php echo $category['name'];?></option> -->
                                            <?php } ?>
                                        </select>    
                                    </div>
                                </div>
                                <?php 
                                $subCategoryData = $contoroller->getBusinessSubCategoryList($inventoryData->categoryId);
                                ?>
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="subCategory">Select Sub Category *</label>
                                        <select class="form-control" name="subCategory" id="subCategory" required>
                                            <option value="">Select Sub Category</option>
                                            <?php foreach($subCategoryData as $category){ ?>
                                                <option value="<?php echo $category['id'];?>" <?php if($inventoryData->sucCatId == $category['id']){ echo 'selected'; } ?>>
                                                    <?php echo $category['name'];?></option>
                                            <?php } ?>
                                        </select>    
                                    </div>
                                </div>

                                <?php 
                                $itemData = $contoroller->getBusinessSubCategoryList($inventoryData->sucCatId);
                                $getAllocateStateData = $contoroller->getAllocateQtyState($inventoryData->target_id);
                                ?>                                
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="fname">Select Product *</label>
                                        <select class="form-control" name="product" id="product" required>
                                            <option value="">Select Product</option>
                                            <?php foreach($itemData as $category){ ?>
                                                <option value="<?php echo $category['id'];?>" <?php if($inventoryData->productId == $category['id']){ echo 'selected'; } ?>>
                                                    <?php echo $category['name'];?></option>
                                            <?php } ?>
                                        </select>    
                                    </div>
                                </div>
                                <?php 
                                $itemData = $contoroller->getBusinessSubCategoryList($inventoryData->productId);
                                $getAllocateStateData = $contoroller->getAllocateQtyState($inventoryData->inventory_id);
                                ?>                                
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="item">Select Item *</label>
                                        <select class="form-control" name="item" id="item" required>
                                            <option value="">Select Item</option>
                                            <?php foreach($itemData as $category){ ?>
                                                <option value="<?php echo $category['id'];?>" <?php if($inventoryData->itemId == $category['id']){ echo 'selected'; } ?>>
                                                    <?php echo $category['name'];?></option>
                                            <?php } ?>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-2">                                
                                    <div class="form-group">
                                        <label for="year">Select Year *</label>
                                        <select class="form-control" name="year" id="year" required>
                                            <option value="">Select Year</option>
                                            <option value="2022" <?php if($inventoryData->year == '2022'){ echo 'selected'; } ?>>2022-2023</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-2">                                
                                    <div class="form-group">
                                        <label for="month">Select Month *</label>
                                        <select class="form-control" name="month" id="month" required>
                                            <option value="">Select Month</option>
                                            <option value="1" <?php if($inventoryData->month == '1'){ echo 'selected'; } ?>>January</option>
                                            <option value="2" <?php if($inventoryData->month == '2'){ echo 'selected'; } ?>>February</option>
                                            <option value="3" <?php if($inventoryData->month == '3'){ echo 'selected'; } ?>>March</option>
                                            <option value="4" <?php if($inventoryData->month == '4'){ echo 'selected'; } ?>>April</option>
                                            <option value="5" <?php if($inventoryData->month == '5'){ echo 'selected'; } ?>>May</option>
                                            <option value="6" <?php if($inventoryData->month == '6'){ echo 'selected'; } ?>>June</option>
                                            <option value="7" <?php if($inventoryData->month == '7'){ echo 'selected'; } ?>>July</option>
                                            <option value="8" <?php if($inventoryData->month == '8'){ echo 'selected'; } ?>>August</option>
                                            <option value="9" <?php if($inventoryData->month == '9'){ echo 'selected'; } ?>>September</option>
                                            <option value="10" <?php if($inventoryData->month == '10'){ echo 'selected'; } ?>>October</option>
                                            <option value="11" <?php if($inventoryData->month == '11'){ echo 'selected'; } ?>>November</option>
                                            <option value="12" <?php if($inventoryData->month == '12'){ echo 'selected'; } ?>>December</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-2">                                
                                    <div class="form-group">
                                        <label for="qty">Enter Qty *</label>
                                        <input type="text" class="form-control" name="qty" id="qty" value="<?php echo $inventoryData->qty;?>" onblur="checkNegetiveValue(this.value);" onkeypress="return isNumber(event)" required min="1">
                                        <span class="text-danger" id="qty-err" style="display: none;"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">                                
                                    <div class="form-group">
                                        <label for="unit">Select Unit *</label>
                                        <select class="form-control" name="unit" id="unit" readonly required>
                                            <option value="">Select Unit</option>
                                            <?php foreach($unitData as $unit){ ?>
                                                <option value="<?php echo $unit['id'];?>" <?php if($inventoryData->unit == $unit['id']){ echo 'selected'; } ?>>
                                                    <?php echo $unit['name'];?></option>
                                            <?php } ?>
                                        </select>    
                                    </div>
                                </div>
                                <!-- <div class="col-md-2">                                
                                    <div class="form-group">
                                        <label for="fname">Rate Per Unit *</label>
                                        <input type="number" class="form-control required" name="rate" step="0.1" value="<?php echo $inventoryData->rate;?>"  required>
                                    </div>
                                </div> -->
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <?php if($inventoryData->attachment != ''){?>
                                            <p><img src="<?=base_url('/writable/uploads/'.$inventoryData->attachment)?>" class="img-thumbnail" style="width: 100px; height: 100px;"></p>
                                        <?php }?>
                                        <label for="attachment">Image</label>
                                        <input type="file" class="form-control" name="attachment" id="attachment">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div id="documentRequired" style="border:1px solid green; padding: 10px; margin-bottom: 10px;">
                                        <label>Document Required *</label>
                                        <?php $document_required = json_decode($inventoryData->document_required); ?>
                                        <?php if($documentRequires) { foreach($documentRequires as $document){ ?> <br>
                                            <input type="checkbox" class="document_required" name="document_required[]" id="document_required<?=$document->id?>" value="<?php echo $document->id;?>" <?=((in_array($document->id, $document_required))?'checked':'')?>>
                                            <label for="document_required<?php echo $document->id;?>"><?php echo $document->documentName;?></label>
                                        <?php } }?>
                                    </div>                                    
                                </div>

                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="hidden" name="stateAllocateValue" id="stateAllocateValue" value="<?php echo $getAllocateStateData->allocateQty;?>">
                            <input type="submit" id="submit-btn" class="btn btn-primary" name="submit" value="Edit Inventory">
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
  
  <?php echo view('user/inc/footer'); ?>

<script>
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
        $("#category").change(function(){  
             $("#subCategory").html('');
             $("#item").html('');
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
             $("#product").html('');
             $("#item").html('');
            var subCatId = $(this).val();
              $.ajax({   
                type: "GET",
                data: { parent: subCatId,name:'Product' },
                url: "/getBusinessCategory.php",             
                dataType: "html",   //expect html to be returned                
                success: function(response){
                        $("#product").html(response);
                }
            });
        });
        $("#product").change(function(){  
             $("#item").html('');
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

        let inventoryType   = '<?=$inventoryData->inventory_type?>';
        let memberType      = '<?=$user_member_type?>';
        let url             = 'user/getMainCategory/';
        let categoryId      = '<?=$inventoryData->categoryId?>';
        $.ajax({
            type: "GET",
            url: base_url + url,
            data: {
                inventoryType   : inventoryType,
                memberType      : memberType
            },
            dataType: "JSON",
            beforeSend: function () {
                $("#category").loading();
            },
            success: function (res) {
                $("#category").loading("stop");
                if(res.status){
                    $('#category').empty();
                    let html = '<option value="" selected>Select Category</option>';
                    $.each(res.response, function (key, val) {
                        if(categoryId == val.id){
                            selected = 'selected';
                        } else {
                            selected = '';
                        }
                        html += '<option value="'+val.id+'" '+selected+'>'+val.name+'</option>';
                    });
                    $('#category').html(html);
                    //swalAlertThenRedirect(res.message, 'success', base_url + res.response.link);
                }else{                      
                    //swalAlert(res.message, 'warning', 5000);                      
                }
            },
        });

        var inventory_type2 = $('input[name="inventory_type"]:checked').val();
        if(inventory_type2 == 'BUY'){
            $('#documentRequired').show();
        } else {
            $('#documentRequired').hide();
        }

        $('#submit-btn').on('click', function(){
            var inventory_type = $('input[name="inventory_type"]:checked').val();
            if(inventory_type == 'BUY'){
                if($('.document_required:checkbox:checked').length == 0){
                  alert('You Have To select At Least One Document !!!');
                } else {                
                  //
                }
            }            
        });
    });
</script>