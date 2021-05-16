<?php

class M_Tkdb extends CI_Model {
        
    function detail_data($Id=null){
        if(!empty($Id)){
            $this->db->where("Id",$Id);
            return $this->db->get("tb_tkdb")->row();
        }else{
            return $this->db->get("tb_tkdb")->result_array();
        }
    }

    function cek_jadwal($NoKtp){
        $this->db->where("NoKtp",$NoKtp);
        return $this->db->get("tb_tkdb")->num_rows();
    }

    function get_soal($kode_paket){
        $this->db->where("KodePaket",$kode_paket);
        return $this->db->get("tb_soal")->result_array();
    }

    function save_data($data){
        $this->db->insert("tb_tkdb", $data);
        return $this->db->affected_rows();
    }

    function update_data($data,$Id){
        $this->db->where("Id", $Id);
        $this->db->update("tb_tkdb", $data);
        return $this->db->affected_rows();
    }

    function delete_data($Id){
        $this->db->where("Id", $Id);
        $this->db->delete("tb_tkdb");
        return $this->db->affected_rows();
    }
}