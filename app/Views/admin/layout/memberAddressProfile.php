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
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Member Address Profile</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="<?=base_url('admin/memberAddressProfileStore')?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="mode" value="member">
                        <input type="hidden" name="storeId" value="<?=$storeData->c_id?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Country <span class="red">*</span> </label>
                                        <select class="form-control" name="country" required>
                                            <option value="1">India</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">State <span class="red">*</span> </label>
                                        <select class="form-control" name="state" id="state" required>
                                            <option>Select state </option>
                                            <?php foreach($stateList as $state){ ?>
                                            <option value="<?php echo $state['state_id'];?>"
                                            <?php if($companyDetail->c_state == $state['state_id']){ echo 'selected'; } ?>><?php echo $state['state_title'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">District <span class="red">*</span> </label>
                                        <select class="form-control" name="district" id="district" required>
                                            <option>Select District </option>
                                            <?php foreach($districtList as $district){ ?>
                                            <option value="<?php echo $district['districtid'];?>"
                                            <?php if($companyDetail->c_district == $district['districtid']){ echo 'selected'; } ?>><?php echo $district['district_title'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">City <span class="red">*</span> </label>
                                        <select class="form-control" name="city" id="city" required>
                                            <option>Select city</option>
                                            <?php foreach($cityList as $city){ ?>
                                            <option value="<?php echo $city['id'];?>"
                                            <?php if($companyDetail->c_city == $city['id']){ echo 'selected'; } ?>><?php echo $city['name'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Pincode <span class="red">*</span></label>
                                        <input class="form-control" type="text" name="pincode" placeholder="Entry Pincode" value="<?php echo $companyDetail->c_pincode;?>" required>
                                    </div>
                                </div>
                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Address <span class="red">*</span> </label>
                                        <textarea placeholder="Entry Address" name="address" class="form-control" required><?php echo $companyDetail->c_full_address;?></textarea>
                                    </div>
                                </div>
                                
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                        </div>
                    </form>
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

<script>
    $(document).ready(function(){ 
     $("#state").change(function(){  
        var stateId = $(this).val();
          $.ajax({   
            type: "GET",
            data: { stateId: stateId },
            url: "/getDistrict.php",             
            dataType: "html",   //expect html to be returned                
            success: function(response){
                $("#district").html(response);
            }
        });
     });
     $("#district").change(function(){  
        var distId = $(this).val();
          $.ajax({   
            type: "GET",
            data: { distId: distId },
            url: "/getCity.php",             
            dataType: "html",   //expect html to be returned                
            success: function(response){
                $("#city").html(response);
            }
        });
     });

    });
</script> 