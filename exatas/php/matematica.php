<?php
// Inclua o arquivo de configuração e o Model
require_once '../config/config.php';
require_once '../MVC/Model/ModelMateria.php';

// Crie uma instância do Model
$model = new ExemploModel($pdo);

// Recupera todos os registros da tabela
$sql = "SELECT * FROM matematica";
$stmt = $pdo->query($sql);
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Listar Exemplos</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/lista.css">
</head>
<body>
    <header>

    </header>

    <div class="accordion">
        <?php foreach ($dados as $linha): ?>
            <div class="accordion-item">
                <button class="accordion-header">ID</button>
                <div class="accordion-content">
                    <p><?php echo htmlspecialchars($linha['id']); ?></p>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-header">O que é</button>
                <div class="accordion-content">
                    <p><?php echo htmlspecialchars($linha['oquee']); ?></p>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-header">Onde usar</button>
                <div class="accordion-content">
                    <p><?php echo htmlspecialchars($linha['ondeusa']); ?></p>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-header">Exemplo</button>
                <div class="accordion-content">
                    <p><?php echo htmlspecialchars($linha['exemplo']); ?></p>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-header">Fórmula</button>
                <div class="accordion-content">
                    <?php if (isset($linha['formula']) && file_exists($linha['formula'])): ?>
                        <img src="<?php echo htmlspecialchars($linha['formula']); ?>" alt="Fórmula" style="max-width: 200px; max-height: 200px;">
                    <?php else: ?>
                        <p>Imagem não disponível</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="../js/scriptlista.js"></script>
</body>
</html>
