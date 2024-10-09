<?php
// Inicia a sessão
session_start();

// Destroi todas as variáveis de sessão
session_unset();

// Destroi a sessão
session_destroy();

// Redireciona o usuário para a página de login ou página inicial
header("Location: login.php"); // Substitua 'login.php' pela página que você quer redirecionar
exit;
?>
