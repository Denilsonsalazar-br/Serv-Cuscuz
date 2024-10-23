<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/carrosel.css">
    <title></title>
</head>
<body>
    <!-- Carrossel -->
    <div class="carrossel">
        <div class="carrossel-container">
            <div class="carrossel-item active">
                <img src="../assets/img/Cuscuz_normal.jpg" alt="Cuscuz Normal">
                <div class="carrossel-caption">
                    <h3>Cuscuz Normal</h3>
                    <p>Excelente opção para quem ama as raízes nordestinas.</p>
                </div>
            </div>
            <div class="carrossel-item">
                <img src="../assets/img/Cuscuz_Recheado_frango.jpg" alt="Cuscuz recheado com frango">
                <div class="carrossel-caption">
                    <h3>Cuscuz recheado com frango</h3>
                    <p>Ótima opção para quem está seguindo uma boa dieta.</p>
                </div>
            </div>
            <div class="carrossel-item">
                <img src="../assets/img/Cuscuz_Recheado_jerked.jpg" alt="Cuscuz recheado">
                <div class="carrossel-caption">
                    <h3>Cuscuz recheado</h3>
                    <p>Esse serve como uma refeição.</p>
                </div>
            </div>
        </div>
        <button class="carrossel-btn prev" onclick="prevSlide()">❮</button>
        <button class="carrossel-btn next" onclick="nextSlide()">❯</button>
    </div>
    <!-- Fim carrossel -->

    <script src="../assets/js/carrosselHome.js"></script>
</body>
</html>