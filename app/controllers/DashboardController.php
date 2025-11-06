<?php
// app/controllers/DashboardController.php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../models/EncryptionDemo.php';

class DashboardController {
    private $demoModel;

    public function __construct() {
        $this->demoModel = new EncryptionDemo();
    }

    public function index() {
        $section = $_POST['section'] ?? 'menu';
        $data = [];

        switch ($section) {
            case 'login_demo':
                if (isset($_POST['run_login'])) {
                    $username = $_POST['username'] ?? '';
                    $password = $_POST['password'] ?? '';
                    $data['username'] = htmlspecialchars($username);
                    $data['password'] = htmlspecialchars($password);
                    $data['hash'] = $this->demoModel->scryptHash($password);
                    $data['stage'] = 'login_result';
                } elseif (isset($_POST['explain_login'])) {
                    $data['stage'] = 'login_explain';
                } else {
                    $data['stage'] = 'login_demo';
                }
                break;

            case 'superenkripsi':
                if (isset($_POST['run_super'])) {
                    $plain = $_POST['plaintext'] ?? '';
                    $scytale = $this->demoModel->scytaleEncrypt($plain);
                    $salsa = $this->demoModel->salsaEncrypt($scytale);
                    $data['plain'] = $plain;
                    $data['scytale'] = $scytale;
                    $data['salsa'] = $salsa;
                    $data['stage'] = 'super_result';
                } elseif (isset($_POST['explain_super'])) {
                    $data['stage'] = 'super_explain';
                } else {
                    $data['stage'] = 'super_demo';
                }
                break;

            case 'file':
                if (isset($_POST['run_file'])) {
                    $data['file_demo'] = 'File berhasil dienkripsi (simulasi).';
                    $data['stage'] = 'file_result';
                } elseif (isset($_POST['explain_file'])) {
                    $data['stage'] = 'file_explain';
                } else {
                    $data['stage'] = 'file_demo';
                }
                break;

            case 'stegano':
                if (isset($_POST['run_stegano'])) {
                    $msg = $_POST['hidden_msg'] ?? '';
                    $data['result'] = "Pesan berhasil disisipkan ke gambar (simulasi): '$msg'";
                    $data['stage'] = 'stegano_result';
                } elseif (isset($_POST['explain_stegano'])) {
                    $data['stage'] = 'stegano_explain';
                } else {
                    $data['stage'] = 'stegano_demo';
                }
                break;

            case 'database':
                $data['stage'] = 'database_explain';
                break;

            default:
                $data['stage'] = 'menu';
        }

        require_once __DIR__ . '/../views/dashboard/index.php';
    }
}
