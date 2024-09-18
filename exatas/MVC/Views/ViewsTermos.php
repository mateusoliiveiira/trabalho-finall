<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro e Listagem de Termos</title>
</head>
<body>
    <h1>Cadastro de Termos</h1>

    <?php if (isset($mensagem)) { ?>
        <p><?php echo htmlspecialchars($mensagem); ?></p>
    <?php } ?>

    <form action="" method="POST">
        <label for="nome">Nome do Termo:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="materia_id">Matéria:</label>
        <select id="materia_id" name="materia_id" required>
            <option value="">Selecione uma matéria</option>
            <?php if (isset($materias) && !empty($materias) && is_array($materias)) { ?>
                <?php foreach ($materias as $materia) { ?>
                    <option value="<?php echo htmlspecialchars($materia['id']); ?>">
                        <?php echo htmlspecialchars($materia['nome']); ?>
                    </option>
                <?php } ?>
            <?php } else { ?>
                <option value="">Nenhuma matéria encontrada</option>
            <?php } ?>
        </select>

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

    <h1>Lista de Termos</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Matéria</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($termos) && is_array($termos) && !empty($termos)) { ?>
                <?php foreach ($termos as $termo) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($termo['id']); ?></td>
                        <td><?php echo htmlspecialchars($termo['nome']); ?></td>
                        <td><?php echo htmlspecialchars($termo['materia_nome']); ?></td>
                        <td>
                            <a href="editar_termo.php?id=<?php echo htmlspecialchars($termo['id']); ?>">Editar</a>
                            <a href="excluir_termo.php?id=<?php echo htmlspecialchars($termo['id']); ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="4">Nenhum termo encontrado.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
