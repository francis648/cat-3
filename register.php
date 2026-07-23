<?php
require_once __DIR__ . '/functions.php';
require_guest();

$errors = [];
$username = '';
$email = '';

if (is_post()) {
    verify_csrf();
    $username = trim((string) ($_POST['username'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $confirmation = (string) ($_POST['password_confirmation'] ?? '');

    if ($error = validate_text($username, 'Username', 3, 50)) $errors[] = $error;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150) $errors[] = 'Enter a valid email address.';
    if (mb_strlen($password) < 8 || mb_strlen($password) > 72) $errors[] = 'Password must be between 8 and 72 characters.';
    if ($password !== $confirmation) $errors[] = 'Passwords do not match.';

    if (!$errors) {
        $check = db()->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
        $check->execute([$username, $email]);
        if ($check->fetch()) {
            $errors[] = 'That username or email is already registered.';
        } else {
            $insert = db()->prepare('INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)');
            $insert->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT)]);
            redirect('login.php?registered=1');
        }
    }
}

$title = 'Create account';
require __DIR__ . '/header.php';
?>
<section class="auth-layout">
    <div class="auth-copy"><p class="eyebrow">New workspace</p><h1>Make the signal easier to follow.</h1><p class="lede">Create a private account for managing your contact conversations with clarity and control.</p></div>
    <div class="auth-panel">
        <h2>Create account</h2><p class="lede">All fields are required.</p>
        <?php if ($errors): ?><div class="alert"><?= e(implode(' ', $errors)) ?></div><?php endif; ?>
        <form method="post" novalidate>
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
            <div class="form-row"><label for="username">Username</label><input id="username" name="username" value="<?= e($username) ?>" minlength="3" maxlength="50" required></div>
            <div class="form-row"><label for="email">Email</label><input id="email" type="email" name="email" value="<?= e($email) ?>" maxlength="150" required></div>
            <div class="form-row"><label for="password">Password</label><input id="password" type="password" name="password" minlength="8" maxlength="72" required></div>
            <div class="form-row"><label for="password_confirmation">Confirm password</label><input id="password_confirmation" type="password" name="password_confirmation" minlength="8" maxlength="72" required></div>
            <button class="button" type="submit">Create account</button>
        </form>
        <p class="form-help">Already registered? <a href="login.php">Sign in</a></p>
    </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
