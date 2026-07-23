<?php
require_once __DIR__ . '/functions.php';
require_login();

$errors = [];
$success = false;
$name = '';
$email = '';
$subject = '';
$message = '';

if (is_post()) {
    verify_csrf();
    $name = trim((string) ($_POST['name'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $subject = trim((string) ($_POST['subject'] ?? ''));
    $message = trim((string) ($_POST['message'] ?? ''));
    if ($error = validate_text($name, 'Name', 2, 100)) $errors[] = $error;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150) $errors[] = 'Enter a valid email address.';
    if ($error = validate_text($subject, 'Subject', 3, 160)) $errors[] = $error;
    if ($error = validate_text($message, 'Message', 10, 5000)) $errors[] = $error;

    if (!$errors) {
        $statement = db()->prepare('INSERT INTO submissions (user_id, name, email, subject, message) VALUES (?, ?, ?, ?, ?)');
        $statement->execute([(int) $_SESSION['user_id'], $name, $email, $subject, $message]);
        $success = true;
        $name = $email = $subject = $message = '';
    }
}

$title = 'Contact us';
require __DIR__ . '/header.php';
?>
<section class="page-heading"><p class="eyebrow">New record</p><h1>Send a clear message.</h1><p class="lede">Every submission is checked before it enters the directory.</p></section>
<div class="form-panel">
    <?php if ($success): ?><div class="alert success">Your message was saved securely. It is now visible in the submissions directory.</div><?php endif; ?>
    <?php if ($errors): ?><div class="alert"><?= e(implode(' ', $errors)) ?></div><?php endif; ?>
    <form method="post" novalidate>
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
        <div class="split"><div class="form-row"><label for="name">Name</label><input id="name" name="name" value="<?= e($name) ?>" maxlength="100" required></div><div class="form-row"><label for="email">Email</label><input id="email" type="email" name="email" value="<?= e($email) ?>" maxlength="150" required></div></div>
        <div class="form-row"><label for="subject">Subject</label><input id="subject" name="subject" value="<?= e($subject) ?>" maxlength="160" required></div>
        <div class="form-row"><label for="message">Message</label><textarea id="message" name="message" maxlength="5000" required><?= e($message) ?></textarea></div>
        <button class="button button-coral" type="submit">Save submission</button>
    </form>
</div>
<?php require __DIR__ . '/footer.php'; ?>
