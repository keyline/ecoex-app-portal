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
                    <script src="//cdn.ckeditor.com/4.13.1/full/ckeditor.js"></script>
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                          <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Edit Email Template</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <?php if(isset($_SESSION['success'])){ ?>
                                <p style="color: #fff;width: 50%;background-color: green;padding: 10px;margin-top:5px;"><?php echo $_SESSION['success'];?></p>
                                <?php unset($_SESSION['success']); } ?>
                                <form role="form" id="addUser" action="/admin/adminEmailData" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-4">                                
                                                <div class="form-group">
                                                    <label for="fname"> Email Template Name:  *</label>
                                                    <input type="text" class="form-control" name="templateName" value="<?php echo $emailData->email_name;?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">                                
                                                <div class="form-group">
                                                    <label for="fname"> Receiver:  *</label>
                                                    <input type="text" class="form-control" name="receiver" value="<?php echo $emailData->receiver;?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-8">                                
                                                <div class="form-group">
                                                    <label for="fname"> Subject:  *</label>
                                                    <input type="text" class="form-control" name="subject" value="<?php echo $emailData->subject;?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">                                
                                                <div class="form-group">
                                                    <label for="fname"> Content:  *</label>
                                                    <textarea class="form-control ckeditor" name="content" required><?php echo $emailData->content;?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div style="position:relative;width:100%;height:100%;">
                                                    <div class="scroll-area">
                                                        <br>
                                                        <h3>Email Keyword Guide</h3>
                                                        <br>
                                                        <strong>{name}</strong> - Name of the Customer<br>
                                                        <strong>{customer_email}</strong> - Customer Email<br>
                                                        <strong>{password}</strong> - Customer Password<br>
                                                        <strong>{forgot_link}</strong> - Forget Password Link<br>
                                                        <strong>{company}</strong> - Company Name<br>
                                                             
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.box-body -->
                
                                    <div class="box-footer">
                                        <input type="hidden" name="emailID" value="<?php echo $emailData->id;?>">
                                        <input type="submit" class="btn btn-primary" name="submit" value="Update">
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

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: '#mytextarea',
    plugins: [
      'a11ychecker','advlist','advcode','advtable','autolink','checklist','export',
      'lists','link','image','charmap','preview','anchor','searchreplace','visualblocks',
      'powerpaste','fullscreen','formatpainter','insertdatetime','media','table','help','wordcount'
    ],
    toolbar: 'undo redo | formatpainter casechange blocks | bold italic backcolor | ' +
      'alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help'
  });
</script>
