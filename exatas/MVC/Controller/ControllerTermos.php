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
    public function salvar() {
        if (isset($_POST['nome'], $_POST['materia_id'], $_POST['oquee'], $_POST['ondeusa'], $_POST['exemplo'])) {
            $nome = $_POST['nome'];
            $materia_id = $_POST['materia_id'];
            $oquee = $_POST['oquee'];
            $ondeusa = $_POST['ondeusa'];
            $exemplo = $_POST['exemplo'];

            $formula = null; // Inicializa a variável de imagem

            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
                // Processar upload da imagem
                $uploadDir = '../uploads/'; // Pasta para armazenar imagens
                $nomeImagem = uniqid() . '-' . basename($_FILES['imagem']['name']);
                $uploadFile = $uploadDir . $nomeImagem;

                // Mover o arquivo para a pasta de uploads
                if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadFile)) {
                    $formula = $uploadFile; // Salva o caminho da imagem
                } else {
                    $mensagem = "Erro ao fazer upload da imagem.";
                }
            }

            // Salvar no banco de dados, mesmo se a imagem não foi enviada
            $termo = new Termo();
            $termo->salvar($nome, $materia_id, $oquee, $ondeusa, $exemplo, $formula);

            // Mensagem de sucesso
            $mensagem = "Termo cadastrado com sucesso!";
            $termos = $termo->listarTermos(); // Atualiza a lista de termos
            $materias = $termo->listarMaterias(); // Atualiza a lista de matérias
            include 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Views\ViewsTermos.php'; // Ajuste o caminho conforme necessário
        }
    }

    // ... (Outros métodos: editar, excluir)

  
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
