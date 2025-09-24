<h1>Slides</h1>

<div class="admin-actions">
  <a class="leo-btn" href="/slides/create">+ Novo Slide</a>
</div>

<div class="table-wrap">
  <table class="leo-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Título</th>
        <th>Ordem</th>
        <th>Status</th>
        <th class="col-actions">Ações</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($slides as $s): ?>
      <tr>
        <td><?= (int)$s['id'] ?></td>
        <td><?= e($s['title']) ?></td>
        <td><?= (int)$s['sort_order'] ?></td>
        <td>
          <?php if ((int)$s['is_active'] === 1): ?>
            <span class="badge badge--green">Ativo</span>
          <?php else: ?>
            <span class="badge badge--muted">Inativo</span>
          <?php endif; ?>
        </td>
        <td class="col-actions">
          <a class="leo-btn leo-btn--sm leo-btn--muted" href="/slides/<?= (int)$s['id'] ?>/edit">
            <!-- lápis -->
            <svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" fill="currentColor"/></svg>
            Editar
          </a>

          <form method="post" action="/slides/<?= (int)$s['id'] ?>/del" class="inline" onsubmit="return confirmDelete(this)">
            <input type="hidden" name="_csrf" value="<?= e($csrf) ?>">
            <button class="leo-btn leo-btn--sm leo-btn--danger" type="submit">
              <!-- lixeira -->
              <svg viewBox="0 0 24 24" width="14" height="14" aria-hidden="true"><path d="M9 3h6l1 2h5v2H3V5h5l1-2zm1 6h2v9h-2V9zm4 0h2v9h-2V9zM7 9h2v9H7V9z" fill="currentColor"/></svg>
              Excluir
            </button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
