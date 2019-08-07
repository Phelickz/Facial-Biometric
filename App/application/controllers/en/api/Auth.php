<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

//include Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Auth extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        
        //load user model
        $this->load->model('Auth_model');
    }

 //Token generate - start capture
 public function Token_post(){
	 $random=$this->activation_code('8');
	 $key=$this->post('key');
	 $ReturnUrl=$this->post('ReturnUrl');
	 $ErrorUrl=$this->post('ErrorUrl');
	 $data = array(
	   'key' => $key,
	   );
	$query=$this->Auth_model->Apikeyogin_($data);   
	$classID = $random;
	$executions = "3";
	$livedetection="false";
	$task=$query[0]->task;
	$AppID=$query[0]->AppID;
	$AppKey=$query[0]->AppKey;
	$patition=$query[0]->partition;
	$trait=$query[0]->trait;
	$recordings=$query[0]->recordings;
	$task2 =$query[0]->task;
	$KeyID=$query[0]->KeyID;
	
 if(!empty($task) && !empty($classID) && !empty($AppID) && !empty($AppKey) && !empty($patition) && !empty($livedetection)&& !empty($ErrorUrl)){
$url = 'https://bws.bioid.com/extension/token?id='.$AppID.'&bcid=bws.'.$patition.'.'.$classID.'&task='.$task.'&'.$livedetection.'';


$request_headers[] = 'Authorization: Basic '.base64_encode(''.$AppID.''.':'.''.$AppKey.'');
$request_headers[] = 'Connection: Keep-Alive';
$curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 3000,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $request_headers,
        ));
        $result = curl_exec($curl);
        $httpcode = curl_getinfo($curl);
         //return $result;
		$token=$result;
		$data = array(
        'token' => $token,
        'task' => $task,
        'trait' => $trait,
		'executions' => $executions,
		'recordings' => $recordings,
		'task2' => $task2,
		'classID' => $classID,
		'ReturnUrl'=> $ReturnUrl,
		'KeyID'=> $KeyID,
		'ErrorUrl'=>$ErrorUrl
        );
        $done=$this->load->view('index',$data);
         curl_close($curl);
		 
		
 }else{
         //set the response and exit
         $this->response("Missing parameter!!!.", REST_Controller::HTTP_BAD_REQUEST);
	 
 }
 }
 
 
 
//Activationcode
public function activation_code($maxlength )
{
$chary = array( "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",  );
$return_str = "";
for ( $x=0; $x<=$maxlength; $x++ ) 
{
	$return_str .= $chary[rand(0, count($chary)-1)];
}
return $return_str;
}




	
	
}

?>