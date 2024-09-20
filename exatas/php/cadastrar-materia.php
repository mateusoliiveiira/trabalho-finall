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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['materia'])) {
    $nome = $_POST['materia'];

    $materia_id = salvarMateria($pdo, $nome);
    
    if ($materia_id) {
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
    <title>Nova Matéria</title>
    <link rel="stylesheet" href="../css/criarmateria.css">
    <link rel="stylesheet" href="../css/header.css">
</head>
<body>
    <header>
        <h1>.</h1>
    </header>
    <div class="container-admateria">
        <div class="form-box-admateria">
            <h1 class="titulo-admateria">Nova matéria</h1>

            <?php if (isset($mensagem)) { ?>
                <p><?php echo htmlspecialchars($mensagem); ?></p>
            <?php } ?>

            <form action="" method="POST" class="form-admateria">
                <input type="text" id="materia" name="materia" placeholder="Adicionar matéria" class="input-admateria" required>
                <button type="submit" class="btn-admateria">Anexar</button>
            </form>

        </div>
        <button class="list-btn-admateria">Listar</button>
    </div>
</body>
</html>
