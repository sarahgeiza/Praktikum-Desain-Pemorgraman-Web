<?php
session_start();

$id = $_POST['id'] ?? null;

$nama = trim($_POST['nama'] ?? '');
$noAnggota = trim($_POST['no_anggota'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$noHp = trim($_POST['no_hp'] ?? '');

if (!$id) {
    header('Location: list.php');
    exit;
}

$errors = [];

if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}

if ($noAnggota === '') {
    $errors[] = "No. Anggota wajib diisi.";
}

if ($noHp !== '' && !preg_match('/^[0-9]+$/', $noHp)) {
    $errors[] = "No. HP hanya boleh berisi angka.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => implode(' ', $errors)
    ];

    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

require __DIR__ . '/../includes/koneksi.php';

$stmt = $pdo->prepare(
    "UPDATE anggota
     SET nama = :nama,
         no_anggota = :no_anggota,
         alamat = :alamat,
         no_hp = :no_hp
     WHERE id = :id"
);

try {
    $stmt->execute([
        'nama' => $nama,
        'no_anggota' => $noAnggota,
        'alamat' => $alamat,
        'no_hp' => $noHp,
        'id' => $id
    ]);
} catch (PDOException $e) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => 'No. Anggota sudah dipakai, gunakan nomor lain.'
    ];

    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => 'Anggota berhasil diubah.'
];

header('Location: list.php');
exit;