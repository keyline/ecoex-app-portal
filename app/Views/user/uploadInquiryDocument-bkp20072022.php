<?php echo view('user/inc/header'); ?>
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="toptile_search">
                        <div class="page-title">
                          <h2>Upload Inquiry Documents</h2>                          
                        </div>
                        &nbsp;&nbsp;&nbsp; 
                        <?php if($row->published == 2){?>
                            <?php if($row->po_documents == '' && $userId == $row->buyer_id){?>
                                <a href="<?=base_url('user/inquiryAcceptDocument/'.encoded($row->id))?>" class="btn btn-success" onclick="return confirm('Are You Sure ?');"><i class="fa fa-check"></i> Accept Inquiry Documents</a>
                            <?php }?>
                        <?php }?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?php if($session->getFlashdata('success_message')) { ?>
                        <p class="alert alert-success"><?php echo $session->getFlashdata('success_message');?></p>
                    <?php } ?>
                  <div class="dashboard_white_panel mt-3">
                    <div class="d-flex justify-content-between pt-3 pb-3 pl-3 pr-3 align-items-center">                      
                        <div class="box-body">
                            <?php
                            if($row) {
                                if($row->seller_type == 'Brand'){
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
                                $join[0]                = ['table' => $childTable, 'field' => $childField, 'table_master' => $parentTable, 'field_table_master' => $parentField, 'type' => 'INNER'];
                                $conditions             = [$childTable.'.id' => $row->inventory_details_id];
                                $itemDetails            = $this->common_model->find_data($parentTable, 'row', $conditions, '', $join);
                                $state        = [];
                                $unit         = [];
                                $category     = [];
                                $subcategory  = [];
                                $product      = [];
                                $item         = [];
                                if($itemDetails){
                                  $state          = $common_model->find_data('ecoex_state', 'row', ['state_id' => $itemDetails->state_id], 'state_title');
                                  $unit           = $common_model->find_data('ecoex_unit', 'row', ['id' => $itemDetails->unit], 'name');
                                  $category       = $common_model->find_data('ecoex_business_category', 'row', ['id' => $itemDetails->categoryId], 'name');
                                  $subcategory    = $common_model->find_data('ecoex_business_category', 'row', ['id' => $itemDetails->sucCatId], 'name');
                                  $product        = $common_model->find_data('ecoex_business_category', 'row', ['id' => $itemDetails->productId], 'name');
                                  $item           = $common_model->find_data('ecoex_business_category', 'row', ['id' => $itemDetails->itemId], 'name');
                                }
                            }
                            ?>

                            <?php if($row->published >= 3){?>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="card">
                                        <div class="card-header">
                                            Upload Purchase Order
                                        </div>
                                        <div class="card-body">
                                            <?php if($row->po_documents == ''){?>
                                                <?php if($userId == $row->buyer_id) {?>
                                                    <form method="post" action="<?=base_url('/user/uploadPO/'.encoded($row->id))?>" enctype="multipart/form-data">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="file" class="form-control" name="po_documents" id="po_documents" accept="application/pdf" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="submit" class="btn btn-success" value="Submit">
                                                            </div>
                                                        </div>
                                                    </form>
                                                <?php }?>
                                            <?php } else {?>
                                                <?php if($userId == $row->buyer_id) {?>
                                                    <a href="<?=base_url('/writable/uploads/'.$row->po_documents)?>" target="_blank" class="badge badge-success">View PO</a>
                                                <?php } elseif($userId != $row->buyer_id && $row->published == 5) {?>
                                                    <a href="<?=base_url('/writable/uploads/'.$row->po_documents)?>" target="_blank" class="badge badge-success">View PO</a>
                                                <?php } ?>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <h4>Category</h4>
                                    <span><?=(($category)?$category->name:'')?></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <h4>Sub-Category</h4>
                                    <span><?=(($subcategory)?$subcategory->name:'')?></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <h4>Product</h4>
                                    <span><?=(($product)?$product->name:'')?></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <h4>Item</h4>
                                    <span><?=(($item)?$item->name:'')?></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <h4>State</h4>
                                    <span><?=(($state)?$state->state_title:'')?></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <h4>Month/year</h4>
                                    <span>
                                        <?=$common_model->monthName($itemDetails->month)?> / <?=$common_model->financialyear($itemDetails->year)?>
                                    </span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <h4>Rate</h4>
                                    <span><?=(($itemDetails)?$itemDetails->rate:'')?></span>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <h4>Required Qty</h4>
                                    <span><?=(($row)?$row->require_qty:'')?></span>
                                </div>                                    
                            </div>
                            <form method="post" enctype="multipart/form-data">
                                <input type="hidden" name="inquiry_id" value="<?=$row->id?>">
                                <input type="hidden" name="inventory_details_id" value="<?=$row->inventory_details_id?>">
                                <div class="row mb-3">
                                    <?php
                                    $require_documents = json_decode($row->require_documents);
                                    //pr($require_documents, false);
                                    if(count($require_documents)){ for($i=0;$i<count($require_documents);$i++){
                                        $document           = $common_model->find_data('ecoex_document_list', 'row', ['id' => $require_documents[$i]], 'documentName');
                                        $contn                  = [
                                            'inquiry_id'            => $row->id,
                                            'inventory_details_id'  => $row->inventory_details_id,
                                            'document_id'           => $require_documents[$i],
                                        ];
                                        $checkDocumentUpload    = $common_model->find_data('ecoex_business_inquiry_documents', 'row', $contn);
                                        if($checkDocumentUpload){
                                            $uploadDocumentStatus = 1;
                                        } else {
                                            $uploadDocumentStatus = 0;
                                        }
                                        //if($checkDocumentUpload->is_share){
                                    ?>
                                        <div class="col-md-4 mb-3">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="text-center"><?=(($document)?$document->documentName:'')?></h4>
                                                    <input type="hidden" name="document_id[]" value="<?=$require_documents[$i]?>">
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <?php if($checkDocumentUpload){?>
                                                            <?php if($checkDocumentUpload->is_share){?>
                                                                <a href="<?=base_url('/writable/uploads/'.$checkDocumentUpload->inquiry_document)?>" target="_blank"><img src="<?=base_url('/writable/uploads/'.$checkDocumentUpload->inquiry_document)?>" class="img-thumbnail" style="height: 300px; width: 100%;" /></a><br><br>
                                                            <?php }?>
                                                        <?php } else {?>
                                                            <input type="file" class="form-control" name="inquiry_document[]" id="inquiry_document<?=$require_documents[$i]?>" accept="image/gif, image/jpeg, image/png" <?=(($uploadDocumentStatus==0)?'required':'')?>>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            </div>                      
                                        </div>
                                        <?php //}?>
                                    <?php } }?>                                   
                                </div>
                                <?php if(!$checkDocumentUpload){?>
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                <?php }?>
                            </form>
                            
                        </div>
                        <div class="box-footer">
                            
                        </div>                        
                    </div>
                  </div>
                </div>
            </div>          
        </section>
    </div>      
</div>
</div>  
<?php echo view('user/inc/footer'); ?>
<script>    
    $(document).ready(function(){ 
        //
    });
</script>

  