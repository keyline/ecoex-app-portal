<?php echo view('brand/inc/header'); ?>
      <!-- Main Content -->
      <div class="main-content">
      	<div class="manage-quotes-top">
        	<div class="manage-quotes-page">
            	<div class="row">
                    <div class="col-lg-12">
                      <div class="toptile_search">
                        <div class="page-title">
                          <h2>Bids</h2>
                        </div>
                        <!--<div class="search-container">
                            <div class="form-group has-search">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input type="text" class="form-control" placeholder="Search">
                          </div>
                        </div>-->
                        
                      </div>
                      
                    </div>
                  </div>
          		<div class="manage-quotes-topbar">
                <div class="container-fluid">
                    <div class="row">
                        <div class="manage-quotes-info">
                            <div class="inquiry-details">
                                <p>Manage Quotes</p> <span>/</span>
                                <p>Inquiries</p> <span>/</span>
                                <p>Inquiry Details</p> <span class="in-black">/</span>
                                <p class="in-black">Queries</p>
                            </div>
                            <!------------|| NAV BAR STARTS ||------------>
                            <div class="topPanel">
                                <div class="topPanel-no">
                                    #12345
                                </div>
                                <nav class="navbar navbar-expand-xl navbar-light w-100">
                                    <a class="navbar-brand" href="<?php echo $database->base_url; ?>">
                                        <img src="<?php echo $database->base_url; ?>images/logo.svg" alt="" class="logo img-fluid">
                                    </a>
                                    <button class="navbar-toggler x collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>

                                    <div class="collapse navbar-collapse h-md-100" id="navbarSupportedContent">
                                        <ul class="navbar-nav h-md-100" id="nav">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="<?php echo base_url();?>/brand/manageQuotesInquiry/1">Inquiry Details</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Queries</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="<?php echo base_url();?>/brand/manageQuotesBid/1">Bid</a>
                                            </li>
                                        </ul>
                                    </div>
                                </nav>
                            </div>

                            <!------------|| NAV BAR ENDS ||------------>
                        </div>
                    </div>
                </div>
            </div>
            	<div class="generalInfo-inner bid-inner">
                <div class="row">
                    <div class="col-lg-12">
                        <bid class="bid-inner">
                            <bid class="bid-submit">
                                <div class="bid-plastic">
                                    <p>Plastic<span>|</span>EPR<span>|</span>Rigid</p>
                                </div>
                                <div class="submit-action">
                                    <a href="#" class="submit-btn">Submit</a>
                                </div>
                            </bid>
                            <div class="manage-quotes-inner">
                                <div class="table-part">
                                <table>
                                    <thead>
                                      <tr>
                                        <th>Item</th>
                                        <th>Req. Qty</th>
                                        <th>State</th>
                                        <th>Enter Qty</th>
                                        <th>Enter Rate Per Unit</th>
                                        <th class="table-fix">Calc. Total</th>
                                        <th></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>PET</td>
                                        <td>100MT</td>
                                        <td>Rajasthan</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="ml100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>
                                        <td></td>
                                      </tr>
                                      <tr>
                                        <td>PET</td>
                                        <td>100MT</td>
                                        <td>Delhi</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>
                                      </tr>
                                      <tr>
                                        <td>PET</td>
                                        <td>100MT</td>
                                        <td>Haryana</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>
                                      </tr>
                                      <tr>
                                        <td>LLDPE</td>
                                        <td>100MT</td>
                                        <td>Rajasthan</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>  
                                      </tr>
                                      <tr>
                                        <td>LLDPE</td>
                                        <td>100MT</td>
                                        <td>Delhi</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>
                                      </tr>
                                      <tr>
                                        <td>LLDPE</td>
                                        <td>100MT</td>
                                        <td>Haryana</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>
                                      </tr>
                                    </tbody>
                                  </table>
                            </div>
                                </div>
                        </bid>
                    </div>
                </div>
            </div>
            	<div class="generalInfo-inner bid-inner">
                <div class="row">
                    <div class="col-lg-12">
                        <bid class="bid-inner">
                            <bid class="bid-submit">
                                <div class="bid-plastic">
                                    <p>Plastic<span>|</span>EPR<span>|</span>Rigid</p>
                                </div>
                                <div class="submit-action">
                                    <a href="#" class="submit-btn">Submit</a>
                                </div>
                            </bid>
                            <div class="manage-quotes-inner">
                                <div class="table-part">
                                <table>
                                    <thead>
                                      <tr>
                                        <th>Item</th>
                                        <th>Req. Qty</th>
                                        <th>State</th>
                                        <th>Enter Qty</th>
                                        <th>Enter Rate Per Unit</th>
                                        <th class="table-fix">Calc. Total</th>
                                        <th></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>PET</td>
                                        <td>100MT</td>
                                        <td>Rajasthan</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="ml100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>
                                        <td></td>
                                      </tr>
                                      <tr>
                                        <td>PET</td>
                                        <td>100MT</td>
                                        <td>Delhi</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>
                                      </tr>
                                      <tr>
                                        <td>PET</td>
                                        <td>100MT</td>
                                        <td>Haryana</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>
                                      </tr>
                                      <tr>
                                        <td>LLDPE</td>
                                        <td>100MT</td>
                                        <td>Rajasthan</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>  
                                      </tr>
                                      <tr>
                                        <td>LLDPE</td>
                                        <td>100MT</td>
                                        <td>Delhi</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>
                                      </tr>
                                      <tr>
                                        <td>LLDPE</td>
                                        <td>100MT</td>
                                        <td>Haryana</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>
                                      </tr>
                                    </tbody>
                                  </table>
                            </div>
                                </div>
                        </bid>
                    </div>
                </div>
            </div>
            	<div class="generalInfo-inner bid-inner">
                <div class="row">
                    <div class="col-lg-12">
                        <bid class="bid-inner">
                            <bid class="bid-submit">
                                <div class="bid-plastic">
                                    <p>Plastic<span>|</span>EPR<span>|</span>Flexi</p>
                                </div>
                                <div class="submit-action">
                                    <a href="#" class="submit-btn">Submit</a>
                                </div>
                            </bid>
                            <div class="manage-quotes-inner">
                                <div class="table-part">
                                <table>
                                    <thead>
                                      <tr>
                                        <th>Item</th>
                                        <th>Req. Qty</th>
                                        <th>State</th>
                                        <th>Enter Qty</th>
                                        <th>Enter Rate Per Unit</th>
                                        <th class="table-fix">Calc. Total</th>
                                        <th></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>PET</td>
                                        <td>100MT</td>
                                        <td>Rajasthan</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="ml100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>
                                        <td></td>
                                      </tr>
                                      <tr>
                                        <td>PET</td>
                                        <td>100MT</td>
                                        <td>Rajasthan</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>
                                      </tr>
                                      <tr>
                                        <td>PET</td>
                                        <td>100MT</td>
                                        <td>Rajasthan</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>
                                      </tr>
                                      <tr>
                                        <td>LLDPE</td>
                                        <td>100MT</td>
                                        <td>Rajasthan</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>  
                                      </tr>
                                      <tr>
                                        <td>LLDPE</td>
                                        <td>100MT</td>
                                        <td>Rajasthan</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>
                                      </tr>
                                      <tr>
                                        <td>LLDPE</td>
                                        <td>100MT</td>
                                        <td>Rajasthan</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>
                                      </tr>
                                    </tbody>
                                  </table>
                            </div>
                                </div>
                        </bid>
                    </div>
                </div>
            </div>
            	<div class="generalInfo-inner bid-inner">
                <div class="row">
                    <div class="col-lg-12">
                        <bid class="bid-inner">
                            <bid class="bid-submit">
                                <div class="bid-plastic">
                                    <p>Plastic<span>|</span>EPR<span>|</span>Flexi</p>
                                </div>
                                <div class="submit-action">
                                    <a href="#" class="submit-btn">Submit</a>
                                </div>
                            </bid>
                            <div class="manage-quotes-inner">
                                <div class="table-part">
                                <table>
                                    <thead>
                                      <tr>
                                        <th>Item</th>
                                        <th>Req. Qty</th>
                                        <th>State</th>
                                        <th>Enter Qty</th>
                                        <th>Enter Rate Per Unit</th>
                                        <th class="table-fix">Calc. Total</th>
                                        <th></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>PET</td>
                                        <td>100MT</td>
                                        <td>Rajasthan</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="ml100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>
                                        <td></td>
                                      </tr>
                                      <tr>
                                        <td>PET</td>
                                        <td>100MT</td>
                                        <td>Rajasthan</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>
                                      </tr>
                                      <tr>
                                        <td>PET</td>
                                        <td>100MT</td>
                                        <td>Rajasthan</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>
                                      </tr>
                                      <tr>
                                        <td>LLDPE</td>
                                        <td>100MT</td>
                                        <td>Rajasthan</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>  
                                      </tr>
                                      <tr>
                                        <td>LLDPE</td>
                                        <td>100MT</td>
                                        <td>Rajasthan</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>
                                      </tr>
                                      <tr>
                                        <td>LLDPE</td>
                                        <td>100MT</td>
                                        <td>Rajasthan</td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="100MT"></td>
                                        <td class="mt100"><input type="email" class="form-control" placeholder="₹1,000"></td>
                                        <td class="pt100"><input type="email" class="form-control" placeholder="₹1,00,000"></td>
                                      </tr>
                                    </tbody>
                                  </table>
                            </div>
                                </div>
                        </bid>
                    </div>
                </div>
            </div>
            </div>
        </div>
      
        
  		</div>
  
  <?php echo view('brand/inc/footer'); ?>

<script>
$(document).ready(function(){ 
 $("#category").change(function(){   
    var catId = $(this).val();
      $.ajax({   
        type: "GET",
        data: { parent: catId,name:'Sub Category' },
        url: "/getBusinessCategory.php",             
        dataType: "html",   //expect html to be returned                
        success: function(response){
                $("#subCategory").html(response);
        }
    });
 });
 $("#subCategory").change(function(){  
    var subCatId = $(this).val();
      $.ajax({   
        type: "GET",
        data: { parent: subCatId,name:'Item' },
        url: "/getBusinessCategory.php",             
        dataType: "html",   //expect html to be returned                
        success: function(response){
                $("#item").html(response);
        }
    });
 });

});
</script> 

  