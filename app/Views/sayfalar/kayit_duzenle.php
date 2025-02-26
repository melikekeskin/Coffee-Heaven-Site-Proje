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
<h2>Ürün Düzenle</h2>


<form action="<?=base_url('kayit_duzenle/'.$veri['id'])?>" method="POST">
    <label for="urunAdi">Ürün Adı:</label>
    <input type="text" id="urunAdi" name="urunAdi" value="<?=esc($veri['urunAdi']) ?>" placeholder="Ürün adını giriniz">
    
    <label for="urunFiyati">Fiyat:</label>
    <input type="text" id="urunFiyati" name="urunFiyati" value="<?=esc($veri['urunFiyati']) ?>" placeholder="Fiyatı giriniz">

    
    <button type="submit" name="gonder">Güncelle</button>
</form>
