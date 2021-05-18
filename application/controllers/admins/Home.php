<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	
    function __construct(){
		parent::__construct();
		$this->load->model('M_Auth',"login");
		$this->load->model('M_Home',"m");
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

   
}
