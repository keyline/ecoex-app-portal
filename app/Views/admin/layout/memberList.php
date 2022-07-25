<?php echo view('admin/layout/header'); ?>
<div class="wrapper-page">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
  <?php echo view('admin/layout/navbar'); ?>
  <?php echo view('admin/layout/sidebar'); ?>
  <!-- Main Content -->
      <div class="main-content">
        <section class="section">
      <div class="container-fluid approvalrequest_page">        
        <div class="row">
            <div class="col-md-12">
              <div class="box">
              <div class="toptile_search">
              	<div class="page-title">
                	 <h2>Approved Members</h2>
                </div>
                <!-- <div class="search-container">
                    <div class="form-group has-search">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input type="text" class="form-control" placeholder="Search">
                  </div>
              	</div> -->
              </div>
              	<div class="col-md-12">              	
                <div class="box-number-filter">
                   <div class="tablelist_number">
                   		<h3>Total: <?php echo $totalPendingSum;?> Approved Members</h3>
                   </div>
                   <div class="innertop-filter">
                      <a href="<?=base_url('admin/memberAdd')?>" style="margin-right: 10px;"><i class="fa fa-plus"></i> Add New Member </a>
                   		<!-- <a href="javascript:void(0)" onclick="openNav()"><i class="fa fa-filter"></i> Filter </a> -->
                   </div>
                </div><!-- /.box-header -->
                </div>
                
                <!-- <div class="col-md-12 table-responsive"> -->
                  <table id="example" class="table table-fixed  sticky-header">
                    <thead>
                      <tr>
                        <th>#</th>
                        <!-- <th>Requested On</th> -->
                        <th>Member Type</th>
                        <th>Company Name<br>Email<br>Phone</th>
                        <th>Business Category</th>
                        <th>Annual Capacity</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $sl=1;
                      if($totalMember) { foreach($totalMember as $row){
                        $companyName = $controller->getCompanyName($row['c_id']);
                        $companyName = $controller->getCompanyName($row['c_id']);
                        $companyDetail = $controller->getCompanyDetailById($row['c_id']);
                        $companyUserData = $controller->getmemberDetailByCID($row['c_id']);
                        $memberType = $controller->getMemberType($companyUserData->user_membership_type);
                        if($row['user_email_auth'] == '1'){ $emailValidation = "check-circle"; $emailColor = "green"; } else { $emailValidation = "window-close"; $emailColor = "red"; } 
                        if($row['user_mobile_auth'] == '1'){ $mobileValidation = "check-circle"; $mobileColor = "green"; } else { $mobileValidation = "window-close"; $mobileColor = "red"; } 
                        
                        $companyDetail = $controller->getCompanyDetailById($row['c_id']);
                        $companyCatData = $companyDetail->c_business_category;
                        $companyCatData = explode (",", $companyCatData); 
                        $categoryName = [];
                        foreach($companyCatData as $cat){
                            $category = $controller->getCatNameById($cat);
                            $categoryName[] = $category->name;
                        }
                        $updatedTime = $row['updated_at'];
                        $updatedText = "Updated on";
                        if($row['c_lastCommentTime'] >= $row['updated_at']){
                            $updatedTime = $row['c_lastCommentTime'];
                            $updatedText = "Commented on";
                        }
                        if($row['c_approvedTime'] >= $updatedTime){
                            $updatedTime = $row['c_approvedTime'];
                            $updatedText = "Approved on";
                        }
                        $join[0] = ['table' => 'ecoex_business_category', 'field' => 'id', 'table_master' => 'ecoex_unit_material_detail', 'field_table_master' => 'typeOfMaterial', 'type' => 'INNER'];
                        $unitMaterials = $common_model->find_data('ecoex_unit_material_detail', 'array', ['ecoex_unit_material_detail.c_id' => $row['c_id']], 'ecoex_unit_material_detail.*,ecoex_business_category.name', $join);
                        ?>                    
                      <tr>
                        <td><?php echo $sl++; ?></td>
                        <!-- <td><?php echo date('d/m/Y',strtotime($row['created_at']));?></td> -->
                        <td><?php echo $memberType->member_type;?></td>
                        <td><?php echo $companyName->c_name;?><br><?php echo $companyUserData->user_email;?><br><?php echo $companyUserData->user_mobile;?></td>
                        <td>
                          <ul>
                            <?php if(count($categoryName)>0){for($i=0;$i<count($categoryName);$i++){?>
                              <li><?=$categoryName[$i]?></li>
                            <?php } }?>
                          </ul>
                        </td>
                        <td>
                          <ul>
                            <?php if($unitMaterials){foreach($unitMaterials as $unitMaterial){?>
                              <li><?=$unitMaterial->name?> <i class="fa fa-arrow-right"></i> <?=$unitMaterial->annualCapicity?></li>
                            <?php } }?>
                          </ul>
                        </td>
                        <td>
                          <div class="lightgreen_bg">
                            <?php echo $updatedText;?><br>
                            <?php echo date('d/m/y',strtotime($updatedTime));?>
                          </div>
                        </td>
                        <td>
                          <a target="_blank" href="<?php echo site_url('admin/memberDetail/'.encoded($row['c_id']));?>" class="btn btn-outline-success"> Details</a>
                          <br><br>
                          <a href="<?php echo site_url('admin/memberDelete/'.$row['c_id']);?>" class="btn btn-outline-danger" onclick="return confirm('Do you want to delete ths member ? Upon delete this member all data including member details, company details, bank, address and unit details will also be deleted. Do you still want to proceed ?')"> Delete</a>
                        </td>
                      </tr>
                      <?php } } ?>
                    </tbody>
                  </table>
                <!-- </div> -->
              </div><!-- /.box -->
            </div>
        </div>   
      </div><!-- /.container-fluid -->
    </section>
  </div>
      <!-- Main Content -->
    </div>
</div>


<div id="tablefilter" class="filtersidenav">
	<div class="filtersidetop">
    	<h4>Fiters</h4>
  		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  	</div>
  
  <div class="accordion" id="accordionExample">
      <div class="card">
        <div class="card-header" id="headingOne">
          <h2 class="mb-0">
            <button class="btn accordion-button" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Business Categroy
            </button>
          </h2>
        </div>
    
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body">
           <div class="form-check">
              <label class="form-check-label" for="Plastic">
                Plastic
              </label>
              <input class="form-check-input greencheck" type="checkbox" value="" id="Plastic">
            </div>
            <div class="form-check">
              <label class="form-check-label" for="EWaste">
                E-Waste
              </label>
              <input class="form-check-input greencheck" type="checkbox" value="" id="EWaste">
            </div>
            <div class="form-check">
              <label class="form-check-label" for="Rubber">
                Rubber
              </label>
              <input class="form-check-input greencheck" type="checkbox" value="" id="Rubber">
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingTwo">
          <h2 class="mb-0">
            <button class="btn accordion-button" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Member Type
            </button>
          </h2>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
          <div class="card-body">
            <div class="form-check">
              <label class="form-check-label" for="Brand">
                Brand
              </label>
              <input class="form-check-input greencheck" type="checkbox" value="" id="Brand">
            </div>
            <div class="form-check">
              <label class="form-check-label" for="Recycler">
                Recycler
              </label>
              <input class="form-check-input greencheck" type="checkbox" value="" id="Recycler">
            </div>
            <div class="form-check">
              <label class="form-check-label" for="Waste">
                Waste Collertor
              </label>
              <input class="form-check-input greencheck" type="checkbox" value="" id="Waste">
            </div>
            <div class="form-check">
              <label class="form-check-label" for="EOL">
                EOL
              </label>
              <input class="form-check-input greencheck" type="checkbox" value="" id="EOL">
            </div>
          </div>
        </div>
      </div>
</div>
  
  
    <div class="filterside_bottom">
    	<div class="filderside_botlink">
        	<a href="#">Clear</a>
            <a href="#" class="appylybtn">Apply</a>
        </div>
    </div>
</div>
<script>
function openNav() {
  document.getElementById("tablefilter").style.width = "250px";
}

function closeNav() {
  document.getElementById("tablefilter").style.width = "0";
}
</script>
<?php echo view('admin/layout/footer'); ?>

