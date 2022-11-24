<div class="cheque_card">
  <article class="cheque_card_container descricao">
    <h4 class="cheque_title">Descrição</h4>
    <p class="cheque_text"><?=$dados['descricao']?></p>
  </article>

  <article class="cheque_card_container valor">
    <h4 class="cheque_title">valor</h4>
    <p class="cheque_text"><span>R$</span> <?=$dados['valor']?></p>
  </article>

  <article class="cheque_card_container data">
    <h4 class="cheque_title">Data</h4>
    <p class="cheque_text"><?=$dados['dt']?></p>
  </article>

  <article class="cheque_card_container remetente">
    <h4 class="cheque_title">Remente</h4>
    <p class="cheque_text"><?=$dados['remetente']?></p>
  </article>

  <article class="cheque_card_container tipo">
    <h4 class="cheque_title">Tipo</h4>
    <p class="cheque_text"><?=$dados['status']?></p>
  </article>
</div>