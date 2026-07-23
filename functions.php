<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}

function is_post(): bool
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verify_csrf(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(419);
        exit('Invalid form token. Please go back and try again.');
    }
}

function login_user(array $user): void
{
    session_regenerate_id(true);
    $_SESSION['user_id'] = (int) $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function logout_user(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'] ?? '', (bool) $params['secure'], (bool) $params['httponly']);
    }
    session_destroy();
}

function require_guest(): void
{
    if (!empty($_SESSION['user_id'])) {
        redirect('dashboard.php');
    }
}

function require_login(): void
{
    if (empty($_SESSION['user_id'])) {
        redirect('login.php');
    }
}

function current_user(): ?array
{
    if (empty($_SESSION['user_id'])) {
        return null;
    }

    $statement = db()->prepare('SELECT id, username, email, created_at FROM users WHERE id = ?');
    $statement->execute([(int) $_SESSION['user_id']]);
    $user = $statement->fetch();

    return $user ?: null;
}

function validate_text(string $value, string $label, int $min, int $max): ?string
{
    $value = trim($value);
    $length = mb_strlen($value);
    if ($length < $min || $length > $max) {
        return $label . " must be between {$min} and {$max} characters.";
    }

    return null;
}

function page_title(string $title): string
{
    return $title . ' | ' . APP_NAME;
}
