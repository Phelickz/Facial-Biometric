<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Push extends CI_Controller {
     public function __construct() {
parent::__construct();
$this->load->model('Homepage_model');

}	
	
   
	public function index()
	{
    ECHO  'Biometric Api Call';
	}

	public function auth(){
	 ECHO  'Biometric Api Call-2';
	}

    public function BioApp(){
	 $this->load->view('startBio');
	}
	public function returnApp(){
	 $this->load->view('return');
	}
	public function getApp(){
	 $this->load->view('get');
	}

public function BiometricDone(){
	 $this->load->view('success');
	}

	public function BiometricAppID(){
	 $this->load->view('land');
	}

// Push ImageID & DataURL to User

 public function image_call_upload()
    {
		$filename =$this->input->post('ClassID');
		$ReturnUrl =$this->input->post('url');
		$ApiID =$this->input->post('KeyID');
		$UserID =$this->input->post('UserID');
		$partition =$this->input->post('partition');
		$uploadedfile =$this->input->post('DataURL');
       
        
		$path=$_SERVER['DOCUMENT_ROOT'].'/upload/'.$partition.''.$filename . '1.png';
        if (exif_imagetype($path) == IMAGETYPE_PNG) {
    
		    $newpng = $_SERVER['DOCUMENT_ROOT'].'/upload/'.$partition.''.$filename . '1.png';
		    $png = imagepng(imagecreatefrompng($path), $newpng);
		    }elseif(exif_imagetype($path) ==  IMAGETYPE_GIF) 
		    {
		         $newpng = $_SERVER['DOCUMENT_ROOT'].'/upload/'.$partition.''.$filename . '1.png';
		        $png = imagepng(imagecreatefromgif($path), $newpng);
		    }
		    elseif(exif_imagetype($path) ==  IMAGETYPE_JPEG) 
		    {
		          $newpng = $_SERVER['DOCUMENT_ROOT'].'/upload/'.$partition.''.$filename . '1.png';
		        $png = imagepng(imagecreatefromjpeg($path), $newpng);
		    }
		    else //already png
		    {
		            $newpng = $_SERVER['DOCUMENT_ROOT'].'/upload/'.$partition.''.$filename . '1.png';
		    }    

		  $name=urlencode('https://aws.appmartgroup.com/upload/'.$partition.''.$filename . '1.png');
		 if($name){
			redirect(''.$ReturnUrl.'?DataURL='.$name.'&ImageID='.urlencode($filename).'&UserID='.urlencode($UserID).'&status=200', 'refresh');
		}ELSE{
			redirect(''.$ReturnUrl.'?DataURL='.$name.'&ImageID='.urlencode($filename).'&UserID='.urlencode($UserID).'&status=404', 'refresh');
		}
		
    }	
	
	
public function identffy_call_push()
    {
		$filename =$this->input->post('classD');
		$ApiID =$this->input->post('KeyID');
		$ReturnUrl =$this->input->post('url');
// 		$UserID =$this->input->post('UserID');
		$partition =$this->input->post('partition');

		$path=$_SERVER['DOCUMENT_ROOT'].'/upload/'.$partition.''.$filename . '1.png';
        if (exif_imagetype($path) == IMAGETYPE_PNG) {
    
		    $newpng = $_SERVER['DOCUMENT_ROOT'].'/upload/'.$partition.''.$filename . '1.png';
		    $png = imagepng(imagecreatefrompng($path), $newpng);
		    }elseif(exif_imagetype($path) ==  IMAGETYPE_GIF) 
		    {
		         $newpng = $_SERVER['DOCUMENT_ROOT'].'/upload/'.$partition.''.$filename . '1.png';
		        $png = imagepng(imagecreatefromgif($path), $newpng);
		    }
		    elseif(exif_imagetype($path) ==  IMAGETYPE_JPEG) 
		    {
		          $newpng = $_SERVER['DOCUMENT_ROOT'].'/upload/'.$partition.''.$filename . '1.png';
		        $png = imagepng(imagecreatefromjpeg($path), $newpng);
		    }
		    else //already png
		    {
		            $newpng = $_SERVER['DOCUMENT_ROOT'].'/upload/'.$partition.''.$filename . '1.png';
		    }    

       //GET USER ID
		    $dataD = array('classID' => $filename,);
		    	$log=$this->Homepage_model->DisplayAll_('bio_score_log',$dataD,'Score_id');
		    //print_r($log)
		    	foreach ($log as $keyLog ) {
		    		$UserID=$keyLog ['UserID'];
		    	}
		
		$name=urlencode('https://aws.appmartgroup.com/upload/'.$partition.''.$filename . '1.png');
		//$name=urlencode('https://aws.appmartgroup.com/App/assets/enroll/Api_pull/'.$ApiID.''.$filename . '.png');
		if($filename){
			redirect(''.$ReturnUrl.'?DataURL='.$name.'&ImageID='.urlencode($filename).'&UserID='.urlencode($UserID).'&status=201', 'refresh');
		}ELSE{
			redirect(''.$ReturnUrl.'?ImageID='.urlencode($filename).'&UserID='.urlencode($UserID).'&status=404', 'refresh');
		}
    }
	
	

public function verify_call_push()
    {
		$filename =$this->input->post('classD');
		$UserID=$this->input->post('UserID');
		$ReturnUrl =$this->input->post('url');

		if($filename==1){
			redirect(''.$ReturnUrl.'?UserID='.urlencode($UserID).'&status=201', 'refresh');
		}ELSE{
			redirect(''.$ReturnUrl.'?UserID='.urlencode($UserID).'&status=404', 'refresh');
		}
    }

		
	public function bio_log_controll()
	{
     $Allclass_id= implode(",",$this->input->post('Allclass_id'));
	 $Allscore=implode(",",$this->input->post('Allscore'));
	 $defaultID=$this->input->post('defaultID');
	 $taskFD=$this->input->post('taskFD');
	 $ApiID =$this->input->post('KeyID');
	 $UserID =$this->input->post('UserID');
	 

     $sql = "INSERT INTO bio_score_log(KeyID,score,r_classID,classID,UserID,status) VALUES ('".$ApiID."','".$Allscore."','".$Allclass_id."','".$defaultID."','".$UserID."','".$taskFD."')";
     $this->db->query($sql);
      echo true;
  
	}
	
	public function bio_log_verify()
	{
     $Allclass_id= $this->input->post('Allclass_id');
	 $Allscore=$this->input->post('Allscore');
	 $defaultID=$this->input->post('defaultID');
	 $taskFD=$this->input->post('taskFD');
	 $ApiID =$this->input->post('KeyID');
	 $UserID =$this->input->post('UserID');
	 

     $sql = "INSERT INTO bio_score_log(KeyID,score,r_classID,classID,UserID,status) VALUES ('".$ApiID."','".$Allscore."','".$Allclass_id."','".$defaultID."','".$UserID."','".$taskFD."')";
     $this->db->query($sql);
      echo true;
  
	}
	// Use Acess API Call
 public function usercall(){
	   //API URL
      $url = 'https://aws.appmartgroup.com/App/idd/api/Auth/Token';
	   //$url = 'http://localhost:8080/BioApi/en/api/Auth/Token';

       //API key &  credentials
       $apiKey = '2MClBiY3XXpZxgLqIvkK5IcVx';  // API key
	   $ReturnUrl = 'https://aws.appmartgroup.com/App/service/api/push/BiometricDone';   // ReturnUrl to get DataURL and ImageID
	   $ErrorUrl = 'https://aws.appmartgroup.com/App/service/api/push/returnApp';   // ErrorUrl controll 
	   $UserID="7878783838";  // user ID to track Call
	   
	 //user information
       $userData = array(
      'key' => $apiKey,
	  'ReturnUrl' => $ReturnUrl,
	  'ErrorUrl' => $ErrorUrl,
	  'UserID' => $UserID
       );

      //create a new cURL resource
       $ch = curl_init($url);

       curl_setopt($ch, CURLOPT_TIMEOUT, 30);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
       curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . $apiKey));
	   curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $userData);

       $result = curl_exec($ch);
       echo $result;
      //close cURL resource
        curl_close($ch);
}



// identify Acess API Call
 public function userId(){
	   //API URL
      $url = 'https://aws.appmartgroup.com/App/identify/api/Auth/Token';
	   //$url = 'http://localhost:8080/BioApi/en/api/Auth/Token';

       //API key &  credentials
       $apiKey = '17H9QFNLPW1FNFMXUXOF9OKAN';  // API key
	   $ReturnUrl = 'https://aws.appmartgroup.com/App/service/api/push/BiometricDone';   // ReturnUrl to get DataURL and ImageID
	   $ErrorUrl = 'https://aws.appmartgroup.com/App/service/api/push/returnApp';   // ErrorUrl controll 
	   $UserID="7878783838";  // user ID to track Call
	   
	 //user information
       $userData = array(
      'key' => $apiKey,
	  'ReturnUrl' => $ReturnUrl,
	  'ErrorUrl' => $ErrorUrl,
	  'UserID' => $UserID
       );

      //create a new cURL resource
       $ch = curl_init($url);

       curl_setopt($ch, CURLOPT_TIMEOUT, 30);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
       curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . $apiKey));
	   curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $userData);

       $result = curl_exec($ch);
       echo $result;
      //close cURL resource
        curl_close($ch);
}

// Verify Acess API Call
 public function userverify(){
	   //API URL
      $url = 'https://aws.appmartgroup.com/App/verify/api/Auth/Token';
	   //$url = 'http://localhost:8080/BioApi/en/api/Auth/Token';

       //API key &  credentials
       $apiKey = '17H9QFNLPW1FNFMXUXOF9OKAN';  // API key
	   $ReturnUrl = 'https://aws.appmartgroup.com/App/service/api/push/BiometricDone';   // ReturnUrl to get DataURL and ImageID
	   $ErrorUrl = 'https://aws.appmartgroup.com/App/service/api/push/returnApp';   // ErrorUrl controll 
	   $UserID="7878783838";  // user ID to track Call
	   $callID="11154311544635";  // CallID to track Call
	   
	 //user information
       $userData = array(
      'key' => $apiKey,
	  'ReturnUrl' => $ReturnUrl,
	  'ErrorUrl' => $ErrorUrl,
	 'UserID' => $UserID,
	  'callID' => $callID
       );

      //create a new cURL resource
       $ch = curl_init($url);

       curl_setopt($ch, CURLOPT_TIMEOUT, 30);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
       curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . $apiKey));
	   curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $userData);

       $result = curl_exec($ch);
       echo $result;
      //close cURL resource
        curl_close($ch);
}



public function logID($maxlength){
	$this->load->model('Homepage_model');
	$chary = array( "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",  );
$return_str = "";
for ( $x=0; $x<=$maxlength; $x++ ) 
{
	$return_str .= $chary[rand(0, count($chary)-1)];
	$return_str;
}

	$dd= array(
         'classID'=>$return_str, 
             );
	$this->Homepage_model->insertData_('classid',$dd);
	$data=$this->Homepage_model->DisplayAll_('classid',$dd,'class_id');
	
		foreach($data as $key){
			$id=$key['class_id'];
			$classD=$key['classID'];
		}
	echo $id.$classD;
}





}



?>