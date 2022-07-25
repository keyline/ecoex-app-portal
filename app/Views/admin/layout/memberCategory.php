<?php echo view('admin/layout/header'); ?>
<div class="wrapper-page">
  <div class="main-wrapper">
    <div class="navbar-bg"></div>
    <?php echo view('admin/layout/navbar'); ?>
    <?php echo view('admin/layout/sidebar'); ?>
    <!-- Main Content -->
    <div class="main-content">
      <section class="section">
        <div class="container-fluid">        
          <div class="row">
              <div class="col-md-12">
                <div class="box">
                  <div class="box-header">
                      <h3 class="box-title">Member Type List</h3>
                      <p><a class="btn btn-success" href="<?=base_url('admin/addMemberType/')?>"><i class="nav-icon fas fa-plus"></i> Add Member Type</a></p>
                  </div><!-- /.box-header -->
                  <div class="col-md-12 table-responsive">
                  <table id="example" class="table table-bordered table-striped">
                      <thead>
                          <tr>
                            <th>Sr. No.</th>
                            <th>Type</th>
                            <th>Member Count</th>
                            <th>Created Date</th>
                            <th>Updated Date</th>
                            <th class="text-center">Actions</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php if($totalCategory){ $i=1; foreach($totalCategory as $row){ ?>
                          <tr>
                            <td><?=$i; ?></td>
                            <td><?php echo $row['member_type'];?></td>
                            <td>
                                <?php
                                $join[0] = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                                echo $memberCount = $commonModel->find_data('ecoex_user_table', 'count', ['ecoex_company.c_status' => 2, 'ecoex_user_table.user_membership_type' => $row['member_id']], '', $join);
                                //echo $memberCount = $commonModel->find_data('ecoex_user_table', 'count', ['user_membership_type' => $row['member_id']]);
                                ?>
                            </td>
                            <td><?php echo date('d-m-Y h:i:s',strtotime($row['created_at']));?></td>
                            <td><?php echo date('d-m-Y h:i:s',strtotime($row['updated_at']));?></td>
                            <td>
                              <a class="text-primary" href="<?=base_url('admin/updateMemberType/'.$row['member_id'])?>"><i class="nav-icon fas fa-edit"></i> Edit</a>

                              <a style="color: red;" href="<?php echo site_url('admin/deleteMemberType/'.$row['member_id']);?>" onclick="return confirm('Are you sure?')">
                                <i class="nav-icon fas fa-trash"></i> Delete</a>
                            </td>
                          </tr>
                          <?php $i++; } }?>
                      </tbody>
                  </table>
                    
                  </div><!-- /.box-body -->
                  <div class="box-footer clearfix">
                                      </div>
                </div><!-- /.box -->
              </div>
          </div>   
        </div>
    </section>
    </div>
  <!-- Main Content -->
  </div>
</div>
<?php echo view('admin/layout/footer'); ?>

<?php if($totalCategory){ $i=1; foreach($totalCategory as $row){ ?>
<!-- Modal -->
<div class="modal fade" id="editModal<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" action="<?php echo site_url('admin/updateMemberType/'.$row['member_id']);?>">
        <input type="hidden" name="member_id" value="<?=$row['member_id']?>">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Member Type</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-md-12">                                
                    <div class="form-group">
                        <label for="fname">Member Type *</label>
                        <input type="text" class="form-control" name="member_type" value="<?=$row['member_type']?>" required>
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </div>
    </form>
  </div>
</div>
<?php $i++; } }?>