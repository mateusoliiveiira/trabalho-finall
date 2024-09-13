<?php
// Configurações do banco de dados
$host = 'localhost';
$dbname = 'exatas';
$user = 'root';
$pass = '';

// Conexão com o banco de dados
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

// Inclui os arquivos de model e controller
require_once 'ExemploModel.php';
require_once 'ExemploController.php';

// Cria uma instância do modelo e do controller
$model = new ExemploModel($pdo);
$controller = new ExemploController($model);

// Checa se há um ID na URL e se o método é GET ou POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $controller->atualizar($_GET['id']);
} elseif (isset($_GET['id'])) {
    $controller->mostrarFormularioAtualizacao($_GET['id']);
} else {
    echo "Erro: ID não fornecido.";
}
?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Atualizar Exemplo</title>
</head>
<body>
    <h1>Atualizar Exemplo</h1>

    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
        <p style="color: green;">Dados atualizados com sucesso!</p>
    <?php endif; ?>

    <?php if (isset($dados)): ?>
    <form method="POST" action="atualizar.php?id=<?= $dados['id']; ?>" enctype="multipart/form-data">
        <label for="oquee">O que é:</label>
        <input type="text" name="oquee" id="oquee" value="<?= $dados['oquee']; ?>" required><br>

        <label for="ondeusa">Onde Usar:</label>
        <input type="text" name="ondeusa" id="ondeusa" value="<?= $dados['ondeusa']; ?>" required><br>

        <label for="exemplo">Exemplo:</label>
        <textarea name="exemplo" id="exemplo" required><?= $dados['exemplo']; ?></textarea><br>

        <label for="formula">Fórmula (imagem):</label>
        <input type="file" name="formula" id="formula" accept="image/*"><br>
        
        <button type="submit">Atualizar</button>
    </form>
    <?php endif; ?>
</body>
</html>
