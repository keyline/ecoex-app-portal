<?php echo view('admin/layout/header'); ?>
<div class="wrapper-page">
    <div class="main-wrapper">
        <div class="navbar-bg"></div>
        <?php echo view('admin/layout/navbar'); ?>
        <?php echo view('admin/layout/sidebar'); ?>
        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>                
                <div class="container-fluid">
                    <?php
                    if($row){
                        $title          = $row->title;
                        $description    = $row->description;
                        $content_file   = $row->content_file;
                    } else {
                        $title          = '';
                        $description    = '';
                        $content_file   = '';
                    }
                    ?>
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                          <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">State Content</h3>
                                </div>
                                <form role="form" id="addUser" action="addStaticContent" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">                                
                                                <div class="form-group">
                                                    <label for="title">Title *</label>
                                                    <input type="text" class="form-control" name="title" id="title" value="<?php echo $title;?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">                                
                                                <div class="form-group">
                                                    <label for="description">Description *</label>
                                                    <textarea class="form-control ckeditor" name="description" id="description" required><?php echo $description;?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">                                
                                                <div class="form-group">
                                                    <?php if($content_file!=''){?>
                                                        <a class="text-primary" href="<?=base_url('writable/uploads/'.$content_file)?>" target="_blank">View</a><br>
                                                    <?php }?>
                                                    <label for="description">Content File *</label>
                                                    <input type="file" class="form-control" name="content_file" accept="application/pdf" required>
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
