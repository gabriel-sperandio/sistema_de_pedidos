<?php
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/app/models/PratoModel.php';
require_once __DIR__ . '/app/controllers/PratoController.php';

session_start();

// Verifica se o usuário está logado
if (empty($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$isAdmin = ($_SESSION['usuario']['is_admin'] == 1);

// Configurações iniciais
require __DIR__ . '/includes/header.php';


$controller = new PratoController();

// Processa ações
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'salvar':
            $controller->salvar();
            break;
        case 'excluir':
            if ($isAdmin) {
                $controller->excluir();
            }
            break;
    }
}

// Preenche prato para edição
$pratoEdicao = array();
if (isset($_GET['editar'])) {
    $pratoEdicao = $controller->buscarPratoPorId($_GET['editar']);
}

// Obtém os produtos
$produtos = $controller->listarPratos();

// Filtra pratos favoritos (substituição da arrow function)
$pratosFiltrados = array_filter($produtos, function ($p) {
    return !empty($p['favorito']);
});
$pratosFavoritos = array_slice($pratosFiltrados, 0, 3);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <title>Tela Cardápio</title>

    <style>
        .card:hover {
            background-color: rgb(235, 231, 173);
            /* cor de fundo ao passar o mouse */
            transition: background-color 0.3s ease;
            /* suaviza a transição */
            cursor: pointer;
        }
    </style>
</head>



<div class="container mt-4">
    <!-- Carrossel de favoritos -->
    <?php include __DIR__ . '/app/views/carrosselPratos.php'; ?>

    <!-- Botão ver carrinho -->
    <div class="position-fixed" style="bottom: 80px; right: 20px; z-index: 1050;">
        <a href="carrinho.php" class="btn btn-outline-primary shadow">Ver Carrinho</a>
    </div>

    <!-- Lista de pratos -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        <?php foreach ($produtos as $prato) { ?>
            <div class="col">

                <div class="card h-100 shadow-sm">
                    <a href="detalhe_prato.php?id=<?= $prato['id'] ?>" class="text-decoration-none text-dark">
                        <img src="uploads/<?= isset($prato['imagem']) ? htmlspecialchars($prato['imagem']) : 'sem-imagem.jpg'; ?>"
                            class="card-img-top rounded-top"
                            style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($prato['nome']) ?></h5>
                        </div>
                    </a>

                    <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                        <span class="fw-bold fs-5 mb-0">R$ <?= number_format($prato['preco'], 2, ',', '.') ?></span>
                        <form action="carrinho_adicionar.php" method="post" class="mb-0">
                            <input type="hidden" name="id" value="<?= $prato['id'] ?>">
                            <button type="submit" class="btn btn-primary btn-sm px-3">Adicionar</button>
                        </form>
                    </div>

                </div>
            </div>

        <?php } ?>
    </div>
</div>

</html>

<?php require __DIR__ . '/includes/footer.php'; ?>