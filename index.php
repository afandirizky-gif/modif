<?php 
session_start();
include 'config/data.php';     
include 'config/koneksi.php';  

// ==========================================
// 1. INISIALISASI DATA (SESSION STATE)
// ==========================================
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
    if (isset($_SESSION['parts_data'][$id_hapus])) {
        unset($_SESSION['parts_data'][$id_hapus]);
        $_SESSION['parts_data'] = array_values($_SESSION['parts_data']); 
    }
    header("Location: index.php?page=dashboard");
    exit;
}

// ==========================================
// 3. KALKULASI TOTAL BIAYA (REAL-TIME)
// ==========================================
$total_estimasi = 0;
$total_pengeluaran = 0;

if (isset($_SESSION['parts_data']) && is_array($_SESSION['parts_data'])) {
    foreach ($_SESSION['parts_data'] as $part) {
        $total_estimasi += $part['harga'];
        if ($part['status'] === "Sudah Dibeli") {
            $total_pengeluaran += $part['harga'];
        }
    }
}

// ==========================================
// 4. LOGIKA AUTENTIKASI (LOGIN & LOGOUT)
// ==========================================
$error_message = "";
if (isset($_POST['login_submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'Rizky Afandi' && $password === 'kiki118') {
        $_SESSION['is_logged_in'] = true;
        $_SESSION['username'] = $username;
        header("Location: index.php?page=dashboard");
        exit;
    } else {
        $error_message = "Username atau password salah!";
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: index.php?page=login");
    exit;
}

// ==========================================
// LOGIKA REGISTRASI USER BARU VIA MYSQL
// ==========================================
$success_message = "";
if (isset($_POST['register_submit'])) {
    $reg_username = trim($_POST['reg_username']);
    $reg_password = $_POST['reg_password']; // Bisa ditingkatkan pakai password_hash() nanti

    try {
        // 1. Cek dulu apakah username sudah pernah terdaftar atau belum
        $cek_query = "SELECT COUNT(*) FROM users WHERE username = :username";
        $cek_stmt = $conn->prepare($cek_query);
        $cek_stmt->bindParam(':username', $reg_username);
        $cek_stmt->execute();
        
        if ($cek_stmt->fetchColumn() > 0) {
            $error_message = "Username sudah digunakan! Silakan cari nama lain.";
        } else {
            // 2. Jika aman, langsung masukkan data user baru ke tabel MySQL
            $ins_query = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $ins_stmt = $conn->prepare($ins_query);
            $ins_stmt->bindParam(':username', $reg_username);
            $ins_stmt->bindParam(':password', $reg_password);
            
            if ($ins_stmt->execute()) {
                $success_message = "Akun berhasil dibuat! Silakan <a href='index.php?page=login' class='underline font-bold text-blue-700'>Login</a>.";
            }
        }
    } catch (PDOException $e) {
        $error_message = "Gagal mendaftar: " . $e->getMessage();
    }
}

// ==========================================
// 5. SISTEM ROUTING (MENGGUNAKAN FOLDER 'PAGAS')
// ==========================================
$page = isset($_GET['page']) ? $_GET['page'] : 'onboarding';

if ($page === 'dashboard' && !isset($_SESSION['is_logged_in'])) {
    header("Location: index.php?page=login");
    exit;
}

if ($page === 'dashboard') {
    include 'components/header.php'; 
    include 'pagas/dashboard.php'; 
    include 'components/footer.php'; 
} elseif ($page === 'login') {
    include 'pagas/login.php';
} elseif ($page === 'register') {
    include 'pagas/register.php'; // 🎯 TAMBAHKAN BARIS INI BIAR BISA DIAKSES
} else {
    include 'pagas/onboarding.php';
}