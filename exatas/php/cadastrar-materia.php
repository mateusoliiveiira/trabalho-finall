<?php

session_start();

if (!isset($_SESSION['tipo_funcionario']) || $_SESSION['tipo_funcionario'] != 1) {
    echo '<!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Acesso Negado</title>
        <style>
            /* Estilos para o modal */
            .modal {
                display: block; /* Exibe o modal */
                position: fixed; /* Fica no topo */
                z-index: 1000; /* Acima de outros elementos */
                left: 0;
                top: 0;
                width: 100%; /* Largura total */
                height: 100%; /* Altura total */
                overflow: auto; /* Habilita scroll se necessário */
                background-color: rgba(0, 0, 0, 0.5); /* Fundo preto com opacidade */
            }

            /* Estilos para o conteúdo do modal */
            .modal-content {
                background-color: #fff; /* Fundo branco */
                margin: 15% auto; /* Margem em cima e centralizado */
                padding: 20px;
                border: 1px solid #888; /* Borda cinza */
                width: 80%; /* Largura do modal */
                max-width: 500px; /* Largura máxima */
                border-radius: 8px; /* Bordas arredondadas */
            }

            /* Estilos para o botão de fechar */
            .close {
                color: #aaa; /* Cor do texto */
                float: right; /* Alinha à direita */
                font-size: 28px; /* Tamanho da fonte */
                font-weight: bold; /* Negrito */
            }

            .close:hover,
            .close:focus {
                color: black; /* Cor ao passar o mouse */
                text-decoration: none; /* Remove sublinhado */
                cursor: pointer; /* Cursor em ponteiro */
            }

            /* Estilos para o botão OK */
            button {
                background-color: #4CAF50; /* Verde */
                color: white; /* Texto branco */
                padding: 10px 15px; /* Espaçamento */
                border: none; /* Sem borda */
                border-radius: 5px; /* Bordas arredondadas */
                cursor: pointer; /* Cursor em ponteiro */
                font-size: 16px; /* Tamanho da fonte */
            }

            button:hover {
                background-color: #45a049; 
            }
        </style>
    </head>
    <body>
        <div class="modal" id="alertModal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Acesso Negado</h2>
                <p>Você não tem permissão para acessar esta página.</p>
                <button onclick="redirectToIndex()">OK</button>
            </div>
        </div>
        <script>
            function closeModal() {
                document.getElementById("alertModal").style.display = "none";
            }
            function redirectToIndex() {
                window.location.href = "index.php";
            }
        </script>
    </body>
    </html>';
    exit();
}


// Código da página de administrador aqui

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

// Função para salvar a matéria
function salvarMateria($pdo, $nome)
{
    $sql = 'INSERT INTO materias (nome) VALUES (:nome)';
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute(['nome' => $nome]);
        return $pdo->lastInsertId(); // Retorna o ID da matéria cadastrada
    } catch (PDOException $e) {
        die("Erro ao salvar: " . $e->getMessage());
    }
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['materia'])) {
    $nome = $_POST['materia'];

    $materia_id = salvarMateria($pdo, $nome);

    if ($materia_id) {
        $_SESSION['materia_cadastrada'] = true;
        $_SESSION['materia_id'] = $materia_id; // Armazenar o ID da matéria
        $mensagem = "Matéria cadastrada com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar matéria.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Matéria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/criarmateria.css">
    <link rel="stylesheet" href="../css/header.css">
</head>

<body>
<style></style>
    <header>
        <div class="cabecalho">
            <a class="log" href="index.php"><img src="../img/digitar.png" width="100" height="100"></a>
        </div>
        <div class ="adicionar">
           <h1 class="titulo">Adicionar Matéria</h1> 
        </div>
        

        <style>
            a.log img {
                width: 60px;
                height: auto;
                transition: transform 0.3s ease;
                /* animação suave */
            }

            a.log img:hover {
                transform: scale(1.2);
                /* aumenta a imagem em 20% */
            }

        </style>


        </a>
    </header>
    <div class="container-admateria">
        <div class="form-box-admateria">
            <h1 class="titulo-admateria">Nova matéria</h1>



            <form action="" method="POST" class="form-admateria">
                <input type="text" id="materia" name="materia" placeholder="Adicionar matéria" class="input-admateria"
                    required>
                <button type="submit" class="btn-admateria">Anexar</button>
            </form>

        </div>

        <!----------------------LISTAR------------------------------------------------------>
        <style>
            #materias-lista {
                display: none;
                text-decoration: none;
            }
        </style>
        <div>
            <a href="listar_materias.php" class="btn list-btn-admateria">Listar</a>
        </div>
        <div class="img">
            <?php if (isset($mensagem)) { ?>
                <p><?php echo htmlspecialchars($mensagem); ?></p>
            <?php } ?>
        </div>


        <div id="materias-lista">
            <?php
            // Conexão com o banco de dados
            $host = 'localhost';
            $dbname = 'exatas';
            $username = 'root';
            $password = '';

            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Consulta para buscar todas as matérias
                $sql = "SELECT id, nome FROM materias";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                // Verificar se há matérias cadastradas
                $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($materias) > 0) {
                    echo "<ul>";
                    foreach ($materias as $materia) {
                        echo "<li>" . htmlspecialchars($materia['nome']) . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "Nenhuma matéria cadastrada.";
                }

            } catch (PDOException $e) {
                die("Erro ao conectar: " . $e->getMessage());
            }
            ?>
        </div>

        <script>
            function alternarMaterias() {
                var lista = document.getElementById('materias-lista');
                if (lista.style.display === 'none' || lista.style.display === '') {
                    lista.style.display = 'block'; // Exibe a lista
                } else {
                    lista.style.display = 'none'; // Oculta a lista
                }
            }
        </script>
</body>

</html>
</body>

</html>