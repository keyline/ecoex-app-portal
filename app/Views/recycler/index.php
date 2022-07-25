<?php echo view('recycler/inc/header'); ?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="row">
            <div class="col-lg-12">
              <div class="toptile_search">
                <div class="page-title">
                  <h2>Dashboard</h2>
                </div>
                <!-- <div class="search-container">
                    <div class="form-group has-search">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input type="text" class="form-control" placeholder="Search">
                  </div>
                </div> -->
              </div>

              <div class="dashboar_image mt-3">
                <img src="<?php echo site_url('public');?>/assets/client/images/dashboard_landingtop_banner.png" alt="">
                <div class="dashboard_info">
                  <h2>Welcome to ECOEX dashboard</h2>
                  <p>To get you started, we have suggested you contiune with the following steps</p>
                </div>
              </div>
            </div>
          </div>

          <?php if(!$userData->user_mobile_auth){?>
          <div class="row">
            <div class="col-lg-12">
              <div class="dashboard_white_panel mt-3">
                <div class="d-flex justify-content-between pt-3 pb-3 pl-3 pr-3 align-items-center">
                  <div class="dashbar_text">
                    <h4 class="font-weight-bold mb-2 text-danger">Mobile Number Not Verified Yet</h4>
                    <p class="mb-0">Start Verified</p>
                  </div>
                  <div class="dashbar_linkbtb">
                    <span id="otp-smsg" class="text-success fw-bold"></span>
                    <span id="otp-fmsg" class="text-danger fw-bold"></span>
                    <a class="btn btn-success btn-block" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1" onclick="sendOTP();">Verify</a>                    
                    <div class="collapse multi-collapse" id="multiCollapseExample1">
                      <!-- <form method="post" action=""> -->
                        <input type="hidden" id="mobile" value="<?=$userData->user_mobile?>">
                        <input type="hidden" id="dbotp">
                        <div class="form-group">
                          <input type="text" id="userotp" class="form-control" placeholder="Enter OTP">
                        </div>
                        <button type="button" class="btn btn-success" onclick="verifyOTP();">Verify</button>
                      <!-- </form> -->                          
                    </div>                    
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php }?>

          <div class="row">
            <div class="col-lg-12">
              <div class="dashboard_white_panel mt-3">
                <div class="d-flex justify-content-between pt-3 pb-3 pl-3 pr-3 align-items-center">
                  <div class="dashbar_text">
                    <h4 class="font-weight-bold mb-2">Post Inventory</h4>
                    <p class="mb-0">Start creating a inventory</p>
                  </div>
                  <div class="dashbar_linkbtb">
                    <a href="<?=base_url('recycler/inventory')?>"><img src="<?php echo site_url('public');?>/assets/client/images/create_icon.png" alt="" class="pr-2"> Create</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="dashboard_white_panel mt-3">
                <div class="d-flex justify-content-between pt-3 pb-3 pl-3 pr-3 align-items-center">
                  <div class="dashbar_text">
                    <h4 class="font-weight-bold mb-2">Invite Team Members</h4>
                    <p class="mb-0">Build your team by inviting members</p>
                  </div>
                  <div class="dashbar_linkbtb">
                    <a href="#"><img src="<?php echo site_url('public');?>/assets/client/images/addteam_icon.png" alt="" class="pr-2"> Add team member</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
              <div class="dashboard_white_panel mt-3">
                <div class="d-flex justify-content-between pt-3 pb-3 pl-3 pr-3 align-items-center">
                  <div class="dashbar_text">
                    <h4 class="font-weight-bold mb-2">Invite</h4>
                    <p class="mb-0">Start building your platform by inviting</p>
                  </div>
                  <div class="dashbar_linkbtb">
                    <a href="#"><img src="<?php echo site_url('public');?>/assets/client/images/invited_icon.png" alt="" class="pr-2"> Invite</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          
          
        </section>
      </div>
      <!-- <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2022 <div class="bullet"></div> 
        </div>
        <div class="footer-right">
         Develop By <a href="https://keylines.net/" target="_blank">Keyline DigiTech</a>
        </div>
      </footer> -->
    </div>
  </div>
  
  <?php echo view('recycler/inc/footer'); ?>
  <script type="text/javascript">
    function sendOTP(){
      let mobile = $('#mobile').val();
      let baseUrl = '<?=base_url()?>';
      $.ajax({
          type: "POST",
          data: { mobile: mobile },
          url: baseUrl+"/sendOTP",
          dataType: "JSON",
          success: function(res){
              if(res.status){
                  $('#dbotp').val(res.response.otp);
                  $('#otp-smsg').show();
                  $('#otp-fmsg').hide();
                  $('#otp-smsg').html(res.message);
              } else {
                  $('#dbotp').val('');
              }
          }
      });
    }
    function verifyOTP(){
      let mobile  = $('#mobile').val();
      let dbOTP = $('#dbotp').val();
      let userotp = $('#userotp').val();
      if(userotp == ''){
        $('#otp-smsg').hide();
        $('#otp-fmsg').show();
        $('#otp-fmsg').html('Please Enter OTP !!!');
      } else {
        if(dbOTP == userotp){
          let mobile = $('#mobile').val();
          let baseUrl = '<?=base_url()?>';
          $.ajax({
              type: "POST",
              data: { mobile: mobile },
              url: baseUrl+"/verifyOTP",
              dataType: "JSON",
              success: function(res){
                if(res.status){
                  $('#otp-smsg').show();
                  $('#otp-fmsg').hide();
                  $('#otp-smsg').html(res.message);                  
                  window.setTimeout(function() {
                    location.reload();
                  }, 3000);
                } else {
                  //
                }
              }
          });          
        } else {
          $('#otp-smsg').hide();
          $('#otp-fmsg').show();
          $('#otp-fmsg').html('OTP Mismatched !!!');
          $('#userotp').val('');
        }        
      }
    }
  </script>