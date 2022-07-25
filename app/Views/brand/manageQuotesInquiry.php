<?php echo view('brand/inc/header'); ?>
      <!-- Main Content -->
      <div class="main-content">
      	<div class="manage-quotes-top">
        	<div class="manage-quotes-page">
            	<div class="row">
            <div class="col-lg-12">
              <div class="toptile_search">
                <div class="page-title">
                  <h2>Inquiry Details</h2>
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
                                <p>Quote Requests</p> <span class="in-black">/</span>
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
            	<div class="generalInfo-inner">
                <div class="row">
                    <div class="col-lg-12">
                        <h3>General Info</h3>
                    </div>
                </div>
                <div class="generalInfo-info general-border-box">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="generalInfo-box">
                                <h5>Inquiry for</h5>
                                <p>E-waste Scrap Dealer</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="generalInfo-box">
                                <h5>Type of Inquiry</h5>
                                <p>Sell</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="generalInfo-box">
                                <h5>Inquiry Discription</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tellus mi in egestas ac ac tincidunt auctor tortor.</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="generalInfo-box">
                                <h5>Inquiry Start Date</h5>
                                <p>22/03/22</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="generalInfo-box">
                                <h5>Inquiry End Date</h5>
                                <p>22/03/22</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="generalInfo-box">
                                <h5>Inquiry Access Type</h5>
                                <p>Limited</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="generalInfo-box">
                                <h5>Attach Document</h5>
                                <p>RFQ .pdf</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="generalInfo-box">
                                <h5>Documents Required</h5>
                                <p>GST & PAN card</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h5 class="milestone">Milestones</h5>
                    </div>
                </div>
                <div class="generalInfo-info generalInfo-info-2">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="generalInfo-box">
                                <p>1. Lorem ipsum dolor sit amet</p>
                                <p>2. Lorem ipsum dolor sit amet</p>
                                <p>3. Lorem ipsum dolor sit amet</p>
                                <p>4. Lorem ipsum dolor sit amet</p>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="generalInfo-box">
                                <p>20% of Total payment</p>
                                <p>30% of Total payment</p>
                                <p>30% of Total payment</p>
                                <p>30% of Total payment</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            	<div class="generalInfo-inner">
                <div class="row">
                    <div class="col-lg-12">
                       <div class="bid-inner">
                            <div class="bid-submit">
                                <div class="bid-plastic">
                                    <p>Plastic<span>|</span>EPR</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                      <div class="row">
                          <div class="col-lg-12">
                              
<div id="table-scroll" class="table-scroll">
  <table id="main-table" class="main-table">
<!--
    <thead>
      <tr>
        <th scope="col">Header 1</th>
        <th scope="col">Header 2</th>
        <th scope="col">Header 3 with longer content</th>
        <th scope="col">Header 4 text</th>
        <th scope="col">Header 5</th>
        <th scope="col">Header 6</th>
        <th scope="col">Header 7</th>
        <th scope="col">Header 8</th>
      </tr>
    </thead>
-->
    <tbody>
      <tr>
        <th>Categroy</th>
        <td>Plastic</td>
        <td>Plastic</td>
        <td>Plastic</td>
        <td>Plastic</td>
        <td>Plastic</td>
        <td>Plastic</td>
        <td>Plastic</td>
      </tr>
      <tr>
        <th>Sub Category</th>
        <td>EPR</td>
        <td>EPR</td>
        <td>EPR</td>
        <td>EPR</td>
        <td>EPR</td>
        <td>EPR</td>
        <td>EPR</td>
      </tr>
      <tr>
        <th>UOM</th>
        <td>PET</td>
        <td>PET</td>
        <td>PET</td>
        <td>PET</td>
        <td>PET</td>
        <td>PET</td>
        <td>PET</td>
      </tr>
      <tr>
        <th>Opening Price</th>
        <td>₹1,00,000</td>
        <td>₹1,00,000</td>
        <td>₹1,00,000</td>
        <td>₹1,00,000</td>
        <td>₹1,00,000</td>
        <td>₹1,00,000</td>
        <td>₹1,00,000</td>
      </tr>
      <tr>
        <th>Bidding UOM</th>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
      </tr>
      <tr>
        <th>Bid inc/dec Factor</th>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
      </tr>
      <tr>
        <th>Reserve Price</th>
        <td>₹10,000</td>
        <td>₹10,000</td>
        <td>₹10,000</td>
        <td>₹10,000</td>
        <td>₹10,000</td>
        <td>₹10,000</td>
        <td>₹10,000</td>
      </tr>
      <tr>
        <th>Ceiling Price</th>
        <td>₹2,00,000</td>
        <td>₹2,00,000</td>
        <td>₹2,00,000</td>
        <td>₹2,00,000</td>
        <td>₹2,00,000</td>
        <td>₹2,00,000</td>
        <td>₹2,00,000</td>
      </tr>
      <tr>
        <th>Quantity</th>
        <td>1000</td>
        <td>1000</td>
        <td>1000</td>
        <td>1000</td>
        <td>1000</td>
        <td>1000</td>
        <td>1000</td>
      </tr>
      <tr>
        <th>State</th>
        <td>Rajasthan</td>
        <td>Rajasthan</td>
        <td>Rajasthan</td>
        <td>Rajasthan</td>
        <td>Rajasthan</td>
        <td>Rajasthan</td>
        <td>Rajasthan</td>
      </tr>
      
    </tbody>
  
  </table>
</div>

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

  