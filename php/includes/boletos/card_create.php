<div class="boleto_card">
  <article class="boleto_card_container descricao">
    <h4 class="card_title_view">Descrição</h4>
    <input type="text" name="descricao" <?php if (isset($alert) && $alert == 'null') echo 'value="'. $_POST['descricao'] .'"' ?>>
  </article>

  <article class="boleto_card_container data">
    <h4 class="card_title_view">Data</h4>
    <input type="date" name="data" <?php if (isset($alert) && $alert == 'null') echo 'value="'. $_POST['data'] .'"' ?>>
  </article>

  <article class="boleto_card_container obs">
    <h4 class="card_title_view">Observações</h4>
    <textarea name="obs" class="card_text_view"><?php if (isset($alert) && $alert == 'null') echo $_POST['obs'] ?></textarea>
  </article>

  <article class="boleto_card_container status">
    <h4 class="card_title_view">Status</h4>
    <p class="card_text_view">Automático</p>
  </article>

  <article class="boleto_card_container valor">
    <h4 class="card_title_view">valor</h4>
    <span class="mascara_valor">R$</span>
    <input class="mascara_valor_text" type="text" name="valor" <?php if (isset($alert) && $alert == 'null') echo 'value="'. $_POST['valor'] .'"' ?>>
  </article>

  <article class="boleto_card_container cod_barra">
    <h4 class="card_title_view">Código de barras</h4>
    <input type="text" name="cod_barra" <?php if (isset($alert) && $alert == 'null') echo 'value="'. $_POST['cod_barra'] .'"' ?>>
  </article>

  <article class="boleto_card_container pagamento">
    <h4 class="card_title_view">Pagamento</h4>
    <p class='card_text_view'>Sem pagamento cadastrado</p>
  </article>
</div>