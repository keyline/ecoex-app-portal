<?php echo view('admin/layout/header'); ?>
<div class="wrapper-page">
    <div class="main-wrapper">
        <div class="navbar-bg"></div>
        <?php echo view('admin/layout/navbar'); ?>
        <?php echo view('admin/layout/sidebar'); ?>
        <script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="container-fluid">        
                    <div class="row">            
                        <div class="col-md-12">
                          <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Static Content List</h3>
                                <p><a class="btn btn-success" href="<?=base_url('admin/addStaticContent/')?>"><i class="nav-icon fas fa-plus"></i> Add Static Content</a></p> 
                            </div><!-- /.box-header -->
                            <div class="col-md-12 table-responsive">
                            <table id="example" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                      <th>Sr. No.</th>
                                      <th>Title</th>
                                      <th>Content</th>
                                      <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($rows){ $i=1; foreach($rows as $row){ ?>
                                    <tr>
                                      <td><?=$i; ?></td>
                                      <td><?php echo $row->title;?></td>
                                      <td><?php if($row->content_file!=''){?><a class="label label-info" href="<?=base_url('writable/uploads/'.$row->content_file)?>" target="_blank">View</a><?php }?></td>
                                      <td>
                                        <a class="text-primary" href="<?=base_url('admin/updateStaticContent/'.$row->id)?>"><i class="nav-icon fas fa-edit"></i> Edit</a>
                                        <a style="color: red;" href="<?php echo site_url('admin/deleteStaticContent/'.$row->id);?>" onclick="return confirm('Are you sure?')">
                                          <i class="nav-icon fas fa-trash"></i> Delete</a>
                                      </td>
                                    </tr>
                                    <?php $i++; } }?>
                                </tbody>
                            </table>
                              
                            </div><!-- /.box-body -->
                            <div class="box-footer clearfix">
                                                </div>
                          </div><!-- /.box -->
                        </div>
                    </div>   
                </div>
            </section>
        </div>
        <!-- Main Content -->
    </div>
</div>
<?php echo view('admin/layout/footer'); ?>

<?php if($rows){ $i=1; foreach($rows as $row){ ?>
<div class="modal fade" id="editModal<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="post" action="<?php echo site_url('admin/updateStaticContent/'.$row->id);?>" enctype="multipart/form-data">
        <div class="modal-dialog" role="document" style="width: 80%;">    
            <input type="hidden" name="id" value="<?=$row->id?>">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Static Content</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">                                
                        <div class="form-group">
                            <label for="title">Title *</label>
                            <input type="text" class="form-control" name="title" id="title" value="<?=$row->title?>" required>
                        </div>
                    </div>
                    <div class="col-md-12">                                
                        <div class="form-group">
                            <label for="description">Description *</label>
                            <textarea class="form-control ckeditor" name="description" id="description" required><?=$row->description?></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">                                
                        <div class="form-group">
                            <?php if($row->content_file!=''){?><a href="<?=base_url('writable/uploads/'.$row->content_file)?>" target="_blank">View</a><br><?php }?>
                            <label for="description">Content File *</label>
                            <input type="file" class="form-control" name="content_file" accept="application/pdf">
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </div>
        </div>
    </form>
</div>
<?php $i++; } }?>
