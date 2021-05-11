<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	
    function __construct(){
		parent::__construct();
		$this->load->model('M_Auth',"login");
        $this->login->cek_login();
		
	}

	public function index()
	{
		$header['title_page'] = "E-MKP ONLINE PT INTAN SEJAHTEAR UTAMA";
		$this->load->view('_template/header',$header);
		$this->load->view('home');
		$this->load->view('_template/footer');

	}
}
