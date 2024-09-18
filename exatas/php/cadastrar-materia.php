<?php
session_start(); // Iniciar sessão

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

// Função para salvar a matéria
function salvarMateria($pdo, $nome) {
    $sql = 'INSERT INTO materias (nome) VALUES (:nome)';
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute(['nome' => $nome]);
        return $pdo->lastInsertId(); // Retorna o ID da matéria cadastrada
    } catch (PDOException $e) {
        die("Erro ao salvar: " . $e->getMessage());
    }
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'])) {
    $nome = $_POST['nome'];

    $materia_id = salvarMateria($pdo, $nome);
    
    if ($materia_id) {
        // Definir a variável de sessão para indicar que o cadastro foi feito
        $_SESSION['materia_cadastrada'] = true;
        $_SESSION['materia_id'] = $materia_id; // Armazenar o ID da matéria
        $mensagem = "Matéria cadastrada com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar matéria.";
    }
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
        <p><?php echo htmlspecialchars($mensagem); ?></p>
    <?php } ?>

    <form action="" method="POST">
        <label for="nome">Nome da Matéria:</label>
        <input type="text" id="nome" name="nome" required>
        <button type="submit">Cadastrar</button>
    </form>

    <?php if (isset($_SESSION['materia_cadastrada']) && $_SESSION['materia_cadastrada']) { ?>
        <a href="materia.php?id=<?php echo $_SESSION['materia_id']; ?>">Ver Matéria</a>
    <?php } ?>

</body>
</html>
