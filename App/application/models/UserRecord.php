<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserRecord extends CI_Model { 

public function DisplayAllNum_($db,$data,$order_id){
$this->db->select("*");
$this->db->from($db);
$this->db->where($data);
$this->db->order_by($order_id, "desc");
$query=$this->db->get();
return $query->num_rows();
}
public function DisplayDAYAllNum_($db,$data,$order_id){
$this->db->select("*");
$this->db->from($db);
$this->db->where($data);
$this->db->where('DAY(date_log) = DAY("CURRENT_DATE()")');
$this->db->order_by($order_id, "desc");
$query=$this->db->get();
return $query->num_rows();
}


//Display Day All
public function DisplayAll_($db,$data,$order_id,$days){
 $pmy = $days;
$this->db->select('DATE_FORMAT(date_log, "%b %d") AS date ,COUNT(status) AS status');
$this->db->from($db);
$this->db->where($data);
//$this->db->where('DAY(date_log)',$pmy);
$this->db->where('date_log BETWEEN DATE_SUB(NOW(), INTERVAL '.$pmy.' DAY) AND NOW()');
$this->db->order_by($order_id, "Asc");
$this->db->group_by('DAY(date_log)');
$query=$this->db->get();
return $query->result_array();
}

//Display  Month All
public function MonthDisplayAll_($db,$data,$order_id){
$this->db->select('DATE_FORMAT(date_log, "%M") AS date ,COUNT(status) AS status');
$this->db->from($db);
$this->db->where($data);
$this->db->order_by($order_id, "Asc");
$this->db->group_by('MONTH(date_log)');
$query=$this->db->get();

return $query->result_array();
}



  public function TotalBio_OP($status,$keyUD)
  {

 $userID_data = array(
          'KeyID'=> $keyUD,
              'status' =>$status
              
             );

      $data = $this->DisplayAllNum_('bio_score_log',$userID_data,'Score_id');
       

return $data; 
  }

///calculate Api
  public function ApiCall($trans_type,$keyUD)
  {

     $userID_data = array(
      'api_key'=> $keyUD,
  'response_code'=>$trans_type
  
             );
     
     $data = $this->DisplayAllNum_('logs',$userID_data,'id');
      return $data; 
  }


//dAILY 


public function DAYBio_OP($status,$keyUD)
  {

 $userID_data = array(
             'KeyID'=> $keyUD,
              'status' =>$status
              
             );

      $data = $this->DisplayDAYAllNum_('bio_score_log',$userID_data,'Score_id');
       

return $data; 
  }

//Graphic Daily Display

    public function GraphicBio_OP($status,$days,$keyUD)
  {

 $userID_data = array(
        'KeyID'=> $keyUD,
              'status' =>$status
              
             );

      $data = $this->DisplayAll_('bio_score_log',$userID_data,'Score_id',$days);
       

return $data; 
  }

	//Graphic Monthly Display

    public function BGraphicMonthly($status,$keyUD)
  {

 $userID_data = array(
             'KeyID'=> $keyUD,
              'status' =>$status
             
             );

      $data = $this->MonthDisplayAll_('bio_score_log',$userID_data,'Score_id');
       

return $data; 
  }
}
?>