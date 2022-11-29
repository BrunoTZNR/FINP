<div class="boleto_card">
  <article class="boleto_card_container descricao">
    <h4 class="card_title_view">Descrição</h4>
    <input type="text" name="descricao" value="<?=$dados['descricao']?>">
  </article>

  <article class="boleto_card_container data">
    <h4 class="card_title_view">Data</h4>
    <input type="date" name="data" value="<?=date('Y-m-d', strtotime($dados['dt_vencimento']))?>">
  </article>

  <article class="boleto_card_container obs">
    <h4 class="card_title_view">Observações</h4>
    <textarea class="card_text_view"><?=$dados['obs']?></textarea>
  </article>

  <article class="boleto_card_container status">
    <h4 class="card_title_view">Status</h4>
    <p class="card_text_view"><?=$dados['status']?></p>
  </article>

  <article class="boleto_card_container valor">
    <h4 class="card_title_view">valor</h4>
    <span class="mascara_valor">R$</span>
    <input class="mascara_valor_text" type="text" name="valor" value="<?=$dados['valor']?>">
  </article>

  <article class="boleto_card_container cod_barra">
    <h4 class="card_title_view">Código de barras</h4>
    <input type="text" name="cod_barra" value="<?=$dados['cod_barra']?>">
  </article>

  <article class="boleto_card_container pagamento">
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