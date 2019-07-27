 <!-- partial -->
    <div class="main-panel">
        <!--Content wrapper-->
        <div class="content-wrapper">
            <div class="row bread-crumb">
              <div class="col-lg-12">
                <span class="d-block d-md-flex align-items-center">
                  <h4><i class="mdi mdi-menu-right"></i> User Profile</h4>
                </span>
              </div>
            </div>

            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <span class="d-block d-md-flex align-items-center">
                              <h4><i class="mdi  mdi-account-check"></i> My Profile</h4>
                            </span>
                            <hr>

                            <div>
                               <!-- My Profile Tabs -->
                                <ul class="nav nav-tabs" id="yourProfile" role="tablist">
                                  <li class="nav-item">
                                    <a class="nav-link active" id="subscriptions-tab" data-toggle="tab" href="#subscriptions" role="tab" aria-controls="subscriptions" aria-selected="false">Subscriptions</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" id="myProfile-tab" data-toggle="tab" href="#myProfile" role="tab" aria-controls="myProfile" aria-selected="true">Edit Profile</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" id="updatePasswpord-tab" data-toggle="tab" href="#updatePasswpord" role="tab" aria-controls="updatePasswpord" aria-selected="false">Change Password</a>
                                  </li>
                                                           
                                </ul>
                              <!--/ End My Profile Tabs -->
                              <!-- Tab Panes -->
                                <div class="tab-content" style="margin-top:30px;">
                                  <div class="tab-pane fade show active" id="subscriptions" role="tabpanel" aria-labelledby="subscriptions-tab">
                                      <?php foreach ($info_subs as $key => $value) {?>                                      
                                          <div class="form-group">
                                             <label>Company Name:</label>
                                             <h4><?php echo strtoupper($value['company_name']);?></h4>
                                          </div>
                                          <div class="form-group">
                                              <label>Subscription Type:</label>
                                              <h4><?php echo $value['subscription_type'];?></h4>
                                          </div>
                                          <div class="form-group">
                                              <label>Anytime Credits:</label>
                                              <h4><?php echo $value['anytime_credits'];?></h4>
                                          </div>
                                          <div class="form-group">
                                              <label>Successful Queries Count:</label>
                                              <h4><?php echo $value['successful_queries_count'];?></h4>
                                          </div>

                                          <div class="form-group">
                                              <label>Remaining Credits:</label>
                                              <h4><?php echo ($value['anytime_credits'] - $value['successful_queries_count']);?></h4>
                                          </div>
                                          <div class="form-group">
                                            <button class="btn btn-primary" id="upgradePlanBtn" title="Change Plan">Change Plan</button>
                                        </div>
                                      
                                      <?php } ?>  
                                     
                                  </div>
                                  <div class="tab-pane fade" id="myProfile" role="tabpanel" aria-labelledby="myProfile-tab">
                                      
                                    <form method="post" enctype="multipart/form-data" id="updateUserInfo">
                                       <div class="form-group">
                                        <?php $userPhoto = ($photo != '') ? $photo : 'no-image.jpg';?>
                                      
                                       <div id="currentUserPhoto">
                                       <img src="https://auctionintel.com/clients/user_images/<?php echo $userPhoto;?>" id="userPhotoImg" style="cursor:pointer;width:128px;border-radius: 50%;" />
                                        </div>
                                       <input type="file" id="userPhotoInput" name="userPhotoInput" style="display: none;" onchange="previewImage();"/>
                                        </div>
                                        <?php //print_r($info_users);

                                        foreach ($info_users as $key => $value) {
                                       
                                        ?>
                                        <div class="form-group">
                                          <label for="userFullName">Full Name</label>
                                          <input type="text" class="form-control" id="userFullName" name="userFullName" value="<?php echo $value['full_name']?>" required>
                                        </div>
                                        <div class="form-group">
                                          <label for="userEmail">Email address</label>
                                          <input type="email" class="form-control" id="userEmail" name="userEmail" value="<?php echo $value['email']?>" required>
                                        </div>

                                      <?php } ?>

                                        <div>
                                            <button type="submit" class="btn btn-primary" title="Update Profile">Update Profile</button>
                                            <p id="msg_update_profile" style="margin-top:10px;"></p>
                                        </div>
                                    </form>

                                
                                  </div>
                                  <div class="tab-pane fade" id="updatePasswpord" role="tabpanel" aria-labelledby="updatePasswpord-tab">
                                    <form method="post" id="updateUserPassword">
                                        <div class="form-group">
                                          <label for="userPassword">Enter Current Password</label>
                                          <input type="password" id="userPassword" name="userPassword" class="form-control" required>
                                          <p id="passChecker"></p>
                                        </div>
                                        <div class="form-group">
                                          <label for="userNewPass">Enter New Password</label>
                                          <input type="password" id="userNewPass" name="userNewPass" class="form-control" disabled="true" required>
                                        </div>
                                        <div class="form-group">
                                          <label for="userNewPassRepeat">Confirm New Password</label>
                                          <input type="password" id="userNewPassRepeat" name="userNewPassRepeat"  class="form-control" disabled="true" required>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary disabled" id="btnChangedPass" title="Update Password">Update Password</button>
                                            <p id="msg_on_update" style="margin-top:10px;"></p>
                                        </div>

                                    </form>
                                  </div>
                                  
                                  
                                </div>
                              <!--/End Tabs Panes-->
                            </div>

                        </div>
                    </div>

                </div>
              
            </div>  

        </div>
        <!--/ content-wrapper ends -->