<?php
require_once 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Model\ModelCadastro.php';

class MateriaController {
    private $model;

    public function __construct($pdo) {
        $this->model = new MateriaModel($pdo);
    }

    public function cadastrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $oquee = $_POST['oquee'];
            $ondeusa = $_POST['ondeusa'];
            $exemplo = $_POST['exemplo'];
            $formula = $_FILES['formula'];

            $success = $this->model->cadastrarMateria($oquee, $ondeusa, $exemplo, $formula);

            if ($success) {
                echo "Matéria cadastrada com sucesso!";
            } else {
                echo "Erro ao cadastrar a matéria.";
            }
        }
    }
}
