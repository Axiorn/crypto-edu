<?php
require_once __DIR__ . '/../models/User.php';
class AuthController extends Controller {
    private $userModel;

    public function __construct(){
        $this->userModel = $this->model('User');
        session_start();
    }
    public function index(){
        header('Location: ' . BASEURL . '/Auth/login');
    }
    public function login(){
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->login($username, $password);

            if($user) {
                $_SESSION['user'] = $user;
                header('Location: ' . BASEURL . '/Encrypt');
                exit;
            } else {
                $error = "Username atau password salah.";
            }
        }
        $this->view('auth/login', isset($error) ? ['error' => $error] : []);
    }
    public function register(){
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if($this->userModel->register($username, $password)) {
                $success = "Registrasi berhasil.";
            } else {
                $error = "Registrasi gagal.";
            }
        }
        $this->view('auth/register', isset($error) ? ['error' => $error] : []);
    }
    public function logout(){
        session_destroy();
        header('Location: ' . BASEURL . '/Auth/login');
    }
}
?>