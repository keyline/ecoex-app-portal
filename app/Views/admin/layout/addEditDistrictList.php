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
            <?php
            if($row){
                $state_id = $row->state_id;
                $district_title = $row->district_title;
            } else {
                $state_id = '';
                $district_title = '';
            }
            ?>
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                  <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">District</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form action="" method="post" >
                            <input type="hidden" name="id" value="<?php echo $id;?>">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">                                
                                        <div class="form-group">
                                            <label for="state_id">State Name *</label>
                                            <select class="form-control" name="state_id" id="state_id" required>
                                                <option value="" selected>Select State</option>
                                                <?php if($states){ foreach($states as $state){?>
                                                <option value="<?=$state->state_id?>" <?=(($state->state_id == $state_id)?'selected':'')?>><?=$state->state_title?></option>
                                                <?php } }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">                                
                                        <div class="form-group">
                                            <label for="district_title">District Name *</label>
                                            <input type="text" class="form-control" name="district_title" id="district_title" value="<?php echo $district_title;?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>    
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