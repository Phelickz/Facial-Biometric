<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
 public function __construct() {
parent::__construct();
$this->load->model('Auth_model');
$this->load->model('Homepage_model');

}
	
	public function test()
	{
		$data = array
		  (
         'email' => "aws@appmartgroup.com",
		 'password' => "12345",
		 'active' => 1,
		 );
		$query=$this->Auth_model->Login_($data);
		$this->output->set_content_type('application/json')->set_output(json_encode($query));
	}
	
	
	public function login()
	{
	$this->load->view('web/login');
    }
public function index()
	{
    $this->load->view('web/login');
	}

	
public function SLogin(){
		/* Load form helper */ 
	
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		//$this->form_validation->set_rules('store', 'store', 'required');

		
		// Validate Operation
		 if ($this->form_validation->run() == FALSE) { 
          $this->load->view('web/login');
         } 
         else { 
		  $data = array
		  (
         'email' => $this->input->post('email'),
		 'password' => $this->input->post('password'),
		 'active' => 1,
		 );
		  $query=$this->Auth_model->Login_($data);
		
		 // $query2=$this->Auth_model->UpdateUser_($query_array, $data);
		  if( $query!= false){
			  $session_data = array(
             'email' => $query[0]->email,
			 'institution_id' => $query[0]->institution_id,
			 'store_vid' => $query[0]->store_vid,
			 'name' => $query[0]->name,
			 'phone' => $query[0]->phone,
			 'personal_info_id' => $query[0]->personal_info_id,
			 'sub_store_vid' => $query[0]->sub_store_vid,
			 'store_name' => $query[0]->store_name,
			 'partition_id' => $query[0]->partition_id,
			 'logged_in'=>TRUE,
             );
			 
			
			 $userID_data = array(
			'store_vid' => $query[0]->store_vid,
			'personal_info_id' => $query[0]->personal_info_id,
			 );
			 $update_data = array(
			 'first_login' => $query[0]->first_login+1,
			 );
		 
		  $this->Auth_model->UpdateUser_($userID_data, $update_data);//Update number of succesfull login
		  $this->session->set_userdata($session_data);
		  $this->session->set_flashdata('success', 'Login sucessful...');
		  redirect('Homepage', 'refresh');
		 
;		 }else{
		  $this->session->set_flashdata('error', 'Incorrect Login Details!!Contact Your Institution  To Confirm Your Outlet Login ');	 
			$this->load->view('web/login'); 
		 }
		 
         } 
		
	}
	
		// Logout from admin page
public function logout() {

// Removing session data
$sess_array = array(
'personal_info_id' => '',
'store_vid' => '',
);
$this->session->unset_userdata('logged_in', $sess_array);
$this->session->set_flashdata('error', 'You Have Successfully Logout ');	 
$this->load->view('web/login'); 
}

	
}




