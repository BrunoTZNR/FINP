<div class="cartao_card">
  <article class="cartao_card_container nome">
    <h4 class="card_title_view">Nome</h4>
    <input type="text" name="nome" <?php if (isset($alert) && $alert == 'null') echo 'value="'. $_POST['nome'] .'"' ?>>
  </article>

  <article class="cartao_card_container data">
    <h4 class="card_title_view">Data</h4>
    <input type="date" name="data" <?php if (isset($alert) && $alert == 'null') echo 'value="'. $_POST['data'] .'"' ?>>
  </article>

  <article class="cartao_card_container status">
    <h4 class="card_title_view">Status</h4>
    <p class="card_text_view">Automático</p>
  </article>

  <article class="cartao_card_container valor">
    <h4 class="card_title_view">valor</h4>
    <span class="mascara_valor">R$</span>
    <input type="text" name="valor" <?php if (isset($alert) && $alert == 'null') echo 'value="'. $_POST['valor'] .'"' ?>>
  </article>

  <article class="cartao_card_container pagamento">
    <h4 class="card_title_view">Pagamento</h4>
    <p class='card_text_view'>Sem pagamento cadastrado</p>
  </article>
</div>