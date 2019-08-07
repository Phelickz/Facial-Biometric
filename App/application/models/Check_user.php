<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Check_user extends CI_Model { 


       // check token login 
public function CheckUser(){
	$session_checkData = array(
			'store_vid' => $this->session->userdata('store_vid'),
			'personal_info_id' => $this->session->userdata('personal_info_id'),
			'token' => $this->session->userdata('token'),
			 'email' => $this->session->userdata('email'),
			 'active' => '1',
			 );	
			 
$this->load->model('Auth_model');
 $query=$this->Auth_model->LoginCheck_($session_checkData);
	
    if( $query == TRUE){
	//redirect('', 'refresh');
   }else{
		  $this->session->set_flashdata('error', 'You have been logged out because your account is logged in elsewhere ');	 
			// redirect("Login",'refresh');
			redirect('Auth/login', 'refresh');
		 }
	}
	
	// check login 
function _is_logged_in(){
        $is_logged_in=$this->session->userdata("logged_in");
        if(!isset($is_logged_in) || $is_logged_in != TRUE){
			$this->session->set_flashdata('error', ' Login to continue...');	 
            redirect("Auth/login",'refresh');
			//$this->load->view('Login'); 
        }
    }
	
	
	       
	
	//generate password
	public function Unique_random_number($maxlength )
	{
    $chary = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",
                    "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
                    "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
    $return_str = "";
    for ( $x=0; $x<=$maxlength; $x++ ) 
	{
        $return_str .= $chary[rand(0, count($chary)-1)];
    }
    return $return_str;
	}
	
	//generate Invoice
	public function random_invo_number($maxlength )
	{
    $chary = array( "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",  );
    $return_str = "";
    for ( $x=0; $x<=$maxlength; $x++ ) 
	{
        $return_str .= $chary[rand(0, count($chary)-1)];
    }
    return $return_str;
	}
	//10 RANDOM NUMBER
	public function random_number()
	{
		$num = rand(1,100000) ;
		$num2 = rand(10,90000) ;
		$num3 = rand() ;
        $m=$num*$num2+$num3;
	    $pin=substr($m,1,11);
		return 'X'.$pin;
		
	}
	
	

	
}
?>