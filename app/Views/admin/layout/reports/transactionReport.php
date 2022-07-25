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
                        <h3 class="box-title">Transaction Report</h3>
                    </div>
                    <form action="" method="get" target="_blank">
                      <div class="row mt-3">
                        <div class="col-md-5">
                          <label for="fdate">From Date</label>
                          <input type="date" class="form-control" name="fdate" id="fdate" required />
                        </div>
                        <div class="col-md-5">
                          <label for="tdate">To Date</label>
                          <input type="date" class="form-control" name="tdate" id="tdate" required />
                        </div>
                        <div class="col-md-2" style="margin-top: 24px;">
                          <button type="submit" class="btn btn-outline-success">Generate</button>
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