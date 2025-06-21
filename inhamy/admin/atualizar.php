<!-- UPDATE -->
<?php
include '../includes/conexao.php';
include '../includes/header.php';

$id = $_GET['id'];
$prato = $pdo->query("SELECT * FROM pratos WHERE id = $id")->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria = $_POST['categoria'];
    
    // Se nova imagem foi enviada
    if ($_FILES['imagem']['size'] > 0) {
        $target_dir = "../assets/images/";
        $target_file = $target_dir . basename($_FILES["imagem"]["name"]);
        move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file);
        $imagem = $_FILES["imagem"]["name"];
    } else {
        $imagem = $prato['imagem'];
    }

    $stmt = $pdo->prepare("UPDATE pratos SET nome = ?, descricao = ?, preco = ?, imagem = ?, categoria = ? WHERE id = ?");
    $stmt->execute([$nome, $descricao, $preco, $imagem, $categoria, $id]);
    
    header("Location: listar.php");
    exit;
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="nome" value="<?= $prato['nome'] ?>" required>
    <textarea name="descricao"><?= $prato['descricao'] ?></textarea>
    <input type="number" step="0.01" name="preco" value="<?= $prato['preco'] ?>" required>
    <select name="categoria" required>
        <option value="pizzas" <?= $prato['categoria'] == 'pizzas' ? 'selected' : '' ?>>Pizzas</option>
        <option value="lanches" <?= $prato['categoria'] == 'lanches' ? 'selected' : '' ?>>Lanches</option>
        <option value="saladas" <?= $prato['categoria'] == 'saladas' ? 'selected' : '' ?>>Saladas</option>
    </select>
    <img src="../assets/images/<?= $prato['imagem'] ?>" width="100">
    <input type="file" name="imagem" accept="image/*">
    <button type="submit">Atualizar</button>
</form>

<?php include '../includes/footer.php'; ?>