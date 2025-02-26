<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipariş Ver</title>
</head>
<body>
    <h1>Sipariş Ver</h1>
    <?php if ($this->session->flashdata('message')): ?>
        <p><?= $this->session->flashdata('message'); ?></p>
    <?php endif; ?>
    <form action="<?= site_url('order/create'); ?>" method="POST">
        <label for="customer_name">Ad Soyad</label>
        <input type="text" id="customer_name" name="customer_name" required>

        <label for="email">E-posta</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Telefon</label>
        <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required>

        <label for="drink">İçecek Seçimi</label>
        <select id="drink" name="drink" required>
            <option value="">Seçiniz</option>
            <option value="kahve">Kahve</option>
            <option value="çay">Çay</option>
            <option value="latte">Latte</option>
        </select>

        <label for="note">Sipariş Notu</label>
        <textarea id="note" name="note" rows="4"></textarea>

        <button type="submit">Sipariş Ver</button>
    </form>
</body>
</html>
