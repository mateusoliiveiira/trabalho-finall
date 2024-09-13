<?php
// Incluir o arquivo de inicialização e autoload, se necessário
require_once '\xampp\htdocs\trabalho-finall\exatas\MVC\Controller\ControllerMateria.php';
require_once 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Model\ModelMateria.php';
require_once 'C:\xampp\htdocs\trabalho-finall\exatas\php\Conexao.php'; // Supondo que este arquivo contenha a conexão com o banco de dados


// Verificar se o parâmetro 'id' está definido na URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID não foi fornecido.");
}

// Pegar o ID da URL
$id = $_GET['id'];

// Criar a conexão com o banco de dados
$pdo = Conexao::getConexao();

// Instanciar o modelo e o controlador
$model = new ExemploModel($pdo);
$controller = new ExemploController($model);

// Buscar os dados atuais para preencher o formulário
$sql = "SELECT * FROM matematica WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$dados = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar se os dados foram encontrados
if (!$dados) {
    echo "Registro não encontrado.";
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Exemplo</title>
</head>
<body>
    <h1>Atualizar Matéria</h1>

    <form action="atualizar.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">

        <label for="oquee">O que é:</label>
        <input type="text" name="oquee" id="oquee" value="<?php echo $dados['oquee']; ?>" required><br>

        <label for="ondeusa">Onde se usa:</label>
        <input type="text" name="ondeusa" id="ondeusa" value="<?php echo $dados['ondeusa']; ?>" required><br>

        <label for="exemplo">Exemplo:</label>
        <input type="text" name="exemplo" id="exemplo" value="<?php echo $dados['exemplo']; ?>" required><br>

        <label for="formula">Fórmula (opcional):</label>
        <input type="file" name="formula" id="formula"><br>

        <button type="submit">Atualizar</button>
    </form>
</body>
</html>
