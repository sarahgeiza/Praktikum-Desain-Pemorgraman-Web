<?php

require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';

if ($_SESSION['role'] !== 'admin') {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => 'Anda tidak memiliki hak akses untuk menghapus anggota.'
    ];

    header('Location: ../index.php');
    exit;
}

require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

csrf_verify();

$id = $_POST['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare(
        "DELETE FROM anggota WHERE id = :id"
    );

    $stmt->execute([
        'id' => $id
    ]);

    $_SESSION['flash'] = [
        'type' => 'success',
        'pesan' => 'Anggota berhasil dihapus.'
    ];
}

header('Location: list.php');
exit;