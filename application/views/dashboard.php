     <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          
          <div class="row bread-crumb">
            <div class="col-12">
              <span class="d-block d-md-flex align-items-center">
                <h4><i class="mdi mdi-menu-right"></i> Dashboard</h4>
              </span>
            </div>
          </div>

          <div class="row web-searches">
            <div class="col-lg-6 col-md-12 grid-margin stretch-card">
              <!--Lookup card-->
              <div class="card">
                <div class="card-body">
                   <span class="d-block d-md-flex align-items-center">
                    <h4>Identity Lookup</h4>
                   
                    
                  </span>
                     <hr>                      
                      <!-- Lookup tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="deepSearch-tab" data-toggle="tab" href="#deepSearch" role="tab" aria-controls="deepSearch" aria-selected="true">Deep Web Search</a>
                          </li>
                          <li class="nav-item disabled">
                            <a class="nav-link" id="reverseAddress-tab" data-toggle="tab" href="#reverseAddress" role="tab" aria-controls="reverseAddress" aria-selected="false">Reverse Address Lookup</a>
                          </li>
                          <li class="nav-item disabled">
                            <a class="nav-link" id="phoneIntel-tab" data-toggle="tab" href="#phoneIntel" role="tab" aria-controls="phoneIntel" aria-selected="false">Phone Intelligence</a>
                          </li>
                          
                        </ul>
                      <!--/End Lookup tabs-->
                      <!-- Tab Panes -->
                        <div class="tab-content">
                          <div class="tab-pane fade show active" id="deepSearch" role="tabpanel" aria-labelledby="deepSearch-tab">
                              <div class="row">
                                 <div class="col-lg-12" id="remaining_search_query" style="display:none;">Friendly reminder: Your only have X search queries remaining. Buy credit now! (This message will only show when the remaining credits is below 10) </div>
                                 <div class="col-lg-6">
                                    <input type="email" placeholder="Email" class="s-email" data-toggle="tooltip" title="Personal or work email address"/>
                                 </div>
                                 <div class="col-lg-6">
                                    <input type="text" placeholder="Phone" class="s-phone" data-toggle="tooltip" title="Current or past phone number. Mobile, home or work."/>
                                 </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4">
                                   <input type="text" placeholder="First Name" class="s-fname" data-toggle="tooltip" title="Current or past name."/>
                                </div>
                                <div class="col-lg-4">
                                   <input type="text" placeholder="Last Name" class="s-lname" data-toggle="tooltip" title="Current or past name."/>
                                </div>
                                <div class="col-lg-4">
                                   <input type="text" placeholder="Middle Name" class="s-mname" data-toggle="tooltip" title="Current or past name."/>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4">
                                   <input type="text" placeholder="Country Code" class="s-country-code" data-toggle="tooltip" title="2 letter abbreviation of current or past country."/>
                                </div>
                                <div class="col-lg-4">
                                   <input type="text" placeholder="State Code" class="s-state-code" data-toggle="tooltip" title="Abbreviation of current or past state."/>
                                </div>
                                <div class="col-lg-4">
                                   <input type="text" placeholder="City" class="s-city" data-toggle="tooltip" title="Current or past city of residence."/>
                                </div>
                              </div>
                              <div class="row">
                                 <div class="col-lg-6">
                                    <input type="text" placeholder="Username" class="s-username" data-toggle="tooltip" title="Screen name, handle, or username."/>
                                 </div>
                                 <div class="col-lg-6">
                                    <input type="text" placeholder="Age" class="s-age" data-toggle="tooltip" title="An age, or age range (e.g. 25-30)."/>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-lg-12">
                                    <input type="text" placeholder="Search Pointer" class="s-search-pointer" data-toggle="tooltip" title="Copy-paste here any search pointer provided in the API response"/>
                                 </div>
                              
                              </div>
                              <div class="row search-btn-wrapper">
                                 <div class="col-lg-6">
                                     <p>Find the person behind the email address, social username or phone number.</p>
                                 </div>
                                 <div class="col-lg-6 text-center">
                                  <button type="button" class="btn btn-secondary btn-fw" id="resetSearch">
                          <i class="mdi mdi-replay"></i>Clear</button>
                                     <button type="button" class="btn btn-success btn-fw" id="goDeepSearch">
                          <i class="mdi mdi-magnify"></i>Search</button>
                                 </div>
                                 <div id="deepMsg"></div>
                              </div>


                          </div>
                          <div class="tab-pane fade" id="reverseAddress" role="tabpanel" aria-labelledby="reverseAddress-tab">
                          
                          </div>
                          <div class="tab-pane fade" id="phoneIntel" role="tabpanel" aria-labelledby="phoneIntel-tab">...</div>
                          
                        </div>
                      <!--/End Tabs Panes-->

                <!--Search Results-->  
                <button style="display:none;margin-bottom: 20px;" type="button" class="btn btn-success btn-sm" id="back_btn"><i class="mdi mdi-chevron-left"></i> Back</button>            
                <div id="deepSearchResultsWrapper">
                    
                </div>   
                <!--End Search Results-->  

                </div><!--/Card Body-->   

              </div>
              <!--Identity Lookup card ends-->
            </div>
            <div class="col-lg-6 col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                     <?php //print_r($this->session->all_userdata());?>
                   <span class="d-block d-md-flex align-items-center">
                    <h4>Search Bad Bidder/Consignor List</h4>
                   <!-- <a class="ml-auto download-button d-none d-md-block" href="#" target="_blank"></a>
                    <a class="purchase-button mt-4 mt-md-0" href="javascript:void(0);" data-toggle="tooltip" title="Add Bad Bidder" ><button type="button" class="btn btn-icons btn-inverse-danger" data-toggle="modal" data-target="#biddersModal">
                              <i class="mdi mdi-account-plus "></i></button></a>-->
                   
                  </span> 
                 
                   <hr>                           
                       <!--Table Content here-->
                    <div class="table-responsive">  
                    <table id="identityReports" class="table table-hover table-bordered table-display" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Identity</th>
                                    <th>Problem / Created Case</th>
                                    <th>Created/ Updated</th>
                                   
                                </tr>
                            </thead>
                            
                        </table>
                    </div>

                   <!--/End Table Content-->
                   
                  <!--Bidder Comments-->
                  <?php //echo date_default_timezone_get();?>
                  <div id="biddersCommentsWrapper" style="margin-top:50px;display: none;">
                     <span class="d-block d-md-flex align-items-center">
                      <h4>Comments for <span id="bidders_name"></span></h4>
                      <a class="ml-auto download-button d-none d-md-block" href="#" target="_blank"></a>
                      <a class="comment-button mt-4 mt-md-0" href="javascript:void(0);" data-toggle="tooltip" title="Post A Comment" ><button type="button" class="btn btn-icons btn-secondary">
                                <i class="mdi mdi-comment-multiple-outline"></i></button></a>
                     
                    </span>
                    <div class="text-muted" style="font-size: 14px;line-height: 14px;"><i class="fa fa-caret-right"></i> <span id="bidders_issue"></span></div>
                    <hr/>
                          <div id="bad_bidders_comments">
                                <form id="post_comment" style="margin-bottom: 30px;">
                                    <input type="hidden" name="bidder_id_comment" id="bidder_id_comment" value="">
                                    <textarea id="commentsWrapper"></textarea> 
                                    <button type="submit" class="btn btn-dark go_post"><i class="mdi mdi-telegram"></i> POST COMMENT</button>
                                </form>
                                <div id="load_msg"></div>
                                <table id="bad_bidder_reviews" width="100%;" cellpadding="5">
                                   
                                </table>
                          </div>

                  </div>
                  <!--/End Bidder Comments-->

                </div>
              </div>


            </div>
          </div>
         
          
        </div>
        <!-- content-wrapper ends -->

        <!-- Bidders Modal -->
        <div class="modal fade" id="biddersModal" tabindex="-1" role="dialog" aria-labelledby="biddersModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            
            <form id="formBadBidders" novalidate="novalidate">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="biddersLabelModal">ADD BAD BIDDER</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>                        
                  <div class="modal-body">                                     
                        <div class="form-group">
                          <label for="IdentityInput">Identity *</label>
                          <input type="text" class="form-control" name="IdentityInput" id="IdentityInput" placeholder="Full Name" required>
                        </div>
                        <div class="form-group">
                          <label for="ProblemInput">Problem/Issue *</label>
                          <input type="text" class="form-control" name="ProblemInput" id="ProblemInput" placeholder="Problem/Issue" required>
                        </div>
                        <div class="form-group">
                          <label for="DetailsInput">Details</label>
                          <textarea class="form-control" name="DetailsInput" id="DetailsInput" ></textarea>
                        </div>
                       
                     
                  </div>
                  <div class="modal-footer">
                   <span id="addMsg"></span> <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="mdi mdi-chevron-left"></i> CANCEL</button>
                    <button type="submit" class="btn btn-danger" id="addBidderNow"><i class="mdi mdi-account-plus"></i> ADD</button>
                  </div>
              </form>
            </div>
          </div>
          <!--/End Bidders Modal-->
          
       </div>
