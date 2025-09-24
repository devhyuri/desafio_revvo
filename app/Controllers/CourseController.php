<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Validation as V;
use App\Models\CourseRepository;

final class CourseController extends Controller {
  private CourseRepository $repo;
  private string $csrfKey;

  public function __construct() {
    $this->repo = new CourseRepository();
    $cfg = require __DIR__ . '/../../config/app.php';
    $this->csrfKey = $cfg['csrf']['key'];
  }

  public function index(): string {
    $q    = trim($_GET['q'] ?? '');
    $page = max(1, (int)($_GET['page'] ?? 1));
    $repo = new CourseRepository();
    $courses = $repo->search($q, $page, 20, null); // ativos e inativos
    return $this->view('courses/index', compact('courses','q'));
  }

  public function create(): string {
    $csrf = Csrf::token($this->csrfKey);
    return $this->view('courses/create', compact('csrf'));
  }

  public function store(): string {
    if (!Csrf::check($this->csrfKey, $_POST['_csrf'] ?? null)) return $this->abort(419,'CSRF');
    $title = trim($_POST['title'] ?? '');
    $desc  = trim($_POST['description'] ?? '');
    $isAct = (int)($_POST['is_active'] ?? 1);

    $errors = [];
    if (!V::required($title)) $errors['title']='Obrigatório';
    if (!V::required($desc))  $errors['description']='Obrigatório';

    $imgPath = null;
    if (!empty($_FILES['image']['name'])) {
      $imgPath = $this->handleUpload($_FILES['image']);
      if (is_string($imgPath) && str_starts_with($imgPath,'ERR:')) $errors['image'] = substr($imgPath,4);
    }

    if ($errors) {
      $csrf = Csrf::token($this->csrfKey);
      return $this->view('courses/create', compact('csrf','errors','title','desc','isAct'));
    }

    $this->repo->create([
      'title'=>$title,'description'=>$desc,'image_path'=>$imgPath,'is_active'=>$isAct
    ]);
    header('Location: /courses'); exit;
  }

  public function edit(int $id): string {
    $course = $this->repo->find($id);
    if (!$course) return $this->abort(404,'Not found');
    $csrf = Csrf::token($this->csrfKey);
    return $this->view('courses/edit', compact('course','csrf'));
  }

  public function update(int $id): string {
    if (!Csrf::check($this->csrfKey, $_POST['_csrf'] ?? null)) return $this->abort(419,'CSRF');

    $course = $this->repo->find($id);
    if (!$course) return $this->abort(404,'Not found');

    $title = trim($_POST['title'] ?? '');
    $desc  = trim($_POST['description'] ?? '');
    $isAct = (int)($_POST['is_active'] ?? 1);

    $errors = [];
    if (!V::required($title)) $errors['title']='Obrigatório';
    if (!V::required($desc))  $errors['description']='Obrigatório';

    $imgPath = $course['image_path'];
    if (!empty($_FILES['image']['name'])) {
      $res = $this->handleUpload($_FILES['image']);
      if (is_string($res) && str_starts_with($res,'ERR:')) $errors['image'] = substr($res,4);
      else $imgPath = $res;
    }

    if ($errors) {
      $csrf = Csrf::token($this->csrfKey);
      $course = array_merge($course, ['title'=>$title,'description'=>$desc,'is_active'=>$isAct,'image_path'=>$imgPath]);
      return $this->view('courses/edit', compact('course','csrf','errors'));
    }

    $this->repo->update($id, [
      'title'=>$title,'description'=>$desc,'image_path'=>$imgPath,'is_active'=>$isAct
    ]);
    header('Location: /courses'); exit;
  }

  public function destroy(int $id): string {
    if (!Csrf::check($this->csrfKey, $_POST['_csrf'] ?? null)) return $this->abort(419,'CSRF');
    $this->repo->delete($id);
    header('Location: /courses'); exit;
  }

  private function handleUpload(array $file) {
    $cfg = require __DIR__ . '/../../config/app.php';
    if ($file['error'] !== UPLOAD_ERR_OK) return 'ERR:Falha no upload';
    if ($file['size'] > $cfg['upload']['max_bytes']) return 'ERR:Arquivo muito grande';
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $file['tmp_name']); finfo_close($finfo);
    if (!in_array($mime, $cfg['upload']['allowed_mime'], true)) return 'ERR:Tipo não permitido';
    if (!is_dir($cfg['upload']['slides_dir'])) mkdir($cfg['upload']['slides_dir'],0775,true);
    $ext = match($mime){'image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp', default=>'bin'};
    $name = bin2hex(random_bytes(8)).'.'.$ext;
    $dest = rtrim($cfg['upload']['slides_dir'],'/').'/'.$name;
    if (!move_uploaded_file($file['tmp_name'],$dest)) return 'ERR:Não foi possível salvar';
    return '/uploads/slides/'.$name;
  }
}
