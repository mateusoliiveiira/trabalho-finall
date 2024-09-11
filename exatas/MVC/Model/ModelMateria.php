<?php
class ExemploModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function cadastrar($oquee, $ondeusa, $exemplo, $formula) {
        $sql = "INSERT INTO matematica (oquee, ondeusa, exemplo, formula) VALUES (:oquee, :ondeusa, :exemplo, :formula)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':oquee', $oquee);
        $stmt->bindParam(':ondeusa', $ondeusa);
        $stmt->bindParam(':exemplo', $exemplo);
        $stmt->bindParam(':formula', $formula);
        return $stmt->execute();
    }
}
?>
