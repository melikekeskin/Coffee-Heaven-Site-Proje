<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['mongo_db']['default'] = [
    'dsn'    => 'mongodb+srv://coffe_heaven:<db_password>@cluster0.xpgbo.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0',
    'hostname' => '', // DSN kullanıldığı için boş bırakılabilir.
    'port'     => '', // DSN kullanıldığı için boş bırakılabilir.
    'username' => '', // DSN kullanıldığı için boş bırakılabilir.
    'password' => '', // DSN kullanıldığı için boş bırakılabilir.
    'database' => 'siparisler_db', // MongoDB veritabanı adı.
    'db_debug' => TRUE, // Hataları gösterir.
    'return_as' => 'array', // Veriyi 'array' olarak döndürmek için.
];
