<!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <div class="nav-link">
              <div class="user-wrapper">
                <div class="profile-image">
                  <?php $userPhoto = ($photo != '') ? $photo : 'no-image.jpg';?>
                  <img src="<?php echo site_url()?>user_images/<?php echo $userPhoto;?>" class="userImgProfile" alt="profile image">
                </div>
                <div class="text-wrapper">
                  <?php foreach ($info_users as $key => $value) {?>                   
                    <p class="profile-name" style="color:#fff;"><?php echo $value['full_name']?></p>
                  <?php } ?>

                  <div>
                    <small class="designation text-muted">Active</small>
                    <span class="status-indicator online"></span>
                  </div>
                  <br/>
                  <button class="btn btn-success btn-dark logout" data-toggle="modal" data-target="#logoutModal">Log out
                    <i class="mdi mdi-arrow-right"></i>
                  </button>
                </div>
              </div>
             
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url().'dashboard'?>">
              <i class="menu-icon mdi mdi-television"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <?php /*
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic" title="Basic Operations">
              <i class="menu-icon mdi mdi-camera-iris"></i>
              <span class="menu-title">MENU WITH SUB</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="#" title="Sub Menu">Sub Menu</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" title="Sub Menu">Sub Menu</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" title="Sub Menu">Sub Menu</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" title="Sub Menu">Sub Menu</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" title="Sub Menu">Sub Menu</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" title="Sub Menu">Sub Menu</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="menu-icon mdi mdi-account-search"></i>
              <span class="menu-title" title="MENU">MENU</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="menu-icon mdi mdi-chart-line"></i>
              <span class="menu-title" title="MENU">MENU</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="menu-icon mdi mdi-library"></i>
              <span class="menu-title" title="MENU">MENU</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="menu-icon mdi mdi-trophy"></i>
              <span class="menu-title" title="MENU">MENU</span>
            </a>
          </li>
          */
          ?>
          
        </ul>
      </nav>