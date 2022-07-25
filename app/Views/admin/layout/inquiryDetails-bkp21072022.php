<?php echo view('admin/layout/header'); ?>
<div class="wrapper-page">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
  <?php echo view('admin/layout/navbar'); ?>
  <?php echo view('admin/layout/sidebar'); ?>
  <div class="main-content">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style type="text/css">
      .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
          color: #fff;
          background-color: #48974e;
      }
      /* TOGGLE STYLING */
      .toggle {
        margin: 0 0 1.5rem;
        box-sizing: border-box;
        font-size: 0;
        display: flex;
        flex-flow: row nowrap;
        justify-content: flex-start;
        align-items: stretch;
      }
      .toggle input {
        width: 0;
        height: 0;
        position: absolute;
        left: -9999px;
      }
      .toggle input + label {
        margin: 0;
        padding: 0.75rem 2rem;
        box-sizing: border-box;
        position: relative;
        display: inline-block;
        border: solid 1px #DDD;
        background-color: #FFF;
        font-size: 1rem;
        line-height: 140%;
        font-weight: 600;
        text-align: center;
        box-shadow: 0 0 0 rgba(255, 255, 255, 0);
        transition: border-color 0.15s ease-out, color 0.25s ease-out, background-color 0.15s ease-out, box-shadow 0.15s ease-out;
        /* ADD THESE PROPERTIES TO SWITCH FROM AUTO WIDTH TO FULL WIDTH */
        /*flex: 0 0 50%; display: flex; justify-content: center; align-items: center;*/
        /* ----- */
      }
      .toggle input + label:first-of-type {
        border-radius: 6px 0 0 6px;
        border-right: none;
      }
      .toggle input + label:last-of-type {
        border-radius: 0 6px 6px 0;
        border-left: none;
      }
      .toggle input:hover + label {
        border-color: #213140;
      }
      .toggle input:checked + label {
        background-color: #5cb85c;
        color: #FFF;
        box-shadow: 0 0 10px rgba(102, 179, 251, 0.5);
        border-color: #5cb85c;
        z-index: 1;
      }
      .toggle input:focus + label {
        outline: dotted 1px #CCC;
        outline-offset: 0.45rem;
      }
      @media (max-width: 800px) {
        .toggle input + label {
          padding: 0.75rem 0.25rem;
          flex: 0 0 50%;
          display: flex;
          justify-content: center;
          align-items: center;
        }
      }

      /* STYLING FOR THE STATUS HELPER TEXT FOR THE DEMO */
      .status {
        margin: 0;
        font-size: 1rem;
        font-weight: 400;
      }
      .status span {
        font-weight: 600;
        color: #B6985A;
      }
      .status span:first-of-type {
        display: inline;
      }
      .status span:last-of-type {
        display: none;
      }
      @media (max-width: 800px) {
        .status span:first-of-type {
          display: none;
        }
        .status span:last-of-type {
          display: inline;
        }
      }
    </style>   
    <!-- Main content -->
    <section class="section">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title" style="float:left">Manage Inventory Inquiry Details
                      <?php if($row->published< 2){?>
                        <!-- <a href="<?=base_url('admin/inquiryApprove/'.encoded($row->id))?>" class="btn btn-success" onclick="return confirm('Are You Sure ?');"><i class="fa fa-check"></i> Approve Inquiry</a> -->
                      <?php }?>
                    </h3>
                </div>
                <div class="col-md-12">
                  <?php if($session->getFlashdata('success_message')) { ?>
                    <p class="alert alert-success"><?php echo $session->getFlashdata('success_message');?></p>
                  <?php } ?>
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
                      $itemDetails            = $common_model->find_data($parentTable, 'row', $conditions, '', $join);
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
                  <form method="POST" action="">
                    <input type="hidden" name="inquiry_id" value="<?=(($row)?$row->id:'')?>">
                    <div class="row mb-3">
                      <?php
                      $require_documents = json_decode($row->require_documents);
                      if(count($require_documents)){ for($i=0;$i<count($require_documents);$i++){
                          $document           = $common_model->find_data('ecoex_document_list', 'row', ['id' => $require_documents[$i]], '');                      
                          $contn                  = [
                              'inquiry_id'            => $row->id,
                              'inventory_details_id'  => $row->inventory_details_id,
                              'document_id'           => $require_documents[$i],
                          ];
                          $checkDocumentUpload    = $common_model->find_data('ecoex_business_inquiry_documents', 'row', $contn);
                          if($checkDocumentUpload){
                              $uploadDocumentStatus = 1;
                              if($checkDocumentUpload->is_share){
                                if($document->documentType == 'AUTOMATIC'){
                                  $uploadDocumentShareStatus = 1;
                                } else {
                                  $uploadDocumentShareStatus = 0;
                                }                            
                              } else {
                                if($document->documentType == 'AUTOMATIC'){
                                  $uploadDocumentShareStatus = 1;
                                } else {
                                  $uploadDocumentShareStatus = 0;
                                }
                              }                          
                          } else {
                              $uploadDocumentStatus       = 0;
                              $uploadDocumentShareStatus  = 0;
                          }

                      ?>                        
                        <input type="hidden" name="inquiry_document_id[]" value="<?=$checkDocumentUpload->id?>">
                        <!-- <input type="hidden" name="actual_document_id[]" value="<?=$require_documents[$i]?>"> -->
                        <div class="col-md-4 mb-3">
                          <div class="card">
                            <div class="card-header">
                              <h4 class="text-center"><?=(($document)?$document->documentName:'')?></h4>
                              <input type="hidden" name="document_id[]" value="<?=$require_documents[$i]?>">
                              <h5 class="text-center"><?=(($document)?$document->documentType:'')?> SHARE</h5>
                            </div>
                            <div class="card-body">
                              <div class="form-group">
                                <a href="<?=base_url('/writable/uploads/'.$checkDocumentUpload->inquiry_document)?>" target="_blank"><img src="<?=base_url('/writable/uploads/'.$checkDocumentUpload->inquiry_document)?>" class="img-thumbnail" style="height: 300px; width: 100%;" /></a><br><br>
                                <?php if($checkDocumentUpload){?>
                                    <!-- <a href="<?=base_url('/writable/uploads/'.$checkDocumentUpload->inquiry_document)?>" target="_blank"><img src="<?=base_url('/writable/uploads/'.$checkDocumentUpload->inquiry_document)?>" class="img-thumbnail" style="height: 300px; width: 100%;" /></a><br><br> -->
                                <?php } else {?>
                                    <!-- <input type="file" class="form-control" name="inquiry_document[]" id="inquiry_document<?=$require_documents[$i]?>" accept="image/gif, image/jpeg, image/png" <?=(($uploadDocumentStatus==0)?'required':'')?>> -->
                                <?php }?>
                              </div>
                            </div>
                            <div class="card-footer">

                              <div class="toggle">
                                <input type="radio" name="is_share<?=$require_documents[$i]?>" value="0" id="notShare<?=$require_documents[$i]?>" <?=(($uploadDocumentShareStatus==0)?'checked':'')?> />
                                <label for="notShare<?=$require_documents[$i]?>">Not Share To Buyer</label>
                                <input type="radio" name="is_share<?=$require_documents[$i]?>" value="1" id="share<?=$require_documents[$i]?>" <?=(($uploadDocumentShareStatus==1)?'checked':'')?> />
                                <label for="share<?=$require_documents[$i]?>">Share To Buyer</label>
                              </div>

                            </div>
                          </div>                      
                        </div> 
                      <?php } }?>
                    </div>
                    <?php if($row->published< 2){?>
                    <button type="submit" class="btn btn-success">Approve Inquiry & Share</button>
                    <?php }?>
                  </form>

                  <?php if($row->published == 4){?>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="card">
                                <div class="card-header">
                                    Upload Purchase Order
                                </div>
                                <div class="card-body">                                    
                                    <a href="<?=base_url('/writable/uploads/'.$row->po_documents)?>" target="_blank" class="label label-info">View PO</a>
                                    <br><br>
                                    <a href="<?=base_url('admin/sharePO/'.encoded($row->id))?>" class="btn btn-success" onclick="return confirm('Are You Sure ?');"><i class="fa fa-check"></i> Share PO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                  <?php } ?>

                </div>                
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