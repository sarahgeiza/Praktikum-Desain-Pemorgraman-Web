<?php

require __DIR__ . '/includes/koneksi.php';

$file = __DIR__ . '/data/buku.json';

$data = json_decode(file_get_contents($file), true);

if (!is_array($data)) {
    die("Data buku.json tidak valid.");
}

$stmt = $pdo->prepare(
    "INSERT INTO buku (judul, pengarang, tahun, stok, kategori)
     VALUES (:judul, :pengarang, :tahun, :stok, :kategori)"
);

$jumlah = 0;

foreach ($data as $buku) {
    $stmt->execute([
        'judul' => $buku['judul'],
        'pengarang' => $buku['pengarang'],
        'tahun' => (int) $buku['tahun'],
        'stok' => (int) $buku['stok'],
        'kategori' => $buku['kategori']
    ]);

    $jumlah++;
}

echo "Migrasi berhasil. $jumlah data buku berhasil dimasukkan.";