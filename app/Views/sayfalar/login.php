    <main>
        <section class="form-container">

            <?php
           if (isset($uyari))
            {
                echo'<div class="alert alert-danger" role="alert">';
                echo' $uyari';
                echo'</div>';
            }
           ?>

            <?= validation_list_errors() ?>
            <h2>Yönetici Girişi</h2>
            <form action="<?=base_url('login')?>" method="POST">
               <?=csrf_field()?> 

                <label for="kulad">Kullanici  Adi</label>
                <input type="text" id="kulad" name="kulad" required>

                <label for="sifre">Şifre</label>
                <input type="password" id="sifre" name="sifre" required>

                <button type="submit">Giriş Yap</button>
            </form>
        </section>
    </main>
