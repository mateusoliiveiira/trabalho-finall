<?php
require_once 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Model\ModelMateria.php';

class CadastroController {
    public function index() {
        require_once 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Views\ViewsMateria.php';
    }

    public function salvar() {
        if (isset($_POST['nome'])) {
            $nome = $_POST['nome'];

            $cadastro = new Cadastro();
            $cadastro->salvar($nome);

            // Mensagem de sucesso
            $mensagem = "Cadastro realizado com sucesso!";
            require_once 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Views\ViewsMateria.php';
        }
    }
}
?>
