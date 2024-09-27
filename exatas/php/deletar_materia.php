<?php
// Conectar ao banco de dados
require_once 'C:\xampp\htdocs\trabalho-finall\exatas\config\config.php';

// Verifica se o ID foi passado via GET
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id) {
    // Excluir a matéria
    $sql = "DELETE FROM materias WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    // Redirecionar de volta para a lista de matérias após a exclusão
    header("Location: listar_materias.php");
    exit;
} else {
    echo "ID da matéria não fornecido.";
}
?>
