<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $title;?></title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?php echo site_url()?>vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?php echo site_url()?>vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php echo site_url()?>vendors/css/vendor.bundle.addons.css">
  <!-- Custom styles for dataTables -->
  <link href="<?php echo site_url()?>vendors/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo site_url()?>css/style.css?v=<?php echo time()?>">
  <link rel="stylesheet" href="<?php echo site_url()?>css/custom-css.css?v=<?php echo time()?>">
  <link rel="stylesheet" href="<?php echo site_url()?>css/editor.css?v=<?php echo time()?>">
  <!-- endinject -->
  <!--<link rel="shortcut icon" href="images/favicon.png" />-->
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="<?php echo base_url().'dashboard'?>">
          AuctionIntel
        </a>
        <a class="navbar-brand brand-logo-mini" href="<?php echo base_url().'dashboard'?>">
          <!--<img src="images/logo-180.png" alt="logo" />-->
          AuctionIntel
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
         <?php /* <li class="nav-item">
            <a href="#" class="nav-link">Activity
              <span class="badge badge-primary ml-1">New</span>
            </a>
          </li>
          <li><img src="<?php echo site_url()?>images/menu_separator.png" class="transform_20"/></li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="mdi mdi-elevation-rise"></i>Reports</a>
          </li>
          <li><img src="<?php echo site_url()?>images/menu_separator.png" class="transform_20"/></li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="mdi mdi-account-multiple-outline"></i>Scores</a>
          </li>
          */
          ?>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          
          <?php /*
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="mdi mdi-bell"></i>
              <span class="count">4</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <a class="dropdown-item">
                <p class="mb-0 font-weight-normal float-left">You have 4 new notifications
                </p>
                <span class="badge badge-pill badge-warning float-right">View all</span>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-success">
                    <i class="mdi mdi-alert-circle-outline mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-medium text-dark">Application Error</h6>
                  <p class="font-weight-light small-text">
                    Just now
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-warning">
                    <i class="mdi mdi-comment-text-outline mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-medium text-dark">Settings</h6>
                  <p class="font-weight-light small-text">
                    Private message
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-info">
                    <i class="mdi mdi-email-outline mx-0"></i>
                  </div>
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-medium text-dark">New user registration</h6>
                  <p class="font-weight-light small-text">
                    2 days ago
                  </p>
                </div>
              </a>
            </div>
          </li>
          */?>
          <li class="nav-item dropdown d-none d-xl-inline-block">
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <span class="profile-text">Hello, <?php foreach ($info_users as $key => $value) {
                echo $value['full_name'];
              }?> !</span>
              <?php $userPhoto = ($photo != '') ? $photo : 'no-image.jpg';?>
              <img class="img-xs rounded-circle userImgProfile" src="<?php echo site_url()?>user_images/<?php echo $userPhoto;?>" alt="Profile image">
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
             
              <a href="<?php echo site_url()?>users/myProfile" class="dropdown-item mt-2" title="My Profile">
                My Profile
              </a>

              <a href="#" class="dropdown-item" data-toggle="modal" data-target="#logoutModal" title="Logout">
                Log Out
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>