<section class="leo-hero  hero--full" data-hero>
  <!-- seta esquerda -->
  <button class="hero-arrow hero-arrow--left" data-hero-prev aria-label="Slide anterior">
    <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true"><path d="M15 6l-6 6 6 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
  </button>

  <div class="hero-track" data-hero-track>
    <?php if (!empty($slides)): ?>
      <?php foreach ($slides as $i => $s): ?>
        <article class="hero-slide<?= $i===0 ? ' is-active':'' ?>" style="background-image:url('<?= e($s['image_path']) ?>')">
          <div class="hero-overlay">
            <div class="hero-copy">
              <div class="hero-box">
                <h2><?= e(strtoupper($s['title'])) ?></h2>
                <?php if (!empty($s['description'])): ?>
                  <p><?= e($s['description']) ?></p>
                <?php endif; ?>
                <?php if (!empty($s['button_link'])): ?>
                  <a class="leo-btn leo-btn--outline-white" href="<?= e($s['button_link']) ?>" target="_blank" rel="noopener">VER CURSO</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    <?php else: ?>
      <?php $fallbackHero = asset('/assets/img/hero-default.jpg'); ?>
      <article class="hero-slide is-active" style="background-image:url('<?= e($fallbackHero) ?>')">
        <div class="hero-overlay">
          <div class="hero-copy">
            <div class="hero-box">
              <h2>LOREM IPSUM</h2>
              <p>Crie slides em <strong>Slides</strong> para aparecer aqui.</p>
              <a class="leo-btn leo-btn--outline-white" href="/slides/create">ADICIONAR SLIDE</a>
            </div>
          </div>
        </div>
      </article>
    <?php endif; ?>
  </div>

  <!-- seta direita -->
  <button class="hero-arrow hero-arrow--right" data-hero-next aria-label="Próximo slide">
    <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true"><path d="M9 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
  </button>

  <div class="hero-dots" data-hero-dots>
    <?php $total = max(1, count($slides ?? [])); for ($d=0; $d<$total; $d++): ?>
      <button class="hero-dot<?= $d===0?' is-active':'' ?>" data-hero-dot="<?= $d ?>" aria-label="Ir para o slide <?= $d+1 ?>"></button>
    <?php endfor; ?>
  </div>
</section>

<section class="leo-courses">
  <h3 class="section-title">
    MEUS CURSOS
    <?php if (!empty($q ?? '')): ?>
      <small class="muted"> · Resultados para “<?= e($q) ?>”</small>
    <?php endif; ?>
  </h3>

  <?php if (empty($courses)): ?>
    <div class="leo-form-card" style="text-align:center">
      <p>Nenhum curso encontrado.</p>
      <?php if (!empty($q ?? '')): ?>
        <p class="hint">Tente outros termos ou limpe a busca.</p>
      <?php endif; ?>
      <a class="leo-btn leo-btn--green" href="/courses/create">ADICIONAR CURSO</a>
    </div>
  <?php else: ?>
    <div class="course-grid">
      <?php foreach ($courses as $c): ?>
        <article class="course-card">
          <?php if (!empty($c['image_path'])): ?>
            <img class="course-card__img" src="<?= e($c['image_path']) ?>" alt="<?= e($c['title']) ?>">
          <?php else: ?>
            <div class="course-card__img course-card__img--ph" aria-hidden="true"></div>
          <?php endif; ?>
          <div class="course-card__body">
            <h4 class="course-card__title"><?= e(mb_strtoupper($c['title'])) ?></h4>
            <p class="course-card__desc"><?= e(mb_strimwidth($c['description'], 0, 96, '…')) ?></p>
            <a class="leo-btn leo-btn--green" href="#">VER CURSO</a>
          </div>
        </article>
      <?php endforeach; ?>

      <!-- bloco “Adicionar curso” permanece -->
      <a href="/courses/create" class="course-card course-card--add" aria-label="Adicionar curso">
        <div class="add-tile">
          <svg width="64" height="64" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/></svg>
          <strong>ADICIONAR<br>CURSO</strong>
        </div>
      </a>
    </div>
  <?php endif; ?>
</section>