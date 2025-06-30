<?php
session_start();
require_once __DIR__ . '/includes/Database.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$db = new Database();
$usuario_id = $_SESSION['usuario']['id'];

$pedidos = $db->query("SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY data_pedido DESC", [$usuario_id])->fetchAll();

require __DIR__ . '/includes/header.php';
?>
<div class="container mt-3 text-end">
    <a href="logout.php" class="btn btn-outline-danger">Sair</a>
</div>

<div class="container mt-4">
    <h2>Meus Pedidos</h2>

    <?php if (empty($pedidos)): ?>
        <p>Você ainda não fez nenhum pedido.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?= date('d/m/Y H:i', strtotime($pedido['data_pedido'])) ?></td>
                        <td>
                            <?php
                            $status = $pedido['status'];
                            $badgeClass = match ($status) {
                                'pendente' => 'badge bg-warning text-dark',
                                'preparando' => 'badge bg-info text-dark',
                                'pronto' => 'badge bg-primary',
                                'em viagem' => 'badge bg-secondary',
                                'entregue' => 'badge bg-success',
                                'cancelado' => 'badge bg-danger',
                                default => 'badge bg-light text-dark'
                            };
                            ?>
                            <span class="<?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                        </td>
                        <td>R$ <?= number_format($pedido['total'], 2, ',', '.') ?></td>
                        <td>
                            <a href="detalhes_pedido.php?id=<?= $pedido['id'] ?>" class="btn btn-sm btn-outline-primary">Detalhes</a>
                            <?php if (in_array($pedido['status'], ['pendente', 'preparando'])): ?>
                                <form action="perfil.php" method="post" style="display:inline-block" onsubmit="return confirm('Tem certeza que deseja cancelar este pedido?');">
                                    <input type="hidden" name="pedido_id" value="<?= $pedido['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Cancelar</button>
                                </form>
                            <?php endif; ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>