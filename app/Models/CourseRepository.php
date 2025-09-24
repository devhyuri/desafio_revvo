<?php
namespace App\Models;
use App\Core\DB;
use PDO;

final class CourseRepository {
  public function paginate(int $page=1, int $perPage=10): array {
    $off = ($page-1)*$perPage;
    $stmt = DB::pdo()->prepare("SELECT * FROM courses ORDER BY id DESC LIMIT :lim OFFSET :off");
    $stmt->bindValue(':lim', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':off', $off, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
  }
  public function find(int $id): ?array {
    $s = DB::pdo()->prepare("SELECT * FROM courses WHERE id=?");
    $s->execute([$id]);
    $r = $s->fetch();
    return $r ?: null;
  }
  public function create(array $d): int {
    $s = DB::pdo()->prepare("INSERT INTO courses(title,description,image_path,is_active,created_at) VALUES(?,?,?,?,datetime('now'))");
    $s->execute([$d['title'],$d['description'],$d['image_path']??null,(int)($d['is_active']??1)]);
    return (int) DB::pdo()->lastInsertId();
  }
  public function update(int $id, array $d): void {
    $s = DB::pdo()->prepare("UPDATE courses SET title=?,description=?,image_path=?,is_active=?,updated_at=datetime('now') WHERE id=?");
    $s->execute([$d['title'],$d['description'],$d['image_path']??null,(int)($d['is_active']??1),$id]);
  }
  public function delete(int $id): void {
    DB::pdo()->prepare("DELETE FROM courses WHERE id=?")->execute([$id]);
  }

   public function search(string $q = '', int $page = 1, int $perPage = 12, ?bool $onlyActive = null): array {
  $pdo = DB::pdo(); // << aqui era conn()

  $conds  = [];
  $params = [];

  if ($q !== '') {
    $conds[] = '(title LIKE :q OR description LIKE :q)';
    $params[':q'] = "%{$q}%";
  }
  if ($onlyActive === true)  $conds[] = 'is_active = 1';
  if ($onlyActive === false) $conds[] = 'is_active = 0';

  $sql = 'SELECT * FROM courses';
  if ($conds) $sql .= ' WHERE ' . implode(' AND ', $conds);
  $sql .= ' ORDER BY id DESC LIMIT :limit OFFSET :offset';

  $stmt = $pdo->prepare($sql);
  foreach ($params as $k => $v) {
    $stmt->bindValue($k, $v, PDO::PARAM_STR);
  }
  $stmt->bindValue(':limit',  $perPage, PDO::PARAM_INT);
  $stmt->bindValue(':offset', max(0, ($page-1)*$perPage), PDO::PARAM_INT);

  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
