if ($page === 'dashboard') {
    include 'components/header.php'; 
    include 'pages/dashboard.php'; // Dashboard baru bisa membaca variabel kalau kalkulasinya ditaruh di atas baris ini
    include 'components/footer.php'; 
}

<div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow">
    <p class="text-gray-700 text-sm">Selamat datang, <span class="font-bold text-blue-600"><?php echo $_SESSION['username']; ?></span>! 👋</p>
    <a href="index.php?action=logout" class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold py-2 px-4 rounded-lg transition">
        🚪 Logout
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
    <div class="bg-blue-500 text-white p-4 rounded-lg shadow">
        <p class="text-sm uppercase tracking-wider font-semibold opacity-80">Total Rencana Anggaran</p>
        <p class="text-2xl font-bold">Rp <?php echo number_format($total_estimasi, 0, ',', '.'); ?></p>
    </div>
    <div class="bg-green-500 text-white p-4 rounded-lg shadow">
        <p class="text-sm uppercase tracking-wider font-semibold opacity-80">Total Dana Terpakai</p>
        <p class="text-2xl font-bold">Rp <?php echo number_format($total_pengeluaran, 0, ',', '.'); ?></p>
    </div>
</div>

<div class="bg-white p-5 rounded-lg shadow mb-8">
    <div class="text-gray-800 font-semibold mb-4 text-sm uppercase tracking-wider border-b pb-2">➕ Tambah Komponen Impian</div>
    <form action="index.php?page=dashboard" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Komponen</label>
            <input type="text" name="nama_komponen" required placeholder="Misal: Shock KTC, Kaliper Brembo" 
                   class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Harga (Rp)</label>
            <input type="number" name="harga_komponen" required placeholder="Misal: 150000" 
                   class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Status Kelayakan</label>
            <select name="status_komponen" class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700">
                <option value="Wishlist">Wishlist</option>
                <option value="Sudah Dibeli">Sudah Dibeli</option>
            </select>
        </div>
        <div>
            <button type="submit" name="tambah_komponen" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg text-sm transition shadow-md">
                Simpan ke Daftar
            </button>
        </div>
    </form>
</div>

<div class="mb-4">
    <input type="text" id="searchBar" placeholder="🔍 Cari komponen modifikasi yang terdaftar..." 
           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm text-gray-700">
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 bg-gray-800 text-white font-semibold flex justify-between items-center">
        <span>Daftar Komponen & Part Modifikasi</span>
        <span class="text-xs bg-gray-700 px-2 py-1 rounded text-gray-300">Total: <?php echo count($_SESSION['parts_data']); ?> Item</span>
    </div>
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-200 text-gray-700 uppercase text-xs tracking-wider">
                <th class="py-3 px-6 text-center w-16">No</th>
                <th class="py-3 px-6">Nama Komponen</th>
                <th class="py-3 px-6 text-right">Harga</th>
                <th class="py-3 px-6 text-center">Status</th>
                <th class="py-3 px-6 text-center w-24">Aksi</th> </tr>
        </thead>
        <tbody class="text-gray-600 text-sm">
            <?php 
            $no = 1;
            // Looping data sekarang mengambil dari Session dinamis
            foreach ($_SESSION['parts_data'] as $index => $part) { 
                $badgeColor = ($part['status'] == "Sudah Dibeli") ? "bg-green-100 text-green-800" : "bg-yellow-100 text-yellow-800";
            ?>
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                    <td class="py-4 px-6 text-center font-medium"><?php echo $no++; ?></td>
                    <td class="py-4 px-6 font-semibold text-gray-800"><?php echo $part['nama']; ?></td>
                    <td class="py-4 px-6 text-right font-mono">Rp <?php echo number_format($part['harga'], 0, ',', '.'); ?></td>
                    <td class="py-4 px-6 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-bold <?php echo $badgeColor; ?>">
                            <?php echo $part['status']; ?>
                        </span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <a href="index.php?page=dashboard&action=hapus&id=<?php echo $index; ?>" 
                           onclick="return confirm('Yakin ingin menghapus komponen ini, Ki?')" 
                           class="text-red-500 hover:text-red-700 text-xs font-bold bg-red-50 hover:bg-red-100 px-2 py-1 rounded border border-red-200 transition">
                            🗑️ Hapus
                        </a>
                    </td>
                </tr>
            <?php } ?>
            
            <?php if (empty($_SESSION['parts_data'])): ?>
                <tr>
                    <td colspan="5" class="py-8 text-center text-gray-400 bg-gray-50 italic">Belum ada komponen dimasukkan. Silakan tambah di atas!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>