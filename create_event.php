<?php
session_start(); // Pastikan session dimulai untuk mendapatkan informasi username
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connect.php';

// Pastikan pengguna sudah login dan memiliki session 'username'
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Jika tidak ada session username, arahkan ke halaman login
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil input tanggal dalam format "YYYY-MM-DD"
    $input_date = $_POST['date'];

    // Pastikan input tanggal valid
    $datetime_object = DateTime::createFromFormat('Y-m-d', $input_date);
    if (!$datetime_object || $datetime_object->format('Y-m-d') !== $input_date) {
        $error = "Format tanggal tidak valid. Harap pilih tanggal yang benar.";
    } else {
        $formatted_date = $datetime_object->format('Y-m-d');
    }

    // Ambil input judul event dan deskripsi
    $event_title = trim($_POST['event_title']);
    $description = trim($_POST['description']);
    $username = $_SESSION['username']; // Ambil username dari session

    // Validasi input judul event dan deskripsi
    if (empty($event_title) || empty($description)) {
        $error = "Judul event dan deskripsi harus diisi.";
    }

    // Proses file gambar
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $fileName = basename($_FILES['image']['name']);
        $targetFilePath = $uploadDir . $fileName;

        // Validasi file gambar (contohnya memeriksa ekstensi file)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($_FILES['image']['tmp_name']);

        if (!in_array($fileType, $allowedTypes)) {
            $error = "Hanya file JPG, PNG, dan GIF yang diperbolehkan.";
        } elseif (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            // Simpan data ke database jika file berhasil diupload
            try {
                $sql = "INSERT INTO events (date, image_path, event_title, description, username) 
                        VALUES (?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$formatted_date, $targetFilePath, $event_title, $description, $username]);

                header("Location: beranda.php");
                exit;
            } catch (PDOException $e) {
                $error = "Terjadi kesalahan pada database: " . $e->getMessage();
            }
        } else {
            $error = "Gagal mengupload gambar.";
        }
    } else {
        $error = "Harap upload gambar.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <a href="Beranda.php" class="text-sm text-muted">Kembali</a>
    <div class="container mt-5">
        <h1>Tambah Event Baru</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $_SESSION['username']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="event_title" class="form-label">Judul Event</label>
                <input type="text" class="form-control" id="event_title" name="event_title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Unggah Gambar</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Pilih Tanggal</label>
                <!-- Input untuk memilih tanggal, memastikan tidak bisa memilih tanggal yang sudah lewat -->
                <input type="date" class="form-control" id="date" name="date" required min="<?= date('Y-m-d') ?>">
            </div>
            <button type="submit" class="btn btn-primary">Tambah Event</button>
        </form>
    </div>
</body>

</html>