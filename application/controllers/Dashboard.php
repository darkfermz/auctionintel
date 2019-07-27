<?php
class Dashboard extends CI_Controller{
  function __construct(){
        parent::__construct();
            $this->load->model('dashboard_model');
            $this->load->model('cache_model');
            $this->load->model('login_model');

            if($this->session->userdata('logged_in') !== TRUE){
                redirect('users?action=login');
            }

        
            $this->user_id = $this->session->userdata('user_id');
  }

  function index(){
            
            $datas['title'] = 'Dashboard | AuctionIntel';
            $datas['photo'] = $this->login_model->getUserPhoto($this->user_id);
            $datas['info_users'] = $this->login_model->getInfoUsers($this->user_id);

            $this->load->view('header', $datas);
            $this->load->view('sidebar', $datas);
            $this->load->view('dashboard', $datas);
            $this->load->view('footer');

  }          


public function deepSearchGetJSON(){
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }else{

            $data = $this->input->post();

            $query_var = '';
            $email = $this->security->xss_clean($this->input->post('email'));
            $phone = $this->security->xss_clean($this->input->post('phone'));
            $first_name = $this->security->xss_clean($this->input->post('first_name'));
            $last_name = $this->security->xss_clean($this->input->post('last_name'));
            $middle_name = $this->security->xss_clean($this->input->post('middle_name'));
            $country = $this->security->xss_clean($this->input->post('country'));
            $state = $this->security->xss_clean($this->input->post('state'));
            $city = $this->security->xss_clean($this->input->post('city'));
            $username = $this->security->xss_clean($this->input->post('username'));
            $search_pointer = $this->security->xss_clean($this->input->post('search_pointer'));
            $age = $this->security->xss_clean($this->input->post('age'));
            //$show_sources = $this->security->xss_clean($this->input->post('show_sources'));


            $post_data = array(
                            'age' => $age,
                            'city' => $city,
                            'country' => $country,
                            'email' => $email,
                            'first_name' => $first_name,
                            'last_name' => $last_name, 
                            'middle_name' => $middle_name,
                            'phone' => $phone,
                            'search_pointer' => $search_pointer,
                            'state' => $state,
                            'username' => $username
                            
                        );

       
            $filtered = array_filter($post_data);

                $a = [];
                    foreach ($filtered as $key => $value) {
                            $a[] = $value;
                    }

            $query_var = strtolower(implode('_',$a));      

                   
            $limit_check =  $this->getClientsInfo($this->session->userdata('cid'));

                    
                 if($limit_check == 'excedeed'){
                    $errors = array(
                                    '@http_status_code' => 400,
                                    'error' => 'Search Query limit excedeed! Upgrade plan now!' 
                                    
                                );

                                echo json_encode($errors);

                 } else{

                        $data =  $this->cache_model->check_pipl_query( md5($query_var) );
                            if(sizeof($data) > 0){

                                foreach ($data as $key => $value) {
                                            echo $value['value'];
                                }
                               

                            }else{

                 
                                $this->checkAPI($filtered, $query_var);
                            }
                }
        }

}   
//function check search query in PIPL API 
public function checkAPI($filtered_data=array(), $query_var){

                try{
                    require(APPPATH.'libraries/piplapis/search.php'); 
                    $configuration = new PiplApi_SearchRequestConfiguration();
                    $configuration->api_key = '6guxd1zrevr292nyskyvndqp';
  
                    $request = new PiplApi_SearchAPIRequest($filtered_data, $configuration);
                
                    $response = $request->send();

                    $obj = (object)$response;

                    $status = $obj->{'http_status_code'};
                            switch ($status) {
                                    case 200:
                                            $rowJson = $obj->{'raw_json'};   

                                            $this->saveDataFromPIPL($query_var, $rowJson);
                                            echo $rowJson;
                        break;
                    
                    default:
                            $errors = array(
                                            'warnings' => 'Make sure all words are spelled correctly. Try searching with other parameters.',
                            );

                                            echo json_encode($errors);
                    break;
                }
                }catch (Exception $e){
                        $errors = array(
                                    'warnings' => 'Make sure all words are spelled correctly.',
                                    '@http_status_code' => 400,
                                    'error' => 'No Results Found. Try searching with other parameters',
                                    'query' => $query_var
                                );

                                echo json_encode($errors);
        }
    
       
}

//function save search queries to database for caching purposes
private function saveDataFromPIPL($names, $values){
   
            
            $this->cache_model->insert_pipl_results(md5($names), $values);

}

//function get clients information from clients table using client id session variable 
private function getClientsInfo($cid){

            $data = $this->dashboard_model->getClientsInfo($this->session->userdata('cid'));

            //print_r($data);

            $getInfos = array();

                foreach ($data as $key => $value) {
                        $getInfos['sub_type'] = $value['subscription_type'];
                        $getInfos['any_limits'] = $value['anytime_credits'];
                        $getInfos['queries_count']= $value['successful_queries_count'];
                }

                $limits = ( $getInfos['queries_count'] > $getInfos['any_limits']) ? '1' : '0';

               
                if($limits == '1') {
                       return 'excedeed';
                }else{
                        $count_update = $getInfos['queries_count'] + 1;


                        $setData = array(
                                    'successful_queries_count' => $count_update,
                        );

                        $this->dashboard_model->updateQueriesCount($cid, $setData) ;
                }

            
                  
 
 }

 public function simpleHtmlDOM(){

       if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }else{
 

        try{
        error_reporting(E_ERROR | E_PARSE);
        //require(APPPATH.'libraries/simple_html_dom/simple_html_dom.php'); 
       
        $post_url = $this->security->xss_clean($this->input->post('post_url'));

       
        $url_src = file_get_contents($post_url);
        $title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $url_src, $matches) ? $matches[1] : '';
         

                $data = array(
                    'title' => $title

                    
                );
          
              echo json_encode($data);
       

      }catch(Exception $e){
                        $errors = array(
                                    'warnings' => 'Try searching with other parameters.',
                                    '@http_status_code' => 400,
                                    'error' => 'No Results Found. Try searching with other parameters.',
                                    'query' => $query_var
                                );

                                echo json_encode($errors);

      }

    }
 
 }

 public function addBadBidders(){
    if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
       }else{

            $user_id =  $this->session->userdata('user_id');
            $identity = $this->security->xss_clean($this->input->post('identity'));
            $problem = $this->security->xss_clean($this->input->post('problem'));
            $details = $this->security->xss_clean($this->input->post('details'));


            $datas = array(
                    'user_id' => $user_id,
                    'identity' => $identity,
                    'problem' => $problem,
                    'details' => $details,
                    'date_added' => mdate('%Y-%m-%d %H:%i:%s', now())
                    
                    );

            if($this->dashboard_model->addBadBidders($datas) == TRUE){

                    $res = array(
                                'status' => 'added',
                                'identity' => $identity
                                );

                            echo json_encode($res);
            }else{

                    $res = array(
                                'status' => 'not-added',

                                );

                            echo json_encode($res);
            }
        
    }

  }

   public function getBadBidders(){
 
    $datas = $this->dashboard_model->getBadBidders();

    $response = array(
        'data' => $datas,

    );

    echo json_encode($response);

   } 

   public function deleteBadBidders(){
       if (!$this->input->is_ajax_request()) {
                exit('No direct script access allowed');
       }else{

             $bidder_id = $this->security->xss_clean($this->input->post('bidder_id'));

             if( $this->dashboard_model->deleteBiddersComments($bidder_id) == TRUE ){
                    
                     if( $this->dashboard_model->deleteBadBidders($bidder_id) == TRUE){                               
                             $response = array(
                                'msg' => 'deleted'
                             );

                             echo json_encode($response);
                    
                    }
            }else{

                    if( $this->dashboard_model->deleteBadBidders($bidder_id) == TRUE){                               
                             $response = array(
                                'msg' => 'deleted'
                             );

                             echo json_encode($response);
                    
                    }
            }


             

       }

   }



   public function postBidderComments(){
       if (!$this->input->is_ajax_request()) {
                exit('No direct script access allowed');
       }else{

            $user_id =  $this->session->userdata('user_id');
            $bidder_id = $this->security->xss_clean($this->input->post('bidder_id'));
            $post_content = $this->security->xss_clean($this->input->post('post_content'));

            $datas = array(
                    'bidder_id' => $bidder_id,                   
                    'content' => $post_content,
                    'date_added' => mdate('%Y-%m-%d %H:%i:%s', now()),
                    'user_id' => $user_id,                  
                    );


           if($this->dashboard_model->postComments($datas) == TRUE){

                    $res = array(
                                'status' => 'posted',
                                
                                );

                            echo json_encode($res);
            }else{

                    $res = array(
                                'status' => 'not-posted',

                                );

                            echo json_encode($res);
            }

       }
   }

   public function getBiddersComments(){

        if (!$this->input->is_ajax_request()) {
                exit('No direct script access allowed');
        }else{

         $bidder_id = $this->security->xss_clean($this->input->post('bidder_id'));
   
         $datas = $this->dashboard_model->getBadBiddersComments($bidder_id);
          
         $response = array(
            'data' => $datas,

          );

          echo json_encode($response);

        }
   }


   
   public function getComments(){

        $datas = $this->dashboard_model->getAllComments();

       
        print_r($datas);
        
   }
  

 


 

}
