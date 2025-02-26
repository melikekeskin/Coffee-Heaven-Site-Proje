
    <section class="features">

        <div class="card-container">
            <?php 
            if (isset($kayitlar) && count($kayitlar) > 0) {
                foreach ($kayitlar as $item) {
                    echo '<div class="card">';
                    echo '<img src="' . base_url("uploads/") . $item['resim'] . '" alt="Kart Resmi">';
                    echo '<h3>' . htmlspecialchars($item['urunAdi']) . '</h3>';
                    echo '<p>' . htmlspecialchars($item['urunFiyati']) . '</p>';
                    echo '</div>';
                }
            } 
            else {
                echo '<p>Gösterilecek veri bulunamadı.</p>';
            }
            ?>
        </div>
    </section>
    <style>
    .card-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
        padding: 20px;
    }
    .card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
        padding: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
    .card img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }
    .card h3 {
        font-size: 18px;
        color: #333;
        margin: 10px 0;
    }
    .card p {
        font-size: 16px;
        color: #555;
        margin: 10px 0 0;
    }
</style>

