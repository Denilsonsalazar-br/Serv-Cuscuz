<?php
// Inclua o controlador
require_once __DIR__ . "../../controller/carrossel/carrosselHomeController.php";

$carrosselController = new CarrosselController();
$itens = $carrosselController->recuperarItensDoBanco(); // Recupera os itens

// Agora você pode usar a variável $itens para construir seu carrossel
if (!$itens) {
    echo "Nenhum item encontrado.";
    exit;
}
//var_dump($itens); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/carrosel.css">
    <title>Carrossel de Produtos</title>
</head>
<body>
    <!-- Carrossel -->
    <div class="carrossel">
        <div class="carrossel-container">
            <?php foreach ($itens as $index => $item): ?>
                <div class="carrossel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    
                <img src="<?php echo htmlspecialchars('/Serv-Cuscuz/Serv+Cuscuz/' . $item->getImagemUrl()); ?>" alt="<?php echo htmlspecialchars($item->getTitulo()); ?>">

                    <div class="carrossel-caption">
                        <h2><?php echo htmlspecialchars($item->getTitulo()); ?></h2>
                        <p><?php echo htmlspecialchars($item->getDescricao()); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carrossel-btn prev" onclick="prevSlide()">❮</button>
        <button class="carrossel-btn next" onclick="nextSlide()">❯</button>
    </div>
    <!-- Fim carrossel -->

    <script src="../assets/js/carrosselHome.js"></script>
</body>
</html>