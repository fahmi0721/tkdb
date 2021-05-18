<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Makassar');
class Home extends CI_Controller {
    function __construct(){
		parent::__construct();
		$this->load->model('M_Auth',"login");
		$this->load->model('M_Home',"m");
		$this->load->library('Mylib');
        $this->login->cek_login_member();
		
	}

	public function index()
	{
		$data['data'] = $this->m->load_peserta($this->session->userdata('Noktp'));
		$data['data']->Jk = intval(substr($data['data']->Noktp,7,2)) > 40 ? "P" : "L";
		$data['data']->TglLahir = $this->mylib->tgl_indo($data['data']->TglLahir);

		/** JADWAL */
		$data['jadwal'] = $this->m->load_jadwal_peserta($this->session->userdata('Noktp'));
		$PaketSoal = json_decode($data['jadwal']->PaketSoal,true);
		$data['jadwal']->PaketSoal = $PaketSoal['Nama'];
		$data['jadwal']->Mulai = $this->mylib->tgl_indo($data['jadwal']->Dari)." ".$this->mylib->jam_indo($data['jadwal']->Dari." 00:00:00");
		$Sampai = date_create($data['jadwal']->Sampai." 00:00:00");
		date_add($Sampai, date_interval_create_from_date_string('-1 seconds'));
		$Sampai = date_format($Sampai, 'Y-m-d H:i:s');
		$data['jadwal']->Selesai = $this->mylib->tgl_indo($Sampai)." ".$this->mylib->jam_indo($Sampai);
		$data['jadwal']->Hari = $this->mylib->hari_indo(date("Y-m-d"));
		$data['jadwal']->Today = $this->mylib->tgl_indo(date("Y-m-d"));

		/** CekTes */
		$data['jawaban'] = $this->m->cek_jawaban($this->session->userdata('Noktp'),$data['jadwal']->KodePaket);
		$DataJawaban = $this->m->all_jawaban($this->session->userdata('Noktp'),$data['jadwal']->KodePaket);
		$this->session->set_userdata("master_jawaban",$DataJawaban);



		/**Cek TKDB */
		$data['tkdb'] = $this->m->cek_tkdb($this->session->userdata('Noktp'));



		$header['title_page'] = "TKDB ONLINE PT INTAN SEJAHTEAR UTAMA";
		$this->load->view('_template/header',$header);
		$this->load->view('home',$data);
		$this->load->view('_template/footer');

	}


	public function proses_mulai(){
		$iDataSoal = array();
		$Soalku=array();
		$Noktp = $this->input->post('Noktp');
		$Soals = $this->m->load_soal($Noktp);
		$WaktuSekarang = date("Y-m-d H:i:s");
		$No=1;
		foreach($Soals as $soal){
			$jawaban['Noktp'] = $Noktp;
			$jawaban['KodePaket'] = $soal['KodePaket'];
			$jawaban['KodeSoal'] = $soal['Kode'];
			$jawaban['TglCreate'] = $WaktuSekarang;
			if($this->m->cek_jawaban_soal($Noktp,$soal['Kode']) <= 0){
				$this->m->save_jawaban($jawaban);
			}
			$Soalku['NomorSoal'] = $No;
			$Soalku['KodePaket'] = $soal['KodePaket'];
			$Soalku['KodeSoal'] = $soal['Kode'];
			$Soalku['Texts'] = base64_decode($soal['Texts']);
			$Soalku['Soal'] = base64_decode($soal['Soal']);
			$Soalku['PilihanJawaban'] = base64_decode($soal['PilihanJawaban']);
			$iDataSoal[] = $Soalku;
			$No++;
			
		}
		$this->session->set_userdata("master_soal",$iDataSoal);
		$tkdb['JamMulai'] = $WaktuSekarang;
		$tkdb['StatusUjian'] = "1";;
		$this->m->update_tkdb($Noktp, $tkdb);

		/** SET TIME INTERVAL */
		
		$dates = date_create($WaktuSekarang);
		date_add($dates, date_interval_create_from_date_string('1 hours'));
		$dates = date_format($dates, 'Y/m/d H:i:s');
		$this->session->set_userdata("waktu_ujian",$dates);
		$success = array("status" => TRUE, "pesan" => $this->session->userdata("waktu_ujian"));
        echo json_encode($success);
	}

	public function jawab_soal(){
		$Noktp = $this->session->userdata("Noktp");
		$KodeSoal = $this->input->post("KodeSoal");
		$KodePaket = $this->input->post("KodePaket");
		$data['Jawaban'] = isset($_POST['PilihanJawaban']) ? $this->input->post("PilihanJawaban") : "";
		$this->m->update_jawaban($Noktp,$KodePaket,$KodeSoal,$data);
		$DataJawaban = $this->m->all_jawaban($Noktp,$KodePaket);
		$this->session->set_userdata("master_jawaban",$DataJawaban);
		$success = array("status" => TRUE, "pesan" => "Jawaban berhasil diperbarui");
        echo json_encode($success);
	}

	public function selesai_normal(){
		$WaktuSekarang = date("Y-m-d H:i:s");
		$Noktp = $this->session->userdata("Noktp");
		$tkdb['JamSelesai'] = $WaktuSekarang;
		$tkdb['StatusUjian'] = "2";
		$this->m->update_tkdb($Noktp, $tkdb);
		$success = array("status" => TRUE, "pesan" => "Tes Selesai");
        echo json_encode($success);
	}

   
}
