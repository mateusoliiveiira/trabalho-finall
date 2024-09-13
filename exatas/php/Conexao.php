<?php
class Conexao {
    private static $pdo;

    public static function getConexao() {
        $host = 'localhost';
        $dbname = 'exatas';
        $username = 'root';
        $password = '';

        if (!isset(self::$pdo)) {
            try {
                self::$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro ao conectar: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
?>
