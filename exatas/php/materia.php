<?php
// Conectar ao banco de dados
$host = 'localhost';
$dbname = 'exatas';
$username = 'root';
$password = '';

$materia_id = $_GET['id'] ?? null; // Usar null caso não exista o id

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
if ($materia_id) {
    $nome = $_POST['pesquisar_nome'] ?? ''; // Pegando o termo de pesquisa
    $dados = obterMateriaETermos($pdo, $materia_id, $nome);

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/search.css">
    <link rel="stylesheet" href="../css/header.css">
    <title>Pesquisar Termos</title>
</head>
<body background="../img/fundo.png">

<header>
    <div class="cabecalho">
        <a class="log" href="index.php"><img src="../img/digitar.png" width="100" height="100" alt="Logo"></a>
    </div>
    <div class="adicionar">
        <h1 class="titulo margin-left">Matéria: <?php echo htmlspecialchars($dados['materia']['nome']); ?></h1> 
    </div>

    <style>
        .margin-left {
            margin-left: -30px;
        }
        .item {
            flex-basis: calc(33.33% - 20px);
            margin: 10px;
            padding: 15px;
            background-color: white;
            color: black;
            border-radius: 10px;
            box-shadow: 1px 5px 5px #ccc;
            display: flex;
            flex-direction: column;
            text-align: center;
        }
        h3 {
            margin: 0;
        }
        p {
            text-align: left;
            margin: 5px 0;
        }
    </style>
</header>

<main>
    <section>
        <div class="container">
            <h2 class="mt-5">Termos Cadastrados</h2>
            
            <!-- Formulário de pesquisa -->
            <form method="POST" class="mb-4">
                <div class="input-group">
                    <input type="text" name="pesquisar_nome" class="form-control" placeholder="Pesquisar termo..." value="<?php echo htmlspecialchars($nome); ?>">
                    <button class="btn btn-primary" type="submit">Pesquisar</button>
                </div>
            </form>
            
            <section>
                <div class="row">
                <?php foreach ($dados['termos'] as $termo) { ?>
                    <div class="item">
                        <h3><?php echo htmlspecialchars($termo['nome']); ?></h3>
                        <p><strong>O que é:</strong> <?php echo htmlspecialchars($termo['oquee']); ?></p>

                        <?php if (isset($termo['formula']) && !empty($termo['formula'])): ?>
                            <img src="<?php echo htmlspecialchars($termo['formula']); ?>" alt="Imagem de <?php echo htmlspecialchars($termo['nome']); ?>" style="max-width: 100%; height: auto; margin: 10px 0;">
                        <?php endif; ?>

                        <a href="detalhes_termo.php?id=<?php echo $termo['id']; ?>" class="btn btn-primary mt-3">Ver Detalhes</a>
                    </div>
                <?php } ?>
                </div>
            </section>
        </div>
    </section>

    <footer>
        <div class="container-botao-materia">
            <a href="admin.php?id=<?php echo $materia_id; ?>"> <button class="botao-materia">+ Adicionar Termo</button></a>
        </div>
    </footer>
</body>
</html>
