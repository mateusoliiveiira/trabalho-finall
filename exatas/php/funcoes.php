<?php
// Conectar ao banco de dados
require_once 'C:\xampp\htdocs\trabalho-finall\exatas\config\config.php';

// Verifica se o ID foi passado via GET
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coletar dados do formulário
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $materia_id = $_POST['materia_id'];
    $oquee = $_POST['oquee'];
    $ondeusa = $_POST['ondeusa'];
    $exemplo = $_POST['exemplo'];
    $formula = $_POST['formula'];

    // Atualizar dados no banco de dados
    $sql = "UPDATE termos SET nome = ?, materia_id = ?, oquee = ?, ondeusa = ?, exemplo = ?, formula = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $materia_id, $oquee, $ondeusa, $exemplo, $formula, $id]);

    echo "Termo atualizado com sucesso!";
}

// Buscar termos e matérias
$sql = "SELECT * FROM termos WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$termo = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT id, nome FROM materias";
$materias = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Termo</title>
</head>
<body>
    <h1>Editar Termo</h1>
    <form action="editar_termo.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($termo['id']); ?>">

        <label for="nome">Nome do Termo:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($termo['nome']); ?>" required>

        <label for="materia_id">Matéria:</label>
        <select id="materia_id" name="materia_id" required>
            <option value="">Selecione uma matéria</option>
            <?php foreach ($materias as $materia) { ?>
                <option value="<?php echo htmlspecialchars($materia['id']); ?>"
                    <?php echo $materia['id'] == $termo['materia_id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($materia['nome']); ?>
                </option>
            <?php } ?>
        </select>

        <label for="oquee">O que é:</label>
        <textarea id="oquee" name="oquee" required><?php echo htmlspecialchars($termo['oquee']); ?></textarea>

        <label for="ondeusa">Onde Usa:</label>
        <textarea id="ondeusa" name="ondeusa" required><?php echo htmlspecialchars($termo['ondeusa']); ?></textarea>

        <label for="exemplo">Exemplo:</label>
        <textarea id="exemplo" name="exemplo" required><?php echo htmlspecialchars($termo['exemplo']); ?></textarea>

        <label for="formula">Fórmula:</label>
        <textarea id="formula" name="formula" required><?php echo htmlspecialchars($termo['formula']); ?></textarea>

        <button type="submit">Atualizar</button>
    </form>

    <a href="formulario-termos.php">Voltar para a lista de termos</a>
</body>
</html>
