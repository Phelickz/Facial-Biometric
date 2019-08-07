<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class settingpage extends CI_Controller {

public function __construct() {
parent::__construct();
$this->load->model('Check_user');
$this->Check_user->_is_logged_in();//CHECK SESSION LOGIN
$this->load->model('Menu_model');
$this->load->model('Auth_model');
$this->load->model('Homepage_model');
}

public function blank(){
  $this->load->view('blank');
}
	public function index()
	{
		$this->load->view('Dashboard');
	}



///*********************************************************COMPANY*****************************

    public function get_MyCompany()
  {
     $userID_data = array(
      
       );
         $data = $this->Homepage_model->DisplayAll_('in_store',$userID_data,'in_store_id');
        $this->output->set_output(json_encode($data));
     
     //$this->output->set_content_type('application/json')->set_output(json_encode($data));
    
    }

////////////////////////////
 public function compProfile()
{
//update
  $dataAngular  = json_decode(file_get_contents("php://input"));
       
        $store_name= $dataAngular->store_name;
        $in_phone= $dataAngular->in_phone;
        $in_email= $dataAngular->in_email;
        $address= $dataAngular->address;
        $btn_name= $dataAngular->btnName;
        $store_vid=$this->Check_user->random_number();
        $store_sub_id=$this->Check_user->Unique_random_number(11);
          $userCD_data = array(
            'store_vid' => $store_vid,
            'store_sub_id'=>'X'.$store_sub_id,
            'personal_info_id' => $this->session->userdata('personal_info_id'),
             'store_name' => $store_name,
            'in_phone' => $in_phone,
            'in_email' => $in_email,
            'address' => $address,
             );
           $userID_data = array(
            'personal_info_id' => $this->session->userdata('personal_info_id'),
             'store_name' => $store_name,
            'in_phone' => $in_phone,
            'in_email' => $in_email,
            'address' => $address,
             );
        $user_select = array(
             'store_name' => $store_name,
            'in_phone' => $in_phone,
            'in_email' => $in_email,
            'address' => $address,
             );

 //Create
     if ($btn_name == "Add") {
       $duplcate = $this->Homepage_model->DisplayAll_('in_store',$user_select,'in_store_id');

        if($duplcate){
        echo  " Aready In Use";
        }else{
      $data = $this->Homepage_model->insertData_('in_store',$userCD_data);
      echo  "Your Action Was Successful";
    }
       
}else{
   $in_store_id= $dataAngular->in_store_id;
         $data2 = array(
            'in_store_id' => $in_store_id
            );
 $editUp =  $this->Homepage_model->update_Data($data2,$userID_data,'in_store');

 if($editUp){
        echo  "Your Action Was Successful";
        }else{
      echo  "Fail to update";
         }
}

}


  //Delete ////
    public function store_Delete() 
  {   
   $data  = json_decode(file_get_contents("php://input"));
     $in_store_id= $data->in_store_id;
        $data2 = array(
            'in_store_id' => $in_store_id
            );
        $dataq = $this->Homepage_model->Del_Data_('in_store',$data2);
      if ( $dataq==1) {
        echo 'Your Action Was Successfully...';
      } else 
    {
        echo 'Failed';
       }  
    }

  }