<?php
// config/koneksi.php

$host     = "localhost";
$username = "root";
$password = "";
$database = "modiftracker"; // Pastikan nama database di phpMyAdmin sama ya!

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    // Set error mode ke exception agar gampang melacak error SQL
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>