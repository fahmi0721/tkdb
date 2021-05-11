<?php

class M_Struktural extends CI_Model {
        
       function detail_data($Id=null){
            if(!empty($Id)){
                $this->db->where("Id",$Id);

            }
            return $this->db->get("mkp_struktural")->result_array();
       }

        function save_data($data){
            $this->db->insert("mkp_struktural", $data);
            return $this->db->affected_rows();
        }

        function update_data($data,$Id){
            $this->db->where("Id", $Id);
            $this->db->update("mkp_struktural", $data);
            return $this->db->affected_rows();
        }

        function delete_data($Id){
            $this->db->where("Id", $Id);
            $this->db->delete("mkp_struktural");
            return $this->db->affected_rows();
        }

        


}