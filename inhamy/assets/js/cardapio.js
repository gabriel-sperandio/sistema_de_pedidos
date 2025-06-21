document.addEventListener('DOMContentLoaded', function() {
    // Filtragem por categoria
    const filtros = document.querySelectorAll('.filtro-btn');
    const itens = document.querySelectorAll('.item-cardapio');
    
    filtros.forEach(filtro => {
        filtro.addEventListener('click', function() {
            // Remove classe active de todos os botões
            filtros.forEach(btn => btn.classList.remove('active'));
            
            // Adiciona classe active no botão clicado
            this.classList.add('active');
            
            const categoria = this.dataset.categoria;
            
            // Filtra os itens
            itens.forEach(item => {
                if (categoria === 'todos' || item.dataset.categoria === categoria) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
    
    // Adicionar ao carrinho
    const botoesAdicionar = document.querySelectorAll('.btn-adicionar');
    
    botoesAdicionar.forEach(botao => {
        botao.addEventListener('click', function() {
            const itemId = this.dataset.id;
            
            // Animação de confirmação
            this.innerHTML = '<i class="fas fa-check"></i> Adicionado';
            this.style.backgroundColor = '#2ecc71';
            
            // Aqui é para fazer uma requisição AJAX para adicionar ao carrinho
            // Exemplo:
            /*
            fetch('adicionar_carrinho.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: itemId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Atualiza o badge do carrinho no menu
                    const badge = document.querySelector('.menu-item[href="carrinho.php"] .menu-notificacao');
                    if (badge) {
                        badge.textContent = data.totalItens;
                        badge.style.display = 'block';
                    }
                }
            });
            */
            
            // Volta ao estado original após 2 segundos
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-plus"></i> Adicionar';
                this.style.backgroundColor = '#e74c3c';
            }, 2000);
        });
    });
});