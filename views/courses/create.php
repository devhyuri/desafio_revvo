<h1>Novo Curso</h1>

<form method="post" enctype="multipart/form-data" action="/courses" class="leo-form leo-form-card">
  <input type="hidden" name="_csrf" value="<?= e($csrf) ?>">

  <div class="form-group">
    <label class="form-label">Título*</label>
    <input class="leo-control" name="title" value="<?= e($title ?? '') ?>">
    <?php if (!empty($errors['title'])): ?><small class="err"><?= e($errors['title']) ?></small><?php endif; ?>
  </div>

  <!-- Descrição + Imagem lado a lado -->
  <div class="form-grid">
    <div class="form-group">
      <label class="form-label">Descrição*</label>
      <textarea class="leo-control leo-control--textarea" name="description"><?= e($desc ?? '') ?></textarea>
      <?php if (!empty($errors['description'])): ?><small class="err"><?= e($errors['description']) ?></small><?php endif; ?>
    </div>

    <div class="form-group">
      <label class="form-label">Imagem</label>
      <input class="leo-control" type="file" name="image" accept="image/*">
      <?php if (!empty($errors['image'])): ?><small class="err"><?= e($errors['image']) ?></small><?php endif; ?>
    </div>
  </div>

  <div class="form-group" style="max-width:280px">
    <label class="form-label">Status</label>
    <select class="leo-control" name="is_active">
      <option value="1" <?= (isset($isAct) ? (int)$isAct===1 : true) ? 'selected':'' ?>>Ativo</option>
      <option value="0" <?= (isset($isAct) && (int)$isAct===0) ? 'selected':'' ?>>Inativo</option>
    </select>
  </div>

  <button class="leo-btn" type="submit">Salvar</button>
</form>
