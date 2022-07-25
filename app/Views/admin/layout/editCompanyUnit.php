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
        <?php //echo view($mainPage); ?>

<?php 
    $companyName = $controller->getCompanyName($totalMember->c_id);
    $companyDetail = $controller->getCompanyDetailByID($totalMember->c_id);
    $companyUserDetail = $controller->getmemberDetailByCID($totalMember->c_id);
    $companyAddress = $controller->getCompanyAddressData($totalMember->c_id);
    $cityList = $Comcontroller->getCityListById($companyAddress->c_district);
    $districtList = $Comcontroller->getDistrictListById($companyAddress->c_state);
    $memberType = $controller->getMemberType($companyUserDetail->user_membership_type);
    $companyType = $controller->getCompanyType($companyDetail->companyType);
    
    $companyDetail = $controller->getCompanyDetailById($totalMember->c_id);
    $companyCatData = $companyDetail->c_business_category;
    $companyCatData = explode (",", $companyCatData); 
    $categoryName = '';
    
    $unitImages = $commonModel->find_data('ecoex_unit_details_images', 'array', ['c_id' => $totalMember->c_id, 'type' => 0]);
    $unitVideos = $commonModel->find_data('ecoex_unit_details_images', 'array', ['c_id' => $totalMember->c_id, 'type' => 1]);
    
    foreach($companyCatData as $cat){
        $category = $controller->getCatNameById($cat);
        $categoryName .= $category->name.',';
    }
                            
?>        
		<div class="row">
        	<div class="col-md-12">
                <form method="post" action="/admin/editCompanyUnitData" enctype="multipart/form-data">
                    <input type="hidden" name="storeID" value="<?php echo $id;?>">
                    <input type="hidden" name="unitID" value="<?php echo $unitId;?>">
                    <input type="hidden" name="user_membership_type" value="<?php echo $companyUserDetail->user_membership_type;?>">
                    	<div class="middle-title mb-4">
                        	<a href="<?=base_url('admin/editCompany/'.encoded($id))?>" class="btn btn-outline-success">Back</a>
                        </div>
            	<div class="memberdetails_inner_section">
                    	<div class="middle-title mb-4">
                    	    <?php if($unitId != '0'){ ?>
                        	<h3>Edit Unit</h3>
                        	<?php } else { ?>
                        	<h3>Add New Unit</h3>
                        	<?php } ?>
                        </div>
                    <div class="memberdetl_middle">

                    <?php if($companyUserDetail->user_membership_type == '2'){
                    $companyDetail = $controller->getUnitByStoreID($totalMember->c_id);
                    $unitDetail = $controller->getUnitDetailUnitID($unitId);
                    $unitMaterialDetail = $controller->getUnitMaterialDetailsByUnitID($unitId);
                    
                    
                    $stateList = $Comcontroller->getStateList();
                    $districtList = $Comcontroller->getDistrictListById($unitDetail->c_state);
                    $cityList = $Comcontroller->getCityListById($unitDetail->c_district);            
                    ?>    
                    <div class="memberdetl_bank">
                    	<div class="middle-title mb-4">
                        	<h3>Unit Creation</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Unit Name <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Entry Unit Name" name="unit_name" 
                                    value="<?php echo $unitDetail->unit_name;?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Unit Category <span class="red">*</span></label>
                                    <div class="form-group pt-2">
                                    <select class="form-control" name="unit_category" required>
                                        <option value="">Select Unit Category</option>
                                        <?php foreach($categoryUnitDetail as $company){ ?>
                                        <option value="<?php echo $company['id'];?>" 
                                        <?php if($unitDetail->unit_category == $company['id']){ echo 'selected'; } ?>><?php echo $company['name'];?></option>
                                        <?php } ?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Material Details </label>
                                </div>
                            </div>

                            <div class="field_wrapper" style="width: 100%;">                                
                                <?php  $cI = 1;if($unitMaterialDetail) { foreach($unitMaterialDetail as $unitMaterial){ ?>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Type Of Material <span class="red">*</span> </label>
                                            <select class="form-control" name="typeOfMaterial[]">
                                                <option value="">Select Material</option>
                                                <?php foreach($materialDetail as $company){ ?>
                                                <option value="<?php echo $company['id'];?>" <?=(($unitMaterial['typeOfMaterial'] == $company['id'])?'selected':'')?>><?php echo $company['name'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>            
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Type Of Material Full Name <span class="red">*</span> </label>
                                            <input class="form-control" type="text" placeholder="Entry Material Full Name" name="materialFullName[]" value="<?=$unitMaterial['materialFullName']?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Monthly Capacity(MT) <span class="red">*</span> </label>
                                            <input class="form-control" type="text" placeholder="Monthly Capacity" name="monthlyCapicity[]" value="<?=$unitMaterial['monthlyCapicity']?>" oninput="calculateAnnualCapacity(this.value,<?=($unitMaterial['material_id']*100)?>)" onkeypress="return isNumber(event)" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Annual Capacity <span class="red">*</span> </label>
                                            <input class="form-control" type="text" placeholder="Annual Capacity" name="annualCapicity[]" value="<?=$unitMaterial['annualCapicity']?>" id="annualCapicity<?=($unitMaterial['material_id']*100)?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-1" style="margin-top: 29px;">
                                        <a href="javascript:void(0);" class="remove_button" title="Remove field">
                                            <i class="fa fa-minus-circle fa-2x text-danger"></i>
                                        </a>
                                    </div>
                                </div>
                                <?php $cI++; } }?>
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Type Of Material <span class="red">*</span> </label>
                                            <select class="form-control" name="typeOfMaterial[]">
                                                <option value="">Select Material</option>
                                                <?php foreach($materialDetail as $company){ ?>
                                                <option value="<?php echo $company['id'];?>"><?php echo $company['name'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>            
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Type Of Material Full Name <span class="red">*</span> </label>
                                            <input class="form-control" type="text" placeholder="Entry Material Full Name" name="materialFullName[]">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Monthly Capacity(MT) <span class="red">*</span> </label>
                                            <input class="form-control" type="text" placeholder="Monthly Capacity" name="monthlyCapicity[]" oninput="calculateAnnualCapacity(this.value,1)" onkeypress="return isNumber(event)" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Annual Capacity <span class="red">*</span> </label>
                                            <input class="form-control" type="text" placeholder="Annual Capacity" name="annualCapicity[]" id="annualCapicity1" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-1" style="margin-top: 29px;">
                                        <a href="javascript:void(0);" class="add_button" title="Add field">
                                            <i class="fa fa-plus-circle fa-2x text-success"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Consent to Operate </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Certificate No. <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Certificate Number" name="consent_cert_no" 
                                    value="<?php echo $unitDetail->consent_cert_no;?>" required>
                                </div>
                            </div>
            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Valid From <span class="red">*</span> </label>
                                    <input class="form-control" type="date" placeholder="Entry Material Full Name" name="consent_valid_from" 
                                    value="<?php echo $unitDetail->consent_valid_from;?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Valid Upto <span class="red">*</span> </label>
                                    <input class="form-control" type="date" placeholder="Monthly Capacity" name="consent_valid_upto" 
                                    value="<?php echo $unitDetail->consent_valid_upto;?>" required>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Upload <span class="red">*</span> </label>                                    
                                    <input class="form-control" type="file" id="custom-input-file-4" placeholder="Choose file" name="consent_document" <?php if($unitDetail->consent_document != ""){ } else {?> required <?php } ?> accept="image/gif, image/jpeg, image/png, application/pdf">
                                    <?php if($unitDetail->consent_document != ''){?>
                                        <a href="<?=base_url('writable/uploads/'.$unitDetail->consent_document)?>" class="badge badge-info" target="_blank">View File</a>
                                    <?php }?>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">PWM Certificate </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Certificate No. <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Certificate Number" name="pwm_cert_no" 
                                    value="<?php echo $unitDetail->pwm_cert_no;?>" required>
                                </div>
                            </div>
            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Valid From <span class="red">*</span> </label>
                                    <input class="form-control" type="date" placeholder="Entry Material Full Name" name="pwm_valid_from" 
                                    value="<?php echo $unitDetail->pwm_valid_from;?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Valid Upto <span class="red">*</span> </label>
                                    <input class="form-control" type="date" placeholder="Monthly Capacity" name="pwm_valid_upto" 
                                    value="<?php echo $unitDetail->pwm_valid_upto;?>" required>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Upload <span class="red">*</span> </label>
                                    <input class="form-control" type="file" id="custom-input-file-4" placeholder="Choose file" name="pwm_document" <?php if($unitDetail->pwm_document != ""){ } else {?> required <?php } ?> accept="image/gif, image/jpeg, image/png, application/pdf">
                                    <?php if($unitDetail->pwm_document != ''){?>
                                        <a href="<?=base_url('writable/uploads/'.$unitDetail->pwm_document)?>" class="badge badge-info" target="_blank">View File</a>
                                    <?php }?>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">CPCB/SPCB</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Certificate No. <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Certificate Number" name="cpcb_cert_no" 
                                    value="<?php echo $unitDetail->cpcb_cert_no;?>" required>
                                </div>
                            </div>
            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Valid From <span class="red">*</span> </label>
                                    <input class="form-control" type="date" placeholder="Entry Material Full Name" name="cpcb_valid_from" 
                                    value="<?php echo $unitDetail->cpcb_valid_from;?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Valid Upto <span class="red">*</span> </label>
                                    <input class="form-control" type="date" placeholder="Monthly Capacity" name="cpcb_valid_upto" 
                                    value="<?php echo $unitDetail->cpcb_valid_upto;?>" required>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Upload <span class="red">*</span> </label>
                                    <input class="form-control" type="file" id="custom-input-file-4" placeholder="Choose file" name="cpcb_document" <?php if($unitDetail->cpcb_document != ""){ } else {?> required <?php } ?> accept="image/gif, image/jpeg, image/png, application/pdf">
                                    <?php if($unitDetail->cpcb_document != ''){?>
                                        <a href="<?=base_url('writable/uploads/'.$unitDetail->cpcb_document)?>" class="badge badge-info" target="_blank">View File</a>
                                    <?php }?>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Images & Videos of Plant</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Plant Images(Max 5) <span class="red"></span> </label>
                                    <div class="row">
                                        <?php if($unitImages){ foreach($unitImages as $unitImage){?>
                                            <div class="col-md-3">
                                                <img src="<?=base_url('writable/uploads/'.$unitImage->unit_image)?>" class="img-thumbnail mb-3" style="width: 100%; height: 100px;">
                                            </div>
                                        <?php } }?>
                                    </div>
                                    <input class="form-control" type="file" id="plant_images" placeholder="Choose file" name="plant_images[]" multiple accept="image/jpeg,image/jpg,image/png,image/gif,image/svg">
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Plant Video <span class="red"></span> </label>
                                    <div class="row">
                                        <?php if($unitVideos){ foreach($unitVideos as $unitVideo){?>
                                            <div class="col-md-3">
                                                <img src="<?=base_url('writable/uploads/'.$unitVideo->unit_image)?>" class="img-thumbnail mb-3" style="width: 100%; height: 100px;">
                                            </div>
                                        <?php } }?>
                                    </div>
                                    <input class="form-control" type="file" id="custom-input-file-4" placeholder="Choose file" name="plant_videos[]" multiple accept="video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Address</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">State <span class="red">*</span> </label>
                                    <select class="form-control" name="c_state1" id="state1" required>
                                        <option>Select state </option>
                                        <?php foreach($stateList as $state){ ?>
                                        <option value="<?php echo $state['state_id'];?>"
                                        <?php if($unitDetail->c_state == $state['state_id']){ echo 'selected'; } ?>><?php echo $state['state_title'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">District <span class="red">*</span> </label>
                                    <select class="form-control" name="c_district1" id="district1" required>
                                        <option>Select District </option>
                                        <?php foreach($districtList as $district){ ?>
                                        <option value="<?php echo $district['districtid'];?>"
                                        <?php if($unitDetail->c_district == $district['districtid']){ echo 'selected'; } ?>><?php echo $district['district_title'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">City </label>
                                    <select class="form-control" name="c_city1" id="city1">
                                        <option>Select city</option>
                                        <?php foreach($cityList as $city){ ?>
                                        <option value="<?php echo $city['id'];?>"
                                        <?php if($unitDetail->c_city == $city['id']){ echo 'selected'; } ?>><?php echo $city['name'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Pincode <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Enter Pincode" name="c_pincode" 
                                    value="<?php echo $unitDetail->c_pincode;?>" required onkeypress="return isNumber(event)" maxlength="6" minlength="6">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Address <span class="red">*</span> </label>
                                    <textarea class="form-control" type="text" name="c_full_address" required><?php echo $unitDetail->c_full_address;?></textarea>
                                </div>
                            </div>
                            
                            
                            
                        </div>
                    </div>
<?php } ?>                    
                    
                    <input type="submit" name="next" class="btn btn-primary" value="Submit" />
                </div>
                
            </form>    
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
    $('#click-show-comment, #comment-to-toggle').click(function (e) {
        if ($(e.target).attr('id') != 'close-btn') {
            $('#comment-to-toggle').show();
            event.stopPropagation();
        }
    });
    $(' #close-btn').click(function () {
        $('#comment-to-toggle').hide();
        event.stopPropagation();
    })
</script>

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
 
 $("#state1").change(function(){  
    var stateId = $(this).val();
      $.ajax({   
        type: "GET",
        data: { stateId: stateId },
        url: "/getDistrict.php",             
        dataType: "html",   //expect html to be returned                
        success: function(response){
                $("#district1").html(response);
        }
    });
 });
 $("#district1").change(function(){  
    var distId = $(this).val();
      $.ajax({   
        type: "GET",
        data: { distId: distId },
        url: "/getCity.php",             
        dataType: "html",   //expect html to be returned                
        success: function(response){
                $("#city1").html(response);
        }
    });
 });
 
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper         
        var x = 1; //Initial field counter is 1
        
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){ 
                x++; //Increment field counter
                var fieldHTML = '<div class="row mb-3">\
                                    <div class="col-md-3">\
                                        <div class="form-group">\
                                            <label for="">Type Of Material <span class="red">*</span> </label>\
                                            <select class="form-control" name="typeOfMaterial[]">\
                                                <option value="">Select Material</option>\
                                                <?php foreach($materialDetail as $company){ ?>
                                                <option value="<?php echo $company['id'];?>"><?php echo $company['name'];?></option>\
                                                <?php } ?>
                                            </select>\
                                        </div>\
                                    </div>\
                                    <div class="col-md-3">\
                                        <div class="form-group">\
                                            <label for="">Type Of Material Full Name <span class="red">*</span> </label>\
                                            <input class="form-control" type="text" placeholder="Entry Material Full Name" name="materialFullName[]">\
                                        </div>\
                                    </div>\
                                    <div class="col-md-3">\
                                        <div class="form-group">\
                                            <label for="">Monthly Capacity(MT) <span class="red">*</span> </label>\
                                            <input class="form-control" type="text" placeholder="Monthly Capacity" name="monthlyCapicity[]" oninput="calculateAnnualCapacity(this.value,'+x+')" onkeypress="return isNumber(event)">\
                                        </div>\
                                    </div>\
                                    <div class="col-md-2">\
                                        <div class="form-group">\
                                            <label for="">Annual Capacity <span class="red">*</span> </label>\
                                            <input class="form-control" type="text" placeholder="Annual Capacity" name="annualCapicity[]" id="annualCapicity'+x+'" readonly autocomplete="off">\
                                        </div>\
                                    </div>\
                                    <div class="col-md-1" style="margin-top: 29px;">\
                                        <a href="javascript:void(0);" class="remove_button" title="Remove field">\
                                            <i class="fa fa-minus-circle fa-2x text-danger"></i>\
                                        </a>\
                                    </div>\
                                </div>'; //New input field html
                $(wrapper).append(fieldHTML); //Add field html
            }
        });
        
        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
    function calculateAnnualCapacity(val,counter){        
        //$('.monthlyCapicity').closest( ".annualCapicity" ).val( val*12 );
        var annualCapicity = val*12;
        $('#annualCapicity'+counter).val(annualCapicity.toFixed(2));
    }
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>