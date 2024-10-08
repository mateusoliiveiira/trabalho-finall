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

$materia = $_GET['id'];

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
    <link rel="stylesheet" href="../css/lista.css">
    <link rel="stylesheet" href="../css/headerTermo.css">
    
    <title>
        <?php
        if (!empty($dados['termos'])) {
            echo htmlspecialchars($dados['termos'][0]['nome']); // Exibe o nome do primeiro termo
        } else {
            echo "Sem termos disponíveis";
        }
        ?>
    </title>
</head>
<body>
    <header>
        <div class="header-dado">
            <?php
            if (!empty($dados['termos'])) {
                echo htmlspecialchars($dados['termos'][0]['nome']); // Exibe o nome do primeiro termo
            } else {
                echo "Sem termos disponíveis";
            }
            ?>
        </div>
    </header>

    <main>
        <?php if (!empty($dados['termos'])): ?>
            <div class="accordion">
                <?php foreach ($dados['termos'] as $termo): ?>
               
                
                 
                    
                    <div class="accordion-item">
                        <button class="accordion-header">O que é?</button>
                        <div class="accordion-content">
                            <?php echo htmlspecialchars($termo['oquee']); ?>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <button class="accordion-header">Onde usa?</button>
                        <div class="accordion-content">
                            <?php echo htmlspecialchars($termo['ondeusa']); ?>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <button class="accordion-header">Exemplo</button>
                        <div class="accordion-content">
                            <?php echo htmlspecialchars($termo['exemplo']); ?>
                        </div>
                    </div>

                    <div class="accordion-item">
    <button class="accordion-header">Fórmula</button>
    <div class="accordion-content">
        <?php 
        $formula = $termo['formula'];

        // Verifica se a fórmula contém um link válido de imagem
        if (filter_var($formula, FILTER_VALIDATE_URL) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $formula)) {
            // Exibe a imagem se for uma URL válida
            echo '<img src="' . htmlspecialchars($formula) . '" alt="Imagem da fórmula" style="max-width:100%;">';
        } else {
            // Exibe como texto se não for uma URL de imagem
            echo htmlspecialchars($formula);
        }
        ?>
    </div>
</div>

    <div class="accordion-content">
        <?php 
        // Verifica se a fórmula contém um link válido de imagem
        $formula = $termo['formula'];
        
        // Verifica se é uma URL e termina com extensões de imagem (jpg, png, gif)
        if (filter_var($formula, FILTER_VALIDATE_URL) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $formula)) {
            // Exibe a imagem
            echo '<img src="' . $formula . '" alt="Imagem da fórmula" style="max-width:100%;">';
        } else {
            // Exibe como texto se não for imagem
            echo htmlspecialchars($formula);
        }
        ?>
    </div>
</div>

</div>

                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Nenhum termo encontrado para esta matéria.</p>
        <?php endif; ?>
    </main>

    <footer>
        <div class="container-botao-materia">
            <button class="botao-materia"><a href="cadastrar-matematica.php?id=<?php echo $materia; ?>">+ Adicionar Termo</a></button>
        </div>
    </footer>

    <script src="../js/scriptlista.js"></script>
</body>
</html>
