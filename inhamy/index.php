<?php 
// INCLUI O HEADER (com barra de busca)
include 'includes/header.php'; 
?>

<!-- CONTEÚDO DO CARDÁPIO (sua home) -->
<main class="cardapio-container">
    
    <h1>Cardápio Digital</h1>
    
    <div class="itens-cardapio">
        <!-- Itens serão carregados aqui -->
        <?php foreach($produtos as $produto): ?>
            <div class="item-cardapio">
                <img src="<?= $produto['imagem'] ?>" alt="<?= $produto['nome'] ?>">
                <h3><?= $produto['nome'] ?></h3>
                <p><?= $produto['descricao'] ?></p>
                <span class="preco">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></span>
                <button class="btn-adicionar" data-id="<?= $produto['id'] ?>">
                    Adicionar
                </button>
            </div>
        <?php endforeach; ?>
    </div>

</main>

<?php 
// INCLUI O MENU INFERIOR (com navegação)
include 'includes/menu.php'; 
?>