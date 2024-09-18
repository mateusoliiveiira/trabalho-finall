<?php
session_start(); // Iniciar a sessão

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

// Função para obter detalhes de uma matéria
function obterMateriaPorId($pdo, $id) {
    $sql = 'SELECT * FROM materias WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erro ao buscar matéria: " . $e->getMessage());
    }
}

// Verificar se o ID foi passado na URL
if (isset($_GET['id'])) {
    $materia_id = $_GET['id'];
    // Obter os detalhes da matéria pelo ID
    $materia = obterMateriaPorId($pdo, $materia_id);
    
    // Se a matéria não for encontrada, redirecionar ou mostrar mensagem
    if (!$materia) {
        header("Location: index.php");
        exit();
    }
    
    // Após exibir a página, destruir a sessão para ocultar o botão no recarregamento
    session_destroy();
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Matéria</title>
</head>
<body>
    <h1>Detalhes da Matéria</h1>

    <?php if ($materia) { ?>
        <p><strong>ID:</strong> <?php echo htmlspecialchars($materia['id']); ?></p>
        <p><strong>Nome:</strong> <?php echo htmlspecialchars($materia['nome']); ?></p>
    <?php } ?>

    <a href="index.php">Voltar para a página inicial</a>
</body>
</html>
