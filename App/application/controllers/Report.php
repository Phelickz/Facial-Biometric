<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class report extends CI_Controller {

public function __construct() {
parent::__construct();
$this->load->model('Check_user');
$this->Check_user->_is_logged_in();//CHECK SESSION LOGIN
$this->load->model('Menu_model');
$this->load->model('Auth_model');
$this->load->model('Homepage_model');
$this->load->model('Record');

}


	public function index()
	{
		
  $userID_data2 = array(
     'status'=>1       

             );
 
        $data2 = $this->Homepage_model->DisplayAll_('bio_score_log',$userID_data2,'Score_id');

  $data['data2']=$data2;
   $this->load->view('web/blank',$data);

	}

	
public function ApiLog()
  {

    $this->load->view('web/Apilog');
  }

  public function BioLog()
  {
    $this->load->view('web/Biolog');
  }
 public function UserBioLog()
  {
    $this->load->view('web/UserBiolog');
  }

//API FUNCTION TO GET API DATA
  public function getApiLog(){
   $userID_data2 = array(
            

             );
 
        $data = $this->Homepage_model->DisplayAll_('logs',$userID_data2,'id');
        $this->output->set_output(json_encode($data));
}
 


//API FUNCTION TO GET BIO DATA
  public function getBioLog(){
     $dataAngular  = json_decode(file_get_contents("php://input"));
        $status= $dataAngular->status;
   $userID_data2 = array(
     'status'=>$status       

             );
 
        $data = $this->Homepage_model->DisplayAll_Limt('bio_score_log',$userID_data2,'Score_id');
        $this->output->set_output(json_encode($data));
}


//API FUNCTION TO GET USER BIO DATA
   public function getUserBioLog(){
    $userID_data = array(
      'store_vid'=>$this->session->userdata('store_vid'),
   );
    $keyD= $this->Homepage_model->DisplayAll_('keys',$userID_data,'id');

foreach ($keyD as $keyV) {
 $keyUD=$keyV['KeyID'];
}

$dataAngular  = json_decode(file_get_contents("php://input"));
     $status= $dataAngular->status;
     if($status==2){
      $userID_data2x = array(
       'KeyID'=> $keyUD,
       'status'=>0,

            );
   $data = $this->Homepage_model->DisplayAll_Having('bio_score_log',$userID_data2x,'Score_id');
  $this->output->set_output(json_encode($data));

     }else{

      $userID_data2 = array(
       'KeyID'=> $keyUD,
       'status'=>$status  

            );

  $data = $this->Homepage_model->DisplayAll_Limt('bio_score_log',$userID_data2,'Score_id');
  $this->output->set_output(json_encode($data));
}


}
//detail log
  public function DBioLog($Score_id){
   $userID_data2 = array(
        'Score_id'=>$Score_id    

             );
 
        $dataDD = $this->Homepage_model->DisplayAll_('bio_score_log',$userID_data2,'Score_id');
        //$this->output->set_output(json_encode($data));
       
         $data['dataDD'] = $dataDD;
         $this->load->view('web/R_Photo',$data);

        
}
  

 //DELETE API LOG////
    public function Log_Delete() 
  {   
   $data  = json_decode(file_get_contents("php://input"));
     $id= $data->id;
        $data2 = array(
            'id' => $id
            );
        $dataq = $this->Homepage_model->Del_Data_('logs',$data2);
      if ( $dataq==1) {
        echo 'Your Action Was Successfully...';
      } else 
    {
        echo 'Failed';
       }  
    }


  }