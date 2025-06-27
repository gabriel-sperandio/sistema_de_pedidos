<?php
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/app/models/PratoModel.php';
require_once __DIR__ . '/app/controllers/PratoController.php';

$controller = new PratoController();

// Processa ações
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'salvar':
            $controller->salvar();
            break;
        case 'excluir':
            $controller->excluir();
            break;
    }
}

$produtos = $controller->listarPratos();

require __DIR__ . '/includes/header.php';
?>

<div class="container mt-4">
    <!-- Formulário de Cadastro -->
    <div class="card mb-5">
        <div class="card-header">
            <h2><?= isset($_GET['editar']) ? 'Editar' : 'Cadastrar' ?> Prato</h2>
        </div>
        <div class="card-body">
            <form method="post" action="?action=salvar" enctype="multipart/form-data">
                <?php if (isset($_GET['editar'])): ?>
                    <input type="hidden" name="id" value="<?= $_GET['editar'] ?>">
                <?php endif; ?>
                
                <div class="mb-3">
                    <label class="form-label">Nome*</label>
                    <input type="text" name="nome" class="form-control" required 
                           value="<?= $pratoEdicao['nome'] ?? '' ?>">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Ingredientes*</label>
                    <textarea name="ingredientes" class="form-control" required><?= $pratoEdicao['ingredientes'] ?? '' ?></textarea>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Tempo (min)</label>
                        <input type="number" name="tempo_preparo" class="form-control" 
                               value="<?= $pratoEdicao['tempo_preparo'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Categoria</label>
                        <input type="text" name="categoria" class="form-control" 
                               value="<?= $pratoEdicao['categoria'] ?? '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Preço*</label>
                        <input type="number" step="0.01" name="preco" class="form-control" required 
                               value="<?= $pratoEdicao['preco'] ?? '' ?>">
                    </div>
                    <div class="col-md-3 pt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="favorito" value="1" 
                                <?= isset($pratoEdicao['favorito']) && $pratoEdicao['favorito'] ? 'checked' : '' ?>>
                            <label class="form-check-label">Favorito</label>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Imagem</label>
                    <input type="file" name="imagem" class="form-control">
                </div>
                
                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>
    </div>

    <!-- Lista de Pratos -->
    <div class="card">
        <div class="card-header">
            <h2>Cardápio</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($produtos)): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Ingredientes</th>
                                <th>Tempo</th>
                                <th>Preço</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produtos as $produto): ?>
                                <tr>
                                    <td><?= htmlspecialchars($produto['nome']) ?></td>
                                    <td><?= htmlspecialchars($produto['ingredientes']) ?></td>
                                    <td><?= $produto['tempo_preparo'] ?> min</td>
                                    <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                                    <td>
                                        <a href="?editar=<?= $produto['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                        <a href="?action=excluir&id=<?= $produto['id'] ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Tem certeza?')">Excluir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">Nenhum prato cadastrado ainda.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>