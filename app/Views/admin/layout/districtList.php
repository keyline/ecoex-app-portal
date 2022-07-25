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
                        <h3 class="box-title">District List</h3>
                        <p><a class="btn btn-success" href="<?=base_url('admin/addDistrictList/')?>"><i class="nav-icon fas fa-plus"></i> Add District</a></p>
                    </div><!-- /.box-header -->
                    <div class="col-md-12 table-responsive">
                    <table id="example" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                              <th>Sr. No.</th>
                              <th>State Name</th>
                              <th>District Name</th>
                              <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($rows){ $i=1; foreach($rows as $row){ ?>
                            <tr>
                              <td><?=$i?></td>
                              <td>
                                <?php
                                $state = $common_model->find_data('ecoex_state', 'row', ['state_id' => $row->state_id]);
                                if($state){
                                  echo $state->state_title;
                                }
                                ?></td>
                              <td><?=$row->district_title?></td>
                              <td>
                                <a class="text-primary" href="<?=base_url('admin/updateDistrictList/'.$row->districtid)?>"><i class="nav-icon fas fa-edit"></i> Edit</a>
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
          </div><!-- /.container-fluid -->
        </section>
      </div>
      <!-- Main Content -->
    </div>
</div>
<?php echo view('admin/layout/footer'); ?>


<?php if($rows){ $i=1; foreach($rows as $row){ ?>
<div class="modal fade" id="editModal<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="post" action="<?php echo site_url('admin/updateDocumentList/'.$row->id);?>">
        <input type="hidden" name="id" value="<?=$row->id?>">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Document List</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-md-12">                                
                    <div class="form-group">
                        <label for="documentName">Document Name *</label>
                        <input type="text" class="form-control" name="documentName" value="<?=$row->documentName?>" required>
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </div>
    </form>
  </div>
</div>
<?php $i++; } }?>