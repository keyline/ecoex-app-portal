<nav class="navbar navbar-expand-lg main-navbar clientdash-navbar">
  <div class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="javascript;void(0);" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fa fa-bars"></i></a></li>
      <li><div class="d-sm-none d-lg-inline-block"><h3><i class="fa fa-use"></i> Admin Panel</div></h3></li>
    </ul>
  </div>
  <ul class="navbar-nav navbar-right align-items-center">
    <li class="nav-item">        
      <a href="<?=base_url()?>" target="_blank" class="nav-link" style="color: var(--primariygreen);">
        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Visit Marketplace
      </a>
    </li>
    <li class="dropdown"><a href="javascript;void(0);" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
      <div class="d-sm-none d-lg-inline-block">Hi, Admin</div></a>
      <div class="dropdown-menu dropdown-menu-right">
        <!-- <a href="features-profile.html" class="dropdown-item has-icon">
          <i class="fa fa-user"></i> Profile
        </a> -->        
        <a href="<?php echo base_url('admin/setting');?>" class="dropdown-item has-icon">
          <i class="fa fa-cog"></i> Settings
        </a>
        <div class="dropdown-divider"></div>
        <a href="<?php echo base_url('admin/logout');?>" class="dropdown-item has-icon text-danger">
          <i class="fa fa-sign-out-alt"></i> Logout
        </a>
      </div>
    </li>          
  </ul>
</nav>