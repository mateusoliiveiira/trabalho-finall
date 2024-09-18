<?php
// Conectar ao banco de dados
$host = 'localhost';
$dbname = 'exatas';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}

// Função para salvar nova matéria e retornar o ID gerado
function salvarMateria($pdo, $nome) {
    $sql = 'INSERT INTO materias (nome) VALUES (:nome)';
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute(['nome' => $nome]);
        // Retornar o ID da matéria recém-cadastrada
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        die("Erro ao salvar matéria: " . $e->getMessage());
    }
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'])) {
    $nome = $_POST['nome'];
    // Salvar a matéria e obter o ID gerado
    $materia_id = salvarMateria($pdo, $nome);
    // Gerar mensagem de sucesso e link para a nova matéria
    $mensagem = "Matéria cadastrada com sucesso! <a href='../../../php/materia.php?id=$materia_id'>Ver matéria</a>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Matéria</title>
</head>
<body>
    <h1>Cadastro de Matéria</h1>

    <?php if (isset($mensagem)) { ?>
        <p><?php echo $mensagem; ?></p>
    <?php } ?>

    <form action="" method="POST">
        <label for="nome">Nome da Matéria:</label>
        <input type="text" id="nome" name="nome" required>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
