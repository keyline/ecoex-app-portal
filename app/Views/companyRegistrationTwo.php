<?php 
echo view('include/header.php');
?>
        <form>
            <div class="dashboard_form_start">
                <ul id="progressbar" class="dashboard_top_tab">
                    <li id="company">
                        <div class="dashoard_steps">
                            <div class="dash-step-number">1</div>
                            <div class="dash-step-name">
                                <div class="dash-step-icon"><img src="<?php echo site_url('public');?>/assets/frontend/images/company-icon.svg" alt="Icon"></div>
                                <div class="dash-step-info">
                                    <h3>Company Details</h3> 
                                    <h5>In Progress</h5>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="active" id="address">
                        <div class="dashoard_steps">
                            <div class="dash-step-number">2</div>
                            <div class="dash-step-name">
                                <div class="dash-step-icon"><img src="<?php echo site_url('public');?>/assets/frontend/images/pin-icon.svg" alt="Icon"></div>
                                <div class="dash-step-info">
                                    <h3>Address</h3> 
                                    <h5>Not started</h5>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li id="payment">
                        <div class="dashoard_steps">
                            <div class="dash-step-number">3</div>
                            <div class="dash-step-name">
                                <div class="dash-step-icon"><img src="<?php echo site_url('public');?>/assets/frontend/images/bank-icon.svg" alt="Icon"></div>
                                <div class="dash-step-info">
                                    <h3>Bank Details</h3> 
                                    <h5>Not started</h5>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
          
                
          
          
            </div>
            <div class="dashboard_inner_section">
                <fieldset>
                    <input type="button" name="next" class="next action-button" value="Save and Continue" />
                    <div class="dashboard_step_part">
                        
                        <div class="dashboard_step_left">
                            <div class="dashboar_leftnum">
                                1
                            </div>
                            <h3>Company Details</h3>
                        </div>
                        <div class="dashboard_step_right">
                            
                        </div>
                    </div>
                    <div class="dashboard_info_inner_section">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Company Name </label>
                                    <input class="form-control" type="text" placeholder="Ecoex Portal" value="<?php echo $storeData->c_name;?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Company Establishment Date <span class="red">*</span> </label>
                                    <input class="form-control" type="date" name="establishDate" placeholder="Entry Company Establishment Date" required>
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Contact Person Name <span class="red">*</span> </label>
                                    <input class="form-control" type="text" name="contactPerson" placeholder="Entry Contact Person Name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Company Type <span class="red">*</span> </label>
                                    <select class="form-control" name="companyType" required>
                                        <option>Brand</option>
                                        <option>Recycler</option>
                                        <option>EOL</option>
                                        <option>Waste Collector</option>
                                        <option>ULB</option>
                                    </select>
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Pan Number <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Entry Pan Number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Upload Pan Card <span class="red">*</span> </label>
                                    <input class="form-control" type="file" id="custom-input-file" placeholder="Entry Pan Number">
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">GST Number <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Entry GST Number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Upload GST Number <span class="red">*</span> </label>
                                    <input class="form-control" type="file" id="custom-input-file-2" placeholder="Entry GST Number">
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Alternate Mobile no. </label>
                                    <input class="form-control" type="text" placeholder="Entry alternate mobile no.">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Alternate Email Id </label>
                                    <input class="form-control" type="text" placeholder="Entry alternate email id">
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Optional Document upload (COI)</label>
                                    <input class="form-control" type="file" id="custom-input-file-3" placeholder="Entry GST Number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Business Category</label>
                                    <div class="form-group pt-2">
                                        <div class="form-check form-check-inline clear">
                                            <input class="form-check-input greencheck" type="checkbox" id="inlineCheckbox1" value="option1">
                                            <label class="form-check-label" for="inlineCheckbox1">Plastic</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input greencheck" type="checkbox" id="inlineCheckbox1" value="option1">
                                            <label class="form-check-label" for="inlineCheckbox1">E-Waste</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input greencheck" type="checkbox" id="inlineCheckbox1" value="option1">
                                            <label class="form-check-label" for="inlineCheckbox1">Rubber</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
          
                <fieldset>
                    <input type="button" name="next" class="next action-button" value="Save and Continue" />
                    <input type="button" name="previous" class="previous action-button-previous" value="Back" /> 
                    
                    <div class="dashboard_step_part">
                        
                        <div class="dashboard_step_left">
                            <div class="dashboar_leftnum">
                                2
                            </div>
                            <h3>Address</h3>
                        </div>
                        <div class="dashboard_step_right">
                            
                        </div>
                    </div>
                    
                    <div class="dashboard_info_inner_section">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Pincode <span class="red">*</span></label>
                                    <input class="form-control" type="text" placeholder="Entry Pincode">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">City <span class="red">*</span> </label>
                                    <select class="form-control">
                                        <option>Select city</option>
                                        <option>City 2</option>
                                        <option>City 3</option>
                                        <option>City 4</option>
                                        <option>City 5</option>
                                    </select>
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">District <span class="red">*</span> </label>
                                    <select class="form-control">
                                        <option>Select district </option>
                                        <option>District 2</option>
                                        <option>District 3</option>
                                        <option>District 4</option>
                                        <option>District 5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">State <span class="red">*</span> </label>
                                    <select class="form-control">
                                        <option>Select state </option>
                                        <option>West Bengal</option>
                                        <option>Delhi</option>
                                        <option>U.P</option>
                                        <option>M.P</option>
                                    </select>
                                </div>
                            </div>
            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Address <span class="red">*</span> </label>
                                    <textarea placeholder="Entry Address" class="form-control"></textarea>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <input type="button" name="next" class="next action-button" value="Submit" />
                    <input type="button" name="previous" class="previous bankpart_back action-button-previous" value="Back" /> 
                    <div class="dashboard_step_part">
                        
                        <div class="dashboard_step_left">
                            <div class="dashboar_leftnum">
                                3
                            </div>
                            <h3>Bank Details</h3>
                        </div>
                        <div class="dashboard_step_right">
                            
                        </div>
                    </div>
                    
                    <div class="dashboard_info_inner_section">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Account Type <span class="red">*</span></label>
                                    <div class="form-group pt-2">
                                        <div class="form-check form-check-inline clear">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                            <label class="form-check-label" for="inlineRadio1">Current</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                            <label class="form-check-label" for="inlineRadio2">Savings</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Bank Name <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Entry Bank Name">
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Branch Name <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Entry Branch Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Account Holder Name <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Entry Account Holder Name">
                                </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Cancelled Cheque <span class="red">*</span> </label>
                                    <input class="form-control" type="file" id="custom-input-file-4" placeholder="Entry GST Number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">MICR Code <span class="red">*</span> </label>
                                    <input class="form-control" type="text" placeholder="Entry MICR Code">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="dashboard_info_inner_section mt-5 pt-5">
                        <div class="form-card">
                            <h2 class="fs-title text-center">Success !</h2>
                            <div class="row justify-content-center">
                                <div class="col-md-12 text-center"> <img src="https://img.icons8.com/color/96/000000/ok--v2.png" class="fit-image"> </div>
                            </div> 
                            <div class="row justify-content-center">
                                <div class="col-7 text-center">
                                    <h5>You Have Successfully Create Account</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
          </form>
        
    </div>  
</div>

<?php echo view('include/footer.php');?>