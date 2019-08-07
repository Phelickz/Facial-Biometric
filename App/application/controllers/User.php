<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
 public function __construct() {
parent::__construct();
$this->load->model('Check_user');
$this->Check_user->_is_logged_in();//CHECK SESSION LOGIN
 
$this->load->model('Menu_model');
//$this->Menu_model->MenuList();
$this->load->model('Auth_model');
$this->load->model('Homepage_model');

}
	
	public function test(){
		//$var=$this->Unique_random_number();
		$dataquery=array(
		 'personal_info_id' => $this->session->userdata('personal_info_id'),
	
		);
		$usersG=$this->Menu_model->GroupSubMenuList($dataquery);
		$dataquery=array(
		 'personal_info_id' => $this->session->userdata('personal_info_id'),
		);
		$usersG=$this->Menu_model->GroupSubMenuList($dataquery);
		foreach($usersG  as $user){
			 $a= $user['submenu_id'];
			 $resultset[] = ($a);
		}
		
		$string = implode(",",$resultset);
echo $string;
		$this->output->set_content_type('application/json')->set_output(json_encode($usersG));
	}
	
	public function index()
	{
    $this->load->view('Dashboard');
	}
	
	//Activate Adminstration
public function m_menu()
	{
		
		$this->load->view('web/Menupage');
	}
	
  //CREATE User/Inst
  public function Inst()
  {
   $this->load->view('web/Inst_page');
  }
	//Activate  store users 
public function staff()
	{
	 $pass=$this->Check_user->Unique_random_number(7);
	 $this->session->set_userdata('Temp_Pass',$pass);
	  $this->load->view('web/userpage');
	}
	
    //Activate  store users 
public function staffMenu()
  {
   $pass=$this->Check_user->Unique_random_number(7);
   $this->session->set_userdata('Temp_Pass',$pass);
    $this->load->view('web/usermenupage');
  }
	
    //Activate  store users 
public function partition()
  {
   $pass=$this->Check_user->Unique_random_number(7);
   $this->session->set_userdata('Temp_Pass',$pass);
    $this->load->view('web/partitionpage');
  }
  
  
	
	



public function Create_User()
    {
    $dataAngular  = json_decode(file_get_contents("php://input"));
        $name= $dataAngular->name;
        $email= $dataAngular->email;
         $phone= $dataAngular->phone;
          $password= $dataAngular->password;
          $btn_name= $dataAngular->btnName;
        
   

         $userID_data = array(
          'store_vid' =>0,
         'name' => $name,
         'phone' => $phone,
         'email' => $email,
		 'temp_password' =>$password,
		 'password' => $password,
		 'enter_by' => $this->session->userdata('personal_info_id'),
		 'account_type' => 'A1',
             );
  
  $user_select = array(
             
            'email' => $email,
             );
  //Create
     if ($btn_name == "Add") {
       $duplcate = $this->Homepage_model->DisplayAll_('personal_info',$user_select,'personal_info_id');

        if($duplcate){
        echo  "Email Aready In Use";
        }else{
      $data = $this->Homepage_model->insertData_('personal_info',$userID_data);
      echo  "Your Action Was Successful";
         }

       }else{

//update
        $personal_info_id= $dataAngular->personal_info_id;
          $userID_dataD = array(
          'name' => $name,
         'phone' => $phone,
         'password' => $password,
		 'enter_by' => $this->session->userdata('personal_info_id'),
             );
  

         $data2 = array(
         	
            'personal_info_id' => $personal_info_id
            );
         $edit = $data = $this->Homepage_model->update_Data($data2,$userID_dataD,'personal_info');

 if($edit){
        echo  "Your Action Was Successful";
        }else{
      echo  "Fail to update";
         }
       }
     
        
    }





//create partition

public function Create_P()
    {
    $dataAngular  = json_decode(file_get_contents("php://input"));
        $task= $dataAngular->task;
        $trait= $dataAngular->trait;
         $AppID= $dataAngular->AppID;
          $AppKey= $dataAngular->AppKey;
           $partition= $dataAngular->partition;
            $rr= $dataAngular->rr;
          $btn_name= $dataAngular->btnName;
        $key=$this->Check_user->Unique_random_number(24);
        $keyID=$this->Check_user->Unique_random_number(4);

         $userID_data = array(
          'store_vid' =>0,
         'task' => $task,
         'trait' => $trait,
         'AppID' => $AppID,
         'AppKey' => $AppKey,
         'partition' => $partition,
         'recordings' =>$rr,
         'state'=>'identify',
         'key' => $key,
         'KeyID' => $keyID,
         'enter_by' => $this->session->userdata('personal_info_id'),
     
             );
         $userID_2= array(
          
         'key' => $key,
         
     
             );
  //Create
     if ($btn_name == "Create Partition") {
        $data = $this->Homepage_model->insertData_('keys',$userID_data);
        $access=$this->Homepage_model->insertData_('access',$userID_2);

        if($data){
       echo  "Your Action Was Successful"; 
        }else{
     echo  "Your Action Was Not Successful";
      
         }

       }else{

//update
        $id= $dataAngular->id;
          $userID_data_2= array(
          'store_vid' =>$this->session->userdata('store_vid'),
         'task' => $task,
         'trait' => $trait,
         'AppID' => $AppID,
         'AppKey' => $AppKey,
         'partition' => $partition,
         'recordings' =>$rr,
         'enter_by' => $this->session->userdata('personal_info_id'),
     
             );
  

         $data2 = array(
        
            'id' => $id
            );
         $edit = $data = $this->Homepage_model->update_Data($data2,$userID_data_2,'keys');

 if($edit){
        echo  "Your Action Was Successful";
        }else{
      echo  "Fail to update";
         }
       }
     
        
    }



//API FUNCTION TO GET USER DATA
  public function getUser(){
   $userID_data2 = array(
            

             );
    $action="personal_info.store_vid=in_store.store_vid";
        $data = $this->Homepage_model->PDisplayJoin_('personal_info','in_store',$userID_data2,'personal_info.personal_info_id',$action,'left');
        $this->output->set_output(json_encode($data));
}


//API FUNCTION TO GET USER DATA
  public function getPat(){
   $userID_data2 = array(
            

             );
      $action="keys.key=access.key";
      $action2="keys.store_vid=in_store.store_vid";
        $data = $this->Homepage_model->Display2Join_('keys','access','in_store',$userID_data2,'keys.id',$action,$action2,'left','left');
        $this->output->set_output(json_encode($data));
}



//activate key
public function Approve_key() // 
  {   
   $data = json_decode(file_get_contents("php://input")); 
      $key = $data->key;
        $data = array(
        'all_access' =>1
        );
        $data2 = array(

            'key' => $key
            );
        $dataq = $this->Homepage_model->update_Data($data2,$data,'access');
       
      if ( $dataq==1) {
        echo 'Activation was Successfully...';
      } else 
    {
        echo 'Failed';
       }
        
    }


//Deactivate key
public function DApprove_key() // 
  {   
   $data = json_decode(file_get_contents("php://input")); 
      $key = $data->key;
        $data = array(
        'all_access' =>0
        );
        $data2 = array(
          
            'key' => $key
            );
        $dataq = $this->Homepage_model->update_Data($data2,$data,'access');
       
      if ( $dataq==1) {
        echo 'Deactivation was Successfully...';
      } else 
    {
        echo 'Failed';
       }
        
    }



  //DELETE key////
    public function key_Delete() 
  {   
   $data  = json_decode(file_get_contents("php://input"));
     $key= $data->key;
        $data2 = array(
            'key' => $key
            );
        $this->Homepage_model->Del_Data_('access',$data2);
        $dataq = $this->Homepage_model->Del_Data_('keys',$data2);
      if ( $dataq==1) {
        echo 'Your Action Was Successfully...';
      } else 
    {
        echo 'Failed';
       }  
    }




    //DELETE Category////
    public function user_Delete() 
  {   
   $data  = json_decode(file_get_contents("php://input"));
     $personal_info_id= $data->personal_info_id;
        $data2 = array(
            'personal_info_id' => $personal_info_id
            );
        $dataq = $this->Homepage_model->Del_Data_('personal_info',$data2);
      if ( $dataq==1) {
        echo 'Your Action Was Successfully...';
      } else 
    {
        echo 'Failed';
       }  
    }



public function Approve_User() // Activate user
	{   
   $data = json_decode(file_get_contents("php://input"));	
	    $personal_info_id = $data->personal_info_id;
        $data = array(
        'approve_on' => date("Y-m-d"),
        'approve_by' => 'A1',
        'active' => '1'
        );
        $data2 = array(
         	
            'personal_info_id' => $personal_info_id
            );
        $dataq = $this->Homepage_model->update_Data($data2,$data,'personal_info');
        $dataq = $this->Homepage_model->update_Data($data2,$data,'personal_info');
	    if ( $dataq==1) {
        echo 'Approval Successfully...';
      } else 
	  {
        echo 'Failed';
       }
        
    }



	
	
	public function D_Approve_User()// Deactivate user
	{     
	 $data = json_decode(file_get_contents("php://input"));	 
	    $personal_info_id = $data->personal_info_id;
        $data = array(
        'approve_on' => date("Y-m-d"),
        'approve_by' => 'A1',
        'active' => '0'
        );
        $data2 = array(

            'personal_info_id' => $personal_info_id
            );
        $dataq = $this->Homepage_model->update_Data($data2,$data,'personal_info');
	    if ( $dataq==1) {
        echo 'Deactivation Successfully...';
      } else 
	  {
        echo 'Failed';
       }
        
    }
	
	
//ASSIGN INST
public function Inst_Ass() // 
  {   
   $data = json_decode(file_get_contents("php://input")); 
      $personal_info_id = $data->personal_info_id;
      $store_vid = $data->store_vid;
        $data = array(
        'store_vid' =>$store_vid
        );
         $userID_data = array(
        'store_vid' =>$store_vid,
        'personal_info_id' => $personal_info_id
        );
        $data2 = array(
     'personal_info_id' => $personal_info_id
            );
        $dataq = $this->Homepage_model->update_Data($data2,$data,'personal_info');
        

      if ( $dataq==1) {
        $duplcate = $this->Homepage_model->DisplayAll_('store_login',$userID_data,'store_login_id');
        if($duplcate){
$this->Homepage_model->update_Data($data2,$data,'store_login');
        }else{
  $this->Homepage_model->insertData_('store_login',$userID_data);
        }
        echo 'Your Action was Successfully...';
      } else 
    {
        echo 'Failed';
       }
        
    }



//ASSIGN INST KEY
public function Inst_key_Ass() // 
  {   
   $data = json_decode(file_get_contents("php://input")); 
      $key = $data->key;
      $store_vid = $data->store_vid;
        $data = array(
        'store_vid' =>$store_vid
        );
         $userID_data = array(
        'store_vid' =>$store_vid,
        'key' => $key
        );
        $data2 = array(
     'key' => $key
            );
        $dataq = $this->Homepage_model->update_Data($data2,$data,'keys');
        

      if ( $dataq==1) {

        echo 'Your Action was Successfully...';
      } else 
    {
        echo 'Failed';
       }
        
    }









	//API FUNCTION TO GET MENU DATA
	public function get_Menu(){

	$menu=$this->Menu_model->AllMenu_();
    $this->output->set_output(json_encode($menu));
   
	}

		//API FUNCTION TO GET MENU DATA
	public function get_SubMenu(){
         $userID_data2 = array(
            'status'=> '1'

             );
   
        $data = $this->Homepage_model->DisplayAll_('submenu',$userID_data2,'submenu_id');
        $this->output->set_output(json_encode($data));
}
   

		
	//////////////////////////////////////////////////////
//create Room
   public function Menu_Item()
    {
    $dataAngular  = json_decode(file_get_contents("php://input"));
        $personal_info_id= $dataAngular->personal_info_id;
        $item= $dataAngular->item;
       
 
        
foreach($item as $Datax){

    $submenu_id = $Datax->submenu_id;
    $parent_id = $Datax->parent_id;

        $user_select = array(
             'store_vid' => $this->session->userdata('store_vid'),
              'personal_info_id' => $personal_info_id,
              'submenu_id' => $submenu_id,
             'parent_id'=>$parent_id
             );
         $userID_data = array(
            'store_vid' => $this->session->userdata('store_vid'),
            'personal_info_id' => $personal_info_id,
            'submenu_id' => $submenu_id,
            'status'=>'1',
            'parent_id'=>$parent_id
             );
$duplcate = $this->Homepage_model->DisplayAll_('in_user_menu',$user_select,'in_user_menu_id');   

if($duplcate){
      $data=1;
        }else{
$data = $this->Homepage_model->insertData_('in_user_menu',$userID_data);
       }
}

if($data){
        echo  "Your Action Was Successful";
        }else{
      echo  "Fail to update";
   }
}

	

	
      //Sellect Menu////
    public function UserGetMenu() 
  {   
   $data  = json_decode(file_get_contents("php://input"));
     $personal_info_id= $data->personal_info_id;
        $data2 = array(
            'personal_info_id' => $personal_info_id
            );
        $userID_data = array(
      'in_user_menu.store_vid' => $this->session->userdata('store_vid'),
      'in_user_menu.personal_info_id'=>$personal_info_id,
      'in_user_menu.status'=>'1',


       );
     $action="in_user_menu.submenu_id=submenu.submenu_id";
        $data = $this->Homepage_model->DisplayJoin_('in_user_menu','submenu',$userID_data,'in_user_menu_id',$action,'left');
         $this->output->set_output(json_encode($data));
  }



    //DELETEUSER mNEU////
    public function MenuUser_Delete() 
  {   
   $data  = json_decode(file_get_contents("php://input"));
     $in_user_menu_id= $data->in_user_menu_id;
        $data2 = array(
            'in_user_menu_id' => $in_user_menu_id
            );
        $dataq = $this->Homepage_model->Del_Data_('in_user_menu',$data2);
      if ( $dataq==1) {
        echo 'Your Action Was Successfully...';
      } else 
    {
        echo 'Failed';
       }  
    }

	////////////////password//////////////////////////

	public function password(){
		 $this->load->view('web/passwd');
	}

	public function Passwd() {
$this->form_validation->set_rules('password', 'Password', 'required');
$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');
	// Validate Operation
		 if ($this->form_validation->run() == FALSE) { 
          $this->load->view('web/passwd');
         } 
         else { 
$data = array
		  (
          'password' => $this->input->post('password')
	
		 );
  
		 $dataA = array
		  (
         'store_vid' => $this->session->userdata('store_vid'),
		 'personal_info_id' => $this->session->userdata('personal_info_id'),
		 
		 
		 );
	$query=$this->Homepage_model->update_Data($dataA,$data,'personal_info');
	   if($query==1){
		  
		  $this->session->set_flashdata('success','Your Password was Change Successfully Login !!   ');
		redirect("Auth/Login", 'refresh' );
	   }else{
		$this->session->set_flashdata('error','Unable to Change Password   ');
		redirect("User/Password", 'refresh' );
		}

  }	
}
	
	
	
}



