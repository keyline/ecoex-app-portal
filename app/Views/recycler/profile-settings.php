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
                    <form class="updateProfile" method="POST" action="recycler/profile-settings-post">
                        <input type="hidden" name="user_id" value="<?=$userId?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="user_name">Enter Name *</label>
                                        <input type="text" class="form-control requiredCheckProfile" name="user_name" id="user_name" value="<?=$profile->user_name?>" data-check="Name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="user_email">Enter Email *</label>
                                        <input type="email" class="form-control requiredCheckProfile" name="user_email" id="user_email" value="<?=$profile->user_email?>" data-check="Email" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="user_mobile">Enter Mobile *</label>
                                        <input type="text" class="form-control requiredCheckProfile" name="user_mobile" id="user_mobile" value="<?=$profile->user_mobile?>" data-check="Mobile" autocomplete="off">
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