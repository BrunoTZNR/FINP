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
  $delete = './delete.php?card='. $card .'&id='. $id_card;

  verifyLogin($logout);

  if ($card == 'boletos') {
    $dados = viewBoleto($_SESSION['id_user'], $id_card);
  } else if ($card == 'cheques') {
    $dados = viewCheque($_SESSION['id_user'], $id_card);
  } else if ($card == 'metas') {
    $dados = viewMeta($_SESSION['id_user'], $id_card);
  } else if ($card == 'cartoes') {
    $dados = viewCartao($_SESSION['id_user'], $id_card);
  } else if ($card == 'investimentos') {
    $dados = viewInvestimento($_SESSION['id_user'], $id_card);
  } else {
    return 'oi';
  }

  define('ALERT', true);
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
    <a href="<?=$delete?>" class="button" id="delete">Sim</a>
  </div>
</section>

<section class="alert">
  <p class="alert_text"><?php if (isset($_GET['alert'])) echo messageAlert(clean($_GET['alert'])) ?></p>
</section>

<main class="view">
  <section class="view_container">
    <?php
      include './includes/'. $card .'/card.php';
    ?>

    <div class="view_container_acoes">
      <a class="button" href="<?=$listagem?>">voltar</a>
      <a class="button" href="<?=$update?>">editar</a>
      <button class="button" id="confirm">excluir</button>
    </div>
  </section>
</main>

<?php
  include './includes/footer.php';
?>