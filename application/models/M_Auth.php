<?php
date_default_timezone_set('Asia/Makassar');
class M_Auth extends CI_Model {

        function __construct(){
            parent::__construct();
            $this->load->library('Mylib');
            
        }    

        function proses_login($data){
            $this->db->select("Username,Id,Passwords,Nama");
            $this->db->where('Username', $data['Username']);
            $query = $this->db->get("tb_login");
            $row = $query->num_rows();
            $password = $data['Password'];
            if($row > 0){
                $r = $query->row();
                $rs['data']['user'] = $r;
                if($password === $r->Passwords){
                    $rs['status'] = TRUE;
                    return $rs;
                }else{
                    $rs['data'] = "";
                    $rs['pesan'] = "Password yang anda masukkan salah!";
                    $rs['status'] = FALSE;
                    return $rs;
                }
            }else{
                $rs['data'] = "";
                $rs['pesan'] = "Username yang anda masukkan salah!";
                $rs['status'] = FALSE;
                return $rs;
            }
             
        }

        function proses_login_peserta($data){
            $this->db->where('Noktp', $data['Noktp']);
            $query = $this->db->get("tb_peserta");
            $row = $query->num_rows();
            $password = $data['Password'];
            if($row > 0){
                $r = $query->row();
                $rs['data']['user'] = $r;
                if($password === $r->Password){
                    $rs['status'] = TRUE;
                    return $rs;
                }else{
                    $rs['data'] = "";
                    $rs['pesan'] = "Password yang anda masukkan salah!";
                    $rs['status'] = FALSE;
                    return $rs;
                }
            }else{
                $rs['data'] = "";
                $rs['pesan'] = "Username yang anda masukkan salah!";
                $rs['status'] = FALSE;
                return $rs;
            }
             
        }
        
        function cek_login(){
            if(empty($this->session->userdata('is_login'))){
                redirect('admins/auths');
            }
        }

        function cek_login_member(){
            if(empty($this->session->userdata('is_login'))){
                redirect('auths');
            }
        }

        function cek_jadwal($Noktp){
            $this->db->where('Noktp', $Noktp);
            $query = $this->db->get("tb_jadwal");
            $row = $query->num_rows();
            if($row > 0){
                $TglNow = date("Y-m-d");
                $dt = $query->row();
                if($TglNow >= $dt->Dari && $TglNow < $dt->Sampai){
                    $rs['pesan'] = "";
                    $rs['status'] = TRUE;   
                    return $rs;
                }else{
                    $rs['pesan'] = "Anda telah di jadwalkan pada <b>".$this->mylib->tgl_indo($dt->Dari)."</b>";
                    $rs['status'] = FALSE;
                    return $rs;
                }
            }else{
                $rs['pesan'] = "Anda belum di jadwalkan!";
                $rs['status'] = FALSE;
                return $rs;
            }
        }

        


}