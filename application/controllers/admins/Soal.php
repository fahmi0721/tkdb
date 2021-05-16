<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Makassar');
class Soal extends CI_Controller {

	
    function __construct(){
		parent::__construct();
		$this->load->model('M_Auth',"login");
		$this->load->model('M_Soal',"m");
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
            $row[] = "<b>Kode Soal: ".$field->Kode."</b><br><small>Kode Paket : ".$field->KodePaket."</small><br><small>Bobot: ".$field->Bobot."</small>";
            $row[] = "<center><span class='btn-group'><a data-toggle='tooltip' href='javascript:void(0)' onclick=\"DetailDataSoal('".$field->Texts."')\" title='Text' class='btn btn-info btn-xs'><i class='fa fa-eye'></i></a><a data-toggle='tooltip' href='javascript:void(0)' onclick=\"DetailDataSoal('".$field->Soal."')\" title='Soal' class='btn btn-primary btn-xs'><i class='fa fa-eye'></i></a><a data-toggle='tooltip' href='javascript:void(0)' onclick=\"DetailDataSoal('".$field->PilihanJawaban."')\" title='Pilihan Jawaban' class='btn btn-warning btn-xs'><i class='fa fa-eye'></i></a></span></center>";
            $row[] = "<center><span class='btn-group'><a data-toggle='tooltip' href='".base_url()."admins/soal/edit?Id=".$field->Id."' title='Ubah Data' class='btn btn-primary btn-xs'><i class='fa fa-edit'></i></a><a data-toggle='tooltip' href='javascript:void(0)' title='Hapus Data' onclick='HapusData(".$field->Id.")' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a></span></center>";
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
        
		$header['title_page'] = "TKDB Online | Soal TKDb";
		$this->load->view('_template/header',$header);
		$this->load->view('admin/soal/detail');
        $this->load->view('_template/footer');

	}

	public function edit()
	{
		$Id = $this->input->get('Id');
		$data['data'] = $this->m->detail_data($Id);
		$data['data']->Soal = base64_decode($data['data']->Soal);
		$data['data']->Texts = base64_decode($data['data']->Texts);
		$data['data']->KunciJawaban = base64_decode($data['data']->KunciJawaban);
		$PilihanJawaban = json_decode(base64_decode($data['data']->PilihanJawaban),true);
		$data['data']->A = $PilihanJawaban['A'];
		$data['data']->B = $PilihanJawaban['B'];
		$data['data']->C = $PilihanJawaban['C'];
		$data['data']->D = $PilihanJawaban['D'];

		$data['paket_soal'] = $this->m->get_paket_soal();
		$header['title_page'] = "TKDB Online | Ubah Soal";
		$this->load->view('_template/header',$header);
		$this->load->view('admin/soal/form-edit',$data);
        $this->load->view('_template/footer');

	}

	public function form_tambah()
	{
		$data['paket_soal'] = $this->m->get_paket_soal();
		$header['title_page'] = "TKDB Online | Tambah Soal";
		$this->load->view('_template/header',$header);
		$this->load->view('admin/soal/form-tambah',$data);
        $this->load->view('_template/footer');
	}

    public function generate_kode_soal(){
        $IdSoalTerakhir = $this->m->get_max_id_soal();
        if(!empty($IdSoalTerakhir)){
            $KodeSoalLama = $IdSoalTerakhir->Kode;
            $KodeSoalLama = substr($KodeSoalLama,-3,3);
            $KodeSoalLama = intval($KodeSoalLama);
            $KodeSoalBaru = $KodeSoalLama + 1;
            $KodeSoalBaru = "KD-".sprintf("%03d",$KodeSoalBaru);
            return $KodeSoalBaru;
        }else{
            return "KD-001";
        }
    }

   
	public function tambah(){
		$data['KodePaket'] = $this->input->post('KodePaket');
		$data['Bobot'] = $this->input->post('Bobot');
		$data['Kode'] = $this->generate_kode_soal();
		$data['Texts'] = base64_encode($this->input->post('Texts'));
		$data['Soal'] = base64_encode($this->input->post('Soal'));
		$PilihanJawaban = array(
			"A" => 	$this->input->post('A'),
			"B" => 	$this->input->post('B'),
			"C" => 	$this->input->post('C'),
			"D" => 	$this->input->post('D')
		);
		$data['PilihanJawaban'] = base64_encode(json_encode($PilihanJawaban));
		$data['KunciJawaban'] = base64_encode($this->input->post('KunciJawaban'));
		$data['TglCreate'] = date("Y-m-d");
		try{
			if($this->m->cek_data_by_kode($this->input->post('Kode')) <= 0){
				$execute = $this->m->save_data($data);
				$success = array("status" => TRUE, "pesan" => "Data  Soal berhasil tersimpan");
				echo json_encode($success);
			}else{
				$error = array("status" => FALSE, "pesan" => "data dengan Kode ".$this->input->post('Kode')." telah terdaftar");
				echo json_encode($error);
			}
			
		}catch(Exception $e){
			$error = array("status" => FALSE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
	}


	public function ubah(){
		$Id = $this->input->post('Id');
		$data['KodePaket'] = $this->input->post('KodePaket');
		$data['Bobot'] = $this->input->post('Bobot');
		$data['Texts'] = base64_encode($this->input->post('Texts'));
		$data['Soal'] = base64_encode($this->input->post('Soal'));
		$PilihanJawaban = array(
			"A" => 	$this->input->post('A'),
			"B" => 	$this->input->post('B'),
			"C" => 	$this->input->post('C'),
			"D" => 	$this->input->post('D')
		);
		$data['PilihanJawaban'] = base64_encode(json_encode($PilihanJawaban));
		$data['KunciJawaban'] = base64_encode($this->input->post('KunciJawaban'));
		try {
			$this->m->update_data($data,$Id);	
			$success = array("status" => TRUE, "pesan" => "Data Soal berhasil terupdate");
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
			$success = array("status" => TRUE, "pesan" => "Data Paket Soal berhasil dihapus");
			echo json_encode($success);
		} catch (Exception $e) {
			$error = array("status" => TRUE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
		
		
	}

}
