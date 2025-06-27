<?php 
$titulo = 'Cardápio Digital';
require_once __DIR__.'/../../includes/header.php'; 
?>

<main class="cardapio-container py-4">
    <?php if (isset($mensagem)): ?>
        <div class="alert alert-<?= $mensagem['tipo'] ?> alert-dismissible fade show">
            <?= $mensagem['texto'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-utensils me-2"></i>Nosso Cardápio</h1>
        <a href="/admin/pratos/novo" class="btn btn-success btn-sm">
            <i class="fas fa-plus-circle me-1"></i> Novo Item
        </a>
    </div>

    <!-- Grid de produtos -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($pratos as $prato): ?>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm">
                    <!-- ... conteúdo do card ... -->
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require_once __DIR__.'/../../includes/footer.php'; ?>