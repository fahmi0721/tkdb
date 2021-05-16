<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Makassar');
class Tkdb extends CI_Controller {

	
    function __construct(){
		parent::__construct();
		// $this->load->model('M_Auth',"login");
		$this->load->model('M_Tkdb',"m");
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

  

    public function get_soal(){
        $Soal = $this->m->get_soal("SL-002");
        return json_encode($Soal);
    }
	

	public function tambah(){
		$data['NoKtp'] = $this->input->post('NoKtp');
		$data['KodePaket'] = $this->input->post('KodePaket');
		$data['Soal'] = base64_encode($this->get_soal($this->input->post('KodePaket')));
		$data['TglCreate'] = date("Y-m-d H:i:s");
		try{
			if($this->m->cek_jadwal($this->input->post('NoKtp')) <= 0){
				$execute = $this->m->save_data($data);
				$success = array("status" => TRUE, "pesan" => "Data TKDB berhasil tersimpan");
				echo json_encode($success);
			}else{
				$error = array("status" => FALSE, "pesan" => "data dengan Kode ".$this->input->post('NoKtp')." telah terjadwalkan");
				echo json_encode($error);
			}
			
		}catch(Exception $e){
			$error = array("status" => FALSE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
	}


	public function ubah(){
		$Id = $this->input->post('Id');
		$data['NoKtp'] = $this->input->post('NoKtp');
		$data['KodePaket'] = $this->input->post('KodePaket');
		$data['Soal'] = base64_encode($this->get_soal($this->input->post('KodePaket')));
		try {
			$this->m->update_data($data,$Id);	
			$success = array("status" => TRUE, "pesan" => "Data Jadwal Peserta berhasil terupdate");
			echo json_encode($success);
		} catch (Exception $e) {
			$error = array("status" => TRUE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
	}

	public function mulai_ujian(){
		$Id = $this->input->post('Id');
		$data['JamMulai'] = date("Y-m-d H:i:s");
		$data['StatusUjian'] = "1";
		try {
			$this->m->update_data($data,$Id);	
			$success = array("status" => TRUE, "pesan" => "Peserta telah mulai");
			echo json_encode($success);
		} catch (Exception $e) {
			$error = array("status" => TRUE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
	}

	public function selesai_ujian(){
		$Id = $this->input->post('Id');
		$data['JamSelesai'] = date("Y-m-d H:i:s");
		$data['StatusUjian'] = "2";
		try {
			$this->m->update_data($data,$Id);	
			$success = array("status" => TRUE, "pesan" => "Peserta telah selesai");
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
			$success = array("status" => TRUE, "pesan" => "Data Jadwal Peserta berhasil dihapus");
			echo json_encode($success);
		} catch (Exception $e) {
			$error = array("status" => TRUE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
		
		
	}

}
