// Após o login bem-sucedido:

// Substitui a entrada atual no histórico pela nova página
window.history.replaceState(null, null, '../../pages/home.php');

// Redireciona para a nova página
window.location.href = '../../pages/home.php';