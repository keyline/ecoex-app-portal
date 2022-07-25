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
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Member Bank Profile</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="<?=base_url('admin/memberBankProfileStore')?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="mode" value="member">
                        <input type="hidden" name="storeId" value="<?=$storeData->c_id?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Account Type <span class="red">*</span></label>
                                        <div class="form-group pt-2">
                                            <div class="form-check form-check-inline clear">
                                                <input class="form-check-input" type="radio" name="accountType" id="inlineRadio1" value="current"
                                                <?php if($companyDetail->c_account_type == "current"){ echo 'checked'; } ?> required>
                                                <label class="form-check-label" for="inlineRadio1">Current</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="accountType" id="inlineRadio2" value="saving"
                                                <?php if($companyDetail->c_account_type == "saving"){ echo 'checked'; } ?> required>
                                                <label class="form-check-label" for="inlineRadio2">Savings</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Bank Name <span class="red">*</span> </label>
                                        <input class="form-control" type="text" placeholder="Entry Bank Name" name="bankName" value="<?php echo $companyDetail->c_bank_name;?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Account Number <span class="red">*</span> </label>
                                        <input class="form-control" type="text" placeholder="Entry Account Number" name="accountNo" 
                                        value="<?php echo $companyDetail->accountNo;?>" required>
                                    </div>
                                </div>
                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Branch Name <span class="red">*</span> </label>
                                        <input class="form-control" type="text" placeholder="Entry Branch Name" name="branchName" value="<?php echo $companyDetail->c_branch_name;?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Account Holder Name <span class="red">*</span> </label>
                                        <input class="form-control" type="text" placeholder="Entry Account Holder Name" name="accountHolder"
                                        value="<?php echo $companyDetail->c_acct_holder_name;?>" required>
                                    </div>
                                </div>
                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Cancelled Cheque <span class="red">*</span> </label>
                                        <input class="form-control" type="file" id="custom-input-file-4" placeholder="Entry GST Number" name="cancllledCheque">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">MICR Code <span class="red">*</span> </label>
                                        <input class="form-control" type="text" placeholder="Entry MICR Code" name="mtcrCode" value="<?php echo $companyDetail->c_micr_code;?>" required>
                                    </div>
                                </div>                                
                            </div>
                        </div><!-- /.box-body -->
    
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