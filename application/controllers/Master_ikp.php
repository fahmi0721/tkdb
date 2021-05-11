<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_ikp extends CI_Controller {

	
    function __construct(){
		parent::__construct();
		$this->load->model('M_Auth',"login");
		$this->load->model('M_Master_ikp',"m");
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
	
	public function convert_to_angka($angka){
		$str = preg_replace( '/[^0-9]/', '', $angka );
		return $str;
	}
	

	public function tambah(){
		$data['Kompetensi'] = strtoupper($this->input->post('Kompetensi'));
		$data['Bobot'] = $this->convert_to_angka($this->input->post('Bobot'));
		$data['Target'] = $this->convert_to_angka($this->input->post('Target'));
		try{
			$execute = $this->m->save_data($data);
			$success = array("status" => TRUE, "pesan" => "Data master indikator kompetensi berhasil tersimpan");
			echo json_encode($success);
		}catch(Exception $e){
			$error = array("status" => FALSE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
	}


	public function ubah(){
		$Id = $this->input->post('Id');
		$data['Kompetensi'] = strtoupper($this->input->post('Kompetensi'));
		$data['Bobot'] = $this->convert_to_angka($this->input->post('Bobot'));
		$data['Target'] = $this->convert_to_angka($this->input->post('Target'));
		try {
			$this->m->update_data($data,$Id);	
			$success = array("status" => TRUE, "pesan" => "Data master indikator kompetensi berhasil terupdate");
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
			$success = array("status" => TRUE, "pesan" => "Data master indikator kompetensi berhasil dihapus");
			echo json_encode($success);
		} catch (Exception $e) {
			$error = array("status" => TRUE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
		
		
	}


}
