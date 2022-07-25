<?php 
$currentURL = explode('/',$_SERVER['REQUEST_URI']);
$currentContorller = $currentURL['2'];
use App\Models\CommonModel;
$this->common_model = new CommonModel();
$site_setting       = $this->common_model->find_data('ecoex_setting', 'row');
?>
<style type="text/css">
  .linkactive{
    color: lightgreen !important;
  }
</style>
<div class="main-sidebar clientdash_mainsidebar">
  <!-- Main Sidebar Container -->
  <aside id="sidebar-wrapper">
    <!-- Brand Logo -->
    <div class="sidebar-brand pt-3 mb-3">
    <a href="<?php echo base_url('admin/');?>" class="brand-link" style="height: 56px;">
      <img src="<?php echo site_url('');?>/writable/uploads/<?=$site_setting->logo?>" alt="<?=$site_setting->websiteName?>" class="brand-image img-circle elevation-3" style="opacity: 1;border-radius:0px;">
    </a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm pt-2 mb-5">
        <a href="index.html"><img src="<?php echo site_url('');?>/public/assets/newadmin/images/logo-icon.png" alt="Logo"></a>
     </div>
    <!-- Sidebar Menu -->
      <ul class="sidebar-menu">         
        <li class="nav-item <?php if($currentContorller == ''){ echo 'active'; } ?>">
          <a href="<?php echo base_url('admin/');?>" class="nav-link <?php if($currentContorller == ''){ echo 'linkactive'; } ?> ">
            <i class="nav-icon fas fa-tachometer-alt"></i><span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item dropdown <?php if($currentContorller == 'category' || $currentContorller == 'manageListingPage' || $currentContorller == 'memberCategory' || $currentContorller == 'documentList' || $currentContorller == 'staticContentList' || $currentContorller == 'stateList' || $currentContorller == 'districtList' || $currentContorller == 'cityList' || $currentContorller == 'uploadAttributeList'){ echo 'active'; } ?>">
          <a href="javascript:void(0);" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa fa-tasks"></i> <span>Masters</span></a>
          <ul class="dropdown-menu">
            <li>
              <a class="nav-link <?php if($currentContorller == 'category'){ echo 'linkactive'; } ?>" href="<?php echo base_url('admin/category');?>">Business Category
              </a>
            </li>
            <li>
              <a class="nav-link <?php if($currentContorller == 'manageListingPage'){ echo 'linkactive'; } ?>" href="<?php echo base_url('admin/manageListingPage');?>">Manage Listing Page
              </a>
            </li>
            <li>
              <a href="<?php echo base_url('admin/memberCategory');?>" class="nav-link <?php if($currentContorller == 'memberCategory'){ echo 'linkactive'; } ?>">Member Type
              </a>
            </li>                            
            <li>
              <a href="<?php echo base_url('admin/documentList');?>" class="nav-link <?php if($currentContorller == 'documentList'){ echo 'linkactive'; } ?>">Document List
              </a>
            </li>
            <li>
              <a href="<?php echo base_url('admin/staticContentList');?>" class="nav-link <?php if($currentContorller == 'staticContentList'){ echo 'linkactive'; } ?>">Static Content
              </a>
            </li>
            <li>
              <a href="<?php echo base_url('admin/stateList');?>" class="nav-link <?php if($currentContorller == 'stateList'){ echo 'linkactive'; } ?>">State
              </a>
            </li>
            <li>
              <a href="<?php echo base_url('admin/districtList');?>" class="nav-link <?php if($currentContorller == 'districtList'){ echo 'linkactive'; } ?>">District
              </a>
            </li>
            <li>
              <a href="<?php echo base_url('admin/cityList');?>" class="nav-link <?php if($currentContorller == 'cityList'){ echo 'linkactive'; } ?>">City
              </a>
            </li>
            <li>
              <a href="<?php echo base_url('admin/uploadAttributeList');?>" class="nav-link <?php if($currentContorller == 'uploadAttributeList'){ echo 'linkactive'; } ?>">Upload Attribute
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item dropdown <?php if($currentContorller == 'emailSetting' || $currentContorller == 'emailLogs'){ echo 'active'; } ?>">
          <a href="javascript:void(0);" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa fa-envelope"></i> <span>Manage Emails</span></a>
          <ul class="dropdown-menu">
            <li>
              <a href="<?php echo base_url('admin/emailSetting');?>" class="nav-link <?php if($currentContorller == 'emailSetting'){ echo 'linkactive'; } ?>">Template Setting
              </a>
            </li>
            <li>
              <a href="<?php echo base_url('admin/emailLogs');?>" class="nav-link <?php if($currentContorller == 'emailLogs'){ echo 'linkactive'; } ?>">Email Logs
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item dropdown <?php if($currentContorller == 'approvalRequest' || $currentContorller == 'memberList'){ echo 'active'; } ?>">
          <a href="javascript:void(0);" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa fa-users"></i> <span>Manage Members</span></a>
          <ul class="dropdown-menu">
            <li>
              <a href="<?php echo base_url('admin/approvalRequest');?>" class="nav-link <?php if($currentContorller == 'approvalRequest'){ echo 'linkactive'; } ?>">Pending Members
              </a>
            </li>
            <li>
              <a href="<?php echo base_url('admin/memberList');?>" class="nav-link <?php if($currentContorller == 'memberList'){ echo 'linkactive'; } ?>">Approved Members
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item dropdown <?php if($currentContorller == 'unapprovedPost' || $currentContorller == 'currentPost' || $currentContorller == 'expiredPost'){ echo 'active'; } ?>">
          <a href="javascript:void(0);" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-sticky-note"></i> <span>Manage Posts</span></a>
          <ul class="dropdown-menu">
            <li>
              <a href="<?php echo base_url('admin/unapprovedPost');?>" class="nav-link <?php if($currentContorller == 'unapprovedPost'){ echo 'linkactive'; } ?>">Pending Posts
              </a>
            </li>
            <li>
              <a href="<?php echo base_url('admin/currentPost');?>" class="nav-link <?php if($currentContorller == 'currentPost'){ echo 'linkactive'; } ?>">Approved Posts
              </a>
            </li>
            <li>
              <a href="<?php echo base_url('admin/expiredPost');?>" class="nav-link <?php if($currentContorller == 'expiredPost'){ echo 'linkactive'; } ?>">Expired Posts
              </a>
            </li>
          </ul>
        </li>          
        
        
        <!-- <li class="nav-item menu-open">
          <a href="<?php echo base_url('admin/manageEnquiry');?>" class="nav-link <?php if($currentContorller == 'manageEnquiry'){ echo 'active'; } ?>">
            <i class="nav-icon fas fa-business-time"></i>
            <p>Manage Enquiry</p>
          </a>
        </li> -->
        <!-- <li class="nav-item menu-open">
          <a href="<?php echo base_url('admin/enquiryApp');?>" class="nav-link <?php if($currentContorller == 'enquiryApp'){ echo 'active'; } ?>">
            <i class="nav-icon fas fa-envelope"></i>
            <p>
             Enquiry From App
            </p>
          </a>
        </li> -->
        <li class="nav-item menu-open">
          <a href="<?php echo base_url('admin/inquiryList');?>" class="nav-link <?php if($currentContorller == 'inquiryList'){ echo 'linkactive'; } ?>">
            <i class="nav-icon fas fa-envelope"></i><span>Manage Inquiry</span>
          </a>
        </li>

        <li class="nav-item dropdown <?php if($currentContorller == 'memberTypeWiseReport' || $currentContorller == 'transactionReport'){ echo 'active'; } ?>">
          <a href="javascript:void(0);" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fa fa-file"></i> <span>Manage Report</span></a>
          <ul class="dropdown-menu">
            <li>
              <a href="<?php echo base_url('admin/memberTypeWiseReport');?>" class="nav-link <?php if($currentContorller == 'memberTypeWiseReport'){ echo 'linkactive'; } ?>">Member Type Wise
              </a>
            </li>
            <li>
              <a href="<?php echo base_url('admin/transactionReport');?>" class="nav-link <?php if($currentContorller == 'transactionReport'){ echo 'linkactive'; } ?>">Transaction
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item menu-open">
          <p>&nbsp;</p>
        </li>
      </ul>
    <!-- /.sidebar-menu -->
  </aside>
</div>
<!-- <style>
  	.main-sidebar {
      box-shadow: 0 4px 8px rgb(0 0 0 / 3%);
      position: fixed;
      top: 0;
      height: 100%;
      width: 250px;
      background-color: #fff;
      z-index: 880;
      left: 0;
  }
  	.main-sidebar .sidebar-menu li a i {
      width: 28px;
      margin-right: 20px;
      text-align: center;
  }
  	.main-sidebar .sidebar-menu li a span {
      margin-top: 3px;
      width: 100%;
  }
  .clientdash_mainsidebar, aside#sidebar-wrapper {
      background: #012e38;
  }
  	.main-sidebar, .navbar, .main-content, .main-footer {
      transition: all .5s;
  }

  .main-sidebar .sidebar-menu li a {
      position: relative;
      display: flex;
      align-items: center;
      height: 50px;
      padding: 0 20px;
      width: 100%;
      letter-spacing: .3px;
      color: #78828a;
      text-decoration: none;
  }
  	.main-sidebar .sidebar-menu li.active a {
      color: var(--white);
      font-weight: 600;
      background-color: #274d56;
  }
  	.main-sidebar .sidebar-menu li ul.dropdown-menu {
      padding: 0;
      margin: 0;
      display: none;
      position: static;
      float: none;
      width: 100%;
      box-shadow: none;
      background-color: transparent;
  }
  	.main-sidebar .sidebar-menu li.active a.has-dropdown:after { transform: translate(0, -50%) rotate(90deg); }
  .main-sidebar .sidebar-menu li a.has-dropdown:after { content: ""; font-family: 'Font Awesome 5 Free'; font-weight: 900; position: absolute; top: 50%; right: 20px; transform: translate(0, -50%); font-size: 12px; transition: all .5s; }
  .main-sidebar .sidebar-menu li.active > ul.dropdown-menu li a:hover { background-color: #f8fafb; }
  	.main-sidebar .sidebar-menu li {
      display: block;
  }
  	.main-sidebar .sidebar-menu li.active a {
      color: var(--white);
      font-weight: 600;
      background-color: #274d56;
  }
  	.main-sidebar .sidebar-menu li ul.dropdown-menu li a {
      color: #868e96;
      height: 35px;
      padding-left: 65px;
      font-weight: 400;
  }
</style> -->