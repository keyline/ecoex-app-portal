<?php echo view('admin/layout/header'); ?>
<div class="wrapper-page">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
  <?php echo view('admin/layout/navbar'); ?>
  <?php echo view('admin/layout/sidebar'); ?>
  <!-- Main Content -->
      <div class="main-content">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style type="text/css">
        .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
            color: #fff;
            background-color: #48974e;
        }
    </style>   
    <!-- Main content -->
    <section class="section">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title" style="float:left">Manage Inventory Inquiry</h3>
                </div>
                <div class="col-md-12">
                  <?php if($session->getFlashdata('success_message')) { ?>
                    <p class="alert alert-success"><?php echo $session->getFlashdata('success_message');?></p>
                  <?php } ?>                  
                  <ul class="nav nav-pills">
                    <li class="active"><a data-toggle="pill" href="#menu1" style="font-size: 13px;">Inquiry Submit (<?=count($submittedInquiries)?>)</a></li>
                    <li><a data-toggle="pill" href="#menu2" style="font-size: 13px;">Document Uploaded (<?=count($documentUploadedInquiries)?>)</a></li>
                    <li><a data-toggle="pill" href="#menu3" style="font-size: 13px;">Admin Approved (<?=count($adminApprovedInquiries)?>)</a></li>
                    <li><a data-toggle="pill" href="#menu4" style="font-size: 13px;">Buyer Accept (<?=count($buyerAcceptInquiries)?>)</a></li>
                    <li><a data-toggle="pill" href="#menu5" style="font-size: 13px;">PO Upload (<?=count($poUploadInquiries)?>)</a></li>
                    <li><a data-toggle="pill" href="#menu6" style="font-size: 13px;">PO Shared (<?=count($poSharedInquiries)?>)</a></li>
                    <li><a data-toggle="pill" href="#menu7" style="font-size: 13px;">Admin Invoice (<?=count($adminInvoicesInquiries)?>)</a></li>
                    <li><a data-toggle="pill" href="#menu8" style="font-size: 13px;">Buyer Payment Upload (<?=count($paymentUploadsInquiries)?>)</a></li>
                    <li><a data-toggle="pill" href="#menu9" style="font-size: 13px;">Admin Payment Accept (<?=count($paymentAcceptInquiries)?>)</a></li>
                  </ul>                  
                  <div class="tab-content">
                    <div id="menu1" class="tab-pane fade in active">
                      <h3>Inquiry Submit</h3>
                      <table id="example" class="table table-bordered table-stripped">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Inquiry Type/<br>Inquiry Number</th>
                            <th>Category/<br>Sub Category/<br>Product/<br>Item</th>
                            <th>State</th>
                            <th>Required Qty</th>
                            <th>Document Needs To Upload</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if($submittedInquiries) { $sl=1; foreach($submittedInquiries as $row){
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
                          ?>
                          <tr>
                            <td><?=$sl++?></td>
                            <td>
                              <span class="targe_table_pname" <?=(($itemDetails->inventory_type == 'BUY')?'style="color:green;"':'style="color:red;"')?>><?=$itemDetails->inventory_type?></span>
                              <br>
                              <?=$row->inquiry_no?>
                            </td>
                            <td>
                              <?=(($category)?$category->name:'')?><br>
                              <?=(($subcategory)?$subcategory->name:'')?><br>
                              <?=(($product)?$product->name:'')?><br>
                              <?=(($item)?$item->name:'')?>
                            </td>
                            <td><?=(($state)?$state->state_title:'')?></td>
                            <td><?=$row->require_qty?></td>
                            <td>
                              <?php
                              $require_documents = json_decode($row->require_documents);
                              ?>
                              <ul class="list-group">
                                <?php
                                if(count($require_documents)){ for($i=0;$i<count($require_documents);$i++){
                                  $document           = $common_model->find_data('ecoex_document_list', 'row', ['id' => $require_documents[$i]], 'documentName');
                                ?>
                                <li class="list-group-item"><?=(($document)?$document->documentName:'')?></li>
                                <?php } }?>
                              </ul>
                            </td>
                            <td>
                              <a href="<?=base_url('admin/inquiryDetails/'.encoded($row->id))?>" class="btn btn-success"><i class="fa fa-info-circle"></i> Inquiry Details</a>                             
                            </td>
                          </tr>
                          <?php } } else {?>
                            <tr>
                              <td colspan="7" style="text-align: center;">No Records Found !!!</td>
                            </tr>
                          <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                      <h3>Document Uploaded</h3>                      
                      <table class="table table-bordered table-stripped">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Inquiry Type/<br>Inquiry Number</th>
                            <th>Category/<br>Sub Category/<br>Product/<br>Item</th>
                            <th>State</th>
                            <th>Required Qty</th>
                            <th>Document Needs To Upload</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          //pr($documentUploadedInquiries);
                          if($documentUploadedInquiries) { $sl=1; foreach($documentUploadedInquiries as $row){
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
                            //$this->db = \Config\Database::connect();
                            //echo $this->db->getLastQuery();die;
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
                          ?>
                          <tr>
                            <td><?=$sl++?></td>
                            <td>
                              <span class="targe_table_pname" <?=(($itemDetails->inventory_type == 'BUY')?'style="color:green;"':'style="color:red;"')?>><?=$itemDetails->inventory_type?></span>
                              <br>
                              <?=$row->inquiry_no?>
                            </td>
                            <td>
                              <?=(($category)?$category->name:'')?><br>
                              <?=(($subcategory)?$subcategory->name:'')?><br>
                              <?=(($product)?$product->name:'')?><br>
                              <?=(($item)?$item->name:'')?>
                            </td>
                            <td><?=(($state)?$state->state_title:'')?></td>
                            <td><?=$row->require_qty?></td>
                            <td>
                              <?php
                              $require_documents = json_decode($row->require_documents);
                              ?>
                              <ul class="list-group">
                                <?php
                                if(count($require_documents)){ for($i=0;$i<count($require_documents);$i++){
                                  $document           = $common_model->find_data('ecoex_document_list', 'row', ['id' => $require_documents[$i]], 'documentName');
                                ?>
                                <li class="list-group-item"><?=(($document)?$document->documentName:'')?></li>
                                <?php } }?>
                              </ul>
                            </td>
                            <td>                              
                              <a href="<?=base_url('admin/inquiryDetails/'.encoded($row->id))?>" class="btn btn-success"><i class="fa fa-check-circle"></i> Verify Document</a>
                            </td>
                          </tr>
                          <?php } } else {?>
                            <tr>
                              <td colspan="7" style="text-align: center;">No Records Found !!!</td>
                            </tr>
                          <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <div id="menu3" class="tab-pane fade">
                      <h3>Admin Approved</h3>                      
                      <table class="table table-bordered table-stripped">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Inquiry Type/<br>Inquiry Number</th>
                            <th>Category/<br>Sub Category/<br>Product/<br>Item</th>
                            <th>State</th>
                            <th>Required Qty</th>
                            <th>Document Needs To Upload</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if($adminApprovedInquiries) { $sl=1; foreach($adminApprovedInquiries as $row){
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
                          ?>
                          <tr>
                            <td><?=$sl++?></td>
                            <td>
                              <span class="targe_table_pname" <?=(($itemDetails->inventory_type == 'BUY')?'style="color:green;"':'style="color:red;"')?>><?=$itemDetails->inventory_type?></span>
                              <br>
                              <?=$row->inquiry_no?>
                            </td>
                            <td>
                              <?=(($category)?$category->name:'')?><br>
                              <?=(($subcategory)?$subcategory->name:'')?><br>
                              <?=(($product)?$product->name:'')?><br>
                              <?=(($item)?$item->name:'')?>
                            </td>
                            <td><?=(($state)?$state->state_title:'')?></td>
                            <td><?=$row->require_qty?></td>
                            <td>
                              <?php
                              $require_documents = json_decode($row->require_documents);
                              ?>
                              <ul class="list-group">
                                <?php
                                if(count($require_documents)){ for($i=0;$i<count($require_documents);$i++){
                                  $document           = $common_model->find_data('ecoex_document_list', 'row', ['id' => $require_documents[$i]], 'documentName');
                                ?>
                                <li class="list-group-item"><?=(($document)?$document->documentName:'')?></li>
                                <?php } }?>
                              </ul>
                            </td>
                            <td>
                              <a href="<?=base_url('admin/inquiryDetails/'.encoded($row->id))?>" class="btn btn-success"><i class="fa fa-info-circle"></i> Inquiry Details</a>                             
                            </td>
                          </tr>
                          <?php } } else {?>
                            <tr>
                              <td colspan="7" style="text-align: center;">No Records Found !!!</td>
                            </tr>
                          <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <div id="menu4" class="tab-pane fade">
                      <h3>Buyer Accept</h3>                      
                      <table class="table table-bordered table-stripped">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Inquiry Type/<br>Inquiry Number</th>
                            <th>Category/<br>Sub Category/<br>Product/<br>Item</th>
                            <th>State</th>
                            <th>Required Qty</th>
                            <th>Document Needs To Upload</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if($buyerAcceptInquiries) { $sl=1; foreach($buyerAcceptInquiries as $row){
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
                          ?>
                          <tr>
                            <td><?=$sl++?></td>
                            <td>
                              <span class="targe_table_pname" <?=(($itemDetails->inventory_type == 'BUY')?'style="color:green;"':'style="color:red;"')?>><?=$itemDetails->inventory_type?></span>
                              <br>
                              <?=$row->inquiry_no?>
                            </td>
                            <td>
                              <?=(($category)?$category->name:'')?><br>
                              <?=(($subcategory)?$subcategory->name:'')?><br>
                              <?=(($product)?$product->name:'')?><br>
                              <?=(($item)?$item->name:'')?>
                            </td>
                            <td><?=(($state)?$state->state_title:'')?></td>
                            <td><?=$row->require_qty?></td>
                            <td>
                              <?php
                              $require_documents = json_decode($row->require_documents);
                              ?>
                              <ul class="list-group">
                                <?php
                                if(count($require_documents)){ for($i=0;$i<count($require_documents);$i++){
                                  $document           = $common_model->find_data('ecoex_document_list', 'row', ['id' => $require_documents[$i]], 'documentName');
                                ?>
                                <li class="list-group-item"><?=(($document)?$document->documentName:'')?></li>
                                <?php } }?>
                              </ul>
                            </td>
                            <td>
                              <a href="<?=base_url('admin/inquiryDetails/'.encoded($row->id))?>" class="btn btn-success"><i class="fa fa-info-circle"></i> Inquiry Details</a>                             
                            </td>
                          </tr>
                          <?php } } else {?>
                            <tr>
                              <td colspan="7" style="text-align: center;">No Records Found !!!</td>
                            </tr>
                          <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <div id="menu5" class="tab-pane fade">
                      <h3>PO Upload</h3>                      
                      <table class="table table-bordered table-stripped">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Inquiry Type/<br>Inquiry Number</th>
                            <th>Category/<br>Sub Category/<br>Product/<br>Item</th>
                            <th>State</th>
                            <th>Required Qty</th>
                            <th>Document Needs To Upload</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if($poUploadInquiries) { $sl=1; foreach($poUploadInquiries as $row){
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
                          ?>
                          <tr>
                            <td><?=$sl++?></td>
                            <td>
                              <span class="targe_table_pname" <?=(($itemDetails->inventory_type == 'BUY')?'style="color:green;"':'style="color:red;"')?>><?=$itemDetails->inventory_type?></span>
                              <br>
                              <?=$row->inquiry_no?>
                            </td>
                            <td>
                              <?=(($category)?$category->name:'')?><br>
                              <?=(($subcategory)?$subcategory->name:'')?><br>
                              <?=(($product)?$product->name:'')?><br>
                              <?=(($item)?$item->name:'')?>
                            </td>
                            <td><?=(($state)?$state->state_title:'')?></td>
                            <td><?=$row->require_qty?></td>
                            <td>
                              <?php
                              $require_documents = json_decode($row->require_documents);
                              ?>
                              <ul class="list-group">
                                <?php
                                if(count($require_documents)){ for($i=0;$i<count($require_documents);$i++){
                                  $document           = $common_model->find_data('ecoex_document_list', 'row', ['id' => $require_documents[$i]], 'documentName');
                                ?>
                                <li class="list-group-item"><?=(($document)?$document->documentName:'')?></li>
                                <?php } }?>
                              </ul>
                            </td>
                            <td>
                              <a href="<?=base_url('admin/inquiryDetails/'.encoded($row->id))?>" class="btn btn-success"><i class="fa fa-info-circle"></i> Inquiry Details</a>                              
                            </td>
                          </tr>
                          <?php } } else {?>
                            <tr>
                              <td colspan="7" style="text-align: center;">No Records Found !!!</td>
                            </tr>
                          <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <div id="menu6" class="tab-pane fade">
                      <h3>PO Shared</h3>                      
                      <table class="table table-bordered table-stripped">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Inquiry Type/<br>Inquiry Number</th>
                            <th>Category/<br>Sub Category/<br>Product/<br>Item</th>
                            <th>State</th>
                            <th>Required Qty</th>
                            <th>Document Needs To Upload</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if($poSharedInquiries) { $sl=1; foreach($poSharedInquiries as $row){
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
                          ?>
                          <tr>
                            <td><?=$sl++?></td>
                            <td>
                              <span class="targe_table_pname" <?=(($itemDetails->inventory_type == 'BUY')?'style="color:green;"':'style="color:red;"')?>><?=$itemDetails->inventory_type?></span>
                              <br>
                              <?=$row->inquiry_no?>
                            </td>
                            <td>
                              <?=(($category)?$category->name:'')?><br>
                              <?=(($subcategory)?$subcategory->name:'')?><br>
                              <?=(($product)?$product->name:'')?><br>
                              <?=(($item)?$item->name:'')?>
                            </td>
                            <td><?=(($state)?$state->state_title:'')?></td>
                            <td><?=$row->require_qty?></td>
                            <td>
                              <?php
                              $require_documents = json_decode($row->require_documents);
                              ?>
                              <ul class="list-group">
                                <?php
                                if(count($require_documents)){ for($i=0;$i<count($require_documents);$i++){
                                  $document           = $common_model->find_data('ecoex_document_list', 'row', ['id' => $require_documents[$i]], 'documentName');
                                ?>
                                <li class="list-group-item"><?=(($document)?$document->documentName:'')?></li>
                                <?php } }?>
                              </ul>
                            </td>
                            <td>
                              <a href="<?=base_url('admin/inquiryDetails/'.encoded($row->id))?>" class="btn btn-success"><i class="fa fa-info-circle"></i> Upload Documents</a>
                              <br><br>
                              <?php if($row->invoice_from_seller != '') {?>
                                <a href="<?=base_url('/writable/uploads/'.$row->invoice_from_seller)?>?>" target="_blank" class="label label-warning">View Seller Invoice</a>
                              <?php }?>
                              <br><br>
                              <?php if($row->seller_invoice_from_admin == '' && $row->buyer_invoice_from_admin == '') {?>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal<?=$row->id?>">
                                <i class="fa fa-upload"></i> Upload Invoice
                                </button>
                              <?php } else {?>
                                <a href="<?=base_url('/writable/uploads/'.$row->invoice_from_seller)?>?>" target="_blank" class="label label-success">View Seller Invoice From Admin</a>
                                <a href="<?=base_url('/writable/uploads/'.$row->invoice_from_seller)?>?>" target="_blank" class="label label-success">View Buyer Invoice From Admin</a>
                              <?php }?>
                            </td>
                          </tr>
                          <?php } } else {?>
                            <tr>
                              <td colspan="7" style="text-align: center;">No Records Found !!!</td>
                            </tr>
                          <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <div id="menu7" class="tab-pane fade">
                      <h3>Invoice From Admin</h3>
                      <table class="table table-bordered table-stripped">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Inquiry Type/<br>Inquiry Number</th>
                            <th>Category/<br>Sub Category/<br>Product/<br>Item</th>
                            <th>State</th>
                            <th>Required Qty</th>
                            <th>Document Needs To Upload</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if($adminInvoicesInquiries) { $sl=1; foreach($adminInvoicesInquiries as $row){
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
                            // echo $parentTable.'<br>';
                            // echo $parentField.'<br>';
                            // echo $childTable.'<br>';
                            // echo $childField;
                            // die;
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
                          ?>
                          <tr>
                            <td><?=$sl++?></td>
                            <td>
                              <span class="targe_table_pname text-success" <?=(($itemDetails->inventory_type == 'BUY')?'':'style="color:red;"')?>><?=$itemDetails->inventory_type?></span>
                              <br>
                              <?=$row->inquiry_no?>
                            </td>
                            <td>
                              <?=(($category)?$category->name:'')?><br>
                              <?=(($subcategory)?$subcategory->name:'')?><br>
                              <?=(($product)?$product->name:'')?><br>
                              <?=(($item)?$item->name:'')?>
                            </td>
                            <td><?=(($state)?$state->state_title:'')?></td>
                            <td><?=$row->require_qty?></td>
                            <td>
                              <?php
                              $require_documents = json_decode($row->require_documents);
                              ?>
                              <ul class="list-group">
                                <?php
                                if(count($require_documents)){ for($i=0;$i<count($require_documents);$i++){
                                  $document           = $common_model->find_data('ecoex_document_list', 'row', ['id' => $require_documents[$i]], 'documentName');
                                ?>
                                <li class="list-group-item"><?=(($document)?$document->documentName:'')?></li>
                                <?php } }?>
                              </ul>
                            </td>
                            <td>
                              <div class="taget_table_button">
                                <a href="<?=base_url('admin/inquiryDetails/'.encoded($row->id))?>" class="btn btn-success"><i class="fa fa-info-circle"></i> View Details</a>
                                <br><br>
                                <?php if($row->seller_invoice_from_admin == '' && $row->buyer_invoice_from_admin == '') {?>
                                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal<?=$row->id?>">
                                  <i class="fa fa-upload"></i> Upload Invoice
                                  </button>
                                <?php } else {?>
                                  <a href="<?=base_url('/writable/uploads/'.$row->invoice_from_seller)?>?>" target="_blank" class="label label-success">View Seller Invoice From Admin</a>
                                  <a href="<?=base_url('/writable/uploads/'.$row->invoice_from_seller)?>?>" target="_blank" class="label label-success">View Buyer Invoice From Admin</a>
                                <?php }?>
                              </div>
                            </td>
                          </tr>
                          <?php } }?>
                        </tbody>
                      </table>
                    </div>
                    <div id="menu8" class="tab-pane fade">
                      <h3>Buyer Payment Upload</h3>
                      <table class="table table-bordered table-stripped">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Inquiry Type/<br>Inquiry Number</th>
                            <th>Category/<br>Sub Category/<br>Product/<br>Item</th>
                            <th>State</th>
                            <th>Required Qty</th>
                            <th>Document Needs To Upload</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if($paymentUploadsInquiries) { $sl=1; foreach($paymentUploadsInquiries as $row){
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
                          ?>
                          <tr>
                            <td><?=$sl++?></td>
                            <td>
                              <span class="targe_table_pname text-success" <?=(($itemDetails->inventory_type == 'BUY')?'':'style="color:red;"')?>><?=$itemDetails->inventory_type?></span>
                              <br>
                              <?=$row->inquiry_no?>
                            </td>
                            <td>
                              <?=(($category)?$category->name:'')?><br>
                              <?=(($subcategory)?$subcategory->name:'')?><br>
                              <?=(($product)?$product->name:'')?><br>
                              <?=(($item)?$item->name:'')?>
                            </td>
                            <td><?=(($state)?$state->state_title:'')?></td>
                            <td><?=$row->require_qty?></td>
                            <td>
                              <?php
                              $require_documents = json_decode($row->require_documents);
                              ?>
                              <ul class="list-group">
                                <?php
                                if(count($require_documents)){ for($i=0;$i<count($require_documents);$i++){
                                  $document           = $common_model->find_data('ecoex_document_list', 'row', ['id' => $require_documents[$i]], 'documentName');
                                ?>
                                <li class="list-group-item"><?=(($document)?$document->documentName:'')?></li>
                                <?php } }?>
                              </ul>
                            </td>
                            <td>
                              <div class="taget_table_button">
                                <a href="<?=base_url('admin/inquiryDetails/'.encoded($row->id))?>" class="btn btn-success"><i class="fa fa-info-circle"></i> View Details</a>
                              </div>
                            </td>
                          </tr>
                          <?php } }?>
                        </tbody>
                      </table>
                    </div>
                    <div id="menu9" class="tab-pane fade">
                      <h3>Admin Payment Accept</h3>
                      <table class="table table-bordered table-stripped">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Inquiry Type/<br>Inquiry Number</th>
                            <th>Category/<br>Sub Category/<br>Product/<br>Item</th>
                            <th>State</th>
                            <th>Required Qty</th>
                            <th>Document Needs To Upload</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if($paymentAcceptInquiries) { $sl=1; foreach($paymentAcceptInquiries as $row){
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
                          ?>
                          <tr>
                            <td><?=$sl++?></td>
                            <td>
                              <span class="targe_table_pname text-success" <?=(($itemDetails->inventory_type == 'BUY')?'':'style="color:red;"')?>><?=$itemDetails->inventory_type?></span>
                              <br>
                              <?=$row->inquiry_no?>
                            </td>
                            <td>
                              <?=(($category)?$category->name:'')?><br>
                              <?=(($subcategory)?$subcategory->name:'')?><br>
                              <?=(($product)?$product->name:'')?><br>
                              <?=(($item)?$item->name:'')?>
                            </td>
                            <td><?=(($state)?$state->state_title:'')?></td>
                            <td><?=$row->require_qty?></td>
                            <td>
                              <?php
                              $require_documents = json_decode($row->require_documents);
                              ?>
                              <ul class="list-group">
                                <?php
                                if(count($require_documents)){ for($i=0;$i<count($require_documents);$i++){
                                  $document           = $common_model->find_data('ecoex_document_list', 'row', ['id' => $require_documents[$i]], 'documentName');
                                ?>
                                <li class="list-group-item"><?=(($document)?$document->documentName:'')?></li>
                                <?php } }?>
                              </ul>
                            </td>
                            <td>
                              <div class="taget_table_button">
                                <a href="<?=base_url('admin/inquiryDetails/'.encoded($row->id))?>" class="btn btn-success"><i class="fa fa-info-circle"></i> View Details</a>
                              </div>
                            </td>
                          </tr>
                          <?php } }?>
                        </tbody>
                      </table>
                    </div>

                  </div>
                </div>
              </div>
            </div>
        </div>   
      </div>

      <?php if($poSharedInquiries) { $sl=1; foreach($poSharedInquiries as $row){?>
      <div class="modal fade" id="exampleModal<?=$row->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <form method="post" action="<?=base_url('/admin/uploadInvoices/'.encoded($row->id))?>" enctype="multipart/form-data">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Invoice For <?=$row->inquiry_no?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label>Invoice For Seller</label>
                  <input type="file" class="form-control" name="seller_invoice_from_admin" accept="application/pdf" required>
                </div>
                <div class="form-group">
                  <label>Invoice For Seller</label>
                  <input type="file" class="form-control" name="buyer_invoice_from_admin" accept="application/pdf" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Upload Invoice</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <?php } }?>

    </section>
  </div>
      <!-- Main Content -->
    </div>
</div>

<?php echo view('admin/layout/footer'); ?>