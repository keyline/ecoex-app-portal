<?php
$site_setting =$common_model->find_data('ecoex_setting', 'row');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $site_setting->websiteName; ?> - Membertype-Wise-Report</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        .right, table td:not(:first-child):not(:nth-child(2)) {text-align: left}
        .center, table thead th, table td:first-child, table td:nth-child(2) {text-align: center}
        table {width: 1042px; border-collapse: collapse; font-family: monospace}
        table td {padding: 5px; border: 1px solid #555}
        table thead th, table tfoot th {border: 1px solid #555; background: #eee}
        table.out {font-family: "Lucida Sans"}
        table.out > tbody > tr > td {border: none!important;}
        h3, h5 {margin: 10px}

        @media print {
            table {width: 100%}
      #printPageButton {
        display: none !important;
      }
      #excel-download {
        display: none !important;
      }
        }
    </style>
</head>
<body>
<button id="printPageButton" onClick="window.print();" style="display: block; background: #eee; border: 1px solid #ccc; padding: 7px 13px; text-transform: uppercase; margin: auto;">Print</button>
<!-- <br><br>
<a target="_blank" id="excel-download" href="<?php echo base_url();?>manage_report/sell_excel_report/<?php echo $fdate; ?>/<?php echo $tdate; ?>" style="background: #eee;border: 1px solid #ccc; padding: 7px 15px;text-transform: uppercase;font-size: 11px;margin: 597px;text-decoration:none;">Download Excel</a> -->
<table class="out" align="center">
    <tr>
        <td>
            <h3 class="center">Member Type Wise Report</h3>
            <!-- <h5 class="center"><strong>From</strong> : <u><?php echo date_format(date_create($fdate), "d.m.Y");?></u> <strong>To</strong> : <u><?php echo  date_format(date_create($tdate), "d.m.Y");?></u></h5> -->
        </td>
    </tr>
    <tr>
        <td>
            <table>
                <thead>
                    <tr>
                        <th width="4%">Sl. No.</th>
                        <th width="5%">User Details</th>
                        <th width="5%">Item Details</th>
                        <th width="10%">Type</th>
                        <th width="20%">Month</th>
                        <th width="9%">Year</th>
                        <th width="9%">Status</th>
                        <th width="9%">Annual Capacity</th>
                    </tr>
                </thead>
                <tbody>
                <?php if($response) { $i=1; foreach($response as $row) { ?>
                  <tr>
                    <td valign="top"><?php echo $i++; ?></td>
                    <td valign="top">
                      <?php echo $row['c_name']; ?><br>
                      <?php echo $row['user_name']; ?><br>
                      <?php echo $row['user_email']; ?><br>
                      <?php echo $row['user_mobile']; ?>
                    </td>
                    <td valign="top">
                      <?php echo $row['category']; ?><br>
                      <?php echo $row['subcategory']; ?><br>
                      <?php echo $row['product']; ?><br>
                      <?php echo $row['item']; ?>
                    </td>
                    <td valign="top"><?php echo $row['type']; ?></td>
                    <td valign="top"><?php echo $row['month']; ?></td>
                    <td valign="top"><?php echo $row['year']; ?></td>
                    <td valign="top"><?php 
                      if($row['post_status'] == 0){
                        echo "DISAPPROVED";
                      } elseif($row['post_status'] == 1){
                        echo "APPROVED";
                      } elseif($row['post_status'] == 3){
                        echo "EXPIRED";
                      }
                    ?></td>
                    <td valign="top">
                      <ul>
                        <?php if($row['unitMaterials']){foreach($row['unitMaterials'] as $unitMaterial){?>
                          <li><?=$unitMaterial->name?> <i class="fa fa-arrow-right"></i> <?=$unitMaterial->annualCapicity?></li>
                        <?php } }?>
                      </ul>
                    </td>
                  </tr>
                <?php } } else {?>
                <tr>
                  <td colspan="8">No data found</td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </td>
    </tr>
</table>
</body>
</html>