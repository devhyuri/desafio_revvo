<?php
namespace App\Core;
use PDO;

final class DB {
  private static ?PDO $pdo = null;

  public static function init(array $cfg): void {
    if (self::$pdo) return;
    if (($cfg['driver'] ?? 'sqlite') === 'sqlite') {
      self::$pdo = new PDO('sqlite:' . $cfg['sqlite_path']);
    } else {
      $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $cfg['host'],$cfg['dbname'],$cfg['charset'] ?? 'utf8mb4');
      self::$pdo = new PDO($dsn, $cfg['user'],$cfg['pass']);
    }
    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  }

  public static function pdo(): PDO { return self::$pdo; }
}
