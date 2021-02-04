<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {

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
			
		$this->load->view('dashboard',$data);
		}
	}
	public function register(){
		$staff_name= $_POST['staffname'];
		$phone= $_POST['phone'];
		$email= $_POST['email'];
		$role= $_POST['role'];
		$gender= $_POST['gender'];

		$this->db->select('ADMIN_ID');
  		$this->db->from('TAB_ADMIN');
  		$this->db->like('ADMIN_ID',strtoupper(substr($staff_name, 0,2)) );
  		$query=$this->db->get();

  		$adm_index =0;
		if($query->num_rows()>0)
  			{
      		$record = $query->result_array();
      		foreach ($record as $key) {
      			if((int)substr($key['ADMIN_ID'],2)>$adm_index)
      			{
      				$adm_index=(int)substr($key['ADMIN_ID'],2);
      			}
      		}
  			}
  		$adm_id=strtoupper(substr($staff_name, 0,2)).str_pad($adm_index+1,3,'0',STR_PAD_LEFT);

  		if($gender=='Male'){
  			$photo ='https://visualpharm.com/assets/381/Admin-595b40b65ba036ed117d3b23.svg';
  			$gender='M';
  		}
  		else{
  			$photo = 'https://visualpharm.com/assets/661/Woman%20Profile-595b40b65ba036ed117d286c.svg';
  			$gender='F';
  		}

		$data = array(
				'ADMIN_ID' =>$adm_id,
				'NAME' => strtoupper($staff_name),
				'ROLE_ID' => strtoupper($role),
				'PHOTO' =>$photo,
				'PASSWORD' =>md5($adm_id),
				'PHONE' => $phone,
                'EMAIL' => $email,
                'GENDER'=> $gender,
                'LAST_LOGIN_DATE' => NULL,
                'LAST_LOGIN_IP' => NULL,
                'CREATED_ON' => date("Y-m-d h:i:sa"),
                'CREATED_BY' => $_SESSION['ADMIN_ID'],
                'STATUS'=>0,
				);
		$this->db->insert('TAB_ADMIN', $data);
			$insertId =  $this->db->affected_rows();
            echo $insertId;

	}

	public function searchstaff(){
		$keyword= strtoupper($_POST['keyword']);
		$this->db->select('*');
  		$this->db->from('TAB_ADMIN');
  		$this->db->like('ADMIN_ID',$keyword );
  		$this->db->or_like('NAME', strtoupper($keyword));
  		$query=$this->db->get();
  		$data= $query->result_array();
  		$count= $query->num_rows();
	  $content='';
	  $res=array(
		'response'=>true,
		'content'=>$content,
		'data'=>null
	  );
  		if($count==0){
			  $content.='<h5> No Results found </h5>';
			  $res['response']=false;
  		}
  		else{


        /*
  			$content.='Results found : '.$count.'</h5>
			<ul class="mt-3 list-group text-left" >';
			$content.='<li class="list-group-item active">
			<b>
  			<div class="row">
  			<span class="col text-center">#</span>
  			<span class="col">ADMIN ID</span>
  			<span class="col">NAME</span>
  			<span class="col">ROLE</span>
  			<span class="col">LAST LOGIN IP</span>
  			<span class="col">STATUS</span>
  			<span class="col">ACTION</span>
  			</div>
  			</b>
  			</li>';
  		$sno=0;
  		foreach ($data as $key) {
  			$sno++;
  			$admid="'".$key['ADMIN_ID']."'";
        if($key['STATUS']==1)
            $status='Online';
        else $status='Offline';
  			$content.='<li class="list-group-item text-left">
  			<div class="row">
  			<span class="col  text-center"><b>'.$sno.'</b></span>
  			<span class="col">'.$key['ADMIN_ID'].'</span>
  			<span class="col">'.$key['NAME'].'</span>
  			<span class="col">'.$key['ROLE_ID'].'</span>
  			<span class="col">'.$key['LAST_LOGIN_IP'].'</span>
			  <span class="col" id="user_status"'.$admid.'>'.$status.'</span>
  			<span class="col">
  				<button onclick="editStaff('.$admid.')" class="btn-manage"><i class="col-sm btn fas fa-edit"></i></button>
  				<button onClick="toggleStaff('.$admid.')" class="btn-manage"><i class="col-sm btn fas fa-times"></i></button>
  				<button onClick="deleteStaff('.$admid.')" class="btn-manage"><i class="col-sm btn fas fa-trash"></i></a></button>
  			</span>
  			</div>
  			</li>'; 
  		}
  			$content.='</ul>';

        */

          $sno=0;
      foreach ($data as $key) {
        $sno++;
		$admid="'".$key['ADMIN_ID']."'";
		$userstatusid="user_status_".$key['ADMIN_ID'];
 
        $content.='<div class="col-md-4">
          <div class="row m-2 profile_card animate__animated animate__jello">

            <div class="col p-3">

            <span class="row">
              <img src="'.$key['PHOTO'].'" style="width: 75px;height: 75px">
              </span>
            </div>
            <div class="col p-3">
              <span class="row">'.$key['NAME'].'</span>
              <span class="row">'.$key['ADMIN_ID'].'</span>
              <span class="row">'.$key['ROLE_ID'].'</span>
			  <span class="row" id='.$userstatusid.'></span>
            </div>
            <div class="col p-3">
            <span>
                  <button onclick="editStaff('.$admid.')" class="btn-manage"><i class="col-sm btn fas fa-edit"></i></button>
                  </span>
                  <span>
                  <button onClick="toggleStaff('.$admid.')" class="btn-manage"><i class="col-sm btn fas fa-times"></i></button>
                  </span>
                  <span>
                    <button onClick="deleteStaff('.$admid.')" class="btn-manage"><i class="col-sm btn fas fa-trash"></i></a></button>
                    </span>
              </div>
          </div>
        </div>
        ';
        
      }
		  }
	$res['data']=$data;
	$res['content']=$content;
  		echo json_encode($res);
}

public function deleteStaff($staffid)
  {
  $this->db->where('ADMIN_ID', $staffid);
  $query= $this->db->delete('TAB_ADMIN');
  if($query)
      echo "Success";
  else
      echo "Fail";
  }

  public function getFirebaseConfig()
  {
	  $file_path = base_url().'assets/firebase_config.json';
  $firebase_config=file_get_contents($file_path);
  return $firebase_config;
  }
}