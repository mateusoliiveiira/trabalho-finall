

<?php
// Conectar ao banco de dados
$host = 'localhost';
$dbname = 'exatas';
$username = 'root';
$password = '';

$materia_id = $_GET['id'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}

// Recuperar os termos cadastrados
$sql = 'SELECT * FROM termos WHERE materia_id = :materia_id';
$stmt = $pdo->prepare($sql);
$stmt->execute(['materia_id' => $materia_id]);
$termos = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/search.css">
    <link rel="stylesheet" href="../css/header.css">
    <title>Pesquisar Termos</title>
</head>
<body background="../img/fundo.png" >

<header>
        <div class="cabecalho">
            <a class="log" href="index.php"><img src="../img/digitar.png" width="100" height="100"></a>
        </div>
        <div class ="adicionar">
           <h1 class="titulo margin-left">Matéria: <?php echo htmlspecialchars($dados['materia']['nome']); ?></h1> 
        </div>
        

        <style>
         
         
            .margin-left{
                margin-left: -30px;
            }

        </style>


        </a>
    </header>

    <main>
        <!-- Formulário de pesquisa -->
        <form action="lista.php?id=<?php echo htmlspecialchars($id); ?>" method="POST" class="search-form">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <input type="text" id="nome" name="pesquisar_nome" placeholder="Digite o termo..." class="search-input">
            <button type="submit">Pesquisar</button>
        </form>
        <section>
       
<div class="container">
    <h2 class="mt-5">Termos Cadastrados</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
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
                    <td><?php echo htmlspecialchars($termo['nome']); ?></td>
                    <td><?php echo htmlspecialchars($termo['oquee']); ?></td>
                    <td><?php echo htmlspecialchars($termo['ondeusa']); ?></td>
                    <td><?php echo htmlspecialchars($termo['exemplo']); ?></td>
                    <td><?php echo htmlspecialchars($termo['formula']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
        </ul>
    </section>
</main>
    </main>

    <footer>
        <div class="container-botao-materia">
        <a href="cadastrar-matematica.php?id=<?php echo $id; ?>"> <button class="botao-materia">+ Adicionar Termo</button></a>
        </div>
    </footer>
</body>
</html>




