<div class="meta_card">
  <article class="meta_card_container nome">
    <h4 class="card_title_view">Nome</h4>
    <input type="text" name="nome" <?php if (isset($alert) && $alert == 'null') echo 'value="'. $_POST['nome'] .'"' ?>>
  </article>

  <article class="meta_card_container status">
    <h4 class="card_title_view">Status</h4>
    <p class="card_text_view">Automático</p>
  </article>

  <article class="meta_card_container descricao">
    <h4 class="card_title_view">Descrição</h4>
    <textarea name="descricao" class="card_text_view"><?php if (isset($alert) && $alert == 'null') echo $_POST['descricao'] ?></textarea>
  </article>

  <article class="meta_card_container dt_inicio">
    <h4 class="card_title_view">Data início</h4>
    <input type="date" name="dt_inicio" <?php if (isset($alert) && $alert == 'null') echo 'value="'. $_POST['dt_inicio'] .'"' ?>>
  </article>

  <article class="meta_card_container valor_inicial">
    <h4 class="card_title_view">Valor inicial</h4>
    <span class="mascara_valor">R$</span>
    <input class="mascara_valor_text" type="text" name="valor_inicial" <?php if (isset($alert) && $alert == 'null') echo 'value="'. $_POST['valor_inicial'] .'"' ?>>
  </article>

  <article class="meta_card_container valor_adicoes">
    <h4 class="card_title_view">Valor adições</h4>
    <p class="card_text_view">Automático</p>
  </article>

  <article class="meta_card_container dt_fim">
    <h4 class="card_title_view">Data fim</h4>
    <input type="date" name="dt_fim" <?php if (isset($alert) && $alert == 'null') echo 'value="'. $_POST['dt_fim'] .'"' ?>>
  </article>

  <article class="meta_card_container valor_pretendido">
    <h4 class="card_title_view">Valor pretendido</h4>
    <span class="mascara_valor">R$</span>
    <input class="mascara_valor_text" type="text" name="valor_pretendido" <?php if (isset($alert) && $alert == 'null') echo 'value="'. $_POST['valor_pretendido'] .'"' ?>>
  </article>

  <article class="meta_card_container valor_atual">
    <h4 class="card_title_view">Valor Atual</h4>
    <p class="card_text_view">Automático</p>
  </article>

  <article class="meta_card_container add">
    <h4 class="card_title_view">Adições</h4>
    <p class="card_text_view">Sem adições cadastradas</p>
  </article>
</div>