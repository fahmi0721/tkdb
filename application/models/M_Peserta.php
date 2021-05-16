<?php

class M_Peserta extends CI_Model {

    var $table = 'tb_peserta'; //nama tabel dari database
    var $column_order = array(null,'NomorPeserta','Nama','Noktp',"UnitKerja","Jabatan"); //field yang ada di table peserta
    var $column_search = array('NomorPeserta','Nama','Noktp','UnitKerja','Jabatan'); //field yang diizin untuk pencarian 
    var $order = array('Id' => 'asc'); // default order 
 

    private function _get_datatables_query()
    {
         
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
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

        
    function detail_data($Id){
        $this->db->where("Id",$Id);
        return $this->db->get("tb_peserta")->row();
        
        
    }

    function cek_data_by_ktp($noktp){
        $this->db->where("NoKtp",$noktp);
        return $this->db->get("tb_peserta")->num_rows();
    }

    function save_data($data){
        $this->db->insert("tb_peserta", $data);
        return $this->db->affected_rows();
    }

    function update_data($data,$Id){
        $this->db->where("Id", $Id);
        $this->db->update("tb_peserta", $data);
        return $this->db->affected_rows();
    }

    function delete_data($Id){
        $this->db->where("Id", $Id);
        $this->db->delete("tb_peserta");
        return $this->db->affected_rows();
    }

    function get_unit_kerja(){
        $UnitKerja = array("PELINDO IV (PERSERO) KANTOR PUSAT","PELINDO IV (PERSERO) CABANG MAKASSAR","PELINDO IV (PERSERO) TERMINAL PETIKEMAS MAKASSAR","PELINDO IV( PERSERO) CABANG MAKASSAR NEW PORT","PELINDO IV (PERSERO) TERMINAL PETIKEMAS BITUNG","PELINDO IV( PERSERO) CABANG BALIKPAPAN","PELINDO IV( PERSERO) CABANG SAMARINDA","PELINDO IV( PERSERO) CABANG BITUNG","PELINDO IV( PERSERO) CABANG AMBON","PELINDO IV( PERSERO) CABANG SORONG","PELINDO IV( PERSERO) CABANG JAYAPURA","PELINDO IV( PERSERO) CABANG TARAKAN","PELINDO IV( PERSERO) CABANG TERNATE","PELINDO IV( PERSERO) CABANG KENDARI","PELINDO IV( PERSERO) CABANG PANTOLOAN","PELINDO IV( PERSERO) CABANG PARE-PARE","PELINDO IV( PERSERO) CABANG NUNUKAN","PELINDO IV( PERSERO) CABANG MANOKWARI","PELINDO IV( PERSERO) CABANG BIAK","PELINDO IV( PERSERO) CABANG MERAUKE","PELINDO IV( PERSERO) CABANG TOLI-TOLI","PELINDO IV( PERSERO) CABANG FAKFAK","PELINDO IV( PERSERO) CABANG GORONGTALO","PELINDO IV( PERSERO) CABANG MANADO","PELINDO IV( PERSERO) CABANG BONTANG","PELINDO IV( PERSERO) CABANG SANGATTA","PELINDO IV( PERSERO) CABANG TANJUNG REDEB");
        ksort($UnitKerja);
        return $UnitKerja;
    }
}