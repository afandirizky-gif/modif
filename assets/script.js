// Fitur Live Search untuk mencari komponen di tabel ModifTracker
document.getElementById('searchBar').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('table tbody tr');

    rows.forEach(row => {
        // Mengambil teks dari kolom kedua (Nama Komponen)
        let namaKomponen = row.cells[1].textContent.toLowerCase();
        
        // Jika nama komponen cocok dengan yang diketik, tampilkan. Jika tidak, sembunyikan.
        if (namaKomponen.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});