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
  $cheque = contentCheque($_SESSION['id_user']);

  include './includes/header.php';
?>

<main class="home">
  <section class="home_container">
    <div class="card boleto">
      <h3 class="card_title">Boletos <a style="margin-left: 2rem;" href="./listagem.php?card=boletos">ver</a></h3>
    </div>

    <div class="card cheque">
      <h3 class="card_title">Cheques <a style="margin-left: 2rem;" href="./listagem.php?card=cheques">ver</a></h3>

      <div class="cheque_container">
        <div class="card_container_content">
          <p class="card_text_valor">Enviados</p>
          <p class="card_qtd_valor"><span>R$</span> <?=formatValores($cheque['enviados'])?></p>
        </div>

        <div class="card_container_content">
          <p class="card_text_valor">Recebidos</p>
          <p class="card_qtd_valor"><span>R$</span> <?=formatValores($cheque['recebidos'])?></p>
        </div>
      </div>
    </div>

    <div class="card meta">
      <h3 class="card_title">Metas <a style="margin-left: 2rem;" href="./listagem.php?card=metas">ver</a></h3>

      <section class="meta_carrosel">
        <div class="meta_carrosel_limit">
        <?php
          if (!empty($meta)) {
            for($j = 0; $j < sizeof($meta); $j++){
              echo '<div class="meta_content">
                      <div class="meta_header">
                        <p class="progressao_title">'. $meta[$j]['nome'] .'</p>
                        <div class="progressao_container">
                          <span class="progressao_container_percent">'. formatValores($meta[$j]['percent']) .'%</span>
                          <div style="height: '. $meta[$j]['percent'] .'%;" class="progressao_container_content"></div>
                        </div>
                      </div>
  
                      <div class="meta_main">
                        <div class="card_container_content">
                          <p class="card_text_valor">Valor Atual</p>
                          <p class="card_qtd_valor"><span>R$</span> '. formatValores($meta[$j]['valor_atual']) .'</p>
                        </div>
  
                        <div class="card_container_content">
                          <p class="card_text_valor">Valor a alcançar</p>
                          <p class="card_qtd_valor"><span>R$</span> '. formatValores($meta[$j]['valor_total']) .'</p>
                        </div>
                      </div>
                    </div>';
            }
          } else {
            echo '<div class="meta_content meta_null">
                    <p class="meta_null_text">Sem metas cadastradas!</p>
                  </div>';
          }
        ?>
        </div>
      </section>

      <div class="meta_acoes">
        <span class="button e">E</span>
        <span class="button d">D</span>
      </div>
    </div>

    <div class="card cartao">
      <h3 class="card_title">Cartões <a style="margin-left: 2rem;" href="./listagem.php?card=cartoes">ver</a></h3>
    </div>

    <div class="card investimento">
      <h3 class="card_title">Investimentos <a style="margin-left: 2rem;" href="./listagem.php?card=investimentos">ver</a></h3>
    </div>
  </section>
</main>

<?php
  include './includes/footer.php';
?>