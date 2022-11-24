<?php
  require './db/conexao.php';

  $card = $_GET['card'];
  $id_card = $_GET['id'];

  $css = './../assets/css/style.css';
  $js = '<script src="./../assets/js/card.js" defer></script>';
  $logout = './logout.php';
  $home = './home.php';
  $perfil = './includes/profile/profile.php';
  $listagem = './listagem.php?card='. $card;
  $update = './update.php?card='. $card .'&id='. $id_card;

  verifyLogin($logout);

  if ($card == 'boletos') {

  } else if ($card == 'cheques') {
    $dados = viewCheque($_SESSION['id_user'], $id_card);
  } else if ($card == 'meta') {

  } else if ($card == 'cartoes') {

  } else if ($card == 'investimentos') {

  } else {
    return false;
  }

  define('TITLE', 'VIEW');
  
  include './includes/header.php';
?>

<section id="fade" class="hide"></section>
<section id="modal" class="hide">
  <article>
    <h5 class="<?=$id_card?>">Tem certeza que quer deletar esta cheque?</h5>
  </article>

  <div>
    <button class="button" id="close">Não</button>
    <button class="button" id="delete">Sim</button>
  </div>
</section>

<main class="view">
  <section class="view_container">
    <?php
      include './includes/'. $card .'/card.php';
    ?>

    <div class="view_container_acoes">
      <a class="button" href="<?=$listagem?>">voltar</a>
      <a class="button" href="<?=$update?>">editar</a>
      <button class="button" id="confirm">excluir cheque</button>
    </div>
  </section>
</main>

<?php
  include './includes/footer.php';
?>