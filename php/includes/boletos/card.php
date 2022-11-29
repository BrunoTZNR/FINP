<div class="boleto_card">
  <article class="boleto_card_container descricao">
    <h4 class="card_title_view">Descrição</h4>
    <p class="card_text_view"><?=$dados['descricao']?></p>
  </article>

  <article class="boleto_card_container data">
    <h4 class="card_title_view">Data</h4>
    <p class="card_text_view"><?=$dados['dt_vencimento']?></p>
  </article>

  <article class="boleto_card_container obs">
    <h4 class="card_title_view">Observações</h4>
    <textarea class="card_text_view" disabled><?=$dados['obs']?></textarea>
  </article>

  <article class="boleto_card_container status">
    <h4 class="card_title_view">Status</h4>
    <p class="card_text_view"><?=$dados['status']?></p>
  </article>

  <article class="boleto_card_container valor">
    <h4 class="card_title_view">valor</h4>
    <p class="card_text_view"><span>R$</span> <?=$dados['valor']?></p>
  </article>

  <article class="boleto_card_container cod_barra">
    <h4 class="card_title_view">Código de barras</h4>
    <p class="card_text_view"><?=$dados['cod_barra']?></p>
  </article>

  <article class="boleto_card_container pagamento">
    <h4 class="card_title_view">Pagamento</h4>
    <?php
    if ($dados['valor_pg'] == '0,00') {
      echo "<a href='#cadastrar_pagamento' class='card_text_view'>Cadastrar pagamento</a>";
    } else {
      echo "<p class='card_text_view'><span>R$</span> {$dados['valor_pg']}</p>";
    }
    ?>
  </article>
</div>