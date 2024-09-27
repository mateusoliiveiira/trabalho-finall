<?php
session_start();

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
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Lista de Matérias</title>
    <link rel="stylesheet" href="../css/listar.css">
</head>
<body>
    <div class="header">
        <h1 >Aprende facil</h1>
    </div>
    <div class="container">
        <h1>Matérias</h1>
        <table>
            <tbody>
                <?php
                // Consulta para buscar todas as matérias
                $sql = "SELECT id, nome FROM materias";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                
                $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if (count($materias) > 0) {
                    foreach ($materias as $materia) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($materia['nome']) . "</td>";
                        echo "<td><a href='#' class='delete-btn' data-id='" . $materia['id'] . "'>Excluir</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>Nenhuma matéria cadastrada.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Caixa de confirmação modal -->
    <!-- Modal -->
<div id="modal-confirm" class="modal">
    <div class="modal-content">
        <h2>Tem certeza que deseja apagar essa matéria?</h2>
        <div class="modal-footer">
            <button id="cancel-btn" class="btn-cancel">Não</button>
            <button id="confirm-btn" class="btn-confirm">Sim</button>
        </div>
    </div>
</div>



    <!-- Incluir o script de confirmação -->
    <script src="../js/confirmacao.js"></script>
</body>
</html>
