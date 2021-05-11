<?php

class M_Master_ikp extends CI_Model {
        
    function detail_data($Id=null){
        if(!empty($Id)){
            $this->db->where("Id",$Id);
        }
        return $this->db->get("mkp_master_ikp")->result_array();
    }

    function save_data($data){
        $this->db->insert("mkp_master_ikp", $data);
        return $this->db->affected_rows();
    }

    function update_data($data,$Id){
        $this->db->where("Id", $Id);
        $this->db->update("mkp_master_ikp", $data);
        return $this->db->affected_rows();
    }

    function delete_data($Id){
        $this->db->where("Id", $Id);
        $this->db->delete("mkp_master_ikp");
        return $this->db->affected_rows();
    }
}