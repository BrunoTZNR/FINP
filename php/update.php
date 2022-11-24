<?php
  require './db/conexao.php';

  $card = $_GET['card'];
  $id_card = $_GET['id'];

  $css = './../assets/css/style.css';
  $js = '';
  $logout = './logout.php';
  $home = './home.php';
  $perfil = './includes/profile/profile.php';
  $view = './view.php?card='. $card .'&id='. $id_card;

  verifyLogin($logout);

  define('TITLE', 'CARD - UPDATE');

  include './includes/header.php';

  if ($card == 'boletos') {

  } else if ($card == 'cheques') {
    $dados = viewCheque($_SESSION['id_user'], $id_card);
  } else if ($card == 'meta') {

  } else if ($card == 'cartoes') {

  } else if ($card == 'investimentos') {

  } else {
    return false;
  }

  $alert = '';
?>

<section class="alert">
  <p class="alert_text"><?=$alert?></p>
</section>

<main class="update">
  <section class="update_container">
    <?php
      include './includes/'. $card .'/card_update.php';
    ?>

    <div class="update_container_acoes">
      <a class="button" href="<?=$view?>">voltar</a>
      <button class="button" type="submit" name="alterar">salvar</button>
    </div>
  </section>
</main>

<?php
  include './includes/footer.php';
?>