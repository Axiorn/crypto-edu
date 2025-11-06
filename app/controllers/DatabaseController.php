<?php
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

    public function index() {
        $data = $this->encModel->getDecryptedDataByUser($_SESSION['user']['id']);
        $this->view('database/index', ['records' => $data]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $feature_name = $_POST['feature_name'];
            $plaintext = $_POST['plaintext'];

            $this->encModel->saveEncryptedData($feature_name, $_SESSION['user']['id'], $plaintext);

            header('Location: ' . BASEURL . '/Database');
        }
    }
}
