<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct(){

        parent::__construct();
  			$this->load->helper(array('url','form'));
        $this->load->library('session');
        $this->load->database();

}
	public function index()
	{
		$this->load->view('common/login');
	}
	public function dashboard()
	{
		if(!isset($_SESSION['ROLE_ID'])){
			$this->index();
		}
		else{
			$data =array('firebaseConfig'=>$this->getFirebaseConfig());
		$this->load->view('dashboard',$data);
		}
	}
	public function login(){
		$adm_id=$_POST['username'];
		$adm_pass=$_POST['password'];
		$log_type=$_POST['logtype'];
		if($log_type=='Staff'){
		$this->db->select('*');
  		$this->db->from('TAB_ADMIN');
  		$this->db->where('ADMIN_ID',$adm_id);
  		$this->db->where('PASSWORD',md5($adm_pass));
  		$query=$this->db->get();
		if($query->num_rows()==1)
  			{
      		$record = $query->row_array();
      		$_SESSION['ADMIN_ID']=$record['ADMIN_ID'];
      		$_SESSION['NAME']=$record['NAME'];
      		$_SESSION['PHOTO']=$record['PHOTO'];
      		$_SESSION['ROLE_ID']=$record['ROLE_ID'];

      		$data = array(
      			'LAST_LOGIN_IP'=>$this->input->ip_address(),
      			'LAST_LOGIN_DATE'=>date("Y-m-d h:i:sa"),
      			'STATUS'=>1
      		);
      		$this->db->update('TAB_ADMIN', $data, array('ADMIN_ID' =>$record['ADMIN_ID']));
      		echo 'Success';
  			}
  		else{
   			echo 'Fail';
  			}
		}else
		{
			echo 'Fail';
		}
	}
	public function logout(){
      		$data = array(
      			'LAST_LOGIN_IP'=>$this->input->ip_address(),
      			'LAST_LOGIN_DATE'=>date("Y-m-d h:i:sa"),
      			'STATUS'=>0
      		);
      	$this->db->update('TAB_ADMIN', $data, array('ADMIN_ID' =>$_SESSION['ADMIN_ID']));
      	session_unset();
		$this->index();
	}

	public function getFirebaseConfig()
	{
		$file_path = base_url().'assets/firebase_config.json';
	$firebase_config=file_get_contents($file_path);
	return json_encode($firebase_config);
	}
}
