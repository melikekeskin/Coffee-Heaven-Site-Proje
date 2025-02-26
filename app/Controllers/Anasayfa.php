<?php
namespace App\Controllers;
use App\Models\AnasayfaModel;
use MongoDB;// composerla yüklendi

class Anasayfa extends BaseController
{
    protected $helpers = ['form'];

    public function index()
    {   
        return view('tema/header') . view('sayfalar/anasayfa') . view('tema/footer');
    }

    public function icecekler()
    {
        $data = [];
        $model = model('AnasayfaModel');
        $kayitlar = $model->kayitlar();

        if (count($kayitlar) > 0) {
            $data['kayitlar'] = $kayitlar;
        }

        $session = session(); 
        $data['isim'] = $session->get('isim');
        $data['durum'] = $session->get('durum');

        return view('tema/header', $data)
            . view('sayfalar/icecekler', $data)
            . view('tema/footer');
    }

    public function order_form()
    {
        return view('tema/header') . view('sayfalar/order_form') . view('tema/footer');
    }

    public function login()
{
    $session = session();
    if ($session->has('durum') && $session->get('durum')) {
        return redirect()->to(base_url('panel'));
    } else {
        if (!$this->request->is('post')) {
            return view('tema/header') . view('sayfalar/login') . view('tema/footer');
        }

        $rules = [
            'kulad' => 'required',
            'sifre' => 'required',
        ];

        if (!$this->validate($rules)) {
            return view('tema/header') . view('sayfalar/login') . view('tema/footer');
        }

        $veri = $this->request->getPost();
        $model = model('AnasayfaModel');

        // Kullanıcı bilgilerini kullanıcı adı ile sorgula
        $sor = $model->where(['kulad' => $veri['kulad']])->find();

        if (count($sor) > 0) {
            // Hashlenmiş parolayı kontrol et
            $hashedPassword = $sor[0]['sifre'];
            if (password_verify($veri['sifre'], $hashedPassword)) {
                $kul_bilgi = [
                    'kulad' => $sor[0]['kulad'], // isim yerine kulad kullanılıyor
                    'durum' => true
                ];

                $session->set($kul_bilgi);

                return redirect()->to(base_url('panel'));
            } else {
                return view('tema/header', ['uyari' => 'Yanlış Parola']) . view('sayfalar/login') . view('tema/footer');
            }
        } else {
            return view('tema/header', ['uyari' => 'Kullanıcı Bulunamadı']) . view('sayfalar/login') . view('tema/footer');
        }
    }
}
    public function generateStaticPassword()
    {
        // Şifre "123" için hash oluşturma
        $password = '123';
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        echo "Hashlenmiş Şifre: " . $hashedPassword;
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('login'));
    }

    public function test($ornek)
    {
        $kul_adi = "creepa";
        $sifre = "UTuNwGx03EBUNJjn";
        $adres = "cluster0.9sywh.mongodb.net";
        $veritabani = "siparis_db";

        switch ($ornek)
        {
            case 1:{//tek veri sorgulama
                $koleksiyon_adi='siparisler';
                $client = new MongoDB\Client("mongodb://localhost:27017");

                $koleksiyon = $client->selectCollection("siparisler_db", $koleksiyon_adi);
                $document = $koleksiyon->findOne(['siparis_no' => '12345']);
                //var_dump($document);
                foreach ($document as $key => $value)
                {
                    echo $key.' -> '.$value.'<br>';
                }
            }break;
            case 2:{//çoklu veri sorgulama
                $koleksiyon_adi='siparisler';
                $client = new MongoDB\Client("mongodb://localhost:27017");

                $koleksiyon = $client->selectCollection("siparis_db", $koleksiyon_adi);
                $document = $koleksiyon->find(['siparis_no' => '12345']);
                //var_dump($document);
                foreach ($document as $doc) {
                    foreach ($doc as $key => $value)
                    {
                        echo $key.' -> '.$value.'<br>';
                    }
                    echo '<hr>';
                }
            }break;
            case 3: {
                $koleksiyon_adi = 'users';
                $client = new MongoDB\Client("mongodb+srv://$kul_adi:$sifre@$adres");

                $koleksiyon = $client->selectCollection($veritabani, $koleksiyon_adi);
                $toplam = $koleksiyon->countDocuments([]);

                echo $toplam;
            } break;
            case 4: {
                $koleksiyon_adi = 'comments';
                $client = new MongoDB\Client("mongodb+srv://$kul_adi:$sifre@$adres");

                $koleksiyon = $client->selectCollection($veritabani, $koleksiyon_adi);
                $toplam = $koleksiyon->countDocuments(['email' => 'john_bishop@fakegmail.com']);

                echo $toplam;
            } break;
            case 5: {
                $koleksiyon_adi = 'comments';
                $client = new MongoDB\Client("mongodb+srv://$kul_adi:$sifre@$adres");

                $koleksiyon = $client->selectCollection($veritabani, $koleksiyon_adi);
                $sonuc = $koleksiyon->insertOne([
                    'name' => 'Veli Özcan',
                    'email' => 'ozcan@test.com',
                    'text' => 'örnek yorum',
                ]);

                echo 'Inserted ID: ' . $sonuc->getInsertedId();
            } break;
            case 6: {
                $koleksiyon_adi = 'comments';
                $client = new MongoDB\Client("mongodb+srv://$kul_adi:$sifre@$adres");

                $koleksiyon = $client->selectCollection($veritabani, $koleksiyon_adi);
                $sonuc = $koleksiyon->insertMany([
                    [
                        'name' => 'Veli Özcan',
                        'email' => 'ozcan@test.com',
                        'text' => 'örnek yorum',
                    ],
                    [
                        'name' => 'Veli Özcansd',
                        'email' => 'ozcan@test.com',
                        'text' => 'örnek yorum2',
                    ],
                ]);

                echo 'Inserted IDs: ' . implode(', ', $sonuc->getInsertedIds());
            } break;
            case 7: {
                $koleksiyon_adi = 'comments';
                $client = new MongoDB\Client("mongodb+srv://$kul_adi:$sifre@$adres");

                $koleksiyon = $client->selectCollection($veritabani, $koleksiyon_adi);
                $sonuc = $koleksiyon->updateOne(
                    ['email' => 'ozcan@test.com'],
                    ['$set' => ['text' => 'yorum güncellendi']]
                );

                echo 'Updated Count: ' . $sonuc->getModifiedCount();
            } break;
            case 8: {
                $koleksiyon_adi = 'comments';
                $client = new MongoDB\Client("mongodb+srv://$kul_adi:$sifre@$adres");

                $koleksiyon = $client->selectCollection($veritabani, $koleksiyon_adi);
                $sonuc = $koleksiyon->updateMany(
                    ['email' => 'ozcan@test.com'],
                    ['$set' => ['text' => 'yorum güncellendi']]
                );

                echo 'Updated Count: ' . $sonuc->getModifiedCount();
            } break;
            case 9: {
                $koleksiyon_adi = 'comments';
                $client = new MongoDB\Client("mongodb+srv://$kul_adi:$sifre@$adres");

                $koleksiyon = $client->selectCollection($veritabani, $koleksiyon_adi);
                $sonuc = $koleksiyon->deleteOne(['email' => 'ozcan@test.com']);

                echo 'Deleted Count: ' . $sonuc->getDeletedCount();
            } break;
            case 10: {
                $koleksiyon_adi = 'comments';
                $client = new MongoDB\Client("mongodb+srv://$kul_adi:$sifre@$adres");

                $koleksiyon = $client->selectCollection($veritabani, $koleksiyon_adi);
                $sonuc = $koleksiyon->deleteMany(['email' => 'ozcan@test.com']);

                echo 'Deleted Count: ' . $sonuc->getDeletedCount();
            } break;
        }
    }
}
