<?php
namespace App\Core;

final class Csrf {
  public static function token(string $key): string {
    if (empty($_SESSION[$key])) $_SESSION[$key] = bin2hex(random_bytes(16));
    return $_SESSION[$key];
  }
  public static function check(string $key, ?string $value): bool {
    return $value && isset($_SESSION[$key]) && hash_equals($_SESSION[$key], $value);
  }
}
