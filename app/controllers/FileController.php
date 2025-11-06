<?php
require_once 'app/models/FileModel.php';

class FileController {
    private $model;

    public function __construct() {
        $this->model = new FileModel();
    }

    public function index() {
        include 'app/views/file/upload.php';
    }

    public function encrypt() {
        if (isset($_FILES['file']) && isset($_POST['password'])) {
            $file = $_FILES['file'];
            $password = $_POST['password'];

            $result = $this->model->encryptFile($file, $password);

            include 'app/views/file/result.php';
        } else {
            echo "File dan password harus diisi!";
        }
    }

    public function decrypt() {
        if (isset($_FILES['file']) && isset($_POST['password'])) {
            $file = $_FILES['file'];
            $password = $_POST['password'];

            $result = $this->model->decryptFile($file, $password);

            include 'app/views/file/result.php';
        } else {
            echo "File dan password harus diisi!";
        }
    }
}
?>
