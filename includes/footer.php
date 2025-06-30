<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu Site</title>
    <style>
        body {
            margin: 0;
            padding: 0 0 60px 0;
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
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            height: 50px;
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
            color: #0066cc;
        }

        .nav div:not(.active):hover i,
        .nav div:not(.active):hover {
            color: #333;
        }
    </style>

    <!-- Ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="nav">
        <div id="menu-item-cardapio">
            <a href="index.php">
                <i class="fas fa-utensils"></i><span>Cardápio</span>
            </a>
        </div>

        <div id="menu-item-perfil">
            <a href="perfil.php">
                <i class="fas fa-user"></i><span>Perfil</span>
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Função para destacar o item ativo no footer
        function highlightActiveMenuItem() {
            // Remove a classe active de todos os itens
            document.querySelectorAll('.nav div').forEach(item => {
                item.classList.remove('active');
            });
            
            // Obtém o caminho atual (pathname) da URL
            const currentPath = window.location.pathname;
            
            // Determina qual item deve receber a classe active
            if (currentPath.includes('perfil.php')) {
                document.getElementById('menu-item-perfil').classList.add('active');
            } else {
                // Padrão: Cardápio (index.php ou qualquer outra página)
                document.getElementById('menu-item-cardapio').classList.add('active');
            }
        }
        
        // Executa a função quando a página carrega
        document.addEventListener('DOMContentLoaded', highlightActiveMenuItem);
    </script>
</body>
</html>