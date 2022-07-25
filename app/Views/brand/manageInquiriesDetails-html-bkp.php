<?php echo view('brand/inc/header'); ?>
      <!-- Main Content -->
      <div class="main-content">
      	<div class="manage-quotes-top">
        	<div class="manage-quotes-page">
            	<div class="row">
            <div class="col-lg-12">
              <div class="toptile_search">
                <div class="page-title">
                  <h2>Inquiries</h2>
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
                                <p>Manage Inquiries</p> <span>/</span>
                                <p>Inquiries</p> <span class="in-black">/</span>
                                <p class="in-black">Inquiry Details</p>
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
                                                <a class="nav-link" href="#">Bid</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Audit Log</a>
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
            	
            	<div class="generalInfo-inner">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="manageInquiries-inquiryDetails-inner manageInquiries-inquiryDetails-inner-2">
                            <div class="manageInquiries-inquiryDetails-general">
                                <h3>General Info</h3>
                            </div>
                            <div class="manageInquiries-inquiryDetails-button">

                                <div class="ellipsis-action">
                                    <a href="#" class="ellipsis-btn"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="generalInfo-info general-border-box manageInquiries-inquiryDetails-borderBox">
                            <div class="row">
                                <div class="col-lg-2 col-md-6">
                                    <div class="generalInfo-box">
                                        <h5>Inquiry for</h5>
                                        <p>E-waste Scrap Dealer</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="generalInfo-box">
                                        <h5>Type of Inquiry</h5>
                                        <p>Buy</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="generalInfo-box">
                                        <h5>Inquiry Start Date</h5>
                                        <p>22/03/22</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="generalInfo-box">
                                        <h5>Inquiry Start Time</h5>
                                        <p>11:30am</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="generalInfo-box">
                                        <h5>Inquiry End Date</h5>
                                        <p>22/03/22</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="generalInfo-box">
                                        <h5>Inquiry End Time</h5>
                                        <p>6:30pm</p>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="generalInfo-box">
                                        <h5>Inquiry Discription</h5>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tellus mi in egestas ac ac tincidunt auctor tortor.</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="generalInfo-box">
                                        <h5>Inquiry Access Type</h5>
                                        <p>Limited</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="generalInfo-box">
                                        <h5>Attach Document</h5>
                                        <p>RFQ .pdf</p>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="generalInfo-box">
                                        <h5>Documents Required</h5>
                                        <p>GST & PAN card</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="generalInfo-inner manageInquiry-inner">
                    <div class="row">
                        <div class="col-lg-12">
                            <bid class="bid-inner">
                                <div class="manage-quotes-inner">
                                    <div class="table-part manageInquiry-tabble manageInquiry-tabble-2">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sub-Category</th>
                                                    <th>Item</th>
                                                    <th>Total Qty</th>
                                                    <th>Bidding UOM</th>
                                                    <th>State</th>
                                                    <th>Quantity</th>
                                                    <th>Milestone(Month)</th>
                                                    <th>Milestone(Qty)</th>
                                                    <th>Payment</th>
                                                </tr>
                                            </thead>
    
                                            <tbody>
                                                <tr>
                                                    <td>Building Material</td>
                                                    <td>Pavement Blocks</td>
                                                    <td>10,000KG</td>
                                                    <td>KG</td>
                                                    <td class="form-border-2">Arunachal Pradesh</td>
                                                    <td>1000Kg</td>
                                                    <td>January</td>
                                                    <td>100KG</td>
                                                    <td>20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border-2"></td>
                                                    <td></td>
                                                    <td>Feburary</td>
                                                    <td>100KG</td>
                                                    <td>20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border-2"></td>
                                                    <td></td>
                                                    <td>March</td>
                                                    <td>100KG</td>
                                                    <td>20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border form-border-2"></td>
                                                    <td class="form-border"></td>
                                                    <td class="form-border">April</td>
                                                    <td class="form-border">100KG</td>
                                                    <td class="form-border">20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border-2">Punjab</td>
                                                    <td>1000Kg</td>
                                                    <td>January</td>
                                                    <td>100KG</td>
                                                    <td>20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border-2"></td>
                                                    <td></td>
                                                    <td>Feburary</td>
                                                    <td>100KG</td>
                                                    <td>20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border-2"></td>
                                                    <td></td>
                                                    <td>March</td>
                                                    <td>100KG</td>
                                                    <td>20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border form-border-2"></td>
                                                    <td class="form-border"></td>
                                                    <td class="form-border">April</td>
                                                    <td class="form-border">100KG</td>
                                                    <td class="form-border">20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border-2">Haryana</td>
                                                    <td>1000Kg</td>
                                                    <td>January</td>
                                                    <td>100KG</td>
                                                    <td>20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border-2"></td>
                                                    <td></td>
                                                    <td>Feburary</td>
                                                    <td>100KG</td>
                                                    <td>20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border-2"></td>
                                                    <td></td>
                                                    <td>March</td>
                                                    <td>100KG</td>
                                                    <td>20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border form-border-2"></td>
                                                    <td class="form-border"></td>
                                                    <td class="form-border">April</td>
                                                    <td class="form-border">100KG</td>
                                                    <td class="form-border">20%</td>
                                                </tr>
                                                
    <!--                                            <div class="form-border">-->
                                                   <tr>
                                                    <td class="form-border-3">Building Material</td>
                                                    <td class="form-border-3">Pavement Blocks</td>
                                                    <td class="form-border-3">10,000KG</td>
                                                    <td class="form-border-3">KG</td>
                                                    <td class="form-border-2">Arunachal Pradesh</td>
                                                    <td>1000Kg</td>
                                                    <td>January</td>
                                                    <td>100KG</td>
                                                    <td>20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border-2"></td>
                                                    <td></td>
                                                    <td>Feburary</td>
                                                    <td>100KG</td>
                                                    <td>20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border-2"></td>
                                                    <td></td>
                                                    <td>March</td>
                                                    <td>100KG</td>
                                                    <td>20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border form-border-2"></td>
                                                    <td class="form-border"></td>
                                                    <td class="form-border">April</td>
                                                    <td class="form-border">100KG</td>
                                                    <td class="form-border">20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border-2">Punjab</td>
                                                    <td>1000Kg</td>
                                                    <td>January</td>
                                                    <td>100KG</td>
                                                    <td>20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border-2"></td>
                                                    <td></td>
                                                    <td>Feburary</td>
                                                    <td>100KG</td>
                                                    <td>20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border-2"></td>
                                                    <td></td>
                                                    <td>March</td>
                                                    <td>100KG</td>
                                                    <td>20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border form-border-2"></td>
                                                    <td class="form-border"></td>
                                                    <td class="form-border">April</td>
                                                    <td class="form-border">100KG</td>
                                                    <td class="form-border">20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border-2">Haryana</td>
                                                    <td>1000Kg</td>
                                                    <td>January</td>
                                                    <td>100KG</td>
                                                    <td>20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border-2"></td>
                                                    <td></td>
                                                    <td>Feburary</td>
                                                    <td>100KG</td>
                                                    <td>20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border-2"></td>
                                                    <td></td>
                                                    <td>March</td>
                                                    <td>100KG</td>
                                                    <td>20%</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="form-border form-border-2"></td>
                                                    <td class="form-border"></td>
                                                    <td class="form-border">April</td>
                                                    <td class="form-border">100KG</td>
                                                    <td class="form-border">20%</td>
                                                </tr>
    <!--                                                </div>-->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </bid>
                        </div>
                    </div>
                </div>
               <div class="generalInfo-inner manageInquiry-inner">
                        <div class="row">
                            <div class="col-lg-12">
                                <bid class="bid-inner">
                                    <bid class="bid-submit">
                                        <div class="bid-plastic invited-sellers">
                                            <p>Invited Sellers</p>
                                        </div>
                                    </bid>
                                    <div class="manage-quotes-inner">
                                        <div class="table-part manageInquiry-tabble">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th class="table-fix">Company Name</th>
                                                        <th>Deal In</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="table-fix">Namo E waste management</td>
                                                        <td>Plastic, E-waste & Rubber</td>
                                                    </tr>
                                                    <tr>
                                                        
                                                        <td class="table-fix">Paper Recycling Company</td>
                                                        <td>Plastic & E-waste</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-fix">Eco Wise Waste Management Pvt. Ltd.</td>
                                                        <td>Plastic</td>
                                                    </tr>
                                                       <tr>
                                                        <td class="table-fix">Eco Wise Waste Management Pvt. Ltd.</td>
                                                        <td>Plastic & E-waste</td>
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

  