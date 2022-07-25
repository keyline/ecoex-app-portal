<?php echo view('admin/layout/header'); ?>
<div class="wrapper-page">
    <div class="main-wrapper">
        <div class="navbar-bg"></div>
        <?php echo view('admin/layout/navbar'); ?>
        <?php echo view('admin/layout/sidebar'); ?>
        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="container-fluid">        
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                          <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Edit Product Category</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form role="form" id="addUser" action="/admin/editBusinessCategoryData" method="post" >
                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-7">                                
                                                <div class="form-group">
                                                    <label for="fname">Select Parent Category *</label>
                                                    <select class="form-control required" name="category" required>
                                                        <option value="0">Select Parent Category</option>
                                                        <option value="0" <?php if($getCategoryData->parent == '0'){ echo 'selected'; } ?>>Parent Category</option>
                                                        <?php 
                                                        foreach($totalCategory as $row){
                                                            $totalCategory51 = $controller->getBusinessCategoryByParentId($row['id']);
                                                            ?>
                                                            <option value="<?php echo $row['id'];?>"
                                                                        <?php if($getCategoryData->parent == $row['id']){ echo 'selected'; } ?>>
                                                                <?php echo $row['name'];?></option>
                                                <!---- code for second sub category ---->
                                                            <?php 
                                                            if(count($totalCategory51) > 0){
                                                            foreach($totalCategory51 as $row51){
                                                                $totalCategory52 = $controller->getBusinessCategoryByParentId($row51['id']);
                                                                ?>
                                                                <option value="<?php echo $row51['id'];?>"
                                                                        <?php if($getCategoryData->parent == $row51['id']){ echo 'selected'; } ?>><?php echo $row['name'];?>-><?php echo $row51['name'];?></option>
                                                            <!---- code for third sub category ---->
                                                                    <?php 
                                                                if(count($totalCategory52) > 0){
                                                                    foreach($totalCategory52 as $row52){
                                                                        $totalCategory53 = $controller->getBusinessCategoryByParentId($row52['id']);
                                                                        ?>
                                                                        <option value="<?php echo $row52['id'];?>"
                                                                        <?php if($getCategoryData->parent == $row52['id']){ echo 'selected'; } ?>>
                                                                            <?php echo $row['name'];?>-><?php echo $row51['name'];?>-><?php echo $row52['name'];?></option>
                                                        <!---- code for forth sub category ---->
                                                                    <?php 
                                                                if(count($totalCategory53) > 0){
                                                                    foreach($totalCategory53 as $row53){
                                                                        $totalCategory54 = $controller->getBusinessCategoryByParentId($row53['id']);
                                                                        ?>
                                                                        <option value="<?php echo $row53['id'];?>" 
                                                                        <?php if($getCategoryData->parent == $row53['id']){ echo 'selected'; } ?> >
                                                                            <?php echo $row['name'];?>-><?php echo $row51['name'];?>-><?php echo $row52['name'];?>-><?php echo $row53['name'];?></option>
                                                                    <?php } ?>  
                                                                    <?php } ?>  
                                                        <!------ Code end  For third Sub Category ----->   
                                                                    <?php } ?>   
                                                                    <?php } ?>  
                                                        <!------ Code end  For third Sub Category ----->               
                                                            <?php } ?>  
                                                <!------ Code end  For Second Sub Category ----->   
                                                        <?php } ?>
                                                        <?php } ?>    
                                                    </select>    
                                                </div>
                                            </div>
                                            <div class="col-md-5">                                
                                                <div class="form-group">
                                                    <label for="fname">Category Name *</label>
                                                    <input type="text" class="form-control required" name="name" value="<?php echo $getCategoryData->name;?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($member_types){ foreach($member_types as $member_type){?>
                                        <?php
                                        $businessCategoryOption = $common_model->find_data('ecoex_business_category_options', 'row', ['category_id' => $getCategoryData->id, 'member_category_id' => $member_type->member_id]);
                                        $typeOptions = [];
                                        if($businessCategoryOption){
                                            $typeOptions = json_decode($businessCategoryOption->options);
                                        }
                                        $buyOption  = 0;
                                        $sellOption = 0;
                                        if(count($typeOptions)>0){

                                            if($typeOptions[0] == 'BUY'){
                                                $buyOption  = 1;
                                            }
                                            if($typeOptions[1] == 'BUY'){
                                                $buyOption  = 1;
                                            }
                                            if($typeOptions[0] == 'SELL'){
                                                $sellOption  = 1;
                                            }
                                            if($typeOptions[1] == 'SELL'){
                                                $sellOption  = 1;
                                            }
                                        } else {
                                            $buyOption  = 0;
                                            $sellOption = 0;
                                        }                            
                                        ?>
                                        <div class="row" style="border: 1px solid #48974e6b;padding: 10px;margin-bottom: 3px;">
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <input type="hidden" name="member_category_id[]" value="<?=$member_type->member_id?>">
                                                    <label><?=$member_type->member_type?></label>
                                                </div>
                                            </div>
                                            <div class="col-md-5">                                    
                                                <input type="checkbox" name="options<?=$member_type->member_id?>[]" id="buy<?=$member_type->member_id?>" value="BUY" <?=(($buyOption)?'checked':'')?>> <label for="buy<?=$member_type->member_id?>">BUY</label>                                    
                                                <input type="checkbox" name="options<?=$member_type->member_id?>[]" id="sell<?=$member_type->member_id?>" value="SELL" <?=(($sellOption)?'checked':'')?>> <label for="sell<?=$member_type->member_id?>">SELL</label>
                                            </div>
                                        </div>
                                        <?php } }?>
                                    </div><!-- /.box-body -->
                
                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-primary" name="submit" value="Edit Category">
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                    </div>   
                </div>
            </section>
        </div>
      <!-- Main Content -->
    </div>
</div>
<?php echo view('admin/layout/footer'); ?>