<?php

class M_Home extends CI_Model {
    
    
    function load_peserta($Noktp){
        $this->db->where("Noktp",$Noktp);
        return $this->db->get("tb_peserta")->row();
    }

    function load_jadwal_peserta($Noktp){
        $this->db->where("Noktp",$Noktp);
        return $this->db->get("tb_jadwal")->row();
    }

    function cek_jawaban($Noktp, $KodePaket){
        $this->db->where("KodePaket",$KodePaket);
        $this->db->where("Noktp",$Noktp);
        $this->db->from("tb_jawaban");
        $this->db->group_by("Noktp");
        return $this->db->count_all_results();
    }

    function load_soal($Noktp){
        $this->db->where("Noktp",$Noktp);
        $data = $this->db->get("tb_tkdb")->row();
        return json_decode($data->Soal,true);
    }

    function cek_jawaban_soal($Noktp,$KodeSoal){
        $this->db->where("Noktp",$Noktp);
        $this->db->where("KodeSoal",$KodeSoal);
        return $this->db->get("tb_jawaban")->num_rows();
    }

    function save_jawaban($data){
        $this->db->insert("tb_jawaban", $data);
        return $this->db->affected_rows();
    }

    function update_tkdb($Noktp,$data){
        $this->db->where("Noktp", $Noktp);
        $this->db->update("tb_tkdb", $data);
        return $this->db->affected_rows();
    }

    function update_jawaban($Noktp, $KodePaket, $KodeSoal, $data){
        $this->db->where("Noktp", $Noktp);
        $this->db->where("KodePaket", $KodePaket);
        $this->db->where("KodeSoal", $KodeSoal);
        $this->db->update("tb_jawaban", $data);
        return $this->db->affected_rows();
    }

    function all_jawaban($Noktp, $KodePaket){
        $this->db->where("Noktp", $Noktp);
        $this->db->where("KodePaket", $KodePaket);
        $res = $this->db->get("tb_jawaban")->result_array();
        $iData = array();
        foreach($res as $dt){
            if(!empty($dt['Jawaban']))
                $iData[$dt['KodeSoal']] = $dt['Jawaban'];
        }

        return $iData;
    }

    function cek_tkdb($Noktp){
        $this->db->where("Noktp",$Noktp);
        return $this->db->get("tb_tkdb")->row();
    }


}