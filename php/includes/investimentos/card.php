<div class="investimento_card">
  <article class="investimento_card_container nome">
    <h4 class="card_title_view">Nome</h4>
    <p class="card_text_view"><?=$dados['nome']?></p>
  </article>

  <article class="investimento_card_container nm_instituicao">
    <h4 class="card_title_view">Instituição</h4>
    <p class="card_text_view"><?=$dados['nm_instituicao']?></p>
  </article>

  <article class="investimento_card_container tipo">
    <h4 class="card_title_view">Tipo</h4>
    <p class="card_text_view"><?=$dados['tipo']?></p>
  </article>

  <article class="investimento_card_container tipo_rentabilidade">
    <h4 class="card_title_view">Tipo rentabilidade</h4>
    <p class="card_text_view"><?=$dados['tipo_rentabilidade']?></p>
  </article>

  <article class="investimento_card_container valor_rentabilidade">
    <h4 class="card_title_view">Rentabilidade</h4>
    <p class="card_text_view"><?=$dados['valor_rentabilidade']?></p>
  </article>

  <article class="investimento_card_container dt_investimento">
    <h4 class="card_title_view">Data do investimento</h4>
    <p class="card_text_view"><?=date('d/m/Y', strtotime($dados['dt_investimento']))?></p>
  </article>

  <article class="investimento_card_container dt_vencimento">
    <h4 class="card_title_view">Data do vencimento</h4>
    <p class="card_text_view"><?=date('d/m/Y', strtotime($dados['dt_vencimento']))?></p>
  </article>

  <article class="investimento_card_container status">
    <h4 class="card_title_view">Status</h4>
    <p class="card_text_view"><?=$dados['status']?></p>
  </article>

  <article class="investimento_card_container qtd_cota">
    <h4 class="card_title_view">Quantidade de cotas</h4>
    <p class="card_text_view"><?=$dados['qtd_cota']?></p>
  </article>

  <article class="investimento_card_container valor_cota">
    <h4 class="card_title_view">Valor unidade cota</h4>
    <p class="card_text_view"><span>R$</span> <?=$dados['valor_cota']?></p>
  </article>

  <article class="investimento_card_container valor_total">
    <h4 class="card_title_view">Valor investido</h4>
    <p class="card_text_view"><span>R$</span> <?=$dados['valor_total']?></p>
  </article>
</div>