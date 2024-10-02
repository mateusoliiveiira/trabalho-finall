<?php
// Conectar ao banco de dados
$host = 'localhost';
$dbname = 'exatas';
$username = 'root';
$password = '';

$materia_id = $_GET['id'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}

// Verificar se o ID da matéria foi passado
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("ID da matéria não fornecido.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/search.css">
    <link rel="stylesheet" href="../css/header.css">
    <title>Pesquisar Termos</title>
</head>
<body background="../img/fundo.png">
    <header>
        <h1 class="titulo">Pesquisar Termos</h1>
    </header>

    <main>
        <!-- Formulário de pesquisa -->
        <form action="lista.php?id=<?php echo htmlspecialchars($id); ?>" method="POST" class="search-form">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <input type="text" id="nome" name="pesquisar_nome" placeholder="Digite o termo..." class="search-input">
            <button type="submit">Pesquisar</button>
        </form>
    </main>

    <footer>
        <div class="container-botao-materia">
            <button class="botao-materia"><a href="cadastrar-matematica.php?id=<?php echo $materia_id; ?>">+ Adicionar Termo</a></button>
        </div>
    </footer>
</body>
</html>
