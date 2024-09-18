<?php
// Conectar ao banco de dados
require_once 'C:\xampp\htdocs\trabalho-finall\exatas\config\config.php';

// Verifica se o ID foi passado via GET
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id) {
    // Excluir o termo
    $sql = "DELETE FROM termos WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    echo "Termo excluído com sucesso!";
} else {
    echo "ID do termo não fornecido.";
}

?>

<a href="formulario-termos.php">Voltar para a lista de termos</a>
