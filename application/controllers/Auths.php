<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auths extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('M_Auth',"m");
		
	}

	public function index(){
		$header['title_page'] = "LOGIN | TKDB ONLINE PT INTAN SEJAHTEAR UTAMA";
		$this->load->view('form_login',$header);
	}

	public function logout_member(){
		$this->session->unset_userdata('Nama');
		$this->session->unset_userdata('Jabatan');
		$this->session->unset_userdata('NomorPeserta');
		$this->session->unset_userdata('Noktp');
		$this->session->unset_userdata('UnitKerja');
		$this->session->unset_userdata('Username');
		$this->session->unset_userdata('Level');
		$this->session->unset_userdata('Link-Logout');
		$this->session->unset_userdata('is_login');
		redirect('/auths');
	}

	

	public function proses()
	{
		$data['Noktp'] = $this->input->post("Username");	
		$data['Password'] = md5($this->input->post("Password"));	
		$result = $this->m->proses_login_peserta($data);
		if($result['status'] === TRUE){
			$this->session->set_userdata('Nama',$result['data']['user']->Nama);
			$this->session->set_userdata('Jabatan',$result['data']['user']->Jabatan);
			$this->session->set_userdata('NomorPeserta',$result['data']['user']->NomorPeserta);
			$this->session->set_userdata('UnitKerja',$result['data']['user']->UnitKerja);
			$this->session->set_userdata('Noktp',$result['data']['user']->Noktp);
			$this->session->set_userdata('Level',"Peserta");
			$this->session->set_userdata('Link-Logout',"logout_member");
			$this->session->set_userdata('is_login',TRUE);
			redirect("home");

		}else{
			$header['title_page'] = "Login Invalid";
			$this->session->set_flashdata("success_login",$result['pesan']);
			$this->load->view('form_login',$header);
		}
	}
}
