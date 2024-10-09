<?php
// Conectar ao banco de dados
$host = 'localhost';
$dbname = 'exatas';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}

// Função para buscar todas as matérias
function listarMaterias($pdo) {
    $sql = 'SELECT id, nome FROM materias';
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erro ao buscar matérias: " . $e->getMessage());
    }
}

// Buscar todas as matérias
$materias = listarMaterias($pdo);

session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_user'])) {
    // Redireciona para a página de login se o usuário não estiver logado
    header("Location: login.php");
    exit();
}

// Exibe o nome completo do usuário logado
$nomeUsuario = $_SESSION['nome_completo'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
    <title>AprendeFácil</title>
</head>
<body>
<!-- Tela de carregamento -->
<div id="loading-screen">
    <div class="loader"></div>
    <p>Carregando...</p>


</div>
<script>
    // Função para simular carregamento de dados
    function carregarDados() {
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve('Dados carregados!');
            }, 1000); // Simula um carregamento de 3 segundos
        });
    }

    // Ocultar a tela de carregamento
    window.onload = async function() {
        const loadingScreen = document.getElementById('loading-screen');
        const welcomeMessage = document.getElementById('welcome-message');
        
        // Exibe a tela de carregamento
        loadingScreen.style.display = 'flex';

        // Simula o carregamento dos dados
        await carregarDados();
        
        loadingScreen.style.opacity = '0'; // Adiciona um efeito de transição
        setTimeout(() => {
            loadingScreen.style.display = 'none'; // Remove da tela após a transição
            welcomeMessage.style.display = 'block'; // Mostra a mensagem de boas-vindas
            welcomeMessage.classList.add('visible'); // Adiciona classe para animação
        }, 500); // Tempo deve ser igual ao tempo de transição no CSS
    };
</script>


<header>
    
    <h1 class="titulo">AprendeFácil</h1>]
    <h1 class="name">Bem-vindo, <?php echo $nomeUsuario; ?>!</h1>

<!-- Link de logout que abre a modal -->
<a class="logout-link" href="#" onclick="abrirModal()">Logout</a>

<!-- Modal de confirmação -->
<div id="logoutModal" class="modal">
    <div class="modal-content">
        <h2>Confirmação de Logout</h2>
        <p>Você realmente deseja fazer logout?</p>
        <button class="modal-button" onclick="confirmarLogout()">Sim</button>
        <button class="modal-button cancel-button" onclick="fecharModal()">Não</button>
    </div>
</div>
</header>
<script>
        // Função para abrir a modal de confirmação
        function abrirModal() {
            document.getElementById("logoutModal").style.display = "block";
        }

        // Função para fechar a modal
        function fecharModal() {
            document.getElementById("logoutModal").style.display = "none";
        }

        // Função para confirmar o logout
        function confirmarLogout() {
            window.location.href = "logout.php"; // Redireciona para a página de logout
        }

        // Função para fechar a modal ao clicar fora dela
        window.onclick = function(event) {
            const modal = document.getElementById("logoutModal");
            if (event.target == modal) {
                fecharModal();
            }
        }
    </script>
<main>
    <img class="banner" src="../img/backto.png" >

    <!-- Container para botões de matérias -->
    <div class="container-materias">
      
        
        <?php if (!empty($materias)) { ?>
            <?php foreach ($materias as $materia) { ?>
                <div class="container-botao-materia">
                    <a href="materia.php?id=<?php echo $materia['id']; ?>" class="botao-materia">
                        <?php echo htmlspecialchars($materia['nome']); ?>
                    </a>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>Nenhuma matéria cadastrada.</p>
        <?php } ?>
    </div>

    <div class="container-botao-adicionar-materia">
        <a href="cadastrar-materia.php">
            <button class="botao-adicionar-materia">+ Nova Matéria</button>
        </a>
    </div>
</main>


</body>
</html>
