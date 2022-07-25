<?php echo view('admin/layout/header'); ?>
<div class="wrapper">
  <?php echo view('admin/layout/navbar'); ?>
  <?php echo view('admin/layout/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php echo view('admin/layout/breadcrumb'); ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
              <div class="box">              
                <div class="col-md-12 table-responsive">
                <table id="example" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style="text-align:center;">Enquiry</th>
                        <th style="text-align:center;">Inventory</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      foreach($targetData as $target){ 
                      $company = $controller->getCompanyByID($target['c_id']);
                      if($target['itemId'] != ''){     
                      $catVariable = 'itemId';
                      $item = $controller->getItemByID($target['itemId']);
                      } else if($target['sucCatId'] != ''){     
                      $catVariable = 'sucCatId';           
                      $item = $controller->getItemByID($target['sucCatId']);
                      } else if($target['categoryId'] != ''){   
                      $catVariable = 'categoryId';             
                      $item = $controller->getItemByID($target['categoryId']);
                      }
                      $unit = $controller->getUnitByID($target['unit']);
                      $getStateAllocateQty = $controller->getAllocateQtyState($target['target_id']);
                      $unallocateQty = $target['qty'] - $getStateAllocateQty->allocateQty;
                      if($getStateAllocateQty->allocateQty == ''){
                          $allocatedQty = '0';
                      } else {
                          $allocatedQty = $getStateAllocateQty->allocateQty;
                      }             
                      ?>
                      <tr>
                        <td>
                                <?php echo $company->c_name;?> <br>
                                <?php echo $item->name;?>
                        </td>
                        <td>

                        </td>
                      </tr>                                    
                      <?php 
                      $stateAllocateData = $controller->getStateAllocateDataByState($target['target_id']);
                      foreach($stateAllocateData as $stateTarget){ 
                      $stateName = $controller->getStateByID($stateTarget['state_id']);
                      $unallocateQty = $stateTarget['req_qty'];
                      ?>                    
                      <tr>
                        <td>
                          <span><?php echo $stateName->state_title;?></span>
                          <span style="float: right;"><?php echo $stateTarget['req_qty'].''.$unit->name;?></span>
                        </td>                 
                        <td>                 
                          <?php 
                          $inventoryStateData = $controller->getInventoryDataByState($stateTarget['state_id'],$item->id,$catVariable);
                          foreach($inventoryStateData as $inventoryState){ 
                          $company = $controller->getCompanyByID($inventoryState['c_id']);
                          $companyUser = $controller->getCompanyUserByID($inventoryState['c_id']);
                          ?>              
                          <span><?php echo $company->c_name;?>, ph:<?php echo $companyUser->user_mobile;?></span><br>
                          <?php }  ?>              
                        </td>
                      </tr>
                      <?php } }  ?>                    
                    </tbody>
                  </table>                  
                </div>
              </div><!-- /.box -->
            </div>
        </div>   
      </div><!-- /.container-fluid -->
    </section>
  </div>
  <!-- /.content-wrapper -->
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<?php echo view('admin/layout/footer'); ?>
