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
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">                
                                <div class="card">
                                    <div class="card-header bg-success text-light">Member Type (Total member : 
                                        <?php
                                        $join[0] = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                                        echo $totalMemberCount = $commonModel->find_data('ecoex_user_table', 'count', ['ecoex_company.c_status!=' => 0, 'ecoex_user_table.user_membership_type>' => 0], '', $join);
                                        ?>)
                                    </div>
                                    <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                  <th>#</th>
                                                  <th>Member TypeType</th>
                                                  <th>Total Members</th>
                                                  <th>Approved Members</th>
                                                  <th>Pending Members</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if($totalCategory){ $i=1; $totMember = 0; $totApproveMember = 0; $totDisapproveMember = 0; foreach($totalCategory as $row){ ?>
                                                <tr>
                                                  <td><?=$i; ?></td>
                                                  <td><?php echo $row['member_type'];?></td>
                                                  <td>
                                                    <?php
                                                    $join[0] = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                                                    echo $memberCount = $commonModel->find_data('ecoex_user_table', 'count', ['ecoex_user_table.user_membership_type' => $row['member_id'], 'ecoex_company.c_status!=' => 0], '', $join);
                                                    $totMember              += $memberCount;
                                                    ?>
                                                  </td>
                                                  <td>
                                                    <?php
                                                    $join[0] = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                                                    echo $memberCount = $commonModel->find_data('ecoex_user_table', 'count', ['ecoex_user_table.user_membership_type' => $row['member_id'], 'ecoex_company.c_status' => 2], '', $join);
                                                    $totApproveMember       += $memberCount;
                                                    ?>
                                                  </td>
                                                  <td>
                                                    <?php
                                                    $join[0] = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                                                    echo $memberCount = $commonModel->find_data('ecoex_user_table', 'count', ['ecoex_user_table.user_membership_type' => $row['member_id'], 'ecoex_company.c_status' => 1], '', $join);
                                                    $totDisapproveMember    += $memberCount;
                                                    ?>
                                                  </td>
                                                </tr>
                                                <?php $i++; } }?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="2" style="text-align: right;">Total <i class="fa fa-arrow-right"></i></th>
                                                    <th><?=$totMember?></th>
                                                    <th><?=$totApproveMember?></th>
                                                    <th><?=$totDisapproveMember?></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        </div>
                                    </div>
                                </div>                    
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <a href="<?=base_url('admin/memberList')?>">
                                    <div class="small-box bg-blue">
                                        <div class="icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div class="inner" style="text-align: center;">
                                            <?php                                
                                            $join[0] = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                                            $totalMemberCount = $commonModel->find_data('ecoex_user_table', 'count', ['ecoex_company.c_status!=' => 0, 'ecoex_user_table.user_membership_type>' => 0], '', $join);
                                            ?>
                                            <h3><?=$totalMemberCount?></h3>
                                            <p>Total</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php
                            if($totalCategory){ $i=1; foreach($totalCategory as $row){                        
                                $join[0] = ['table' => 'ecoex_company', 'field' => 'c_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'c_id', 'type' => 'INNER'];
                                $memberCount = $commonModel->find_data('ecoex_user_table', 'count', ['ecoex_user_table.user_membership_type' => $row['member_id'], 'ecoex_company.c_status' => 2], '', $join);
                                $memberId = $row['member_id'];
                            ?>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <a target="_blank" href="<?=base_url('admin/memberTypeWiseList/'.$memberId)?>">
                                    <div class="small-box bg-blue">
                                        <div class="icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div class="inner" style="text-align: center;">
                                            <h3><?php echo $memberCount;?></h3>
                                            <p><?php echo $row['short_name'];?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php $i++; } }?>                    
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header bg-success text-light">Business Category Tree View</div>
                                    <div class="card-body">
                                        <ul id="tree1">
                                            <?php
                                            if($parentCategory) { foreach($parentCategory as $row){
                                            $totalCategory51 = $controller->getBusinessCategoryByParentId($row['id']);
                                            ?>
                                            <li><a href="javascript:void(0);"><?php echo $row['name'];?></a>
                                            <?php 
                                            if(count($totalCategory51) > 0){ foreach($totalCategory51 as $row51){
                                            $totalCategory52 = $controller->getBusinessCategoryByParentId($row51['id']);
                                            ?>
                                                <ul>
                                                  <!-- <li>Company Maintenance</li> -->
                                                  <li><?php echo $row51['name'];?>
                                                  <?php 
                                                  if(count($totalCategory52) > 0){ foreach($totalCategory52 as $row52){
                                                  $totalCategory53 = $controller->getBusinessCategoryByParentId($row52['id']);
                                                  ?>
                                                    <ul>
                                                      <li><?php echo $row52['name'];?>
                                                        <ul>
                                                          <?php 
                                                          if(count($totalCategory53) > 0){ foreach($totalCategory53 as $row53){
                                                          $totalCategory54 = $controller->getBusinessCategoryByParentId($row53['id']);
                                                          ?>
                                                          <li><?php echo $row53['name'];?></li>
                                                          <?php } }?>
                                                        </ul>
                                                      </li>                              
                                                    </ul>
                                                  <?php } }?>
                                                  </li>                          
                                                </ul>
                                            <?php } }?>
                                            </li>
                                            <?php } }?>                      
                                        </ul>
                                    </div>
                                </div>
                            </div>
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