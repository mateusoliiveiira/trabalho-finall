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
</head>
<body>
    <h1>Listar Exemplos</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>O que é</th>
                <th>Onde Usar</th>
                <th>Exemplo</th>
                <th>Fórmula</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dados as $linha): ?>
                <tr>
                    <td><?php echo htmlspecialchars($linha['id']); ?></td>
                    <td><?php echo htmlspecialchars($linha['oquee']); ?></td>
                    <td><?php echo htmlspecialchars($linha['ondeusa']); ?></td>
                    <td><?php echo htmlspecialchars($linha['exemplo']); ?></td>
                    <td>
                        <?php if (isset($linha['formula']) && file_exists($linha['formula'])): ?>
                            <img src="<?php echo htmlspecialchars($linha['formula']); ?>" alt="Fórmula" style="max-width: 200px; max-height: 200px;">
                        <?php else: ?>
                            Imagem não disponível
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
