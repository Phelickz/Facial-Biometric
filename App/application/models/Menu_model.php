<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

	


//Display JOIN
public function DisplayJoin_($db1,$db2,$data,$id,$action,$join_type){
$this->db->select("*");
$this->db->from($db1);
$this->db->where($data);
$this->db->order_by($id, "desc");
$this->db->join($db2, $action,$join_type);
$this->db->group_by("in_user_menu.parent_id");
$query=$this->db->get();
return $query->result_array();

}

//Display JOIN
public function DisplayAJoin_($db1,$db2,$data,$id,$action,$join_type){
$this->db->select("*");
$this->db->from($db1);
$this->db->where($data);
$this->db->order_by($id, "desc");
$this->db->join($db2, $action,$join_type);
$query=$this->db->get();
return $query->result_array();

}


//API FUNCTION TO GET MEDIA DATA
    public function MenuID()
  {
     $userID_data = array(
      
      'in_user_menu.personal_info_id'=>$this->session->userdata('personal_info_id'),

       );
     $action="in_user_menu.parent_id=menu.parent_id";
        $data = $this->DisplayJoin_('in_user_menu','menu',$userID_data,'in_user_menu_id',$action,'inner');
        
       return $data;
    
    }

      public function MenuSubM($parent_id)
  {
     $userID_data = array(
     
      'in_user_menu.personal_info_id'=>$this->session->userdata('personal_info_id'),
      'in_user_menu.parent_id'=>$parent_id,
      'in_user_menu.status'=>'1',


       );
     $action="in_user_menu.submenu_id=submenu.submenu_id";
        $data = $this->DisplayAJoin_('in_user_menu','submenu',$userID_data,'in_user_menu_id',$action,'left');
        return $data;
    
    
    }
	





}


?>