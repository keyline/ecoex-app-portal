<?php echo view('admin/layout/header'); ?>
<div class="wrapper-page">
    <div class="main-wrapper">
        <div class="navbar-bg"></div>
        <?php echo view('admin/layout/navbar'); ?>
        <?php echo view('admin/layout/sidebar'); ?>
        <div class="main-content">
            <?php echo view('admin/layout/breadcrumb'); ?>
            <!-- Main content -->
            <section class="section">
                <div class="container-fluid">
                    <?php
                    if($row){
                        $documentName = $row->documentName;
                        $documentType = $row->documentType;
                    } else {
                        $documentName = '';
                        $documentType = '';
                    }
                    ?>
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                          <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Document</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form action="" method="post" >
                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-6">                                
                                                <div class="form-group">
                                                    <label for="documentName">Document Name *</label>
                                                    <input type="text" class="form-control" name="documentName" id="documentName" value="<?php echo $documentName;?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">                                
                                                <div class="form-group">
                                                    <label for="documentType">Document Type *</label>
                                                    <select class="form-control" name="documentType" id="documentType" required>
                                                        <option value="AUTOMATIC" <?=(($documentType == 'AUTOMATIC')?'selected':'')?>>AUTOMATIC</option>
                                                        <option value="MANUAL" <?=(($documentType == 'MANUAL')?'selected':'')?>>MANUAL</option>
                                                    </select>
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