<?php
require_once 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Model\ModelTermos.php';

class TermoController {
    public function index() {
        $termo = new Termo();
        $termos = $termo->listarTermos(); // Lista todos os termos
        $materias = $termo->listarMaterias(); // Lista todas as matérias
        
        // Inclui a view passando as variáveis necessárias
        include 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Views\ViewsTermos.php';
    }

  
    public function editar() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $termo = new Termo();
        $termoParaEditar = $termo->buscarTermoPorId($id);
        $materias = $termo->listarMaterias();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $materia_id = $_POST['materia_id'];
            $oquee = $_POST['oquee'];
            $ondeusa = $_POST['ondeusa'];
            $exemplo = $_POST['exemplo'];

            // Atualiza o termo no banco
            $termo->atualizar($id, $nome, $materia_id, $oquee, $ondeusa, $exemplo);

            // Mensagem de sucesso
            $mensagem = "Termo atualizado com sucesso!";
            $termos = $termo->listarTermos(); // Atualiza a lista de termos
            $materias = $termo->listarMaterias(); // Atualiza a lista de matérias
            include 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Views\ViewsTermos.php'; // Ajuste o caminho conforme necessário
        } else {
            include 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Views\EditarTermo.php'; // Ajuste o caminho conforme necessário
        }
    }

    public function excluir() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $termo = new Termo();
        $termo->excluir($id);

        // Mensagem de sucesso
        $mensagem = "Termo excluído com sucesso!";
        $termos = $termo->listarTermos(); // Atualiza a lista de termos
        $materias = $termo->listarMaterias(); // Atualiza a lista de matérias
        include 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Views\ViewsTermos.php'; // Ajuste o caminho conforme necessário
    }
}
?>
