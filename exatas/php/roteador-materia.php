<?php
require_once 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Controller\ControllerMateria.php';

$controller = new CadastroController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->salvar();
} else {
    $controller->index();
}
?>
