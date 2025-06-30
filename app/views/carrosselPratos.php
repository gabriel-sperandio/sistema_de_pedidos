<div id="carrosselPremium" class="container-fluid mb-5">
    <div class="row g-0 bg-white rounded-4 shadow-lg overflow-hidden">
        <!-- Coluna da Imagem -->
        <div class="col-lg-6">
            <div id="carrosselImagens" class="carousel slide h-100" data-bs-ride="carousel" data-bs-interval="3500">
                <div class="carousel-inner h-100">
                    <?php foreach ($pratosFavoritos as $index => $prato): ?>
                    <div class="carousel-item h-100 <?= $index === 0 ? 'active' : '' ?>" data-bs-slide-to="<?= $index ?>">
                        <img src="uploads/<?= htmlspecialchars($prato['imagem'] ?? 'default.jpg') ?>" 
                             class="d-block w-100 h-100 object-fit-cover"
                             alt="<?= htmlspecialchars($prato['nome']) ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
                <!-- Controles do Carrossel -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carrosselImagens" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carrosselImagens" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
        
        <!-- Coluna da Descrição -->
        <div class="col-lg-6 d-flex align-items-center p-5">
            <div class="w-100">
                <?php foreach ($pratosFavoritos as $index => $prato): ?>
                <div class="descricao-prato <?= $index === 0 ? 'active' : 'd-none' ?>" 
                     data-index="<?= $index ?>">
                     <h2><?= htmlspecialchars($prato['nome']) ?></h2>
                     <p>R$ <?= number_format($prato['preco'], 2, ',', '.') ?></p>
                     <!-- Outros detalhes do prato -->
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Correção da sincronização
document.addEventListener('DOMContentLoaded', function() {
    const carrossel = document.getElementById('carrosselImagens');
    const descricoes = document.querySelectorAll('.descricao-prato');
    
    // Atualiza descrição quando o slide muda
    carrossel.addEventListener('slid.bs.carousel', function(event) {
        const activeIndex = [...event.currentTarget.querySelectorAll('.carousel-item')].indexOf(event.currentTarget.querySelector('.active'));
        
        descricoes.forEach(desc => {
            desc.classList.add('d-none');
            desc.classList.remove('active');
        });
        
        descricoes[activeIndex].classList.remove('d-none');
        descricoes[activeIndex].classList.add('active');
    });
    
    // Controles manuais
    document.querySelectorAll('.descricao-prato').forEach(desc => {
        desc.addEventListener('click', function() {
            const index = this.getAttribute('data-index');
            const carousel = bootstrap.Carousel.getInstance(carrossel);
            carousel.to(index);
        });
    });
});
</script>