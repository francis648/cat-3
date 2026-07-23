<?php
declare(strict_types=1);

const DB_HOST = '127.0.0.1';
const DB_NAME = 'secure_contact_portal';
const DB_USER = 'root';
const DB_PASS = '';
const APP_NAME = 'Signal Desk';

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'httponly' => true,
    'samesite' => 'Lax',
]);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
