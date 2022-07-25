<?php echo view('collector/inc/header'); ?>
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
                <div class="d-flex justify-content-between pt-3 pb-3 pl-3 pr-3 align-items-center">
                  <form role="form" id="editTarget" action="editInventoryData" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">&nbsp;</div>
                                <div class="col-md-4">                                    
                                    <label>Inventory Type *</label>
                                    <div class="toggle">
                                        <input type="radio" name="inventory_type" value="BUY" id="inventory_type1" <?=(($inventoryData->inventory_type == 'BUY')?'checked':'')?> required onclick="getMainCategory('BUY',<?=$user_member_type?>,'collector/getMainCategory/');"/>
                                        <label for="inventory_type1">I Want To <b>BUY</b></label>
                                        <input type="radio" name="inventory_type" value="SELL" id="inventory_type2" <?=(($inventoryData->inventory_type == 'SELL')?'checked':'')?> required onclick="getMainCategory('SELL',<?=$user_member_type?>,'collector/getMainCategory/');"/>
                                        <label for="inventory_type2">I Want To <b>SELL</b></label>
                                    </div>
                                </div>
                                <div class="col-md-4">&nbsp;</div>
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
                                            <option value="2223" <?php if($inventoryData->year == '2223'){ echo 'selected'; } ?>>2022-2023</option>
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
                                        <input type="text" class="form-control" name="qty" id="qty" value="<?php echo $inventoryData->qty;?>" required>
                                    </div>
                                </div>
                                <div class="col-md-2">                                
                                    <div class="form-group">
                                        <label for="unit">Select Unit *</label>
                                        <select class="form-control" name="unit" id="unit" required>
                                            <option value="">Select Unit</option>
                                            <?php foreach($unitData as $unit){ ?>
                                                <option value="<?php echo $unit['id'];?>" <?php if($inventoryData->unit == $unit['id']){ echo 'selected'; } ?>>
                                                    <?php echo $unit['name'];?></option>
                                            <?php } ?>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-2">                                
                                    <div class="form-group">
                                        <label for="fname">Rate Per Unit *</label>
                                        <input type="text" class="form-control" name="rate" step="0.1" value="<?php echo $inventoryData->rate;?>" required>
                                    </div>
                                </div>
                                <div class="col-md-2">                                
                                    <div class="form-group">
                                        <?php if($inventoryData->attachment != ''){?>
                                            <p><img src="<?=base_url('/writable/uploads/'.$inventoryData->attachment)?>" style="width: 100px; height: 100px;"></p>
                                        <?php }?>
                                        <label for="attachment">Image</label>
                                        <input type="file" class="form-control" name="attachment" id="attachment">
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="hidden" name="stateAllocateValue" id="stateAllocateValue" value="<?php echo $getAllocateStateData->allocateQty;?>">
                            <input type="submit" class="btn btn-primary" name="submit" value="Edit Inventory">
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
        let url             = 'collector/getMainCategory/';
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
    });
</script>