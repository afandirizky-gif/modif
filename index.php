<?php 
session_start();
include 'config/koneksi.php';  // Koneksi database MySQL tetap aktif
include 'config/data.php';     // Memanggil array master $parts untuk pencocokan

$error_message = "";

// ==========================================
// 1. AMBIL DATA DARI MYSQL & KALKULASI BIAYA
// ==========================================
$total_estimasi = 0;
$total_pengeluaran = 0;
$parts_data = [];

try {
    $query_parts = "SELECT * FROM components ORDER BY id DESC";
    $stmt_parts = $conn->prepare($query_parts);
    $stmt_parts->execute();
    $parts_data = $stmt_parts->fetchAll(PDO::FETCH_ASSOC);

    foreach ($parts_data as $part) {
        $total_estimasi += $part['harga'];
        if ($part['status'] === "Sudah Dibeli") {
            $total_pengeluaran += $part['harga'];
        }
    }
} catch (PDOException $e) {
    echo "Gagal mengambil data dari database: " . $e->getMessage();
}

// ==========================================
// 2. LOGIKA TAMBAH BARANG LANGSUNG KE MYSQL
// ==========================================
if (isset($_POST['tambah_komponen'])) {
    $nama_input = trim($_POST['nama_komponen']);
    $status = $_POST['status_komponen'];
    
    $data_ditemukan = false;
    $harga_otomatis = 0;

    // Cari harga aslinya di file data.php berdasarkan pilihan dropdown
    foreach ($parts as $p) {
        if (strcasecmp($p['nama'], $nama_input) === 0) {
            $data_ditemukan = true;
            $nama_input = $p['nama']; 
            $harga_otomatis = $p['harga']; 
            break;
        }
    }

    if (!$data_ditemukan) {
        $_SESSION['error_flash'] = "Peringatan: Komponen '" . htmlspecialchars($nama_input) . "' tidak terdaftar di data master!";
        header("Location: index.php?page=dashboard");
        exit;
    } else {
        try {
            $query_add = "INSERT INTO components (nama, harga, status) VALUES (:nama, :harga, :status)";
            $stmt_add = $conn->prepare($query_add);
            $stmt_add->bindParam(':nama', $nama_input);
            $stmt_add->bindParam(':harga', $harga_otomatis);
            $stmt_add->bindParam(':status', $status);
            
            if ($stmt_add->execute()) {
                header("Location: index.php?page=dashboard");
                exit;
            }
        } catch (PDOException $e) {
            echo "Gagal menyimpan data ke MySQL: " . $e->getMessage();
        }
    }
}

// ==========================================
// 3. LOGIKA HAPUS BARANG DARI MYSQL
// ==========================================
if (isset($_GET['action']) && $_GET['action'] === 'hapus' && isset($_GET['id'])) {
    $id_hapus = (int)$_GET['id'];

    try {
        $query_del = "DELETE FROM components WHERE id = :id";
        $stmt_del = $conn->prepare($query_del);
        $stmt_del->bindParam(':id', $id_hapus, PDO::PARAM_INT);
        
        if ($stmt_del->execute()) {
            header("Location: index.php?page=dashboard");
            exit;
        }
    } catch (PDOException $e) {
        echo "Gagal menghapus data di MySQL: " . $e->getMessage();
    }
}

// Ambil notifikasi error flash dari session jika ada
if (isset($_SESSION['error_flash'])) {
    $error_message = $_SESSION['error_flash'];
    unset($_SESSION['error_flash']);
}

// ==========================================
// 4. SISTEM ROUTING HALAMAN
// ==========================================
$page = isset($_GET['page']) ? $_GET['page'] : 'onboarding';

if ($page === 'dashboard') {
    include 'components/header.php'; 
    include 'pagas/dashboard.php'; 
    include 'components/footer.php'; 
} else {
    include 'pagas/onboarding.php';
}
?>