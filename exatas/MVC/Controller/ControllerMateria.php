<?php
class ExemploController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function cadastrar() {
        if (isset($_POST['oquee']) && isset($_POST['ondeusa']) && isset($_POST['exemplo']) && isset($_FILES['formula'])) {
            $oquee = $_POST['oquee'];
            $ondeusa = $_POST['ondeusa'];
            $exemplo = $_POST['exemplo'];
            $formula = $_FILES['formula'];

            $uploadDir = './uploads';
            $uploadFile = $uploadDir . basename($formula['name']);

            if (move_uploaded_file($formula['tmp_name'], $uploadFile)) {
                if ($this->model->cadastrar($oquee, $ondeusa, $exemplo, $uploadFile)) {
                    header('Location: ../MVC/Views/ViewsMateria.php');
                    exit;
                } else {
                    echo "Erro ao salvar os dados no banco de dados.";
                }
            } else {
                echo "Erro ao fazer o upload da imagem.";
            }
        }
    }
}
?>
