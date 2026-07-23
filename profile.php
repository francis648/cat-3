<?php
require_once __DIR__ . '/functions.php';
require_login();

$user = current_user();
$title = 'Profile';
require __DIR__ . '/header.php';
?>
<section class="page-heading"><p class="eyebrow">Account identity</p><h1>Your profile.</h1><p class="lede">These details are pulled directly from your account record.</p></section>
<div class="profile-panel"><dl class="profile-list"><div><dt>Username</dt><dd><?= e($user['username'] ?? '') ?></dd></div><div><dt>Email address</dt><dd><?= e($user['email'] ?? '') ?></dd></div><div><dt>Member since</dt><dd><?= e(isset($user['created_at']) ? date('F j, Y', strtotime($user['created_at'])) : '') ?></dd></div><div><dt>Account ID</dt><dd>#<?= e((string) ($user['id'] ?? '')) ?></dd></div></dl></div>
<?php require __DIR__ . '/footer.php'; ?>
