<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

	class Dashboard extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			check_session();
		}

		public function index(){
			$data["js"] = "pages/dashboard/index_js.php";
			$this->themes->primary("pages/dashboard/index", $data);
		}
	}
?>
