<?php

session_start();

if (!isset($_SESSION['tipo_funcionario']) || $_SESSION['tipo_funcionario'] != 1) {
    echo '<!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Acesso Negado</title>
        <style>
            /* Estilos para o modal */
            .modal {
                display: block; /* Exibe o modal */
                position: fixed; /* Fica no topo */
                z-index: 1000; /* Acima de outros elementos */
                left: 0;
                top: 0;
                width: 100%; /* Largura total */
                height: 100%; /* Altura total */
                overflow: auto; /* Habilita scroll se necessário */
                background-color: rgba(0, 0, 0, 0.5); /* Fundo preto com opacidade */
            }

            /* Estilos para o conteúdo do modal */
            .modal-content {
                background-color: #fff; /* Fundo branco */
                margin: 15% auto; /* Margem em cima e centralizado */
                padding: 20px;
                border: 1px solid #888; /* Borda cinza */
                width: 80%; /* Largura do modal */
                max-width: 500px; /* Largura máxima */
                border-radius: 8px; /* Bordas arredondadas */
            }

            /* Estilos para o botão de fechar */
            .close {
                color: #aaa; /* Cor do texto */
                float: right; /* Alinha à direita */
                font-size: 28px; /* Tamanho da fonte */
                font-weight: bold; /* Negrito */
            }

            .close:hover,
            .close:focus {
                color: black; /* Cor ao passar o mouse */
                text-decoration: none; /* Remove sublinhado */
                cursor: pointer; /* Cursor em ponteiro */
            }

            /* Estilos para o botão OK */
            button {
                background-color: #4CAF50; /* Verde */
                color: white; /* Texto branco */
                padding: 10px 15px; /* Espaçamento */
                border: none; /* Sem borda */
                border-radius: 5px; /* Bordas arredondadas */
                cursor: pointer; /* Cursor em ponteiro */
                font-size: 16px; /* Tamanho da fonte */
            }

            button:hover {
                background-color: #45a049; 
            }
        </style>
    </head>
    <body>
        <div class="modal" id="alertModal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Acesso Negado</h2>
                <p>Você não tem permissão para acessar esta página.</p>
                <button onclick="redirectToIndex()">OK</button>
            </div>
        </div>
        <script>
            function closeModal() {
                document.getElementById("alertModal").style.display = "none";
            }
            function redirectToIndex() {
                window.location.href = "index.php";
            }
        </script>
    </body>
    </html>';
    exit();
}


require_once 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Controller\ControllerTermos.php';

$controller = new TermoController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->salvar();
} else {
    $controller->index();
}

// Verifica se o usuário está logado e se tem permissão para acessar esta página
if (!isset($_SESSION['id_user']) || $_SESSION['tipo_funcionario'] != 1) {
    header('Location: login.php');
    exit;
}

include_once('../config/config.php');

// Consulta os usuários
$query = "SELECT * FROM usuarios";
$stmt = $pdo->prepare($query);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Atualiza as permissões
if (isset($_POST['update_permissions'])) {
    $userId = $_POST['user_id'];
    $newPermission = $_POST['permission'];

    $updateQuery = "UPDATE usuarios SET tipo_funcionario = ? WHERE id_user = ?";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute([$newPermission, $userId]);

    // Adicione uma mensagem de sucesso
    $_SESSION['message'] = 'Permissão atualizada com sucesso!';
    header('Location: definir_permissoes.php'); // Redireciona após a atualização
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Definir Permissões</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/adm.css">
</head>

<body>
    <div class="container">
        <h1>Definir Permissões de Usuários</h1>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']); // Remove a mensagem após exibi-la
                ?>
            </div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome Completo</th>
                    <th>Email</th>
                    <th>Tipo de Funcionário</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo htmlspecialchars($usuario['id_user']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['nome_completo']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                    <td>
                        <form method="POST">
                            <select name="permission">
                                <option value="1" <?php echo $usuario['tipo_funcionario'] == 1 ? 'selected' : ''; ?>>Admin</option>
                                <option value="5" <?php echo $usuario['tipo_funcionario'] == 5 ? 'selected' : ''; ?>>Usuário</option>
                            </select>
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($usuario['id_user']); ?>">
                            <button type="submit" name="update_permissions">Atualizar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <a href="index.php">Ir Para o Index</a>
</body>

</html>
