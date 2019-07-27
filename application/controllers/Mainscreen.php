<?php
class MainScreen extends CI_Controller{
  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in') !== TRUE){
      redirect('users?action=login');
    }
  }

  function index(){
    //Allowing akses to admin only

      $datas['title'] = 'HRIS MainScreen | LGU-Claver';
      if($this->session->userdata('level')==='1'){


            $this->load->view('header', $datas);
            $this->load->view('sidebar');
            $this->load->view('mainscreen');
            $this->load->view('footer');

      }else{
          echo "Access Denied";
      }

  }

  function staff(){
    //Allowing akses to staff only
    if($this->session->userdata('level')==='2'){
      $this->load->view('dashboard_view');
    }else{
        echo "Access Denied";
    }
  }

  function author(){
    //Allowing akses to author only
    if($this->session->userdata('level')==='3'){
      $this->load->view('dashboard_view');
    }else{
        echo "Access Denied";
    }
  }

}
