<?php

class M_Rkb extends CI_Model {
        
    function detail_data($Id=null){
        if(!empty($Id)){
            $this->db->where("Id",$Id);
        }
        return $this->db->get("mkp_user")->result_array();
    }

    function save_data($data){
        $this->db->insert("mkp_user", $data);
        return $this->db->affected_rows();
    }

    function update_data($data,$Id){
        $this->db->where("Id", $Id);
        $this->db->update("mkp_user", $data);
        return $this->db->affected_rows();
    }

    function delete_data($Id){
        $this->db->where("Id", $Id);
        $this->db->delete("mkp_user");
        return $this->db->affected_rows();
    }
}