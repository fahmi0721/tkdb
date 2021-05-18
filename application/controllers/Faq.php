<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Makassar');
class Faq extends CI_Controller {
    function __construct(){
		parent::__construct();
		$this->load->model('M_Auth',"login");
		$this->load->model('M_Faq',"m");
		$this->load->library('Mylib');
		
	}

	function get_data_faq()
    {
		$this->login->cek_login();
        $list = $this->m->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->Nama;
            $row[] = $field->NoHp;
            $row[] = $field->Keterangan;
            $row[] = "<center><span class='btn-group'><span class='btn-group'><a data-toggle='tooltip' target='_blank' href='".base_url()."public/img/ktp/".$field->Files."' title='Lihat KTP' class='btn btn-info btn-xs'><i class='fa fa-eye'></i><a data-toggle='tooltip' href='".base_url()."admins/faq/edit?Id=".$field->Id."' title='Ubah Data' class='btn btn-primary btn-xs'><i class='fa fa-edit'></i></a><a data-toggle='tooltip' href='javascript:void(0)' title='Hapus Data' onclick='HapusData(".$field->Id.")' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a></span></center>";
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m->count_all(),
            "recordsFiltered" => $this->m->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

	public function index()
	{

		$header['title_page'] = "FAQ TKDB ONLINE PT INTAN SEJAHTEAR UTAMA";
		$this->load->view('form_faq',$header);

	}

	public function data()
	{
		$this->login->cek_login();
		$header['title_page'] = "FAQ TKDB ONLINE PT INTAN SEJAHTEAR UTAMA";
		$this->load->view('_template/header',$header);
		$this->load->view('admin/faq/detail');
        $this->load->view('_template/footer');

	}

	public function do_upload(){
        $config['upload_path']          = './public/img/ktp/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 2048;
        $config['file_name']             = time();

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('Files'))
        {
            $error = array("status" => FALSE, "pesan" =>  $this->upload->display_errors());
            echo json_encode($error);
            exit();
        }
        else
        {
               $data =  $this->upload->data();
               return $data['file_name'];
        }
    }

	public function proses(){
	
		$data['Files'] = $this->do_upload();
		$data['Nama'] = strtoupper($this->input->post('Nama'));
		$data['Keterangan'] = $this->input->post('Keterangan');
		$data['TglLahir'] = $this->input->post('TglLahir');
		$data['Noktp'] = $this->input->post('Noktp');
		$data['NoHp'] = $this->input->post('NoHp');
		$data['TglCreate'] = date("Y-m-d :H:i:s");
		try{
            $execute = $this->m->save_data($data);
            $header['title_page'] = "Pesan Terkirim";
			$this->session->set_flashdata("success","Terima kasih telah menghubungi kami, laporan anda akan kami proses");
			$this->load->view('form_faq',$header);
		}catch(Exception $e){
			$header['title_page'] = "Invalid Proses";
			$this->session->set_flashdata("error","Terjadi kesalahan sistem");
			$this->load->view('form_faq',$header);
		}
	}
	

	
   
}
