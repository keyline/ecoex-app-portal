<?php echo view('brand/inc/header'); ?>
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
                  <form role="form" id="addUser" action="/brand/targetToInquiryData" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="inquiry_start_date">Inquiry Start Date</label>
                                        <input type="date" class="form-control required" name="inquiry_start_date" id="inquiry_start_date" required>
                                    </div>
                                </div>
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="inquiry_start_time">Inquiry Start Time</label>
                                        <input type="time" class="form-control required" name="inquiry_start_time" id="inquiry_start_time" required>
                                    </div>
                                </div>                                
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="inquiry_end_date">Inquiry End Date</label>
                                        <input type="date" class="form-control required" name="inquiry_end_date" id="inquiry_end_date" required>
                                    </div>
                                </div>
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="inquiry_end_time">Inquiry End Time</label>
                                        <input type="time" class="form-control required" name="inquiry_end_time" id="inquiry_end_time" required>
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="description">Inquiry Description</label>
                                        <textarea class="form-control required" name="description" id="description" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Shared Member Type</label>
                                        <select class="form-control" name="member_type[]" required multiple>
                                            <option value="" selected>Select Member Type</option>
                                            <option value="2">Recycler</option>
                                            <option value="12">WMA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="attachment">Attach Document</label>
                                        <input type="file" class="form-control required" name="attachment" id="attachment" required>
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Document Required</label>
                                        <?php if($documentRequireds) { foreach($documentRequireds as $document){ ?> <br>
                                            <input type="checkbox" name="requiredDocument[]" id="requiredDocument<?=$document->id?>" 
                                            value="<?php echo $document->id;?>">
                                            <label for="requiredDocument<?php echo $document->id;?>"><?php echo $document->documentName;?></label>
                                        <?php } }?>
                                    </div>
                                </div>
                                
                            </div>
                        </div><!-- /.box-body -->
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

});
</script> 

  