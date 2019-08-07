<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {



    /*
     * Fetch user data
     */
 public function Apikeyogin_($data){
$this->db->select('*');
$this->db->from('keys');
$this->db->where($data);
$this->db->limit(1);
$query = $this->db->get();
if ($query->num_rows() == 1) {
return $query->result();
} else {
return false;
}

}

public function Reg_($data){
$query=$this->db->insert('personal_info', $data);
return $query;

}
public function Login_($data){
$this->db->select('*,personal_info.personal_info_id,store_login.sub_store_vid,in_store.store_name');
$this->db->from('personal_info');
$this->db->where($data);
$this->db->limit(1);
$this->db->join('store_login', 'store_login.personal_info_id=personal_info.personal_info_id');
$this->db->join('in_store', 'personal_info.store_vid=in_store.store_vid','left');
$query = $this->db->get();
if ($query->num_rows() == 1) {
return $query->result();
} else {
return false;
}


}

public function SubLogin_($data){
$this->db->select('*');
$this->db->from('store_login');
$this->db->where($data);
$query = $this->db->get();
return $query->num_rows();

}

public function DisplayUser_(){
$query =$this->db->query('SELECT * FROM personal_info ');
return $query->result_array();

}
public function DisplayUserByStore_($data){
$this->db->select('*');
$this->db->from('personal_info');
$this->db->where($data);
$query = $this->db->get();
return $query->result_array();

}



public function ApproveUser_($personal_info_id, $data){
$this->db->where('personal_info_id', $personal_info_id);
$this->db->update('personal_info', $data);
return TRUE;
}

public function UpdateUser_($query_array, $data){
$this->db->update('personal_info', $data,$query_array);
return TRUE;
}

public function Passwd_($query_array, $data){
$this->db->update('personal_info', $data,$query_array);
return TRUE;
}

public function UpdateLog_($data){
$this->db->replace('login_session',$data);  
return TRUE;
}


public function LoginCheck_($data){
$this->db->select('*');
$this->db->from('login_session');
$this->db->where($data);
//$this->db->limit(1);
$query = $this->db->get();
$vat= $query->num_rows();
return $vat;

}

public function AsignStore_($data,$dataA){
$this->db->select('*');
$this->db->from('store_login');
$this->db->where($data);
$this->db->limit(1);
$query = $this->db->get();
if ($query->num_rows() == 1) {
return FALSE;
} else {
$this->db->insert('store_login', $dataA);
return TRUE;
}


}
//Menu AsignStore

public function MenuAssgn_($data){
$this->db->select('*');
$this->db->from('in_user_menu');
$this->db->where($data);
$this->db->limit(1);
$query = $this->db->get();
if ($query->num_rows() == 1) {
return FALSE;
} else {
$this->db->insert('in_user_menu', $data);
return TRUE;
}
}

// Display OutletAssign
function  Display_Outlet($data){
$this->db->select("personal_info.name,in_store.store_name,store_login.date,store_login.store_login_id");
$this->db->from('store_login');
$this->db->where($data);
$this->db->join('in_store', 'in_store.store_sub_id=store_login.sub_store_vid');
$this->db->join('personal_info', 'store_login.personal_info_id=personal_info.personal_info_id');
$query=$this->db->get();
return $query->result_array();
}

//Remove OutLet User
function Del_outletUser_($id){
$this->db->where('store_login_id', $id);
$a=$this->db->delete('store_login');
if(isset($a)){return TRUE;}else{return FALSE;}

}


}
