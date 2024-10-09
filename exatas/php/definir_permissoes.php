<?php
session_start();
include_once('../config/config.php');

// Verifica se o usuário está logado e se tem permissão para acessar esta página
if (!isset($_SESSION['id_user']) || $_SESSION['tipo_funcionario'] != 1) {
    header('Location: login.php');
    exit;
}

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

    // Mensagem de sucesso
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

       <style> /* Estilos gerais */
body {
    font-family: 'Jomhuria', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4; /* Cor de fundo */
}

.container {
    width: 80%;
    max-width: 900px;
    margin: 20px auto;
    padding: 20px;
    background: #fff; /* Fundo branco para o container */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
    border-radius: 8px; /* Bordas arredondadas */
}

/* Estilo para o título */
h1 {
    text-align: center;
    color: #333; /* Cor do texto */
}

/* Estilos para a tabela */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    border: 1px solid #ddd; /* Borda da tabela */
    padding: 8px; /* Espaçamento interno */
    text-align: left; /* Alinhamento à esquerda */
}

table th {
    background-color: #007bff; /* Cor de fundo do cabeçalho */
    color: white; /* Cor do texto do cabeçalho */
}

table tr:nth-child(even) {
    background-color: #f2f2f2; /* Cor de fundo alternada */
}

/* Estilos para os botões */
button {
    background-color: #28a745; /* Cor do botão */
    color: white; /* Cor do texto do botão */
    border: none;
    padding: 8px 12px;
    border-radius: 4px; /* Bordas arredondadas */
    cursor: pointer; /* Muda o cursor para indicar clicável */
}

button:hover {
    background-color: #218838; /* Cor ao passar o mouse */
}

/* Estilos para a mensagem de alerta */
.alert {
    background-color: #d4edda; /* Cor de fundo da mensagem de sucesso */
    color: #155724; /* Cor do texto da mensagem de sucesso */
    padding: 10px;
    border: 1px solid #c3e6cb; /* Borda da mensagem */
    border-radius: 4px; /* Bordas arredondadas */
    margin-bottom: 20px; /* Espaçamento inferior */
}

/* Estilos para o select */
select {
    padding: 8px;
    border-radius: 4px;
    border: 1px solid #ccc; /* Borda do select */
    width: 100%; /* Largura total do select */
}

form {
    display: flex; /* Flexbox para alinhar os elementos */
    align-items: center; /* Centraliza verticalmente */
}

form select {
    flex: 1; /* Faz o select ocupar o máximo de espaço disponível */
}

form button {
    margin-left: 10px; /* Espaçamento à esquerda do botão */
}
.btn-voltar {
    display: inline-block; /* Para manter o link como um bloco */
    background-color: #007bff; /* Cor de fundo */
    color: white; /* Cor do texto */
    padding: 10px 15px; /* Espaçamento interno */
    border-radius: 5px; /* Bordas arredondadas */
    text-decoration: none; /* Remove o sublinhado */
    margin-bottom: 20px; /* Espaçamento inferior */
}

.btn-voltar:hover {
    background-color: #0056b3; /* Cor ao passar o mouse */
}

</style>
        
    </div>

    <a href="admin.php" class="btn-voltar">Voltar</a>

</body>

</html>
