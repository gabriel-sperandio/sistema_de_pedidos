document.addEventListener('DOMContentLoaded', function() {
    const buscarInput = document.getElementById('buscarInput');
    const buscarForm = document.getElementById('buscarForm');
    const buscarResultados = document.getElementById('buscarResultados');
    let buscarTimeout;

    // Busca em tempo real com atraso de 300ms
    buscarInput.addEventListener('input', function() {
        clearTimeout(buscarTimeout);
        const query = this.value.trim();
        
        // Oculta resultados se a busca for muito curta
        if (query.length < 2) {
            buscarResultados.style.display = 'none';
            return;
        }

        // Aguarda 300ms antes de fazer a busca
        buscarTimeout = setTimeout(() => {
            fetchBuscarResultados(query);
        }, 300);
    });

    // Redireciona para a página de busca completa ao submeter o formulário
    buscarForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const query = buscarInput.value.trim();
        if (query) {
            window.location.href = `buscar.php?q=${encodeURIComponent(query)}`;
        }
    });

    // Esconde resultados ao clicar fora da área de busca
    document.addEventListener('click', function(e) {
        if (!buscarForm.contains(e.target)) {
            buscarResultados.style.display = 'none';
        }
    });

    // Busca os resultados via fetch e atualiza a lista
    function fetchBuscarResultados(query) {
        fetch(`includes/buscar.php?q=${encodeURIComponent(query)}&live=1`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    buscarResultados.innerHTML = data.map(post => `
                        <div class="buscar-resultado-item" onclick="window.location='post.php?id=${post.id}'">
                            <strong>${post.name}</strong> @${post.username}
                            <p>${post.content.substring(0, 50)}${post.content.length > 50 ? '...' : ''}</p>
                        </div>
                    `).join('');
                } else {
                    buscarResultados.innerHTML = '<div class="buscar-resultado-item">Nenhum resultado encontrado</div>';
                }
                buscarResultados.style.display = 'block';
            })
            .catch(error => {
                console.error('Erro na busca:', error);
            });
    }
});