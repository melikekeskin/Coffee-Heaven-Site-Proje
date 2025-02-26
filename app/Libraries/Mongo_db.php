<?php
require 'vendor/autoload.php'; // Composer autoload

class Mongo_db {
    private $client;
    private $db;
    
    public function __construct() {
        // MongoDB bağlantısı
        $CI =& get_instance();
        $config = $CI->config->item('mongodb');
        $this->client = new MongoDB\Client($config['dsn']);
        $this->db = $this->client->siparisler_db; // Veritabanı adı
    }

    // Siparişleri kaydetme fonksiyonu
    public function create_order($data) {
        $collection = $this->db->siparisler; // Koleksiyon adı
        $result = $collection->insertOne($data);
        return $result->getInsertedId(); // Eklenen siparişin ID'sini döndürür
    }

    // Koleksiyondan verileri çekme fonksiyonu
    public function get_orders() {
        $collection = $this->db->siparisler;
        return $collection->find();
    }
}
