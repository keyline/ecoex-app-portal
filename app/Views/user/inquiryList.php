<?php echo view('user/inc/header'); ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<style type="text/css">
    .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
        color: #fff;
        background-color: #48974e;
    }
</style>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="row">
            <div class="col-lg-12">
              <div class="toptile_search">
                <div class="page-title">
                  <h2>Inquiry</h2>
                </div>
                <!-- <div class="search-container">
                    <div class="form-group has-search">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input type="text" class="form-control" placeholder="Search">
                  </div>
                </div> -->
              </div>
            </div>
          </div>
          <div class="row align-items-center mt-3">
            <div class="col-md-6">
              <div class="market-traget_topleft">                
              </div>
            </div>
            <div class="col-md-6">
              <div class="market_tagettop_btn">
                <!-- <a href="/user/inventory/" class="nav-link greenbtn"> Add New</a> -->
                <!-- <a href="javascript:void(0)" onclick="openNavTablefilter()" class="nav-link filter_btn"><i class="fa fa-bell"></i> Filter</a> -->
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="dashboard_white_panel mt-3">
                <div class="target_dashland_details">
                  <?php if($session->getFlashdata('success_message')) { ?>
                    <p class="alert alert-success statusMessage"><?php echo $session->getFlashdata('success_message');?></p>
                  <?php } ?>                  
                  <ul class="nav nav-pills">
                    <!-- <li class="active"><a data-toggle="pill" href="#menu0" style="font-size: 13px;">All (<?=count($allInquiries)?>)</a></li> -->
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
                    <!-- <div id="menu0" class="tab-pane fade in active">
                      <h3>Inquiry Submit</h3>                      
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
                          if($allInquiries) { $sl=1; foreach($allInquiries as $row){
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
                                $documentName = [];
                                if(count($require_documents)){ for($i=0;$i<count($require_documents);$i++){
                                  $document           = $common_model->find_data('ecoex_document_list', 'row', ['id' => $require_documents[$i]], 'documentName');
                                  $documentName[] = (($document)?$document->documentName:'');
                                ?>
                                <li class="list-group-item"><?=(($document)?$document->documentName:'')?></li>
                                <?php } }?>
                              </ul>
                            </td>
                            <td>
                              <div class="taget_table_button">
                                <a href="<?=base_url('user/uploadInquiryDocument/'.encoded($row->id))?>" class="filter_btn btn-sm">Upload Document</a>
                              </div>
                            </td>
                          </tr>
                          <?php } }?>
                        </tbody>
                      </table>
                    </div> -->
                    <div id="menu1" class="tab-pane fade in active">
                      <h3>Inquiry Submit</h3>                      
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
                                $documentName = [];
                                if(count($require_documents)){ for($i=0;$i<count($require_documents);$i++){
                                  $document           = $common_model->find_data('ecoex_document_list', 'row', ['id' => $require_documents[$i]], 'documentName');
                                  $documentName[] = (($document)?$document->documentName:'');
                                ?>
                                <li class="list-group-item"><?=(($document)?$document->documentName:'')?></li>
                                <?php } }?>
                              </ul>
                            </td>
                            <td>
                              <div class="taget_table_button">
                                <a href="<?=base_url('user/uploadInquiryDocument/'.encoded($row->id))?>" class="filter_btn btn-sm">Upload Document</a>
                              </div>
                            </td>
                          </tr>
                          <?php } }?>
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
                                <a href="<?=base_url('user/uploadInquiryDocument/'.encoded($row->id))?>" class="filter_btn">View Details</a>
                              </div>                              
                            </td>
                          </tr>
                          <?php } }?>
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
                                <a href="<?=base_url('user/uploadInquiryDocument/'.encoded($row->id))?>" class="filter_btn">View Details</a>
                              </div>
                            </td>
                          </tr>
                          <?php } }?>
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
                                <a href="<?=base_url('user/uploadInquiryDocument/'.encoded($row->id))?>" class="filter_btn">View Details</a>
                              </div>
                            </td>
                          </tr>
                          <?php } }?>
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
                                <a href="<?=base_url('user/uploadInquiryDocument/'.encoded($row->id))?>" class="filter_btn">View Details</a>
                              </div>
                            </td>
                          </tr>
                          <?php } }?>
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
                                <a href="<?=base_url('user/uploadInquiryDocument/'.encoded($row->id))?>" class="filter_btn">View Details</a>
                                <?php 
                                $userId                 = $session->get('recycleUserId');
                                if($userId == $row->seller_id){?>
                                  <br><br>
                                    <?php if($row->invoice_from_seller == '') {?>
                                      <button type="button" class="filter_btn" data-toggle="modal" data-target="#exampleModal<?=$row->id?>">
                                      Upload Invoice
                                      </button>
                                    <?php } else {?>
                                      <a href="<?=base_url('/writable/uploads/'.$row->invoice_from_seller)?>?>" target="_blank" class="label label-success">View Invoice</a>
                                    <?php }?>
                                <?php }?>
                              </div>
                            </td>
                          </tr>
                          <?php } }?>
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
                                <a href="<?=base_url('user/uploadInquiryDocument/'.encoded($row->id))?>" class="filter_btn">View Details</a>                               
                                  <?php 
                                  $userId                 = $session->get('recycleUserId');
                                  if($userId == $row->seller_id){?>
                                    <a href="<?=base_url('/writable/uploads/'.$row->seller_invoice_from_admin)?>?>" target="_blank" class="label label-success">View Invoice</a>
                                        </button>
                                  <?php } else {?>
                                    <a href="<?=base_url('/writable/uploads/'.$row->buyer_invoice_from_admin)?>?>" target="_blank" class="label label-success">View Invoice</a>
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
                                <a href="<?=base_url('user/uploadInquiryDocument/'.encoded($row->id))?>" class="filter_btn">View Details</a>
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
                                <a href="<?=base_url('user/uploadInquiryDocument/'.encoded($row->id))?>" class="filter_btn">View Details</a>
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
        </section>
      </div>
    </div>
  </div>
</div>
<?php if($poSharedInquiries) { $sl=1; foreach($poSharedInquiries as $row){?>
<div class="modal fade" id="exampleModal<?=$row->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" action="<?=base_url('/user/uploadInvoice/'.encoded($row->id))?>" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Invoice For <?=$row->inquiry_no?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="file" class="form-control" name="invoice_from_seller" id="invoice_from_seller" accept="application/pdf" required>
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

<script>
function opennotifilterNav() {
  document.getElementById("notifilter").style.width = "300px";
}

function closenotifilterNav() {
  document.getElementById("notifilter").style.width = "0";
}

function openNavTablefilter() {
  document.getElementById("tablefilter").style.width = "250px";
}

function closeNavTablefilter() {
  document.getElementById("tablefilter").style.width = "0";
}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>    
    $(document).ready(function(){
        $('.statusMessage').delay(5000).fadeOut('slow');
    });
</script>
<?php echo view('user/inc/footer'); ?>