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
                                    <h3 class="box-title">Manage Listing Page For <?=$memberTypeRow->member_type?></h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form action="" method="post" >
                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                    <div class="box-body">
                                        <div class="row">
                                            <?php 
                                            $i=1; if($memberTypes) { foreach($memberTypes as $row){
                                                if($row->member_id != $memberTypeRow->member_id){
                                            ?>
                                                <input type="hidden" name="reference_member_id[]" value="<?=$row->member_id?>">
                                                <div class="col-md-6">
                                                    <div class="card">
                                                        <div class="card-header bg-success"><?=$row->member_type?></div>
                                                        <div class="card-body">
                                                            <ul class="list-group">
                                                                <?php
                                                                $maincats = $common_model->find_data('ecoex_business_category', 'array', ['parent' => 0]);
                                                                if($maincats) { foreach($maincats as $maincat){
                                                                ?>
                                                                <li class="list-group-item">
                                                                    <input type="checkbox" name="maincat<?=$row->member_id?>[]" value="<?=$maincat->id?>" id="maincat<?=$row->member_id?>_<?=$maincat->id?>" onClick="check_uncheck_checkbox(this.checked,<?=$row->member_id?>,<?=$maincat->id?>);">
                                                                    <label for="maincat<?=$row->member_id?>_<?=$maincat->id?>"><?=$maincat->name?></label>

                                                                    <ul class="list-group">
                                                                        <?php
                                                                        $subcats = $common_model->find_data('ecoex_business_category', 'array', ['parent' => $maincat->id]);
                                                                        if($subcats) { foreach($subcats as $subcat){
                                                                            $conditions = [
                                                                                'member_id'                 => $id,
                                                                                'reference_member_id'       => $row->member_id,
                                                                                'maincat'                   => $maincat->id,
                                                                                'subcat'                    => $subcat->id
                                                                            ];
                                                                            $checkExist = $common_model->find_data('ecoex_listing_access', 'count', $conditions);
                                                                        ?>
                                                                        <li class="list-group-item">
                                                                            <input type="checkbox" class="subcat_<?=$row->member_id?>_<?=$maincat->id?>" name="subcat<?=$row->member_id?>[]" value="<?=$subcat->id?>/<?=$maincat->id?>" id="subcat<?=$row->member_type?>_<?=$subcat->id?>" <?=(($checkExist)?'checked':'')?>>
                                                                            <label for="subcat<?=$row->member_type?>_<?=$subcat->id?>"><?=$subcat->name?></label>
                                                                        </li>
                                                                        <?php } }?>
                                                                    </ul>
                                                                </li>
                                                                <?php } }?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php }?>
                                            <?php $i++; } }?>
                                        </div>
                                    </div>                            
                                    <div class="box-footer">
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

<script type="text/javascript">
    function check_uncheck_checkbox(isChecked,param1,param2) {
        if(isChecked) {
            // $('input[name="language"]').each(function() { 
            //     this.checked = true; 
            // });
            $('.subcat_'+param1+'_'+param2).each(function() { 
                this.checked = true; 
            });
        } else {
            // $('input[name="language"]').each(function() {
            //     this.checked = false;
            // });
            $('.subcat_'+param1+'_'+param2).each(function() { 
                this.checked = false;
            });
        }
    }
</script>