<!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © <script>document.write(new Date().getFullYear());</script>
             AuctionIntenl | All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Created By: UNIQUENESS, INC
            </span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

   <!-- Scroll to Top Button-->
  <!--<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
-->

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logoutModalLabel">LOG OUT</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body text-center">Are you sure you want to logout?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="mdi mdi-chevron-left"></i> Cancel</button>
          <a class="btn btn-primary" href="<?php echo base_url().'users/logout'?>">Logout <i class="mdi mdi-chevron-right"></i></a>
        </div>
      </div>
    </div>
  </div>

  <!-- plugins:js -->
  <script src="<?php echo site_url()?>vendors/js/vendor.bundle.base.js"></script>
  <script src="<?php echo site_url()?>vendors/js/vendor.bundle.addons.js"></script>

  <script src="<?php echo site_url()?>vendors/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo site_url()?>vendors/datatables/dataTables.bootstrap4.min.js"></script>
  
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->

  <script src="<?php echo site_url()?>js/jquery.validate.min.js"></script>
  <script src="<?php echo site_url()?>js/off-canvas.js"></script>
  <script src="<?php echo site_url()?>js/misc.js"></script>
  <script src="<?php echo site_url()?>js/jquery.md5.min.js"></script>
  <script src="<?php echo site_url()?>js/moment.min.js"></script>
  <script src="<?php echo site_url()?>js/jquery.cookie.min.js"></script>
  <script src="<?php echo site_url()?>js/DataTables.button.min.js"></script>
  <script src="<?php echo site_url()?>js/DataTables.select.min.js"></script>
  <script src="<?php echo site_url()?>js/editor.js"></script>
  <script src="<?php echo site_url()?>js/bootbox.min.js"></script>
 
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="<?php echo site_url()?>js/dashboard.js?v=<?php echo time()?>"></script>
  <script src="<?php echo site_url()?>js/customjs.js?v=<?php echo time()?>"></script>
  
  <!-- End custom js for this page-->
  
</body>

</html>