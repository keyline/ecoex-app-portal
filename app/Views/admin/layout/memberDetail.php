<?php echo view('admin/layout/header'); ?>
<div class="wrapper-page">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
  <?php echo view('admin/layout/navbar'); ?>
  <?php echo view('admin/layout/sidebar'); ?>
  <div class="main-content">
    <section class="section">
      <div class="container-fluid">
<?php 
    $companyName = $controller->getCompanyName($totalMember->c_id);
    $companyDetail = $controller->getCompanyDetailByID($totalMember->c_id);
    $companyUserDetail = $controller->getmemberDetailByCID($totalMember->c_id);
    $companyAddress = $controller->getCompanyAddressData($totalMember->c_id);
    $memberType = $controller->getMemberType($companyUserDetail->user_membership_type);
    $companyType = $controller->getCompanyType($companyDetail->companyType);
    
    $companyDetail = $controller->getCompanyDetailById($totalMember->c_id);
    $companyCatData = $companyDetail->c_business_category;
    $companyCatData = explode (",", $companyCatData); 
    $categoryName = '';
    foreach($companyCatData as $cat){
        $category = $controller->getCatNameById($cat);
        $categoryName .= $category->name.',';
    }
                            
?>        
		<div class="row">
        	<div class="col-md-12">
        	    <?php /* if(isset($editUserMessage)){ ?>
        	    <p style="background-color: green;padding: 10px;color: #fff;width: 50%;">
        	        <?php echo $editUserMessage;?></p>
        	   <?php } */ ?>     
            	<div class="memberdetails_inner_section">
                	<div class="memberdetl_toppart">
                    	<div class="memberdetl_title">
                        	<h2><?php echo $companyName->c_name;?></h2>
                        	<?php if($companyName->c_status == '2'){ ?>
                            <div class="greenapprove">Approved on <?php echo date('d M Y',strtotime($companyName->c_approvedTime));?></div>
                            <?php } ?>
                        </div>
                        <div class="memberdetl_topbtn">
                        <?php if($companyName->c_status != '2'){ ?>
                        	<a href="/admin/approveCompanyData/<?php echo $totalMember->c_id;?>" class="member-approvebtn" onclick="return confirm('Are You Sure To Approve?')">Approve</a>
                        <?php } ?>    
                            <!-- <button type="button" class="btn approvebtn" id="click-show-comment">Comment</button> -->
                        	<a href="<?=base_url('/admin/editCompany/'.encoded($totalMember->c_id))?>" class="btn approvebtn">Edit</a>
                        </div>
                    </div>
                    
                    <div class="memberdetl_middle">
                    	<div class="middle-title mb-4">
                        	<h3>Company Details</h3>
                        </div>
                        <div class="member_midle_flex">
                        	<div class="memberdtl_col">
                                <div class="col pl-0">
                                    <h5>Establishment Date</h5>
                                    <p><?php echo date('d M Y',strtotime($companyDetail->c_establishDate));?></p>
                                </div>
                                <div class="col pl-0">
                                    <h5>Pan Number</h5>
                                    <p><?php echo $companyDetail->c_pan;?></p>
                                </div>
                                <div class="col pl-0">
                                    <h5>COI</h5>
                                    <?php if($companyDetail->coiFile != ''){?>
                                    <p><a href="/writable/uploads/<?php echo $companyDetail->coiFile;?>" target="_blank" class="viewopenimg">View</a></p>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="memberdtl_col">
                                <div class="col">
                                    <h5>Contact Person</h5>
                                    <p><?php echo $companyDetail->contactName;?></p>
                                </div>
                                <div class="col">
                                    <h5>Pan Card</h5>
                                    <?php if($companyDetail->c_pan_file != ''){?>
                                    <p><a href="/writable/uploads/<?php echo $companyDetail->c_pan_file;?>" target="_blank" class="viewopenimg">View</a></p>
                                    <?php } ?>
                                </div>
                                <div class="col">
                                    <h5>Mobile No.</h5>
                                    <p><?php echo $companyUserDetail->user_mobile;?></p>
                                </div>
                            </div>
                            <div class="memberdtl_col">
                                <div class="col">
                                    <h5>Member Type</h5>
                                    <p><?php echo $memberType->member_type;?></p>
                                </div>
                                <div class="col">
                                    <h5>GST Number</h5>
                                    <p><?php echo $companyDetail->c_gst;?></p>
                                </div>
                                <div class="col">
                                    <h5>Alt Mobile No.</h5>
                                    <p><?php echo $companyDetail->alMobileNo;?></p>
                                </div>
                            </div>
                            <div class="memberdtl_col">
                                <div class="col">
                                    <h5>Company Type</h5>
                                    <p><?php echo $companyType->name;?></p>
                                </div>
                                <div class="col">
                                    <h5>GST Number</h5>
                                    <?php if($companyDetail->c_gst_file != ''){?>
                                    <p><a href="/writable/uploads/<?php echo $companyDetail->c_gst_file;?>" target="_blank" class="viewopenimg">View</a></p>
                                    <?php } ?>
                                </div>
                                <div class="col">
                                    <h5>Business Category</h5>
                                    <p><?php echo rtrim($categoryName,',');?></p>
                                </div>
                            </div>
                            <div class="memberdtl_col">
                                <div class="col">
                                    <h5>Email ID</h5>
                                    <p><?php echo $companyUserDetail->user_email;?></p>
                                </div>
                                <div class="col">
                                    <h5>Alt Email Id</h5>
                                    <p><?php echo $companyDetail->alEmail;?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="comment-to-toggle" style="display: none;">
                        <form name="commentForm" action="/admin/companyComment" method="post">
                        <div class="comment-inner-section mb-5">
                        	<button id="close-btn"><i class="fa fa-times"></i></button>
                            <div class="comment-inner-part">
                            	<h2>Comment</h2>
                                <div class="comment-reply-post">
                                	<ul>
                            <?php 
                            foreach($totalCommentData as $commentData) {
                                if($commentData['commentBy'] == '1'){ $commmentBy = "Admin"; } else 
                                if($commentData['commentBy'] == '0'){ $commmentBy = "User"; }
                            ?>   	    
                                    <li>
                                	<h3><?php echo $commmentBy;?></h3>
                                    <div class="reply-comnt"><?php echo $commentData['comment'];?></div>
                                    </li>
                            <?php } ?>        
                                    </ul>
                                    <div class="commente-textarea">
                                    	<textarea  name="commentBox" required></textarea>
                                    </div>
                                    <input type="hidden" name="c_id" value="<?php echo $totalMember->c_id;?>">
                                    <input type="submit" name="submit" value="Submit" class="btn btn-primary" style="float: right;margin-top: 10px;">
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    
                    <div class="memberdetl_address">
                    	<div class="middle-title mb-4">
                        	<h3>Address</h3>
                        </div>
                        <?php 
                            $cityData = $controller->getCityByCityID($companyAddress->c_city);
                            $districtData = $controller->getDistByDistID($companyAddress->c_district);
                            $stateData = $controller->getStateByStateID($companyAddress->c_state);
                        ?>
                    	<div class="col pl-0">
                            <!--<p>Warehouse - 23, Plot no.42, Faridabad, Haryana, Pincode - 7003255</p>--->
                            <p>Warehouse - <?php echo $companyAddress->c_full_address.', '.$cityData->name.', '.$districtData->district_title.', '.
                            $stateData->state_title;?>, Pincode - <?php echo $companyAddress->c_pincode;?></p>
                        </div>
                    </div>                    
                    <?php $companyBankDetailData = $controller->getCompanyBankDetailsByID($totalMember->c_id); ?>
                    <div class="memberdetl_bank">
                    	<div class="middle-title mb-4">
                        	<h3>Bank Details</h3>
                        </div>
                        <div class="member_midle_flex">
                            <div class="memberdtl_col">
                                <div class="col pl-0">
                                    <h5>Account No.</h5>
                                    <p><?php echo $companyBankDetailData->accountNo;?></p>
                                </div>
                                <div class="col pl-0">
                                    <h5>Branch</h5>
                                    <p><?php echo $companyBankDetailData->c_branch_name;?></p>
                                </div>
                              </div>
                            <div class="memberdtl_col">
                                <div class="col">
                                    <h5>Account Holder Name</h5>
                                    <p><?php echo $companyBankDetailData->c_acct_holder_name;?></p>
                                </div>
                                <div class="col">
                                    <h5>IFSC Code</h5>
                                    <p><?php echo $companyBankDetailData->c_micr_code;?></p>
                                </div>
                              </div>
                            <div class="memberdtl_col">
                                <div class="col">
                                    <h5>Cancelled Check</h5>
                                    <?php if($companyBankDetailData->c_cancelled_cheque != ''){?>
                                    <p><a href="/writable/uploads/<?php echo $companyBankDetailData->c_cancelled_cheque;?>" target="_blank" class="viewopenimg">View</a></p>
                                    <?php } ?>                                    
                                </div>
                              </div>
                            <div class="memberdtl_col">
                                <div class="col">
                                    <h5>Account Type</h5>
                                    <p style="text-transform: capitalize;"><?php echo $companyBankDetailData->c_account_type;?></p>
                                </div>
                              </div>
                            <div class="memberdtl_col">
                                <div class="col">
                                    <h5>Bank Name</h5>
                                    <p><?php echo $companyBankDetailData->c_bank_name;?></p>
                                </div>
                              </div>
                        </div>
                    </div>                    
                    <?php if($companyUserDetail->user_membership_type == '2'){
                        $companyDetail = $controller->getUnitByStoreID($totalMember->c_id);
                        $unitMaterialDetail = $controller->getUnitMaterialDetailsByUnitID($totalMember->unit_id);                        
                        $stateList = $Comcontroller->getStateList();
                        $districtList = $Comcontroller->getDistrictListById($companyDetail->c_state);
                        $cityList = $Comcontroller->getCityListById($companyDetail->c_district);                            
                    ?>    
                    <div class="memberdetl_bank">
                        <div class="middle-title mb-4">
                            <h3 style="float: left;margin-right: 20px;">Unit Creation</h3> 
                            <a class="btn btn-info" href="/admin/editCompanyUnit/<?php echo encoded($totalMember->c_id).'/'.encoded(0);?>" target="_blank">Add New Unit</a>
                        </div>
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Unit Name</th>
                                            <th>Unit Category</th>
                                            <th>City</th>
                                            <th>District</th>
                                            <th>State</th>
                                            <th>Pincode</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $unitDatas = $controller->getUnitDatasByStoreID($totalMember->c_id);
                                                $cIj = 1;
                                                foreach($unitDatas as $unitData){ 
                                            $unitMatirialName = $controller->getCategoryUnitTypeById($unitData['unit_category']);  
                                            $unitCityName = $controller->getCityByCityID($unitData['c_city']);  
                                            $unitDistName = $controller->getDistByDistID($unitData['c_district']);  
                                            $unitStateName = $controller->getStateByStateID($unitData['c_state']);        
                                        ?>                                            
                                        <tr>
                                            <td><?php echo $cIj;?></td>
                                            <td><?php echo $unitData['unit_name'];?></td>
                                            <td><?php echo $unitMatirialName->name;?></td>
                                            <td><?php echo $unitCityName->name;?></td>
                                            <td><?php echo $unitDistName->district_title;?></td>
                                            <td><?php echo $unitStateName->state_title;?></td>
                                            <td><?php echo $unitData['c_pincode'];?></td>
                                            <td><?php echo $unitData['c_full_address'];?></td>
                                            <td><a class="btn btn-info" href="/admin/editCompanyUnit/<?php echo encoded($unitData['c_id']).'/'.encoded($unitData['unit_id']);?>" target="_blank">Edit Unit</a></td>
                                        </tr>
                                        <?php $cIj++; } ?>                                        
                                    </tbody>
                                </table>                                
                            </div>                            
                        </div>
                    </div>
                    <?php } ?>                    
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