<div class="cartao_card">
  <article class="cartao_card_container nome">
    <h4 class="card_title_view">Nome</h4>
    <p class="card_text_view"><?=$dados['nome']?></p>
  </article>

  <article class="cartao_card_container data">
    <h4 class="card_title_view">Data</h4>
    <p class="card_text_view"><?=$dados['mes_fatura']?></p>
  </article>

  <article class="cartao_card_container status">
    <h4 class="card_title_view">Status</h4>
    <p class="card_text_view"><?=$dados['status']?></p>
  </article>

  <article class="cartao_card_container valor">
    <h4 class="card_title_view">valor</h4>
    <p class="card_text_view"><span>R$</span> <?=$dados['valor']?></p>
  </article>

  <article class="cartao_card_container pagamento">
    <h4 class="card_title_view">Pagamento</h4>
    <?php
    if ($dados['valor_pg'] == '0,00') {
      echo "<a href='./create.php?card=pg&id=". $id_card ."&' class='card_text_view'>Cadastrar pagamento</a>";
    } else {
      echo "<a href='./view.php?card=pg&id_pg=". $dados['fk_pagamento'] ."&id=". $id_card ."' class='card_text_view'><span>R$</span> {$dados['valor_pg']}</a>";
    }
    ?>
  </article>
</div>