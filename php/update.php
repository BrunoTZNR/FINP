<?php
  require './db/conexao.php';

  $card = $_GET['card'];
  $id_card = $_GET['id'];

  $css = './../assets/css/style.css';
  $js = '<script src="./../assets/js/card_update.js" defer></script>';
  $logout = './logout.php';
  $home = './home.php';
  $perfil = './includes/profile/profile.php';
  $view = './view.php?card='. $card .'&id='. $id_card;

  verifyLogin($logout);

  define('ALERT', true);
  define('TITLE', 'CARD - UPDATE');

  include './includes/header.php';

  switch ($card) {
    case 'boletos':
      $dados = viewBoleto($_SESSION['id_user'], $id_card);
      break;
    case 'cheques':
      $dados = viewCheque($_SESSION['id_user'], $id_card);
      break;
    case 'metas':
      $dados = viewMeta($_SESSION['id_user'], $id_card);
      break;
    case 'cartoes':
      $dados = viewCartao($_SESSION['id_user'], $id_card);
      break;
    case 'investimentos':
      $dados = viewInvestimento($_SESSION['id_user'], $id_card);
      break;
    default:
      echo 'oi dnv';
      break;
  }

  if (isset($_POST['alterar_boletos'])) {
    
  } else if (isset($_POST['alterar_cheques'])) {
    if (empty($_POST['descricao']) || empty($_POST['valor']) || empty($_POST['dt']) || empty($_POST['remetente']) || empty($_POST['fk_status'])) {
      $alert = 'null';
    } else {
      $fields = [
        'descricao' => $_POST['descricao'],
        'valor' => $_POST['valor'],
        'dt' => $_POST['dt'],
        'remetente' => $_POST['remetente'],
        'fk_status' => $_POST['fk_status'],
        'instituicao' => $_POST['instituicao']
      ];

      $return = updateCheque($_SESSION['id_user'], $id_card, $fields);

      header("Location: ./view.php?card=$card&id=$id_card&$return");
    }
  } else if (isset($_POST['alterar_metas'])) {
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
        'valor_atual' => str_replace(',', '.', str_replace('.', '', $dados[0]['valor_atual']))
      ];

      $return = updateMeta($_SESSION['id_user'], $id_card, $fields);

      header("Location: ./view.php?card=$card&id=$id_card&$return");
    }
  } else if (isset($_POST['alterar_cartoes'])) {
    
  } else if (isset($_POST['alterar_investimentos'])) {
    if (empty($_POST['nome']) || empty($_POST['instituicao']) || empty($_POST['tipo']) || empty($_POST['tipo_rentabilidade']) || empty($_POST['valor_rentabilidade']) 
    || empty($_POST['dt_investimento']) || empty($_POST['dt_vencimento']) || empty($_POST['qtd_cota']) || empty($_POST['valor_cota'])) {
      $alert = 'null';
    } else {
      $fields = [
        'nome' => $_POST['nome'],
        'instituicao' => $_POST['instituicao'],
        'tipo' => $_POST['tipo'],
        'tipo_rentabilidade' => $_POST['tipo_rentabilidade'],
        'valor_rentabilidade' => $_POST['valor_rentabilidade'],
        'dt_investimento' => $_POST['dt_investimento'],
        'dt_vencimento' => $_POST['dt_vencimento'],
        'qtd_cota' => $_POST['qtd_cota'],
        'valor_cota' => $_POST['valor_cota']
      ];

      $return = updateInvestimento($_SESSION['id_user'], $id_card, $fields);

      header("Location: ./view.php?card=$card&id=$id_card&$return");
    }
  }
?>

<section class="alert">
  <p class="alert_text"><?php if (isset($alert)) echo messageAlert($alert) ?></p>
</section>

<main class="update">
  <form class="update_container" method="post">
    <?php
      include './includes/'. $card .'/card_update.php';
    ?>

    <div class="update_container_acoes">
      <a class="button" href="<?=$view?>">voltar</a>
      <button class="button" type="submit" name="alterar_<?=$card?>">salvar</button>
    </div>
  </form>
</main>

<?php
  include './includes/footer.php';
?>