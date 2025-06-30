document.addEventListener('DOMContentLoaded', () => {
    const searchForm = document.querySelector('.search-form');
    const searchInput = searchForm.querySelector('input[name="q"]');
    const searchType = searchForm.querySelector('input[name="tipo"]');
    const suggestionsContainer = document.querySelector('.search-suggestions');
    let debounceTimer;

    // Detecta contexto automaticamente
    if (window.location.pathname.includes('carrinho') || 
        window.location.pathname.includes('cardapio')) {
        searchType.value = 'pratos';
        searchInput.placeholder = 'Buscar pratos...';
    }

    // Busca em tempo real
    searchInput.addEventListener('input', (e) => {
        clearTimeout(debounceTimer);
        const query = e.target.value.trim();
        
        if (query.length > 1) {
            debounceTimer = setTimeout(() => fetchSuggestions(query), 300);
        } else {
            suggestionsContainer.style.display = 'none';
        }
    });

    // Foco na barra
    searchInput.addEventListener('focus', () => {
        if (searchInput.value.trim().length > 1) {
            fetchSuggestions(searchInput.value.trim());
        }
    });

    // Fecha sugestões ao clicar fora
    document.addEventListener('click', (e) => {
        if (!searchForm.contains(e.target)) {
            suggestionsContainer.style.display = 'none';
        }
    });

    // Função para buscar sugestões
    async function fetchSuggestions(query) {
        try {
            const response = await fetch(
                `buscar_unificado.php?q=${encodeURIComponent(query)}&live=1&tipo=${searchType.value}`
            );
            const results = await response.json();
            showSuggestions(results);
        } catch (error) {
            console.error('Erro na busca:', error);
        }
    }

    // Mostra sugestões
    function showSuggestions(results) {
        if (!results || results.length === 0) {
            suggestionsContainer.innerHTML = '<div class="suggestion">Nada encontrado</div>';
            suggestionsContainer.style.display = 'block';
            return;
        }

        suggestionsContainer.innerHTML = results.map(item => {
            if (searchType.value === 'pratos') {
                return `
                    <div class="suggestion" data-id="${item.id}">
                        ${item.imagem ? `<img src="${item.imagem}" alt="${item.nome}">` : ''}
                        <div class="info">
                            <div class="title">${item.nome}</div>
                            <div class="type">Prato • R$ ${item.preco?.toFixed(2) || '0,00'}</div>
                        </div>
                    </div>
                `;
            } else {
                return `
                    <div class="suggestion" data-id="${item.id}">
                        <div class="info">
                            <div class="title">${item.name || item.username}</div>
                            <div class="type">Post • ${item.content?.substring(0, 30) || ''}...</div>
                        </div>
                    </div>
                `;
            }
        }).join('');

        // Adiciona eventos de clique
        document.querySelectorAll('.suggestion').forEach(item => {
            item.addEventListener('click', () => {
                const url = searchType.value === 'pratos' 
                    ? `detalhes_prato.php?id=${item.dataset.id}`
                    : `post.php?id=${item.dataset.id}`;
                window.location.href = url;
            });
        });

        suggestionsContainer.style.display = 'block';
    }
});