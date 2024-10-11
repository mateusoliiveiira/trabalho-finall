<?php
// Conectar ao banco de dados
$host = 'localhost';
$dbname = 'exatas';
$username = 'root';
$password = '';

$termo_id = $_GET['id'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}

// Recuperar os detalhes do termo pelo ID
$sql = 'SELECT * FROM termos WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $termo_id]);
$termo = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar se o termo existe
if (!$termo) {
    die("Termo não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Termo</title>
    <link rel="stylesheet" href="../css/lista.css">
</head>
<body>

    <header>
        <h1><?php echo htmlspecialchars($termo['nome']); ?></h1></header>
        
        <div class="accordion">
            <div class="accordion-item">
                <button class="accordion-header">O que é</button>
                <div class="accordion-content">
                    <p><?php echo htmlspecialchars($termo['oquee']); ?></p>
                </div>
            </div>
            
            <div class="accordion-item">
                <button class="accordion-header">Onde Usa</button>
                <div class="accordion-content">
                    <p><?php echo htmlspecialchars($termo['ondeusa']); ?></p>
                </div>
            </div>
            
            <div class="accordion-item">
                <button class="accordion-header">Exemplo</button>
                <div class="accordion-content">
                    <p><?php echo htmlspecialchars($termo['exemplo']); ?></p>
                </div>
            </div>
            
            <div class="accordion-item">
                <button class="accordion-header">Fórmula</button>
                <div class="accordion-content">
                    <p><?php echo htmlspecialchars($termo['formula']); ?></p>
                </div>
            </div>
        </div>
        <div class="container-botao-materia">
        <button class="botao-materia"> <a href="editar_termo.php?id=<?php echo $termo['id']; ?>" class="btn btn-warning">Editar Termo</a></button>
        <button class="botao-voltar"><a href="materia.php?id=<?php echo $termo['materia_id']; ?>" class="btn btn-secondary">Voltar</a></button>
    </div>

    <script src="../js/scriptlista.js"></script>
</body>
</html>
