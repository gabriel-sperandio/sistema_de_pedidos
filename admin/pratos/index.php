<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['is_admin'] != 1) {
    header('Location: /index.php'); // redireciona para área do cliente
    exit;
}

$titulo = 'Admin - Gerenciar Pratos';
require_once __DIR__.'/../../includes/header.php';
require_once __DIR__.'/../../includes/Database.php';
require_once __DIR__.'/../../app/models/PratoModel.php';

$model = new PratoModel();
$pratos = $model->listarTodos();
?>

<main class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-utensils me-2"></i>Gerenciar Pratos</h1>
        <a href="index.php?action=novo" class="btn btn-success btn-sm">
            <i class="fas fa-plus-circle me-1"></i> Novo Prato
        </a>
    </div>

    <?php if (isset($_SESSION['mensagem'])): ?>
        <div class="alert alert-<?= $_SESSION['mensagem']['tipo'] ?> alert-dismissible fade show">
            <?= $_SESSION['mensagem']['texto'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['mensagem']); ?>
    <?php endif; ?>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($pratos as $prato): ?>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="/uploads/<?= $prato['imagem'] ?>" class="card-img-top" alt="<?= $prato['nome'] ?>">

                    <div class="card-body">
                        <h5 class="card-title"><?= $prato['nome'] ?></h5>
                        <p class="card-text"><?= $prato['ingredientes'] ?></p>
                        <p class="fw-bold text-success">R$ <?= number_format($prato['preco'], 2, ',', '.') ?></p>
                    </div>

                    <div class="card-footer bg-white border-0 d-flex flex-wrap gap-1">
                        <a href="/index.php?action=editar&id=<?= $prato['id'] ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>

                        <a href="/index.php?action=excluir&id=<?= $prato['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir este prato?')">
                            <i class="fas fa-trash-alt"></i> Excluir
                        </a>

                        <?php if ($prato['ativo']): ?>
                            <a href="/index.php?action=ativar&id=<?= $prato['id'] ?>&status=0" class="btn btn-secondary btn-sm">
                                <i class="fas fa-eye-slash"></i> Ocultar
                            </a>
                        <?php else: ?>
                            <a href="/index.php?action=ativar&id=<?= $prato['id'] ?>&status=1" class="btn btn-success btn-sm">
                                <i class="fas fa-eye"></i> Reexibir
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require_once __DIR__.'/../../includes/footer.php'; ?>