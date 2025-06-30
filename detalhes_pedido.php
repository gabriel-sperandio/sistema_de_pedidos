<?php
session_start();
require_once __DIR__ . '/includes/Database.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: perfil.php');
    exit;
}

$db = new Database();
$pedido_id = (int)$_GET['id'];
$usuario_id = $_SESSION['usuario']['id'];

// Busca pedido só se for do usuário
$pedido = $db->query("SELECT * FROM pedidos WHERE id = ? AND usuario_id = ?", [$pedido_id, $usuario_id])->fetch();

if (!$pedido) {
    echo "Pedido não encontrado ou acesso negado.";
    exit;
}

$itens = $db->query("SELECT ip.*, p.nome FROM itens_pedido ip JOIN pratos p ON ip.prato_id = p.id WHERE ip.pedido_id = ?", [$pedido_id])->fetchAll();

require __DIR__ . '/includes/header.php';
?>

<div class="container mt-4">
    <h2>Detalhes do Pedido #<?= $pedido['id'] ?></h2>
    <p><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($pedido['data_pedido'])) ?></p>
    <p><strong>Status:</strong> <?= ucfirst($pedido['status']) ?></p>
    <p><strong>Forma de pagamento:</strong> <?= ucfirst($pedido['forma_pagamento']) ?></p>
    <p><strong>Endereço de entrega:</strong> <?= htmlspecialchars($pedido['endereco_entrega']) ?></p>
    <p><strong>Observações:</strong> <?= nl2br(htmlspecialchars($pedido['observacoes'])) ?></p>

    <h4>Itens</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Prato</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($itens as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nome']) ?></td>
                    <td><?= $item['quantidade'] ?></td>
                    <td>R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?></td>
                    <td>R$ <?= number_format($item['preco_unitario'] * $item['quantidade'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-end fw-bold">
        Total: R$ <?= number_format($pedido['total'], 2, ',', '.') ?>
    </div>

    <a href="perfil.php" class="btn btn-secondary mt-3">Voltar</a>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>