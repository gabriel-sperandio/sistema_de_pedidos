<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <div class="buscar-container">
        <form action="buscar.php" method="get" class="buscar-form">
            <input type="text" name="q" placeholder="Buscar pratos..." class="buscar-input">
            <button type="submit" class="buscar-button">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>
    <main class="container-fluid">