<?php echo view('admin/layout/header'); ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<!-- for toggle switching -->
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
<!-- for toggle switching -->
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
<style type="text/css">
  th:first-child, td:first-child
  {
    position:sticky;
    left:0px;
    background-color:grey;
    color: #FFF;
  }
</style>
<div class="wrapper-page">
  <div class="main-wrapper">
    <div class="navbar-bg"></div>
    <?php echo view('admin/layout/navbar'); ?>
    <?php echo view('admin/layout/sidebar'); ?>
    <div class="main-content">    
    <!-- Main content -->
      <section class="section">
        <div class="container-fluid">
          <div class="row">
              <div class="col-md-12">
                <div class="box">
                  <div class="box-header">
                      <h3 class="box-title" style="float:left">Inquiry Details For <?=$row->inquiry_no?></h3>
                  </div>
                  <div class="col-md-12">
                    <?php if($session->getFlashdata('success_message')) { ?>
                      <p class="alert alert-success statusMessage"><?php echo $session->getFlashdata('success_message');?></p>
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
                          $inquiryStatus = 'Admin Uploaded Invoices';
                      } elseif($row->published == 7){
                          $inquiryStatus = 'Buyer Payment Upload';
                      } elseif($row->published == 8){
                          $inquiryStatus = 'Admin Accept Payment';
                      }
                      ?>    
                      <div class="progress-bar-wrapper" style="margin-bottom: 10px;"></div>
                    <!-- inquiry flow tracking -->

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
                    $buyer = $common_model->getUserByUserId($row->buyer_id);
                    $seller = $common_model->getUserByUserId($row->seller_id);
                    ?>

                    <?php if($row->published >= 4){?>
                      <div class="row">
                          <div class="col-md-12 mb-3">
                              <div class="card">
                                  <div class="card-header bg-success text-light">
                                      Purchase Order
                                  </div>
                                  <div class="card-body">                                    
                                      <h3><a href="<?=base_url('/writable/uploads/'.$row->po_documents)?>" target="_blank" class="label label-primary">View Purchase Order</a></h3>
                                      <?php if($row->published == 4){?>
                                      <br><br>
                                      <a href="<?=base_url('admin/sharePO/'.encoded($row->id))?>" class="btn btn-success" onclick="return confirm('Are You Sure ?');"><i class="fa fa-check"></i> Share Purchase Order To Seller</a>
                                      <?php } ?>
                                  </div>
                              </div>
                          </div>
                      </div>
                    <?php } ?>
                    <?php if($row->published >= 5 && $row->invoice_from_seller != ''){?>
                      <div class="row">
                          <div class="col-md-12 mb-3">
                              <div class="card">
                                  <div class="card-header bg-success text-light">
                                      Sale Invoice From Seller
                                  </div>
                                  <div class="card-body">                                    
                                      <h3><a href="<?=base_url('/writable/uploads/'.$row->invoice_from_seller)?>" target="_blank" class="label label-primary">View Sale Invoice</a></h3>
                                  </div>
                              </div>
                          </div>
                      </div>
                    <?php } ?>

                    <?php if($row->published >= 5 && $row->invoice_from_seller != ''){?>
                      <div class="row">
                          <div class="col-md-12 mb-3">
                              <div class="card">
                                  <div class="card-header bg-success text-light">
                                      Invoice For Seller & Buyer From EcoEx
                                  </div>
                                  <div class="card-body">
                                    <?php if($row->seller_invoice_from_admin == '' && $row->buyer_invoice_from_admin == ''){?>
                                      <form method="post" action="<?=base_url('/admin/uploadInvoices/'.encoded($row->id))?>" enctype="multipart/form-data">                                        
                                        <div class="form-group">
                                          <label>Invoice For Seller From EcoEx</label>
                                          <input type="file" class="form-control" name="seller_invoice_from_admin" accept="application/pdf" required>
                                        </div>
                                        <div class="form-group">
                                          <label>Invoice For Buyer From EcoEx</label>
                                          <input type="file" class="form-control" name="buyer_invoice_from_admin" accept="application/pdf" required>
                                        </div>                                        
                                        <button type="submit" class="btn btn-success">Upload Invoice</button>
                                      </form>
                                    <?php } else {?>
                                      <h3><a href="<?=base_url('/writable/uploads/'.$row->seller_invoice_from_admin)?>" target="_blank" class="label label-primary">View Invoice For Seller From EcoEx</a></h3>
                                      <h3><a href="<?=base_url('/writable/uploads/'.$row->buyer_invoice_from_admin)?>" target="_blank" class="label label-primary">View Invoice For Buyer From EcoEx</a></h3>

                                      <?php if($row->transaction_no != ''){?>
                                        <ul class="list-group mt-3">
                                          <li class="list-group-item">Transaction Number : <?=$row->transaction_no?></li>
                                          <li class="list-group-item">Transaction Date : <?=date_format(date_create($row->transaction_date), "M d, Y")?></li>
                                          <li class="list-group-item">Transaction Time : <?=date_format(date_create($row->transaction_time), "h:i A")?></li>
                                          <li class="list-group-item">Transaction Amount : <?=$row->transaction_amount?></li>
                                        </ul>
                                        <a class="btn btn-success" href="<?=base_url('/admin/acceptPayment/'.encoded($row->id))?>" onclick="return confirm('Do You Want To Accept Buyer Payment ?');">Accept Payment</a>
                                      <?php }?>  
                                    <?php }?>
                                  </div>
                              </div>
                          </div>
                      </div>
                    <?php } ?>

                    <div class="row">                      
                      <div class="col-md-6 mb-3">
                          <h4 style="font-weight:bold;">Buyer</h4>
                          <h5><i class="fa fa-list-alt text-success"></i> <?=$row->buyer_type?></h5>
                          <h5><i class="fa fa-home text-success"></i> <?=(($buyer)?$buyer->c_name:'')?></h5>
                          <h5><i class="fa fa-user text-success"></i> <?=(($buyer)?$buyer->user_name:'')?></h5>
                          <h5><i class="fa fa-envelope text-success"></i> <?=(($buyer)?$buyer->user_email:'')?></h5>
                          <h5><i class="fa fa-mobile text-success"></i> <?=(($buyer)?$buyer->user_mobile:'')?></h5>
                      </div>
                      <div class="col-md-6 mb-3">
                          <h4 style="font-weight:bold;">Seller</h4>
                          <h5><i class="fa fa-list-alt text-success"></i> <?=$row->seller_type?></h5>
                          <h5><i class="fa fa-home text-success"></i> <?=(($seller)?$seller->c_name:'')?></h5>
                          <h5><i class="fa fa-user text-success"></i> <?=(($seller)?$seller->user_name:'')?></h5>
                          <h5><i class="fa fa-envelope text-success"></i> <?=(($seller)?$seller->user_email:'')?></h5>
                          <h5><i class="fa fa-mobile text-success"></i> <?=(($seller)?$seller->user_mobile:'')?></h5>
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
                      <div class="col-md-12 mb-3">
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
                    </div>
                    
                    <?php if($row->excel_data != ''){?>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h4 style="font-weight:bold;">Uploaded Excel Data</h4> 
                            <div class="table-responsive">
                              <form method="post" enctype="multipart/form-data">                              
                                <input type="hidden" name="inquiry_id" value="<?=$row->id?>">
                                <input type="hidden" name="inventory_id" value="<?=$row->inventory_id?>">
                                <input type="hidden" name="inventory_details_id" value="<?=$row->inventory_details_id?>">
                                <!-- <input type="hidden" name="attr_id" value="15">
                                <input type="hidden" name="sl_no" value="<?=$attrData->sl_no?>"> -->
                                
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
                                        <td style="font-weight: bold;">
                                          <input type="checkbox" name="is_share[]" <?=(($attribute->share_nature == 'AUTOMATIC')?'checked':'')?> value="<?=$attribute->attr_id?>">
                                          <?=$attribute->attr_name?>                                      
                                        </td>
                                        <?php
                                        $condition = [
                                            'inquiry_id'            => $row->id,
                                            'inventory_id'          => $row->inventory_id,
                                            'inventory_details_id'  => $row->inventory_details_id,
                                            'attr_id'               => $attribute->attr_id
                                        ];
                                        $attrDatas = $common_model->find_data('ecoex_business_inquiry_excel_data', 'array', $condition);
                                        //pr($attrDatas,false);
                                        if($attrDatas){ foreach($attrDatas as $attrData){
                                        ?>                                            
                                            <?php if($attribute->attr_id == 15){?>
                                                <td>                                            
                                                  <?php if($attrData->attr_value != ''){?>
                                                      <a href="<?=base_url('writable/uploads/'.$attrData->attr_value)?>" target="_blank" class="label label-primary mb-3">Pdf Uploaded - Click to view</a>
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
                                <?php if($row->published <= 2){?>
                                  <button type="submit" class="btn btn-success mt-3 mb-3"><i class="fa fa-check"></i> Approve & Share To Buyer</button>
                                <?php } ?>
                              </form>
                            </div>                                                                       
                        </div>
                    </div>
                    <?php }?>                  

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