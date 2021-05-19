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
    
}