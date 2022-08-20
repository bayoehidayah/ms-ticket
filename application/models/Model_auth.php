<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Model_auth extends CI_Model{

		public $table = "pengguna";

        function checkUser($username){
            $check = $this->db->get_where($this->table, ["username" => $username])->num_rows();
            if($check > 0){ return true; }
            else {return false;}
        }

        function getDataUser($data){
            return $this->db->get_where($this->table, $data)->row_array();
        }
		
		function isExist($id){
			$check = $this->db->get_where($this->table, ["id" => $id])->num_rows();
			if($check > 0){ return true; }
			else {return false;}
		}

		function getUser($id){
			return $this->db->get_where($this->table, ["id" => $id])->row();
		}

		function getITSupport(){
			return $this->db->get_where($this->table, ["tipe" => "it_support"])->result();
		}
    }
?>
