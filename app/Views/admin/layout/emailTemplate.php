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
                        <h3 class="box-title" style="float:left">Email Template</h3>
                    </div>
                    <div class="col-md-12 table-responsive">
                      <table id="example" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Sr. No.</th>
                            <th>Template For</th>
                            <th class="text-center">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          $i=1;
                          foreach($totalEmailTemplate as $emailTemplate){
                              ?>
                          <tr>
                            <td><?= $i; ?></td>
                            <td><?php echo $emailTemplate['email_name'];?></td>
                            <td><a style="color: red;" href="<?php echo site_url('admin/editEmailTemplate/'.$emailTemplate['id']);?>">
                                <i class="nav-icon fas fa-pencil"></i> Edit</a></td>
                          </tr>
                          <?php $i++; } ?>                    
                        </tbody>
                      </table>                  
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