<!-- READ -->
<?php
include '../includes/conexao.php';
include '../includes/header.php';

$pratos = $pdo->query("SELECT * FROM pratos")->fetchAll();
?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Imagem</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pratos as $prato): ?>
        <tr>
            <td><?= $prato['id'] ?></td>
            <td><img src="../assets/images/<?= $prato['imagem'] ?>" width="50"></td>
            <td><?= $prato['nome'] ?></td>
            <td>R$ <?= number_format($prato['preco'], 2, ',', '.') ?></td>
            <td>
                <a href="editar.php?id=<?= $prato['id'] ?>">Editar</a>
                <a href="excluir.php?id=<?= $prato['id'] ?>" onclick="return confirm('Tem certeza?')">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="cadastrar.php">Novo Prato</a>

<?php include '../includes/footer.php'; ?>