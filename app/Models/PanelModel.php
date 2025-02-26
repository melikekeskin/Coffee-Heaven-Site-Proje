<?php

namespace App\Models;

use CodeIgniter\Model;

class PanelModel extends Model
{
    protected $table = 'urunler'; // Tablo adı
    protected $primaryKey = 'id'; // Birincil anahtar (opsiyonel)
    protected $allowedFields = ['urunAdi', 'url', 'urunFiyati', 'resim']; // Eklenebilir/sorgulanabilir alanlar

    public function veri_ekle($urunAdi, $url, $urunFiyati, $resim)
    {
        $data = [
            'urunAdi' => $urunAdi,
            'url' => $url,
            'urunFiyati' => $urunFiyati,
            'resim' => $resim,
        ];
        return $this->insert($data);
    }

    public function kayit_sil($id)
    {
        return $this->where('id', $id)->delete();
    }

    public function kayit_al($id)
    {
        return $this->find($id); // Tek kaydı alır
    }

    public function veri_duzenle($urunAdi, $url, $urunFiyati, $resim, $id)
    {
        $data = [
            'urunAdi' => $urunAdi,
            'url' => $url,
            'urunFiyati' => $urunFiyati,
            'resim' => $resim,
        ];
        return $this->update($id, $data);
    }
    public function kayit_listele()
{
    $session = session();

    if ($session->has('durum') && $session->get('durum')) {
        $model = model('PanelModel'); // Modeli çağır
        $kayitlar = $model->findAll(); // Tüm kayıtları al

        $data = [
            'isim' => $session->get('isim'),
            'durum' => $session->get('durum'),
            'kayitlar' => $kayitlar, // View'e gönderilecek kayıtlar
        ];

        return $this->loadViews(['sayfalar/kayit_listele'], $data);
    } else {
        return redirect()->to(base_url('login')); // Oturum yoksa yönlendir
    }
}


}
