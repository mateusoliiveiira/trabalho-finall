<?php
class MateriaModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function cadastrarMateria($oquee, $ondeusa, $exemplo, $formula) {
        try {
            // Configuração para o upload do arquivo
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($formula["name"]);
            move_uploaded_file($formula["tmp_name"], $targetFile);

            // Prepara a consulta SQL
            $sql = "INSERT INTO materias (oquee, ondeusa, exemplo, formula) VALUES (:oquee, :ondeusa, :exemplo, :formula)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':oquee', $oquee);
            $stmt->bindParam(':ondeusa', $ondeusa);
            $stmt->bindParam(':exemplo', $exemplo);
            $stmt->bindParam(':formula', $targetFile);

            return $stmt->execute();
        } catch (PDOException $e) {
            die("Erro ao cadastrar: " . $e->getMessage());
        }
    }
}
