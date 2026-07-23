<?php
require_once __DIR__ . '/functions.php';
require_login();

$statement = db()->query('SELECT name, email, subject, message, created_at FROM submissions ORDER BY created_at DESC');
$submissions = $statement->fetchAll();
$title = 'Submissions directory';
require __DIR__ . '/header.php';
?>
<section class="page-heading"><p class="eyebrow">Message archive</p><h1>Submissions directory.</h1><p class="lede">A chronological view of every contact record stored in the system.</p></section>
<div class="table-panel">
    <?php if (!$submissions): ?><p>No submissions yet. <a class="text-link" href="contact.php">Create the first one.</a></p><?php else: ?>
    <table><thead><tr><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Received</th></tr></thead><tbody>
        <?php foreach ($submissions as $submission): ?><tr><td><?= e($submission['name']) ?></td><td><?= e($submission['email']) ?></td><td><?= e($submission['subject']) ?></td><td class="message-cell"><?= e($submission['message']) ?></td><td><?= e(date('M j, Y g:i A', strtotime($submission['created_at']))) ?></td></tr><?php endforeach; ?>
    </tbody></table>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/footer.php'; ?>
