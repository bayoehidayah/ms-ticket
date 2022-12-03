<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
	class Model_incident extends CI_Model{
		public $table  = "ticket";
		public $table2 = "ticket_resolved";

		public $listStatus = [
			"new"      => "New",
			"assign"   => "Assign",
			"resolved" => "Resolved",
		];

		public $listServiceType = [
			"aplikasi_pendukung_kerja"      => "Aplikasi  Pendukung Kerja",
			"jaringan_internet"             => "Jaringan  Internet",
			"perangkat_pc/laptop_internal"  => "Perangkat PC/Laptop Internal",
			"perangkat_pc/laptop_ms_lapto"  => "Perangkat PC/Laptop MS Lapto",
			"perangkat_pendukung"           => "Perangkat Pendukung",
			"server"                        => "Server",
		];

		public $listUrgent = [
			"critical" => "Critical",
			"high"     => "High",
			"medium"   => "Medium",
			"low"      => "Low",
		];

		public $maxPriority = 4;

		public function checkTicket($id){
			$check = $this->db->get_where($this->table, ["id" => $id])->num_rows();
			if($check > 0){ return true; }
			else {return false;}
		}

		public function setNewStatus($status){
			if ($status == "new") {
				return "assign";
			}
			else if($status == "assign"){
				return "resolved";
			}
			else{
				return $status;
			}
		}

		public function getAllTicket(){
			// if(isItSupport()){
				return $this->db->get($this->table)->result();
			// }
			
			// return $this->db->get_where($this->table, ["id_pengguna" => getIDAuth()])->result();
		}

		public function getTicketExport(){
			return $this->db
				->select($this->table.".*", $this->table2.".id_ticket")
				->join($this->table2, $this->table.".id=".$this->table2.".id_ticket")
				->get($this->table)
				->result();
		}

		public function getTicketResolvedExport($id_ticket){
			return $this->db->get_where($this->table2, ["id_ticket" => $id_ticket])->row();
		}

		public function getDataTicket($id){
			return $this->db->get_where($this->table, ["id" => $id])->row_array();
		}

		public function getDataTicketResolved($id){
			return $this->db->get_where($this->table2, ["id_ticket" => $id])->row_array();
		}

		public function insertTicket($data){
			date_default_timezone_set("Asia/Jakarta");
			$data["created_at"] = date("Y-m-d H:i:s");
			return $this->db->insert($this->table, $data);
		}

		public function updateTicket($id, $data){
			return $this->db->update($this->table, $data, ["id" => $id]);
		}

		public function deleteTicket($id){
			return $this->db->delete($this->table, ["id" => $id]);
		}

		public function insertTicketResolved($data){
			return $this->db->insert($this->table2, $data);
		}
	}
?>
