<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ikp_pegawai extends CI_Controller {

	
    function __construct(){
		parent::__construct();
		$this->load->model('M_Auth',"login");
		$this->load->model('M_Ikp_pegawai',"m");
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
	
	public function getKompetensi(){
		$Kompetensi = array(
			2 => array(
				"Kompetensi" => "sssssss",
				"Bobot" => "3",
				"Target" => "",
				"Nila" => "",
			),
			3 => array(
				"Kompetensi" => "sssssss",
				"Bobot" => "3",
				"Nilai" => "",
			)	
		);
		return json_encode($Kompetensi);

	}

	public function tambah(){
		$data['Kompetensi'] = $this->getKompetensi();
		$data['IdPejabat'] = $this->input->post('IdPejabat');
		$data['TglCreate'] = date("Y-m-d H:i:s");
		try{
			$execute = $this->m->save_data($data);
			$success = array("status" => TRUE, "pesan" => "Data Indikator Kompetensi Pegawai berhasil tersimpan");
			echo json_encode($success);
		}catch(Exception $e){
			$error = array("status" => FALSE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
	}


	public function ubah(){
		$Id = $this->input->post('Id');
		$data['Kompetensi'] = $this->getKompetensi();
		$data['IdPejabat'] = $this->input->post('IdPejabat');
		try {
			$this->m->update_data($data,$Id);	
			$success = array("status" => TRUE, "pesan" => "Data Inikator Kompetensi Pegawai berhasil terupdate");
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
