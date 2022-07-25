<?php echo view('admin/layout/header'); ?>
<div class="wrapper-page">
  <div class="main-wrapper">
    <div class="navbar-bg"></div>
  <?php echo view('admin/layout/navbar'); ?>
  <?php echo view('admin/layout/sidebar'); ?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style type="text/css">
      .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
          color: #fff;
          background-color: #48974e;
      }
  </style> 
  <div class="main-content">
      <section class="section">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title" style="float:left">Manage Expired Posts</h3>
                </div>
                <div class="col-md-12">
                  <?php if($session->getFlashdata('success_message')) { ?>
                    <p class="alert alert-success"><?php echo $session->getFlashdata('success_message');?></p>
                  <?php } ?>                  
                  <ul class="nav nav-pills">
                    <li class="active"><a data-toggle="pill" href="#menu1" style="font-size: 13px;">Brand</a></li>
                    <?php if($member_category){ foreach($member_category as $member_cat){?>
                      <li><a data-toggle="pill" href="#menu<?=$member_cat->member_id?>" style="font-size: 13px;"><?=$member_cat->short_name?></a></li>
                    <?php } }?>
                  </ul>                  
                  <div class="tab-content">
                    <div id="menu1" class="tab-pane fade in active">
                      <h3>Brand Posts</h3>                      
                      <table class="table table-bordered table-stripped">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Item</th>
                            <th>Type<br>Month<br>Year</th>
                            <th>Post Qty</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if($userData1){ $sl=1; foreach($userData1 as $row){?>
                            <?php
                            $category      = $common_model->find_data('ecoex_business_category', 'row', ['id' => $row->categoryId], 'name');
                            $subcategory   = $common_model->find_data('ecoex_business_category', 'row', ['id' => $row->sucCatId], 'name');
                            $product       = $common_model->find_data('ecoex_business_category', 'row', ['id' => $row->productId], 'name');
                            $item          = $common_model->find_data('ecoex_business_category', 'row', ['id' => $row->itemId], 'name');

                            $join[0]                = ['table' => 'ecoex_state', 'field' => 'state_id', 'table_master' => 'ecoex_target_by_state', 'field_table_master' => 'state_id', 'type' => 'INNER'];
                            $stateWiseQty  = $common_model->find_data('ecoex_target_by_state', 'array', ['ecoex_target_by_state.target_id' => $row->target_id], 'ecoex_target_by_state.*,ecoex_state.state_title', $join);
                            ?>
                            <tr>
                              <td><?=$sl++?></td>
                              <td>
                                <p><i class="fa fa-home"></i> <?=$row->c_name?></p>
                                <p><i class="fa fa-user"></i> <?=$row->user_name?></p>
                                <p><i class="fa fa-envelope"></i> <?=$row->user_email?></p>
                                <p><i class="fa fa-mobile"></i> <?=$row->user_mobile?></p>
                              </td>
                              <td>
                                <?=(($category)?$category->name:'')?><br>
                                <?=(($subcategory)?$subcategory->name:'')?><br>
                                <?=(($product)?$product->name:'')?><br>
                                <?=(($item)?$item->name:'')?>
                              </td>
                              <td>
                                <p class="<?=(($row->inventory_type == 'BUY')?'text-success':'text-danger')?>"><?=$row->inventory_type?></p>
                                <p><?=$common_model->monthName($row->month)?></p>
                                <p><?=$row->year?></p>
                              </td>
                              <td>
                                <p><?=$row->qty?> <?=$row->unit_name?></p>
                                <p>
                                  <ul>
                                    <?php if($stateWiseQty){foreach($stateWiseQty as $stateWiseQty){?>
                                    <li><?=$stateWiseQty->state_title?> <i class="fa fa-arrow-right"></i> <?=$stateWiseQty->req_qty?> <?=$row->unit_name?>
                                        <a target="_blank" href="<?=base_url('/admin/postViewDetails/'.encoded($stateWiseQty->id).'/'.encoded(1))?>" class="label label-warning">View List</a>
                                    </li>
                                    <?php } }?>
                                  </ul>
                                </p>
                              </td>
                              <td>
                                <!-- <a href="<?=base_url('/admin/postExpire/'.encoded($row->target_id).'/'.encoded(1))?>" class="btn btn-success" onclick="return confirm('Do You Want To Expire This Post ?');">Get Expire</a> -->
                                <a href="<?=base_url('/admin/postDetails/'.encoded($row->target_id).'/'.encoded(1))?>" class="btn btn-info">Get Details</a>
                              </td>
                            </tr>
                          <?php } } else {?>
                            <tr>
                              <td colspan="5" style="text-align: center;">No Brand Posts Found !!!</td>
                            </tr>
                          <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <?php if($member_category){ foreach($member_category as $member_cat){?>
                    <div id="menu<?=$member_cat->member_id?>" class="tab-pane fade">
                      <h3><?=$member_cat->member_type?> Posts</h3>
                      <table class="table table-bordered table-stripped">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Item</th>
                            <th>Type<br>Month<br>Year</th>
                            <th>Post Qty</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php //pr($userData[$member_cat->member_id],false);?>
                          <?php if($userData[$member_cat->member_id]){ $sl=1; foreach($userData[$member_cat->member_id] as $row){?>
                            <?php
                            $category      = $common_model->find_data('ecoex_business_category', 'row', ['id' => $row->categoryId], 'name');
                            $subcategory   = $common_model->find_data('ecoex_business_category', 'row', ['id' => $row->sucCatId], 'name');
                            $product       = $common_model->find_data('ecoex_business_category', 'row', ['id' => $row->productId], 'name');
                            $item          = $common_model->find_data('ecoex_business_category', 'row', ['id' => $row->itemId], 'name');

                            $join[0]                = ['table' => 'ecoex_state', 'field' => 'state_id', 'table_master' => 'ecoex_inventory_by_state', 'field_table_master' => 'state_id', 'type' => 'INNER'];
                            $stateWiseQty  = $common_model->find_data('ecoex_inventory_by_state', 'array', ['ecoex_inventory_by_state.inventory_id' => $row->inventory_id], 'ecoex_inventory_by_state.*,ecoex_state.state_title', $join);
                            ?>
                            <tr>
                              <td><?=$sl++?></td>
                              <td>
                                <p><i class="fa fa-home"></i> <?=$row->c_name?></p>
                                <p><i class="fa fa-user"></i> <?=$row->user_name?></p>
                                <p><i class="fa fa-envelope"></i> <?=$row->user_email?></p>
                                <p><i class="fa fa-mobile"></i> <?=$row->user_mobile?></p>
                              </td>
                              <td>
                                <?=(($category)?$category->name:'')?><br>
                                <?=(($subcategory)?$subcategory->name:'')?><br>
                                <?=(($product)?$product->name:'')?><br>
                                <?=(($item)?$item->name:'')?>
                              </td>
                              <td>
                                <p class="<?=(($row->inventory_type == 'BUY')?'text-success':'text-danger')?>"><?=$row->inventory_type?></p>
                                <p><?=$common_model->monthName($row->month)?></p>
                                <p><?=$row->year?></p>
                              </td>
                              <td>
                                <p><?=$row->qty?> <?=$row->unit_name?></p>
                                <p>
                                  <ul>
                                    <?php if($stateWiseQty){foreach($stateWiseQty as $stateWiseQty){?>
                                    <li><?=$stateWiseQty->state_title?> <i class="fa fa-arrow-right"></i> <?=$stateWiseQty->req_qty?> <?=$row->unit_name?>
                                        <a target="_blank" href="<?=base_url('/admin/postViewDetails/'.encoded($stateWiseQty->id).'/'.encoded($member_cat->member_id))?>" class="label label-warning">View List</a>
                                    </li>
                                    <?php } }?>
                                  </ul>
                                </p>
                              </td>
                              <td>
                                <!-- <a href="<?=base_url('/admin/postExpire/'.encoded($row->inventory_id).'/'.encoded($member_cat->member_id))?>" class="btn btn-success" onclick="return confirm('Do You Want To Expire This Post ?');">Get Expire</a> -->
                                <a href="<?=base_url('/admin/postDetails/'.encoded($row->inventory_id).'/'.encoded($member_cat->member_id))?>" class="btn btn-info">Get Details</a>
                              </td>
                            </tr>
                          <?php } } else {?>
                            <tr>
                              <td colspan="5" style="text-align: center;">No <?=$member_cat->member_type?> Posts Found !!!</td>
                            </tr>
                          <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <?php } }?>
                  </div>
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