document.addEventListener('DOMContentLoaded', function() {
    // Adiciona classe ao body para o espaço do menu
    document.body.classList.add('com-menu');
    
    // Atualiza notificações dinamicamente (exemplo)
    function atualizarNotificacoes() {
        // Pode ser feita uma requisição AJAX aqui
        // fetch('api/notificacoes')
        //     .then(response => response.json())
        //     .then(data => {
        //         document.querySelector('.menu-notificacao').textContent = data.total;
        //     });
    }
    
    // Atualiza a cada 30 segundos (opcional)
    setInterval(atualizarNotificacoes, 30000);
});