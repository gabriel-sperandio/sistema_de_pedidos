<?php
function filtrarInput($dado) {
    $dado = trim($dado);
    $dado = stripslashes($dado);
    $dado = htmlspecialchars($dado);
    return $dado;
}

function verificarLogin() {
    if (empty($_SESSION['usuario'])) {
        header('Location: /admin/login.php');
        exit;
    }
}