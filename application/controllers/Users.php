<?php
class Users extends CI_Controller{
  function __construct(){
      parent::__construct();
            $this->load->model('login_model');
            $this->user_id = $this->session->userdata('user_id');

            $this->u_level = '';
            $this->u_script = '';
            $this->u_content = '';
            $this->u_timestamp = date('Y-m-d H:i:s');
  }

  public function index(){
    if($this->session->userdata('logged_in') == TRUE){
        redirect('dashboard');
    }else
      {
        $this->load->view('login_view');

      }
    
  }

  public function system_logger($level, $script, $content, $timestamp){

   $this->login_model->system_logger($level, $script, $content, $timestamp);
  }

  public function auth(){
   
    if (!$this->input->is_ajax_request()) {
      exit('No direct script access allowed');
    }else{  

          $output = array('error' => false);

          $username  = $this->security->xss_clean($this->input->post('username',TRUE));
          $password  = $this->security->xss_clean($this->input->post('password',TRUE));

  
          $data = $this->login_model->login($username, $password);
 
    if($data){
     
          $useremail = $data['email']; 
          $cliend_id = $data['cid'];     
          $user_id = $data['id']; 
          $full_name = $data['full_name'];
          $photo = $data['photo'];

          $sesdata = array(
            'email'     => $useremail,
            'user_id' => $user_id,
            'cid' => $cliend_id,
            'user_photo' => $photo,
            'full_name' => $full_name,
            'logged_in' => TRUE
          );

          $this->session->set_userdata($sesdata);

          $level = 'User';
          $script = $full_name.' logged-in';
          $content = $full_name.' logged-in';

          $this->system_logger($level, $script, $content, $this->u_timestamp);

          $output['message'] = '<img src="images/loader.gif" /> Logging in. Please wait...';
    }else{
          $output['error'] = true;
          $output['message'] = 'Username and Password Invalid.';
        }
 
          echo json_encode($output);
    }
   
  }

  public function myProfile(){

    $datas['title'] = 'My Profile | AuctionIntel';
    $datas['photo'] = $this->login_model->getUserPhoto($this->user_id);
    $datas['info_subs'] = $this->login_model->getClientSubscription($this->user_id);
    $datas['info_users'] = $this->login_model->getInfoUsers($this->user_id);

    $this->load->view('header', $datas);
    $this->load->view('sidebar', $datas);
    $this->load->view('user_profile',$datas);
    $this->load->view('footer');
    
  }


//Receiving POST after new subscription is created on Zoho Subscriptions
//API Request added on Zoho subscriptions
//Auto Create account after successful subscription using Zoho Subscriptions
  public function createAccountAfterSubscription(){
    
     $full_name = $_GET['full_name'];
     $email = $_GET['email'];
     $company_name = $_GET['company_name'];
     $subscription_id = $_GET['subscription_id'];
     $subscription_type = $_GET['subscription_type'];
     $subscription_status = $_GET['subscription_status'];

   
     $data1 = array(
       'photo' => 'no-image.jpg',
       'username' => $email,
       'password' => $this->random_password(),
       'full_name' => $full_name,
       'email' => $email
     );

    
     $data2 = array(
        'company_name' => $company_name,
        'subscription_id' => $subscription_id,
        'subscription_type' => $subscription_type,
        'anytime_credits' => $this->checkAnytimeCredits($subscription_type),
        'subscription_status' => $subscription_status
     );

    $this->login_model->autoCreateNewAccount($data1, $data2);

   
  }

 //Generate random password for new account created from Zoho subscriptions
  public function random_password() 
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $password = array(); 
        $alpha_length = strlen($alphabet) - 1; 
        for ($i = 0; $i < 8; $i++) 
        {
            $n = rand(0, $alpha_length);
            $password[] = $alphabet[$n];
        }
        return implode($password); 
    }

//Zoho Subscription on renewing subscription
  public function resetAnytimeCredits(){
        $subscription_id = $_GET['sub_id'];
        $subscription_type = $_GEt['sub_type'];
        $subscription_status = $_GET['sub_status'];

        $datas = array(
                'subscription_id' => $subscription_id,
                'anytime_credits' => $this->checkAnytimeCredits($subscription_type),
                'subscription_status' => $subscription_status
        );

        $anytime_credits = $this->checkAnytimeCredits($subscription_type);

        $this->login_model->resetAnytimeCredits($subscription_id, $anytime_credits, $subscription_status);

  }

//Zoho Subscription immediate event on cancellation
  public function cancelSubscription(){
        $subscription_id = $_GET['sub_id'];
        $subscription_status = $_GET['sub_status'];

        $this->login_model->cancelSubscription($subscription_id, $subscription_status);
  }

 //Zoho Subscription immediate event on deleting subscription 
  public function deleteSubscription(){
        $subscription_id = $_GET['sub_id'];

        $this->login_model->deleteSubscription($subscription_id);
  }

  //Zoho Subscription immediate event on upgrading subscription
  public function upgradeSubscription(){
        $subscription_id = $_GET['sub_id'];
        $subscription_type = $_GET['sub_type'];

        $datas = array(
              'subscription_type' => $subscription_type,
              'anytime_credits' => $this->checkAnytimeCredits($subscription_type),
              'successful_queries_count' => '0'
        );

        $this->login_model->upgradeSubscription($subscription_id, $datas);
  }

//Zoho Subscription immediate event on downgrading subscription
  public function downgradeSubscription(){
        $subscription_id = $_GET['sub_id'];
        $subscription_type = $_GET['sub_type'];

        $datas = array(
              'subscription_type' => $subscription_type,
              'anytime_credits' => $this->checkAnytimeCredits($subscription_type),
              'successful_queries_count' => '0'
        );

        $this->login_modal->downgradeSubscription($subscription_id, $datas);
  }

  //Zoho SUbscription immediate event on expired subscription
  public function expiredSubscription(){
        $subscription_id = $_GET['sub_id'];

  }

  private function checkAnytimeCredits($subscription_type){
      
        $anytime_credits = '';

            switch($subscription_type){

                case 'BASE1':
                    $anytime_credits = '200';
                break;

                case 'PREMIUM1':
                    $anytime_credits = '500';
                break;

                case 'BUSINESS1':
                    $anytime_credits = '1000';
                break;

                default:
                    $anytime_credits = '200';
                break;

      }

        return $anytime_credits;
  }
  public function updateProfileInfo(){
    
        $full_name =  $this->security->xss_clean( $this->input->post('full_name') );
        $email =  $this->security->xss_clean( $this->input->post('email') );

        $datas = array(
            'full_name' => $full_name,
            'email' => $email
          );
    

        if( $this->login_model->updateUserProfileInfo($datas,$this->user_id) == TRUE ){

            $response = array('msg' => 'updated');         
            echo json_encode($response);

          }else{

              $response = array('msg' => 'failed');
              echo json_encode($response);
          }

  }
  public function updateProfilePhoto(){
        
        $config['upload_path'] = "./user_images";      
        $config['allowed_types'] = 'gif|jpg|png|jpeg'; 
        $config['max_size']      = 2048;
        $config['encrypt_name'] = TRUE;
         

        $this->upload->initialize($config);

          if($this->upload->do_upload('userPhotoInput')){

       
              $img_data = $this->upload->data('file_name');

              $datas = array(
                      'photo' => $img_data              
                     );
       
                if( $this->login_model->updateUserProfilePhoto($datas,$this->user_id) == TRUE ){

                  $response = array(
                      'msg' => 'updated',
                      'new_img' => $img_data
                    );

                  echo json_encode($response);

                }else{

                  $response = array(
                      'msg' => 'failed'
                  );

                  echo json_encode($response);
                }

                             

        }else{
          $response = array(
              'msg' => 'failed'
              );

          echo json_encode($response);
        }
    
  
       
  }

  public function updateUserPassword(){
    
        $currentPass = $this->security->xss_clean( $this->input->post('currentpass') );
        $newPass = $this->security->xss_clean( $this->input->post('newpass') );

        $datas = array(
                  'password' => $newPass
                );
    
            if($this->login_model->updateUserPassword($datas, $this->user_id) == TRUE){
                  
              $level = 'User';
              $script = $this->session->userdata('full_name').' updated password';
              $content = $this->session->userdata('full_name').' updated password';
    
              $this->system_logger($level, $script, $content, $this->u_timestamp);
              
              
              $response = array(
                          'msg' => 'updated',
                          'newpass' => $newPass
                        );
              echo json_encode($response);

            }else{
                  $response = array(
                          'msg' => 'not'
                  );

              echo json_encode($response);
            }

  }


  public function checkUserPassword(){
        $password = $this->security->xss_clean( $this->input->post('password') );  

        if($this->login_model->checkUserPassword($this->user_id) === $password ){
     
            $response = array('msg' => 'okay' );

            echo json_encode($response);

        }else{

            $response = array('msg' => 'not');

            echo json_encode($response);

        }
  }


  public function getClientSubscription(){
    
        $datas = $this->login_model->getClientSubscription();

        print_r($datas);

  }

  public function logout(){
        $this->session->sess_destroy();
        redirect('users?action=logout');
  }

  

}
