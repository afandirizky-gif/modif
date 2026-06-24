<?php 
session_start();
include 'config/data.php'; 

// ==========================================
// 1. INISIALISASI DATA (SESSION STATE)
// ==========================================
// Mengambil data awal dari data.php jika session belum terbentuk
if (!isset($_SESSION['parts_data'])) {
    $_SESSION['parts_data'] = $parts; 
}

// ==========================================
// 2. LOGIKA CRUD (TAMBAH & HAPUS KOMPONEN)
// ==========================================
// Proses Tambah Komponen
if (isset($_POST['tambah_komponen'])) {
    $nama = $_POST['nama_komponen'];
    $harga = (int)$_POST['harga_komponen'];
    $status = $_POST['status_komponen'];

    $_SESSION['parts_data'][] = [
        'nama' => $nama,
        'harga' => $harga,
        'status' => $status
    ];
    header("Location: index.php?page=dashboard");
    exit;
}

// Proses Hapus Komponen
if (isset($_GET['action']) && $_GET['action'] === 'hapus' && isset($_GET['id'])) {
    $id_hapus = $_GET['id'];
    if (isset($_SESSION['SESSION_parts_data'][$id_hapus])) {
        unset($_SESSION['parts_data'][$id_hapus]);
        $_SESSION['parts_data'] = array_values($_SESSION['parts_data']); // Atur ulang index array agar tetap berurutan
    }
    header("Location: index.php?page=dashboard");
    exit;
}

// ==========================================
// 3. KALKULASI TOTAL BIAYA (REAL-TIME)
// ==========================================
$total_estimasi = 0;
$total_pengeluaran = 0;
foreach ($_SESSION['parts_data'] as $part) {
    $total_estimasi += $part['harga'];
    if ($part['status'] == "Sudah Dibeli") {
        $total_pengeluaran += $part['harga'];
    }
}

// ==========================================
// 4. LOGIKA AUTENTIKASI (LOGIN & LOGOUT)
// ==========================================
$error_message = "";

// Proses Login
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

// Proses Logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: index.php?page=login");
    exit;
}

// ==========================================
// 5. SISTEM ROUTING & PROTEKSI HALAMAN
// ==========================================
$page = isset($_GET['page']) ? $_GET['page'] : 'onboarding';

// Proteksi: Jika belum login, tendang balik ke halaman login saat mencoba akses dashboard
if ($page === 'dashboard' && !isset($_SESSION['is_logged_in'])) {
    header("Location: index.php?page=login");
    exit;
}

// Proses Pemanggilan Halaman (Render View)
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