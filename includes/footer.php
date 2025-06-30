<!DOCTYPE html>
<html lang="pt-BR">

<style>
    .nav {
        display: flex;
        justify-content: space-around;
        padding: 15px 0;
        border-top: 1px solid #ccc;
        background-color: #fff;
        position: fixed;
        width: 100%;
        bottom: 0;
        left: 0;
    }

    .nav i {
        font-size: 20px;
        color: #333;
    }

    .nav div {
        text-align: center;
        font-size: 12px;
        color: #333;
    }

    .nav a {
        text-decoration: none;
        color: inherit;
    }

    .nav div.active i,
    .nav div.active {
        color: #000;
    }
</style>

<body>
    <div class="nav">

        <div class="active">
            <a href="cardapio.php">
                <i class="fas fa-utensils"></i><br>Cardápio
            </a>
        </div>


        <div>
            <a href="oferta.php">
                <i class="fas fa-star"></i><br>Ofertas
            </a>
        </div>


        <div>
            <a href="perfil.php">
                <i class="fas fa-user"></i><br>Perfil
            </a>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/app.js"></script>
</body>

</html>