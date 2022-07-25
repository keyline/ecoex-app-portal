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
            $attr_name      = $row->attr_name;
            $share_nature   = $row->share_nature;
        } else {
            $attr_name      = '';
            $share_nature   = '';
        }
        ?>
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Upload Attribute</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form action="" method="post" >
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="attr_name">Upload Attribute Name *</label>
                                        <input type="text" class="form-control" name="attr_name" id="attr_name" value="<?php echo $attr_name;?>" required style="text-transform: uppercase;">
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="share_nature">Share Nature *</label>
                                        <select class="form-control" name="share_nature" id="share_nature" required>
                                            <option value="" selected>Select Share Nature</option>
                                            <option value="AUTOMATIC" <?=(($share_nature == 'AUTOMATIC')?'selected':'')?>>AUTOMATIC</option>
                                            <option value="MANUAL" <?=(($share_nature == 'MANUAL')?'selected':'')?>>MANUAL</option>
                                        </select>
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