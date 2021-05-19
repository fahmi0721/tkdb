<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	
    function __construct(){
		parent::__construct();
		$this->load->model('M_Auth',"login");
		$this->load->model('M_Home',"m");
		$this->load->model("M_Pesrta_belum_tes","m_belum_tes");
		$this->load->model("M_Pesrta_berlangsung_tes","m_berlangsung_tes");
		$this->load->model("M_Pesrta_selesai_tes","m_selesai_tes");
        $this->login->cek_login();
		
	}

	public function index()
	{
		$header['title_page'] = "TKDB ONLINE PT INTAN SEJAHTEAR UTAMA";
		$this->load->view('_template/header',$header);
		$this->load->view('admin/home');
		$this->load->view('_template/footer');

	}

	public function load_data_rekap_tes(){
		$TglNow = date("Y-m-d");
		$data['waiting'] = $this->m->load_count_tkdb_waiting();
		$data['progress'] = $this->m->load_count_tkdb_progress();
		$data['finish'] = $this->m->load_count_tkdb_finish();
		$data['total'] = $this->m->load_count_all();
		echo json_encode($data);
	}
	
	public function get_data_peserta_belum_tes(){
		$list = $this->m_belum_tes->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
			$Peserta = json_decode($field->Peserta,true);
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "<b>".$Peserta['Nama']."</b><br><small>No KTP : ".$field->Noktp."</small><br><small>Unit Kerja : ".$Peserta['UnitKerja']."</small><br><small>Jabatan : ".$Peserta['Jabatan']."</small>";
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_belum_tes->count_all(),
            "recordsFiltered" => $this->m_belum_tes->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function get_data_peserta_berlangsung_tes(){
		$list = $this->m_berlangsung_tes->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
			$Peserta = json_decode($field->Peserta,true);
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "<b>".$Peserta['Nama']."</b><br><small>No KTP : ".$field->Noktp."</small><br><small>Unit Kerja : ".$Peserta['UnitKerja']."</small><br><small>Jabatan : ".$Peserta['Jabatan']."</small>";
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_berlangsung_tes->count_all(),
            "recordsFiltered" => $this->m_berlangsung_tes->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	public function get_data_peserta_selesai_tes(){
		$list = $this->m_selesai_tes->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
			$Peserta = json_decode($field->Peserta,true);
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "<b>".$Peserta['Nama']."</b><br><small>No KTP : ".$field->Noktp."</small><br><small>Unit Kerja : ".$Peserta['UnitKerja']."</small><br><small>Jabatan : ".$Peserta['Jabatan']."</small>";
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_selesai_tes->count_all(),
            "recordsFiltered" => $this->m_selesai_tes->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

   
}
