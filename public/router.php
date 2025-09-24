<?php
// public/router.php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $path;

// Se for arquivo físico (css/js/img), deixa o servidor servir direto
if (php_sapi_name() === 'cli-server' && is_file($file)) {
  return false;
}

// Caso contrário, despacha para o front controller
require __DIR__ . '/index.php';
