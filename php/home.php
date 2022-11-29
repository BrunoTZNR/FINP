<?php
  require './db/conexao.php';

  $css = './../assets/css/style.css';
  $js = '<script src="./../assets/js/home.js" defer></script>';
  $logout = './logout.php';
  $home = './home.php';
  $perfil = './includes/profile/profile.php';

  verifyLogin($logout);

  define('ALERT', false);
  define('TITLE', 'HOME');

  $boleto = contentBoleto($_SESSION['id_user']);
  $cheque = contentCheque($_SESSION['id_user']);
  $meta = contentMeta($_SESSION['id_user']);
  $cartao = contentCartao($_SESSION['id_user']);
  $investimento = contentInvestimento($_SESSION['id_user']);


  include './includes/header.php';
?>

<main class="home">
  <section class="home_container">
    <div class="card boleto">
      <a class="card_title--hover" href="./listagem.php?card=boletos"><h3 class="card_title">Boletos</h3></a>

      <section class="boleto_container">
        <div class="card_container_content boleto_container_content">
          <p class="card_text_valor"><a class="card_redirect" href="#boletos?pagos"></a> Pagos</p>
          <p class="card_qtd_valor"><span>R$</span> <?= formatValores($boleto[0]['valor_total']) ?></p>
        </div>

        <div class="card_container_content boleto_container_content">
          <p class="card_text_valor"><a class="card_redirect" href="#boletos?pendentes"></a> Pendentes</p>
          <p class="card_qtd_valor"><span>R$</span> <?= formatValores($boleto[1]['valor_total']) ?></p>
        </div>

        <div class="card_container_content boleto_container_content">
          <p class="card_text_valor"><a class="card_redirect" href="#boletos?vencidos"></a> Vencidos</p>
          <p class="card_qtd_valor"><span>R$</span> <?= formatValores($boleto[2]['valor_total']) ?></p>
        </div>
      </section>
    </div>

    <div class="card cheque">
      <a class="card_title--hover" href="./listagem.php?card=cheques"><h3 class="card_title">Cheques</h3></a>

      <section class="cheque_container">
        <div class="card_container_content">
          <p class="card_text_valor">Enviados</p>
          <p class="card_qtd_valor"><span>R$</span> <?=formatValores($cheque[0])?></p>
        </div>

        <div class="card_container_content">
          <p class="card_text_valor">Recebidos</p>
          <p class="card_qtd_valor"><span>R$</span> <?=formatValores($cheque[1])?></p>
        </div>
      </section>
    </div>

    <div class="card meta">
      <a class="card_title--hover" href="./listagem.php?card=metas"><h3 class="card_title">Metas</h3></a>

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
      <a class="card_title--hover" href="./listagem.php?card=cartoes"><h3 class="card_title">Cartões</h3></a>

      <section class="cartao_container">
        <div class="card_container_content cartao_container_content">
          <article>
            <h4 class="card_cartao_title">Mês atual</h4>
            <p class="card_cartao_text"><?=$cartao[0]['mes']?></p>

            <p class="card_text_valor card_text_valor--cartao">Valor da fatura</p>
            <p class="card_qtd_valor"><span>R$</span> <?=$cartao[0]['valor']?></p>
          </article>

          <article>
            <h4 class="card_cartao_title">Mês anterior</h4>
            <p class="card_cartao_text"><?=$cartao[1]['mes']?></p>

            <p class="card_text_valor card_text_valor--cartao">Valor da fatura</p>
            <p class="card_qtd_valor"><span>R$</span> <?=$cartao[1]['valor']?></p>
          </article>
        </div>

        <div class="card_container_content">
          <?=$cartao[2]?>
        </div>
      </section>
    </div>

    <div class="card investimento">
    <a class="card_title--hover" href="./listagem.php?card=investimentos"><h3 class="card_title">Investimentos </h3></a>

      <section class="investimento_container">
        <div class="card_container_content investimento_container_content">
          <p class="card_text_valor">Carteira</p>
          <p class="card_qtd_valor"><span>R$</span> <?=$investimento[0]['valor_total']?></p>
          <div class="progressao">
            <?php
            for($h = 0; $h < sizeof($investimento[1]); $h++) {
              echo '<div style="width: '. $investimento[1][$h]['percent'] .'; background-color: var(--color-'. ($h+1) .');"></div>';
            }
            ?>
          </div>
        </div>

        <div class="card_container_content investimento_container_tipos">
          <?php
          if (sizeof($investimento[1]) == 0) {
            echo '<h4 class="card_cartao_title">Não há investimentos cadastrados!</h4>';
          } else {
            for($h = 0; $h < sizeof($investimento[1]); $h++) {
              echo '<span class="investimento_tipo" style="background-color: var(--color-'. ($h+1) .');">'. $investimento[1][$h]['tipo'] .'</span>';
            }
          }
          ?>
        </div>
      </section>
    </div>
  </section>
</main>

<?php
  include './includes/footer.php';
?>