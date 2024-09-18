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
$materia_id = 5;
$termos = [];
$nome = '';

// Verificar se o formulário de pesquisa foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'])) {
    $nome = $_POST['nome'];
    // Buscar termos com base no nome fornecido
    $termos = listarTermos($pdo, $materia_id, $nome);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
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
