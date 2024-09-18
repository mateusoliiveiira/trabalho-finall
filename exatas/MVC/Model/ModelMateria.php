<?php
class Cadastro {
    private $pdo;

    public function __construct() {
        // Conectar ao banco de dados
        $host = 'localhost';
        $dbname = 'exatas';
        $username = 'root';
        $password = '';

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Erro: ' . $e->getMessage();
        }
    }

    public function salvar($nome) {
        $sql = "INSERT INTO materias (nome) VALUES (:nome)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();
    }
}
?>
