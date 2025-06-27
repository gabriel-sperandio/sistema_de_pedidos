    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script para confirmar exclusões
        document.querySelectorAll('.btn-excluir').forEach(button => {
            button.addEventListener('click', (e) => {
                if (!confirm('Tem certeza que deseja excluir este prato?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>