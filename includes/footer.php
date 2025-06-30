<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu Site</title>
    <style>
        /* Adicione margem no body para o conteúdo não ficar escondido atrás do footer */
        body {
            margin: 0;
            padding: 0 0 60px 0; /* 60px é a altura aproximada do footer */
            min-height: 100vh;
            box-sizing: border-box;
        }

        .nav {
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            border-top: 1px solid #ccc;
            background-color: #fff;
            position: fixed;
            width: 100%;
            bottom: 0;
            left: 0;
            z-index: 1000;
            box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
            height: 50px; /* Altura fixa para consistência */
        }

        .nav i {
            font-size: 20px;
            color: #666;
            transition: color 0.3s;
        }

        .nav div {
            text-align: center;
            font-size: 12px;
            color: #666;
            padding: 5px;
            transition: all 0.3s;
        }

        .nav a {
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .nav div.active i,
        .nav div.active {
            color: #0066cc; /* Cor mais vibrante para o item ativo */
        }

        .nav div:not(.active):hover i,
        .nav div:not(.active):hover {
            color: #333;
        }
    </style>
    <!-- Adicione o link para o Font Awesome se ainda não estiver incluído -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <!-- Seu conteúdo principal aqui -->
    <div style="height: 1500px;"> <!-- Exemplo de conteúdo longo - remova na implementação real -->
        Conteúdo da sua página que vai rolar...
    </div>

    <div class="nav">
        <div class="active">
            <a href="cardapio.php">
                <i class="fas fa-utensils"></i><span>Cardápio</span>
            </a>
        </div>

        <div>
            <a href="oferta.php">
                <i class="fas fa-star"></i><span>Ofertas</span>
            </a>
        </div>

        <div>
            <a href="perfil.php">
                <i class="fas fa-user"></i><span>Perfil</span>
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/app.js"></script>
</body>
</html>