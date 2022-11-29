<?php
  require './db/conexao.php';

  $card = $_GET['card'];

  $css = './../assets/css/style.css';
  $js = '<script src="./../assets/js/card_update.js" defer></script>';
  $logout = './logout.php';
  $home = './home.php';
  $perfil = './includes/profile/profile.php';
  $listagem = './listagem.php?card='. $card;

  verifyLogin($logout);

  define('ALERT', true);
  define('TITLE', 'CARD - CREATE');

  include './includes/header.php';

  if (isset($_POST['create_boletos'])) {
    if (empty($_POST['descricao']) || empty($_POST['data']) || empty($_POST['valor'])) {
      $alert = 'null';
    } else {
      $alert = 'create';
      // $fields = [
      //   'descricao' => clean($_POST['descricao']),
      //   'valor' => str_replace(',', '.', str_replace('.', '', clean($_POST['valor']))),
      //   'dt' => clean($_POST['dt']),
      //   'remetente' => clean($_POST['remetente']),
      //   'dt_cadastro' => date('Y-m-d H:i:s'),
      //   'fk_status' => clean($_POST['fk_status']),
      //   'instituicao' => clean($_POST['instituicao'])
      // ];

      // $return = createCheque($_SESSION['id_user'], $fields);

      // header("Location: $listagem&$return");
    }
  } else if (isset($_POST['create_cheques'])) {
    if (empty($_POST['descricao']) || empty($_POST['valor']) || empty($_POST['dt']) || empty($_POST['remetente']) || empty($_POST['fk_status']) || empty($_POST['instituicao'])) {
      $alert = 'null';
    } else {
      $fields = [
        'descricao' => clean($_POST['descricao']),
        'valor' => str_replace(',', '.', str_replace('.', '', clean($_POST['valor']))),
        'dt' => clean($_POST['dt']),
        'remetente' => clean($_POST['remetente']),
        'dt_cadastro' => date('Y-m-d H:i:s'),
        'fk_status' => clean($_POST['fk_status']),
        'instituicao' => clean($_POST['instituicao'])
      ];

      $return = createCheque($_SESSION['id_user'], $fields);

      header("Location: $listagem&$return");
    }
  } else if (isset($_POST['create_metas'])) {
    if (empty($_POST['nome']) || empty($_POST['dt_inicio']) || $_POST['valor_inicial'] == '' || empty($_POST['dt_fim']) || empty($_POST['valor_pretendido'])) {
      $alert = 'null';
    } else {
      $fields = [
        'nome' => clean($_POST['nome']),
        'descricao' => clean($_POST['descricao']),
        'dt_inicio' => clean($_POST['dt_inicio']),
        'dt_fim' => clean($_POST['dt_fim']),
        'valor_inicial' => str_replace(',', '.', str_replace('.', '', clean($_POST['valor_inicial']))),
        'valor_pretendido' => str_replace(',', '.', str_replace('.', '', clean($_POST['valor_pretendido']))),
        'dt_cadastro' => date('Y-m-d H:i:s')
      ];

      $return = createMeta($_SESSION['id_user'], $fields);

      header("Location: $listagem&$return");
    }
  } else if (isset($_POST['create_cartoes'])) {
    if (empty($_POST['nome']) || empty($_POST['valor']) || empty($_POST['data'])) {
      $alert = 'null';
    } else {
      $alert = 'create';
      // $fields = [
      //   'descricao' => clean($_POST['descricao']),
      //   'valor' => str_replace(',', '.', str_replace('.', '', clean($_POST['valor']))),
      //   'dt' => clean($_POST['dt']),
      //   'remetente' => clean($_POST['remetente']),
      //   'dt_cadastro' => date('Y-m-d H:i:s'),
      //   'fk_status' => clean($_POST['fk_status']),
      //   'instituicao' => clean($_POST['instituicao'])
      // ];

      // $return = createCheque($_SESSION['id_user'], $fields);

      // header("Location: $listagem&$return");
    }
  } else if (isset($_POST['create_investimentos'])) {
    if (empty($_POST['nome']) || empty($_POST['instituicao']) || empty($_POST['tipo']) || empty($_POST['tipo_rentabilidade']) || empty($_POST['valor_rentabilidade']) 
    || empty($_POST['dt_investimento']) || empty($_POST['dt_vencimento']) || empty($_POST['qtd_cota']) || empty($_POST['valor_cota'])) {
      $alert = 'null';
    } else {
      $fields = [
        'nome' => clean($_POST['nome']),
        'tipo' => clean($_POST['tipo']),
        'dt_investimento' => clean($_POST['dt_investimento']),
        'dt_vencimento' => clean($_POST['dt_vencimento']),
        'qtd_cota' => clean($_POST['qtd_cota']),
        'valor_cota' => str_replace(',', '.', str_replace('.', '', clean($_POST['valor_cota']))),
        'tipo_rentabilidade' => clean($_POST['tipo_rentabilidade']),
        'valor_rentabilidade' => str_replace(',', '.', clean($_POST['valor_rentabilidade'])),
        'dt_cadastro' => date('Y-m-d H:i:s'),
        'instituicao' => clean($_POST['instituicao'])
      ];

      $return = createInvestimento($_SESSION['id_user'], $fields);

      header("Location: $listagem&$return");
    }
  }
?>

<section class="alert">
  <p class="alert_text"><?php if (isset($alert)) echo messageAlert($alert) ?></p>
</section>

<main class="update">
  <form class="update_container" method="post">
    <?php
      include './includes/'. $card .'/card_create.php';
    ?>

    <div class="update_container_acoes">
      <a class="button" href="<?=$listagem?>">voltar</a>
      <button class="button" type="submit" name="create_<?=$card?>">cadastrar</button>
    </div>
  </form>
</main>

<?php
  include './includes/footer.php';
?>