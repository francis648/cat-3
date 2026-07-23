<?php
require_once __DIR__ . '/functions.php';
require_login();

$user = current_user();
$counts = db()->query('SELECT COUNT(*) AS total, MAX(created_at) AS latest FROM submissions')->fetch();
$title = 'Dashboard';
require __DIR__ . '/header.php';
?>
<section class="dashboard-head"><div><p class="eyebrow">Workspace overview</p><h1>Good to see you, <?= e($user['username'] ?? $_SESSION['username']) ?>.</h1><p class="lede">Your contact desk is ready. Keep an eye on new messages and make every reply count.</p></div><a class="button" href="contact.php">New submission</a></section>
<section class="stats-grid"><div class="stat"><span class="stat-label">Messages received</span><span class="stat-value"><?= e((string) ($counts['total'] ?? 0)) ?></span></div><div class="stat"><span class="stat-label">Latest activity</span><span class="stat-value"><?= e($counts['latest'] ? date('M j', strtotime($counts['latest'])) : 'None') ?></span></div><div class="stat"><span class="stat-label">Account status</span><span class="stat-value">Active</span></div></section>
<section class="feature-grid"><article class="feature"><div><p class="eyebrow">01 / Profile</p><h3>Your account, clearly presented.</h3><p>Review your saved identity details and account creation date.</p></div><a class="text-link" href="profile.php">View profile -></a></article><article class="feature"><div><p class="eyebrow">02 / Directory</p><h3>Every message in one place.</h3><p>Browse the contact history with names, subjects, and timestamps.</p></div><a class="text-link" href="submissions.php">Open directory -></a></article><article class="feature"><div><p class="eyebrow">03 / Information</p><h3>Understand the system.</h3><p>See the controls and practices that keep this workspace dependable.</p></div><a class="text-link" href="information.php">Read the hub -></a></article><article class="feature"><div><p class="eyebrow">04 / Contact</p><h3>Start a new record.</h3><p>Capture a message with server-side validation and secure storage.</p></div><a class="text-link" href="contact.php">Open form -></a></article></section>
<?php require __DIR__ . '/footer.php'; ?>
