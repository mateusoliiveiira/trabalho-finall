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

// Função para listar todos os termos com materia_id = 5
function listarTermosPorMateria($pdo, $materia_id) {
    $sql = 'SELECT id, nome, oquee, ondeusa, exemplo, formula
            FROM termos
            WHERE materia_id = :materia_id';
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute(['materia_id' => $materia_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erro na consulta: " . $e->getMessage());
    }
}

// Busca os termos com materia_id = 5
$materia_id = 5;
$termos = listarTermosPorMateria($pdo, $materia_id);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termos de Matemática</title>
</head>
<body>
    

    <?php if (!empty($termos)) { ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>O que é</th>
                    <th>Onde Usa</th>
                    <th>Exemplo</th>
                    <th>Fórmula</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($termos as $termo) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($termo['id']); ?></td>
                        <td><?php echo htmlspecialchars($termo['nome']); ?></td>
                        <td><?php echo htmlspecialchars($termo['oquee']); ?></td>
                        <td><?php echo htmlspecialchars($termo['ondeusa']); ?></td>
                        <td><?php echo htmlspecialchars($termo['exemplo']); ?></td>
                        <td><?php echo htmlspecialchars($termo['formula']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>Nenhum termo encontrado para a matéria com ID <?php echo htmlspecialchars($materia_id); ?>.</p>
    <?php } ?>

    <a href="cadastrar-matematica.php">Cadastrar Termo</a>
</body>
</html>
