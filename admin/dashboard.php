<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: /login.php');
    exit;
}

require_once __DIR__ . '/../app/controllers/PratoController.php';
require_once __DIR__ . '/../includes/Database.php';

$pratoController = new PratoController();
$db = new Database();

// Define qual aba está aberta: 'pratos' ou 'pedidos'
$aba = $_GET['aba'] ?? 'pratos';

// Ações para pedidos
if ($aba === 'pedidos' && isset($_GET['acao'], $_GET['id'])) {
    $pedidoId = (int) $_GET['id'];
    $acao = $_GET['acao'];

    if (in_array($acao, ['preparando', 'pronto', 'entregue', 'cancelar'])) {
        if ($acao === 'cancelar') {
            // Atualiza status para cancelado
            $db->query("UPDATE pedidos SET status = 'cancelado' WHERE id = ?", [$pedidoId]);
            $_SESSION['mensagem'] = ['tipo' => 'warning', 'texto' => "Pedido #$pedidoId cancelado."];
        } else {
            // Atualiza status para um dos outros valores
            $db->query("UPDATE pedidos SET status = ? WHERE id = ?", [$acao, $pedidoId]);
            $_SESSION['mensagem'] = ['tipo' => 'success', 'texto' => "Status do pedido #$pedidoId atualizado para '".htmlspecialchars($acao)."'."];
        }
        header('Location: dashboard.php?aba=pedidos');
        exit;
    }
}

// Ações para pratos (já existentes)
$pratoEdicao = null;
if ($aba === 'pratos' && isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'salvar':
            $pratoController->salvar();
            break;
        case 'excluir':
            if (isset($_GET['id'])) {
                $pratoController->excluir();
            }
            break;
        case 'editar':
            if (isset($_GET['id'])) {
                $pratoEdicao = $pratoController->buscarPratoPorId($_GET['id']);
            }
            break;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard - Sistema de Pedidos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        .sidebar {
            background-color: #343a40;
            min-height: 100vh;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .formulario-prato {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        .badge-status {
            text-transform: capitalize;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block sidebar sidebar-dark p-3">
            <h4 class="text-white text-center mb-3">Painel Admin</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="?aba=pratos" class="nav-link <?= $aba === 'pratos' ? 'active' : '' ?>">
                        <i class="bi bi-egg-fried me-2"></i> Pratos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?aba=pedidos" class="nav-link <?= $aba === 'pedidos' ? 'active' : '' ?>">
                        <i class="bi bi-list-check me-2"></i> Pedidos
                    </a>
                </li>
                <li class="nav-item mt-4">
                    <a href="/sistema_de_pedidos/logout.php" class="nav-link text-danger">
                        <i class="bi bi-box-arrow-right me-2"></i> Sair
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Conteúdo principal -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">

            <?php if (isset($_SESSION['mensagem'])): ?>
                <div class="alert alert-<?= $_SESSION['mensagem']['tipo'] ?> alert-dismissible fade show mt-3" role="alert">
                    <?= $_SESSION['mensagem']['texto'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
                <?php unset($_SESSION['mensagem']); ?>
            <?php endif; ?>

            <?php if ($aba === 'pratos'): ?>
                <div class="d-flex justify-content-between align-items-center pb-3 border-bottom">
                    <h2>Gerenciamento de Pratos</h2>
                    <button id="toggleFormBtn" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Novo Prato
                    </button>
                </div>

                <div id="formContainer" class="formulario-prato mt-4" style="display: <?= $pratoEdicao ? 'block' : 'none' ?>;">
                    <?php
                    $prato = $pratoEdicao ?? null;
                    include __DIR__ . '/../app/views/pratos/form.php';
                    ?>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover mt-3 align-middle">
                        <thead class="table-dark">
                        <tr>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Categoria</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($pratoController->listarPratos() as $prato): ?>
                            <tr>
                                <td><?= htmlspecialchars($prato['nome']) ?></td>
                                <td>R$ <?= number_format($prato['preco'], 2, ',', '.') ?></td>
                                <td><?= htmlspecialchars($prato['categoria']) ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                        <a href="?aba=pratos&action=editar&id=<?= $prato['id'] ?>" class="btn btn-outline-primary" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="?aba=pratos&action=excluir&id=<?= $prato['id'] ?>" class="btn btn-outline-danger" title="Excluir"
                                           onclick="return confirm('Tem certeza que deseja excluir este prato?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php elseif ($aba === 'pedidos'): ?>

                <h2>Gerenciamento de Pedidos</h2>

                <?php
                // Busca os pedidos junto com nome do cliente
                $sql = "SELECT pedidos.*, usuarios.nome AS cliente_nome 
                        FROM pedidos 
                        JOIN usuarios ON pedidos.usuario_id = usuarios.id 
                        ORDER BY data_pedido DESC";
                $pedidos = $db->query($sql)->fetchAll();

                if (!$pedidos): ?>
                    <p>Nenhum pedido encontrado.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Data</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pedidos as $pedido): ?>
                                    <tr>
                                        <td><?= $pedido['id'] ?></td>
                                        <td><?= htmlspecialchars($pedido['cliente_nome']) ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($pedido['data_pedido'])) ?></td>
                                        <td>
                                            <?php
                                            $status = $pedido['status'];
                                            $badgeClass = match ($status) {
                                                'pendente' => 'badge bg-warning text-dark badge-status',
                                                'preparando' => 'badge bg-info text-dark badge-status',
                                                'pronto' => 'badge bg-primary badge-status',
                                                'em viagem' => 'badge bg-secondary badge-status',
                                                'entregue' => 'badge bg-success badge-status',
                                                'cancelado' => 'badge bg-danger badge-status',
                                                default => 'badge bg-light text-dark badge-status',
                                            };
                                            ?>
                                            <span class="<?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                                        </td>
                                        <td>R$ <?= number_format($pedido['total'], 2, ',', '.') ?></td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group" aria-label="Ações">

                                                <?php if (!in_array($pedido['status'], ['entregue', 'cancelado'])): ?>
                                                    <?php if ($pedido['status'] === 'pendente'): ?>
                                                        <a href="?aba=pedidos&acao=preparando&id=<?= $pedido['id'] ?>" class="btn btn-outline-info" title="Marcar como Preparando">
                                                            <i class="bi bi-hourglass-split"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <?php if ($pedido['status'] === 'preparando'): ?>
                                                        <a href="?aba=pedidos&acao=pronto&id=<?= $pedido['id'] ?>" class="btn btn-outline-primary" title="Marcar como Pronto">
                                                            <i class="bi bi-check2-circle"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <?php if ($pedido['status'] === 'pronto'): ?>
                                                        <a href="?aba=pedidos&acao=em viagem&id=<?= $pedido['id'] ?>" class="btn btn-outline-secondary" title="Marcar como Em Viagem">
                                                            <i class="bi bi-truck"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <?php if ($pedido['status'] === 'em viagem'): ?>
                                                        <a href="?aba=pedidos&acao=entregue&id=<?= $pedido['id'] ?>" class="btn btn-outline-success" title="Marcar como Entregue">
                                                            <i class="bi bi-check-lg"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <a href="?aba=pedidos&acao=cancelar&id=<?= $pedido['id'] ?>" class="btn btn-outline-danger" title="Cancelar Pedido" onclick="return confirm('Confirma o cancelamento deste pedido?');">
                                                        <i class="bi bi-x-circle"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">Sem ações</span>
                                                <?php endif; ?>

                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

            <?php endif; ?>

        </main>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const toggleBtn = document.getElementById('toggleFormBtn');
    const formContainer = document.getElementById('formContainer');

    toggleBtn?.addEventListener('click', () => {
        if (formContainer.style.display === 'none' || formContainer.style.display === '') {
            formContainer.style.display = 'block';
        } else {
            formContainer.style.display = 'none';
        }
    });
</script>
</body>
</html>