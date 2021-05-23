<?php

class M_Nilai extends CI_Model {

    var $table = 'tb_tkdb'; //nama tabel dari database
    var $column_order = array(null,'NoKtp','Peserta'); //field yang ada di table peserta
    var $column_search = array('Peserta'); //field yang diizin untuk pencarian 
    var $order = array('Id' => 'asc'); // default order 
 

    private function _get_datatables_query()
    {
        $this->db->where("StatusUjian","2");
        $this->db->from($this->table);
 
        $i = 0;
        
        foreach ($this->column_search as $item) // looping awal
        {
            if($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {
                 
                if($i===0) // looping awal
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->where("StatusUjian","2");
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_kode_paket($Noktp){
        $this->db->where("Noktp",$Noktp);
        $res = $this->db->get("tb_tkdb")->row();
        return $res->KodePaket;
    }
    
    function get_jawaban_peserta($Noktp, $KodePaket){
        $this->db->where("Noktp",$Noktp);
        $this->db->where("KodePaket",$KodePaket);
        return $this->db->get("tb_jawaban")->result();
    }

    function get_nilai($KodeSoal,$Jawaban){
        $Jawaban = base64_encode($Jawaban);
        $this->db->where("Kode",$KodeSoal);
        $this->db->where("KunciJawaban",$Jawaban);
        $res = $this->db->get("tb_soal")->row();
        return !empty($res->Bobot) ? $res->Bobot : 0;
    }

    function get_unit_kerja(){
        $UnitKerja = array("PELINDO IV (PERSERO) KANTOR PUSAT","PELINDO IV (PERSERO) CABANG MAKASSAR","PELINDO IV (PERSERO) TERMINAL PETIKEMAS MAKASSAR","PELINDO IV( PERSERO) CABANG MAKASSAR NEW PORT","PELINDO IV (PERSERO) TERMINAL PETIKEMAS BITUNG","PELINDO IV( PERSERO) CABANG BALIKPAPAN","PELINDO IV( PERSERO) CABANG SAMARINDA","PELINDO IV( PERSERO) CABANG BITUNG","PELINDO IV( PERSERO) CABANG AMBON","PELINDO IV( PERSERO) CABANG SORONG","PELINDO IV( PERSERO) CABANG JAYAPURA","PELINDO IV( PERSERO) CABANG TARAKAN","PELINDO IV( PERSERO) CABANG TERNATE","PELINDO IV( PERSERO) CABANG KENDARI","PELINDO IV( PERSERO) CABANG PANTOLOAN","PELINDO IV( PERSERO) CABANG PARE-PARE","PELINDO IV( PERSERO) CABANG NUNUKAN","PELINDO IV( PERSERO) CABANG MANOKWARI","PELINDO IV( PERSERO) CABANG BIAK","PELINDO IV( PERSERO) CABANG MERAUKE","PELINDO IV( PERSERO) CABANG TOLI-TOLI","PELINDO IV( PERSERO) CABANG FAKFAK","PELINDO IV( PERSERO) CABANG GORONGTALO","PELINDO IV( PERSERO) CABANG MANADO","PELINDO IV( PERSERO) CABANG BONTANG","PELINDO IV( PERSERO) CABANG SANGATTA","PELINDO IV( PERSERO) CABANG TANJUNG REDEB");
        ksort($UnitKerja);
        return $UnitKerja;
    }

    function load_peserta_ujian_selesai($UnitKerja){
        $this->db->select("tb_tkdb.Noktp, tb_peserta.Nama,tb_tkdb.KodePaket");
        $this->db->from("tb_tkdb");
        $this->db->join("tb_peserta","tb_tkdb.Noktp = tb_peserta.Noktp");
        $this->db->where("tb_tkdb.StatusUjian","2");
        $this->db->where("tb_tkdb.Nilai IS NULL");
        $this->db->where("tb_peserta.UnitKerja",$UnitKerja);
        $this->db->limit(50);
        return $this->db->get()->result_array();
    }

    function update_nilai_peserta($data,$NoKtp){
        $this->db->where("Noktp", $NoKtp);
        $this->db->update("tb_tkdb", $data);
        return $this->db->affected_rows();
    }

    function get_peserta_tkdb(){
        $this->db->select("tb_peserta.Noktp, tb_peserta.Nama, tb_tkdb.KodePaket");
        $this->db->from("tb_tkdb");
        $this->db->join("tb_peserta","tb_tkdb.Noktp = tb_peserta.Noktp");
        $this->db->where("tb_tkdb.StatusUjian","2");
        return $this->db->get()->result_array();
    }

    function load_soal_cek($KodePaket){
        $this->db->select("Kode, KunciJawaban, Bobot,KodePaket");
        $this->db->where("KodePaket",$KodePaket);
        return $this->db->get("tb_soal")->result_array();
    }

    function get_jawaban_peserta_ubah($Noktp, $KodePaket){
        $this->db->where("Noktp",$Noktp);
        $this->db->where("KodePaket",$KodePaket);
        $dt = $this->db->get("tb_jawaban")->result();
        $iData = array();
        foreach($dt as $data){
            $iData[$data->KodeSoal] = $data;
        }
        return $iData;
    }
    
}