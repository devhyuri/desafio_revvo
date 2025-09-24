<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>LEO • Plataforma</title>
  <link rel="stylesheet" href="/assets/css/app.css">
</head>

<?php $userName = $_SESSION['user_name'] ?? 'John Doe'; ?>

<body class="leo-body">
  <!-- Header -->
  <header class="leo-header">
    <div class="leo-container leo-header__wrap">
      <a class="leo-brand" href="/">LEO</a>

      <?php $q = trim($_GET['q'] ?? ''); ?>
      <form class="leo-search" action="/" method="get" role="search">
        <input name="q" class="leo-input" placeholder="Pesquisar cursos..."
              value="<?= e($q) ?>" aria-label="Pesquisar curso"/>
        <button class="leo-btn leo-btn--ghost" type="submit" aria-label="Buscar">…</button>
      </form>

      <!-- Usuário + dropdown -->
      <div class="leo-user-wrap">
        <button class="leo-user leo-user-btn" id="userMenuBtn" aria-haspopup="menu" aria-expanded="false">
          <div class="leo-avatar" title="<?= htmlspecialchars($userName) ?>">
            <?= strtoupper(mb_substr($userName,0,1)) ?>
          </div>
          <div class="leo-user__txt">
            <small>Seja bem-vindo</small>
            <strong><?= htmlspecialchars($userName) ?></strong>
          </div>
          <svg class="leo-chev" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
            <path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </button>

        <nav class="user-dropdown" id="userDropdown" role="menu" aria-labelledby="userMenuBtn">
          <a href="/slides"  role="menuitem">Listar slides</a>
          <a href="/courses" role="menuitem">Listar cards</a>
        </nav>
      </div>
    </div>
  </header>

  <!-- Main -->
  <main class="leo-main">
    <div class="leo-container">
      <?php include $file; ?>
    </div>
  </main>

  <!-- Footer -->
  <footer class="leo-footer">
    <div class="leo-container leo-footer__grid">
      <div>
        <a class="leo-brand leo-brand--footer" href="/">LEO</a>
        <p class="leo-footnote">
          Maecenas faucibus mollis interdum. Morbi leo risus, porta ac consectetur
          ac, vestibulum at eros.
        </p>
      </div>

      <div>
        <h4>// CONTATO</h4>
        <p>(21) 98765-3434<br/>contato@leolearning.com</p>
      </div>

      <div>
        <h4>// REDES SOCIAIS</h4>
        <div class="leo-social">
          <a href="#" aria-label="Facebook" class="leo-social__btn" title="Facebook">
            <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
              <path d="M22 12a10 10 0 10-11.6 9.9v-7h-2.4v-2.9h2.4V9.4c0-2.4 1.4-3.8 3.5-3.8 1 0 2 .2 2 .2v2.2h-1.1c-1.1 0-1.5.7-1.5 1.4v1.7h2.6L15.6 15h-2v7A10 10 0 0022 12z" fill="currentColor"/>
            </svg>
          </a>
          <a href="#" aria-label="Twitter/X" class="leo-social__btn" title="Twitter">
            <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
              <path d="M3 3l7.4 9.8L3 21h3.3l6.1-6.9 4.9 6.9H21l-7.9-10.8L21 3h-3.3l-5.6 6.3L7.6 3H3z" fill="currentColor"/>
            </svg>
          </a>
          <a href="#" aria-label="YouTube" class="leo-social__btn" title="YouTube">
            <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
              <path d="M23 7.1a3 3 0 00-2.1-2.1C19 4.5 12 4.5 12 4.5s-7 0-8.9.5A3 3 0 001 7.1 31.7 31.7 0 000 12a31.7 31.7 0 001 4.9 3 3 0 002.1 2.1c1.9.5 8.9.5 8.9.5s7 0 8.9-.5A3 3 0 0023 16.9 31.7 31.7 0 0024 12a31.7 31.7 0 00-1-4.9zM9.8 15.3V8.7l6.1 3.3-6.1 3.3z" fill="currentColor"/>
            </svg>
          </a>
          <a href="#" aria-label="Pinterest" class="leo-social__btn" title="Pinterest">
            <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
              <path d="M12 2a10 10 0 00-3.7 19.3c-.1-.8-.2-2 .1-3 0-.3.8-3.4.8-3.4s-.2-.5-.2-1c0-1 .6-1.7 1.3-1.7s.8.3.8.9c0 .5-.3 1.2-.4 1.9-.1.6.3 1.1.9 1.1 1.1 0 2-1.2 2-3 0-1.6-1.2-2.7-2.9-2.7-2 0-3.2 1.5-3.2 3.2 0 .6.2 1.1.5 1.4l.1.2-.2.8c0 .2-.2.3-.4.2-1.2-.5-1.8-1.9-1.8-3.4 0-2.6 2.1-5.6 6.2-5.6 3.3 0 5.5 2.4 5.5 5 0 3.4-1.9 6-4.7 6-1 0-2-.5-2.3-1.1l-.6 2.2c-.2.8-.8 1.8-1.2 2.4A10 10 0 1012 2z" fill="currentColor"/>
            </svg>
          </a>
        </div>
      </div>
    </div>

    <div class="leo-footer__bottom">
      <div class="leo-container">
        <small>Copyright 2017 – All right reserved.</small>
      </div>
    </div>
  </footer>

  <!-- Modal 1º acesso (único) -->
  <div id="firstVisitModal" class="leo-modal" style="display:none" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="leo-modal__panel first-modal" role="document">
      <button class="first-modal__close" id="firstModalClose" aria-label="Fechar">
        <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true">
          <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>
        </svg>
      </button>

      <img class="first-modal__img" src="/assets/img/modal-hero.jpg" alt="Banner promocional">

      <div class="first-modal__body">
        <h2>EGESTAS TORTOR VULPUTATE</h2>
        <p>Enean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.
           Donec ullamcorper nulla non metus auctor fringilla. Donec sed odio dui.</p>
        <a id="firstModalCta" class="leo-btn leo-btn--blue leo-btn--wide" href="/courses">INSCREVA-SE</a>
      </div>
    </div>
  </div>

  <script src="/assets/js/app.js"></script>
</body>
</html>
