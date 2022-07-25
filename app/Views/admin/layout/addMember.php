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
                        <h3 class="box-title">Add Member</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="mode" value="member">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="c_name">Company Name *</label>
                                        <input type="text" class="form-control required" id="c_name" name="c_name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="user_email">Email Address *</label>
                                        <input type="email" class="form-control required" id="user_email" name="user_email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="user_mobile">Mobile *</label>
                                        <input type="text" class="form-control required" id="user_mobile" name="user_mobile" min="10" maxlength="10" required>
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="user_password">Create Paswword *</label>
                                        <input type="password" class="form-control required" id="user_password" name="user_password" min="8" maxlength="8" required>
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="user_password_confirm">Confirm Paswword *</label>
                                        <input type="password" class="form-control required" id="user_password_confirm" name="user_password_confirm" min="8" maxlength="8" required>
                                    </div>
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="member_id">Select Member Type *</label>
                                        <select class="form-control required" id="member_id" name="user_membership_type" required>
                                            <option value="" selected>Select Member Type</option>
                                            <?php if($memberTypes){ foreach($memberTypes as $memberType){?>
                                            <option value="<?=$memberType->member_id?>"><?=$memberType->member_type?></option>
                                            <?php } }?>
                                        </select>    
                                    </div>
                                    <div class="form-group" id="sub_member_type" style="display: none;">
                                        <label for="">Sub Member Type <span class="red">*</span></label>
                                        <div class="form-group form-check">
                                            <input type="checkbox" name="user_sub_member_type[]" class="form-check-input greencheck myCB" id="user_sub_member_type1" value="Producer">
                                            <label class="form-check-label" for="user_sub_member_type1">Producer</label>
                                        </div>
                                        <div class="form-group form-check">
                                            <input type="checkbox" name="user_sub_member_type[]" class="form-check-input greencheck myCB" id="user_sub_member_type2" value="Importer">
                                            <label class="form-check-label" for="user_sub_member_type2">Importer</label>
                                        </div>
                                        <div class="form-group form-check">
                                            <input type="checkbox" name="user_sub_member_type[]" class="form-check-input greencheck myCB" id="user_sub_member_type3" value="Brand Owner">
                                            <label class="form-check-label" for="user_sub_member_type3">Brand Owner</label>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" name="submit" value="Add Member">
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

<script type="text/javascript">
    $(document).ready(function(){
        $('#c_name').on('blur', function(){
            var c_name  = $('#c_name').val();
            if(c_name == ''){
                erorFunction("Please Enter Company Name !!!");
            } else {
                var baseUrl = '<?=base_url()?>'; 
                $.post({
                    url:baseUrl+'/admin/checkCompanyName',
                    dataType: 'JSON',
                    data: { c_name:c_name }
                })
                .done(function(rply) {
                    if(rply.status) {
                        successFunction(rply.message);
                    } else {
                        erorFunction(rply.message);
                        $('#c_name').val('');
                    }
                })
                .fail(function(rply, txtsts) {
                    //
                });
            }            
        });
        $('#user_email').on('blur', function(){
            var user_email  = $('#user_email').val();
            if(user_email == ''){
                erorFunction("Please Enter Email !!!");
            } else {
                var baseUrl = '<?=base_url()?>'; 
                $.post({
                    url:baseUrl+'/admin/checkMemberEmail',
                    dataType: 'JSON',
                    data: { user_email:user_email }
                })
                .done(function(rply) {
                    if(rply.status) {
                        successFunction(rply.message);
                    } else {
                        erorFunction(rply.message);
                        $('#user_email').val('');
                    }
                })
                .fail(function(rply, txtsts) {
                    //
                });
            }            
        });
        $('#user_mobile').on('blur', function(){
            var user_mobile  = $('#user_mobile').val();
            if(user_mobile == ''){
                erorFunction("Please Enter Mobile !!!");
            } else {
                var baseUrl = '<?=base_url()?>'; 
                $.post({
                    url:baseUrl+'/admin/checkMemberPhone',
                    dataType: 'JSON',
                    data: { user_mobile:user_mobile }
                })
                .done(function(rply) {
                    if(rply.status) {
                        successFunction(rply.message);
                    } else {
                        erorFunction(rply.message);
                        $('#user_mobile').val('');
                    }
                })
                .fail(function(rply, txtsts) {
                    //
                });
            }            
        });
        $('#user_password_confirm').on('blur', function(){
            var user_password = $('#user_password').val();
            var user_password_confirm = $('#user_password_confirm').val();
            if(user_password != user_password_confirm){
                erorFunction('Password & Confirm Password Not Matched !!!');
                $('#user_password').val('');
                $('#user_password_confirm').val('');
            } else {
                successFunction('Password & Confirm Password Matched !!!');
            }
        })
        $('#member_id').on('change', function(){
            var member_id = $('#member_id').val();
            if(member_id == 1){
                $('#sub_member_type').show();
                $("input[name=user_sub_member_type[]]").attr("required", true);
            } else {
                $('#sub_member_type').hide();
                $("input[name=user_sub_member_type[]]").attr("required", false);
            }
        });
    });
</script>
