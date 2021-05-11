<?php

class M_Auth extends CI_Model {
        
        function proses_login($data){
            $this->db->select("Username,IdPejabat,Password,Level");
            $this->db->where('Username', $data['Username']);
            $query = $this->db->get("mkp_user");
            $row = $query->num_rows();
            $password = md5("mkp".$data['Password']);
            if($row > 0){
                $r = $query->row();
                $rs['data']['user'] = $r;
                if($password === $r->Password){
                    $rs['data']['diri'] = $this->get_data_diri($r->IdPejabat);
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
        

        function get_data_diri($Id){
            $this->db->where('Id', $Id);
            return $this->db->get("mkp_pejabat")->row(); 
        }

       

        function cek_login(){
            if(empty($this->session->userdata('is_login'))){
                redirect('auths');
            }
        }

        


}