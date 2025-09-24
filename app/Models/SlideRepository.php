<?php
namespace App\Models;
use App\Core\DB;
use PDO;

final class SlideRepository {
  public function all(): array {
    return DB::pdo()->query("SELECT * FROM slides ORDER BY sort_order ASC, id DESC")->fetchAll();
  }
  public function allActive(): array {
    return DB::pdo()->query("SELECT * FROM slides WHERE is_active=1 ORDER BY sort_order ASC, id DESC")->fetchAll();
  }
  public function find(int $id): ?array {
    $s = DB::pdo()->prepare("SELECT * FROM slides WHERE id=?"); $s->execute([$id]);
    $r = $s->fetch(); return $r ?: null;
  }
  public function create(array $d): int {
    $s = DB::pdo()->prepare("INSERT INTO slides(title,description,button_text,button_link,image_path,sort_order,is_active,created_at) VALUES(?,?,?,?,?,?,?,datetime('now'))");
    $s->execute([$d['title'],$d['description']??null,$d['button_text']??null,$d['button_link']??null,$d['image_path'],(int)($d['sort_order']??0),(int)($d['is_active']??1)]);
    return (int) DB::pdo()->lastInsertId();
  }
  public function update(int $id, array $d): void {
    $s = DB::pdo()->prepare("UPDATE slides SET title=?,description=?,button_text=?,button_link=?,image_path=?,sort_order=?,is_active=?,updated_at=datetime('now') WHERE id=?");
    $s->execute([$d['title'],$d['description']??null,$d['button_text']??null,$d['button_link']??null,$d['image_path'],(int)($d['sort_order']??0),(int)($d['is_active']??1),$id]);
  }
  public function delete(int $id): void {
    DB::pdo()->prepare("DELETE FROM slides WHERE id=?")->execute([$id]);
  }
}
