<?php
/**
 * View do Carrossel de Pratos Favoritos
 * 
 * @param array $pratosFavoritos Array com os pratos favoritos (máx 3)
 * @param bool $isAdmin Define se mostra controles de administração
 */
?>
<div id="carrosselPratos" class="carousel slide mb-5" data-bs-ride="carousel">
    <?php if ($isAdmin): ?>
        <div class="carrossel-header d-flex justify-content-between align-items-center mb-2">
            <h3 class="h5 mb-0">Destaques do Dia</h3>
            <span class="badge bg-primary"><?= count($pratosFavoritos) ?>/3 favoritos</span>
        </div>
    <?php endif; ?>

    <div class="carousel-inner rounded-3 overflow-hidden shadow">
        <?php foreach ($pratosFavoritos as $index => $prato): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <div class="ratio ratio-16x9">
                    <img src="uploads/<?= htmlspecialchars($prato['imagem'] ?? 'default.jpg') ?>" 
                         class="d-block w-100 object-fit-cover" 
                         alt="<?= htmlspecialchars($prato['nome']) ?>">
                </div>
                
                <div class="carousel-caption carrossel-caption-custom">
                    <div class="d-flex justify-content-between align-items-end">
                        <div>
                            <h5 class="mb-1"><?= htmlspecialchars($prato['nome']) ?></h5>
                            <p class="mb-0">R$ <?= number_format($prato['preco'], 2, ',', '.') ?></p>
                        </div>
                        
                        <?php if ($isAdmin): ?>
                            <form method="post" class="ms-3">
                                <input type="hidden" name="prato_id" value="<?= $prato['id'] ?>">
                                <input type="hidden" name="favorito" value="0">
                                <button type="submit" name="toggle_favorito" 
                                        class="btn btn-sm btn-danger"
                                        title="Remover dos destaques">
                                    <i class="bi bi-star-fill"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (count($pratosFavoritos) > 1): ?>
        <button class="carousel-control-prev" type="button" data-bs-target="#carrosselPratos" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carrosselPratos" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    <?php endif; ?>
</div>

<style>
.carrossel-caption-custom {
    right: 0;
    left: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 100%);
    padding: 2rem 1rem 1rem;
}

.object-fit-cover {
    object-fit: cover;
}
</style>