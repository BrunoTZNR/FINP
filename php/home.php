<?php
  require './db/conexao.php';

  $css = './../assets/css/style.css';
  $js = '';
  $logout = './logout.php';
  $home = './home.php';
  $perfil = './includes/profile/profile.php';

  verifyLogin($logout);

  define('TITLE', 'HOME');

  // $query = $conn->prepare("SELECT p.nome nome FROM tb_user u 
  //                         JOIN tb_pessoa p ON p.id_pessoa = u.fk_pessoa 
  //                         WHERE id_user = ?");
  // $query->execute([$_SESSION['id_user']]);
  // $result = $query->fetch(PDO::FETCH_ASSOC);

  include './includes/header.php';
?>

<main class="home">
  <section class="home_container">
    <div class="card boleto">
      <h3 class="card_title">boletos</h3>
    </div>

    <div class="card cheque">
      <h3 class="card_title">cheques</h3>
    </div>

    <div class="card meta">
      <h3 class="card_title">metas</h3>
    </div>

    <div class="card cartao">
      <h3 class="card_title">cartões</h3>
    </div>

    <div class="card investimento">
      <h3 class="card_title">investimentos</h3>
    </div>
  </section>
</main>

<?php
  include './includes/footer.php';
?>