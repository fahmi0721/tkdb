<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mylib {

    public function hari_indo($tgl) {
		$tanggal = $tgl;
		$day = date('D', strtotime($tanggal));
		$dayList = array(
			'Sun' => 'Minggu',
			'Mon' => 'Senin',
			'Tue' => 'Selasa',
			'Wed' => 'Rabu',
			'Thu' => 'Kamis',
			'Fri' => 'Jumat',
			'Sat' => 'Sabtu'
		);
		return $dayList[$day];
	}

	//====== FUNGSI JAM INDONESIA ===///
	public function jam_indo($tgl){
		$timestamp = strtotime($tgl);
		return date("g:i:s A", $timestamp);
	}

	//====== FUNGSI TANGGAL INDONESIA ===///
	public function tgl_indo($tgl){
		$tanggal = substr($tgl,8,2);
		$bulan = $this->getBulan(substr($tgl,5,2));
		$tahun = substr($tgl,0,4);
		return $tanggal.' '.$bulan.' '.$tahun;		 
	}

	public function getBulan($bln){
	    switch ($bln){
	        case 1:
	          return "Januari";
	          break;
	        case 2:
	          return "Februari";
	          break;
	        case 3:
	          return "Maret";
	          break;
	        case 4:
	          return "April";
	          break;
	        case 5:
	          return "Mei";
	          break;
	        case 6:
	          return "Juni";
	          break;
	        case 7:
	          return "Juli";
	          break;
	        case 8:
	          return "Agustus";
	          break;
	        case 9:
	          return "September";
	          break;
	        case 10:
	          return "Oktober";
	          break;
	        case 11:
	          return "November";
	          break;
	        case 12:
	          return "Desember";
	          break;
	    }
	}


	public function angka($str){
		$str = preg_replace( '/[^0-9]/', '', $str );
		return $str;
	}
}