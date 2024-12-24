<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UKM List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .ukm-card {
            background-color: #f8d7da;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease-in-out; /* Hover effect */
        }

        .ukm-card:hover {
            transform: scale(1.05); /* Enlarge card on hover */
        }

        .ukm-icon {
            background-color: #e9ecef;
            border-radius: 10px;
            padding: 20px;
            height: 100px;
            width: 100px;
            margin: auto;
        }

        .ukm-icon img {
            max-width: 100%;
            max-height: 100%;
        }

        .ukm-name {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <div class="container my-5">
        <div class="row row-cols-1 row-cols-md-3 g-3">
            <!-- UKM Card 1 - Djawa Tjap Parabola -->
            <div class="col">
                <a href="isiukm.php" class="text-decoration-none">
                    <div class="ukm-card">
                        <div class="ukm-icon">
                            <img src="voli.jpeg" alt="Djawa Tjap Parabola">
                        </div>
                        <div class="ukm-name">Djawa Tjap Parabola</div>
                    </div>
                </a>
            </div>

            <!-- UKM Card 2 - Embununitel -->
            <div class="col">
                <a href="embununitel.html" class="text-decoration-none">
                    <div class="ukm-card">
                        <div class="ukm-icon">
                            <img src="voli.jpeg" alt="Embununitel">
                        </div>
                        <div class="ukm-name">Embununitel</div>
                    </div>
                </a>
            </div>

            <!-- UKM Card 3 - Voly -->
            <div class="col">
                <a href="voly.html" class="text-decoration-none">
                    <div class="ukm-card">
                        <div class="ukm-icon">
                            <img src="voli.jpeg" alt="Voly">
                        </div>
                        <div class="ukm-name">Voly</div>
                    </div>
                </a>
            </div>

            <!-- UKM Card 4 - Basket -->
            <div class="col">
                <a href="basket.html" class="text-decoration-none">
                    <div class="ukm-card">
                        <div class="ukm-icon">
                            <img src="voli.jpeg" alt="Basket">
                        </div>
                        <div class="ukm-name">Basket</div>
                    </div>
                </a>
            </div>

            <!-- UKM Card 5 - Taekwondo -->
            <div class="col">
                <a href="taekwondo.html" class="text-decoration-none">
                    <div class="ukm-card">
                        <div class="ukm-icon">
                            <img src="voli.jpeg" alt="Taekwondo">
                        </div>
                        <div class="ukm-name">Taekwondo</div>
                    </div>
                </a>
            </div>

            <!-- UKM Card 6 - Karate -->
            <div class="col">
                <a href="karate.html" class="text-decoration-none">
                    <div class="ukm-card">
                        <div class="ukm-icon">
                            <img src="voli.jpeg" alt="Karate">
                        </div>
                        <div class="ukm-name">Karate</div>
                    </div>
                </a>
            </div>

            <!-- UKM Card 7 - Esport -->
            <div class="col">
                <a href="esport.html" class="text-decoration-none">
                    <div class="ukm-card">
                        <div class="ukm-icon">
                            <img src="voli.jpeg" alt="Esport">
                        </div>
                        <div class="ukm-name">Esport</div>
                    </div>
                </a>
            </div>

            <!-- UKM Card 8 - Capoeira -->
            <div class="col">
                <a href="capoeira.html" class="text-decoration-none">
                    <div class="ukm-card">
                        <div class="ukm-icon">
                            <img src="voli.jpeg" alt="Capoeira">
                        </div>
                        <div class="ukm-name">Capoeira</div>
                    </div>
                </a>
            </div>

            <!-- UKM Card 9 - Silat -->
            <div class="col">
                <a href="silat.html" class="text-decoration-none">
                    <div class="ukm-card">
                        <div class="ukm-icon">
                            <img src="voli.jpeg" alt="Silat">
                        </div>
                        <div class="ukm-name">Silat</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
