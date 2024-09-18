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

// Função para buscar a matéria e seus termos associados pelo ID
function obterMateriaETermos($pdo, $id, $nome = '') {
    // Buscar a matéria pelo ID
    $sqlMateria = 'SELECT * FROM materias WHERE id = :id';
    $stmtMateria = $pdo->prepare($sqlMateria);
    
    // Buscar os termos associados a essa matéria
    $sqlTermos = 'SELECT * FROM termos WHERE materia_id = :id AND nome LIKE :nome';
    $stmtTermos = $pdo->prepare($sqlTermos);
    
    try {
        // Executar a consulta da matéria
        $stmtMateria->execute(['id' => $id]);
        $materia = $stmtMateria->fetch(PDO::FETCH_ASSOC);

        // Executar a consulta dos termos associados
        $stmtTermos->execute([
            'id' => $id,
            'nome' => "%$nome%"
        ]);
        $termos = $stmtTermos->fetchAll(PDO::FETCH_ASSOC);

        // Retornar a matéria e seus termos
        return ['materia' => $materia, 'termos' => $termos];
    } catch (PDOException $e) {
        die("Erro ao buscar matéria e termos: " . $e->getMessage());
    }
}

// Verificar se o ID da matéria foi passado
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $nome = isset($_POST['pesquisar_nome']) ? $_POST['pesquisar_nome'] : '';
    $dados = obterMateriaETermos($pdo, $id, $nome);
    
    // Verificar se a matéria existe
    if (!$dados['materia']) {
        die("Matéria não encontrada.");
    }
} else {
    die("ID da matéria não fornecido.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($dados['materia']['nome']); ?></title>
</head>
<body>
    <h1>Matéria: <?php echo htmlspecialchars($dados['materia']['nome']); ?></h1>
    
    <h2>Termos Associados:</h2>
    
    <!-- Formulário de pesquisa -->
    <form action="" method="POST">
        <label for="pesquisar_nome">Buscar Termos:</label>
        <input type="text" id="pesquisar_nome" name="pesquisar_nome" value="<?php echo htmlspecialchars($nome); ?>">
        <button type="submit">Pesquisar</button>
    </form>

    <?php if ($nome !== '' && !empty($dados['termos'])) { ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Termo</th>
                    <th>O que é</th>
                    <th>Onde Usa</th>
                    <th>Exemplo</th>
                    <th>Fórmula</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dados['termos'] as $termo) { ?>
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
    <?php } elseif ($nome !== '') { ?>
        <p>Nenhum termo encontrado para a pesquisa.</p>
    <?php } ?>

    <!-- Link para cadastrar novos termos -->
    <a href="cadastrar-termo.php?materia_id=<?php echo htmlspecialchars($id); ?>">Cadastrar Novo Termo para Esta Matéria</a>

    <a href="index.php">Voltar para o índice</a>
</body>
</html>
