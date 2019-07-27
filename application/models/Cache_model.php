<?php
class Cache_model extends CI_Model{

  
 public function check_pipl_query($query_var){
 	$this->db->where('name', $query_var);

 	return $this->db->get('vars',1)->result_array();

}

 public function insert_pipl_results($names, $values){
			
 		$data = array(
        'name' => $names,
        'value' => $values
		);


		$this->db->replace('vars', $data);			

}

}
