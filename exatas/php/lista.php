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
$materia_id = isset($_POST['materia_id']) ? $_POST['materia_id'] : 1;
$dados = [];
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';

// Buscar termos com base no nome fornecido
if (!empty($nome)) {
    $dados = listarTermos($pdo, $materia_id, $nome);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/lista.css">
    <link rel="stylesheet" href="../css/headerTermo.css">
    <title>Resultados da Pesquisa</title>
</head>
<body>
<?php if (!empty($dados)) { ?>
    <?php foreach ($dados as $dado) { ?>

<div class="header-dado">
    <?php echo htmlspecialchars($dado['nome']); ?>
</div>


   
            <div class="accordion">
                <div class="accordion-item">
                    <button class="accordion-header">ID</button>
                    <div class="accordion-content">
                        <?php echo htmlspecialchars($dado['id']); ?>
                    </div>
                </div>
                        
                <div class="accordion-item">
                    <button class="accordion-header">O que é?</button>
                    <div class="accordion-content">
                        <?php echo htmlspecialchars($dado['oquee']); ?>
                    </div>
                </div>

                <div class="accordion-item">
                    <button class="accordion-header">Onde usa?</button>
                    <div class="accordion-content">
                        <?php echo htmlspecialchars($dado['ondeusa']); ?>
                    </div>
                </div>

                <div class="accordion-item">
                    <button class="accordion-header">Exemplo?</button>
                    <div class="accordion-content">
                        <?php echo htmlspecialchars($dado['exemplo']); ?>
                    </div>
                </div>

                <div class="accordion-item">
                    <button class="accordion-header">Fórmula?</button>
                    <div class="accordion-content">
                        <?php echo htmlspecialchars($dado['formula']); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } else if ($nome !== '') { ?>
        <p>Nenhum termo encontrado para a matéria com ID <?php echo htmlspecialchars($materia_id); ?>.</p>
    <?php } ?>

    <script src="../js/scriptlista.js"></script>
</body>
</html>
