<?php
require_once '../config/config.php';
require_once '../MVC/Model/ModelMateria.php';
require_once '../MVC/Controller/ControllerMateria.php';

// Inicializa o model e o controller
$model = new ExemploModel($pdo);
$controller = new ExemploController($model);

// Processa o formulário de cadastro se for enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller->cadastrar();
}

// Inclui a view para exibir o formulário

?>
