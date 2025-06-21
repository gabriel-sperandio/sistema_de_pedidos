<nav class="menu-navegacao">
    <ul class="menu-lista">
        <!-- Item Cardápio (agora index.php) -->
        <li class="menu-item <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'ativo' : '' ?>">
            <a href="index.php" class="menu-link">
                <span class="menu-icone">
                    <i class="fas fa-utensils"></i>
                </span>
                <span class="menu-texto">Cardápio</span>
            </a>
        </li>
        
        <!-- Item Ofertas -->
        <li class="menu-item <?= basename($_SERVER['PHP_SELF']) === 'ofertas.php' ? 'ativo' : '' ?>">
            <a href="ofertas.php" class="menu-link">
                <span class="menu-icone">
                    <i class="fas fa-tag"></i>
                </span>
                <span class="menu-texto">Ofertas</span>
            </a>
        </li>
        
        <!-- Item Perfil -->
        <li class="menu-item <?= basename($_SERVER['PHP_SELF']) === 'perfil.php' ? 'ativo' : '' ?>">
            <a href="perfil.php" class="menu-link">
                <span class="menu-icone">
                    <i class="fas fa-user"></i>
                </span>
                <span class="menu-texto">Perfil</span>
            </a>
        </li>
    </ul>
</nav>

<script src="assets/js/menu.js"></script>
<script src="assets/js/cardapio.js"></script>
</body>
</html>