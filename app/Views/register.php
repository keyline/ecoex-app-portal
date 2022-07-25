<!doctype html>
<html>
<head>
    <!-- Meta Tag -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Title -->
    <title>Ecoex Portal</title>
    <!-- Favicons -->
    <link rel="shortcut icon" href="<?= base_url('inc/images/favicon.png'); ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        media="screen">
    <!-- Main Style -->
    <link href="<?= base_url('inc/css/local.css'); ?>" rel="stylesheet" media="screen">
    <!-- Important Owl stylesheet -->
    <link rel="stylesheet" href="<?= base_url('inc/css/owl.carousel.css'); ?>">
    <!-- Responsive Style -->
    <link href="<?= base_url('inc/css/responsive.css'); ?>" rel="stylesheet" media="screen">
    <style>
    body,
    html {
        height: 100%;
        min-height: 100%;
        width: 100%;
        margin: 0 0;
        display: flex;
        align-items: flex-start;
        justify-content: flex-start
    }
    @media (max-width: 1024px) {
        body,
        html {
            height: 100%;
        }
    }
    </style>
</head>
<body class="loginbody">
    
<!-- Start Content Section ==================================================-->
<div class="loginmain_section">
    <div class="loginmain_leftimg"></div>
    <div class="rightdash_img">
        <div class="rightsection_form loginfrom_center">
            <div class="toplogo"><img src="<?= base_url('inc/images/logo.svg'); ?>" alt="Logo" class="img-fluid"></div>
            <h2 class="greenheading">Registration</h2>
            <div class="form_section">
                <form action="storeCompany" id="myForm" method="POST" enctype="multipart/form-data"> 
                    <div class="form-group">
                        <label for="">Company Name <span class="red">*</span></label>
                        <input class="form-control" type="text"  name="company" id="company"  placeholder="Company Name" required>
                        <span style="color: red;display:none;" id="alreadyName">Company Name Already Registered</span>
                    </div>
                    <button type="submit" class="btn btn-primary green">Next</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Content Section ==================================================-->
<!-- ======================= JQuery libs =========================== -->
    <!-- Main jQuery -->
    <script src="<?= base_url('inc/js/jquery-min.js'); ?>"></script>
    <!-- Carousel -->
    <script src="<?= base_url('inc/js/owl.carousel.js'); ?>"></script>
    <!-- Bootstrap -->
    <script src="<?= base_url('inc/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- ======================= End JQuery libs =========================== -->
    <script src="<?= base_url('inc/js/custom.js'); ?>"></script>
<script>
    $(document).ready(function(){ 
    $('#myForm').on('submit', function(e){ 
        e.preventDefault();
      var companyName = $("#company").val();
      $.ajax({    //create an ajax request to display.php
        type: "POST",
        data: { companyName: companyName },
        url: "checkCompanyName.php",             
        dataType: "JSON",   //expect html to be returned                
        success: function(response){       
            if(response.success == 'true'){
                $("#alreadyName").css('display','block'); return false;
            } else { 
            
                    $('#myForm').unbind('submit').submit();
            }
        }
    });
    });
});
</script>
</body>
</html>
        
    