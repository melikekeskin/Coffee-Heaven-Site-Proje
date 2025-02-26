<?php

namespace App\Controllers;

use MongoDB\Client;

class Home extends BaseController
{
    public function kayit_ekle()
    {
        $session = session();

        if (!($session->has('durum') && $session->get('durum'))) {
            return redirect()->to(base_url('login'));
        }

 
        if ($this->request->getMethod() !== 'post') {
            return $this->loadViews(['sayfalar/kayit_ekle'], ['durum' => $session->get('durum')]);
        } else {
          
            $rules = [
                'siparis_no' => 'required',
                'musteri_adi' => 'required',
                'urun' => 'required',
                'tarih' => 'required',
                'adet' => 'required|numeric',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('error', 'Form doğrulama hatası!');
            }

    
            $kul_adi = "coffe_heaven";
            $sifre = "f36XdBTvwVIhf48S";
            $adres = "cluster0.xpgbo.mongodb.net";
            $veritabani = "siparisler_db";
            $koleksiyon_adi = "siparisler";

            try {
                $client = new Client("mongodb+srv://$kul_adi:$sifre@$adres");
                $koleksiyon = $client->selectCollection($veritabani, $koleksiyon_adi);

                $result = $koleksiyon->insertOne([
                    'siparis_no' => $this->request->getPost('siparis_no'),
                    'musteri_adi' => $this->request->getPost('musteri_adi'),
                    'urun' => $this->request->getPost('urun'),
                    'tarih' => $this->request->getPost('tarih'),
                    'adet' => (int)$this->request->getPost('adet'),
                ]);

                if ($result->getInsertedCount() > 0) {
                    return redirect()->to(base_url('kayit_ekle'))->with('message', 'Sipariş başarıyla eklendi!');
                } else {
                    return redirect()->to(base_url('kayit_ekle'))->with('error', 'Sipariş eklenirken bir hata oluştu!');
                }
            } catch (\Exception $e) {
                return redirect()->to(base_url('kayit_ekle'))->with('error', 'MongoDB bağlantı hatası: ' . $e->getMessage());
            }
        }
    }
}
