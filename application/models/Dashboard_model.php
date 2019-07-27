<?php

class Dashboard_model extends CI_Model{

  	
  	function getClientsInfo($cid){
    		$this->db->where('cid',$cid);
    		return  $this->db->get('clients',1)->result_array();

  	}


	function updateQueriesCount($cid, $datas){

			$this->db->where('cid', $cid);
		
			$this->db->update('clients', $datas);

			if($this->db->affected_rows() >0){
				return TRUE;
			}else{
				return FALSE;
			}


	}

	function addBadBidders($datas){

			$this->db->insert('bidders', $datas);

			if($this->db->affected_rows() >0){
				return TRUE;
			}else{
				return FALSE;
			}
	}

	function getBadBidders(){
			$this->db->order_by('bidder_id', 'DESC');
			return $this->db->get('bidders')->result_array();
	}
	
	function deleteBiddersComments($bidder_id){

			$this->db->where('bidder_id', $bidder_id);
			$this->db->delete('bidders_comments');

			if($this->db->affected_rows() >0){
				return TRUE;
			}else{
				return FALSE;
			}
	}

	function deleteBadBidders($bidder_id){
			
			$this->db->where('bidder_id', $bidder_id);
			$this->db->delete('bidders');

			if($this->db->affected_rows() >0){
				return TRUE;
			}else{
				return FALSE;
			}

	}

	function postComments($datas){

			
			$this->db->insert('bidders_comments', $datas);

			if($this->db->affected_rows() >0){
				return TRUE;
			}else{
				return FALSE;
			}
	}

	function getBadBiddersComments($bidder_id){

    		$this->db->select('users.photo, users.full_name, bidders_comments.content, bidders_comments.date_added');
			$this->db->from('users');
			$this->db->join('bidders_comments', 'users.id = bidders_comments.user_id','inner');
			$this->db->where('bidders_comments.bidder_id',$bidder_id);
			$this->db->order_by('bidders_comments.date_added', 'DESC');

			return $this->db->get()->result_array();
    		
	}


  function getAllComments(){

  			$this->db->select('users.photo, users.full_name, bidders_comments.content, bidders_comments.date_added');
			$this->db->from('users');
			$this->db->join('bidders_comments', 'users.id = bidders_comments.user_id','inner');
			$this->db->where('bidders_comments.bidder_id','4');
			$this->db->order_by('bidders_comments.date_added', 'DESC');

			return $this->db->get()->result_array();
  }	




}
