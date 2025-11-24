<?php
// auth.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Middleware type:
 * 'auth'  → for protected pages (dashboard, CRUD)
 * 'guest' → for login/register pages
 */
$type = $type ?? 'auth'; // default to 'auth'

if ($type === 'auth') {
    // Protected page: must be logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit;
    }
} elseif ($type === 'guest') {
    // Guest page: must NOT be logged in
    if (isset($_SESSION['user_id'])) {
        header("Location: home.php");
        exit;
    }
}
