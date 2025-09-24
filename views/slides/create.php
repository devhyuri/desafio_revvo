<h1>Novo Slide</h1>

<form method="post" enctype="multipart/form-data" action="/slides" class="leo-form leo-form-card">
  <input type="hidden" name="_csrf" value="<?= e($csrf) ?>">

  <!-- Título -->
  <div class="form-group">
    <label class="form-label">Título*</label>
    <input class="leo-control" name="title" value="<?= e($title ?? '') ?>">
    <?php if (!empty($errors['title'])): ?><small class="err"><?= e($errors['title']) ?></small><?php endif; ?>
  </div>

  <!-- Descrição + Imagem lado a lado -->
  <div class="form-grid">
    <div class="form-group">
      <label class="form-label">Descrição</label>
      <textarea class="leo-control leo-control--textarea" name="description"><?= e($desc ?? '') ?></textarea>
    </div>

    <div class="form-group">
      <label class="form-label">Imagem*</label>
      <input class="leo-control" type="file" name="image" id="slideImageInput" accept="image/*">
      <?php if (!empty($errors['image'])): ?><small class="err"><?= e($errors['image']) ?></small><?php endif; ?>
      <div class="img-preview" id="slideImagePreview" aria-label="Pré-visualização da imagem"></div>
      <small class="hint">Formatos: JPG/PNG/WEBP • até 2MB • proporção sugerida ~16:9</small>
    </div>
  </div>

  <!-- Texto e Link do botão (2 colunas) -->
  <div class="form-row-2">
    <div class="form-group">
      <label class="form-label">Texto do botão</label>
      <input class="leo-control" name="button_text" value="<?= e($btxt ?? '') ?>">
    </div>
    <div class="form-group">
      <label class="form-label">Link do botão</label>
      <input class="leo-control" name="button_link" value="<?= e($blink ?? '') ?>">
      <?php if (!empty($errors['button_link'])): ?><small class="err"><?= e($errors['button_link']) ?></small><?php endif; ?>
    </div>
  </div>

  <!-- Ordem e Status (2 colunas) -->
  <div class="form-row-2">
    <div class="form-group" style="max-width:220px">
      <label class="form-label">Ordem</label>
      <input class="leo-control" name="sort_order" type="number" value="<?= e((string)($order ?? 0)) ?>">
    </div>
    <div class="form-group" style="max-width:220px">
      <label class="form-label">Status</label>
      <select class="leo-control" name="is_active">
        <option value="1" <?= (isset($isAct) ? (int)$isAct===1 : true) ? 'selected':'' ?>>Ativo</option>
        <option value="0" <?= (isset($isAct) && (int)$isAct===0) ? 'selected':'' ?>>Inativo</option>
      </select>
    </div>
  </div>

  <button class="leo-btn" type="submit">Salvar</button>
</form>
