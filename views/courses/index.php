<?php
// helper de destaque do termo pesquisado
if (!function_exists('hlt')) {
  function hlt(string $text, string $q): string {
    if ($q === '') return e($text);
    $safe = e($text);
    return preg_replace('/'.preg_quote($q, '/').'/i', '<mark>$0</mark>', $safe);
  }
}
$q = trim($q ?? ($_GET['q'] ?? ''));
?>

<h1>Cursos</h1>

<form method="get" class="admin-actions" role="search" style="gap:8px; align-items:center">
  <input type="search" name="q" class="leo-control" placeholder="Buscar cursos…"
         value="<?= e($q) ?>" style="max-width:320px">
  <button class="leo-btn leo-btn--muted leo-btn--sm" type="submit">Buscar</button>
  <?php if ($q !== ''): ?>
    <a class="leo-btn leo-btn--sm leo-btn--ghost" href="/courses">Limpar</a>
  <?php endif; ?>
  <span class="hint" style="margin-left:8px">
    <?= count($courses) ?> resultado<?= count($courses)===1?'':'s' ?><?= $q!=='' ? ' para “'.e($q).'”' : '' ?>
  </span>
  <div style="flex:1"></div>
  <a class="leo-btn" href="/courses/create">+ Novo Curso</a>
</form>

<?php if (empty($courses)): ?>
  <div class="leo-form-card" style="text-align:center">
    <p>Nenhum curso encontrado<?= $q!=='' ? ' para “'.e($q).'”' : '' ?>.</p>
    <p class="hint">Tente outros termos ou <a href="/courses">limpe a busca</a>.</p>
    <a class="leo-btn leo-btn--green" href="/courses/create">Adicionar curso</a>
  </div>
<?php else: ?>
  <div class="table-wrap">
    <table class="leo-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Título</th>
          <th>Status</th>
          <th class="col-actions">Ações</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($courses as $c): ?>
        <tr>
          <td><?= (int)$c['id'] ?></td>

          <td>
            <div class="cell-title">
              <?php if (!empty($c['image_path'])): ?>
                <img class="cell-thumb" src="<?= e($c['image_path']) ?>" alt="">
              <?php endif; ?>
              <span><?= hlt($c['title'], $q) ?></span>
            </div>
          </td>

          <td>
            <?php if ((int)$c['is_active'] === 1): ?>
              <span class="badge badge--green">Ativo</span>
            <?php else: ?>
              <span class="badge badge--muted">Inativo</span>
            <?php endif; ?>
          </td>

          <td class="col-actions">
            <a class="leo-btn leo-btn--sm leo-btn--muted" href="/courses/<?= (int)$c['id'] ?>/edit">
              <svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true">
                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" fill="currentColor"/>
              </svg>
              Editar
            </a>

            <form method="post" action="/courses/<?= (int)$c['id'] ?>/del" class="inline" onsubmit="return confirmDelete(this)">
              <input type="hidden" name="_csrf" value="<?= e($csrf) ?>">
              <button class="leo-btn leo-btn--sm leo-btn--danger" type="submit">
                <svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true">
                  <path d="M9 3h6l1 2h5v2H3V5h5l1-2zm1 6h2v9h-2V9zm4 0h2v9h-2V9zM7 9h2v9H7V9z" fill="currentColor"/>
                </svg>
                Excluir
              </button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<script>
function confirmDelete(form){
  return confirm('Excluir este curso?');
}
</script>
