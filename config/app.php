<?php
return [
  'app' => [
    'base_url' => '/', // ajuste se estiver em subdiretório
    'env'      => 'local',
  ],
  'db' => [
    'driver' => 'sqlite', // 'sqlite' | 'mysql'
    'sqlite_path' => __DIR__ . '/../database/desafio_revvo.sqlite',
    // 'driver' => 'mysql',
    // 'host'   => '127.0.0.1',
    // 'dbname' => 'desafio_revvo',
    // 'user'   => 'root',
    // 'pass'   => '',
    // 'charset'=> 'utf8mb4'
  ],
  'upload' => [
    'slides_dir'   => __DIR__ . '/../public/uploads/slides',
    'max_bytes'    => 2 * 1024 * 1024, // 2MB
    'allowed_mime' => ['image/jpeg','image/png','image/webp'],
  ],
  'csrf' => [ 'key' => '_csrf' ],
];
