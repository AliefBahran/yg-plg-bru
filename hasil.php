<?php 
// Include koneksi database
require_once 'databasee.php';

// Ambil jawaban user berdasarkan ID terakhir
$query = "SELECT * FROM user_answers ORDER BY id DESC LIMIT 1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $userAnswers = $result->fetch_assoc();

    // Ambil jawaban user
    $question1 = $userAnswers['question1'];
    $question2 = $userAnswers['question2'];
    $question3 = $userAnswers['question3'];
    $question4 = $userAnswers['question4'];
    $question5 = $userAnswers['question5'];

    // Logika pencocokan berdasarkan jawaban
    $recommendedUKM = [];
    $hasilJawaban = [];

    // Logika berdasarkan jawaban
    if ($question1 == 'Seni') {
        $recommendedUKM[] = "Unit Kebudayaan Mahasiswa Aceh (UKMA)";
        $recommendedUKM[] = "Eka Sanvadita Orkestra (ESO)";
        $recommendedUKM[] = "Bengkel Seni Embun";
        $recommendedUKM[] = "Telkom University Choir (Paduan Suara)";
        $recommendedUKM[] = "Kesenian Bali Widyacana Murti";
        $recommendedUKM[] = "Nippon Bunka - BU";
        $recommendedUKM[] = "Teater Titik";
        $hasilJawaban[] = "Anda memilih kegiatan Seni, sehingga UKM Seni dan Tari serta Paduan Suara cocok untuk Anda.";
    }

    if ($question1 == 'Olahraga' || $question2 == 'Fisik') {
        $recommendedUKM[] = "Academy Archery of Telkom (ARCHATEL)";
        $recommendedUKM[] = "Telkom University Badminton Club (TUBC)";
        $recommendedUKM[] = "Bola";
        $recommendedUKM[] = "Basket";
        $recommendedUKM[] = "Capoeira Brazil Telkom University";
        $recommendedUKM[] = "Persatuan Catur Mahasiswa (PCM)";
        $recommendedUKM[] = "Karate";
        $recommendedUKM[] = "Riverside Softball - Baseball";
        $recommendedUKM[] = "Taekwondo";
        $recommendedUKM[] = "Tenis Lapangan";
        $recommendedUKM[] = "Telkom University Esport";
        $recommendedUKM[] = "Telkom University Volley Ball Club (TUVBC)";
        $hasilJawaban[] = "Pilihan Anda terkait kegiatan fisik atau olahraga cocok dengan berbagai UKM olahraga yang tersedia.";
    }

    if ($question1 == 'Organisasi' || $question3 == 'Teknis') {
        $recommendedUKM[] = "Aksara Jurnalistik";
        $recommendedUKM[] = "Central Computer Improvement (CCI)";
        $recommendedUKM[] = "Himpunan Pengusaha Muda Indonesia Perguruan Tinggi (HIPMI PT)";
        $recommendedUKM[] = "Indonesia Marketing Association Student Chapter (IMA SC)";
        $recommendedUKM[] = "Institute of Electrical and Electronics Engineers (IEEE)";
        $recommendedUKM[] = "Koperasi Mahasiswa (KOPMA) TelU";
        $recommendedUKM[] = "Student Activity for Research and Competition Handling (SEARCH)";
        $hasilJawaban[] = "Anda menunjukkan minat pada kegiatan organisasi atau teknis, sehingga UKM yang mendukung pengembangan teknis dan organisasi cocok untuk Anda.";
    }

    if ($question1 == 'Komunitas Daerah' || $question4 == 'Sosial') {
        $recommendedUKM[] = "Keluarga Besar Mahasiswa Sulawesi (KBMS)";
        $recommendedUKM[] = "Persatuan Mahasiswa Lampung (PERMALA)";
        $recommendedUKM[] = "Kalimantan";
        $recommendedUKM[] = "Ikatan Keluarga Anak Riau dan Kepulauan Riau (IKRAR)";
        $recommendedUKM[] = "Ikatan Mahasiswa Maluku dan Papua (IMMAPA)";
        $recommendedUKM[] = "Samalowa Lombok Sumbawa";
        $recommendedUKM[] = "Rumah Gadang";
        $recommendedUKM[] = "Sariksa Wiwaha Sunda (SAWANDA)";
        $recommendedUKM[] = "Pramuka";
        $recommendedUKM[] = "Paskibra";
        $hasilJawaban[] = "Ketertarikan Anda pada komunitas daerah atau kegiatan sosial sesuai dengan UKM Komunitas Daerah.";
    }

    if ($question4 == 'Religius') {
        $recommendedUKM[] = "Lembaga Dakwah Kampus";
        $recommendedUKM[] = "Keluarga Mahasiswa Hindu (KMH)";
        $recommendedUKM[] = "Persekutuan Mahasiswa Kristen (PMK)";
        $hasilJawaban[] = "Pilihan Anda pada kegiatan religius cocok dengan UKM Religius yang ada.";
    }

    if ($question4 == 'Lingkungan') {
        $recommendedUKM[] = "Keluarga Mahasiswa Pecinta Alam (KMPA)";
        $recommendedUKM[] = "Korps Suka Rela Palang Merah Indonesia (KSR PMI)";
        $hasilJawaban[] = "Ketertarikan Anda pada kegiatan lingkungan cocok dengan UKM yang fokus pada kegiatan alam dan sosial.";
    }

    if ($question5 == 'Karir') {
        $recommendedUKM[] = "Himpunan Pengusaha Muda Indonesia Perguruan Tinggi (HIPMI PT)";
        $recommendedUKM[] = "Student Activity for Research and Competition Handling (SEARCH)";
        $hasilJawaban[] = "Minat Anda pada pengembangan karir sesuai dengan UKM yang fokus pada kewirausahaan dan riset.";
    }

    if ($question5 == 'Pengembangan Diri') {
        $recommendedUKM[] = "Aksara Jurnalistik";
        $recommendedUKM[] = "Koperasi Mahasiswa (KOPMA) TelU";
        $recommendedUKM[] = "Student English Society (SES)";
        $recommendedUKM[] = "Pramuka";
        $hasilJawaban[] = "Anda menunjukkan minat pada pengembangan diri, sehingga UKM yang mendukung kreativitas dan pembelajaran cocok untuk Anda.";
    }

    // Hapus duplikasi
    $recommendedUKM = array_unique($recommendedUKM);
    $hasilJawaban = implode(" ", $hasilJawaban);

    // Simpan hasil ke tabel user_answers
    $insertQuery = "INSERT INTO user_answers (user_id, question1, question2, question3, question4, question5, answers) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);

    if ($stmt) {
        // Bind parameter dengan benar, pastikan jumlah parameter yang di-bind sesuai
        $stmt->bind_param("issssss", $userAnswers['id'], $question1, $question2, $question3, $question4, $question5, $hasilJawaban);

        // Eksekusi perintah insert
        $stmt->execute();
        $stmt->close();
    }
} else {
    echo "Tidak ada data jawaban yang ditemukan.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hasil Rekomendasi</title>
  <link rel="stylesheet" href="hasil.css">
</head>
<body>
  <div class="container">
    <h1>Hasil Rekomendasi UKM</h1>

    <?php if (!empty($recommendedUKM)) : ?>
      <p>Berdasarkan jawaban Anda, berikut adalah UKM yang kami rekomendasikan:</p>
      <ul class="recommendation-list">
        <?php foreach ($recommendedUKM as $ukm) : ?>
          <li><?php echo htmlspecialchars($ukm); ?></li>
        <?php endforeach; ?>
      </ul>

      <p><strong>Alasan rekomendasi:</strong></p>
      <p><?php echo htmlspecialchars($hasilJawaban); ?></p>
    <?php else : ?>
      <p>Tidak ada UKM yang sesuai dengan jawaban Anda. Silakan coba lagi.</p>
    <?php endif; ?>

    <a href="Beranda.php" class="retry-button">Klik untuk kembali</a>
  </div>
</body>
</html>