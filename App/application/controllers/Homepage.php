<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class homepage extends CI_Controller {

public function __construct() {
parent::__construct();
$this->load->model('Check_user');
$this->Check_user->_is_logged_in();//CHECK SESSION LOGIN
$this->load->model('Menu_model');
$this->load->model('Auth_model');
$this->load->model('Homepage_model');
$this->load->model('Record');
$this->load->model('UserRecord');
}



	public function index()
	{
      $userID_data = array(
      'store_vid'=>$this->session->userdata('store_vid'),
   );
    $keyD= $this->Homepage_model->DisplayAll_('keys',$userID_data,'id');
    if(empty($keyD)){
      $this->session->set_flashdata('error', 'Unable to Navigate. Create partition for Institution to enable Navigaton  ');
          redirect("User/Inst", 'refresh');
    }else{

foreach ($keyD as $keyV) {
 $keyUD=$keyV['KeyID'];
 $keyZ=$keyV['key'];
}

    $enroll= $this->UserRecord->TotalBio_OP(1,$keyUD);
    $iden=$this->UserRecord->TotalBio_OP(0,$keyUD);
    $Denroll= $this->UserRecord->DAYBio_OP(1,$keyUD);
    $Diden=$this->UserRecord->DAYBio_OP(0,$keyUD);
    $Api_s=$this->UserRecord->ApiCall(0,$keyZ);

    
    
     $data['enroll'] = $enroll;
     $data['iden'] = $iden;
     $data['Denroll'] = $Denroll;
     $data['Diden'] = $Diden;
     $data['Api_s'] = $Api_s;
   
///chart//
     $GPenroll= $this->UserRecord->GraphicBio_OP(1,8,$keyUD);
     $GPiden= $this->UserRecord->GraphicBio_OP(0,8,$keyUD);
     $data['GPenroll'] = $GPenroll;
     $data['GPiden'] = $GPiden;
  //monthly//
   $Menroll= $this->UserRecord->BGraphicMonthly(1,$keyUD);
   $Miden= $this->UserRecord->BGraphicMonthly(0,$keyUD);
    $data['Menroll'] = $Menroll;
    $data['Miden'] = $Miden;
		$this->load->view('web/Dashboard',$data);
	}
}



	public function user_token()
	{
		$this->load->view('web/user');
	}


  public function AdminDash()
  {
    $enroll= $this->Record->TotalBio_OP(1);
    $iden=$this->Record->TotalBio_OP(0);
    $Denroll= $this->Record->DAYBio_OP(1);
    $Diden=$this->Record->DAYBio_OP(0);
    $Api_s=$this->Record->ApiCall(0);
    $Inst=$this->Record->Inst();
    
    
     $data['enroll'] = $enroll;
     $data['iden'] = $iden;
     $data['Denroll'] = $Denroll;
     $data['Diden'] = $Diden;
     $data['Api_s'] = $Api_s;
     $data['Inst'] = $Inst;
///chart//
     $GPenroll= $this->Record->GraphicBio_OP(1,8);
     $GPiden= $this->Record->GraphicBio_OP(0,8);
     $data['GPenroll'] = $GPenroll;
     $data['GPiden'] = $GPiden;
  //monthly//
   $Menroll= $this->Record->BGraphicMonthly(1);
   $Miden= $this->Record->BGraphicMonthly(0);
    $data['Menroll'] = $Menroll;
    $data['Miden'] = $Miden;
    $this->load->view('web/Dashboardpage',$data);

  }
	
//Create slider
    public function Create_User()
    {
         $userID_data = array(
            'first_name' => $this->input->post('fname'),
            'last_name' => $this->input->post('lname'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
             );

        $data = $this->Homepage_model->insertData_('users',$userID_data);
        if($data){

      $this->session->set_flashdata('success', 'User Created !!');
      redirect('Homepage/user_token', 'refresh');
        }else{
      $this->session->set_flashdata('error', 'Unable to  Create  User !!');
      redirect('Homepage/user_token', 'refresh');

        }
     
        
    }

//API FUNCTION TO GET MEDIA DATA
    public function get_User()
	{
		 $userID_data = array(
			
			 );
        $data = $this->Homepage_model->DisplayAll_('users',$userID_data,'id');
        $this->output->set_output(json_encode($data));
     //$this->output->set_content_type('application/json')->set_output(json_encode($data));
		
    }



//Update Action////
        public function Users_Update() 
    {   
   $data  = json_decode(file_get_contents("php://input"));
        $id= $data->id;
        $data2 = array(
            'id' => $id
            );
        $data_array=array(
       'status' => 1,
);
        //$itemD=json_encode($in_cate_id);
        $dataq = $this->Homepage_model->update_Data($data2,$data_array,'users');
        if ( $dataq==1) {
        echo 'Your Action Was Successfully...';
      } else 
      {
        echo 'Failed';
       }  
    }
    



//DELETE Media////
		public function Users_Delete() 
	{   
   $data  = json_decode(file_get_contents("php://input"));
	   $id= $data->id;
        $data2 = array(
            'id' => $id
            );
        $dataq = $this->Homepage_model->Del_Data_('users',$data2);
	    if ( $dataq==1) {
        echo 'Your Action Was Successfully...';
      } else 
	  {
        echo 'Failed';
       }  
    }

 //Instt Naviga 
    public function Navg($store_vid)
  {
   
      $userID_data2 = array(
            
        'in_store.store_vid' => $store_vid,
             );
      $action="keys.key=access.key";
      $action2="keys.store_vid=in_store.store_vid";
     $store = $this->Homepage_model->Display2Join_('keys','access','in_store',$userID_data2,'keys.id',$action,$action2,'left','left');

     foreach ( $store as  $storek ) {
       $store_vidN=$storek['store_vid'];
       $store_name=$storek['store_name'];
       $partition_idd=$storek['partition'];
     }
     $session_data = array(
       'store_vid' => $store_vidN,
       'store_name' => $store_name,
       'partition_id'=>$partition_idd
             );
     if(isset($store)){
     $this->session->unset_userdata('store_vid');
     $this->session->unset_userdata('store_name');
     $this->session->unset_userdata('partition');
      $this->session->set_userdata($session_data);
       
        }
  $this->session->set_flashdata('success', "You have succesfully Navigate to ".$this->session->userdata("store_name")."PP ".$this->session->userdata("partition")." ");
     redirect('Homepage','refresh');
   
  } 


}
