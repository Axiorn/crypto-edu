<?php
require_once __DIR__ . '/../helpers/ScryptHelper.php';
require_once __DIR__ . '/../helpers/SuperEncryptHelper.php';
require_once __DIR__ . '/../helpers/ChaChaHelper.php';

class DatabaseController extends Controller {
    private $encModel;

    public function __construct() {
        $this->encModel = $this->model('EncryptedModel');
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/Auth/login');
            exit;
        }
    }

    // 🔹 Menampilkan data terenkripsi milik user
    public function index() {
        $passwords = $this->encModel->getDemoPasswords();
        $texts = $this->encModel->getDemoTexts();
        $this->view('database/index', ['passwords' => $passwords, 'texts' => $texts]);
    }

    // 🔹 Menyimpan data terenkripsi milik user
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $feature_name = $_POST['feature_name'];
            $plaintext = $_POST['plaintext'];

            $this->encModel->saveEncryptedData($feature_name, $_SESSION['user']['id'], $plaintext);
            header('Location: ' . BASEURL . '/Database');
        }
    }

    // 🔹 Menyimpan hasil demo password (Scrypt → ChaCha20)
    public function storeDemoPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            if (!$password) {
                echo json_encode(['success' => false, 'error' => 'Password kosong']);
                exit;
            }

            $scrypt = ScryptHelper::hash($password);
            $chacha = ChaChaHelper::encrypt($scrypt);

            $this->encModel->saveDemoPassword($password, $scrypt, $chacha);
            echo json_encode(['success' => true]);
            exit;
        }
    }

    // 🔹 Menyimpan hasil demo teks (Scytale + Salsa20 → ChaCha20)
    public function storeDemoText() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $text = $_POST['text'] ?? '';
            if (!$text) {
                echo json_encode(['success' => false, 'error' => 'Teks kosong']);
                exit;
            }

            $super = SuperEncryptHelper::encrypt($text);
            $chacha = ChaChaHelper::encrypt($super);

            $this->encModel->saveDemoText($text, $super, $chacha);
            echo json_encode(['success' => true]);
            exit;
        }
    }

    // 🔹 Menampilkan isi tabel demo (opsional jika ingin pisah dari index)
    public function demo() {
        $passwords = $this->encModel->getDemoPasswords();
        $texts = $this->encModel->getDemoTexts();
        $this->view('database/demo', ['passwords' => $passwords, 'texts' => $texts]);
    }

    // 🔹 Menampilkan penjelasan algoritma ChaCha20
    public function explain() {
        $this->view('database/explain');
    }
}
