<?php echo view('recycler/inc/header'); ?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="row">
            <div class="col-lg-12">
              <div class="toptile_search">
                <div class="page-title">
                  <h2><?=$page_header?></h2>
                </div> 
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="dashboard_white_panel mt-3">
                <div class="d-flex justify-content-between pt-3 pb-3 pl-3 pr-3 align-items-center">
                    <form class="changePassword" method="POST" action="recycler/change-password-post">
                        <input type="hidden" name="user_id" value="<?=$userId?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="old_password">Enter Old Password *</label>
                                        <input type="password" class="form-control requiredCheckChangePassword" name="old_password" id="old_password" data-check="Old Password" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="new_password">Enter New Password *</label>
                                        <input type="password" class="form-control requiredCheckChangePassword" name="new_password" id="new_password" data-check="New Password" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="confirm_confirm">Enter Confirm Password *</label>
                                        <input type="password" class="form-control requiredCheckChangePassword" name="confirm_confirm" id="confirm_confirm" data-check="Confirm Password" autocomplete="off">
                                    </div>
                                </div>                                
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>

          
          
        </section>
      </div>
    </div>
  </div>  
  <?php echo view('recycler/inc/footer'); ?>