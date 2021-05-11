<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rkb extends CI_Controller {

	
    function __construct(){
		parent::__construct();
		$this->load->model('M_Auth',"login");
		$this->load->model('M_Users',"m");
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
	
	public function getMKp(){
		$Mkp = array(
			2 => array(
				"Uraian" => "Buat Aplikasi",
				"Bobot" => 20,
				"Bukti" => "",
				"Target" => 100,
				"Nilai" => 20
			),
			3 => array(
				"Uraian" => "Buat Aplikasi",
				"Bobot" => 30,
				"Bukti" => "",
				"Target" => 100,
				"Nilai" => 30
			),
			4 => array(
				"Uraian" => "Buat Aplikasi",
				"Bobot" => 50,
				"Bukti" => "",
				"Target" => 100,
				"Nilai" => 50
			),
		);
		return json_encode($Mkp);
	}

	public function tambah(){
		
		$data['Periode'] = "2021-03";
		$data['Rkb'] = $this->getMkp();
		$data['Ikp'] = $this->m->getIkp(2);//this sessoin id pejabat
		$data['NilaiRkb'] = $this->generate_nilai_rkb($data['Rkb']);
		$data['NilaiIkp'] = $this->generate_nilai_ikp($data['Ikp']);
		try{
			$execute = $this->m->save_data($data);
			$success = array("status" => TRUE, "pesan" => "Data User berhasil tersimpan");
			echo json_encode($success);
		}catch(Exception $e){
			$error = array("status" => FALSE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
	}


	public function ubah(){
		$Id = $this->input->post('Id');
		$data['IdPejabat'] = $this->input->post('IdPejabat');
		$data['Level'] = $this->input->post('Level');
		if(!empty($this->input->post('Password'))){
			$data['Password'] = md5("mkp".$this->input->post('Password'));
		}
		$data['Username'] = $this->input->post('Username');
		try {
			$this->m->update_data($data,$Id);	
			$success = array("status" => TRUE, "pesan" => "Data Users berhasil terupdate");
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
