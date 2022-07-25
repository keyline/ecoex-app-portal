<?php echo view('admin/layout/header'); ?>
<div class="wrapper-page">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
        <?php echo view('admin/layout/navbar'); ?>
        <?php echo view('admin/layout/sidebar'); ?>
        <!-- Main Content -->
        <div class="main-content">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
            <style type="text/css">
                .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
                    color: #fff;
                    background-color: #48974e;
                }
            </style>
            <section class="section">
              <div class="container-fluid">
                <?php //echo view($mainPage); ?>
                <script src="//cdn.ckeditor.com/4.13.1/full/ckeditor.js"></script>
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                      <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">Website Setting</h3>
                            </div><!-- /.box-header -->
                            <?php if(isset($_SESSION['success'])){ ?>
                            <p style="color: green;"><?php echo $_SESSION['success'];?></p>
                            <?php unset($_SESSION['success']); } ?>  
                            <ul class="nav nav-pills">
                                <li class="active"><a data-toggle="pill" href="#menu1">General Setting</a></li>
                                <li><a data-toggle="pill" href="#menu2">Profile Setting</a></li>
                                <li><a data-toggle="pill" href="#menu3">Email Setting</a></li>
                                <li><a data-toggle="pill" href="#menu4">Payment Setting</a></li>
                                <li><a data-toggle="pill" href="#menu5">SMS Setting</a></li>
                                <li><a data-toggle="pill" href="#menu6">Bank Account Setting</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="menu1" class="tab-pane fade in active">
                                    <h3>General Setting</h3>                            
                                    <form role="form" action="adminSettingData" method="post" enctype="multipart/form-data">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="websiteName">Site Name: *</label>
                                                        <input type="text" class="form-control" name="websiteName" id="websiteName" value="<?php echo $settingData->websiteName;?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="keywords">Keywords: *</label>
                                                        <input type="text" class="form-control" name="keywords" id="keywords" value="<?php echo $settingData->keywords;?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">                                
                                                    <div class="form-group">
                                                        <label for="description">Description: *</label>
                                                        <textarea class="form-control ckeditor" name="description" id="description" required><?php echo $settingData->description;?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="site_email">Email: *</label>
                                                        <input type="email" class="form-control" name="site_email" id="site_email" value="<?php echo $settingData->site_email;?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="site_address">Address: *</label>
                                                        <textarea class="form-control" name="site_address" id="site_address" required><?php echo $settingData->site_address;?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="site_phone">Phone: *</label>
                                                        <input type="text" class="form-control" name="site_phone" id="site_phone" value="<?php echo $settingData->site_phone;?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="site_whatsapp_no">Whatsapp No:</label>
                                                        <input type="text" class="form-control" name="site_whatsapp_no" id="site_whatsapp_no" value="<?php echo $settingData->site_whatsapp_no;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="site_state">State *</label>
                                                        <input type="text" class="form-control" name="site_state" id="site_state" value="<?php echo $settingData->site_state;?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="site_statecode">State Code *</label>
                                                        <input type="number" class="form-control" name="site_statecode" id="site_statecode" value="<?php echo $settingData->site_statecode;?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="site_gst">GST No</label>
                                                        <input type="text" class="form-control" name="site_gst" id="site_gst" value="<?php echo $settingData->site_gst;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="site_pan">PAN No</label>
                                                        <input type="text" class="form-control" name="site_pan" id="site_pan" value="<?php echo $settingData->site_pan;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="establishment_year">Establishment Year</label>
                                                        <input type="number" class="form-control" name="establishment_year" id="establishment_year" value="<?php echo $settingData->establishment_year;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="facebook_link">Facebook Link</label>
                                                        <input type="text" class="form-control" name="facebook_link" id="facebook_link" value="<?php echo $settingData->facebook_link;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="twitter_link">Twitter Link</label>
                                                        <input type="text" class="form-control" name="twitter_link" id="twitter_link" value="<?php echo $settingData->twitter_link;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="linkedin_link">Linkedin Link</label>
                                                        <input type="text" class="form-control" name="linkedin_link" id="linkedin_link" value="<?php echo $settingData->linkedin_link;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="instagram_link">Instagram Link</label>
                                                        <input type="text" class="form-control" name="instagram_link" id="instagram_link" value="<?php echo $settingData->instagram_link;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="youtube_link">Youtube Link</label>
                                                        <input type="text" class="form-control" name="youtube_link" id="youtube_link" value="<?php echo $settingData->youtube_link;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">                                
                                                    <div class="form-group">
                                                        <?php if($settingData->logo != ''){?>
                                                            <img src="<?=base_url('/writable/uploads/'.$settingData->logo)?>" class="img-thumbnail" height="100px;"><br>
                                                        <?php }?>
                                                        <label for="logo"> Logo: </label>
                                                        <input type="file" class="form-control" name="logo" id="logo" accept="image/jpeg,image/png,image/svg+xml">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <input type="submit" class="btn btn-success" name="submit" value="Update">
                                        </div>
                                    </form>
                                </div>
                                <div id="menu2" class="tab-pane fade">
                                    <h3>Profile Setting</h3>
                                    <form role="form" action="profileSettingData" method="post" enctype="multipart/form-data">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="name">Name: *</label>
                                                        <input type="text" class="form-control" name="name" id="name" value="<?php echo $profileData->name;?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="mobileNo">Mobile No: *</label>
                                                        <input type="text" class="form-control" name="mobileNo" id="mobileNo" value="<?php echo $profileData->mobileNo;?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="username">Username: *</label>
                                                        <input type="text" class="form-control" name="username" id="username" value="<?php echo $profileData->username;?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="password">Password: *</label>
                                                        <input type="password" class="form-control" name="password" id="password">
                                                    </div>
                                                </div>                                        
                                            </div>
                                        </div>                                
                                        <div class="box-footer">
                                            <input type="submit" class="btn btn-success" name="submit" value="Update">
                                        </div>
                                    </form>
                                </div>
                                <div id="menu3" class="tab-pane fade">
                                    <h3>Email Setting</h3>
                                    <form role="form" action="emailSettingData" method="post" enctype="multipart/form-data">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="from_email">From Email: *</label>
                                                        <input type="text" class="form-control" name="from_email" id="from_email" value="<?php echo $settingData->from_email;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="from_name">From Name: *</label>
                                                        <input type="text" class="form-control" name="from_name" id="from_name" value="<?php echo $settingData->from_name;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="smtp_host">SMTP Host: *</label>
                                                        <input type="text" class="form-control" name="smtp_host" id="smtp_host" value="<?php echo $settingData->smtp_host;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="smtp_username">SMTP Username: *</label>
                                                        <input type="text" class="form-control" name="smtp_username" id="smtp_username" value="<?php echo $settingData->smtp_username;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="smtp_password">SMTP Password: *</label>
                                                        <input type="text" class="form-control" name="smtp_password" id="smtp_password" value="<?php echo $settingData->smtp_password;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="smtp_port">SMTP Port: *</label>
                                                        <input type="text" class="form-control" name="smtp_port" id="smtp_port" value="<?php echo $settingData->smtp_port;?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                
                                        <div class="box-footer">
                                            <input type="submit" class="btn btn-success" name="submit" value="Update">
                                        </div>
                                    </form>
                                </div>
                                <div id="menu4" class="tab-pane fade">
                                    <h3>Payment Setting</h3>
                                    <form role="form" action="paymentSettingData" method="post" enctype="multipart/form-data">
                                        <div class="box-body">
                                            <div class="row">                                        
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="payment_gateway_mode">Payment Gateway Mode: *</label>
                                                        <select class="form-control" name="payment_gateway_mode" id="payment_gateway_mode" required>
                                                            <option value="" selected>Select Payment Gateway Mode</option>
                                                            <option value="SANDBOX" <?=(($settingData->payment_gateway_mode == 'SANDBOX')?'selected':'')?>>SANDBOX</option>
                                                            <option value="LIVE" <?=(($settingData->payment_gateway_mode == 'LIVE')?'selected':'')?>>LIVE</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">&nbsp;</div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="sandbox_secret_key">Sandbox Secret Key: *</label>
                                                        <input type="text" class="form-control" name="sandbox_secret_key" id="sandbox_secret_key" value="<?php echo $settingData->sandbox_secret_key;?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="sandbox_publishable_key">Sandbox Publishable Key: *</label>
                                                        <input type="text" class="form-control" name="sandbox_publishable_key" id="sandbox_publishable_key" value="<?php echo $settingData->sandbox_publishable_key;?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="live_secret_key">Live Secret Key: *</label>
                                                        <input type="text" class="form-control" name="live_secret_key" id="live_secret_key" value="<?php echo $settingData->live_secret_key;?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="live_publishable_key">Live Publishable Key: *</label>
                                                        <input type="text" class="form-control" name="live_publishable_key" id="live_publishable_key" value="<?php echo $settingData->live_publishable_key;?>" required>
                                                    </div>
                                                </div>                                        
                                            </div>
                                        </div>                                
                                        <div class="box-footer">
                                            <input type="submit" class="btn btn-success" name="submit" value="Update">
                                        </div>
                                    </form>
                                </div>
                                <div id="menu5" class="tab-pane fade">
                                    <h3>SMS Setting</h3>
                                    <form role="form" action="smsSettingData" method="post" enctype="multipart/form-data">
                                        <div class="box-body">
                                            <div class="row">                                        
                                                <div class="col-md-4">                                
                                                    <div class="form-group">
                                                        <label for="authentication_key">Authentication Key: *</label>
                                                        <input type="text" class="form-control" name="authentication_key" id="authentication_key" value="<?php echo $settingData->authentication_key;?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">                                
                                                    <div class="form-group">
                                                        <label for="sender_id">Sender ID: *</label>
                                                        <input type="text" class="form-control" name="sender_id" id="sender_id" value="<?php echo $settingData->sender_id;?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">                                
                                                    <div class="form-group">
                                                        <label for="base_url">Base URL: *</label>
                                                        <input type="text" class="form-control" name="base_url" id="base_url" value="<?php echo $settingData->base_url;?>" required>
                                                    </div>
                                                </div>                                       
                                            </div>
                                        </div>                                
                                        <div class="box-footer">
                                            <input type="submit" class="btn btn-success" name="submit" value="Update">
                                        </div>
                                    </form>
                                </div>
                                <div id="menu6" class="tab-pane fade">
                                    <h3>Bank Account Setting</h3>
                                    <form role="form" action="bankSettingData" method="post" enctype="multipart/form-data">
                                        <div class="box-body">
                                            <div class="row">                                        
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="bank_name">Bank Name: *</label>
                                                        <input type="text" class="form-control" name="bank_name" id="bank_name" value="<?php echo $settingData->bank_name;?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="bank_branch">Bank Branch: *</label>
                                                        <input type="text" class="form-control" name="bank_branch" id="bank_branch" value="<?php echo $settingData->bank_branch;?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="account_no">Account Number: *</label>
                                                        <input type="text" class="form-control" name="account_no" id="account_no" value="<?php echo $settingData->account_no;?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                
                                                    <div class="form-group">
                                                        <label for="ifsc_code">IFSC Code: *</label>
                                                        <input type="text" class="form-control" name="ifsc_code" id="ifsc_code" value="<?php echo $settingData->ifsc_code;?>" required>
                                                    </div>
                                                </div>                                       
                                            </div>
                                        </div>                                
                                        <div class="box-footer">
                                            <input type="submit" class="btn btn-success" name="submit" value="Update">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>            
                </div>   
              </div><!-- /.container-fluid -->
            </section>
        </div>
        <!-- Main content -->
    </div>
</div>
<?php echo view('admin/layout/footer'); ?>
