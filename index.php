<?php 
session_start();
include 'config/data.php'; 

// 1. LOGIKA LOGIN
$error_message = "";
if (isset($_POST['login_submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['is_logged_in'] = true;
        $_SESSION['username'] = $username;
        header("Location: index.php?page=dashboard");
        exit;
    } else {
        $error_message = "Username atau password salah, Ki!";
    }
}

// 2. LOGIKA LOGOUT
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: index.php?page=login");
    exit;
}

// 3. ROUTING & PROTEKSI HALAMAN
$page = isset($_GET['page']) ? $_GET['page'] : 'onboarding';

if ($page === 'dashboard' && !isset($_SESSION['is_logged_in'])) {
    header("Location: index.php?page=login");
    exit;
}

// 4. MEMANGGIL FILE DARI FOLDER PAGES (Sama kayak panggil Screen di Flutter)
if ($page === 'dashboard') {
    include 'components/header.php'; 
    include 'pages/dashboard.php'; 
    include 'components/footer.php'; 
} elseif ($page === 'login') {
    include 'pages/login.php';
} else {
    include 'pages/onboarding.php';
}
?>