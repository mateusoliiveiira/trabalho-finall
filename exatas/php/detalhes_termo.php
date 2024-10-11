<?php
// Conectar ao banco de dados
$host = 'localhost';
$dbname = 'exatas';
$username = 'root';
$password = '';

$termo_id = $_GET['id'] ?? null; // Usar null caso não exista o id

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}

// Recuperar os detalhes do termo pelo ID
if ($termo_id) {
    $sql = 'SELECT * FROM termos WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $termo_id]);
    $termo = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar se o termo existe
    if (!$termo) {
        die("Termo não encontrado.");
    }
} else {
    die("ID do termo não fornecido.");
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

        .container {
            background: rgba(0, 0, 0, 0.7); /* Fundo escuro semi-transparente */
            padding: 20px;
            border-radius: 10px;
            max-width: 800px;
            margin: 50px auto;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
        }

        h1 {
            font-size: 3rem;
            text-align: center;
            margin-bottom: 30px;
            text-transform: uppercase;
            color: #ffd700;
        }

        p {
            font-size: 1.5rem;
            line-height: 1.8;
            color: #f0f0f0;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 1.2rem;
        }

        .btn-warning {
            background-color: #ffae42;
            border: none;
            box-shadow: 0 5px 15px rgba(255, 174, 66, 0.4);
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.4);
        }

        .btn:hover {
            opacity: 0.8;
        }

        .imagem {
            max-width: 100%; /* Para garantir que a imagem não ultrapasse a largura do container */
            height: auto; /* Manter a proporção da imagem */
            margin: 20px 0; /* Espaçamento em volta da imagem */
        }
</style>
    <div class="container">
        <h1>Detalhes do Termo: <?php echo htmlspecialchars($termo['nome']); ?></h1>
        <p><strong>O que é:</strong> <?php echo htmlspecialchars($termo['oquee']); ?></p>
        <p><strong>Onde Usa:</strong> <?php echo htmlspecialchars($termo['ondeusa']); ?></p>
        <p><strong>Exemplo:</strong> <?php echo htmlspecialchars($termo['exemplo']); ?></p>
        <p><strong>Fórmula:</strong> <?php echo htmlspecialchars($termo['formula']); ?></p>

        <!-- Exibir a imagem, se existir -->
        <?php if (!empty($termo['imagem'])): ?>
            <img src="<?php echo htmlspecialchars($termo['imagem']); ?>" alt="Imagem de <?php echo htmlspecialchars($termo['nome']); ?>" class="imagem">
        <?php endif; ?>

        <a href="editar_termo.php?id=<?php echo $termo['id']; ?>" class="btn btn-warning">Editar Termo</a>
        <a href="materia.php?id=<?php echo $termo['materia_id']; ?>" class="btn btn-secondary">Voltar</a>
    </div>

    <script src="../js/scriptlista.js"></script>
</body>
</html>
