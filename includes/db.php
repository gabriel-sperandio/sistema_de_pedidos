<?php
$host = 'localhost';
$user = 'root';
$password = 'Biel/20041309';
$database = 'inhamy';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Configurações adicionais
$conn->set_charset("utf8mb4");