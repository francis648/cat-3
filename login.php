<?php
require_once __DIR__ . '/functions.php';
require_guest();

$error = '';
$email = '';
if (is_post()) {
    verify_csrf();
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $error = 'Enter a valid email and password.';
    } else {
        $statement = db()->prepare('SELECT id, username, email, password_hash FROM users WHERE email = ?');
        $statement->execute([$email]);
        $user = $statement->fetch();
        if (!$user || !password_verify($password, $user['password_hash'])) {
            $error = 'The email or password was not recognised.';
        } else {
            login_user($user);
            redirect('dashboard.php');
        }
    }
}

$title = 'Sign in';
require __DIR__ . '/header.php';
?>
<section class="auth-layout">
    <div class="auth-copy"><p class="eyebrow">Private operations</p><h1>Keep every conversation in view.</h1><p class="lede">A focused workspace for receiving, reviewing, and responding to contact submissions.</p></div>
    <div class="auth-panel">
        <h2>Welcome back</h2><p class="lede">Sign in to your workspace.</p>
        <?php if (isset($_GET['registered'])): ?><div class="alert success">Account created. You can sign in now.</div><?php endif; ?>
        <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
        <form method="post" novalidate>
            <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
            <div class="form-row"><label for="email">Email</label><input id="email" type="email" name="email" value="<?= e($email) ?>" maxlength="150" required></div>
            <div class="form-row"><label for="password">Password</label><input id="password" type="password" name="password" required></div>
            <button class="button" type="submit">Sign in</button>
        </form>
        <p class="form-help">New here? <a href="register.php">Create an account</a></p>
    </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
