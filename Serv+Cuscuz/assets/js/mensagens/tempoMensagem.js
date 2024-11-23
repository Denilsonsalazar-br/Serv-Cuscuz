document.addEventListener("DOMContentLoaded", function () {
    // Função para remover mensagens automaticamente
    const removerMensagem = (elemento) => {
        const tempoExibicao = 4000; // Define o tempo de exibição em milissegundos

        if (elemento) {
            setTimeout(() => {
                elemento.style.transition = "opacity 0.5s"; // Aplica transição suave
                elemento.style.opacity = "0"; // Faz desaparecer

                // Remove do DOM após a transição
                setTimeout(() => elemento.remove(), 500);
            }, tempoExibicao);
        }
    };

    // Seleciona mensagens dinâmicas por ID ou classe
    const mensagemFlash = document.getElementById("mensagemFlash"); // ID único para mensagens
    const mensagens = document.querySelectorAll(".msg"); // Classe comum para todas as mensagens

    // Remove mensagens únicas
    if (mensagemFlash) {
        removerMensagem(mensagemFlash);
    }

    // Remove múltiplas mensagens (se houver)
    mensagens.forEach((mensagem) => {
        removerMensagem(mensagem);
    });
});
