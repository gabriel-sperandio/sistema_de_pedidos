<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $key = $_POST['key'] ?? null;
    $acao = $_POST['acao'] ?? null;

    if ($key !== null && isset($_SESSION['carrinho'][$key])) {
        switch ($acao) {
            case 'aumentar':
                $_SESSION['carrinho'][$key]['quantidade']++;
                break;
            case 'diminuir':
                if ($_SESSION['carrinho'][$key]['quantidade'] > 1) {
                    $_SESSION['carrinho'][$key]['quantidade']--;
                }
                break;
            case 'remover':
                unset($_SESSION['carrinho'][$key]);
                // Reindexa array para evitar problemas
                $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
                break;
        }
    }
}

header('Location: carrinho.php');
exit;