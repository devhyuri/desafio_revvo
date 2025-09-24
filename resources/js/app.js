// ========== Slider (sem libs) ==========
(function(){
  var hero = document.querySelector('[data-hero]');
  if (!hero) return;

  var track  = hero.querySelector('[data-hero-track]');
  var slides = Array.prototype.slice.call(track.querySelectorAll('.hero-slide'));
  if (!slides.length) return;

  var btnPrev = hero.querySelector('[data-hero-prev]');
  var btnNext = hero.querySelector('[data-hero-next]');
  var dotsBox = hero.querySelector('[data-hero-dots]');
  var dots    = Array.prototype.slice.call(dotsBox.querySelectorAll('.hero-dot'));

  var i = slides.findIndex(function(s){ return s.classList.contains('is-active'); });
  if (i < 0) i = 0;

  function go(idx){
    slides[i].classList.remove('is-active');
    if (dots[i]) dots[i].classList.remove('is-active');

    i = (idx + slides.length) % slides.length;

    slides[i].classList.add('is-active');
    if (dots[i]) dots[i].classList.add('is-active');
  }

  if (btnPrev) btnPrev.addEventListener('click', function(){ go(i-1); });
  if (btnNext) btnNext.addEventListener('click', function(){ go(i+1); });

  dots.forEach(function(d){
    d.addEventListener('click', function(){
      var to = parseInt(d.getAttribute('data-hero-dot'), 10) || 0;
      go(to);
    });
  });

  var timer = setInterval(function(){ go(i+1); }, 5000);
  hero.addEventListener('mouseenter', function(){ clearInterval(timer); });
  hero.addEventListener('mouseleave', function(){ timer = setInterval(function(){ go(i+1); }, 5000); });

  // Com 1 slide não mostra setas/dots
  if (slides.length <= 1) {
    if (btnPrev)  btnPrev.style.display = 'none';
    if (btnNext)  btnNext.style.display = 'none';
    if (dotsBox)  dotsBox.style.display = 'none';
  }
})();

// ========== Modal 1º acesso (Home, estilo do layout) ==========
(function(){
  try {
    if (location.pathname !== "/") return; // só na Home (remova se quiser global)
    var KEY = "revvo_first_visit";
    if (localStorage.getItem(KEY)) return;

    var modal = document.getElementById("firstVisitModal");
    if (!modal) return;

    var btnX  = document.getElementById("firstModalClose");
    var btnGo = document.getElementById("firstModalCta");

    function openModal(){
      modal.style.display = "flex";
      modal.setAttribute("aria-hidden", "false");
      document.body.classList.add("no-scroll");
    }
    function closeModal(){
      modal.style.display = "none";
      modal.setAttribute("aria-hidden", "true");
      document.body.classList.remove("no-scroll");
      localStorage.setItem(KEY, "1"); // marcou que já viu
    }

    openModal();
    if (btnX)  btnX.addEventListener("click", closeModal);
    if (btnGo) btnGo.addEventListener("click", closeModal);

    modal.addEventListener("click", function(e){
      if (e.target === modal) closeModal(); // clique fora
    });
    document.addEventListener("keydown", function(e){
      if (e.key === "Escape") closeModal(); // ESC
    });
  } catch(e){}
})();

// ========== Preview de imagem genérico (Slide/Course) ==========
(function(){
  function bindImagePreview(inputId, previewId){
    var input = document.getElementById(inputId);
    var preview = document.getElementById(previewId);
    if (!input || !preview) return;

    input.addEventListener('change', function(){
      var f = this.files && this.files[0];
      if (!f) return;
      var reader = new FileReader();
      reader.onload = function(e){
        preview.style.backgroundImage = 'url(' + e.target.result + ')';
      };
      reader.readAsDataURL(f);
    });
  }

  // Slide (create/edit)
  bindImagePreview('slideImageInput', 'slideImagePreview');
  // Course (edit)
  bindImagePreview('courseImageInput', 'courseImagePreview');
})();

(function(){
  var btn  = document.getElementById('userMenuBtn');
  var menu = document.getElementById('userDropdown');
  if (!btn || !menu) return;

  function setOpen(v){
    menu.classList.toggle('is-open', v);
    btn.setAttribute('aria-expanded', v ? 'true' : 'false');
  }
  function isOpen(){ return menu.classList.contains('is-open'); }

  btn.addEventListener('click', function(e){
    e.stopPropagation();
    setOpen(!isOpen());
  });

  document.addEventListener('click', function(e){
    if (!isOpen()) return;
    if (!menu.contains(e.target) && e.target !== btn) setOpen(false);
  });

  document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') setOpen(false);
  });
})();

function confirmDelete(formEl){ return confirm('Tem certeza que deseja excluir este item?'); }