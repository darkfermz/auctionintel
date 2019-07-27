     <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          
          <div class="row bread-crumb">
            <div class="col-12">
              <span class="d-block d-md-flex align-items-center">
                <h4><i class="mdi mdi-menu-right"></i> Employee Master List</h4>
                <a class="btn ml-auto download-button d-none d-md-block" href="#" target="_blank"></a>
                <a class="btn purchase-button mt-4 mt-md-0" href="#" target="_blank"><button type="button" class="btn btn-success btn-sm">
                          <i class="mdi mdi-account-plus"></i>Add New Employee</button></a>
                <i class="mdi mdi-drag-vertical d-none d-md-block"></i>
              </span>
            </div>
          </div>
                        
          <div class="row">
            <div class="col-12 grid-margin">
               <!-- Data List -->
                <div class="card shadow mb-4">
                 
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-hover table-bordered table-display" id="Employees_list" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Employee ID</th>
                            <th>Office / Department</th>
                            <th>Status</th>
                            <th>Position</th>
                            <th style="width: 200px;">Action</th>
                          </tr>
                        </thead>
                        
                        <tbody>
                          
                          <?php for($a=1;$a<100;$a++){?>
                          <tr>
                            <td><strong>Fermin B. Ocon Jr.</strong></td>
                            <td>CE 22-2</td>
                            <td>Human Resource Management Office</td>
                            <td>Co-Terminous</td>
                            <td>Utility Worker</td>
                            <td><button class="btn btn-info btn-sm"><i class="mdi mdi-magnify"></i>View</button> <button class="btn btn-danger btn-sm"><i class="mdi mdi-close"></i>Delete</button></td>
                          </tr>
                          
                        <?php }?>
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->