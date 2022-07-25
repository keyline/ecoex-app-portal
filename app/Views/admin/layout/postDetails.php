<?php echo view('admin/layout/header'); ?>
<div class="wrapper-page">
    <div class="main-wrapper">
        <div class="navbar-bg"></div>
        <?php echo view('admin/layout/navbar'); ?>
        <?php echo view('admin/layout/sidebar'); ?>
        <div class="main-content">
            <section class="section">
                <div class="container-fluid">        
            		<div class="row">
                    	<div class="col-md-12">        	       
                        	<div class="memberdetails_inner_section">                	                    
                                <div class="memberdetl_middle">
                                	<div class="middle-title mb-4">
                                    	<h3>Member Details</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h4>Company Name</h4>
                                            <p><?=(($seller)?$seller->c_name:'')?></p>
                                        </div>
                                        <div class="col-md-3">
                                            <h4>Name</h4>
                                            <p><?=(($seller)?$seller->user_name:'')?></p>
                                        </div>
                                        <div class="col-md-3">
                                            <h4>Email</h4>
                                            <p><?=(($seller)?$seller->user_email:'')?></p>
                                        </div>
                                        <div class="col-md-3">
                                            <h4>Mobile</h4>
                                            <p><?=(($seller)?$seller->user_mobile:'')?></p>
                                        </div>
                                    </div>
                                    <?php
                                        $category      = $common_model->find_data('ecoex_business_category', 'row', ['id' => $inventory[0]->categoryId], 'name');
                                        $subcategory   = $common_model->find_data('ecoex_business_category', 'row', ['id' => $inventory[0]->sucCatId], 'name');
                                        $product       = $common_model->find_data('ecoex_business_category', 'row', ['id' => $inventory[0]->productId], 'name');
                                        $item          = $common_model->find_data('ecoex_business_category', 'row', ['id' => $inventory[0]->itemId], 'name');
                                        $unit          = $common_model->find_data('ecoex_unit', 'row', ['id' => $inventory[0]->unit], 'name');

                                        if($memberTypeId<=1){
                                            $parentTable          = 'ecoex_target';
                                            $parentField          = 'target_id';
                                            $childTable           = 'ecoex_target_by_state';
                                            $childField           = 'target_id';
                                        } else {
                                            $parentTable          = 'ecoex_inventory';
                                            $parentField          = 'inventory_id';
                                            $childTable           = 'ecoex_inventory_by_state';
                                            $childField           = 'inventory_id';
                                        }

                                        $join[0]                = ['table' => 'ecoex_state', 'field' => 'state_id', 'table_master' => $childTable, 'field_table_master' => 'state_id', 'type' => 'INNER'];
                                        $stateWiseQty  = $common_model->find_data($childTable, 'array', [$childTable.'.'.$childField => $inventory[0]->$childField], '', $join);
                                        //pr($stateWiseQty,false);
                                    ?>
                                    <div class="middle-title mb-4">
                                        <h3>Item Details</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h4>Main Category</h4>
                                            <p><?=(($category)?$category->name:'')?></p>
                                        </div>
                                        <div class="col-md-3">
                                            <h4>Sub Category</h4>
                                            <p><?=(($subcategory)?$subcategory->name:'')?></p>
                                        </div>
                                        <div class="col-md-3">
                                            <h4>Product</h4>
                                            <p><?=(($product)?$product->name:'')?></p>
                                        </div>
                                        <div class="col-md-3">
                                            <h4>Item</h4>
                                            <p><?=(($item)?$item->name:'')?></p>
                                        </div>
                                    </div>

                                    <div class="middle-title mb-4">
                                        <h3>Other Details</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h4>Inventory Type</h4>
                                            <p class="<?=(($inventory[0]->inventory_type == 'BUY')?'text-success':'text-danger')?>"><?=$inventory[0]->inventory_type?></p>
                                        </div>
                                        <div class="col-md-3">
                                            <h4>Month</h4>
                                            <p><?=$common_model->monthName($inventory[0]->month)?></p>
                                        </div>
                                        <div class="col-md-3">
                                            <h4>Year</h4>
                                            <p><?=$inventory[0]->year?></p>
                                        </div>
                                        <div class="col-md-3">
                                            <h4>Total Quantity</h4>
                                            <p><?=$inventory[0]->qty?> <?=$unit->name?></p>
                                        </div>
                                    </div>
                                    <div class="middle-title mb-4">
                                        <h3>State Wise Details</h3>
                                    </div>
                                    <div class="row">
                                        <?php if($stateWiseQty){foreach($stateWiseQty as $stateWiseQty){?>
                                        <div class="col-md-3">
                                            <h4><?=$stateWiseQty->state_title?></h4>
                                            <p><?=$stateWiseQty->req_qty?> <?=$unit->name?></p>
                                        </div>
                                        <?php } }?>
                                    </div>
                                </div>
                                <?php if($inventory[0]->attachment != ''){?>
                                <div class="memberdetl_address">
                                	<div class="middle-title mb-4">
                                    	<h3>Attachment</h3>
                                    </div>
                                	<div class="col pl-0">                            
                                        <p><img src="<?=base_url('/writable/uploads/'.$inventory[0]->attachment)?>" class="img-thumbnail"></p>
                                    </div>
                                </div>
                                <?php }?>
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