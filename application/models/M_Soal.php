<?php

class M_Soal extends CI_Model {
    
    var $table = 'tb_soal'; //nama tabel dari database
    var $column_order = array(null,'Kode','KodePaket'); //field yang ada di table peserta
    var $column_search = array('Kode','KodePaket'); //field yang diizin untuk pencarian 
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
        return $this->db->get("tb_soal")->row();
    
    }

    function get_paket_soal(){
        $this->db->order_by("Nama", "ASC");
        return $this->db->get("tb_paket_soal")->result_array();
    }

    function get_max_id_soal(){
        $this->db->order_by("Id", "DESC");
        return $this->db->get("tb_soal")->row();
    }

    function cek_data_by_kode($Kode){
        $this->db->where("Kode",$Kode);
        return $this->db->get("tb_soal")->num_rows();
    }

    function save_data($data){
        $this->db->insert("tb_soal", $data);
        return $this->db->affected_rows();
    }

    function update_data($data,$Id){
        $this->db->where("Id", $Id);
        $this->db->update("tb_soal", $data);
        return $this->db->affected_rows();
    }

    function delete_data($Id){
        $this->db->where("Id", $Id);
        $this->db->delete("tb_soal");
        return $this->db->affected_rows();
    }
}