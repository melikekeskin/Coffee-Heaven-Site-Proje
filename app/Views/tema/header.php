<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Heaven</title>
    <link rel="stylesheet" href="<?=base_url()?>Assets/style.css">
</head>
<body>
<header>
    <div class="navbar">
        <div class="logo">☕ Coffee Heaven</div>
        <nav>
            <ul>
                <li><a href="index.php">Anasayfa</a></li>
                <li class="dropdown">
                    <a class="dropbtn">Menüler</a>
                    <ul class="dropdown-content">
                        <li><a href="<?=base_url("icecekler")?>">İçecekler</a></li>
                        
                    </ul>
                </li>
                <li><a href="<?=base_url("order_form")?>">Sipariş Oluştur</a></li>
                <?php
                if (isset($durum) && $durum)
                 {
                ?>
                <li><a href="<?=base_url("logout")?>">Çıkış</a></li>
                <?php
                }
                else
                {
                ?>
                <li><a href="<?=base_url("login")?>">Yönetici Girişi</a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
    </div>
</header>