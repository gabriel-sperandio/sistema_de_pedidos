<?php
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/app/models/PratoModel.php';

$query = $_GET['q'] ?? '';
$resultados = [];

if (!empty($query)) {
    $db = new Database();
    $sql = "SELECT * FROM pratos WHERE nome LIKE ? OR ingredientes LIKE ?";
    $stmt = $db->query($sql, ["%$query%", "%$query%"]);
    $resultados = $stmt->fetchAll();
}

require __DIR__ . '/includes/header.php';
?>

<div class="container mt-4">
    <h2>Resultados para: <?= htmlspecialchars($query) ?></h2>

    <?php if (empty($resultados)) : ?>
        <p>Nenhum prato encontrado.</p>
    <?php else : ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($resultados as $prato) : ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="uploads/<?= htmlspecialchars($prato['imagem']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($prato['nome']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($prato['ingredientes']) ?></p>
                            <p class="fw-bold">R$ <?= number_format($prato['preco'], 2, ',', '.') ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
