<?php
// Memulai session untuk mengambil data login
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, alihkan ke halaman login
    header("Location: login.php");
    exit();
}

// Ambil username yang sedang login dari session
$username_login = $_SESSION['username']; // Mengambil username yang login dari session

// Koneksi ke database
$servername = "localhost";
$db_username = "root"; // Sesuaikan dengan username database Anda
$db_password = ""; // Sesuaikan dengan password database Anda
$dbname = "infoukmtelkom"; // Sesuaikan dengan nama database Anda

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data event dari database berdasarkan username tetap "Dhawa Tjap Parabola"
$sql_events = "SELECT * FROM events WHERE username = 'Dhawa Tjap Parabola'";
$result_events = $conn->query($sql_events);

// Periksa apakah ada hasil
if ($result_events->num_rows > 0) {
    // Menyimpan hasil ke dalam array $events
    $events = [];
    while ($row = $result_events->fetch_assoc()) {
        $events[] = $row; // Menambahkan data event ke array
    }
} else {
    // Jika tidak ada event yang ditemukan
    $events = [];
}

// Ambil data postingan dari database berdasarkan username tetap "Dhawa Tjap Parabola"
$sql_posts = "SELECT * FROM posts WHERE username = 'Dhawa Tjap Parabola' ORDER BY created_at DESC";
$result_posts = $conn->query($sql_posts);

// Periksa apakah ada hasil
if ($result_posts->num_rows > 0) {
    // Menyimpan hasil postingan ke dalam array $posts
    $posts = [];
    while ($row = $result_posts->fetch_assoc()) {
        $posts[] = $row; // Menambahkan data postingan ke array
    }
} else {
    // Jika tidak ada postingan yang ditemukan
    $posts = [];
}

// Ambil data status dan tanggal bergabung pengguna berdasarkan full_name yang sama dengan username yang login
$sql_user = "SELECT status, created_at FROM pendaftaran_ukm WHERE full_name = '$username_login'";
$result_user = $conn->query($sql_user);

$status = "";
$created_at = "";

if ($result_user->num_rows > 0) {
    // Mengambil data pengguna yang sedang login
    $row = $result_user->fetch_assoc();
    $status = $row['status'];
    $created_at = $row['created_at'];
} else {
    // Jika tidak ada data status pengguna
    $status = "not_accepted"; // Default jika data tidak ditemukan
    $created_at = ""; // Tidak ada tanggal bergabung
}

// Ambil jumlah anggota dengan status 'accepted' dari tabel pendaftaran_ukm
$sql_members = "SELECT COUNT(*) AS accepted_members FROM pendaftaran_ukm WHERE status = 'accepted'";
$result_members = $conn->query($sql_members);
$accepted_members = 0;
if ($result_members->num_rows > 0) {
    $row = $result_members->fetch_assoc();
    $accepted_members = $row['accepted_members'];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UKM Djawa Tjap Parabola</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styling untuk logo UKM */
        .logo-ukm {
            width: 150px;
            border-radius: 10px;
            height: 150px;
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .logo-ukm:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        /* Styling untuk teks deskripsi */
        .container h1 {
            font-size: 2rem;
            font-weight: bold;
        }

        .container p {
            font-size: 1rem;
            line-height: 1.5;
            margin-top: 10px;
            color: #6c757d;
        }

        .container ul {
            list-style-type: none;
            padding-left: 0;
        }

        .container ul li {
            font-size: 1rem;
            color: #495057;
        }

        /* Gambar Event */
        .event-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .event-image:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        /* Layout Responsif */
        @media (max-width: 768px) {
            .col-md-6 {
                margin-bottom: 30px;
            }

            .event-image {
                width: 100%;
            }
        }

        /* Ukuran kartu pengurus */
        .pengurus-card {
            width: 100%;
            margin-bottom: 20px;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            height: 400px;
            /* Menetapkan tinggi tetap pada kartu */
        }

        /* Gambar dalam kartu */
        .pengurus-card img {
            width: 100%;
            height: 250px;
            /* Menetapkan tinggi gambar agar konsisten */
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        /* Mengatur teks di dalam kartu */
        .pengurus-card .card-body {
            padding: 10px;
            text-align: center;
            height: 150px;
            /* Menyediakan ruang cukup untuk teks */
        }

        .pengurus-card .card-title {
            font-weight: bold;
            font-size: 1.2rem;
        }

        .pengurus-card .card-text {
            color: #6c757d;
        }

        /* Styling untuk tampilan gambar postingan */
        .post-thumbnail {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .post-thumbnail:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        /* Styling untuk grid postingan */
        .posts-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        /* Styling responsif untuk ukuran layar kecil */
        @media (max-width: 768px) {
            .posts-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 576px) {
            .posts-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <!-- Header Section -->
    <div class="container mt-5">
        <div class="row align-items-center">
            <!-- Logo UKM -->
            <div class="col-md-4 text-center mb-4 mb-md-0">
                <img src="jawa.jpg" alt="Logo UKM Djawa Tjap Parabola" class="logo-ukm rounded-circle shadow-lg img-fluid">
            </div>

            <!-- Konten Deskripsi -->
            <div class="col-md-8">
                <div class="card border-light shadow-lg p-4">
                    <!-- Judul -->
                    <h1 class="display-4 text-dark font-weight-bold mb-4">UKM Djawa Tjap Parabola</h1>

                    <!-- Deskripsi singkat tentang UKM -->
                    <p class="lead mb-4 text-muted">
                        UKM Djawa Tjap Parabola adalah organisasi mahasiswa di tingkat universitas yang mewadahi minat dan bakat mahasiswa dalam budaya Jawa. UKM ini memiliki beberapa divisi sebagai berikut:
                    </p>

                    <!-- Daftar Divisi UKM -->
                    <ul class="list-unstyled mb-5">
                        <li class="mb-3">
                            <i class="bi bi-music-note-beamed text-success"></i>
                            <strong>Karawitan:</strong> Menampung minat dan bakat dalam musik tradisional Jawa.
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-headphones text-warning"></i>
                            <strong>Keroncong:</strong> Untuk mahasiswa yang hobi atau berminat pada genre musik keroncong.
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-person-lines-fill text-info"></i>
                            <strong>Tari:</strong> Menampung minat dan bakat dalam seni tari tradisional Jawa.
                        </li>
                    </ul>

                    <!-- Informasi Anggota dan Status -->
                    <div class="mb-4">
                        <!-- Jumlah Anggota Accepted - Tetap ditampilkan -->
                        <p class="font-weight-bold text-secondary mb-3">
                            <i class="bi bi-person-check-fill text-success"></i>
                            <strong>Jumlah Anggota Accepted:</strong> <?php echo $accepted_members; ?>
                        </p>

                        <!-- Status Anda: Tampil jika pending atau accepted -->
                        <?php if ($status == 'pending' || $status == 'accepted'): ?>
                            <p class="font-weight-bold text-secondary mb-3">
                                <i class="bi bi-person-fill text-warning"></i>
                                <strong>Status Anda:</strong> <?php echo $status; ?>
                            </p>
                        <?php endif; ?>

                        <!-- Tanggal Bergabung: Tampil jika status accepted -->
                        <?php if ($status == 'accepted'): ?>
                            <p class="font-weight-bold text-secondary mb-3">
                                <i class="bi bi-calendar-date text-info"></i>
                                <strong>Tanggal Bergabung:</strong> <?php echo $created_at; ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Tombol Apply Now hanya jika status tidak "accepted" -->
                    <?php if ($status != 'accepted' && $status != 'pending'): ?>
                        <div class="mt-4 text-left">
                            <a href="daftartjap.php" class="btn btn-primary btn-lg shadow-sm">Apply Now</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>


            <!-- Bagian Pengurus dan Event -->
            <div class="container mt-5">
                <div class="row">
                    <!-- Bagian Pengurus -->
                    <div class="col-md-6">
                        <h3 class="text-center text-dark mb-4">Pengurus</h3>
                        <div class="row">
                            <!-- Ketua -->
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm border-light">
                                    <img src="bangjep.jpg" alt="Ketua" class="card-img-top pengurus-img">
                                    <div class="card-body text-center">
                                        <h5 class="card-title font-weight-bold text-dark">Ketua</h5>
                                        <p class="card-text text-muted">(Jefri Ahmad)</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Wakil Ketua -->
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm border-light">
                                    <img src="amanda.jpg" alt="Wakil Ketua" class="card-img-top pengurus-img">
                                    <div class="card-body text-center">
                                        <h5 class="card-title font-weight-bold text-dark">Wakil Ketua</h5>
                                        <p class="card-text text-muted">(Amanda Siti)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Event -->
                    <div class="col-md-6">
                        <h3 class="text-center text-dark mb-4">Event</h3>
                        <div class="row">
                            <!-- Menampilkan Event yang Dibuat oleh Djawa Tjap Parabola -->
                            <?php foreach ($events as $event): ?>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card event-card shadow-sm border-light">
                                        <!-- Format Tanggal -->
                                        <div class="card-header bg-light">
                                            <p class="text-muted mb-0">
                                                <?php
                                                $formattedDate = date('d F, Y', strtotime($event['date']));
                                                echo htmlspecialchars($formattedDate);
                                                ?>
                                            </p>
                                        </div>

                                        <!-- Gambar Event -->
                                        <img src="<?= htmlspecialchars($event['image_path']); ?>" class="card-img-top event-image mb-3 rounded" alt="<?= htmlspecialchars($event['event_title']); ?>">

                                        <!-- Judul Event -->
                                        <div class="card-body">
                                            <h5 class="font-weight-bold text-dark mb-2"><?= htmlspecialchars($event['event_title']); ?></h5>
                                            <p class="text-sm text-muted mb-3"><?= htmlspecialchars($event['description']); ?></p>

                                            <!-- Tombol Edit dan Delete -->
                                            <div class="d-flex justify-content-between mt-3">
                                                <?php
                                                // Cek apakah pengguna memiliki peran 'Pengurus UKM'
                                                if (isset($_SESSION['role']) && $_SESSION['role'] == 'Pengurus UKM') {
                                                    echo '<a href="edit_event.php?id=' . $event['id'] . '" class="btn btn-warning btn-sm">Edit</a>';
                                                    echo '<a href="delete_event.php?id=' . $event['id'] . '" class="btn btn-danger btn-sm">Delete</a>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>


            <!-- CSS tambahan -->
            <style>
                /* Styling untuk logo UKM */
                .logo-ukm {
                    width: 300px;
                    height: 300px;
                    object-fit: cover;
                }

                /* Styling untuk gambar pengurus */
                .pengurus-img {
                    object-fit: cover;
                    height: 200px;
                }

                /* Styling untuk card pengurus */
                .card {
                    border-radius: 12px;
                    overflow: hidden;
                }

                .event-card {
                    border-radius: 12px;
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                }

                .event-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
                }

                /* Styling untuk gambar event */
                .event-image {
                    width: 100%;
                    height: 180px;
                    object-fit: cover;
                    border-radius: 8px;
                }

                /* Spacing dan padding */
                .mb-4 {
                    margin-bottom: 1.5rem !important;
                }

                .p-4 {
                    padding: 2rem !important;
                }

                /* Styling untuk tombol Apply Now */
                .btn-primary {
                    font-size: 1.1rem;
                    padding: 12px 30px;
                    border-radius: 8px;
                    /* Menambahkan titik koma */
                }

                /* Agar tombol berada di kanan */
                .text-right {
                    text-align: right;
                }

                .btn-primary:hover {
                    background-color: #0069d9;
                    transform: scale(1.05);
                }

                .text-muted {
                    color: #6c757d !important;
                }

                .text-sm {
                    font-size: 0.875rem;
                }

                /* Mengubah warna teks untuk judul menjadi hitam */
                .text-dark {
                    color: #000000 !important;
                }

                .card-title.text-dark {
                    color: #000000 !important;
                }
            </style>



            <!-- Menampilkan Postingan -->
            <div class="container mt-4">
                <h3 class="text-center"></h3>

                <!-- Grid untuk menampilkan postingan -->
                <div class="posts-grid">
                    <?php foreach ($posts as $post): ?>
                        <div>
                            <!-- Gambar Posting yang dapat diklik -->
                            <img src="<?= htmlspecialchars($post['image_path']); ?>" alt="<?= htmlspecialchars($post['title']); ?>" class="post-thumbnail" data-bs-toggle="modal" data-bs-target="#postModal" data-title="<?= htmlspecialchars($post['title']); ?>" data-content="<?= htmlspecialchars($post['content']); ?>" data-username="<?= htmlspecialchars($post['username']); ?>" data-date="<?= date('d F, Y H:i', strtotime($post['created_at'])); ?>" data-image="<?= htmlspecialchars($post['image_path']); ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Modal untuk menampilkan detail postingan -->
            <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="postModalLabel">Detail Postingan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Gambar Postingan -->
                            <img id="modalImage" src="" alt="Post Image" class="img-fluid mb-3" style="border-radius: 10px;">
                            <!-- Judul Postingan -->
                            <h5 id="modalTitle"></h5>
                            <!-- Username -->
                            <p><strong>Diposting oleh:</strong> <span id="modalUsername"></span></p>
                            <!-- Tanggal Posting -->
                            <p><strong>Tanggal:</strong> <span id="modalDate"></span></p>
                            <!-- Konten Postingan -->
                            <p id="modalContent"></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

            <script>
                // JavaScript untuk mengisi modal dengan data postingan
                var postModal = document.getElementById('postModal');
                postModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var title = button.getAttribute('data-title');
                    var content = button.getAttribute('data-content');
                    var username = button.getAttribute('data-username');
                    var date = button.getAttribute('data-date');
                    var image = button.getAttribute('data-image');

                    // Menampilkan data ke dalam modal
                    document.getElementById('modalTitle').textContent = title;
                    document.getElementById('modalContent').textContent = content;
                    document.getElementById('modalUsername').textContent = username;
                    document.getElementById('modalDate').textContent = date;
                    document.getElementById('modalImage').src = image;
                });
            </script>
</body>

</html>

<?php
$conn->close();
?>