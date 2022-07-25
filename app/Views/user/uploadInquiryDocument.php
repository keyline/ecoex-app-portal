<?php echo view('user/inc/header'); ?>
    <style type="text/css">
        th:first-child, td:first-child
        {
          position:sticky;
          left:0px;
          background-color:grey;
          color: #FFF;
        }
    </style>
    <!-- for inquiry tracking -->
        <style type="text/css">
            .progress-bar-wrapper ul.progress-bar {
                width: 100%;
                margin: 0;
                padding: 0;
                font-size: 0;
                list-style: none;
                background-color: #FFF;
                display: inline-block !important;
            }

            .progress-bar-wrapper li.section {
                display: inline-block !important;
                padding-top: 45px;
                font-size: 9px;
                font-weight: bold;
                line-height: 16px;
                color: gray;
                vertical-align: top;
                position: relative;
                text-align: center;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .progress-bar-wrapper li.section:before {
                content: 'x';
                position: absolute;
                top: 3px;
                left: calc(50% - 15px);
                z-index: 1;
                width: 30px;
                height: 30px;
                color: white;
                border: 2px solid white;
                border-radius: 17px;
                line-height: 26px;
                background: gray;
            }
            .progress-bar-wrapper .status-bar {
                height: 2px;
                background: gray;
                position: relative;
                top: 20px;
                margin: 0 auto;
            }
            .progress-bar-wrapper .current-status {
                height: 3px;
                width: 0;
                border-radius: 1px;
                background: #26a541;
            }

            @keyframes changeBackground {
                from {background: gray}
                to {background: #26a541}
            }

            .progress-bar-wrapper li.section.visited:before {
                content: '\2714';
                animation: changeBackground .5s linear;
                animation-fill-mode: forwards;
            }

            .progress-bar-wrapper li.section.visited.current:before {
                box-shadow: 0 0 0 2px #26a541;
            }
        </style>
    <!-- for inquiry tracking -->
    <!-- Main Content -->
    <div class="main-content">        
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="toptile_search">
                        <div class="page-title">
                          <h2>Inquiry Details For <?=$row->inquiry_no?></h2>                          
                        </div>
                        &nbsp;&nbsp;&nbsp; 
                        <?php if($row->published == 2){?>
                            <?php if($row->po_documents == '' && $userId == $row->buyer_id){?>
                                <a href="<?=base_url('user/inquiryAcceptDocument/'.encoded($row->id))?>" class="btn btn-success" onclick="return confirm('Are You Sure ?');"><i class="fa fa-check"></i> Accept Inquiry Documents & Data</a>
                            <?php }?>
                        <?php }?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?php if($session->getFlashdata('success_message')) { ?>
                        <p class="alert alert-success mt-3 statusMessage"><?php echo $session->getFlashdata('success_message');?></p>
                    <?php } ?>
                    <?php if($session->getFlashdata('error_message')) { ?>
                        <p class="alert alert-danger mt-3 statusMessage"><?php echo $session->getFlashdata('error_message');?></p>
                    <?php } ?>

                    <!-- inquiry flow tracking -->
                        <?php
                        if($row->published == 0){
                            $inquiryStatus = 'Submit Inquiry';
                        } elseif($row->published == 1){
                            $inquiryStatus = 'Documents Uploaded';
                        } elseif($row->published == 2){
                            $inquiryStatus = 'Admin Approved';
                        } elseif($row->published == 3){
                            $inquiryStatus = 'Buyer Accept';
                        } elseif($row->published == 4){
                            $inquiryStatus = 'PO Uploaded';
                        } elseif($row->published == 5){
                            $inquiryStatus = 'Shared PO';
                        } elseif($row->published == 6){
                            $inquiryStatus = 'Admin Upload Invoices';
                        } elseif($row->published == 7){
                            $inquiryStatus = 'Buyer Payment Upload';
                        } elseif($row->published == 8){
                            $inquiryStatus = 'Admin Accept Payment';
                        }
                        ?>    
                        <div class="progress-bar-wrapper"></div>
                    <!-- inquiry flow tracking -->

                    <div class="dashboard_white_panel mt-3">
                        <div class=" justify-content-between pt-3 pb-3 pl-3 pr-3 align-items-center">                      
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
                                    <?php if($userId == $row->buyer_id) {?>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="card">
                                                <div class="card-header bg-success text-light">
                                                    Upload Purchase Order
                                                </div>
                                                <div class="card-body">
                                                    <?php if($row->po_documents == ''){?>              
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
                                                    <?php } else {?>
                                                        <?php if($userId == $row->buyer_id) {?>
                                                            <h3><a href="<?=base_url('/writable/uploads/'.$row->po_documents)?>" target="_blank" class="badge badge-primary">View Purchase Order</a></h3>
                                                        <?php } ?>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }?>
                                <?php } ?>
                                <?php if(($common_model->checkSellerBuyer($row->seller_id))  && ($row->published == 5)) {?>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="card">
                                                <div class="card-header bg-success text-light">
                                                    Purchase Order
                                                </div>
                                                <div class="card-body">
                                                    <h3><a href="<?=base_url('/writable/uploads/'.$row->po_documents)?>" target="_blank" class="badge badge-primary">View Purchase Order</a></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                <?php }?>
                                <?php if(($common_model->checkSellerBuyer($row->seller_id))  && ($row->published >= 5)) {?>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="card">
                                                <div class="card-header bg-success text-light">
                                                    Upload Sale Invoice
                                                </div>
                                                <div class="card-body">
                                                    <?php if($row->invoice_from_seller == ''){?>              
                                                        <form method="post" action="<?=base_url('/user/uploadInvoice/'.encoded($row->id))?>" enctype="multipart/form-data">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <input type="file" class="form-control" name="invoice_from_seller" id="invoice_from_seller" accept="application/pdf" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="submit" class="btn btn-success" value="Submit">
                                                                </div>
                                                            </div>
                                                        </form>                                                    
                                                    <?php } else {?>
                                                        <h3><a href="<?=base_url('/writable/uploads/'.$row->invoice_from_seller)?>" target="_blank" class="badge badge-primary">View Sale Invoice</a></h3>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                <?php }?>

                                <?php if($row->published >= 6) {?>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="card">
                                                <div class="card-header bg-success text-light">
                                                    Invoice From EcoEx
                                                </div>
                                                <div class="card-body">
                                                    <?php if($common_model->checkSellerBuyer($row->seller_id)){?>
                                                        <h3><a href="<?=base_url('/writable/uploads/'.$row->seller_invoice_from_admin)?>" target="_blank" class="badge badge-primary">View Seller Invoice From EcoEx</a></h3>
                                                    <?php }?>
                                                    <?php if($common_model->checkSellerBuyer($row->buyer_id)){?>
                                                        <h3><a href="<?=base_url('/writable/uploads/'.$row->buyer_invoice_from_admin)?>" target="_blank" class="badge badge-primary">View Buyer Invoice From EcoEx</a></h3>
                                                        <?php if($row->transaction_no == ''){?>
                                                        <form method="post" action="<?=base_url('/user/uploadPayment/'.encoded($row->id))?>" enctype="multipart/form-data" style="border: 1px solid #a2d63e; margin-top: 20px; padding: 20px;">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="transaction_no">Transaction Number</label>
                                                                    <input type="text" class="form-control" name="transaction_no" id="transaction_no" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="transaction_amount">Transaction Amount</label>
                                                                    <input type="text" class="form-control" name="transaction_amount" id="transaction_amount" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="transaction_date">Transaction Date</label>
                                                                    <input type="date" class="form-control" name="transaction_date" id="transaction_date" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="transaction_time">Transaction Time</label>
                                                                    <input type="time" class="form-control" name="transaction_time" id="transaction_time" required>
                                                                </div>
                                                                <div class="col-md-6 mt-3">
                                                                    <input type="submit" class="btn btn-success" value="Submit">
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <?php } else {?>
                                                            <ul class="list-group mt-3">
                                                                <li class="list-group-item">Transaction Number : <?=$row->transaction_no?></li>
                                                                <li class="list-group-item">Transaction Date : <?=date_format(date_create($row->transaction_date), "M d, Y")?></li>
                                                                <li class="list-group-item">Transaction Time : <?=date_format(date_create($row->transaction_time), "h:i A")?></li>
                                                                <li class="list-group-item">Transaction Amount : <?=$row->transaction_amount?></li>
                                                            </ul>
                                                        <?php }?>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                <?php }?>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <h4 style="font-weight:bold;">Buyer</h4>
                                        <span><?=$row->buyer_type?></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h4 style="font-weight:bold;">Seller</h4>
                                        <span><?=$row->seller_type?></span>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <h4 style="font-weight:bold;">Category</h4>
                                        <span><?=(($category)?$category->name:'')?></span>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <h4 style="font-weight:bold;">Sub-Category</h4>
                                        <span><?=(($subcategory)?$subcategory->name:'')?></span>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <h4 style="font-weight:bold;">Product</h4>
                                        <span><?=(($product)?$product->name:'')?></span>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <h4 style="font-weight:bold;">Item</h4>
                                        <span><?=(($item)?$item->name:'')?></span>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <h4 style="font-weight:bold;">State</h4>
                                        <span><?=(($state)?$state->state_title:'')?></span>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <h4 style="font-weight:bold;">Month/year</h4>
                                        <span>
                                            <?=$common_model->monthName($itemDetails->month)?> / <?=$common_model->financialyear($itemDetails->year)?>
                                        </span>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <h4 style="font-weight:bold;">Rate</h4>
                                        <span><?=(($itemDetails)?$itemDetails->rate:'')?></span>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <h4 style="font-weight:bold;">Required Qty</h4>
                                        <span><?=(($row)?$row->require_qty:'')?></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <h4 style="font-weight:bold;">Required Documents</h4>
                                        <ul class="list-group">
                                            <?php
                                            $require_documents = json_decode($row->require_documents);
                                            if(count($require_documents)){ for($i=0;$i<count($require_documents);$i++){
                                            $document           = $common_model->find_data('ecoex_document_list', 'row', ['id' => $require_documents[$i]], 'documentName');
                                            ?>
                                                <li class="list-group-item"><i class="fa fa-check-circle text-success"></i> <?=(($document)?$document->documentName:'')?></li>
                                            <?php } }?>
                                        </ul>
                                    </div>
                                    <?php if($common_model->checkSellerBuyer($row->seller_id)){?>
                                        <div class="col-md-6">
                                            <?php if($row->excel_data == ''){?>
                                                <h4 style="font-weight:bold;">Upload CSV File</h4>
                                                <h6 class="text-info">(Only csv files are allowed to upload)</h6>
                                                <h6 class="text-primary mb-3">Please download <a href="<?=base_url('public/assets/DEMO_SHEET.csv')?>" target="_blank">Sample File</a></h6>
                                                <form method="post" enctype="multipart/form-data" class="form-inline">
                                                    <input type="hidden" name="mode" value="csv_document">
                                                    <input type="hidden" name="inquiry_id" value="<?=$row->id?>">
                                                    <input type="hidden" name="inventory_id" value="<?=$row->inventory_id?>">
                                                    <input type="hidden" name="inventory_details_id" value="<?=$row->inventory_details_id?>">
                                                    <input type="file" class="form-control" name="excel_data" accept="text/csv" required>
                                                    <button type="submit" class="btn btn-outline-success"><i class="fa fa-upload"></i> Upload CSV</button>
                                                </form>
                                            <?php } else {?>
                                                <div class="after-csv-upload-action-section mt-3">
                                                    
                                                    <?php if($row->published <= 0){?>
                                                        <a href="<?=base_url('user/delete-uploaded-data/'.encoded($row->id))?>" class="btn btn-outline-danger" onclick="return confirm('Do You Want To Delete All Uploaded Data In This Inquiry ?');"><i class="fa fa-times-circle text-danger"></i> Delete CSV Uploaded Data</a>
                                                    <?php }?>
                                                </div>
                                            <?php }?>
                                        </div>
                                    <?php }?>
                                </div>
                                <?php if($row->excel_data != ''){?>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h4 style="font-weight:bold;">Uploaded Excel Data</h4> 
                                        <div class="table-responsive">                                       
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>COLUMN NAME</th>                                                
                                                    <?php
                                                    $condition = [
                                                        'inquiry_id'            => $row->id,
                                                        'inventory_id'          => $row->inventory_id,
                                                        'inventory_details_id'  => $row->inventory_details_id,
                                                        'attr_id'               => 1
                                                    ];
                                                    $attrDatas = $common_model->find_data('ecoex_business_inquiry_excel_data', 'array', $condition);
                                                    if($attrDatas){ $k=1;foreach($attrDatas as $attrData){
                                                    ?>
                                                        <th>TRUCK <?=$k++?></th>
                                                    <?php } }?>                                                
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php if($attributes){ foreach($attributes as $attribute){?>
                                            <tr>                                                
                                                <td style="font-weight: bold;"><?=$attribute->attr_name?></td>
                                                <?php
                                                if($common_model->checkSellerBuyer($row->seller_id)){
                                                    $condition = [
                                                        'inquiry_id'            => $row->id,
                                                        'inventory_id'          => $row->inventory_id,
                                                        'inventory_details_id'  => $row->inventory_details_id,
                                                        'attr_id'               => $attribute->attr_id
                                                    ];
                                                } else {
                                                    $condition = [
                                                        'inquiry_id'            => $row->id,
                                                        'inventory_id'          => $row->inventory_id,
                                                        'inventory_details_id'  => $row->inventory_details_id,
                                                        'attr_id'               => $attribute->attr_id,
                                                        'published'             => 1
                                                    ];
                                                }
                                                
                                                $attrDatas = $common_model->find_data('ecoex_business_inquiry_excel_data', 'array', $condition);
                                                //pr($attrDatas,false);
                                                if($attrDatas){ foreach($attrDatas as $attrData){
                                                ?>

                                                    <?php if($attribute->attr_id == 15){?>
                                                        <td>
                                                            <?php if($attrData->attr_value != ''){?>
                                                                <a href="<?=base_url('writable/uploads/'.$attrData->attr_value)?>" target="_blank" class="badge badge-info mb-3">Pdf Uploaded - Click to view</a>
                                                            <?php }?>
                                                            <?php if($common_model->checkSellerBuyer($row->seller_id)){?>
                                                                <?php if($row->published <= 1){?>
                                                                    <form method="post" enctype="multipart/form-data">
                                                                        <input type="hidden" name="mode" value="pdf_document">
                                                                        <input type="hidden" name="inquiry_id" value="<?=$row->id?>">
                                                                        <input type="hidden" name="inventory_id" value="<?=$row->inventory_id?>">
                                                                        <input type="hidden" name="inventory_details_id" value="<?=$row->inventory_details_id?>">
                                                                        <input type="hidden" name="attr_id" value="15">
                                                                        <input type="hidden" name="sl_no" value="<?=$attrData->sl_no?>">
                                                                        <input type="file" class="form-control" name="pdf_data" accept="application/pdf" required>
                                                                        <button type="submit" class="btn btn-outline-success btn-block mt-3"><i class="fa fa-upload"></i> Upload</button>
                                                                    </form>
                                                                <?php }?>
                                                            <?php }?>
                                                        </td>
                                                    <?php } else {?>
                                                        <td><?=$attrData->attr_value?></td>
                                                    <?php }?>
                                                <?php } }?>
                                            </tr>
                                            <?php } }?>
                                            </tbody>
                                        </table> 
                                        </div>
                                    </div>
                                </div>
                                <?php }?>

                                <?php //if($row->published <= 1){?>
                                    <a href="<?=base_url('user/notify-admin-approval/'.encoded($row->id))?>" class="btn btn-outline-success" onclick="return confirm('Do You Want To Notify Admin For Approval ?');"><i class="fa fa-check-circle text-success"></i> Notify Admin For Approval</a>
                                <?php //}?>
                                
                            </div>
                            <div class="box-footer"></div>                        
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
        $('.statusMessage').delay(5000).fadeOut('slow');
    });
</script>
<script type="text/javascript">
  //we can set animation delay as following in ms (default 1000)
  ProgressBar.singleStepAnimation = 1500;
  ProgressBar.init(
    [ 'Submit Inquiry',
      'Documents Uploaded',
      'Admin Approved',
      'Buyer Accept',
      'PO Uploaded',
      'Shared PO',
      'Admin Upload Invoices',
      'Buyer Payment Upload',
      'Admin Accept Payment',
    ],
    '<?=$inquiryStatus?>',
    'progress-bar-wrapper' // created this optional parameter for container name (otherwise default container created)
  );
</script>