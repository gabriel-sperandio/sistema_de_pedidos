<?php require_once __DIR__.'/../layouts/header.php'; ?>

<div class="card">
    <div class="card-header">
        <h2><?= isset($prato['id']) ? 'Editar' : 'Novo' ?> Prato</h2>
    </div>
    <div class="card-body">
        <form action="/admin/pratos/salvar" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $prato['id'] ?? '' ?>">
            
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Prato</label>
                <input type="text" class="form-control" id="nome" name="nome" 
                       value="<?= htmlspecialchars($prato['nome'] ?? '') ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="ingredientes" class="form-label">Ingredientes</label>
                <textarea class="form-control" id="ingredientes" name="ingredientes" 
                          rows="3"><?= htmlspecialchars($prato['ingredientes'] ?? '') ?></textarea>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="preco" class="form-label">Preço (R$)</label>
                    <input type="number" step="0.01" class="form-control" id="preco" name="preco" 
                           value="<?= $prato['preco'] ?? '' ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="tempo_preparo" class="form-label">Tempo de Preparo (min)</label>
                    <input type="number" class="form-control" id="tempo_preparo" name="tempo_preparo" 
                           value="<?= $prato['tempo_preparo'] ?? '' ?>">
                </div>
                <div class="col-md-4">
                    <label for="categoria" class="form-label">Categoria</label>
                    <select class="form-select" id="categoria" name="categoria">
                        <option value="">Selecione...</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= htmlspecialchars($categoria) ?>" 
                                <?= isset($prato['categoria']) && $prato['categoria'] === $categoria ? 'selected' : '' ?>>
                                <?= htmlspecialchars($categoria) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="favorito" name="favorito" 
                           value="1" <?= isset($prato['favorito']) && $prato['favorito'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="favorito">Destaque (Favorito)</label>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem do Prato</label>
                <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
                <?php if (isset($prato['imagem']) && $prato['imagem']): ?>
                    <div class="mt-2">
                        <img src="/uploads/pratos/<?= htmlspecialchars($prato['imagem']) ?>" 
                             alt="Imagem atual" style="max-height: 100px;">
                        <p class="text-muted mt-1">Imagem atual</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="/admin/pratos" class="btn btn-secondary">Voltar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__.'/../layouts/footer.php'; ?>