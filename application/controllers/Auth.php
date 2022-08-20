<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Auth extends CI_Controller{

        function __construct(){
            parent::__construct();
        }

        function index(){
            check_login();
            $data['page_title'] = "Halaman Login";
            $data['js'] = APPPATH."views/auth/login_js.php";
            $this->themes->login("auth/login", $data);
        }

        function pass(){
            $data = password_hash("password", PASSWORD_BCRYPT);
            echo $data;
        }

        function checkLogin(){
            $username = $this->input->post("username");
            $password = $this->input->post("password");

            if($this->model_auth->checkUser($username)){
                $dataUser = $this->model_auth->getDataUser(["username" => $username]);
                if(password_verify($password, $dataUser['password'])){
                    $this->session->set_userdata($dataUser);
                    $this->session->set_userdata(["status_login" => true]);
                    $data['result'] = "success";
					$data['title'] = "Login Berhasil";
                }
                else{
                    $data['result'] = "error";
                    $data['title'] = "Username atau password anda salah!";
                }
            }
            else{
                $data['result'] = "error";
                $data['title'] = "Username atau password anda salah!";
            }

            echo json_encode($data);
        }

        function logout(){
            session_destroy();
            redirect(base_url());
        }

        function checkLevel(){
            if($this->session->userdata("levuser") == "Super"){ return true; }
            else{ return false; }
        }

        //User Pass --------------------------------------------------------------------
        function dataPegawai(){
            $kdepeg = $this->input->post("kdepeg");
            if($this->model_pegawai->checkPegawaiRem($kdepeg) && $this->checkLevel() ){
                $data['result'] = true;
                $data['pegawai'] = $this->model_pegawai->getPegawaiRem($kdepeg);
                $data['pegawai']['kdeukerja'] = $this->model_pegawai->getSatKer($data['pegawai']['kdesatker'])['kdeukerja'];
            }
            else{
                $data['result'] = false;
                $data['msg'] = "Pegawai tidak diketahui";
            }
            echo json_encode($data);
        }

        function userPass(){
            if($this->checkLevel()){
                check_session();
                $data['page_title'] = "User Password - Pegawai";
                $data['topbar_title'] = "User Password";
                $data['bread'] = [
                    [false, "Pegawai", "javascript:void(0);"],
                    [true, "User Password", "javascript:void(0);"]
                ];
                $data['js'] = APPPATH."views/auth/user_pass/user_js.php";
                $this->themes->primary("auth/user_pass/user_list", $data);
            }
            else{
                redirect(base_url());
            }
        }

        function userPassBaru(){
            if($this->checkLevel()){
                check_session();
                $data['page_title'] = "Tabel User Password - Tabel Referensi";
                $data['topbar_title'] = "Tabel User Password Baru";
                $data['bread'] = [
                    [false, "Tabel Referensi", "javascript:void(0);"],
                    [false, "Tabel User Password", base_url("pegawai/user-password")],
                    [true, "Tabel User Password Baru", "javascript:void(0);"]
                ];
                
                //For Form
                $data['edit'] = false;
                $data['pegawai'] = $this->model_pegawai->getPegawaiRem();
                
                $data['js'] = APPPATH."views/auth/user_pass/user_form_js.php";
                $this->themes->primary("auth/user_pass/user_form", $data);
            }
            else{
                redirect(base_url());
            }
        }

        function newUserPass(){
            if($this->checkLevel()){
                check_session();
                $kdepeg = $this->input->post("pegawai");
                if($this->model_auth->checkPegawai($kdepeg)){
                    $data['result'] = false;
                    $data['msg'] = "Pegawai telah mempunyai akun. <br/> Tidak dapat menambahkan akun.";
                }
                else{
                    $username = $this->input->post("username");
                    if($this->model_auth->checkUser($username)){
                        $data['result'] = false;
                        $data['msg'] = "Username telah digunakan. <br/> Silahkan mencoba username lain.";
                    }
                    else{
                        $password = password_hash($this->input->post("password"), PASSWORD_BCRYPT);
                        $kdeaplikasi = $this->input->post("kdeaplikasi");
                        $levuser = $this->input->post("user_level");
                        $ukerja = $this->input->post("ukerja");
                        $satker = $this->input->post("satker");
        
                        //Hak Akses
                        $akses = $this->input->post("akses");
                        $all = false;
                        $read = false;
                        $view = false;
                        $update = false;
                        $delete = false;
                        for($i = 0; $i < sizeof($akses); $i++){
                            if($akses[$i] == "all_true"){
                                $all = true;
                                $read = true;
                                $view = true;
                                $update = true;
                                $delete = true;
                            }
                            else if($akses[$i] == "view_true"){
                                $view = true;
                            }
                            else if($akses[$i] == "read_true"){
                                $read = true;
                            }
                            else if($akses[$i] == "update_true"){
                                $update = true;
                            }
                            else if($akses[$i] == "delete_true"){
                                $delete = true;
                            }
                        }
        
                        $set = [
                            "kdepeg" => $kdepeg,
                            "nmalogin" => $username,
                            "paswuser" => $password,
                            "kdeaplikasi" => $kdeaplikasi,
                            "levuser" => $levuser,
                            "o_all" => $all,
                            "o_read" => $read,
                            "o_update" => $update,
                            "o_delete" => $delete,
                            "o_view" => $view,
                            "kdeukerja" => $ukerja,
                            "kdesatker" => $satker
                        ];
        
                        $insert = $this->db->insert("tmuser", $set);
                        if($insert){
                            $data['result'] = true;
                            $data['msg'] = "Akun untuk pegawai tersebut telah berhasil dibuat";
                        }
                        else{
                            $data['result'] = false;
                            $data['msg'] = "Terjadi kesalahan dalam membuat akun";
                        }
                    }
                }
        
                echo json_encode($data);
            }
            else{
                redirect(base_url());
            }
        }

        function getDataUserPass(){
            if($this->checkLevel()){
                check_session();
                $search = $_POST['search']['value'];
                $limit = $_POST['length'];
                $start = $_POST['start'];
                $order_index = $_POST['order'][0]['column'];
                $order_field = $_POST['columns'][$order_index]['data'];
                $order_ascdesc = $_POST['order'][0]['dir'];
                
                $sql_total = $this->model_auth->countAllUserPass(); 
                $sql_data = $this->model_auth->userPassFilter($search, $limit, $start, $order_field, $order_ascdesc);
                $sql_filter = $this->model_auth->countFilterUserPass($search);
                
                $callback = array(
                    'draw' => $_POST['draw'],
                    'recordsTotal' => $sql_total,
                    'recordsFiltered' => $sql_filter,
                    'data' => $sql_data
                );
                header('Content-Type: application/json');
                echo json_encode($callback);
            }
            else{
                redirect(base_url());
            }
        }
        
        function delUserPass($kdepeg){
            check_session();
            if($this->model_auth->checkPegawai($kdepeg) && $this->checkLevel()){
                $delete = $this->db->delete("tmuser", ["kdepeg" => $kdepeg]);
                if($delete){
                    $data['result'] = true;
                }
                else{
                    $data['result'] = false;
                    $data['msg'] = "Terjadi kesalahan dalam menghapus akun";
                }
            }
            else{
                $data['result'] = false;
                $data['msg'] = "Data akun tidak diketahui";
            }
            echo json_encode($data);
        }
        //End User Pass ----------------------------------------------------------------
    }
?>
