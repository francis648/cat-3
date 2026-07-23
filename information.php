<?php
require_once __DIR__ . '/functions.php';
require_login();

$title = 'Information hub';
require __DIR__ . '/header.php';
?>
<section class="page-heading"><p class="eyebrow">System notes</p><h1>Information hub.</h1><p class="lede">A compact view of the controls behind this private workspace.</p></section>
<div class="info-band"><article class="setting"><strong>Authentication</strong><p>Passwords are stored with PHP's password hashing API. A successful login regenerates the session identifier.</p></article><article class="setting"><strong>Database access</strong><p>All writes use PDO prepared statements with emulated prepares disabled, keeping values separate from SQL instructions.</p></article><article class="setting"><strong>Input discipline</strong><p>Server-side checks enforce required fields, valid email formats, and practical string length limits before insertion.</p></article><article class="setting"><strong>Output safety</strong><p>Values rendered into HTML are escaped with htmlspecialchars using UTF-8 and quote encoding.</p></article></div>
<?php require __DIR__ . '/footer.php'; ?>
