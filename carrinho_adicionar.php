<?php
session_start();
require_once __DIR__ . '/includes/Database.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['id'])) {
    header('Location: index.php');
    exit;
}

$prato_id = (int) $_POST['id'];

$db = new Database();
$stmt = $db->query("SELECT id, nome, preco FROM pratos WHERE id = ?", [$prato_id]);
$prato = $stmt->fetch();

if (!$prato) {
    $_SESSION['mensagem'] = ['tipo' => 'danger', 'texto' => 'Prato não encontrado.'];
    header('Location: index.php');
    exit;
}

// Pega o carrinho da sessão ou cria um novo
$carrinho = $_SESSION['carrinho'] ?? [];

// Verifica se o prato já está no carrinho
$index = null;
foreach ($carrinho as $key => $item) {
    if ($item['id'] == $prato_id) {
        $index = $key;
        break;
    }
}

if ($index !== null) {
    // Se já existe, aumenta a quantidade
    $carrinho[$index]['quantidade'] += 1;
} else {
    // Senão, adiciona novo item
    $carrinho[] = [
        'id' => $prato['id'],
        'nome' => $prato['nome'],
        'preco' => $prato['preco'],
        'quantidade' => 1
    ];
}

$_SESSION['carrinho'] = $carrinho;

$_SESSION['mensagem'] = ['tipo' => 'success', 'texto' => 'Prato adicionado ao carrinho.'];

// Redireciona para cardápio ou carrinho (pode trocar)
header('Location: index.php');
exit;