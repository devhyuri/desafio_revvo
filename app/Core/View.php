<?php
namespace App\Core;

final class View {
  public static function make(string $tpl, array $data=[]): string {
    $file = __DIR__ . '/../../views/' . $tpl . '.php';
    if (!file_exists($file)) return 'View not found';
    extract($data, EXTR_SKIP);
    ob_start();
    include __DIR__ . '/../../views/layout.php';
    return ob_get_clean();
  }
}
