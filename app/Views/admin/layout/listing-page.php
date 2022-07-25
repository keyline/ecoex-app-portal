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
                      <h3 class="box-title" style="float:left">Manage Listing Page</h3>
                  </div>
                  <div class="col-md-12 table-responsive">
                    <table id="example" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Sr. No.</th>
                          <th>Member Type</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php $i=1; if($memberTypes) { foreach($memberTypes as $memberType){ ?>
                          <tr>
                            <td><?=$i?></td>
                            <td><?=$memberType->member_type?></td>                          
                            <td>
                              <a class="text-primary" href="<?php echo site_url('admin/editManageListingpage/'.$memberType->member_id);?>">
                              <i class="nav-icon fas fa-edit"></i> Edit</a>
                            </td>
                          </tr>
                        <?php $i++; } }?>                    
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