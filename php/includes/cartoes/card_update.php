<div class="cartao_card">
  <article class="cartao_card_container nome">
    <h4 class="card_title_view">Nome</h4>
    <input type="text" name="nome" value="<?=$dados['nome']?>">
  </article>

  <article class="cartao_card_container data">
    <h4 class="card_title_view">Data</h4>
    <input type="date" name="data" value="<?=date('Y-m-d', strtotime($dados['mes_fatura']))?>">
  </article>

  <article class="cartao_card_container status">
    <h4 class="card_title_view">Status</h4>
    <p class="card_text_view"><?=$dados['status']?></p>
  </article>

  <article class="cartao_card_container valor">
    <h4 class="card_title_view">valor</h4>
    <span class="mascara_valor">R$</span>
    <input type="text" name="valor" value="<?=$dados['valor']?>">
  </article>

  <article class="cartao_card_container pagamento">
    <h4 class="card_title_view">Pagamento</h4>
    <?php
    if ($dados['valor_pg'] == '0,00') {
      echo "<p class='card_text_view'>Sem pagamento cadastrado</p>";
    } else {
      echo "<p class='card_text_view'><span>R$</span> {$dados['valor_pg']}</p>";
    }
    ?>
  </article>
</div>