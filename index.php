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

// Saúda o usuário
if (isset($_SESSION['usuario'])) {
    echo '<div class="text-end p-2">';
    echo 'Olá, ' . htmlspecialchars($_SESSION['usuario']['nome']);
    if ($isAdmin) {
        echo '<span class="badge bg-secondary">Admin</span>';
    }
    echo ' | <a href="logout.php">Sair</a>';
    echo '</div>';
}

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
$pratosFiltrados = array_filter($produtos, function($p) {
    return !empty($p['favorito']);
});
$pratosFavoritos = array_slice($pratosFiltrados, 0, 3);
?>

<div class="container mt-4">
    <!-- Carrossel de favoritos -->
    <?php include __DIR__ . '/app/views/carrosselPratos.php'; ?>

    <!-- Botão Carrinho -->
    <div class="text-end mb-3">
        <a href="carrinho.php" class="btn btn-outline-primary">Ver Carrinho</a>
    </div>

    <!-- Lista de pratos -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        <?php foreach ($produtos as $prato) { ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="uploads/<?php echo isset($prato['imagem']) ? htmlspecialchars($prato['imagem']) : 'sem-imagem.jpg'; ?>" 
                         class="card-img-top" 
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo htmlspecialchars($prato['nome']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($prato['ingredientes']); ?></p>
                        <p class="mt-auto fw-bold">R$ <?php echo number_format($prato['preco'], 2, ',', '.'); ?></p>
                        <form action="carrinho_adicionar.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $prato['id']; ?>">
                            <button type="submit" class="btn btn-primary w-100">Adicionar ao Carrinho</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Formulário de Cadastro (admin) -->
    <?php if ($isAdmin) { ?>
        <a href="?action=novo" class="btn btn-success mb-3">+ Novo Prato</a>
        
        <?php if (isset($_GET['action']) && ($_GET['action'] == 'novo' || isset($_GET['editar']))) { ?>
            <div class="card mb-4">
                <div class="card-body">
                    <?php include __DIR__ . '/app/views/pratos/form.php'; ?>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>