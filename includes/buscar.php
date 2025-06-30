<div class="search-minimal">
    <form action="buscar_unificado.php" method="get" class="search-form">
        <input type="hidden" name="tipo" id="search-type" value="posts">
        <div class="search-wrapper">
            <input type="text" 
                   name="q" 
                   placeholder="O que procura?"
                   class="search-input"
                   autocomplete="off">
            <button type="submit" class="search-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
        </div>
    </form>
    <div class="search-suggestions"></div>
</div>

<link rel="stylesheet" href="assets/css/search-minimal.css">
<script src="assets/js/search-minimal.js" defer></script>