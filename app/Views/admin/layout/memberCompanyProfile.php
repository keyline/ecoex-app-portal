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
                        <h3 class="box-title">Member Company Profile</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="<?=base_url('admin/memberCompanyProfileStore')?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="mode" value="member">
                        <input type="hidden" name="storeId" value="<?=$storeData->c_id?>">
                        <input type="hidden" name="storeUserId" value="<?=$storeUserData->user_id?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Company Name </label>
                                        <input class="form-control" type="text" placeholder="Ecoex Portal" value="<?php echo $storeData->c_name;?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Company Establishment Date <span class="red">*</span> </label>
                                        <input class="form-control" type="date" name="establishDate" placeholder="Entry Company Establishment Date" 
                                        value="<?php echo $companyDetail->c_establishDate;?>" required>
                                    </div>
                                </div>
                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Contact Person Name <span class="red">*</span> </label>
                                        <input class="form-control" type="text" name="contactPerson" placeholder="Entry Contact Person Name"
                                        value="<?php echo $companyDetail->contactName;?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Company Type <span class="red">*</span> </label>
                                        <select class="form-control" name="companyType" required>
                                            <option value="">Select Company Type</option>
                                            <?php foreach($companyList as $company){ ?>
                                            <option value="<?php echo $company['id'];?>" 
                                            <?php if($companyDetail->companyType == $company['id']){ echo 'selected'; } ?>><?php echo $company['name'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Pan Number <span class="red">*</span> </label>
                                        <input class="form-control" type="text" placeholder="Entry Pan Number" name="panNumber" 
                                        value="<?php echo $companyDetail->c_pan;?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Upload Pan Card <?php if($companyDetail->c_pan_file != ""){ } else {?><span class="red">*</span><?php } ?>  </label>
                                        <input class="form-control" type="file" id="custom-input-file" placeholder="Entry Pan Number" name="panCard" 
                                        <?php if($companyDetail->c_pan_file != ""){ } else {?> required <?php } ?>>
                                    </div>
                                </div>                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">GST Number <span class="red">*</span> </label>
                                        <input class="form-control" type="text" placeholder="Entry GST Number" name="gstNumber" 
                                        value="<?php echo $companyDetail->c_gst;?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Upload GST Document <?php if($companyDetail->c_gst_file != ""){ } else {?><span class="red">*</span><?php } ?> </label>
                                        <input class="form-control" type="file" id="custom-input-file-2" placeholder="Entry GST Number" name="gstCard" 
                                        <?php if($companyDetail->c_gst_file != ""){ } else {?> required <?php } ?>>
                                    </div>
                                </div>                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Alternate Mobile no. </label>
                                        <input class="form-control" type="text" placeholder="Entry alternate mobile no." name="alMobile"
                                        value="<?php echo $companyDetail->alMobileNo;?>" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Alternate Email Id </label>
                                        <input class="form-control" type="text" placeholder="Entry alternate email id" name="alEmail"
                                        value="<?php echo $companyDetail->alEmail;?>" >
                                    </div>
                                </div>
                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Optional Document upload (COI)</label>
                                        <input class="form-control" type="file" id="custom-input-file-3" placeholder="Entry GST Number" name="COI">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Business Category</label>
                                        <div class="form-group pt-2">
                                            <?php foreach($categoryList as $category){ ?>
                                            <div class="form-check form-check-inline clear">
                                            <?php  $allMainCategories = explode(',' ,$companyDetail->c_business_category); ?>
                                                <input class="form-check-input greencheck" type="checkbox" name="businessCategory[]" id="checkbox<?php echo $category['id']; ?>" 
                                                value="<?php echo $category['id']; ?>" <?php if(in_array($category['id'], $allMainCategories)){ echo 'checked'; } ?>>
                                                <label class="form-check-label" for="checkbox<?php echo $category['id']; ?>"><?php echo $category['name']; ?></label>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                

                                <?php foreach($categoryList as $category){ 
                                $totalCategory5 = $controller->getSubCategoryByParentID($category['id']);
                                if(in_array($category['id'], $allMainCategories)){ $checkboxDisplay = "inline"; } else { $checkboxDisplay = "none"; } 
                                ?>
                                <div class="col-md-6" id="subCategoryCheckbox<?php echo $category['id'];?>" style="display:<?php echo $checkboxDisplay; ?>">
                                    <div class="form-group">
                                        <label for=""><?php echo $category['name']; ?></label>
                                        <div class="form-group pt-2">
                                         <?php foreach($totalCategory5 as $category5){ ?>    
                                            <div class="form-check form-check-inline clear">
                                                <input class="form-check-input greencheck" type="checkbox" name="businessCategory[]" id="<?php echo $category5['id']; ?>" 
                                                value="<?php echo $category5['id']; ?>" <?php if(in_array($category5['id'], $allMainCategories)){ echo 'checked'; } ?>>
                                                <label class="form-check-label" for="<?php echo $category5['id']; ?>"><?php echo $category5['name']; ?></label>
                                            </div>
                                        <?php } ?>    
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                
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
<?php foreach($categoryList as $category){ ?>        
    $('#checkbox<?php echo $category['id'];?>').change(function(){
        if(this.checked){ 
            $('#subCategoryCheckbox<?php echo $category['id'];?>').show(300);
        }else{
            $('#subCategoryCheckbox<?php echo $category['id'];?>').hide(200);
            $("#subCategoryCheckbox<?php echo $category['id'];?>").find(":checkbox").prop("checked", false);
        }

    });
<?php } ?>    
});
</script>