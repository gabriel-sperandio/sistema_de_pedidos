<?php
// DEBUG: Mostra todos os erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexão e CRUD primeiro
require 'includes/db.php'; // Altere para 'config/db.php' se preferir
require_once 'crud_pratos.php';

$crud = new PratoCRUD();
$produtos = $crud->listar();

// Depois o HTML
include 'includes/header.php';
?>

<main class="cardapio-container">
    <h1>Cardápio Digital</h1>
    
    <!-- Mensagens de debug -->
    <div class="container mb-4">
        <div class="alert alert-info">
            <h4>Debug:</h4>
            <p>PHP está funcionando corretamente.</p>
            <?php if (!empty($produtos)): ?>
                <p>✅ <strong><?= count($produtos) ?></strong> produtos carregados do banco.</p>
            <?php else: ?>
                <p class="text-danger">❌ Nenhum produto encontrado no banco.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Listagem de produtos -->
    <div class="container">
        <div class="row">
            <?php foreach ($produtos as $produto): ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card h-100">
                        <img src="<?= htmlspecialchars($produto['imagem'] ?? 'img/sem-foto.jpg') ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($produto['nome']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($produto['nome']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($produto['ingredientes']) ?></p>
                            <p class="text-muted">
                                <small><?= $produto['tempo_preparo'] ?> min • <?= $produto['categoria'] ?></small>
                            </p>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary btn-adicionar" 
                                    data-id="<?= $produto['id'] ?>">
                                <i class="bi bi-cart-plus"></i> R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php include 'includes/menu.php'; ?>