<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/includes/Database.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$carrinho = $_SESSION['carrinho'] ?? [];
if (empty($carrinho)) {
    $_SESSION['mensagem'] = ['tipo' => 'warning', 'texto' => 'Seu carrinho está vazio.'];
    header('Location: carrinho.php');
    exit;
}

// Dados do formulário
$usuario_id = $_SESSION['usuario']['id'];
$forma_pagamento = $_POST['forma_pagamento'] ?? '';
$endereco = trim($_POST['endereco'] ?? '');
$observacoes = trim($_POST['observacoes'] ?? '');
$total = 0;

// Calcula total novamente para garantir
foreach ($carrinho as $item) {
    $total += $item['preco'] * $item['quantidade'];
}

$db = new Database();

try {
    // Inicia transação
    $db->query("START TRANSACTION");

    // Insere pedido
    $db->query(
        "INSERT INTO pedidos (usuario_id, data_pedido, status, total, observacoes, forma_pagamento, endereco_entrega)
         VALUES (?, NOW(), 'pendente', ?, ?, ?, ?)",
        [$usuario_id, $total, $observacoes, $forma_pagamento, $endereco]
    );

    // Recupera o ID do novo pedido
    $pedido_id = $db->query("SELECT LAST_INSERT_ID() AS id")->fetch()['id'];

    // Insere cada item do carrinho como item do pedido
    foreach ($carrinho as $item) {
        $db->query(
            "INSERT INTO itens_pedido (pedido_id, prato_id, quantidade, preco_unitario, observacoes)
             VALUES (?, ?, ?, ?, '')",
            [$pedido_id, $item['id'], $item['quantidade'], $item['preco']]
        );
    }

    // Confirma a transação
    $db->query("COMMIT");

    // Limpa o carrinho
    unset($_SESSION['carrinho']);

    $_SESSION['mensagem'] = ['tipo' => 'success', 'texto' => 'Pedido realizado com sucesso!'];
    header('Location: perfil.php');
    exit;
} catch (Exception $e) {
    $db->query("ROLLBACK");
    $_SESSION['mensagem'] = ['tipo' => 'danger', 'texto' => 'Erro ao finalizar pedido: ' . $e->getMessage()];
    header('Location: carrinho.php');
    exit;
}