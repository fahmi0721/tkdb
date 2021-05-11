<?php

class M_Sk extends CI_Model {
        
    function detail_data($Id=null){
        if(!empty($Id)){
            $this->db->where("Id",$Id);
        }
        return $this->db->get("mkp_sk")->result_array();
    }

    function save_data($data){
        $this->db->insert("mkp_sk", $data);
        return $this->db->affected_rows();
    }

    function update_data($data,$Id){
        $this->db->where("Id", $Id);
        $this->db->update("mkp_sk", $data);
        return $this->db->affected_rows();
    }

    function delete_data($Id){
        $this->db->where("Id", $Id);
        $this->db->delete("mkp_sk");
        return $this->db->affected_rows();
    }

    function get_img($Id){
        $this->db->select("Foto");
        $this->db->where("Id",$Id);
        $dt =  $this->db->get("mkp_sk")->row();
        return $dt->Foto;
        
    }

    

}