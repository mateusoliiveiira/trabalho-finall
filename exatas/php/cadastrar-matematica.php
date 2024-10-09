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

// Função para salvar um novo termo
function salvarTermo($pdo, $nome, $oquee, $ondeusa, $exemplo, $formula) {
    $materia_id = $_GET['id'];
    $sql = 'INSERT INTO termos (nome, materia_id, oquee, ondeusa, exemplo, formula) 
            VALUES (:nome, :materia_id, :oquee, :ondeusa, :exemplo, :formula)';
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            'nome' => $nome,
            'materia_id' => $materia_id,
            'oquee' => $oquee,
            'ondeusa' => $ondeusa,
            'exemplo' => $exemplo,
            'formula' => $formula
        ]);
        return true;
    } catch (PDOException $e) {
        die("Erro ao salvar: " . $e->getMessage());
    }
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'], $_POST['oquee'], $_POST['ondeusa'], $_POST['exemplo'], $_POST['formula'])) {
    $nome = $_POST['nome'];
    $oquee = $_POST['oquee'];
    $ondeusa = $_POST['ondeusa'];
    $exemplo = $_POST['exemplo'];
    $formula = $_POST['formula'];

    if (salvarTermo($pdo, $nome, $oquee, $ondeusa, $exemplo, $formula)) {
        $mensagem = "Termo cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar termo.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Termos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/cdtermo.css"> 
    <link rel="stylesheet" href="../css/header.css"> 
</head>
<body>
<header>
        <div class="cabecalho">
            <a class="log" href="index.php"><img src="../img/digitar.png" width="100" height="100"></a>
        </div>
        <div class ="adicionar">
           <h1 class="titulo margin-left">Adicionar termo</h1> 
        </div>

        <style>
            a.log img {
                width: 60px;
                height: auto;
                transition: transform 0.3s ease;
                /* animação suave */
            }

            a.log img:hover {
                transform: scale(1.2);
                /* aumenta a imagem em 20% */
            }
            .margin-left{
                margin-left: 0.5em;
            }

        </style>

        
    </header>
    
    <?php if (isset($mensagem)) { ?>
        <p><?php echo htmlspecialchars($mensagem); ?></p>
    <?php } ?>

    <div class="container">
        <form action="" method="POST">
            <div class="section">
                <div class="title">Nome do Termo:</div>
                <input type="text" id="nome" name="nome" required>
            </div>

            <div class="section">
                <div class="title">O que é:</div>
                <textarea id="oquee" name="oquee" required></textarea>
            </div>

            <div class="section">
                <div class="title">Onde Usa:</div>
                <textarea id="ondeusa" name="ondeusa" required></textarea>
            </div>

            <div class="section">
                <div class="title">Exemplo:</div>
                <textarea id="exemplo" name="exemplo" required></textarea>
            </div>

            <div class="section">
                <div class="title">Fórmula (coloque um link de imagem, se houver):</div>
                <textarea id="formula" name="formula" required></textarea>
            </div>

            <button type="submit">Adicionar</button>
        </form>
    </div>
</body>
</html>
