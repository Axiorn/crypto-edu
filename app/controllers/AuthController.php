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
    public function login() {
        $data = [];
        if (!empty($_SESSION['flash_message'])) {
            $data['success'] = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $user = $this->userModel->getByUsername($username);

            if ($user && sodium_crypto_pwhash_str_verify($user['password_hash'], $password)) {
                $_SESSION['user'] = $user['username'];
                header('Location: ' . BASEURL . '/Dashboard');
                exit;
            } else {
                $data['error'] = 'Username atau password salah.';
            }
        }

        require_once '../app/views/auth/login.php';
    }
    public function register(){
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            try {
                $this->userModel->create($username, $password);

                // Simpan pesan flash
                $_SESSION['flash_message'] = 'Akun berhasil dibuat dengan aman.';

                // Redirect ke halaman login
                header('Location: ' . BASEURL . '/Auth/login');
                exit;
            } catch (Exception $e) {
                $data['error'] = $e->getMessage();
            }
        }

        require_once '../app/views/auth/register.php';
    }
}
?>