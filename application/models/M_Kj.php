<?php

class M_Kj extends CI_Model {
        
    function detail_data($Id=null){
        if(!empty($Id)){
            $this->db->where("Id",$Id);
        }
        return $this->db->get("mkp_kls_jabatan")->result_array();
    }

    function save_data($data){
        $this->db->insert("mkp_kls_jabatan", $data);
        return $this->db->affected_rows();
    }

    function update_data($data,$Id){
        $this->db->where("Id", $Id);
        $this->db->update("mkp_kls_jabatan", $data);
        return $this->db->affected_rows();
    }

    function delete_data($Id){
        $this->db->where("Id", $Id);
        $this->db->delete("mkp_kls_jabatan");
        return $this->db->affected_rows();
    }

    function cek_duplicate_kode($kode){
        $this->db->where("Kode",$kode);
        return $this->db->get("mkp_kls_jabatan")->num_rows();
        
        
    }

    

}