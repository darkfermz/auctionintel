 <!-- partial -->
    <div class="main-panel">
        <!--Content wrapper-->
        <div class="content-wrapper">
            <div class="row bread-crumb">
              <div class="col-lg-12">
                <span class="d-block d-md-flex align-items-center">
                  <h4><i class="mdi mdi-menu-right"></i> Bad Bidders List  <i class="mdi mdi-menu-right"></i> Fermin Ocon <i class="mdi mdi-menu-right"></i> Test problem</h4>

                </span>
              </div>
            </div>

            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <span class="d-block d-md-flex align-items-center">
                              <h4><i class="mdi mdi-comment-multiple-outline"></i> Reviews and Comments</h4>
                              <a class="ml-auto download-button d-none d-md-block" href="#" target="_blank"></a>
                    <a class="comment-button mt-4 mt-md-0" href="javascript:void(0);" data-toggle="tooltip" title="Comment Now"><button type="button" class="btn btn-icons btn-secondary">
                              <i class="mdi mdi-comment-text-outline"></i></button></a>
                            </span>
                            <hr>

                            <div id="bad_bidders_comments">
                                <form id="post_comment" style="display: none;margin-bottom: 30px;">
                                    <input type="" name="bidder_id_comment" id="bidder_id_comment" value="">
                                    <textarea id="commentsWrapper"></textarea> 
                                    <button type="submit" class="btn btn-dark"><i class="mdi mdi-telegram"></i> POST COMMENT</button>
                                </form>
                                <table id="bad_bidder_reviews">
                                 <?php for($i =0 ; $i < 6; $i++){?>

                                  <tr style="border-bottom: 1px solid #efefef;">
                                     <td style="vertical-align: top;padding:20px 0px;"><img style="width:100px;border-radius: 3px;" src="<?php echo site_url()?>images/me.png" alt="Profile image"></td>
                                     <td style="padding:0px 20px">
                                       <b>Fermin Ocon</b><br/>
                                       <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                                     </td>
                                     <td style="width: 80px;vertical-align: top;padding: 20px 0px"><span style="font-size: 12px;color:#aaa;">5hrs ago</span></td>
                                  </tr>
                                <?php }?>

                                </table>
                            </div>

                        </div>
                    </div>

                </div>
              
            </div>  

        </div>
        <!--/ content-wrapper ends -->