<?php
namespace App\Core;
final class Validation {
  public static function required(string $v): bool { return trim($v) !== ''; }
  public static function maxlen(string $v, int $n): bool { return mb_strlen($v) <= $n; }
  public static function url(?string $v): bool { return !$v || filter_var($v, FILTER_VALIDATE_URL); }
}
