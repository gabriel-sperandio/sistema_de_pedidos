<?php
session_start();

function fazerLogin(string $email, string $senha): bool {
    try {
        $db = new Database();
        $stmt = $db->query(
            "SELECT id, nome, senha, is_admin FROM usuarios WHERE email = ? LIMIT 1",
            [$email]
        );
        
        $usuario = $stmt->fetch();
        
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Regenera o ID da sessão para prevenir fixation
            session_regenerate_id(true);
            
            $_SESSION['usuario'] = [
                'id' => (int)$usuario['id'],
                'nome' => htmlspecialchars($usuario['nome']),
                'is_admin' => (bool)$usuario['is_admin']
            ];
            return true;
        }
        return false;
    } catch (Exception $e) {
        error_log("Erro no login: " . $e->getMessage());
        return false;
    }
}

function usuarioEstaLogado(): bool {
    return !empty($_SESSION['usuario']['id']);
}

function isAdmin(): bool {
    return usuarioEstaLogado() && !empty($_SESSION['usuario']['is_admin']);
}

function protegerAdmin(): void {
    if (!isAdmin()) {
        // Guarda a URL atual para redirecionar após login
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header('Location: /login.php');
        exit;
    }
}

function logout(): void {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}