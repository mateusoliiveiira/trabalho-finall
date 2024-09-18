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

// Função para listar termos com base em materia_id e nome
function listarTermos($pdo, $materia_id, $nome = '') {
    $sql = 'SELECT id, nome, oquee, ondeusa, exemplo, formula
            FROM termos
            WHERE materia_id = :materia_id
            AND nome LIKE :nome';
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([
            'materia_id' => $materia_id,
            'nome' => "%$nome%"
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erro na consulta: " . $e->getMessage());
    }
}

// Inicializar variáveis
$materia_id = 1;
$dados = [];
$nome = '';

// Verificar se o formulário de pesquisa foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'])) {
    $nome = $_POST['nome'];
    // Buscar termos com base no nome fornecido
    $dados = listarTermos($pdo, $materia_id, $nome);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/search.css">
    <link rel="stylesheet" href="../css/header.css">
    <title>Termos de Matemática</title>
</head>
<body>
    <header>
    <h1>Termos da Matéria com ID <?php htmlspecialchars($materia_id); ?></h1>
</header>
<form action="lista.php" method="POST" class="search-form">
        <input type="text" id="nome" name="nome" placeholder="Digite sua pesquisa..." class="search-input">
        <input type="hidden" name="materia_id" value="<?php echo htmlspecialchars($materia_id); ?>">
    </form>

<div class="container-botao-materia">
<button class="botao-materia"><a href="cadastrar-matematica.php">+ Adicionar Termo</a></button>
</div>
</body>
</html>
