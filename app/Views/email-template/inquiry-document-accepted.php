<?php	
 	$join[0]            = ['table' => 'ecoex_member_category', 'field' => 'member_id', 'table_master' => 'ecoex_user_table', 'field_table_master' => 'user_membership_type', 'type' => 'INNER'];
    $conditions         = ['ecoex_user_table.user_id' => $inventory->buyer_id];
    $buyer             = $common_model->find_data('ecoex_user_table', 'row', $conditions, 'ecoex_user_table.*,ecoex_member_category.member_type', $join);

    if($inventory->seller_type == 'Brand'){
  		$parentTable          = 'ecoex_target';
      	$parentField          = 'target_id';
      	$childTable           = 'ecoex_target_by_state';
      	$childField           = 'target_id';
    } else {
      	$parentTable          = 'ecoex_inventory';
      	$parentField          = 'inventory_id';
      	$childTable           = 'ecoex_inventory_by_state';
      	$childField           = 'inventory_id';
    }
    $join[0]                = ['table' => $childTable, 'field' => $childField, 'table_master' => $parentTable, 'field_table_master' => $parentField, 'type' => 'INNER'];
    $conditions             = [$childTable.'.id' => $inventory->inventory_details_id];
    $itemDetails            = $common_model->find_data($parentTable, 'row', $conditions, '', $join);


    $state          = $common_model->find_data('ecoex_state', 'row', ['state_id' => $itemDetails->state_id], 'state_title');
    $unit           = $common_model->find_data('ecoex_unit', 'row', ['id' => $itemDetails->unit], 'name');
    $category       = $common_model->find_data('ecoex_business_category', 'row', ['id' => $itemDetails->categoryId], 'name');
    $subcategory    = $common_model->find_data('ecoex_business_category', 'row', ['id' => $itemDetails->sucCatId], 'name');
    $product        = $common_model->find_data('ecoex_business_category', 'row', ['id' => $itemDetails->productId], 'name');
    $item           = $common_model->find_data('ecoex_business_category', 'row', ['id' => $itemDetails->itemId], 'name');
?>
<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Title</title>
</head>
<body style="margin: 0 !important; padding: 0 !important;">
	<style type="text/css">
		* {
		   -webkit-box-sizing: border-box;
		   -moz-box-sizing: border-box;
		   box-sizing: border-box;
		}
		body, table, td, a {
		   -webkit-text-size-adjust: 100%;
		   -ms-text-size-adjust: 100%;
		}
		body {
		   height: 100% !important;
		   margin: 0 !important;
		   padding: 0 !important;
		   width: 100% !important;
		}
		table, td {
		   mso-table-lspace: 0pt;
		   mso-table-rspace: 0pt;
		} 
		img {
		   border: 0;
		   line-height: 100%;
		   text-decoration: none;
		   -ms-interpolation-mode: bicubic;
		}
		table {
		   border-collapse: collapse !important;
		}
		/* iOS Blue Links */
		a[x-apple-data-detectors] {
		   color: inherit !important;
		   text-decoration: none !important;
		   font-size: inherit !important;
		   font-family: inherit !important;
		   font-weight: inherit !important;
		   line-height: inherit !important;
		}
		table {
		   border-collapse:separate;
		}
	</style>
<center>
	<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#FFF" style="max-width: 700px;border: 3px solid #36973d;">
	  <tr>
	    <td align="center">	      
	      <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 700px;" class="wrapper">
	        <tr>
	          <td align="center" height="25" style="height:25px; font-size: 0;">
	          	<img src="<?=base_url('/public/assets/images/logo-new.png')?>" />
	          </td>
	        </tr>	        
	        <tr>
	          <td align="center" height="25" style="height:25px; font-size: 0;">&nbsp;</td>
	        </tr>
	      </table>	     
	      </td>
	  </tr>
	  <tr>
	    <td bgcolor="#FFF" align="center" style="padding: 0;">
	      <table role="presentation" border="0" cellpadding="10" cellspacing="0" width="100%" style="max-width: 700px;" class="table-max">
	        <tr>
	          <td><table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0">
             	<tr>
		            <td align="left" class="titleblock" style="padding:7px 0">
		               <font size="2" face="Open-sans, sans-serif" color="#222">
		                  <span class="title" style="font-weight:400;font-size:18px;line-height:33px"><strong>Dear</strong> EcoEx</span>
		               </font>
		            </td>
	            </tr>
	            <tr>
		            <td align="left" class="titleblock" style="padding:7px 0">
		               <font size="2" face="Open-sans, sans-serif" color="#222">
		                  <span class="title" style="font-weight:bold;font-size:18px;line-height:33px;color: #48974e;">
		                  	Seller Uploaded Admin Approved Documents Has Been Accepted By Buyer Successfully !!!
		                  </span>
		               </font>
		            </td>
	            </tr>
	              <tr>	               
	               <td>	                  
	                  <table cellpadding="10" border="1" cellspacing="0" width="100%" style="border: 1px solid #ccc">
	                  	<tr>
	                        <td>Inquiry Number</td>
	                        <td><?=(($inventory)?$inventory->inquiry_no:'')?></td>
	                     </tr>
	                     <tr>
	                        <td>Category</td>
	                        <td><?=(($category)?$category->name:'')?></td>
	                     </tr>
	                     <tr>
	                        <td>Sub-Category</td>
	                        <td><?=(($subcategory)?$subcategory->name:'')?></td>
	                     </tr>
	                     <tr>
	                        <td>Product</td>
	                        <td><?=(($product)?$product->name:'')?></td>
	                     </tr>
	                     <tr>
	                        <td>Item</td>
	                        <td><?=(($item)?$item->name:'')?></td>
	                     </tr>
	                     <tr>
	                        <td>State</td>
	                        <td><?=(($state)?$state->state_title:'')?></td>
	                     </tr>
	                     <tr>
	                        <td>Month/Year</td>
	                        <td><?=$common_model->monthName($itemDetails->month)?> / <?=$common_model->financialyear($itemDetails->year)?></td>
	                     </tr>
	                     <tr>
	                        <td>Required Quantity</td>
	                        <td><?=$inventory->require_qty?> <?=(($unit)?$unit->name:'')?></td>
	                     </tr>
	                     <tr>
	                        <td>Rate</td>
	                        <td><?=$itemDetails->rate?>/<?=(($unit)?$unit->name:'')?></td>
	                     </tr>
	                     <tr>
	                     	<td colspan="2" style="text-align: center;">
	                     		<h4>
	                     			For more info <a href="<?=base_url('admin/inquiryDetails/'.encoded((($inventory)?$inventory->id:'')))?>" style="text-decoration: none;">Click On This Link</a>
	                     		</h4>
	                     	</td>
	                     </tr>
	                  </table>
	                  
	               </td>               
	            </tr>
	              
	              <tr>
	                <td align="center" height="25" style="height:25px; font-size: 0;">&nbsp;</td>
	              </tr>
	            <tr>
	                <td align="center" height="25" style="height:25px; font-size: 0;">&nbsp;</td>
	              </tr>
	              
	            </table></td>
	        </tr>
	      </table>
	      </td>
	  </tr>
	  <tr>
	    <td align="center" bgcolor="#36973d">
	  <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#36973d">
	  <tr>
	    <td align="center" bgcolor="#36973d" height="15" style="height:15px; font-size: 0;">&nbsp;</td>
	  </tr>
	  <tr>
	      <td align="center"><h3 style="font-family: Helvetica, Arial, sans-serif; font-size:15px; font-weight:normal; color: #fff; margin:0; mso-line-height-rule:exactly;">© <?php echo date('Y'); ?> - <?=$site_setting->websiteName?> - All rights reserved </h3></td>
	   </tr>
	   <tr>
	    <td align="center" bgcolor="#36973d" height="15" style="height:15px; font-size: 0;">&nbsp;</td>
	  </tr>
	  </table>
	  </td>  
	  </tr>
	</table>
</center>
</body>
</html>
