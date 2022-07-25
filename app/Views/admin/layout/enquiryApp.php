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
                <div class="box-header">
                    <h3 class="box-title" style="float:left">Enquiry List From App</h3>
                </div>
                <div class="col-md-12 table-responsive">
                  <table id="example" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Sr. No.</th>
                        <th>Category/<br>Sub Category/<br>/Product/<br>/Item</th>
                        <th>Enquiry From</th>
                        <th>Enquiry To</th>
                        <th>Uploaded Documents</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if($rows) { $sl=1;foreach($rows as $row){
                        $inventory      = $common_model->find_data('ecoex_collecter_inventory', 'row', ['inventory_id' => $row->inventory_id]);
                        $category       = $common_model->find_data('ecoex_business_category', 'row', ['id' => $inventory->categoryId], 'name');
                        $subcategory    = $common_model->find_data('ecoex_business_category', 'row', ['id' => $inventory->sucCatId], 'name');
                        $product        = $common_model->find_data('ecoex_business_category', 'row', ['id' => $inventory->productId], 'name');
                        $item           = $common_model->find_data('ecoex_business_category', 'row', ['id' => $inventory->itemId], 'name');
                        
                        $enquiryFromUser    = $common_model->find_data('ecoex_user_table', 'row', ['user_id' => $row->recycler_id]);
                        $enquiryFromCompany = $common_model->find_data('ecoex_company', 'row', ['c_id' => $enquiryFromUser->c_id]);
                        $enquiryFromMemberType = $common_model->find_data('ecoex_member_category', 'row', ['member_id' => $enquiryFromUser->user_membership_type]);
                        //pr($enquiryFromCompany);

                        $enquiryToCompany = $common_model->find_data('ecoex_company', 'row', ['c_id' => $row->c_id]);
                        $enquiryToUser    = $common_model->find_data('ecoex_user_table', 'row', ['c_id' => $row->c_id]);
                        $enquiryToMemberType = $common_model->find_data('ecoex_member_category', 'row', ['member_id' => $enquiryToUser->user_membership_type]);
                      ?>
                      <tr>
                        <td><?=$sl++?></td>
                        <td>
                          <?=(($category)?$category->name:'')?><br>
                          <?=(($subcategory)?$subcategory->name:'')?><br>
                          <?=(($product)?$product->name:'')?><br>
                          <?=(($item)?$item->name:'')?>
                        </td>
                        <td>
                          <?=$enquiryFromCompany->c_name?><br>(<?=$enquiryFromMemberType->member_type?>)
                        </td>
                        <td>
                          <?=$enquiryToCompany->c_name?><br>(<?=$enquiryToMemberType->member_type?>)
                        </td>
                        <td>
                          <ul class="list-group">
                            <li class="list-group-item">Aadhar File : <a href="<?=base_url('/writable/uploads/'.$row->aadhar_file)?>" target="_blank" class="label label-success">View</a></li>
                            <li class="list-group-item">Votar File : <a href="<?=base_url('/writable/uploads/'.$row->votar_file)?>" target="_blank" class="label label-success">View</a></li>
                            <li class="list-group-item">Pan File : <a href="<?=base_url('/writable/uploads/'.$row->pan_file)?>" target="_blank" class="label label-success">View</a></li>
                            <li class="list-group-item">Document File : <a href="<?=base_url('/writable/uploads/'.$row->document_file)?>" target="_blank" class="label label-success">View</a></li>
                          </ul>
                        </td>
                      </tr>
                      <?php } }?>
                    </tbody>
                  </table>                  
                </div>
              </div>
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
