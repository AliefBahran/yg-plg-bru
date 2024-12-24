<?php
include 'connect.php';
session_start(); // Memulai sesi untuk mengambil role dari pengguna yang login

// Pastikan pengguna sudah login dan memiliki session role
if (isset($_SESSION['role'])) {
    // Periksa role pengguna
    $is_pengunjung = ($_SESSION['role'] == 'Pengunjung') ? true : false;
    $is_pengurus_ukm = ($_SESSION['role'] == 'Pengurus UKM') ? true : false;
    $is_anggota_ukm = ($_SESSION['role'] == 'Anggota UKM') ? true : false;
} else {
    // Jika tidak ada sesi, artinya pengguna belum login
    $is_pengunjung = false;
    $is_pengurus_ukm = false;
    $is_anggota_ukm = false;
}

// Ambil data dari database untuk posts
$query = $pdo->prepare("SELECT *, DATE_FORMAT(created_at, '%Y-%m-%d') AS date, DATE_FORMAT(created_at, '%H:%i') AS time FROM posts");
$query->execute();
$posts = $query->fetchAll(PDO::FETCH_ASSOC);

// Ambil data dari tabel event
$queryEvents = $pdo->prepare("SELECT * FROM events ORDER BY date DESC");
$queryEvents->execute(); // Eksekusi query untuk mendapatkan data event
$events = $queryEvents->fetchAll(PDO::FETCH_ASSOC); // Ambil data event dalam bentuk array

// Jika tidak ada data event, set $events menjadi array kosong
if ($events === false) {
    $events = [];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <!-- Link ke Font Awesome untuk ikon profesional -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="zz.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <!-- Search Bar -->
        <div class="row mb-4">
            <div class="col">
                <div class="search-bar">
                    <form action="pencarian.php" method="GET" class="d-flex w-100">
                        <input type="text" name="query" class="form-control" placeholder="Cari UKM..." value="<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>" required>
                        <button type="submit" class="btn btn-primary ms-2"><i class="bi bi-search"></i> Cari</button>
                    </form>
                </div>
            </div>
        </div>
        
        <?php include 'sidebar.php'; ?>
        
        <!-- Main Content Wrapper -->
        <div class="main-wrapper container">
            <!-- New Post Section -->
            <div class="new-post mt-5">
                <?php if ($is_pengunjung): ?>
                    <h4><a href="p1.html">“UKM recommendation?”</a></h4>
                <?php endif; ?>
                
                <div class="container">
                    <div class="row mb-4">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <h2 class="text-xl font-bold">New Post</h2>
                            <a href="berita.php" class="text-sm text-muted">See more</a>
                        </div>
                        
                        <!-- Tombol Add New Post berada di bawah -->
                        <?php if ($is_pengurus_ukm): ?>
                            <div class="col-12">
                                <a href="rikues.php"><i class="icon fas fa-bell"></i></a>
                                <a href="create_postingan.php" class="btn btn-success w-100">Add New Post</a>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="row">
                        <?php foreach ($posts as $post): ?>
                            <!-- Post Cards -->
                            <div class="col-12 mb-4">
                                <div class="card shadow-sm">
                                    <!-- Bagian Atas: Posted By -->
                                    <div class="card-header d-flex align-items-center" style="background-color: #f8f9fa; border-bottom: none;">
                                        <img src="97242732_237533537524197_4474686594728591360_n (1).jpg" alt="User Profile" class="rounded-circle me-3" style="width: 40px; height: 40px;">
                                        <div>
                                            <h6 class="mb-0 fw-bold"><?= htmlspecialchars($post['username']); ?></h6>
                                        </div>
                                    </div>
                                    
                                    <!-- Gambar Postingan -->
                                    <div class="card-img-top-container">
                                        <img src="<?= htmlspecialchars($post['image_path']); ?>" class="card-img-top img-fluid rounded-top" alt="Post Image">
                                    </div>
                                    
                                    <!-- Tanggal dan Jam -->
                                    <div class="card-meta d-flex justify-content-between px-3 py-2">
                                        <small class="text-muted date"><?= htmlspecialchars($post['date']); ?></small>
                                        <small class="text-muted time"><?= htmlspecialchars($post['time']); ?></small>
                                    </div>
                                    
                                    <!-- Konten Postingan -->
                                    <div class="card-body">
                                        <h5 class="card-title mb-3 fw-bold"><?= htmlspecialchars($post['title']); ?></h5>
                                        <p class="card-text text-muted">
                                            <?= nl2br(htmlspecialchars($post['content'])); ?>
                                        </p>
                                    </div>
                                    
                                    <!-- Footer Postingan -->
                                    <div class="card-footer">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="text-muted small">736 People Saw</div>
                                            <div class="d-flex align-items-center ms-auto">
                                                <i class="bi bi-save2 me-3" style="font-size: 1.2rem; cursor: pointer;"></i>
                                                <i class="bi bi-share" style="font-size: 1.2rem; cursor: pointer;"></i>
                                            </div>
                                        </div>
                                        
                                        <!-- Tombol Edit dan Delete, hanya tampil untuk Pengurus UKM -->
                                        <?php if ($is_pengurus_ukm): ?>
                                            <div class="card-footer d-flex justify-content-start mt-2">
                                                <a href="edit_postingan.php?id=<?= $post['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                                <a href="delete_postingan.php?id=<?= $post['id']; ?>" class="btn btn-danger btn-sm ms-2">Delete</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Planner, Events, and UKM Wrapper -->
            <div class="planner-ukm-wrapper container mt-5">
                <div class="planner">
                    <h3>Planner</h3>
                    <div id="novemberCalendar"></div>
                    <div id="eventListPanel">
                        <h2>Activities</h2>
                        <ul id="eventList"></ul>
                    </div>
                </div>

                <div class="container mt-3">
                    <div class="row">
                        <!-- Events Section -->
                        <div class="col-md-12 mb-4">
                            <div class="events-section-container">
                                <div class="header d-flex justify-content-between">
                                    <h2 class="text-xl font-bold">Live Events</h2>
                                    <a class="text-sm text-gray-500" href="#">See more</a>
                                </div>

                                <div class="container mt-4">
                                    <!-- Tombol Tambah Event di Atas -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <?php
                                            // Cek apakah pengguna memiliki role 'Pengurus UKM'
                                            if ($is_pengurus_ukm) {
                                                // Jika role adalah 'Pengurus UKM', tampilkan tombol "Tambah Event"
                                                echo '<a href="create_event.php" class="btn btn-primary">Tambah Event</a>';
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <!-- Daftar Event -->
                                    <div class="row">
                                        <?php foreach ($events as $event): ?>
                                            <div class="col-12 col-md-6 col-lg-4 mb-4">
                                                <div class="events live-events text-center p-4 border rounded shadow-sm">
                                                    <!-- Format tanggal ke format '15 November, 2024' -->
                                                    <p class="text-muted mb-3">
                                                        <?php
                                                        $formattedDate = date('d F, Y', strtotime($event['date']));
                                                        echo htmlspecialchars($formattedDate);
                                                        ?>
                                                    </p>
                                                    
                                                    <!-- Gambar -->
                                                    <img src="<?= htmlspecialchars($event['image_path']); ?>" alt="Event Image" class="img-fluid rounded mb-3" style="max-height: 200px; object-fit: cover;">
                                                    
                                                    <!-- Judul event -->
                                                    <h5 class="font-bold mb-2"><?= htmlspecialchars($event['event_title']); ?></h5>
                                                    
                                                    <!-- Deskripsi -->
                                                    <p class="text-sm text-gray-700 mb-3"><?= htmlspecialchars($event['description']); ?></p>

                                                    <!-- Tombol Edit dan Delete -->
                                                    <div class="d-flex justify-content-between mt-3">
                                                        <?php
                                                        // Tombol Edit dan Delete hanya untuk Pengurus UKM
                                                        if ($is_pengurus_ukm) {
                                                            echo '<a href="edit_event.php?id=' . $event['id'] . '" class="btn btn-warning btn-sm">Edit</a>';
                                                            echo '<a href="delete_event.php?id=' . $event['id'] . '" class="btn btn-danger btn-sm">Delete</a>';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Popup Kalender Tahun -->
                        <div id="fullCalendarModal" class="modal">
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <h2>Kalender 2024</h2>
                                <div id="fullCalendar"></div>
                            </div>
                        </div>

                        <script src="Beranda.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
