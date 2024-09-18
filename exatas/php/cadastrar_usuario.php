<?php
$host = 'localhost';
$dbname = 'exatas';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar se os dados foram enviados
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha'])) {
            // Obtendo os dados do formulário
            $nome = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $senha = trim($_POST['senha']);
            
            if (empty($nome) || empty($email) || empty($senha)) {
                throw new Exception("Todos os campos são obrigatórios.");
            }

            $senhaHash = password_hash($senha, PASSWORD_BCRYPT); // Criptografando a senha

            // Preparando a consulta SQL
            $sql = "INSERT INTO usuario (nome, email, senha) VALUES (:nome, :email, :senha)";
            $stmt = $pdo->prepare($sql);
            
            // Executando a consulta
            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':senha' => $senhaHash,
            ]);

            echo "Usuário cadastrado com sucesso!";
        } else {
            throw new Exception("Dados do formulário não enviados corretamente.");
        }
    } else {
        throw new Exception("Método de requisição não suportado.");
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
} catch (PDOException $e) {
    echo "Erro ao conectar ou inserir dados: " . $e->getMessage();
}
?>
