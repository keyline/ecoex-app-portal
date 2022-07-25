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
                      <h3 class="box-title">Member Type Wise Report</h3>
                  </div>
                  <form action="" method="get" target="_blank">
                    <div class="row mt-3">
                      <div class="col-md-3">
                        <label for="member_type_id">Member Type</label>
                        <select class="form-control" name="member_type_id" id="member_type_id" required>
                            <option value="" selected>Select Member Type</option>
                          <?php if($member_category){ foreach($member_category as $member_cat){?>
                            <option value="<?=$member_cat->member_id?>"><?=$member_cat->member_type?></option>
                          <?php } }?>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label for="state">State</label>
                        <select class="form-control" name="state" id="state" required>
                            <option value="" selected>Select State</option>
                          <?php if($states){ foreach($states as $state){?>
                            <option value="<?=$state->state_id?>"><?=$state->state_title?></option>
                          <?php } }?>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label for="item_id">Item</label>
                        <select class="form-control" name="item_id" id="item_id" required>
                            <option value="" selected>Select Item</option>
                          <?php if($items){ foreach($items as $item){?>
                            <option value="<?=$item->id?>"><?=$item->name?></option>
                          <?php } }?>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group mt-3">
                          <button type="submit" class="btn btn-outline-success" style="margin-top: 8px;">Generate</button>
                        </div>
                      </div>
                    </div>                  
                  </form>
                  <div class="box-footer clearfix"></div>
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