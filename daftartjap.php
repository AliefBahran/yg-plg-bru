<?php
// Memulai session
session_start();

// Cek jika pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, redirect ke halaman login
    header("Location: Login.php");
    exit();
}

// Mengambil ID pengguna dari session
$user_id = $_SESSION['id']; // Pastikan ID ada dalam session setelah login

// Koneksi ke database
include 'koneksipendaftaran.php';

// Ambil data pengguna dari tabel users
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();

// Cek jika pengguna sudah pernah mendaftar
$sql_check = "SELECT * FROM pendaftaran_ukm WHERE nim = ? LIMIT 1";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $user_data['nim']);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

// Jika pengguna sudah mendaftar, tampilkan pesan di bawah
$already_registered = $result_check->num_rows > 0 ? true : false;

// Tutup koneksi
$stmt_check->close();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran UKM</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .background {
            background-image: url('daftar.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }

        .form-container {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 40px 50px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 600px;
        }

        .form-container h2 {
            color: #f0f0f0;
            margin-bottom: 30px;
            font-weight: 600;
            font-size: 24px;
        }

        .form-container label {
            font-weight: 500;
            color: #ddd;
            margin-bottom: 8px;
            display: block;
        }

        .form-container input,
        .form-container select,
        .form-container textarea {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            background-color: #f4f4f4;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            background-color: #a94c4c;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #d3b16b;
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <!-- Bagian Latar Belakang -->
    <div class="background">
        <!-- Formulir Pendaftaran -->
        <div class="form-container">
            <?php
            // Cek jika status URL adalah success
            if (isset($_GET['status']) && $_GET['status'] === 'success') {
                echo '<h2>Permintaan Terkirim!</h2>';
                echo '<a href="DhawaTjapParabola.php" class="back-button">Kembali</a>';
            } else {
                echo '<h2>Pendaftaran UKM</h2>';
            }
        

            // Cek jika sudah pernah mendaftar
            if ($already_registered) {
                echo '<script>showModal("already_registered");</script>';
            } else {
                // Jika belum mendaftar, tampilkan form
            ?>
                <form action="submit_registration.php" method="POST">
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Nama Pengguna</label>
                        <input type="text" id="fullName" name="full_name" class="form-control" value="<?php echo $user_data['username']; ?>" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nim" class="form-label">Nim</label>
                        <input type="text" id="nim" name="nim" class="form-control" value="<?php echo $user_data['nim']; ?>" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo $user_data['email']; ?>" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="division" class="form-label">Divisi</label>
                        <select id="division" name="division" class="form-control" required>
                            <option value="Karawitan">Karawitan</option>
                            <option value="Keroncong">Keroncong</option>
                            <option value="Tari">Tari</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Alasan Bergabung</label>
                        <textarea id="reason" name="reason" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>

    <!-- Modal untuk mendaftar sudah ada -->
    <div class="modal fade" id="alreadyRegisteredModal" tabindex="-1" aria-labelledby="alreadyRegisteredModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alreadyRegisteredModalLabel">Pendaftaran Gagal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Anda sudah mendaftar sebelumnya. Terima kasih!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menampilkan modal
        function showModal(status) {
            let modalId = status === 'already_registered' ? '#alreadyRegisteredModal' : '';
            var myModal = new bootstrap.Modal(document.querySelector(modalId));
            myModal.show();
        }

        // Periksa query string status=success atau already_registered untuk menampilkan modal
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('status') === 'success') {
                showModal('success');
            } else if (urlParams.get('status') === 'already_registered') {
                showModal('already_registered');
            }
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
