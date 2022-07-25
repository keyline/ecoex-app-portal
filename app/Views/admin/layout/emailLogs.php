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
                      <h3 class="box-title" style="float:left">Email Logs</h3>
                  </div><!-- /.box-header -->
                  <div class="col-md-12 table-responsive">
                  <table id="example" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Sr. No.</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>Email Message</th>
                        <th class="text-center">Time</th>
                      </tr>
                      </thead>
                        <tbody>
                            <?php 
                            $i=1;
                            foreach($totalEmailLogs as $emailLogs){
                                $userDetails = $controller->getmemberDetailData($emailLogs['userID']);
                                ?>
                            <tr>
                              <td><?=$i++?></td>
                              <td><?php echo $userDetails->user_name;?></td>
                              <td><?php echo $userDetails->user_email;?></td>
                              <td><?php echo $emailLogs['email'];?></td>
                              <td><?php echo $emailLogs['createdAt'];?></td>
                              
                            </tr>
                            <?php } ?>                    
                    </tbody></table>
                    
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