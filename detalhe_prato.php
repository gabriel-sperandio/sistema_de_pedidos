<?php
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/app/controllers/PratoController.php';

session_start();

if (empty($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: cardapio.php');
    exit;
}

$pratoController = new PratoController();
$prato = $pratoController->buscarPratoPorId((int)$_GET['id']);

if (!$prato) {
    echo "<p>Prato não encontrado.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?= htmlspecialchars($prato['nome']) ?> - Detalhes</title>
<style>
    body {
        background-color: #d7e9d0; /* verde pastel suave */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        min-height: 100vh;
        align-items: flex-start;
        padding-top: 40px;
    }
    .container {
        background: white;
        max-width: 600px;
        width: 90%;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        padding: 30px 40px;
        box-sizing: border-box;
        text-align: center;
    }
    h2 {
        margin-bottom: 20px;
        color: #2f4f2f;
    }
    img {
        max-width: 100%;
        max-height: 320px;
        border-radius: 10px;
        object-fit: cover;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        margin-bottom: 25px;
    }
    p {
        color: #405940;
        font-size: 1.1em;
        line-height: 1.5;
        margin: 12px 0;
    }
    form button {
        background-color: #4caf50;
        border: none;
        color: white;
        padding: 12px 35px;
        font-size: 1.15em;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 30px;
    }
    form button:hover {
        background-color: #3a8a34;
    }
    .back-link {
        display: inline-block;
        margin-bottom: 25px;
        color: #4caf50;
        font-weight: 600;
        text-decoration: none;
        font-size: 1em;
        transition: color 0.3s ease;
    }
    .back-link:hover {
        color: #357a29;
        text-decoration: underline;
    }
</style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-link">&larr; Voltar ao Cardápio</a>
        <h2><?= htmlspecialchars($prato['nome']) ?></h2>
        <img src="uploads/<?= htmlspecialchars($prato['imagem'] ?: 'sem-imagem.jpg') ?>" alt="<?= htmlspecialchars($prato['nome']) ?>">
        <p><strong>Ingredientes:</strong><br><?= nl2br(htmlspecialchars($prato['ingredientes'])) ?></p>
        <p><strong>Tempo de preparo:</strong> <?= (int)$prato['tempo_preparo'] ?> minutos</p>
        <p><strong>Preço:</strong> R$ <?= number_format($prato['preco'], 2, ',', '.') ?></p>

        <form action="carrinho_adicionar.php" method="post">
            <input type="hidden" name="id" value="<?= $prato['id'] ?>">
            <button type="submit">Adicionar ao Carrinho</button>
        </form>
    </div>
</body>
</html>
