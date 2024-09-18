<?php
require_once 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Model\ModelTermos.php';

class TermoController {
    public function index() {
        $termo = new Termo();
        $termos = $termo->listarTermos(); // Atualize a função para listar todos os termos
        $materias = $termo->listarMaterias();
        
        // Inclua a view passando as variáveis necessárias
        include 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Views\ViewsTermos.php'; // Ajuste o caminho conforme necessário
    }

    public function salvar() {
        if (isset($_POST['nome'], $_POST['materia_id'], $_POST['oquee'], $_POST['ondeusa'], $_POST['exemplo'], $_POST['formula'])) {
            $nome = $_POST['nome'];
            $materia_id = $_POST['materia_id'];
            $oquee = $_POST['oquee'];
            $ondeusa = $_POST['ondeusa'];
            $exemplo = $_POST['exemplo'];
            $formula = $_POST['formula'];

            $termo = new Termo();
            $termo->salvar($nome, $materia_id, $oquee, $ondeusa, $exemplo, $formula);

            // Mensagem de sucesso
            $mensagem = "Termo cadastrado com sucesso!";
            $termos = $termo->listarTermos(); // Atualize a função para listar todos os termos
            $materias = $termo->listarMaterias();
            include 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Views\ViewsTermos.php'; // Ajuste o caminho conforme necessário
        }
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
            $formula = $_POST['formula'];

            $termo->atualizar($id, $nome, $materia_id, $oquee, $ondeusa, $exemplo, $formula);

            // Mensagem de sucesso
            $mensagem = "Termo atualizado com sucesso!";
            $termos = $termo->listarTermos(); // Atualize a função para listar todos os termos
            $materias = $termo->listarMaterias();
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
        $termos = $termo->listarTermos(); // Atualize a função para listar todos os termos
        $materias = $termo->listarMaterias();
        include 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Views\ViewsTermos.php'; // Ajuste o caminho conforme necessário
    }
}
?>
