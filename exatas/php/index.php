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

// Função para buscar todas as matérias
function listarMaterias($pdo) {
    $sql = 'SELECT id, nome FROM materias';
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erro ao buscar matérias: " . $e->getMessage());
    }
}

// Buscar todas as matérias
$materias = listarMaterias($pdo);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
    <title>AprendeFácil</title>
</head>
<body>

<header>
    <h1 class="titulo">AprendeFácil</h1>
</header>

<main>
    <img class="banner" src="../img/backto.png">

    <!-- Container para botões de matérias -->
    <div class="container-materias">
      
        
        <?php if (!empty($materias)) { ?>
            <?php foreach ($materias as $materia) { ?>
                <div class="container-botao-materia">
                    <a href="materia.php?id=<?php echo $materia['id']; ?>" class="botao-materia">
                        <?php echo htmlspecialchars($materia['nome']); ?>
                    </a>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>Nenhuma matéria cadastrada.</p>
        <?php } ?>
    </div>

    <div class="container-botao-adicionar-materia">
        <a href="cadastrar-materia.php">
            <button class="botao-adicionar-materia">+ Nova Matéria</button>
        </a>
    </div>
</main>

</body>
</html>
