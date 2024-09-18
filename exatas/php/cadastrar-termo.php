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

// Função para salvar um novo termo
function salvarTermo($pdo, $nome, $materia_id, $oquee, $ondeusa, $exemplo, $formula) {
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

// Inicializar variáveis
$mensagem = '';
$materia_id = isset($_GET['materia_id']) ? (int)$_GET['materia_id'] : 0;

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'], $_POST['oquee'], $_POST['ondeusa'], $_POST['exemplo'], $_POST['formula'])) {
    $nome = $_POST['nome'];
    $oquee = $_POST['oquee'];
    $ondeusa = $_POST['ondeusa'];
    $exemplo = $_POST['exemplo'];
    $formula = $_POST['formula'];

    if (salvarTermo($pdo, $nome, $materia_id, $oquee, $ondeusa, $exemplo, $formula)) {
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
</head>
<body>
    <h1>Cadastro de Termos</h1>

    <?php if (isset($mensagem)) { ?>
        <p><?php echo htmlspecialchars($mensagem); ?></p>
    <?php } ?>

    <form action="" method="POST">
        <label for="nome">Nome do Termo:</label>
        <input type="text" id="nome" name="nome" required>

        <input type="hidden" name="materia_id" value="<?php echo htmlspecialchars($materia_id); ?>">

        <label for="oquee">O que é:</label>
        <textarea id="oquee" name="oquee" required></textarea>

        <label for="ondeusa">Onde Usa:</label>
        <textarea id="ondeusa" name="ondeusa" required></textarea>

        <label for="exemplo">Exemplo:</label>
        <textarea id="exemplo" name="exemplo" required></textarea>

        <label for="formula">Fórmula:</label>
        <textarea id="formula" name="formula" required></textarea>

        <button type="submit">Cadastrar</button>
    </form>

    <a href="materia.php?id=<?php echo htmlspecialchars($materia_id); ?>">Voltar para a Matéria</a>
    <a href="index.php">Voltar para o índice</a>
</body>
</html>
