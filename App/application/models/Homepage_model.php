<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage_model extends CI_Model {

public function insertData_($db,$data){
$query=$this->db->insert($db, $data);
return $query;

}
//Login
public function Login_($db,$data){
$this->db->select('*');
$this->db->from($db);
$this->db->where($data);
$this->db->limit(1);
$query = $this->db->get();
if ($query->num_rows() == 1) {
return $query->result();
} else {
return false;
}


}

//Display All Limit Record
public function DisplayAll_Limt($db,$data,$order_id){
$this->db->select("*");
$this->db->from($db);
$this->db->where('MONTH(date_log) = MONTH(CURRENT_DATE())');
$this->db->where($data);
$this->db->order_by($order_id, "desc");
$query=$this->db->get();
return $query->result_array();
}

//Display All Limit Record
public function DisplayAll_Having($db,$data,$order_id){
$this->db->select("*");
$this->db->from($db);
$this->db->order_by($order_id, "desc");
$this->db->where('MONTH(date_log) = MONTH(CURRENT_DATE())');
$this->db->where($data);
$this->db->like('Score',"0.8");
$this->db->or_like('Score',0.7);
$query=$this->db->get();
return $query->result_array();
}


//Display All
public function DisplayAll_($db,$data,$order_id){
$this->db->select("*");
$this->db->from($db);
$this->db->where($data);
$this->db->order_by($order_id, "desc");
$query=$this->db->get();
return $query->result_array();
}

//Display All
public function DisplayAl1_($db,$data,$order_id){
$this->db->select("*");
$this->db->from($db);
$this->db->where($data);
$this->db->limit(1);
$this->db->order_by($order_id, "desc");
$query=$this->db->get();
return $query->result_array();
}


// Update Date
function update_Data($id,$data,$db){
$this->db->where($id);
$this->db->update($db, $data);
return TRUE;
}	

//Remove Media
function Del_Data_($db,$id){
$this->db->where( $id);
$a=$this->db->delete($db);
if(isset($a)){return TRUE;}else{return FALSE;}

}



//Display JOIN
public function PDisplayJoin_($db1,$db2,$data,$id,$action,$join_type){
$this->db->select('*,personal_info.personal_info_id');
$this->db->from($db1);
$this->db->where($data);
$this->db->order_by($id, "desc");
$this->db->join($db2, $action,$join_type);
$query=$this->db->get();
return $query->result_array();

}

//Display JOIN
public function DisplayJoin_($db1,$db2,$data,$id,$action,$join_type){
$this->db->select("*");
$this->db->from($db1);
$this->db->where($data);
$this->db->order_by($id, "desc");
$this->db->join($db2, $action,$join_type);
$query=$this->db->get();
return $query->result_array();

}
//Display JOIN
public function Display2Join_($db1,$db2,$db3,$data,$id,$action,$action3,$join_type,$join_type3){
$this->db->select("*");
$this->db->from($db1);
$this->db->where($data);
$this->db->order_by($id, "desc");
$this->db->join($db2, $action,$join_type);
$this->db->join($db3, $action3,$join_type3);
$query=$this->db->get();
return $query->result_array();

}
//Display JOIN3
public function MutiDisplayJoin_($db1,$db2,$db3,$db4,$data,$id,$action,$action3,$action4,$join_type,$join_type3,$join_type4){
$this->db->select("*");
$this->db->from($db1);
$this->db->where($data);
$this->db->order_by($id, "desc");
$this->db->join($db2, $action,$join_type);
$this->db->join($db3, $action3,$join_type3);
$this->db->join($db4, $action4,$join_type4);
$query=$this->db->get();
return $query->result_array();

}



//Display JOIN4
public function Muti5DisplayJoin_($db1,$db2,$db3,$db4,$db5,$data,$id,$action,$action3,$action4,$action5,$join_type,$join_type3,$join_type4,$join_type5){
$this->db->select("*");
$this->db->from($db1);
$this->db->where($data);
$this->db->order_by($id, "desc");
$this->db->join($db2, $action,$join_type);
$this->db->join($db3, $action3,$join_type3);
$this->db->join($db4, $action4,$join_type4);
$this->db->join($db5, $action5,$join_type5);
$query=$this->db->get();
return $query->result_array();

}





//Display JOIN3 Range
public function MutiDisplayJoinRange_($db1,$db2,$db3,$db4,$data,$id,$action,$action3,$action4,$join_type,$join_type3,$join_type4,$val,$avl_date_s,$avl_date_e){
$this->db->select("*");
$this->db->from($db1);
$this->db->where($data);
$this->db->where("$val BETWEEN '$avl_date_s' AND '$avl_date_e'","", FALSE);
$this->db->order_by($id, "desc");
$this->db->join($db2, $action,$join_type);
$this->db->join($db3, $action3,$join_type3);
$this->db->join($db4, $action4,$join_type4);
$query=$this->db->get();
return $query->result_array();

}

//Display JOIN2 Range
public function Muti_2JoinRange_($db1,$db2,$db3,$data,$id,$action,$action3,$join_type,$join_type3,$val,$avl_date_s,$avl_date_e){
$this->db->select("*");
$this->db->from($db1);
$this->db->where($data);
$this->db->where("$val BETWEEN '$avl_date_s' AND '$avl_date_e'","", FALSE);
$this->db->order_by($id, "desc");
$this->db->join($db2, $action,$join_type);
$this->db->join($db3, $action3,$join_type3);
$query=$this->db->get();
return $query->result_array();

}

//Display JOIN1 Range
public function Muti_JoinRange_($db1,$db2,$data,$id,$action,$join_type,$val,$avl_date_s,$avl_date_e){
$this->db->select("*");
$this->db->from($db1);
$this->db->where($data);
$this->db->where("$val BETWEEN '$avl_date_s' AND '$avl_date_e'","", FALSE);
$this->db->order_by($id, "desc");
$this->db->join($db2, $action,$join_type);

$query=$this->db->get();
return $query->result_array();

}

public function exp($data){
$this->db->select('DATE_FORMAT(s_date, "%M") AS date ,SUM(amt) AS amount');
$this->db->from('exp_trans');
$this->db->where($data);
$this->db->group_by('MONTH(s_date)');
$query=$this->db->get();
return $query->result_array();
}

public function cashIn($data){
$this->db->select('DATE_FORMAT(date, "%M") AS date ,SUM(amount) AS amount');
$this->db->from('trans_acc');
$this->db->where($data);
$this->db->group_by('MONTH(date)');
$query=$this->db->get();
return $query->result_array();
}

public function FBcash($data){
$this->db->select('DATE_FORMAT(date, "%M") AS date ,SUM(amt*qty-discount) AS amount');
$this->db->from('rt_trans');
$this->db->where($data);
$this->db->group_by('MONTH(date)');
$query=$this->db->get();
return $query->result_array();
}


}


?>