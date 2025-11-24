<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$user = "root";
$pass = "";
$db   = "crud_app";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("DB Error: " . $conn->connect_error);
}

function secure($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
