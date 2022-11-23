<?php
  require './db/conexao.php';

  $css = './../assets/css/style.css';
  $js = '<script src="./../assets/js/home.js" defer></script>';
  $logout = './logout.php';
  $home = './home.php';
  $perfil = './includes/profile/profile.php';

  verifyLogin($logout);

  define('TITLE', 'HOME');

  $meta = contentMeta($_SESSION['id_user']);

  include './includes/header.php';
?>

<main class="home">
  <section class="home_container">
    <div class="card boleto">
      <h3 class="card_title">Boletos</h3>
    </div>

    <div class="card cheque">
      <h3 class="card_title">Cheques</h3>
    </div>

    <div class="card meta">
      <h3 class="card_title">Metas</h3>

      <section class="meta_carrosel">
        <div class="meta_carrosel_limit">
          <div class="content a1">
            <h1>meta 1</h1>
          </div>

          <div class="content a2">
            <h1>meta 2</h1>
          </div>

          <div class="content a3">
            <h1>meta 3</h1>
          </div>
        </div>
      </section>

      <div class="meta_acoes">
        <span class="button e">E</span>
        <span class="button d">D</span>
      </div>
    </div>

    <div class="card cartao">
      <h3 class="card_title">Cartões</h3>
    </div>

    <div class="card investimento">
      <h3 class="card_title">Investimentos</h3>
    </div>
  </section>
</main>

<?php
  include './includes/footer.php';
?>