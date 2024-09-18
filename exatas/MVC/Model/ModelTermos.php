<?php
class Termo {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=exatas', 'root', '');
    }

    public function listarTermos() {
        $sql = "SELECT termos.id, termos.nome, materias.nome AS materia_nome
                FROM termos
                JOIN materias ON termos.materia_id = materias.id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarMaterias() {
        $sql = "SELECT id, nome FROM materias";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar($nome, $materia_id, $oquee, $ondeusa, $exemplo, $formula) {
        $sql = "INSERT INTO termos (nome, materia_id, oquee, ondeusa, exemplo, formula) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nome, $materia_id, $oquee, $ondeusa, $exemplo, $formula]);
    }

    public function buscarTermoPorId($id) {
        $sql = "SELECT * FROM termos WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $nome, $materia_id, $oquee, $ondeusa, $exemplo, $formula) {
        $sql = "UPDATE termos SET nome = ?, materia_id = ?, oquee = ?, ondeusa = ?, exemplo = ?, formula = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nome, $materia_id, $oquee, $ondeusa, $exemplo, $formula, $id]);
    }

    public function excluir($id) {
        $sql = "DELETE FROM termos WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }
}
?>
