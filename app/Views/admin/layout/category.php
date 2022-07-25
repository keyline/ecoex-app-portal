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
                <div class="col-md-12">
                  <div class="box">
                    <div class="box-header">
                        <h3 class="box-title" style="float:left">Business Category</h3>
                        <a style="float: right;padding: 10px;background-color: #007bff;color: #fff;margin-right: 8px;" href="addBusinessCategory">
                            <i class="nav-icon fas fa-plus"></i> Add Business Category</a>
                    </div>
                    <div class="col-md-12 table-responsive">                  
                        
                      <div class="col-md-12">
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

                      <table id="example" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>Sr. No.</th>
                            <th>Name</th>
                            <th>Parent</th>
                            <th>Created Date</th>
                            <th>Updated Date</th>
                            <th class="text-center">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          $i=1;
                          foreach($totalCategory as $row){
                              $totalCategory555 = $controller->getCategoryParent($row['parent']);
                              $totalChild = $controller->getTotalChild($row['id']);
                              ?>
                            <tr>
                              <td><?= $i; ?></td>
                              <td><?php echo $row['name'];?></td>
                              <td><?php echo $totalCategory555->name;?></td>
                              <td><?php echo date('d-m-Y h:i:s',strtotime($row['created_at']));?></td>
                              <td><?php echo date('d-m-Y h:i:s',strtotime($row['updated_at']));?></td>
                              <td>
                                  <a class="text-primary" href="<?php echo site_url('admin/editBusinessCategory/'.$row['id']);?>">
                                  <i class="nav-icon fas fa-edit"></i> Edit</a><br>
                                  <?php if($totalChild->totalChild<=0){ ?>
                                  <a class="text-danger" href="<?php echo site_url('admin/deleteBusinessCategory/'.$row['id']);?>" onclick="return confirm('Are you sure?')">
                                  <i class="nav-icon fas fa-trash"></i> Delete</a>
                                  <?php } ?>
                                  </td>
                            </tr>
                          <?php $i++; } ?>                    
                        </tbody>
                      </table>                  
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