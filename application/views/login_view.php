<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login Portal | AuctionIntel</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?php echo site_url()?>vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?php echo site_url()?>vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="<?php echo site_url()?>vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo site_url()?>css/style.css">
  <!-- endinject -->
  <!--<link rel="shortcut icon" href="images/favicon.png" />-->
  <style>
    .form-check .form-check-label input:checked + .input-helper:after{
      line-height: 10px !important;
    }
    .login_title span{
      color: #fff !important;
      font-size: 25px !important;
      letter-spacing: .5px;
    }
    .login_title{
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
      <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="login_title"><span>AuctionIntel - Log In Portal</span></div>
            <div class="auto-form-wrapper">

              <form action="<?php echo site_url('users/auth');?>" method="post" id="loginForm">
                <?php echo $this->session->flashdata('msg');?>
                <div class="form-group">
                  <label class="label">Username</label>
                  <div class="input-group">
                    <input type="text" name="username" class="form-control" placeholder="Username" required />
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="label">Password</label>
                  <div class="input-group">
                    <input type="password" name="password" class="form-control" placeholder="*********" required />
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                <div class="form-group">
                  <button class="btn btn-primary submit-btn btn-block">Login</button>
                </div>
                <div class="form-group d-flex justify-content-between">
                  <div class="form-check form-check-flat mt-0">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" checked> Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="text-small forgot-password text-black">Forgot Password?</a>
                </div>
                
              </form>

              <div id="responseDiv" class="alert text-center" style="margin-top:20px; display:none;">
                <button type="button" class="close" id="clearMsg"><span aria-hidden="true">&times;</span></button>
                <span id="message"></span>
              </div>
              
            </div>
            <br/>
            <p class="footer-text text-center">Copyright © <script>document.write(new Date().getFullYear());</script> AuctionIntel. All rights reserved.</p>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="<?php echo site_url()?>vendors/js/vendor.bundle.base.js"></script>
  <script src="<?php echo site_url()?>vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script type="text/javascript">
    
$(function($) {
 
    // this script needs to be loaded on every page where an ajax POST may happen
    $.ajaxSetup({
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    });
 
 
  // now write your ajax script 
 
});
  </script>
  <script src="<?php echo site_url()?>js/jquery.cookie.min.js"></script>
  <script src="<?php echo site_url()?>js/off-canvas.js"></script>
  <script src="<?php echo site_url()?>js/misc.js"></script>
  <script src="<?php echo site_url()?>js/login_page.js?v=<?php echo time()?>"></script>
  <!-- endinject -->

</body>

</html>