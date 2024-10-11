<?php
# Inicia a sessão para acessar as variáveis de sessão
session_start(); 

# Verifique se o usuário está logado
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <title>Serv+Cuscuz</title>
</head>
<body>   
    <div class="container-fluid">
        <header class="topo-site">
            <div class="navegacao">
                <nav class="navbar navbar-expand-lg ">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav nav-underline navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="navbar-brand" href="#">Quem somos</a>
                            </li>
                            <li class="nav-item">
                                <a class="navbar-brand" href="#rodapé">Contatos</a>
                            </li>
                            <li class="nav-item">
                                <form class="d-flex" role="search">
                                    <input class="form-control form-control-sm me-2" type="search" placeholder="Pesquisar Cuscuz" aria-label="Search">
                                    <button class="btn btn-primary" type="submit">Pesquisar</button>
                                </form>
                            </li>
                        </ul>    
                    </div>
                </nav> 
            </div>
            <div class="logo">
                <a href="#" class="logo">
                    <img src="./img/LOGO+SIMBOLO.png" alt="Logo Serv+Cuscuz">
                </a>
            </div>
            <div class="loginCadastro icone-carrinho icons">
                <div id="cart" class="bi bi-basket" style="width: 46px;"></div>
                <!-- Verificar se o usuário está logado -->
                <?php if ($isLoggedIn): ?>
                    <a href="../ServMaisCuscuz/includes/logout.php" class="btn btn-danger" style="margin-left: 15px;">Sair</a>
                <?php else: ?>
                    <a href="../ServMaisCuscuz/pages/login.php" class="btn btn-primary" style="margin-left: 15px;">Login</a>
                <?php endif; ?>
            </div>
        </header>
        <!--Carrossel-->
        <div class="carrossel">
          <div id="carouselExampleDark" class="carousel carousel-dark slide">
              <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
              </div>
              <div class="carrosselimg carousel-inner">
                <div class="carousel-item active" data-bs-interval="2000">
                  <img src="./img/Cuscuz_normal.jpg" class="d-block w-100" alt="...">
                  <div class="carousel-caption d-none d-md-block">
                    <h3 class="titulo">Cuscuz Normal</h3>
                    <p class="titulo">Exclente opção para quem ama as raizes nordestinas.</p>
                  </div>
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                  <img src="./img/Cuscuz_Recheado_frango.jpg" class="d-block w-100" alt="...">
                  <div class="carousel-caption d-none d-md-block">
                    <h3 class="titulo">Cuscuz recheado com frango.</h3>
                    <p class="titulo">Otima opção para quem está seguindo uma boa dieta.</p>
                  </div>
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                  <img src="./img/Cuscuz_Recheado_jerked.jpg" class="d-block w-100" alt="...">
                  <div class="carousel-caption d-none d-md-block">
                    <h3 class="titulo">Cuscuz recheado.</h3>
                    <p class="titulo">Esse serve como uma refeição.</p>
                  </div>
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
        </div>        
        <!--Fim carrossel-->
        <div class="lista-suspensa">
          <div class="tipodecuscuz">
            <select name="Tipos de Cuscuz" id="lista" onchange="scrollToSection(this.value)">
                      <option value="simples" >Simples</option>
                      <option value="vegano" >Vegano</option>
                      <option value="frango" >Frango</option>
                      <option value="carne" >Carne</option>
                      <option value="dieta" >Dieta</option>
                      <option value="personalizavel" >Personalizavel</option>
            </select>
          </divtipodecuscuz>        
        </div>
        <!--Meus produtos-->
        <div class="produtos">
          <section class="simples" id="simples">
          <div class="espacoprodutos card" style="width: 22rem;">
                <img src="./img/Cuscuz_normal.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="espacoprodutos card" style="width: 22rem;">
                <img src="./img/Cuscuz_normal.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="espacoprodutos card" style="width: 22rem;">
                <img src="./img/Cuscuz_normal.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
          </section>
          <sectio class="vegano" id="vegano">
          <div class="espacoprodutos card" style="width: 22rem;">
                <img src="./img/Cuscuz_normal.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="espacoprodutos card" style="width: 22rem;">
                <img src="./img/Cuscuz_normal.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="espacoprodutos card" style="width: 22rem;">
                <img src="./img/Cuscuz_normal.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
          </sectio>
          <section class="frango" id="frango">
          <div class="espacoprodutos card" style="width: 22rem;">
                <img src="./img/Cuscuz_normal.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="espacoprodutos card" style="width: 22rem;">
                <img src="./img/Cuscuz_normal.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="espacoprodutos card" style="width: 22rem;">
                <img src="./img/Cuscuz_normal.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
          </section>
          <section class="carne" id="carne">
          <div class="espacoprodutos card" style="width: 22rem;">
                <img src="./img/Cuscuz_normal.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="espacoprodutos card" style="width: 22rem;">
                <img src="./img/Cuscuz_normal.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="espacoprodutos card" style="width: 22rem;">
                <img src="./img/Cuscuz_normal.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
          </section>
          <section class="dieta" id="dieta">
            <div class="espacoprodutos card" style="width: 22rem;">
                <img src="./img/Cuscuz_normal.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="espacoprodutos card" style="width: 22rem;">
                <img src="./img/Cuscuz_normal.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="espacoprodutos card" style="width: 22rem;">
                <img src="./img/Cuscuz_normal.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
          </section>
            <section class="personalizavel" id="personalizavel">
            <div class="espacoprodutos card" style="width: 22rem;">
                <img src="./img/Cuscuz_normal.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="espacoprodutos card" style="width: 22rem;">
                <img src="./img/Cuscuz_normal.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="espacoprodutos card" style="width: 22rem;">
                <img src="./img/Cuscuz_normal.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            </section>       
        </div>
        <!--fim do meus produtos-->
        <footer class="rodape" id="rodapé">

            <h1>Rodapé</h1>
        </footer>
    </div>
    <script src="./js/home.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>