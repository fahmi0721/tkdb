<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktural extends CI_Controller {

	
    function __construct(){
		parent::__construct();
		$this->load->model('M_Auth',"login");
		$this->load->model('M_Struktural',"m");
        // $this->login->cek_login();
		
	}


	public function index()
	{
		$data = $this->m->detail_data();
		// $header['title_page'] = "MODUL STRUKTURAL";
		// $this->load->view('_template/header',$header);
		// $this->load->view('modul/struktural/detail');
        // $this->load->view('_template/footer');
		echo json_encode($data);

	}

	public function edit()
	{
		$Id = $this->input->get('Id');
		$data = $this->m->detail_data($Id);
		echo json_encode($data);
		// $header['title_page'] = "MODUL STRUKTURAL";
		// $this->load->view('_template/header',$header);
		// $this->load->view('modul/struktural/detail');
        // $this->load->view('_template/footer');

	}

	public function tambah(){
		$data['IdAtasan'] = $this->input->post('IdAtasan');
		$data['Jabatan'] = $this->input->post('Jabatan');
		$data['Deskripsi'] = $this->input->post('Deskripsi');
		$data['Flag'] = $this->input->post('Flag');
		echo $this->m->save_data($data);
	}

	public function ubah(){
		$Id = $this->input->post('Id');
		$data['IdAtasan'] = $this->input->post('IdAtasan');
		$data['Jabatan'] = $this->input->post('Jabatan');
		$data['Deskripsi'] = $this->input->post('Deskripsi');
		$data['Flag'] = $this->input->post('Flag');
		echo $this->m->update_data($data,$Id);
	}

	public function hapus(){
		$Id = $this->input->get('Id');
		echo $this->m->delete_data($Id);
	}

}
