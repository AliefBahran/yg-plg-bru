<?php
// Aktifkan laporan error untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Memulai session
session_start();

// Masukkan file koneksi ke database
include 'database.php'; // Pastikan koneksi berhasil

// Variabel untuk pesan error
$error_message = '';

// Memproses form jika ada request POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form dan bersihkan dari spasi yang tidak perlu
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Query untuk mengambil data pengguna berdasarkan username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username); // "s" berarti string
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika ada data user dengan username tersebut
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password yang dimasukkan dengan password yang disimpan di database
        if ($password === $user['password']) { // Jika password cocok
            // Mulai session dan simpan informasi login
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Menyimpan role untuk akses selanjutnya
            $_SESSION['ukm_id'] = $user['ukm_id']; // Jika ada kolom ukm_id pada tabel users
            $_SESSION['id'] = $user['id']; // Menyimpan id pengguna ke session

            // Redirect ke Beranda.php setelah login berhasil
            header("Location: Beranda.php");
            exit();  // Menghentikan eksekusi lebih lanjut
        } else {
            // Jika password salah
            $error_message = 'Password salah!';
        }
    } else {
        // Jika username tidak ditemukan
        $error_message = 'Username tidak ditemukan!';
    }

    // Tutup prepared statement
    $stmt->close();
}

// Tutup koneksi database
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #d84848, #a94c4c);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        .container {
            display: flex;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); /* White box-shadow */
            width: 70%;
            max-width: 700px;
            outline: 2px solid #ccc; /* Outline for the container */
        }

        .left-section {
            background-color: #fff;
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .doodle-image {
            width: 80%;
            max-width: 250px;
        }

        .right-section {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color:rgb(231, 231, 231);
            border-top-left-radius: 0px;
            border-bottom-left-radius: 0px;
        }

        .login-form {
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        h2 {
            color: #000; /* Black color for heading */
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
            color: #000; /* Black color for label */
        }

        input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s ease;
            outline: 2px solid #ccc; /* Outline on input */
        }

        input:focus {
            border-color: #007BFF;
            outline: 2px solid #007BFF; /* Outline focus color */
        }

        .password-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        /* Atur panjang input password agar sedikit lebih panjang */
        .password-container input {
            width: calc(100% + 10px); /* Menambah sedikit panjang dari 100% */
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            cursor: pointer;
            font-size: 18px;
        }

        .login-button {
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-button:hover {
            background-color: #0056b3;
        }

        .forgot-password {
            text-align: center;
            color: #000; /* Black color for forgot password */
            font-size: 12px;
            display: block;
            margin-top: 8px;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .create-account {
            text-align: center;
            color:rgb(0, 124, 159);
            text-decoration: none;
        }

        .create-account:hover {
            text-decoration: underline;
        }

        p {
            text-align: center;
            margin-top: 8px;
            color: #000; /* Black color for error message */
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                width: 90%;
            }

            .left-section,
            .right-section {
                width: 100%;
                padding: 20px;
            }

            .doodle-image {
                max-width: 250px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="left-section">
            <img src="doodle.jpg" alt="Doodle" class="doodle-image">
        </div>
        <div class="right-section">
            <form class="login-form" method="POST" action="Login.php">
                <h2>Log in</h2>

                <!-- Username -->
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>

                <!-- Password -->
                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" required>
                    <span id="toggle-icon" class="toggle-password" onclick="togglePassword()">
                        <i class="fas fa-eye"></i> <!-- Mata terbuka -->
                    </span>
                </div>

                <!-- Login Button -->
                <button type="submit" class="login-button">Login</button>

                <!-- Link to create account -->
                <a href="#" class="forgot-password">Forgot Password?</a>
                <br>
                <a href="BuatAkun.html" class="create-account">Buat akun</a>

                <!-- Display Error Message -->
                <?php if (!empty($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <script>
        // Fungsi untuk menampilkan atau menyembunyikan password
        function togglePassword() {
            var passwordField = document.getElementById('password');
            var toggleIcon = document.getElementById('toggle-icon');

            // Cek jika password sedang tersembunyi atau terlihat
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Mata tertutup
            } else {
                passwordField.type = 'password';
                toggleIcon.innerHTML = '<i class="fas fa-eye"></i>'; // Mata terbuka
            }
        }
    </script>
</body>

</html>
