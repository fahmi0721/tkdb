<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Makassar');
class Jadwal extends CI_Controller {
    function __construct(){
		parent::__construct();
		$this->load->model('M_Auth',"login");
		$this->load->model('M_Jadwal',"m");
		$this->load->library('mylib');
        $this->login->cek_login();
		
	}

	function get_data_peserta()
    {
        $list = $this->m->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
			$Peserta = json_decode($field->Peserta,true);
			$PaketSoal = json_decode($field->PaketSoal,true);
			$FlagSoal = $field->Flag == "0" ? "<label class='label label-danger'>CLose</label>" : "<label class='label label-success'>Open</label>";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "<b>".$Peserta['Nama']."</b><br><small>No KTP : ".$field->Noktp."</small><br /><small>No Peserta : ".$Peserta['NomorPeserta']."</small><br /><small>Unit Kerja : ".$Peserta['UnitKerja']."</small>";
            $row[] = "Mulai :".$this->mylib->tgl_indo($field->Dari)." ".$this->mylib->jam_indo($field->Dari." 00:00:00")."<br />Sampai : ".$this->mylib->tgl_indo($field->Sampai)." ".$this->mylib->jam_indo($field->Sampai);
            $row[] = "<b>".$PaketSoal['Nama']."</b><br><small>KodecPaket : ".$field->KodePaket."</small><br><small>Status Soal : ".$FlagSoal."</small>";
            $row[] = "<center><span class='btn-group'><a data-toggle='tooltip' href='".base_url()."admins/jadwal/edit?Id=".$field->Id."' title='Ubah Data' class='btn btn-primary btn-xs'><i class='fa fa-edit'></i></a><a data-toggle='tooltip' href='javascript:void(0)' title='Hapus Data' onclick='HapusData(".$field->Id.")' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a></span></center>";
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
        
		$header['title_page'] = "TKDB Online | Jadwak TKDB";
		$this->load->view('_template/header',$header);
		$this->load->view('admin/jadwal/detail');
        $this->load->view('_template/footer');
	}

	function buka(){
		$UnitKerja = $this->input->post('UnitKerja');
		$data_jadwal = $this->m->data_jadwal($UnitKerja);
		foreach($data_jadwal as $data){
			$res['Noktp'] = $data['Noktp'];
			$res['Peserta'] = $data['Peserta'];
			$res['KodePaket'] = $data['KodePaket'];
			$res['PaketSoal'] = $data['PaketSoal'];
			$res['Soal'] = !empty($this->m->get_soal($data['KodePaket'])) ? json_encode($this->m->get_soal($data['KodePaket'])) : "";
			if(!empty($this->m->get_soal($data['KodePaket'])))
				$this->save_tkdb($res);
		}
		$success = array("status" => TRUE, "pesan" => "Data Soal Peserta Unit Kerja ".$UnitKerja." berhasil dibuka");
		echo json_encode($success);
	}

	public function save_tkdb($data){
		$data['TglCreate'] = date("Y-m-d H:i:s");
		$data['StatusUjian'] = "0";
		try{
			$execute = $this->m->save_data_tkdb($data);
			return true;
			
		}catch(Exception $e){
			$error = array("status" => FALSE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
	}

	public function edit()
	{
		$Id = $this->input->get('Id');
		$data['data'] = $this->m->detail_data($Id);
		$header['title_page'] = "TKDB Online | Ubah Jadwal TKDB";
		$data['Peserta'] = $this->m->get_peserta_all();
		$data['PaketSoal'] = $this->m->get_paket();
		$this->load->view('_template/header',$header);
		$this->load->view('admin/jadwal/form-edit',$data);
        $this->load->view('_template/footer');
	}

	public function form_tambah()
	{
		$header['title_page'] = "TKDB Online | Tambah Jadwal TKDB";
		$data['UnitKerja'] = $this->m->get_unit_kerja();
		$this->load->view('_template/header',$header);
		$this->load->view('admin/jadwal/form-tambah',$data);
        $this->load->view('_template/footer');
	}

	public function form_buka()
	{
		$header['title_page'] = "TKDB Online | Buka Soal TKDB";
		$data['UnitKerja'] = $this->m->get_unit_kerja();
		$this->load->view('_template/header',$header);
		$this->load->view('admin/jadwal/form-buka',$data);
        $this->load->view('_template/footer');
	}
	
	public function tambah(){
		$UnitKerja = $this->input->post('UnitKerja');
		$Dari = $this->input->post('Dari');
		$Sampai = $this->input->post('Sampai');
		$peserta = $this->m->get_peserta($UnitKerja);
		$KodePaket = $this->m->get_paket();
		
		$i=0;
		$JumPaket = count($KodePaket);
		foreach($peserta as $dt_peserta){
			if($this->m->cek_jadwal($dt_peserta['Noktp']) <= 0){
				$data['Dari']  = $Dari;
				$data['Sampai']  = $Sampai;
				$data['Peserta']  = json_encode($dt_peserta);
				$data['Noktp']  = $dt_peserta['Noktp'];
				$data['UnitKerja']  = $dt_peserta['UnitKerja'];
				$data['KodePaket']  = $KodePaket[$i]['Kode'];
				$data['PaketSoal']  = json_encode($KodePaket[$i]);
				$this->save($data);
				if($i == ($JumPaket - 1)){
					$i = 0;
				}else{
					$i++;
				}
			}
		}

		$success = array("status" => true, "pesan" => "Data Jadwal Peserta berhasil tersimpan");
		echo json_encode($success);
		
	}

	public function save($data){
		$data['TglCreate'] = date("Y-m-d H:i:s");
		try{
			$execute = $this->m->save_data($data);
			return true;
			
		}catch(Exception $e){
			$error = array("status" => FALSE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
	}


	public function ubah(){
		$Id = $this->input->post('Id');
		$this->delete_soal_tkdb($Id);
        $data['Noktp'] = $this->input->post('NoKtp');
		$data['Peserta'] = json_encode($this->m->get_peserta_one($data['Noktp']));
		$data['Dari'] = $this->input->post('Dari');
		$data['Sampai'] = $this->input->post('Sampai');
		$data['KodePaket'] = $this->input->post('KodePaket');
		$data['PaketSoal']  = json_encode($this->m->get_paket_one($data['KodePaket']));
		$data['Flag'] = "0";
		try {
			$this->m->update_data($data,$Id);	
			$success = array("status" => TRUE, "pesan" => "Data Jadwal Peserta berhasil terupdate");
			echo json_encode($success);
		} catch (Exception $e) {
			$error = array("status" => TRUE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
	}

	function delete_soal_tkdb($Id){
		$data = $this->m->detail_data($Id);
		$this->m->delete_soal_tkdb($data->KodePaket,$data->Noktp);
		return true;
	}

	public function hapus(){
		try {
			$Id = $this->input->get('Id');
			$this->m->delete_data($Id);
			$success = array("status" => TRUE, "pesan" => "Data Jadwal Peserta berhasil dihapus");
			echo json_encode($success);
		} catch (Exception $e) {
			$error = array("status" => TRUE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
		
		
	}

}
