<!-- DELETE -->
<?php
include '../includes/conexao.php';

$id = $_GET['id'];
$pdo->exec("DELETE FROM pratos WHERE id_prato = $id_prato");

header("Location: listar.php");
exit;
?>