<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('message') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>
<?= validation_list_errors() ?>
<h2>Ürün Ekle</h2>


<form action="<?=base_url('kayit_ekle')?>" method="POST" enctype="multipart/form-data">
    <label for="urunAdi">Ürün Adı:</label>
    <input type="text" id="urunAdi" name="urunAdi" placeholder="Ürün adını giriniz">
    
    <label for="urunFiyati">Fiyat:</label>
    <input type="text" id="urunFiyati" name="urunFiyati" placeholder="Fiyatı giriniz">
    
    <label for="resim">Resim Yükle:</label>
    <input type="file" id="resim" name="resim" accept="image/*">
    
    <button type="submit" name="gonder">Ekle</button>
</form>
