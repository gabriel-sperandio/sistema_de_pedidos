<?php
session_start();
require_once __DIR__ . '/includes/Database.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$carrinho = $_SESSION['carrinho'] ?? [];

// Calcular total
$total = 0;
foreach ($carrinho as $item) {
    $total += $item['preco'] * $item['quantidade'];
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Seu Carrinho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Carrinho de Compras</h2>

        <?php if (empty($carrinho)): ?>
            <div class="alert alert-warning">Seu carrinho está vazio.</div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($carrinho as $key => $item): ?>
                    <div class="col-12 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body d-flex justify-content-between flex-wrap align-items-center">
                                <!-- Nome e preço -->
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-1"><?= htmlspecialchars($item['nome']) ?></h5>
                                    <p class="text-muted small mb-2">Preço unitário: R$ <?= number_format($item['preco'], 2, ',', '.') ?></p>

                                    <!-- Controles de quantidade -->
                                    <div class="d-flex align-items-center">
                                        <form action="carrinho_atualizar.php" method="post" class="me-1">
                                            <input type="hidden" name="key" value="<?= $key ?>">
                                            <button type="submit" name="acao" value="diminuir" class="btn btn-outline-secondary btn-sm rounded-circle" title="Diminuir">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </form>

                                        <span class="mx-2 fw-bold"><?= $item['quantidade'] ?></span>

                                        <form action="carrinho_atualizar.php" method="post" class="ms-1">
                                            <input type="hidden" name="key" value="<?= $key ?>">
                                            <button type="submit" name="acao" value="aumentar" class="btn btn-outline-secondary btn-sm rounded-circle" title="Aumentar">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Total e remover -->
                                <div class="text-end mt-3 mt-md-0">
                                    <p class="mb-2 fw-semibold">Subtotal:</p>
                                    <h5 class="text-success mb-3">R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?></h5>
                                    <form action="carrinho_atualizar.php" method="post" onsubmit="return confirm('Remover este item?');">
                                        <input type="hidden" name="key" value="<?= $key ?>">
                                        <button type="submit" name="acao" value="remover" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-trash-alt me-1"></i> Remover
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Total geral -->
            <div class="text-end fw-bold fs-5 mt-4">
                Total: R$ <?= number_format($total, 2, ',', '.') ?>
            </div>

            <!-- Formulário de Finalização -->
            <form action="finalizar_pedido.php" method="post" class="mt-4">
                <hr class="my-5">

                <form action="finalizar_pedido.php" method="post">
                    <input type="hidden" name="total" value="<?= $total ?>">

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Informações do Pedido</h5>

                            <div class="mb-3">
                                <label for="forma_pagamento" class="form-label">Forma de Pagamento</label>
                                <select name="forma_pagamento" id="forma_pagamento" class="form-select" required>
                                    <option value="">Selecione...</option>
                                    <option value="dinheiro">Dinheiro</option>
                                    <option value="pix">Pix</option>
                                    <option value="cartao">Cartão</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="endereco" class="form-label">Endereço de Entrega</label>
                                <input type="text" name="endereco" id="endereco" class="form-control" placeholder="Rua, número, bairro..." required>
                            </div>

                            <div class="mb-3">
                                <label for="observacoes" class="form-label">Observações (opcional)</label>
                                <textarea name="observacoes" id="observacoes" class="form-control" rows="3" placeholder="Ex: sem cebola, trocar bebida..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-outline-secondary">
                            ← Voltar ao Cardápio
                        </a>
                        <button type="submit" class="btn btn-success">
                            Finalizar Pedido
                        </button>
                    </div>
                </form>

            </form>

        <?php endif; ?>
    </div>
</body>

</html>
<?php require __DIR__ . '/includes/footer.php'; ?>