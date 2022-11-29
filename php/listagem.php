<?php
  require './db/conexao.php';

  $css = './../assets/css/style.css';
  $js = '<script src="./../assets/js/listagem.js" defer></script>';
  $logout = './logout.php';
  $home = './home.php';
  $perfil = './includes/profile/profile.php';

  verifyLogin($logout);

  define('ALERT', true);
  define('TITLE', 'LISTAGEM');

  $tipo = $_GET['card'];
  $table = tableContent($_SESSION['id_user'], $tipo);

  include './includes/header.php';
?>

<section class="alert">
  <p class="alert_text"><?php if (isset($_GET['alert'])) echo messageAlert(clean($_GET['alert'])) ?></p>
</section>

<main class="listagem">
  <section class="listagem_container">
    <header class="listagem_container_header">
      <h1 class="listagem_title"><?=$tipo?></h1>

      <div class="listagem_container_header_acoes">
        <a class="button" href="./create.php?card=<?=$tipo?>">cadastrar</a>

        <form method="post">
          <input class="search" type="text" name="search" value="<?php if(isset($search)) echo str_replace('%','',$search);?>">
          <i class="fa-solid fa-magnifying-glass"></i>
        </form>
      </div>
    </header>

    <div class="listagem_container_table">
      <table>
        <thead>
          <?=$table[0]?>
        </thead>
        <tbody>
          <?=$table[1]?>
        </tbody>
      </table>
    </div>
  </section>
</main>

<?php
  include './includes/footer.php';
?>