
const searchInput = document.getElementById('searchInput');
const resultsContainer = document.getElementById('resultsContainer');

// Coleção de todos os cards de postos (health-post)
const healthPostCards = resultsContainer.querySelectorAll('.health-post');

function performSearch() {
    const searchTerm = searchInput.value.toLowerCase().trim();

    healthPostCards.forEach(postCard => {
        // Obtém o texto relevante para busca do card
        // Você precisa adaptar as classes conforme seu Blade
        const postName = postCard.querySelector('.post-title').textContent.toLowerCase();
        const postAddress = postCard.querySelector('.post-address').textContent.toLowerCase();

        // Verifica se o termo de busca está no nome OU no endereço
        if (postName.includes(searchTerm) || postAddress.includes(searchTerm)) {
            postCard.style.display = 'block'; // Mostra o card
        } else {
            postCard.style.display = 'none'; // Esconde o card
        }
    });
}

// Busca ao pressionar Enter
searchInput.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        performSearch();
    }
});

// Busca em tempo real enquanto digita
searchInput.addEventListener('input', function () {
    performSearch();
});

// Opcional: Se o campo estiver vazio ao carregar, mostra todos os resultados
window.addEventListener('load', function () {
    if (!searchInput.value.trim()) {
        healthPostCards.forEach(card => card.style.display = 'block');
    }
});
