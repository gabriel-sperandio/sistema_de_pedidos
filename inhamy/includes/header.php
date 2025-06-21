<!DOCTYPE html>
<html>
<head>
    <title>Seu Site</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/buscar.css">
    <link rel="stylesheet" href="assets/css/cardapio.css">
    <!-- Seus outros meta tags e links -->
</head>
<body>

<!-- Container principal da barra de busca -->
<div class="buscar-container">
    <!-- Formulário de busca que envia para buscar.php via GET -->
    <form action="buscar.php" method="get" class="buscar-form" id="buscarForm">
        <input type="text" name="q" placeholder="Pesquisar posts..." class="buscar-input" id="buscarInput">
        <button type="submit" class="buscar-button">
            <i class="fas fa-search"></i>
        </button>
        <div class="buscar-resultados" id="buscarResultados"></div>
    </form>
</div>
