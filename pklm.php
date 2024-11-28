<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuis Umum</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: auto; /* Allow body to scroll if needed */
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            max-height: 90vh; /* Limit height to 90% of viewport */
            overflow-y: auto; /* Enable vertical scroll if content exceeds max-height */
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .question {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .options {
            list-style-type: none;
            padding: 0;
        }
        .options li {
            margin-bottom: 5px;
        }
        .options li label {
            cursor: pointer;
        }
        img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 10px 0;
        }
        .navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        input[type="submit"], button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #45a049;
        }
        .result {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            background-color: #e9ecef;
            border-radius: 8px;
        }
        .result h2 {
            margin-bottom: 10px;
        }
        .explanation {
            margin-top: 20px;
            text-align: left;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kuis Umum</h1>
        <form method="POST" action="">
            <?php
                session_start();

                if (!isset($_SESSION['nama']) && isset($_POST['nama']) && isset($_POST['nim'])) {
                    $_SESSION['nama'] = $_POST['nama'];
                    $_SESSION['nim'] = $_POST['nim'];
                    $_SESSION['currentQuestion'] = 0;
                    $_SESSION['answers'] = [];
                }

                if (!isset($_SESSION['nama'])) {
                    echo '<div class="form-group">';
                    echo '<label for="nama">Nama:</label>';
                    echo '<input type="text" id="nama" name="nama" required>';
                    echo '</div>';
                    echo '<div class="form-group">';
                    echo '<label for="nim">NIM:</label>';
                    echo '<input type="text" id="nim" name="nim" required>';
                    echo '</div>';
                    echo '<input type="submit" value="Mulai Kuis">';
                } else {
                    $questions = [
                        ["question" => "Bangunan tersebut teletak di negara...", "image" => "tajmahal.webp", "options" => ["India", "Indonesia", "Arab", "Amerika", "Singapura"], "correct" => "India", "explanation" => "Tajmahal terletak dinegara India"],
                        ["question" => "Siapa presiden pertama RI?", "image" => "", "options" => ["Albert Einstein", "Thomas Edison", "Soekarno", "Nikola Tesla", "B.J. Habibie"], "correct" => "Soekarno", "explanation" => "Soekarno adalah presiden pertama Indonesia, menjabat sejak tahun 1945."],
                        ["question" => "Berapa jumlah apel yang ada di gambar?", "image" => "apel.png", "options" => ["20", "21", "22", "23", "24"], "correct" => "21", "explanation" => "15+6 adalah 21"],
                        ["question" => "Anggota tubuh yang digunakan untuk mendengar adalah...", "image" => "", "options" => ["Mata", "Hidung", "Mulut", "Telinga", "Kaki"], "correct" => "Telinga", "explanation" => "Telinga berfungsi untuk mendengar"],
                        ["question" => "Apa nama hewan di gambar?", "image" => "kucing.webp", "options" => ["Kucing", "Gajah", "Anjing", "Sapi", "Kelinci"], "correct" => "Kucing", "explanation" => "Nama hewan tersebut adalah Kucing"],
                        ["question" => "Apa nama planet terbesar dalam tata surya kita?", "image" => "", "options" => ["Bumi", "Mars", "Jupiter", "Saturnus", "Venus"], "correct" => "Jupiter", "explanation" => "Jupiter adalah planet terbesar dalam tata surya kita, dengan diameter sekitar 142.984 km."],
                        ["question" => "Apa nama mata uang resmi Indonesia?", "image" => "", "options" => ["Yen", "Won", "Rupiah", "Dollar", "Ringgit"], "correct" => "Rupiah", "explanation" => "Rupiah merupakan alat pembayaran yang sah di Negara Kesatuan Republik Indonesia (NKRI)."],
                        ["question" => "Warna bendera Indonesia adalah...", "image" => "", "options" => ["Merah Putih", "Merah Kuning", "Merah Hijau", "Putih Biru", "Ungu Abu"], "correct" => "Merah Putih", "explanation" => "Bendera merah putih merupakan simbol dari Negara Kesatuan Republik Indonesia (NKRI) dan salah satu identitas bangsa Indonesia."],
                        ["question" => "Hewan yang dapat berubah warna kulitnya adalah…", "image" => "", "options" => ["Ular", "Bunglon", "kadal", "Kucing", "Sapi"], "correct" => "Bunglon", "explanation" => "Bunglon dianggap sebagai hewan yang dapat berkamuflase dengan cara mengubah warna tubuhnya agar sesuai dengan lingkungan."],
                        ["question" => "Tempat ibadah umat Islam disebut…", "image" => "", "options" => ["Masjid", "Gereja", "Pura", "Vihara", "Kelenteng"], "correct" => "Masjid", "explanation" => "Masjid adalah tempat ibadah umat Islam untuk menunaikan ibadah, terutama salat berjamaah."]
                    ];

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (isset($_POST['answer'])) {
                            $_SESSION['answers'][$_SESSION['currentQuestion']] = $_POST['answer'];
                        }
                        if (isset($_POST['next'])) {
                            $_SESSION['currentQuestion']++;
                        } elseif (isset($_POST['prev'])) {
                            $_SESSION['currentQuestion']--;
                        } elseif (isset($_POST['submit'])) {
                            $score = 0;
                            echo "<div class='result'><h2>Hasil Kuis</h2>";
                            foreach ($questions as $index => $q) {
                                $userAnswer = isset($_SESSION['answers'][$index]) ? $_SESSION['answers'][$index] : 'Tidak Dijawab';
                                $isCorrect = $userAnswer == $q['correct'];
                                if ($isCorrect) {
                                    $score++;
                                }
                                echo "<p>Soal " . ($index + 1) . ": " . $q['question'] . "</p>";
                                echo "<p>Jawaban Anda: $userAnswer</p>";
                                echo "<p>Jawaban Benar: " . $q['correct'] . "</p>";
                                echo "<div class='explanation'><strong>Penjelasan:</strong> " . $q['explanation'] . "</div>";
                                echo "<hr>";
                            }
                            $total = count($questions);
                            echo "<p>Skor Anda: $score dari $total</p></div>";
                            echo '<form method="POST"><input type="submit" name="restart" value="Mulai Kuis Lagi"></form>';
                            session_destroy();
                            exit();
                        }
                    }

                    $currentQuestion = $_SESSION['currentQuestion'];
                    $q = $questions[$currentQuestion];
                    echo "<div class='question'>";
                    echo "<p>" . ($currentQuestion + 1) . ". " . $q['question'] . "</p>";
                    if ($q['image'] != "") {
                        echo "<img src='" . $q['image'] . "' alt='Gambar untuk soal'>";
                    }
                    $options = $q['options'];
                    shuffle($options);
                    $labels = ["A", "B", "C", "D", "E"];
                    echo "<ul class='options'>";
                    foreach ($options as $i => $opt) {
                        $checked = isset($_SESSION['answers'][$currentQuestion]) && $_SESSION['answers'][$currentQuestion] == $opt ? 'checked' : '';
                        echo "<li><label><input type='radio' name='answer' value='$opt' required $checked> " . $labels[$i] . ". $opt</label></li>";
                    }
                    echo "</ul></div>";
                    echo "<div class='navigation'>";
                    if ($currentQuestion > 0) {
                        echo "<button type='submit' name='prev'>Previous</button>";
                    }
                    if ($currentQuestion < count($questions) - 1) {
                        echo "<button type='submit' name='next'>Next</button>";
                    } else {
                        echo "<input type='submit' name='submit' value='Submit'>";
                    }
                    echo "</div>";
                }
            ?>
        </form>
    </div>
</body>
</html>