<!-- CREATE  -->
<?php 
include '../includes/conexao.php';
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria = $_POST['categoria'];
    
    // Upload de imagem
    $imagem = '';
    if (isset($_FILES['imagem'])) {
        $target_dir = "../assets/images/";
        $target_file = $target_dir . basename($_FILES["imagem"]["name"]);
        move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file);
        $imagem = $_FILES["imagem"]["name"];
    }

    // Insere prato no banco
    $stmt = $pdo->prepare("INSERT INTO pratos (nome, descricao, preco, imagem, categoria) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nome, $descricao, $preco, $imagem, $categoria]);
    
    // Redireciona após cadastro
    header("Location: listar.php");
    exit;
}
?>

<!-- Formulário de cadastro de prato -->
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="nome" placeholder="Nome do Prato" required>
    <textarea name="descricao" placeholder="Descrição"></textarea>
    <input type="number" step="0.01" name="preco" placeholder="Preço" required>
    <select name="categoria" required>
        <option value="pizzas">Pizzas</option>
        <option value="lanches">Lanches</option>
        <option value="saladas">Saladas</option>
    </select>
    <input type="file" name="imagem" accept="image/*">
    <button type="submit">Cadastrar</button>
</form>

<?php include '../includes/footer.php'; ?>
