<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Makassar');
class Nilai extends CI_Controller {

	
    function __construct(){
		parent::__construct();
		$this->load->model('M_Auth',"login");
		$this->load->model('M_Nilai',"m");
        $this->login->cek_login();
		
	}

	function get_data_peserta()
    {
        $list = $this->m->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
			$Peserta = json_decode($field->Peserta,true);
            $row = array();
			$nilai = empty($field->Nilai) ? "<center><a data-toggle='tooltip' onclick=\"CekNilai('".$field->Noktp."')\" href='javascript:void(0)' title='Intip Nilai' class='btn btn-success btn-xs'><i class='fa fa-eye'></i></a></center>" : $field->Nilai;
            $row[] = $no;
            $row[] = "<b>".$Peserta['Nama']."</b><br><small>No KTP : ".$field->Noktp."</small><br /><small>Unit Kerja : ".$Peserta['UnitKerja']."</small><br /><small>Jabatan : ".$Peserta['Jabatan']."</small>";
            $row[] = "<b>".$Peserta['Jabatan']."</b><br><small>Unit Kerja : ".$Peserta['UnitKerja']."</small>";
            $row[] = $nilai;
            $row[] = "<center><a data-toggle='tooltip' href='".base_url()."admins/paket/edit?Id=".$field->Id."' title='Ubah Data' class='btn btn-primary btn-xs'><i class='fa fa-edit'></i></a><a data-toggle='tooltip' href='javascript:void(0)' title='Hapus Data' onclick='HapusData(".$field->Id.")' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a></span></center>";
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
        
		$header['title_page'] = "TKDB Online | Nilai TKDB";
		$this->load->view('_template/header',$header);
		$this->load->view('admin/nilai/detail');
        $this->load->view('_template/footer');

	}

	function intip_nilai(){
		$iData = array();
		$iResult = array();
		$Noktp = $this->input->post("Noktp");
		$getKodePaket = $this->m->get_kode_paket($Noktp);
		$getJawabanPeserta = $this->m->get_jawaban_peserta($Noktp,$getKodePaket);
		foreach($getJawabanPeserta as $jawaban_peserta){
			$nilai = $this->m->get_nilai($jawaban_peserta->KodeSoal,$jawaban_peserta->Jawaban);
			$iResult['Nilai'][] = $nilai;
		}
		// $Total
		$Total = array_sum($iResult['Nilai']);
		$iRes['Nilai'] = $Total;
		if($Total > 90){
			$Hasil = "DISARANKAN";
		}elseif($Total >= 45 && $Total <= 89){
			$Hasil = "DIPERTIMBANGKAN";
		}else{
			$Hasil = "TIDAK DISARANKAN";
		}

		$iRes['Hasil'] = $Hasil;
		echo json_encode($iRes);
	}

	// public function edit()
	// {
	// 	$Id = $this->input->get('Id');
	// 	$data['data'] = $this->m->detail_data($Id);
	// 	$header['title_page'] = "TKDB Online | Ubah Paket Soal";
	// 	$this->load->view('_template/header',$header);
	// 	$this->load->view('admin/paket/form-edit',$data);
    //     $this->load->view('_template/footer');

	// }

	// public function form_tambah()
	// {
	// 	$header['title_page'] = "TKDB Online | Tambah Paket Soal";
	// 	$this->load->view('_template/header',$header);
	// 	$this->load->view('admin/paket/form-tambah');
    //     $this->load->view('_template/footer');
	// }


	// public function tambah(){
	// 	$data['Kode'] = $this->input->post('Kode');
	// 	$data['Nama'] = strtoupper($this->input->post('Nama'));
	// 	$data['TglCreate'] = date("Y-m-d H:i:s");
	// 	try{
	// 		if($this->m->cek_data_by_kode($this->input->post('Kode')) <= 0){
	// 			$execute = $this->m->save_data($data);
	// 			$success = array("status" => TRUE, "pesan" => "Data Paket Soal berhasil tersimpan");
	// 			echo json_encode($success);
	// 		}else{
	// 			$error = array("status" => FALSE, "pesan" => "data dengan Kode ".$this->input->post('Kode')." telah terdaftar");
	// 			echo json_encode($error);
	// 		}
			
	// 	}catch(Exception $e){
	// 		$error = array("status" => FALSE, "pesan" => $e->getMessage());
	// 		echo json_encode($error);
	// 	}
	// }


	// public function ubah(){
	// 	$Id = $this->input->post('Id');
	// 	$data['Nama'] = strtoupper($this->input->post('Nama'));
	// 	try {
	// 		$this->m->update_data($data,$Id);	
	// 		$success = array("status" => TRUE, "pesan" => "Data Paket Soal berhasil terupdate");
	// 		echo json_encode($success);
	// 	} catch (Exception $e) {
	// 		$error = array("status" => TRUE, "pesan" => $e->getMessage());
	// 		echo json_encode($error);
	// 	}
	// }

	// public function hapus(){
	// 	try {
	// 		$Id = $this->input->get('Id');
	// 		$this->m->delete_data($Id);
	// 		$success = array("status" => TRUE, "pesan" => "Data Paket Soal berhasil dihapus");
	// 		echo json_encode($success);
	// 	} catch (Exception $e) {
	// 		$error = array("status" => TRUE, "pesan" => $e->getMessage());
	// 		echo json_encode($error);
	// 	}
		
		
	// }

}
