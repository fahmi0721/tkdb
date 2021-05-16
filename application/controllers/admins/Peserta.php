<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Makassar');
class Peserta extends CI_Controller {

	
    function __construct(){
		parent::__construct();
		$this->load->model('M_Auth',"login");
		$this->load->model('M_Peserta',"m");
		$this->load->library('Excel'); //load librari excel
		$this->load->library('Mylib'); //Libku
    	$this->login->cek_login();
		
	}

	public function index()
	{
		$header['title_page'] = "TKDB Online | Peserta";
		$this->load->view('_template/header',$header);
		$this->load->view('admin/pekerja/detail');
        $this->load->view('_template/footer');

	}


	public function import_excel(){
		$fileName = $_FILES['file']['name'];
        $config['upload_path'] = './public/file/'; //path upload
        $config['file_name'] = $fileName;  // nama file
        $config['allowed_types'] = 'xls|xlsx|csv'; //tipe file yang diperbolehkan
        $config['max_size'] = 10000; // maksimal sizze
 
        $this->load->library('upload'); //meload librari upload
        $this->upload->initialize($config);
          
        if(! $this->upload->do_upload('file') ){
            echo $this->upload->display_errors();exit();
        }
              
        $inputFileName = './public/file/'.$fileName;
 
        try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
        } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
        }
 
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();

		for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array                 
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
											NULL,
											TRUE,
											FALSE);   

				// Sesuaikan key array dengan nama kolom di database  
				$InvDate =  $rowData[0][3];
				$InvDate = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($InvDate));
				$data = array(
					"Noktp"=> $rowData[0][1],
					"Nama"=> strtoupper($rowData[0][2]),
					"TglLahir"=> $InvDate,
					"Jabatan"=> strtoupper($rowData[0][4]),
					"UnitKerja"=> strtoupper($rowData[0][5])
				);
				$this->save_upload($data);
		}
		unlink($inputFileName);
		$success = array("status" => TRUE, "pesan" => "Data Peserta berhasil tersimpan");
					echo json_encode($success);
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
            $row[] = "<b>".$field->Nama."</b><br>"."<small>No Peserta : ".$field->NomorPeserta."</small><br>"."<small>No KTP : ".$field->Noktp."</small><br /><small>Tanggal Lahir : ".$this->mylib->tgl_indo($field->TglLahir)."</small>";
            $row[] = $field->Jabatan."<br>"."<small>Unit Kerja : ".$field->UnitKerja."</small>";
            $row[] = "<center><span class='btn-group'><a data-toggle='tooltip' href='".base_url()."admins/peserta/edit?Id=".$field->Id."' title='Ubah Data' class='btn btn-primary btn-xs'><i class='fa fa-edit'></i></a><a data-toggle='tooltip' href='javascript:void(0)' title='Hapus Data' onclick='HapusData(".$field->Id.")' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a></span></center>";
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

	public function edit()
	{
		$Id = $this->input->get('Id');
		$data['Peserta'] = $this->m->detail_data($Id);
		$data['UnitKerja'] = $this->m->get_unit_kerja();
		$header['title_page'] = "TKDB Online | Ubah Peserta A.n ".$data['Peserta']->Nama;
		$this->load->view('_template/header',$header);
		$this->load->view('admin/pekerja/form-edit',$data);
        $this->load->view('_template/footer');

	}

	public function form_tambah()
	{
		$data['UnitKerja'] = $this->m->get_unit_kerja();
		$header['title_page'] = "TKDB Online | Tambah Peserta";
		$this->load->view('_template/header',$header);
		$this->load->view('admin/pekerja/form-tambah',$data);
        $this->load->view('_template/footer');
	

	}

	public function form_upload()
	{
		$header['title_page'] = "TKDB Online | Upload Peserta";
		$this->load->view('_template/header',$header);
		$this->load->view('admin/pekerja/form-upload');
        $this->load->view('_template/footer');
	

	}
	
	public function generate_password($tgl_lahir){
		$pisah = explode("-",$tgl_lahir);
		$tahun = $pisah[0];
		$bulan = $pisah[1];
		$hari = $pisah[2];
		$password = $hari.$bulan.substr($tahun,-2,2);
		return $password;
	}

	public function generate_nomor($TglLahir){
		$tgl_lahir = str_replace("-","",$TglLahir);
		$Nomor = "TKDB-".$tgl_lahir."-".time();
		return $Nomor;
	}

	public function save_upload($data){
		$data['NomorPeserta'] = $this->generate_nomor($data['TglLahir']);
		$data['Password'] = md5($this->generate_password($data['TglLahir']));
		$data['TglCreate'] = date("Y-m-d H:i:s");
		try{
			if($this->m->cek_data_by_ktp($data['Noktp']) <= 0){
				if(strlen($data['Noktp']) === 16){
					$execute = $this->m->save_data($data);
					return true;
				}
			}
			
		}catch(Exception $e){
			$error = array("status" => FALSE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
	}

	

	public function tambah(){
		$data['NomorPeserta'] = $this->generate_nomor($this->input->post('TglLahir'));
		$data['Nama'] = strtoupper($this->input->post('Nama'));
		$data['Jabatan'] = strtoupper($this->input->post('Jabatan'));
		$data['UnitKerja'] = strtoupper($this->input->post('UnitKerja'));
		$data['TglLahir'] = $this->input->post('TglLahir');
		$data['NoKtp'] = $this->input->post('NoKtp');
		$data['Password'] = md5($this->generate_password($this->input->post('TglLahir')));
		$data['TglCreate'] = date("Y-m-d H:i:s");
		try{
			if($this->m->cek_data_by_ktp($this->input->post('NoKtp')) <= 0){
				if(strlen($this->input->post('NoKtp')) === 16){
					$execute = $this->m->save_data($data);
					$success = array("status" => TRUE, "pesan" => "Data Peserta berhasil tersimpan");
					echo json_encode($success);
				}else{
					$error = array("status" => FALSE, "pesan" => "Pastikan No KTP yang dimasukkan valid!. periksa kembali No KTP yang anda dimasukkan");
					echo json_encode($error);
				}
			}else{
				$error = array("status" => FALSE, "pesan" => "data dengan No KTP ".$this->input->post('NoKtp')." telah terdaftar");
				echo json_encode($error);
			}
			
		}catch(Exception $e){
			$error = array("status" => FALSE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
	}


	public function ubah(){
		$Id = $this->input->post('Id');
		$data['Nama'] = strtoupper($this->input->post('Nama'));
		$data['Jabatan'] = strtoupper($this->input->post('Jabatan'));
		$data['UnitKerja'] = strtoupper($this->input->post('UnitKerja'));
		$data['TglLahir'] = $this->input->post('TglLahir');
		$data['NoKtp'] = $this->input->post('NoKtp');
		$data['Password'] = md5($this->generate_password($this->input->post('TglLahir')));
		try {
			$this->m->update_data($data,$Id);	
			$success = array("status" => TRUE, "pesan" => "Data Peserta berhasil terupdate");
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
			$success = array("status" => TRUE, "pesan" => "Data Peserta berhasil dihapus");
			echo json_encode($success);
		} catch (Exception $e) {
			$error = array("status" => TRUE, "pesan" => $e->getMessage());
			echo json_encode($error);
		}
		
		
	}


}
