<?php
class Login_model extends CI_Model{

public function validate($username,$password){
    	$this->db->where('username',$username);
    	$this->db->where('password',$password);
    	$result = $this->db->get('users',1);
    	return $result;
}

public function system_logger($level, $script, $content, $timestamp){
	
		$data = array(
			'level' => $level,
			'script' => $script,
			'content' => $content,
			'timestamp' => $timestamp
		);

		$this->db->insert('system_log', $data);

}

public function login($username, $password){
		$query = $this->db->get_where('users', array('username'=>$username, 'password'=>$password));
		return $query->row_array();
} 

public function getClientMaxId(){

		$this->db->select_max('cid');
     	$result = $this->db->get('clients')->row_array();

     	return $result['cid'];
}

public function getusersMaxId(){

		$this->db->select_max('id');
		$result = $this->db->get('users')->row_array(); 

		return $result['id'];
}

public function autoCreateNewAccount($data1,$data2){
	
		$this->db->insert('clients', $data2);

		$last_cid = $this->db->insert_id();
	

		$userData = array_merge(array('cid'=>$last_cid),$data1);

		$email = $data1['email'];

		if($email == $this->checkUsernameEmail($email)){

			$client_data = array('user_id' => $this->getUserId($email) );
			$this->db->where('cid', $last_cid)->update('clients', $client_data);

		}else{

		$this->db->insert('users', $userData);

		$last_uid = $this->db->insert_id();

		$client_data = array('user_id'=>$last_uid);
		$this->db->where('cid', $last_cid)->update('clients', $client_data);
	
		}								
}	

public function resetAnytimeCredits($sub_id, $anytime_credits, $sub_status){
		$datas = array(
			'anytime_credits' => $anytime_credits,
			'subscription_status' => $sub_status
		);
		$this->db->where('subscription_id',$sub_id);
		$this->db->update('clients', $datas);
}

public function cancelSubscription($subscription_id, $subscription_status){
		$datas = array(
			'anytime_credits' => '0', 
			'successful_queries_count' => '0', 
			'subscription_status' => $subscription_status
		);
		$this->db->where('subscription_id', $subscription_id);
		$this->db->update('clients', $datas);
}

public function upgradeSubscription($subscription_id, $datas){
		$this->db->where('subscription_id',$subscription_id);
		$this->db->update('clients', $datas);
}

public function downgradeSubscription($subscription_id, $datas){
		$this->db->where('subscription_id',$subscription_id);
		$this->db->update('clients', $datas);
}

public function checkUsernameEmail($email){
		$this->db->where('email',$email);
		return $this->db->get('users',1)->row()->email;
}	

public function getUserId($email){
		$this->db->where('email',$email);
		return $this->db->get('users',1)->row()->id;
}

public function getUserPhoto($user_id){

		$this->db->where('id', $user_id);
		return $this->db->get('users',1)->row()->photo;
}		

public function updateUserProfilePhoto($datas, $user_id){

		$this->db->where('id',$user_id);
		$this->db->update('users', $datas);

			if($this->db->affected_rows() >0){
				return TRUE;
			}else{
				return FALSE;
			}
}

public function updateUserProfileInfo($datas, $user_id){

		$this->db->where('id',$user_id);
		$this->db->update('users', $datas);

			if($this->db->affected_rows() >0){
				return TRUE;
			}else{
				return FALSE;
			}
}	

public function checkUserPassword($user_id){

		$this->db->where('id',$user_id);
		return $this->db->get('users',1)->row()->password;


}

public function updateUserPassword($newPass, $user_id){

		$this->db->where('id', $user_id);
		$this->db->update('users', $newPass);

			if($this->db->affected_rows() >0){
				return TRUE;
			}else{
				return FALSE;
			}

}

public function getClientSubscription($user_id){

		$this->db->where('user_id', $user_id);
		$this->db->order_by('cid', 'DESC');
		return $this->db->get('clients',1)->result_array();


}


public function getInfoUsers($user_id){

		$this->db->where('id', $user_id);
		return $this->db->get('users',1)->result_array();

	}

}
