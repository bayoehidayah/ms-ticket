<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

	class Incident extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			check_session();
		}

		public function index(){
			// $data["it_support"] = $this->model_auth->getITSupport();

			$data["incident"] = $this->model_incident->getAllTicket();
			if($this->input->get("status")){
				$data["incident"] = $this->model_incident->getAllTicket([
					"status" => $this->input->get("status")
				]);
			}

			$data["js"] = "pages/incident/index_js.php";

			$status = $this->model_incident->listStatus;
			if(!isItSupport()){
				unset($status["assign"]);
				unset($status["resolved"]);
			}

			$data["it_support"] = [
				"Dedi Sianturi",
				"Muhammad Aji Alfaridzi",
				"Rahmat Rezki"
			];

			$data["status"]     = $status;
			$data["listStatus"] = $this->model_incident->listStatus;
			$data["service"]    = $this->model_incident->listServiceType;
			$data["urgent"]     = $this->model_incident->listUrgent;
			$data["priority"]   = $this->model_incident->maxPriority;

			// echo json_encode($data);
			$this->themes->primary("pages/incident/index", $data);
		}

		public function saveIncident(){
			try {
				$this->db->trans_begin();

				$set = $this->input->post();
				// if(!$this->model_auth->isExist($set['it_support'])){
				// 	throw new \Exception("IT Support not found");
				// }

				$id = $this->input->post("id_ticket");
				// $set["id_pengguna"]   = getIDAuth();
				// $set["id_it_support"] = $set["it_support"];
				unset($set["id_ticket"]);
				// unset($set["it_support"]);

				if ($id == null || $id == "") {
					if(!$this->model_incident->insertTicket($set)){
						throw new \Exception("Failed to insert ticket");
					}
				}
				else{
					if(!$this->model_incident->updateTicket($id, $set)){
						throw new \Exception("Failed to insert ticket");
					}
				}


				$this->db->trans_commit();
				$return = [
					"result" => "success",
					"title"  => "Ticket berhasil dibuat"
				];
			} catch (\Throwable $th) {
				$this->db->trans_rollback();
				$return = [
					"result" => "error",
					"title"  => $th->getMessage()
				];
			}
			echo json_encode($return);
		}

		public function showResolved($id){
			try {
				if(!$this->model_incident->checkTicket($id)){
					throw new \Exception("Ticket not found");
				}

				$data = $this->model_incident->getDataTicketResolved($id);

				$return = [
					"result" => "success",
					"title" => "Berhasil mengambil data",
					"data" => $data
				];

			} catch (\Throwable $th) {
				$return = [
					"result" => "error",
					"title"  => $th->getMessage()
				];
			}
			echo json_encode($return);	
		}

		public function editIncident($id){
			try {
				if(!$this->model_incident->checkTicket($id)){
					throw new \Exception("Ticket not found");
				}

				$data = $this->model_incident->getDataTicket($id);

				$return = [
					"result" => "success",
					"title" => "Berhasil mengambil data ticket",
					"data" => $data
				];

			} catch (\Throwable $th) {
				$return = [
					"result" => "error",
					"title"  => $th->getMessage()
				];
			}
			echo json_encode($return);	
		}

		public function delIncident($id){
			try {
				$this->db->trans_begin();

				if(!$this->model_incident->checkTicket($id)){
					throw new \Exception("Ticket not found");
				}
				
				if(!$this->model_incident->deleteTicket($id)){
					throw new \Exception("Failed to deleted ticket");
				}

				$this->db->trans_commit();
				$return = [
					"result" => "success",
					"title"  => "Ticket berhasil dihapus"
				];

			} catch (\Throwable $th) {
				$this->db->trans_rollback();
				$return = [
					"result" => "error",
					"title"  => $th->getMessage()
				];
			}
			echo json_encode($return);
		}

		public function setStatus($id){
			try {
				$this->db->trans_begin();

				if(!$this->model_incident->checkTicket($id)){
					throw new \Exception("Ticket not found");
				}
				
				$status = $this->input->get("status");
				if(!array_key_exists($status, $this->model_incident->listStatus)){
					throw new \Exception("Status not found");
				}

				if($status == "assign"){
					if(!$this->model_incident->insertTicketResolved([
						"id_ticket"    => $id,
						"cause"        => $this->input->post("cause"),
						"resolved_ket" => $this->input->post("resolved_ket"),	
					])){
						throw new \Exception("Failed to insert incident resolved");
					}	

					if(!$this->model_incident->updateTicket($id, [
						"status" => $this->model_incident->setNewStatus($status)
					])){
						throw new \Exception("Failed to update ticket");
					}
				}
				else{
					if(!$this->model_incident->updateTicket($id, ["status" => $this->model_incident->setNewStatus($status)])){
						throw new \Exception("Failed to set status");
					}
				}


				$this->db->trans_commit();
				$return = [
					"result" => "success",
					"title"  => "Ticket status berhasil diubah"
				];

			} catch (\Throwable $th) {
				$this->db->trans_rollback();
				$return = [
					"result" => "error",
					"title"  => $th->getMessage()
				];
			}
			echo json_encode($return);
		}
	}
?>
