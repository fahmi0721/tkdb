<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_jabatan extends CI_Controller {

	
    function __construct(){
		parent::__construct();
		$this->load->model('M_Auth',"login");
		$this->load->model('M_Kj',"m");
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
		$data['Kode'] = strtoupper($this->input->post('Kode'));
		$data['Tkp'] = $this->convert_to_angka($this->input->post('Tkp'));
		$data['Tko'] = $this->convert_to_angka($this->input->post('Tko'));
		if($this->m->cek_duplicate_kode($data['Kode']) <= 0){
			try{
				$execute = $this->m->save_data($data);
				$success = array("status" => TRUE, "pesan" => "Data kelas jabatan berhasil tersimpan");
				echo json_encode($success);
			}catch(Exception $e){
				$error = array("status" => FALSE, "pesan" => $e->getMessage());
				echo json_encode($error);
			}
		}else{
			$error = array("status" => FALSE, "pesan" => "Kode kelas jabatan telah tersedia");
			echo json_encode($error);
		}
		
		
	}


	public function ubah(){
		$Id = $this->input->post('Id');
		$data['Kode'] = strtoupper($this->input->post('Kode'));
		$data['Tkp'] = $this->convert_to_angka($this->input->post('Tkp'));
		$data['Tko'] = $this->convert_to_angka($this->input->post('Tko'));
		try {
			$this->m->update_data($data,$Id);	
			$success = array("status" => TRUE, "pesan" => "Data kelas jabatan berhasil terupdate");
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
			$success = array("status" => TRUE, "pesan" => "Data kelas jabatan berhasil dihapus");
			echo json_encode($success);
		} catch (Exception $e) {
			$error = array("status" => TRUE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
		
		
	}


}
