<form action="dashboard.php?action=salvar" method="post" enctype="multipart/form-data">


    <?php if (!empty($pratoEdicao['id'])): ?>
        <input type="hidden" name="id" value="<?= $pratoEdicao['id'] ?>">
        <input type="hidden" name="imagem_atual" value="<?= $pratoEdicao['imagem'] ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label for="nome" class="form-label">Nome do Prato*</label>
        <input type="text" class="form-control" id="nome" name="nome" 
               value="<?= htmlspecialchars($pratoEdicao['nome'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
        <label for="ingredientes" class="form-label">Ingredientes*</label>
        <textarea class="form-control" id="ingredientes" name="ingredientes" 
                  rows="3" required><?= htmlspecialchars($pratoEdicao['ingredientes'] ?? '') ?></textarea>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="preco" class="form-label">Preço (R$)*</label>
            <input type="number" step="0.01" min="0" class="form-control" id="preco" name="preco" 
                   value="<?= htmlspecialchars($pratoEdicao['preco'] ?? '') ?>" required>
        </div>
        <div class="col-md-6">
            <label for="tempo_preparo" class="form-label">Tempo de Preparo (min)*</label>
            <input type="number" min="1" class="form-control" id="tempo_preparo" name="tempo_preparo" 
                   value="<?= htmlspecialchars($pratoEdicao['tempo_preparo'] ?? '') ?>" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="categoria" class="form-label">Categoria*</label>
        <select class="form-select" id="categoria" name="categoria" required>
            <option value="">Selecione...</option>
            <option value="entrada" <?= ($pratoEdicao['categoria'] ?? '') === 'entrada' ? 'selected' : '' ?>>Entrada</option>
            <option value="principal" <?= ($pratoEdicao['categoria'] ?? '') === 'principal' ? 'selected' : '' ?>>Principal</option>
            <option value="sobremesa" <?= ($pratoEdicao['categoria'] ?? '') === 'sobremesa' ? 'selected' : '' ?>>Sobremesa</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="imagem" class="form-label">Imagem</label>
        <input type="file" class="form-control" id="imagem" name="imagem">
        <?php if (!empty($pratoEdicao['imagem'])): ?>
            <div class="mt-2">
                <img src="/uploads/<?= htmlspecialchars($pratoEdicao['imagem']) ?>" height="100" class="img-thumbnail">
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="favorito" name="favorito" 
               value="1" <?= (!empty($pratoEdicao['favorito']) ? 'checked' : '') ?>>
        <label class="form-check-label" for="favorito">Destacar como favorito</label>
    </div>

    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="/admin/dashboard.php" class="btn btn-secondary">Cancelar</a>
    </div>
</form>