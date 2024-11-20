function menuShowPedido() {
    let menuMobile = document.querySelector('.mobile-menu');
    if (menuMobile.classList.contains('open')) {
        menuMobile.classList.remove('open');
        document.querySelector('.icon').src = "../assets/img/abrirMenu.png";
    } else {
        menuMobile.classList.add('open');
        document.querySelector('.icon').src = "../assets/img/fecharMenu.png";
    }
}