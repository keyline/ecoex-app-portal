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
                        $member_type = $row->member_type;
                    } else {
                        $member_type = '';
                    }
                    ?>
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                          <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Member Type</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form action="" method="post" >
                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-5">                                
                                                <div class="form-group">
                                                    <label for="member_type">Member Type *</label>
                                                    <input type="text" class="form-control" name="member_type" id="member_type" value="<?php echo $member_type;?>" required>
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