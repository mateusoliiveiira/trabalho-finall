<?php
require_once 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Controller\ControllerTermos.php';

$controller = new TermoController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->salvar();
} else {
    $controller->index();
}
?>
