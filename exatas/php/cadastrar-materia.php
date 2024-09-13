<?php
$host = 'localhost';
$dbname = 'exatas';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    require_once 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Controller\ControllerCadastro.php';

    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $controller = new MateriaController($pdo);

    if ($action === 'cadastrar') {
        $controller->cadastrar();
    } else {
        require 'C:\xampp\htdocs\trabalho-finall\exatas\php\cadastrar-materia.php';
    }
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Matéria</title>
</head>
<body>
    <h1>Cadastro de Matéria</h1>
    <form action="index.php?action=cadastrar" method="post" enctype="multipart/form-data">
        <label for="oquee">O que é:</label>
        <input type="text" id="oquee" name="oquee" required><br>
        
        <label for="ondeusa">Onde usa:</label>
        <input type="text" id="ondeusa" name="ondeusa" required><br>
        
        <label for="exemplo">Exemplo:</label>
        <input type="text" id="exemplo" name="exemplo" required><br>
        
        <label for="formula">Fórmula:</label>
        <input type="file" id="formula" name="formula" required><br>
        
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
