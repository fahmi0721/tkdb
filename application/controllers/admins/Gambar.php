<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Makassar');
class Gambar extends CI_Controller {

	
    function __construct(){
		parent::__construct();
        $this->load->helper("file");
		$this->load->model('M_Auth',"login");
		$this->load->model('M_Gambar',"m");
        $this->login->cek_login();
		
	}
	
	function get_data_peserta()
    {
        $list = $this->m->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "<b>".$field->Nama."</b><br><small>Source : ".base_url("public/img/soal/").$field->Files."</small><br><small>Keterangan :".$field->Keterangan."</small>";
            $row[] = "<center><img class='img-responsive' src='".base_url("public/img/soal/").$field->Files."'></center>";
            $row[] = "<center><span class='btn-group'><a data-toggle='tooltip' href='".base_url()."admins/gambar/edit?Id=".$field->Id."' title='Ubah Data' class='btn btn-primary btn-xs'><i class='fa fa-edit'></i></a><a data-toggle='tooltip' href='javascript:void(0)' title='Hapus Data' onclick='HapusData(".$field->Id.")' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a></span></center>";
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
        
		$header['title_page'] = "TKDB Online | Gambar";
		$this->load->view('_template/header',$header);
		$this->load->view('admin/gambar/detail');
        $this->load->view('_template/footer');

	}

	public function edit()
	{
		$Id = $this->input->get('Id');
		$data['data'] = $this->m->detail_data($Id);
		$header['title_page'] = "TKDB Online | Ubah Gambar";
		$this->load->view('_template/header',$header);
		$this->load->view('admin/gambar/form-edit',$data);
        $this->load->view('_template/footer');

	}

	public function form_tambah()
	{
		$header['title_page'] = "TKDB Online | Tambah Gambar";
		$this->load->view('_template/header',$header);
		$this->load->view('admin/gambar/form-tambah');
        $this->load->view('_template/footer');
	}


    public function do_upload(){
        $config['upload_path']          = './public/img/soal/';
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

	public function tambah(){
		$data['Files'] = $this->do_upload();
		$data['Nama'] = strtoupper($this->input->post('Nama'));
		$data['Keterangan'] = $this->input->post('Keterangan');
		$data['TglCreate'] = date("Y-m-d :H:i:s");
		try{
            $execute = $this->m->save_data($data);
            $success = array("status" => TRUE, "pesan" => "Data Gambar berhasil tersimpan");
            echo json_encode($success);
		}catch(Exception $e){
			$error = array("status" => FALSE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
	}


    public function hapus_gambar_lama($Id){
        $path = "./public/img/soal/";
        $getGambarLama = $this->m->get_gambar_lama($Id);
        unlink($path.$getGambarLama);
        return true;
    }

    
	public function ubah(){
		$Id = $this->input->post('Id');
        if(!empty($_FILES['Files']['name'])){
            $this->hapus_gambar_lama($Id);
		    $data['Files'] = $this->do_upload();
        }
		$data['Nama'] = $this->input->post('Nama');
		$data['Keterangan'] = $this->input->post('Keterangan');
		$data['TglCreate'] = date("Y-m-d");
		try{
            $execute = $this->m->update_data($data,$Id);
            $success = array("status" => TRUE, "pesan" => "Data Gambar berhasil terupdate");
            echo json_encode($success);
		}catch(Exception $e){
			$error = array("status" => FALSE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
	}

	public function hapus(){
		try {
			$Id = $this->input->get('Id');
            $this->hapus_gambar_lama($Id);
			$this->m->delete_data($Id);
			$success = array("status" => TRUE, "pesan" => "Data Gambar berhasil dihapus");
			echo json_encode($success);
		} catch (Exception $e) {
			$error = array("status" => TRUE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
		
		
	}

}
