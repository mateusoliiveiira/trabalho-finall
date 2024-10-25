<?php
require_once 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Model\ModelTermos.php';

class TermoController {
    private $termoModel;

    public function __construct() {
        $this->termoModel = new Termo(); // Instancia o modelo Termo ao construir o controlador
    }

    public function index() {
        $termos = $this->termoModel->listarTermos(); // Lista todos os termos
        $materias = $this->termoModel->listarMaterias(); // Lista todas as matérias
        
        // Inclui a view passando as variáveis necessárias
        include 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Views\ViewsTermos.php';
    }

    public function editar() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $termoParaEditar = $this->termoModel->buscarTermoPorId($id);
        $materias = $this->termoModel->listarMaterias();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $materia_id = $_POST['materia_id'];
            $oquee = $_POST['oquee'];
            $ondeusa = $_POST['ondeusa'];
            $exemplo = $_POST['exemplo'];

            // Atualiza o termo no banco
            $this->termoModel->atualizar($id, $nome, $materia_id, $oquee, $ondeusa, $exemplo);

            // Mensagem de sucesso
            $mensagem = "Termo atualizado com sucesso!";
            $termos = $this->termoModel->listarTermos(); // Atualiza a lista de termos
            $materias = $this->termoModel->listarMaterias(); // Atualiza a lista de matérias
            include 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Views\ViewsTermos.php'; // Ajuste o caminho conforme necessário
        } else {
            include 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Views\EditarTermo.php'; // Ajuste o caminho conforme necessário
        }
    }

    public function excluir() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $this->termoModel->excluir($id);

        // Mensagem de sucesso
        $mensagem = "Termo excluído com sucesso!";
        $termos = $this->termoModel->listarTermos(); // Atualiza a lista de termos
        $materias = $this->termoModel->listarMaterias(); // Atualiza a lista de matérias
        include 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Views\ViewsTermos.php'; // Ajuste o caminho conforme necessário
    }

    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Captura os dados enviados pelo formulário
            $nome = isset($_POST['nome_termo']) ? $_POST['nome_termo'] : null;
            $materia_id = isset($_POST['materia_id']) ? $_POST['materia_id'] : null;
            $oquee = isset($_POST['oquee']) ? $_POST['oquee'] : null;
            $ondeusa = isset($_POST['ondeusa']) ? $_POST['ondeusa'] : null;
            $exemplo = isset($_POST['exemplo']) ? $_POST['exemplo'] : null;
            $formula = isset($_POST['formula']) ? $_POST['formula'] : null;

            // Validação simples
            if (empty($nome) || empty($materia_id) || empty($oquee) || empty($ondeusa)) {
                echo "Por favor, preencha todos os campos obrigatórios.";
                return;
            }

            // Chama o método salvar do modelo Termo
            $this->termoModel->salvar($nome, $materia_id, $oquee, $ondeusa, $exemplo, $formula);

            // Define a mensagem de sucesso e redireciona para a página de listagem
            $_SESSION['message'] = 'Termo salvo com sucesso!';
            header('Location: lista_termos.php');
            exit();
        }
    }
}
?>
