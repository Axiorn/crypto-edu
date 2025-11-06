<?php
class SuperEncController extends Controller {
    private $model;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/Auth/login');
            exit;
        }
        $this->model = $this->model('SuperEncModel');
    }

    public function index() {
        $this->view('superenc/index');
    }

    public function encrypt() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $text = $_POST['text'];
            $key = (int) $_POST['key'];
            $user_id = $_SESSION['user']['id'];

            $encrypted = $this->model->superEncrypt($text, $key, $user_id);

            $this->view('superenc/index', [
                'text' => $text,
                'encrypted' => $encrypted,
                'key' => $key
            ]);
        }
    }
}
