<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Validation as V;
use App\Models\SlideRepository;

final class SlideController extends Controller {
  private SlideRepository $repo;
  private string $csrfKey;

  public function __construct() {
    $this->repo = new SlideRepository();
    $cfg = require __DIR__ . '/../../config/app.php';
    $this->csrfKey = $cfg['csrf']['key'];
  }

  public function index(): string {
    $slides = $this->repo->all();
    $csrf = Csrf::token($this->csrfKey);
    return $this->view('slides/index', compact('slides','csrf'));
  }

  public function create(): string {
    $csrf = Csrf::token($this->csrfKey);
    return $this->view('slides/create', compact('csrf'));
  }

  public function store(): string {
    if (!Csrf::check($this->csrfKey, $_POST['_csrf'] ?? null)) return $this->abort(419,'CSRF');

    $title = trim($_POST['title'] ?? '');
    $desc  = trim($_POST['description'] ?? '');
    $btxt  = trim($_POST['button_text'] ?? '');
    $blink = trim($_POST['button_link'] ?? '');
    $order = (int)($_POST['sort_order'] ?? 0);
    $isAct = (int)($_POST['is_active'] ?? 1);

    $errors = [];
    if (!V::required($title)) $errors['title']='Obrigatório';
    if ($blink && !V::url($blink)) $errors['button_link']='URL inválida';

    // imagem é obrigatória no slide
    if (empty($_FILES['image']['name'])) $errors['image'] = 'Imagem obrigatória';

    $imgPath = null;
    if (!isset($errors['image']) && !empty($_FILES['image']['name'])) {
      $imgPath = $this->handleUpload($_FILES['image']);
      if (is_string($imgPath) && str_starts_with($imgPath,'ERR:')) $errors['image'] = substr($imgPath,4);
    }

    if ($errors) {
      $csrf = Csrf::token($this->csrfKey);
      return $this->view('slides/create', compact('csrf','errors','title','desc','btxt','blink','order','isAct'));
    }

    $this->repo->create([
      'title'=>$title,'description'=>$desc,'button_text'=>$btxt,'button_link'=>$blink,
      'image_path'=>$imgPath,'sort_order'=>$order,'is_active'=>$isAct
    ]);
    header('Location: /slides'); exit;
  }

  public function edit(int $id): string {
    $slide = $this->repo->find($id);
    if (!$slide) return $this->abort(404,'Not found');
    $csrf = Csrf::token($this->csrfKey);
    return $this->view('slides/edit', compact('slide','csrf'));
  }

  public function update(int $id): string {
    if (!Csrf::check($this->csrfKey, $_POST['_csrf'] ?? null)) return $this->abort(419,'CSRF');

    $slide = $this->repo->find($id);
    if (!$slide) return $this->abort(404,'Not found');

    $title = trim($_POST['title'] ?? '');
    $desc  = trim($_POST['description'] ?? '');
    $btxt  = trim($_POST['button_text'] ?? '');
    $blink = trim($_POST['button_link'] ?? '');
    $order = (int)($_POST['sort_order'] ?? 0);
    $isAct = (int)($_POST['is_active'] ?? 1);

    $errors = [];
    if (!V::required($title)) $errors['title']='Obrigatório';
    if ($blink && !V::url($blink)) $errors['button_link']='URL inválida';

    $imgPath = $slide['image_path'];
    if (!empty($_FILES['image']['name'])) {
      $res = $this->handleUpload($_FILES['image']);
      if (is_string($res) && str_starts_with($res,'ERR:')) $errors['image'] = substr($res,4);
      else $imgPath = $res;
    }

    if ($errors) {
      $csrf = Csrf::token($this->csrfKey);
      $slide = array_merge($slide, [
        'title'=>$title,'description'=>$desc,'button_text'=>$btxt,'button_link'=>$blink,
        'sort_order'=>$order,'is_active'=>$isAct,'image_path'=>$imgPath
      ]);
      return $this->view('slides/edit', compact('slide','csrf','errors'));
    }

    $this->repo->update($id, [
      'title'=>$title,'description'=>$desc,'button_text'=>$btxt,'button_link'=>$blink,
      'image_path'=>$imgPath,'sort_order'=>$order,'is_active'=>$isAct
    ]);
    header('Location: /slides'); exit;
  }

  public function destroy(int $id): string {
    if (!Csrf::check($this->csrfKey, $_POST['_csrf'] ?? null)) return $this->abort(419,'CSRF');
    $this->repo->delete($id);
    header('Location: /slides'); exit;
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
