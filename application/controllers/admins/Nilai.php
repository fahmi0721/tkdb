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

	public function form_tambah()
	{
		$data['UnitKerja'] = $this->m->get_unit_kerja();
		$header['title_page'] = "TKDB Online | Generate Nilai";
		$this->load->view('_template/header',$header);
		$this->load->view('admin/nilai/form-tambah',$data);
        $this->load->view('_template/footer');
	}

	function hitung_nilai($Noktp,$KodePaket){
		$iData = array();
		$iResult = array();
		$getJawabanPeserta = $this->m->get_jawaban_peserta($Noktp,$KodePaket);
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
		$iRes['Keterangan'] = $Hasil;
		return $iRes;
	}


	public function tambah(){
		$UnitKerja = $this->input->post('UnitKerja');
		$LoadPsertaUjainSelesai = $this->m->load_peserta_ujian_selesai($UnitKerja);
		if(count($LoadPsertaUjainSelesai) > 0){
			$i=0;
			foreach($LoadPsertaUjainSelesai as $data){
				$iData = $this->hitung_nilai($data['Noktp'],$data['KodePaket']);
				$this->m->update_nilai_peserta($iData,$data['Noktp']);
				$i++;
			}
			$success = array("status" => TRUE, "pesan" => $i." peserta berhasil digenerate nilainya");
			echo json_encode($success);
		}else{
			$success = array("status" => FALSE, "pesan" => "Semua Nilai telah digenerate");
			echo json_encode($success);
		}
		
	}

	public function form_nilai()
	{
		$data['Peserta'] = $this->m->get_peserta_tkdb();
		$header['title_page'] = "TKDB Online | Cek Nilai";
		$this->load->view('_template/header',$header);
		$this->load->view('admin/nilai/form-nilai',$data);
        $this->load->view('_template/footer');
	}
	
	public function detail_jawaban(){
		$Noktp = $this->input->post("Noktp");
		$getKodePaket = $this->m->get_kode_paket($Noktp);
		$data['Soal'] = $this->m->load_soal_cek($getKodePaket);
		$data['Jawaban'] = $this->m->get_jawaban_peserta_ubah($Noktp,$getKodePaket);
		echo json_encode($data);
	}	


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
