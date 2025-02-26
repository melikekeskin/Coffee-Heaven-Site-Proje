<?php

namespace App\Models;

use CodeIgniter\Model;

class AnasayfaModel extends Model
{
   protected $table='kullanicilar';


   public function kayitlar()
   {
      $this->table='urunler';
      return $this->findAll();
   }

} 