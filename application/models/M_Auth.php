<?php

class M_Auth extends CI_Model {
        
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

        


}