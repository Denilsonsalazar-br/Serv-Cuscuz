<?php
// Iniciar a sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/home.css">
    <title>Serv+Cuscuz</title>
</head>
<div class="containerHome">
        <header>
            <?php
                include '../includes/header.php';
            ?>
        </header>
        <section>
            <?php
                include '../includes/carrossel.php';
            ?>
        </section>
        <main style="text-align: center; color: #000000">

        <h1>Conteudo home</h1>

        </main>
    </main>
    <footer>
        <?php
            include '../includes/footer.php'
        ?>
    </footer>
</div>
</body>
</html>