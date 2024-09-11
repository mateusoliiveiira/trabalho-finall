<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Exemplo</title>
</head>
<body>
    <h1>Cadastrar Exemplo</h1>

    <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
        <p style="color: green;">Cadastro realizado com sucesso!</p>
    <?php endif; ?>

    <form method="POST" action="cadastrar.php" enctype="multipart/form-data">
        <label for="oquee">O que é:</label>
        <input type="text" name="oquee" required><br>

        <label for="ondeusa">Onde Usar:</label>
        <input type="text" name="ondeusa" required><br>

        <label for="exemplo">Exemplo:</label>
        <input type="text" name="exemplo" required><br>

        <label for="formula">Fórmula (imagem):</label>
        <input type="file" name="formula" accept="image/*" required><br>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
