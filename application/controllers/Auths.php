<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auths extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('M_Auth',"m");
		
	}

	public function index(){
		$header['title_page'] = "LOGIN | E-MKP ONLINE PT INTAN SEJAHTEAR UTAMA";
		$this->load->view('form_login',$header);
	}

	public function Logout(){
		$this->session->unset_userdata('Nama');
		$this->session->unset_userdata('Username');
		$this->session->unset_userdata('Level');
		$this->session->unset_userdata('is_login');
		redirect('/');
	}

	public function proses()
	{
		$data['Username'] = $this->input->post("Username");	
		$data['Password'] = $this->input->post("Password");	
		$result = $this->m->proses_login($data);
		if($result['status'] === TRUE){
			$this->session->set_userdata('Nama',$result['data']['diri']->Nama);
			$this->session->set_userdata('Level',$result['data']['user']->Level);
			$this->session->set_userdata('Username',$result['data']['user']->Username);
			$this->session->set_userdata('is_login',TRUE);
			redirect("home");

		}else{
			$header['title_page'] = "Login Invalid";
			$this->session->set_flashdata("success_login",$result['pesan']);
			$this->load->view('form_login',$header);
		}
	}
}
