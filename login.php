<?php
session_start();
require_once __DIR__ . '/includes/Database.php';

// Redireciona se já estiver logado
if (!empty($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

$erro = null;

// Processar login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha']; // Não filtre senhas!

    try {
        $db = new Database();
        $stmt = $db->query("SELECT id, nome, senha, is_admin FROM usuarios WHERE email = ?", [$email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Login bem-sucedido
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nome' => $usuario['nome'],
                'is_admin' => $usuario['is_admin']
            ];

            // Atualiza último login (opcional)
            $db->query("UPDATE usuarios SET ultimo_login = NOW() WHERE id = ?", [$usuario['id']]);

            header('Location: /');
            exit;
        } else {
            $erro = "Credenciais inválidas!";
        }
    } catch (Exception $e) {
        error_log("Erro no login: " . $e->getMessage());
        $erro = "Erro interno. Tente novamente mais tarde.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">

</head>

<body>
    <div class="container">
        <h1 class="logo">Inhamy</h1>
        <p>Bem-vindo de volta!</p>

        <?php if ($erro): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form id="loginForm" action="login.php" method="POST">
            <label for="email">Login</label>
            <input type="email" name="email" placeholder="E-mail" required>

            <input type="text" name="senha" placeholder="Senha" required>

            <a href="#" class="link">Esqueceu o código?</a>


            <button type="submit">Entrar</button>

        </form>
    </div>
    
</body>

</html>