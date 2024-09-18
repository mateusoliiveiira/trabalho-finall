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

require_once '../../php/roteador-materia.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Matéria</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

<?php if (isset($mensagem)) { ?>
        <p><?php echo $mensagem; ?></p>
    <?php } ?>
     
    <div class="container-admateria">
        <div class="form-box-admateria">
            <h1 class="titulo-admateria">Nova matéria</h1>
            <form action="" method="POST" class="form-admateria">
                <input type="text" id="nome" name="nome" placeholder="Adicionar matéria" class="input-admateria" required>
                <button type="submit" class="btn-admateria">Anexar</button>
            </form>
        </div>
        <button class="list-btn-admateria">Listar</button>
    </div>
</body>
</html>
