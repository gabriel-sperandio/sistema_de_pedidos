<?php
include 'config.php';
include 'functions.php';

header('Content-Type: application/json');

$query = isset($_GET['q']) ? trim($_GET['q']) : '';
$isLiveBusca = isset($_GET['live']);

if (empty($query)) {
    echo json_encode([]);
    exit;
}

try {
    $pdo = getPDO();

    // Consulta posts e usuários relacionados com o termo de busca
    $stmt = $pdo->prepare("
        SELECT p.*, u.username, u.name 
        FROM posts p
        JOIN users u ON p.user_id = u.id
        WHERE p.content LIKE :query OR u.username LIKE :query OR u.name LIKE :query
        ORDER BY p.created_at DESC
        LIMIT 10
    ");
    
    $searchTerm = "%$query%";
    $stmt->bindParam(':query', $searchTerm, PDO::PARAM_STR);
    $stmt->execute();

    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($isLiveBusca) {
        // Retorna JSON para busca em tempo real
        echo json_encode($resultados);
    } else {
        // Página completa de resultados
        include 'header.php';

        echo '<div class="buscar-resultados-page">';
        echo '<h1>Resultados para: "'.htmlspecialchars($query).'"</h1>';

        if (count($resultados) > 0) {
            foreach ($resultados as $post) {
                include 'post-template.php';
            }
        } else {
            echo '<p>Nenhum resultado encontrado.</p>';
        }

        echo '</div>';

        include 'footer.php';
    }

} catch (PDOException $e) {
    // Tratamento de erro para ambos os modos
    if ($isLiveBusca) {
        echo json_encode(['error' => 'Erro na busca']);
    } else {
        echo 'Erro na busca: ' . $e->getMessage();
    }
}
?>