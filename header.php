<?php
require_once __DIR__ . '/functions.php';
$title = $title ?? APP_NAME;
$user = current_user();
?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(page_title($title)) ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="topbar">
    <a class="brand" href="dashboard.php"><span class="brand-mark">S</span><span><?= e(APP_NAME) ?></span></a>
    <?php if ($user): ?>
        <nav class="nav-links" aria-label="Primary navigation">
            <a href="dashboard.php">Overview</a>
            <a href="profile.php">Profile</a>
            <a href="contact.php">Contact</a>
            <a href="submissions.php">Submissions</a>
            <a href="information.php">Info hub</a>
            <a class="nav-logout" href="logout.php">Log out</a>
        </nav>
    <?php endif; ?>
</header>
<main class="page-shell">
