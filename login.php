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
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .h2 {
            font-family: 'Brush Script MT', cursive;
            color: #7d5a8a;
        }

    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="login-container">
            <h2 class="text-center mb-4">Logi</h2>

            <?php if ($erro): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>
        </div>
    </div>
</body>

</html>