<?php
$site_setting =$common_model->find_data('ecoex_setting', 'row');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $site_setting->websiteName; ?>-Transaction-Report</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        .right, table td:not(:first-child):not(:nth-child(2)) {text-align: left}
        .center, table thead th, table td:first-child, table td:nth-child(2) {text-align: center}
        table {width: 1042px; border-collapse: collapse; font-family: monospace;}
        table td {padding: 5px; border: 1px solid #555}
        table thead th, table tfoot th {border: 1px solid #555; background: #eee}
        table.out {font-family: "Lucida Sans"}
        table.out > tbody > tr > td {border: none!important;}
        h3, h5 {margin: 10px}

        @media print {
            table {width: 100%; margin-top: 20px;}
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
            <table>
                <thead>
                    <tr>
                        <td colspan="11">
                            <h3 class="center">Transaction Report</h3>
                            <h5 class="center"><strong>From</strong> : <u><?php echo date_format(date_create($fdate), "d.m.Y");?></u> <strong>To</strong> : <u><?php echo date_format(date_create($tdate), "d.m.Y");?></u></h5>
                        </td>
                    </tr>
                    <tr>
                        <th width="4%">Sl. No.</th>
                        <th width="5%">Inquiry No.</th>
                        <th width="20%">Seller Details</th>
                        <th width="20%">Buyer Details</th>
                        <th width="10%">Type</th>
                        <th width="20%">Item Details</th>
                        <th width="2%">Month/Year</th>
                        <th width="4%">Location</th>
                        <th width="4%">Quantity</th>
                        <th width="4%">Status</th>
                        <th width="8%">Date Of Enquiry Posting</th>
                    </tr>
                </thead>
                <tbody>
                <?php if($response) { $i=1; foreach($response as $row) { ?>
                  <tr>
                    <td valign="top"><?php echo $i++; ?></td>
                    <td valign="top"><?php echo $row['inquiry_no']; ?></td>
                    <td valign="top">
                      <?php echo $row['buyer_type']; ?><br>
                      <?php echo $row['buyer_company']; ?><br>
                      <?php echo $row['buyer_name']; ?><br>
                      <?php echo $row['buyer_email']; ?><br>
                      <?php echo $row['buyer_phone']; ?>
                    </td>
                    <td valign="top">
                      <?php echo $row['seller_type']; ?><br>
                      <?php echo $row['seller_company']; ?><br>
                      <?php echo $row['seller_name']; ?><br>
                      <?php echo $row['seller_email']; ?><br>
                      <?php echo $row['seller_phone']; ?>
                    </td>
                    <td valign="top"><?php echo $row['inquiry_type']; ?></td>
                    <td valign="top">
                      <?php echo $row['category']; ?><br>
                      <?php echo $row['subcategory']; ?><br>
                      <?php echo $row['product']; ?><br>
                      <?php echo $row['item']; ?>
                    </td>
                    <td valign="top"><?php echo $row['month']; ?>/<?php echo $row['year']; ?></td>
                    <td valign="top"><?php echo $row['state']; ?></td>
                    <td valign="top"><?php echo $row['required_qty']; ?> <?php echo $row['unit']; ?></td>
                    <td valign="top"><?php 
                      if($row['post_status'] == 0){
                        echo "Submit Inquiry";
                      } elseif($row['post_status'] == 1){
                        echo "Documents Upload";
                      } elseif($row['post_status'] == 2){
                        echo "Admin Approved";
                      } elseif($row['post_status'] == 3){
                        echo "Buyer Accept";
                      } elseif($row['post_status'] == 4){
                        echo "PO Upload";
                      } elseif($row['post_status'] == 5){
                        echo "Shared PO";
                      } elseif($row['post_status'] == 6){
                        echo "Admin Upload Invoices";
                      }
                    ?></td>
                    <td valign="top">
                      <?php echo date_format(date_create($row['inquiry_date']), "M d, Y"); ?><br>
                      <?php echo date_format(date_create($row['inquiry_date']), "h:i A"); ?>
                    </td>
                  </tr>
                <?php } } else {?>
                <tr>
                  <td colspan="11">No data found</td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </td>
    </tr>
</table>
</body>
</html>