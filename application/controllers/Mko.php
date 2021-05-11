<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mko extends CI_Controller {

	
    function __construct(){
		parent::__construct();
		$this->load->model('M_Auth',"login");
		$this->load->model('M_Mko',"m");
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
		$data['Periode'] = $this->input->post('Periode');
		$data['Mko'] = $this->input->post('Mko');
		$data['Keterangan'] = $this->input->post('Keterangan');
		$data['TglCreate'] = date("Y-m-d H:i:s");
		try{
			$execute = $this->m->save_data($data);
			$success = array("status" => TRUE, "pesan" => "Data MKO berhasil tersimpan");
			echo json_encode($success);
		}catch(Exception $e){
			$error = array("status" => FALSE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
	}


	public function ubah(){
		$Id = $this->input->post('Id');
		$data['Periode'] = $this->input->post('Periode');
		$data['Mko'] = $this->input->post('Mko');
		$data['Keterangan'] = $this->input->post('Keterangan');
		try {
			$this->m->update_data($data,$Id);	
			$success = array("status" => TRUE, "pesan" => "Data MKO berhasil terupdate");
			echo json_encode($success);
		} catch (Exception $e) {
			$error = array("status" => TRUE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
	}

	public function hapus(){
		try {
			$Id = $this->input->get('Id');
			$this->m->delete_data($Id);
			$success = array("status" => TRUE, "pesan" => "Data MKO berhasil dihapus");
			echo json_encode($success);
		} catch (Exception $e) {
			$error = array("status" => TRUE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
		
		
	}


}
