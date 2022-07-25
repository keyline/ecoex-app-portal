<?php echo view('brand/inc/header'); ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <?php if(!$userData->user_mobile_auth){?>
            <p class="alert alert-danger">Mobile Number Not Verified Yet</p>
          <?php }?>
          <?php if(!$userData->user_email_auth){?>
            <p class="alert alert-danger">Email Address Not Verified Yet</p>
          <?php }?>

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
          <?php if(!$userData->user_email_auth){?>
            <div class="row">
              <div class="col-lg-12">
                <div class="dashboard_white_panel mt-3">
                  <div class="d-flex justify-content-between pt-3 pb-3 pl-3 pr-3 align-items-center">
                    <div class="dashbar_text">
                      <h4 class="font-weight-bold mb-2 text-danger">Email Address Not Verified Yet</h4>
                    </div>
                    <div class="dashbar_linkbtb">
                      <p class="mb-0"><a href="javascript:void(0);" id="sendVerificationLink" class="btn btn-success" onclick="sendVerificationLink('<?=$userData->user_email?>', 'user');">Send Verification Link</a></p>
                    </div>                    
                  </div>
                </div>
              </div>
            </div>
          <?php }?>
          
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
          
          <?php if($userData){ if(($userData->user_email_auth)){?>
          <!-- <div class="row">
            <div class="col-lg-12">
              <div class="dashboard_white_panel mt-3">
                  <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home" class="greenbtn">Current</a></li>
                    <li><a data-toggle="tab" href="#menu1" class="greenbtn">Past</a></li>
                  </ul>

                  <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                      <h3>Current Inquires</h3>
                      <div class="manage-quotes-inner">
                        <div class="table-part inquiries-table">
                          <table class="table table-stripped">
                            <thead class="thead-light">
                              <tr>
                                <th>S.No.</th>
                                <th>Inquiry Id</th>
                                <th>Created At</th>
                                <th>Inquiry Type</th>
                                <th>Access Type</th>
                                <th>Category</th>
                                <th>Sub-Category</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              if($currentInquiries){ foreach($currentInquiries as $row){
                                $subCategory      = $commonModel->find_data('ecoex_business_category', 'row', ['id' => $row->sucCatId], 'name');
                                $subSubCategory   = $commonModel->find_data('ecoex_business_category', 'row', ['id' => $row->productId], 'name');
                                $item             = $commonModel->find_data('ecoex_business_category', 'row', ['id' => $row->itemId], 'name');
                              ?>
                                <tr>
                                  <td class="manage-number">1</td>
                                  <td>#<?=$row->inquiry_no?></td>
                                  <td><?=date_format(date_create($row->createdAt), "d-m-Y")?></td>
                                  <td><?=$row->typeOfSale?></td>
                                  <td><?=$row->accessType?></td>
                                  <td><?=$row->categoryName?></td>
                                  <td class="manage-rigid">
                                      <p><?=!empty($subCategory)?$subCategory->name:''?></p>
                                      <p><?=!empty($subSubCategory)?$subSubCategory->name:''?></p>
                                      <p><?=!empty($item)?$item->name:''?></p>
                                  </td>
                                   <td>
                                      <p><?=date_format(date_create($row->inquiryStart), "d-m-Y")?></p>
                                      <p><?=date_format(date_create($row->inquiryStartTime), "h:i A")?></p>
                                  </td>
                                  <td>
                                      <p><?=date_format(date_create($row->inquiryEnd), "d-m-Y")?></p>
                                      <p><?=date_format(date_create($row->inquiryEndTime), "h:i A")?></p>
                                  </td>
                                  <td>
                                    <a target="_blank" href="<?php echo base_url();?>/brand/manageInquiriesDetails/<?=$row->inquiry_id?>" class="view-btn">View Details</a><br><br>
                                    <a href="<?php echo base_url();?>/brand/closeInquiry/<?=$row->inquiry_id?>" class="view-btn" onclick="return confirm('Do You Want To Close This Inquiry ?');">Close Inquiry</a>
                                  </td>  
                                </tr>
                              <?php } } else {?>
                                <tr>
                                  <td colspan="10" style="text-align: center;">No Inquiries Found !!!</td>
                                </tr>
                              <?php }?>                  
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                      <h3>Past Inquiries</h3>
                      <div class="manage-quotes-inner">
                        <div class="table-part inquiries-table">
                          <table class="table table-stripped">
                            <thead class="thead-light">
                              <tr>
                                <th>S.No.</th>
                                <th>Inquiry Id</th>
                                <th>Created At</th>
                                <th>Inquiry Type</th>
                                <th>Access Type</th>
                                <th>Category</th>
                                <th>Sub-Category</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Actions</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              if($pastInquiries){ foreach($pastInquiries as $row){
                                $subCategory      = $commonModel->find_data('ecoex_business_category', 'row', ['id' => $row->sucCatId], 'name');
                                $subSubCategory   = $commonModel->find_data('ecoex_business_category', 'row', ['id' => $row->productId], 'name');
                                $item             = $commonModel->find_data('ecoex_business_category', 'row', ['id' => $row->itemId], 'name');
                              ?>
                                <tr>
                                  <td class="manage-number">1</td>
                                  <td>#<?=$row->inquiry_no?></td>
                                  <td><?=date_format(date_create($row->createdAt), "d-m-Y")?></td>
                                  <td><?=$row->typeOfSale?></td>
                                  <td><?=$row->accessType?></td>
                                  <td><?=$row->categoryName?></td>
                                  <td class="manage-rigid">
                                      <p><?=!empty($subCategory)?$subCategory->name:''?></p>
                                      <p><?=!empty($subSubCategory)?$subSubCategory->name:''?></p>
                                      <p><?=!empty($item)?$item->name:''?></p>
                                  </td>
                                   <td>
                                      <p><?=date_format(date_create($row->inquiryStart), "d-m-Y")?></p>
                                      <p><?=date_format(date_create($row->inquiryStartTime), "h:i A")?></p>
                                  </td>
                                  <td>
                                      <p><?=date_format(date_create($row->inquiryEnd), "d-m-Y")?></p>
                                      <p><?=date_format(date_create($row->inquiryEndTime), "h:i A")?></p>
                                  </td>
                                  <td><a href="<?php echo base_url();?>/brand/manageInquiriesDetails/<?=$row->inquiry_id?>" class="view-btn">View Details</a></td>  
                                </tr>
                              <?php } } else {?>
                                <tr>
                                  <td colspan="10" style="text-align: center;">No Inquiries Found !!!</td>
                                </tr>
                              <?php }?>                  
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div> -->

          <div class="row">
            <div class="col-lg-12">
              <div class="dashboard_white_panel mt-3">
                <div class="d-flex justify-content-between pt-3 pb-3 pl-3 pr-3 align-items-center">
                  <div class="dashbar_text">
                    <h4 class="font-weight-bold mb-2">Create an Inquiry</h4>
                    <p class="mb-0">Start creating an enquiry</p>
                  </div>
                  <div class="dashbar_linkbtb">
                    <a href="<?=base_url('brand/target')?>" onclick="return confirm('Do You Want To Create Inquiry ?');"><img src="<?php echo site_url('public');?>/assets/client/images/create_icon.png" alt="" class="pr-2"> Create</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php } }?>
          
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
  <?php echo view('brand/inc/footer'); ?>
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