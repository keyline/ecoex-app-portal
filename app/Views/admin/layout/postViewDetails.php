<?php echo view('admin/layout/header'); ?>
<div class="wrapper-page">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <?php echo view('admin/layout/navbar'); ?>
      <?php echo view('admin/layout/sidebar'); ?>
      <div class="main-content">
        <section class="section">
          <div class="container-fluid">        
            <div class="row">
                <div class="col-md-12">
                  <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Post View List (<?=count($post_view_list)?> views)</h3>                    <
                    </div>
                    <div class="col-md-12 table-responsive">
                      <table id="example" class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                <th>#</th>
                                <th>User Type</th>
                                <th>Company Name</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>IP Address</th>
                                <th>Visit Date/Time</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php if($post_view_list){ $i=1; foreach($post_view_list as $row){ ?>
                                <?php
                                $user = [];                          
                                if($row->user_id>0){
                                  $user = $common_model->getUserByUserId($row->user_id);                            
                                }                          
                                ?>
                                <tr>
                                  <td><?=$i?></td>
                                  <td><?=(($user)?$user->member_type:'')?></td>
                                  <td><?=(($user)?$user->c_name:'')?></td>
                                  <td><?=(($user)?$user->user_name:'')?></td>
                                  <td><?=(($user)?$user->user_email:'')?></td>
                                  <td><?=(($user)?$user->user_mobile:'')?></td>
                                  <td><?=$row->ip_address?></td>
                                  <td>
                                    <?php
                                      echo date_format(date_create($row->created_at), "M d, Y").'<br>';
                                      echo date_format(date_create($row->created_at), "h:i A");
                                    ?>
                                  </td>
                                </tr>
                              <?php $i++; } }?>
                          </tbody>
                      </table>
                    </div>
                    <div class="box-footer clearfix"></div>
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