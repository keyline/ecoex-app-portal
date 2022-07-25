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
        <?php //echo view($mainPage); ?>
        
        <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title" style="float:left">Member List</h3>
                </div><!-- /.box-header -->
                <div class="col-md-12 table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>Sr. No.</th>
                      <th>Company Name</th>
                      <th>Email</th>
                      <th>Mobile No.</th>
                      <th>Type</th>
                      <th>Joining Date</th>
                      <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                <tbody>
<?php 
$i=1;
foreach($totalMember as $row){
    $companyName = $controller->getCompanyName($row['c_id']);
    $memberType = $controller->getMemberType($row['user_membership_type']);
    if($row['user_email_auth'] == '1'){ $emailValidation = "check-circle"; $emailColor = "green"; } else { $emailValidation = "window-close"; $emailColor = "red"; } 
    if($row['user_mobile_auth'] == '1'){ $mobileValidation = "check-circle"; $mobileColor = "green"; } else { $mobileValidation = "window-close"; $mobileColor = "red"; } 
    ?>
                    <tr>
                      <td><?= $i; ?></td>
                      <td><?php echo $companyName->c_name;?></td>
                      <td><?php echo $row['user_email'];?> <i class="nav-icon fas fa-<?php echo $emailValidation;?>" style="color:<?php echo $emailColor;?>"></i></td>
                      <td><?php echo $row['user_mobile'];?> <i class="nav-icon fas fa-<?php echo $mobileValidation;?>" style="color:<?php echo $mobileColor;?>"></i></td>
                      <td><?php echo $memberType->member_type;?></td>
                      <td><?php echo date('d-m-Y h:i:s',strtotime($row['created_at']));?></td>
                      <td><a href="<?php echo site_url('admin/memberDetail/'.$row['user_id']);?>">
                          <i class="nav-icon fas fa-eye"></i> View More</a></td>
                    </tr>
<?php $i++; } ?>                    
            </tbody></table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
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
