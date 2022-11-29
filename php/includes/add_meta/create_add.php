<?php
  require './../../db/conexao.php';

  $id_card = $_GET['id'];

  $css = './../../../assets/css/style.css';
  $js = '';
  $logout = './../../logout.php';
  $home = './../../home.php';
  $perfil = './../profile/profile.php';
  $meta = './../../view.php?card=metas&id='. $id_card;

  verifyLogin($logout);

  define('ALERT', true);
  define('TITLE', 'CREATE - ADD');
  
  include './../header.php';
?>

<section class="alert">
  <p class="alert_text"><?php if (isset($_GET['alert'])) echo messageAlert(clean($_GET['alert'])) ?></p>
</section>

<main class="add_meta">
  <section class="add_meta_container">
    <div class="add_meta_content">

    </div>

    <div class="add_meta_container_acoes">
      <a class="button" href="<?=$meta?>">voltar</a>
      <button class="button" id="confirm">excluir</button>
    </div>
  </section>
</main>

<?php
  include './../footer.php';
?>