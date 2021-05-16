<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auths extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('M_Auth',"m");
		
	}

	public function index(){
		$header['title_page'] = "LOGIN | TKDB ONLINE PT INTAN SEJAHTEAR UTAMA";
		$this->load->view('admin/form_login',$header);
	}

	public function logout_admin(){
		$this->session->unset_userdata('Nama');
		$this->session->unset_userdata('Username');
		$this->session->unset_userdata('Level');
		$this->session->unset_userdata('is_login');
		redirect('/admins');
	}

	public function generate_password($str){
        $key = "tkdb";
        $awal =  substr($key,0,2);
        $akhir =  substr($key,-2,2);
        $new_pass = $awal.$str.$akhir;
        $password = md5($new_pass);
        return $password;
    }

	public function proses()
	{
		$data['Username'] = $this->input->post("Username");	
		$data['Password'] = $this->generate_password($this->input->post("Password"));	
		$result = $this->m->proses_login($data);
		if($result['status'] === TRUE){
			$this->session->set_userdata('Nama',$result['data']['user']->Nama);
			$this->session->set_userdata('Username',$result['data']['user']->Username);
			$this->session->set_userdata('Level',"Admin");
			$this->session->set_userdata('Link-Logout',"logout_admin");
			$this->session->set_userdata('is_login',TRUE);
			redirect("admins/home");

		}else{
			$header['title_page'] = "Login Invalid";
			$this->session->set_flashdata("success_login",$result['pesan']);
			$this->load->view('form_login',$header);
		}
	}
}
