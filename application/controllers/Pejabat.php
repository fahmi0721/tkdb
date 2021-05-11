<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pejabat extends CI_Controller {

	
    function __construct(){
		parent::__construct();
		$this->load->model('M_Auth',"login");
		$this->load->model('M_Pejabat',"m");
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
		/** CONFIG UPLOAD GAMBAR */
		$path = $_FILES['Foto']['name'];
		$new_name = time().".".pathinfo($path,PATHINFO_EXTENSION);
		$config['file_name'] = $new_name;
		$config['upload_path'] = './upload/foto/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 2048;
		$this->load->library("upload",$config);
		if(!$this->upload->do_upload('Foto')){
			$error = array("status" => FALSE,'pesan' => $this->upload->display_errors());
			echo json_encode($error);
		}else{
			try{
				$data['Nip'] = $this->input->post('Nip');
				$data['Nama'] = $this->input->post('Nama');
				$data['GelarDepan'] = $this->input->post('GelarDepan');
				$data['GelarBelakang'] = $this->input->post('GelarBelakang');
				$data['NoHp'] = $this->input->post('NoHp');
				$data['NoKtp'] = $this->input->post('NoKtp');
				$data['TptLahir'] = $this->input->post('TptLahir');
				$data['TglLahir'] = $this->input->post('TglLahir');
				$data['Alamat'] = $this->input->post('Alamat');
				$data['Foto'] = $new_name;
				$execute = $this->m->save_data($data);
				$success = array("status" => TRUE, "pesan" => "Data pejabat berhasil tersimpan");
				echo json_encode($success);
			}catch(Exception $e){
				$error = array("status" => FALSE, "pesan" => $e->getMessage());
				echo json_encode($error);
			}
		}
		
		
	}

	public function hapus_gambar($dir,$img){
		if(file_exists($dir.$img) && !empty($img)){
			unlink($dir.$img);
			return true;
		}else{
			return true;
		}
	}
	

	public function ubah(){
		$Id = $this->input->post('Id');
		$File = $_FILES['Foto']['name'];
		if(!empty($File)){
			/** Hapus Gambar Lama */
			$ImgOld = $this->m->get_img($Id);
			if(!empty($ImgOld)){ $this->hapus_gambar("./upload/foto/",$ImgOld); }
			/** CONFIG UPLOAD GAMBAR */
			$path = $_FILES['Foto']['name'];
			$new_name = time().".".pathinfo($path,PATHINFO_EXTENSION);
			$config['file_name'] = $new_name;
			$config['upload_path'] = './upload/foto/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = 2048;
			$this->load->library("upload",$config);
			if(!$this->upload->do_upload('Foto')){
				$pesan = array("status" => FALSE, "pesan" =>  $this->upload->display_errors());
				echo json_encode($pesan);
			}else{
				try {
					$data['Nip'] = $this->input->post('Nip');
					$data['Nama'] = $this->input->post('Nama');
					$data['GelarDepan'] = $this->input->post('GelarDepan');
					$data['GelarBelakang'] = $this->input->post('GelarBelakang');
					$data['NoHp'] = $this->input->post('NoHp');
					$data['NoKtp'] = $this->input->post('NoKtp');
					$data['TptLahir'] = $this->input->post('TptLahir');
					$data['TglLahir'] = $this->input->post('TglLahir');
					$data['Alamat'] = $this->input->post('Alamat');
					$data['Foto'] = $new_name;
					$this->m->update_data($data,$Id);	
					$success = array("status" => TRUE, "pesan" => "Data pejabat berhasil terupdate");
					echo json_encode($success);
				} catch (Exception $e) {
					$error = array("status" => TRUE, "pesan" => $e->getMessage());
					echo json_encode($error);
				}
			}
			
		}else{
			try {
				$data['Nip'] = $this->input->post('Nip');
				$data['Nama'] = $this->input->post('Nama');
				$data['GelarDepan'] = $this->input->post('GelarDepan');
				$data['GelarBelakang'] = $this->input->post('GelarBelakang');
				$data['NoHp'] = $this->input->post('NoHp');
				$data['NoKtp'] = $this->input->post('NoKtp');
				$data['TptLahir'] = $this->input->post('TptLahir');
				$data['TglLahir'] = $this->input->post('TglLahir');
				$data['Alamat'] = $this->input->post('Alamat');
				$this->m->update_data($data,$Id);	
				$success = array("status" => TRUE, "pesan" => "Data pejabat berhasil terupdate");
				echo json_encode($success);
			} catch (Exception $e) {
				$error = array("status" => TRUE, "pesan" => $e->getMessage());
				echo json_encode($error);
			}
		}
	}

	public function hapus(){
		try {
			$Id = $this->input->get('Id');
			$ImgOld = $this->m->get_img($Id);
			if(!empty($ImgOld)){ $this->hapus_gambar("./upload/foto/",$ImgOld); }
			$this->m->delete_data($Id);
			$success = array("status" => TRUE, "pesan" => "Data pejabat berhasil dihapus");
			echo json_encode($success);
		} catch (Exception $e) {
			$error = array("status" => TRUE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
		
		
	}


}
