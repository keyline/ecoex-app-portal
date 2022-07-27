<?php echo view('brand/inc/header'); ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="row">
            <div class="col-lg-12">
              <div class="toptile_search">
                <div class="page-title">
                  <h2>Convert Target To Inquiry</h2>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="dashboard_white_panel mt-3">
                <div class="d-flex justify-content-between pt-3 pb-3 pl-3 pr-3 align-items-center">
                  <form role="form" id="addUser" action="<?=base_url('/brand/targetToInquiryData')?>" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="inquiry_start_date">Inquiry Start Date</label>
                                        <input type="date" class="form-control" name="inquiry_start_date" id="inquiry_start_date" required>
                                    </div>
                                </div>
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="inquiry_start_time">Inquiry Start Time</label>
                                        <input type="time" class="form-control" name="inquiry_start_time" id="inquiry_start_time" required>
                                    </div>
                                </div>                                
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="inquiry_end_date">Inquiry End Date</label>
                                        <input type="date" class="form-control" name="inquiry_end_date" id="inquiry_end_date" required>
                                    </div>
                                </div>
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="inquiry_end_time">Inquiry End Time</label>
                                        <input type="time" class="form-control" name="inquiry_end_time" id="inquiry_end_time" required>
                                    </div>
                                </div>
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="description">Inquiry Description</label>
                                        <textarea class="form-control" name="description" id="description" required></textarea>
                                    </div>
                                </div>                                
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="attachment">Attach Document</label>
                                        <input type="file" class="form-control" name="attachment" id="attachment" accept="image/gif, image/jpeg, image/png">
                                    </div>
                                </div>
                                <div class="col-md-4">                                
                                    <div class="form-group">
                                        <label for="attachment">Post Type</label>
                                        <select class="form-control" name="visibility" id="visibility" required>
                                            <option value="" selected>Select Post Type</option>
                                            <option value="0">PUBLIC</option>
                                            <option value="1">PRIVATE</option>
                                        </select>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                    $convert_to_inquiry_members = json_decode($userData->convert_to_inquiry_members);
                                    //print_r($convert_to_inquiry_members);
                                    ?>
                                    <ul class="nav nav-tabs">
                                        <?php
                                        if(count($convert_to_inquiry_members)>0){
                                            for($k=0;$k<count($convert_to_inquiry_members);$k++){
                                                $memberCategory = $common_model->find_data('ecoex_member_category', 'row', ['member_id' => $convert_to_inquiry_members[$k]]);
                                        ?>
                                        <li<?=(($k == 0)?' class="active"':'')?>><a data-toggle="tab" href="#menu<?=$k?>"><?=(($memberCategory)?$memberCategory->member_type:'')?></a></li>
                                        <?php } }?>
                                    </ul>

                                    <div class="tab-content">
                                        <?php
                                        if(count($convert_to_inquiry_members)>0){
                                            for($k=0;$k<count($convert_to_inquiry_members);$k++){
                                                $memberCategory = $common_model->find_data('ecoex_member_category', 'row', ['member_id' => $convert_to_inquiry_members[$k]]);
                                        ?>
                                        <div id="menu<?=$k?>" class="tab-pane fade<?=(($k == 0)?' in active':'')?>">
                                          <h3><?=(($memberCategory)?$memberCategory->member_type:'')?></h3>
                                          <input type="hidden" name="member_type[]" value="<?=(($memberCategory)?$memberCategory->member_id:0)?>">

                                          <table id="example<?=(($memberCategory)?$memberCategory->member_id:0)?>" class="table table-stripped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Location</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $join[0]    = ['table' => 'ecoex_company_address', 'field' => 'c_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                                                    $users      = $common_model->find_data('ecoex_user_table', 'array', ['ecoex_user_table.user_membership_type' => $memberCategory->member_id, 'ecoex_user_table.userStatus' => 2], '', $join);
                                                    if($users) { foreach($users as $user){
                                                        $state = $common_model->find_data('ecoex_state', 'row', ['state_id' => $user->c_state]);
                                                    ?>
                                                    <tr>
                                                        <td>
                                                          <input type="checkbox" name="user_id<?=(($memberCategory)?$memberCategory->member_id:0)?>[]" class="member" value="<?=$user->user_id?>">
                                                        </td>
                                                        <td><?=$user->user_name?></td>
                                                        <td><?=$user->user_email?></td>
                                                        <td>
                                                            <?=$user->c_full_address?><br>
                                                            <?=(($state)?$state->state_title:'')?>
                                                        </td>
                                                    </tr>
                                                    <?php } }?>
                                              </tbody>
                                          </table>
                                        </div>
                                        <?php } }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $target_state_wise_ids = [];
                        if($target_details_ids){
                            foreach($target_details_ids as $target_details_id){
                                $target_state_wise_ids[] = $target_details_id->id;
                            }
                        }
                        ?>
                        <div class="box-footer">
                            <input type="hidden" name="target_id" value="<?php echo $targetID;?>" required>
                            <input type="hidden" name="target_state_wise_ids" value="<?php echo implode(",", $target_state_wise_ids);?>" required>
                            <input type="submit" class="btn btn-primary" name="submit" value="Convert">
                        </div>
                    </form>
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

<script>
$(document).ready(function(){ 
    $("#category").change(function(){   
        var catId = $(this).val();
          $.ajax({   
            type: "GET",
            data: { parent: catId,name:'Sub Category' },
            url: "/getBusinessCategory.php",             
            dataType: "html",   //expect html to be returned                
            success: function(response){
                    $("#subCategory").html(response);
            }
        });
    });
    $("#subCategory").change(function(){  
        var subCatId = $(this).val();
          $.ajax({   
            type: "GET",
            data: { parent: subCatId,name:'Item' },
            url: "/getBusinessCategory.php",             
            dataType: "html",   //expect html to be returned                
            success: function(response){
                    $("#item").html(response);
            }
        });
    });

    $('#visibility').on('change', function(){
        var visibility = $('#visibility').val();
        if(visibility == 0){
            $('.member').prop('checked', true);
        } else {
            $('.member').prop('checked', false);
        }
    });

});
</script> 

  