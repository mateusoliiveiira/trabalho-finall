<?php
session_start();
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
    <link rel="stylesheet" href="../css/styles.css">
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
</body>

</html>
