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

    // Daftar UKM dan gambar mereka
    $ukm_images = [
        'Unit Kebudayaan Mahasiswa Aceh (UKMA)' => 'aceh.png',
        'AVI Pictures' => 'avi.png',
        'Balon Kata' => 'bata.png',
        'Band' => 'musik.jpg',
        'Betawie' => 'betawi.jpg',
        'Dhawa Tjap Parabola' => 'daftar.jpg',
        'Eka Sanvadita Orkestra (ESO)' => 'orkestra.png',
        'Bengkel Seni Embun' => 'beni.png',
        'Fotografi Telkom' => 'foto.png',
        'Kalimantan' => 'kali.png',
        'Keluarga Besar Mahasiswa Sulawesi (KBMS)' => 'sula.png',
        'Kesenian Bali Widyacana Murti' => 'bali.png',
        'Nippon Bunka - BU' => 'nibu.png',
        'Telkom University Choir (Paduan Suara)' => 'padus.png',
        'Persatuan Mahasiswa Lampung (PERMALA)' => 'lampung.png',
        'Rumah Gadang' => 'rg.png',
        'Samalowa Lombok Sumbawa' => 'lomb.png',
        'Sariksa Wiwaha Sunda (SAWANDA)' => 'sunda.png',
        'Teater Titik' => 'teater.png',
        'Ikatan Keluarga Anak Riau dan Kepulauan Riau (IKRAR)' => 'riau.png',
        'Ikatan Mahasiswa Maluku dan Papua (IMMAPA)' => 'maluku.png',
        'Academy Archery of Telkom (ARCHATEL)' => 'panah.png',
        'Telkom University Badminton Club (TUBC)' => 'minto.png',
        'Bola' => 'bola.png',
        'Basket' => 'bask.png',
        'Capoeira Brazil Telkom University' => 'capo.png',
        'Persatuan Catur Mahasiswa (PCM)' => 'ctr.png',
        'Karate' => 'krt.png',
        'Riverside Softball - Baseball' => 'bsb.png',
        'Taekwondo' => 'tkd.png',
        'Tenis Lapangan' => 'olahraga.jpg',
        'Perguruan Pencak Silat Bela Diri Tangan Kosong (PPS BETAKO) Merpati Putih' => 'mrpt.png',
        'Telkom University Esport' => 'esp.png',
        'Telkom University Volley Ball Club (TUVBC)' => 'vly.png',
        'Aksara Jurnalistik' => 'jrnl.png',
        'Central Computer Improvement (CCI)' => 'cpu.png',
        'Himpunan Pengusaha Muda Indonesia Perguruan Tinggi (HIPMI PT)' => 'pmd.png',
        'Indonesia Marketing Association Student Chapter (IMA SC)' => 'mkrt.png',
        'Institute of Electrical and Electronics Engineers (IEEE)' => 'eng.png',
        'Koperasi Mahasiswa (KOPMA) TelU' => 'kopr.png',
        'Student Activity for Research and Competition Handling (SEARCH)' => 'rsr.png',
        'Student English Society (SES)' => 'egls.png',
        'Lembaga Dakwah Kampus' => 'dkwh.png',
        'Keluarga Mahasiswa Hindu (KMH)' => 'hnd.png',
        'Persekutuan Mahasiswa Kristen (PMK)' => 'grj.png',
        'Keluarga Mahasiswa Pecinta Alam (KMPA)' => 'mapala.png',
        'Korps Suka Rela Palang Merah Indonesia (KSR PMI)' => 'pmi.png',
        'Korps Protokoler Mahasiswa (KPM)' => 'klr.png',
        'Pramuka' => 'prmk.png',
        'Paskibra' => 'pskb.png',
        'Telkom University Education Movement (TEAM)' => 'cpu.png'
    ];

    // Logika pencocokan berdasarkan jawaban
    $recommendedUKM = [];
    $hasilJawaban = [];

    // Logika berdasarkan jawaban question 1 (Seni)
    if ($question1 == 'Seni') {
        $recommendedUKM[] = 'Unit Kebudayaan Mahasiswa Aceh (UKMA)';
        $recommendedUKM[] = 'Eka Sanvadita Orkestra (ESO)';
        $recommendedUKM[] = 'Bengkel Seni Embun';
        $hasilJawaban[] = "Anda memilih kegiatan Seni, sehingga UKM Seni dan Tari serta Paduan Suara cocok untuk Anda.";
    }

    // Logika berdasarkan jawaban question 2 (Olahraga)
    if ($question1 == 'Olahraga' || $question2 == 'Fisik') {
        $recommendedUKM[] = 'Academy Archery of Telkom (ARCHATEL)';
        $recommendedUKM[] = 'Telkom University Badminton Club (TUBC)';
        $recommendedUKM[] = 'Bola';
        $hasilJawaban[] = "Pilihan Anda terkait kegiatan fisik atau olahraga cocok dengan berbagai UKM olahraga yang tersedia.";
    }

    // Logika berdasarkan jawaban question 3 (Organisasi)
    if ($question1 == 'Organisasi' || $question3 == 'Teknis') {
        $recommendedUKM[] = 'Aksara Jurnalistik';
        $recommendedUKM[] = 'Central Computer Improvement (CCI)';
        $recommendedUKM[] = 'Himpunan Pengusaha Muda Indonesia Perguruan Tinggi (HIPMI PT)';
        $hasilJawaban[] = "Anda menunjukkan minat pada kegiatan organisasi atau teknis, sehingga UKM yang mendukung pengembangan teknis dan organisasi cocok untuk Anda.";
    }

    // Logika berdasarkan jawaban question 4 (Komunitas Daerah atau Sosial)
    if ($question4 == 'Komunitas Daerah' || $question4 == 'Sosial') {
        $recommendedUKM[] = 'Keluarga Besar Mahasiswa Sulawesi (KBMS)';
        $recommendedUKM[] = 'Persatuan Mahasiswa Lampung (PERMALA)';
        $recommendedUKM[] = 'Kalimantan';
        $hasilJawaban[] = "Ketertarikan Anda pada komunitas daerah atau kegiatan sosial sesuai dengan UKM Komunitas Daerah.";
    }

    // Logika berdasarkan jawaban question 5 (Karir atau Pengembangan Diri)
    if ($question5 == 'Karir') {
        $recommendedUKM[] = 'Himpunan Pengusaha Muda Indonesia Perguruan Tinggi (HIPMI PT)';
        $recommendedUKM[] = 'Student Activity for Research and Competition Handling (SEARCH)';
        $hasilJawaban[] = "Minat Anda pada pengembangan karir sesuai dengan UKM yang fokus pada kewirausahaan dan riset.";
    }
    if ($question5 == 'Pengembangan Diri') {
        $recommendedUKM[] = 'Aksara Jurnalistik';
        $recommendedUKM[] = 'Koperasi Mahasiswa (KOPMA) TelU';
        $recommendedUKM[] = 'Student English Society (SES)';
        $hasilJawaban[] = "Anda menunjukkan minat pada pengembangan diri, sehingga UKM yang mendukung kreativitas dan pembelajaran cocok untuk Anda.";
    }

    // Hapus duplikasi
    $recommendedUKM = array_unique($recommendedUKM);

    // Gabungkan hasil jawaban
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
  <title>Hasil Rekomendasi UKM</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .ukm-card {
      position: relative;
      width: 100%;
      height: 250px; /* Menjaga tinggi konsisten */
      border: 1px solid #ddd;
      border-radius: 8px;
      margin-bottom: 20px;
      background-size: cover;
      background-position: center;
      text-align: center;
      color: white;
    }
    .ukm-card h5 {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 18px;
      font-weight: bold;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    }
    .ukm-card:hover {
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      transform: translateY(-4px);
      transition: transform 0.3s, box-shadow 0.3s;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h1 class="mb-4">Hasil Rekomendasi UKM</h1>

    <?php if (!empty($recommendedUKM)) : ?>
      <p>Berdasarkan jawaban Anda, berikut adalah UKM yang kami rekomendasikan:</p>
      <div class="row">
        <?php foreach ($recommendedUKM as $ukm) : ?>
          <div class="col-md-2 mb-4"> <!-- Setiap kolom mengisi 2 kolom grid (5 kolom per baris) -->
            <div class="ukm-card" style="background-image: url('<?php echo $ukm_images[$ukm] ?? 'default.jpg'; ?>');">
              <h5><?php echo $ukm; ?></h5>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <p>Hasil analisa: <?php echo nl2br($hasilJawaban); ?></p>

    <!-- Tombol Kembali ke Beranda -->
    <a href="Beranda.php" class="btn btn-primary mt-4">Kembali ke Beranda</a>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
