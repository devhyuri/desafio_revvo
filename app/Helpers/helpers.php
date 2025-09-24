<?php
function e(string $v): string { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

function asset(string $path): string {
  $cfg = require __DIR__ . '/../../config/app.php';
  $base = rtrim($cfg['app']['base_url'] ?? '/', '/');
  return $base . $path;
}
