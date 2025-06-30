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

$pratoController = new PratoController();

$pratoEdicao = null;
if (isset($_GET['action'])) {
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
                    <a href="dashboard.php" class="nav-link <?= (!isset($_GET['action']) || $_GET['action'] === 'editar' || $_GET['action'] === 'novo') ? 'active' : '' ?>">
                        <i class="bi bi-egg-fried me-2"></i> Pratos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pedidos.php" class="nav-link <?= (isset($_GET['action']) && $_GET['action'] === 'pedidos') ? 'active' : '' ?>">
                        <i class="bi bi-list-check me-2"></i> Pedidos
                    </a>
                </li>
                <li class="nav-item mt-4">
                    <a href="/logout.php" class="nav-link text-danger">
                        <i class="bi bi-box-arrow-right me-2"></i> Sair
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Conteúdo principal -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between align-items-center pb-3 border-bottom">
                <h2>Gerenciamento de Pratos</h2>
                <button id="toggleFormBtn" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Novo Prato
                </button>
            </div>

            <?php if (isset($_SESSION['mensagem'])): ?>
                <div class="alert alert-<?= $_SESSION['mensagem']['tipo'] ?> alert-dismissible fade show mt-3" role="alert">
                    <?= $_SESSION['mensagem']['texto'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
                <?php unset($_SESSION['mensagem']); ?>
            <?php endif; ?>

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
                        <!-- <th>Imagem</th> -->
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pratoController->listarPratos() as $prato): ?>
                        <tr>
                            <!-- <td>
                                <img src="/uploads/<?= htmlspecialchars($prato['imagem']) ?>"
                                     alt="<?= htmlspecialchars($prato['nome']) ?>"
                                     class="img-thumbnail"
                                     style="width: 60px; height: 60px; object-fit: cover;">
                            </td> -->
                            <td><?= htmlspecialchars($prato['nome']) ?></td>
                            <td>R$ <?= number_format($prato['preco'], 2, ',', '.') ?></td>
                            <td><?= htmlspecialchars($prato['categoria']) ?></td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                    <a href="?action=editar&id=<?= $prato['id'] ?>" class="btn btn-outline-primary" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="?action=excluir&id=<?= $prato['id'] ?>" class="btn btn-outline-danger" title="Excluir"
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
        </main>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const toggleBtn = document.getElementById('toggleFormBtn');
    const formContainer = document.getElementById('formContainer');

    toggleBtn.addEventListener('click', () => {
        if (formContainer.style.display === 'none' || formContainer.style.display === '') {
            formContainer.style.display = 'block';
        } else {
            formContainer.style.display = 'none';
        }
    });
</script>
</body>
</html>