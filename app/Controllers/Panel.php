<?php

namespace App\Controllers;

use App\Models\PanelModel;
use MongoDB;

class Panel extends BaseController
{
    protected $helpers = ['form'];

    public function index()
    {
        $session = session();

        if ($session->has('durum') && $session->get('durum')) {
            return $this->loadViews([
                'tema/panel_header',
                'sayfalar/panasayfa',
                'tema/panel_footer',
            ]);
        } else {
            return redirect()->to(base_url('login'));
        }
    }

    public function kayit_ekle()
    {
        
        $session = session();

        if (!($session->has('durum') && $session->get('durum'))) {
            return redirect()->to(base_url('login'));
        }
        
        if ($this->request->getMethod() !== 'post') {
            return $this->loadViews(['sayfalar/kayit_ekle'], ['durum' => $session->get('durum')]);
        }
        else
        {
            $rules = [
                'urunAdi' => 'required',
                'urunFiyati' => 'required',
                'resim' => 'uploaded[resim]|max_size[resim,1024]',
            ];
    
            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('error', 'Form dogrulama hatasi!');
            }
    
            $model = model('PanelModel');
            $img = $this->request->getFile('resim');
    
            if ($img->isValid() && !$img->hasMoved()) {
                $path = FCPATH . 'uploads/';
                $name = $img->getRandomName();
                $img->move($path, $name);
    
                $result = $model->veri_ekle(
                    $this->request->getPost('urunAdi'),
                    url_title($this->request->getPost('url'), '_', true),
                    $this->request->getPost('urunFiyati'),
                    $name
                );
    
                if ($result) {
                    return redirect()->to(base_url('kayit_ekle'))->with('message', 'Urun basariyla eklendi!');
                } else {
                    return redirect()->to(base_url('kayit_ekle'))->with('error', 'Urun eklenirken bir hata olustu!');
                }
            } else {
                return redirect()->to(base_url('kayit_ekle'))->with('error', 'Resim yuklenirken bir hata olustu!');
            }
        }
        
    }

    public function kayit_sil($id)
    {
        $session = session();

        if ($session->has('durum') && $session->get('durum')) {
            $model = model('PanelModel');
            $model->kayit_sil($id);
            return redirect()->to(base_url('kayit_listele'));
        } else {
            return redirect()->to(base_url('login'));
        }
    }

    public function kayit_duzenle($id)
    {
        $session = session();

        if (!($session->has('durum') && $session->get('durum'))) {
            return redirect()->to(base_url('login'));
        }

        $model = model('PanelModel');
        $data = [
            'isim' => $session->get('isim'),
            'durum' => $session->get('durum'),
            'veri' => $model->kayit_al($id),
        ];

        if (!$this->request->getMethod() === 'post') {
            return $this->loadViews(['sayfalar/kayit_duzenle'], $data);
        }

        $rules = [
            'urunAdi' => 'required',
            'urunFiyati' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->loadViews(['sayfalar/kayit_duzenle'], $data);
        }

        $validatedData = $this->validator->getValidated();
        $result = $model->veri_duzenle(
            $validatedData['urunAdi'],
            url_title($validatedData['urunAdi'], '_', true),
            $validatedData['urunFiyati'],
            $id
        );

        if ($result) {
            return redirect()->to(base_url('kayit_duzenle/' . $id))->with('message', 'Kayit basariyla guncellendi!');
        } else {
            return redirect()->back()->with('error', 'Kayit guncellenirken bir hata olustu!');
        }
    }

    public function kayit_listele()
    {
        $session = session();
    
        if ($session->has('durum') && $session->get('durum')) {
            $model = model('PanelModel'); // Modeli yükle
            
            // Veritabanındaki kayıtları al
            $kayitlar = $model->findAll();
    
            // View'e gönderilecek veri
            $data = [
                'isim' => $session->get('isim'),
                'durum' => $session->get('durum'),
                'kayitlar' => $kayitlar, // Kayıtları ekle
            ];
    
            // Görünümü yükle
            return $this->loadViews(['sayfalar/kayit_listele'], $data);
        } else {
            // Eğer oturum yoksa login sayfasına yönlendir
            return redirect()->to(base_url('login'));
        }
    }
    

    public function test($ornek)
    {
        $env = getenv();
        $kul_adi = $env['MONGO_USER'];
        $sifre = $env['MONGO_PASS'];
        $adres = $env['MONGO_HOST'];
        $veritabani = $env['MONGO_DB'];

        $client = new MongoDB\Client("mongodb+srv://$kul_adi:$sifre@$adres");

        switch ($ornek) {
            case 1:
                $this->mongoFindOne($client, $veritabani, 'users', ['email' => 'sean_bean@gameofthron.es']);
                break;
            case 2:
                $this->mongoFind($client, $veritabani, 'comments', ['email' => 'john_bishop@fakegmail.com']);
                break;
            case 3:
                $this->mongoCount($client, $veritabani, 'users', []);
                break;
            case 4:
                $this->mongoCount($client, $veritabani, 'comments', ['email' => 'john_bishop@fakegmail.com']);
                break;
            case 5:
                $this->mongoInsertOne($client, $veritabani, 'comments', [
                    'name' => 'Veli Ozcan',
                    'email' => 'ozcan@test.com',
                    'text' => 'ornek yorum',
                ]);
                break;
            case 6:
                $this->mongoInsertMany($client, $veritabani, 'comments', [
                    ['name' => 'Veli Ozcan', 'email' => 'ozcan@test.com', 'text' => 'ornek yorum'],
                    ['name' => 'Veli Ozcansd', 'email' => 'ozcan@test.com', 'text' => 'ornek yorum2'],
                ]);
                break;
            case 7:
                $this->mongoUpdateOne($client, $veritabani, 'comments', ['email' => 'ozcan@test.com'], ['$set' => ['text' => 'yorum guncellendi']]);
                break;
            case 8:
                $this->mongoUpdateMany($client, $veritabani, 'comments', ['email' => 'ozcan@test.com'], ['$set' => ['text' => 'yorum guncellendi']]);
                break;
            case 9:
                $this->mongoDeleteOne($client, $veritabani, 'comments', ['email' => 'ozcan@test.com']);
                break;
            case 10:
                $this->mongoDeleteMany($client, $veritabani, 'comments', ['email' => 'ozcan@test.com']);
                break;
        }
    }

    private function loadViews(array $views, array $data = [])
    {
        $output = view('tema/header', $data) . view('tema/panel_header');
        foreach ($views as $view) {
            $output .= view($view, $data);
        }
        $output .= view('tema/panel_footer') . view('tema/footer');
        return $output;
    }

    private function mongoFindOne($client, $database, $collection, $filter)
    {
        $collection = $client->selectCollection($database, $collection);
        $document = $collection->findOne($filter);
        foreach ($document as $key => $value) {
            echo "$key -> $value<br>";
        }
    }

    private function mongoFind($client, $database, $collection, $filter)
    {
        $collection = $client->selectCollection($database, $collection);
        $documents = $collection->find($filter);
        foreach ($documents as $doc) {
            foreach ($doc as $key => $value) {
                echo "$key -> $value<br>";
            }
            echo '<hr>';
        }
    }

    private function mongoCount($client, $database, $collection, $filter)
    {
        $collection = $client->selectCollection($database, $collection);
        echo $collection->countDocuments($filter);
    }

    private function mongoInsertOne($client, $database, $collection, $data)
    {
        $collection = $client->selectCollection($database, $collection);
        $collection->insertOne($data);
    }

    private function mongoInsertMany($client, $database, $collection, $data)
    {
        $collection = $client->selectCollection($database, $collection);
        $collection->insertMany($data);
    }

    private function mongoUpdateOne($client, $database, $collection, $filter, $update)
    {
        $collection = $client->selectCollection($database, $collection);
        $collection->updateOne($filter, $update);
    }

    private function mongoUpdateMany($client, $database, $collection, $filter, $update)
    {
        $collection = $client->selectCollection($database, $collection);
        $collection->updateMany($filter, $update);
    }

    private function mongoDeleteOne($client, $database, $collection, $filter)
    {
        $collection = $client->selectCollection($database, $collection);
        $collection->deleteOne($filter);
    }

    private function mongoDeleteMany($client, $database, $collection, $filter)
    {
        $collection = $client->selectCollection($database, $collection);
        $collection->deleteMany($filter);
    }
}