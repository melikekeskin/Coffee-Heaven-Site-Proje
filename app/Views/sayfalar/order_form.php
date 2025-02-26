<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş Oluştur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
        }
        form label {
            display: block;
            margin: 10px 0 5px;
        }
        form input, form select, form textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <main>
        <section class="form-container">
            <h2>Sipariş Oluştur</h2>
            <form action="" method="POST">
                <label for="siparis_no">Sipariş No</label>
                <input type="text" id="siparis_no" name="siparis_no" required>

                <label for="musteri_adi">Müşteri Adı</label>
                <input type="text" id="musteri_adi" name="musteri_adi" required>

                <label for="urun">Ürün</label>
                <input type="text" id="urun" name="urun" required>

                <label for="tarih">Tarih</label>
                <input type="date" id="tarih" name="tarih" required>

                <label for="adet">Adet</label>
                <input type="number" id="adet" name="adet" min="1" required>

                <button type="submit">Sipariş Ver</button>
            </form>
        </section>
    </main>

    <?php
var_dump(__DIR__ . '/../vendor/autoload.php');
    use MongoDB\Client;

    try {
        // MongoDB bağlantısını oluştur
        $client = new Client("mongodb://localhost:27017");
        $database = $client->siparisler_db; // Veri tabanı adı
        $collection = $database->siparisler; // Koleksiyon adı

        // Form gönderildiğinde işlemleri gerçekleştir
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $siparis_no = $_POST['siparis_no'] ?? '';
            $musteri_adi = $_POST['musteri_adi'] ?? '';
            $urun = $_POST['urun'] ?? '';
            $tarih = $_POST['tarih'] ?? '';
            $adet = (int)($_POST['adet'] ?? 1);

            // Siparişi MongoDB'ye ekle
            $order = [
                'siparis_no' => $siparis_no,
                'musteri_adi' => $musteri_adi,
                'urun' => $urun,
                'tarih' => $tarih,
                'adet' => $adet,
            ];

            $result = $collection->insertOne($order);

            if ($result->getInsertedCount() > 0) {
                echo "<p style='text-align: center; color: green;'>Sipariş başariyla oluşturuldu! Sipariş ID: " . $result->getInsertedId() . "</p>";
            } else {
                echo "<p style='text-align: center; color: red;'>Sipariş eklenirken bir hata oluştu.</p>";
            }
        }
    } catch (Exception $e) {
        echo "<p style='text-align: center; color: red;'>Bir hata oluştu: " . $e->getMessage() . "</p>";
    }
    ?>
</body>
</html>
