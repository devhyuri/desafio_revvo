<?php
namespace App\Core;

class Controller {
  protected function view(string $tpl, array $data = []): string { return View::make($tpl, $data); }
  protected function abort(int $code, string $msg): string { http_response_code($code); return $msg; }
}
