<?php
session_start(); // Inicia a sessão, caso ainda não tenha sido iniciada

// Limpa todas as variáveis de sessão
session_unset();

// Destroi a sessão
session_destroy();

// Mensagem de feedback 
echo "Você foi deslogado com sucesso!";

// Redireciona para a página de login
header("Location: ../pages/login.php");
exit();
