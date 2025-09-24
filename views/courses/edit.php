<h1>Editar Curso #<?= (int)$course['id'] ?></h1>

<form method="post" enctype="multipart/form-data" action="/courses/<?= (int)$course['id'] ?>" class="leo-form leo-form-card">
  <input type="hidden" name="_csrf" value="<?= e($csrf) ?>">

  <!-- Título -->
  <div class="form-group">
    <label class="form-label">Título*</label>
    <input class="leo-control" name="title" value="<?= e($course['title']) ?>">
    <?php if (!empty($errors['title'])): ?><small class="err"><?= e($errors['title']) ?></small><?php endif; ?>
  </div>

  <!-- Descrição + Imagem lado a lado -->
  <div class="form-grid">
    <div class="form-group">
      <label class="form-label">Descrição*</label>
      <textarea class="leo-control leo-control--textarea" name="description"><?= e($course['description']) ?></textarea>
      <?php if (!empty($errors['description'])): ?><small class="err"><?= e($errors['description']) ?></small><?php endif; ?>
    </div>

    <div class="form-group">
      <label class="form-label">Imagem (opcional)</label>
      <input class="leo-control" type="file" name="image" id="courseImageInput" accept="image/*">
      <?php if (!empty($errors['image'])): ?><small class="err"><?= e($errors['image']) ?></small><?php endif; ?>

      <?php
        $img = !empty($course['image_path']) ? $course['image_path'] : '';
      ?>
      <div class="img-preview" id="courseImagePreview"
           style="<?= $img ? "background-image:url('".e($img)."')" : '' ?>"></div>
      <small class="hint">Formatos: JPG/PNG/WEBP • até 2MB • proporção sugerida ~16:9</small>
    </div>
  </div>

  <!-- Status -->
  <div class="form-group" style="max-width:280px">
    <label class="form-label">Status</label>
    <select class="leo-control" name="is_active">
      <option value="1" <?= (int)$course['is_active']===1 ? 'selected':'' ?>>Ativo</option>
      <option value="0" <?= (int)$course['is_active']===0 ? 'selected':'' ?>>Inativo</option>
    </select>
  </div>

  <button class="leo-btn" type="submit">Salvar</button>
</form>
