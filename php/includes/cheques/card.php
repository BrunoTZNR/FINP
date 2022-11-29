<div class="cheque_card">
  <article class="cheque_card_container descricao">
    <h4 class="card_title_view">Descrição</h4>
    <textarea class="card_text_view" disabled><?=$dados['descricao']?></textarea>
  </article>

  <article class="cheque_card_container instuicao">
    <h4 class="card_title_view">Instituição</h4>
    <p class="card_text_view"><?=$dados['nm_instituicao']?></p>
  </article>

  <article class="cheque_card_container valor">
    <h4 class="card_title_view">valor</h4>
    <p class="card_text_view"><span>R$</span> <?=$dados['valor']?></p>
  </article>

  <article class="cheque_card_container data">
    <h4 class="card_title_view">Data</h4>
    <p class="card_text_view"><?=$dados['dt']?></p>
  </article>

  <article class="cheque_card_container remetente">
    <h4 class="card_title_view">Remente</h4>
    <p class="card_text_view"><?=$dados['remetente']?></p>
  </article>

  <article class="cheque_card_container tipo">
    <h4 class="card_title_view">Tipo</h4>
    <p class="card_text_view"><?=$dados['status']?></p>
  </article>
</div>