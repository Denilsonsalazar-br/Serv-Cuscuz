// Função para pré-visualizar a imagem selecionada
function previewImage(event) {
    var file = event.target.files[0]; // Captura o arquivo selecionado
    var reader = new FileReader(); // Cria um novo FileReader para ler o arquivo

    reader.onload = function() {
        var imagePreview = document.getElementById('imagePreview'); // Referência ao elemento <img>
        imagePreview.src = reader.result; // Define o conteúdo da imagem
        imagePreview.style.display = 'block'; // Exibe a imagem
    };

    if (file) {
        reader.readAsDataURL(file); // Lê o arquivo e dispara a função onload
    }
}