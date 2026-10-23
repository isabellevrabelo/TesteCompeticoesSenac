const botaoTema = document.getElementById('btn-tema');
const htmlElement = document.documentElement;

// 1. Carrega o tema salvo (se existir) ao carregar a página
const temaSalvo = localStorage.getItem('theme') || 'light';
htmlElement.setAttribute('data-bs-theme', temaSalvo);
atualizarBotao(temaSalvo);

// 2. Escuta o clique do botão para alternar
botaoTema.addEventListener('click', () => {
    const novoTema = htmlElement.getAttribute('data-bs-theme') === 'light' ? 'dark' : 'light';
    
    htmlElement.setAttribute('data-bs-theme', novoTema);
    localStorage.setItem('theme', novoTema); // Salva no navegador
    atualizarBotao(novoTema);
});

// Função auxiliar para atualizar o visual do botão
function atualizarBotao(tema) {
    if (tema === 'dark') {
        botaoTema.textContent = 'Tema';
        botaoTema.className = 'btn btn-outline-light mb-4';
    } else {
        botaoTema.textContent = 'Tema';
        botaoTema.className = 'btn btn-outline-secondary mb-4';
    }
}
