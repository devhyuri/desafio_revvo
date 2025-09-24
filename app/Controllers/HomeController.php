<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\SlideRepository;
use App\Models\CourseRepository;

final class HomeController extends Controller {
 public function index(): string {
  $q = trim($_GET['q'] ?? '');
  $slides  = (new SlideRepository())->allActive();
  $repo    = new CourseRepository();
  // só cursos ativos na home
  $courses = $repo->search($q, 1, 12, true);
  return $this->view('home/index', compact('slides','courses','q'));
}

  
}
