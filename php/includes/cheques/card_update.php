<div class="cheque_card">
  <article class="cheque_card_container descricao">
    <h4 class="cheque_title">Descrição</h4>
    <textarea name="descricao"><?=$dados['descricao']?></textarea>
  </article>

  <article class="cheque_card_container valor">
    <h4 class="cheque_title">valor</h4>
    <input class="mascara" type="text" name="valor" value="<?=$dados['valor']?>">
  </article>

  <article class="cheque_card_container data">
    <h4 class="cheque_title">Data</h4>
    <input type="date" name="dt" value="<?=$dados['dt']?>">
  </article>

  <article class="cheque_card_container remetente">
    <h4 class="cheque_title">Remente</h4>
    <input type="text" name="remetente" value="<?=$dados['remetente']?>">
  </article>

  <article class="cheque_card_container tipo">
    <h4 class="cheque_title">Tipo</h4>
    <input type="text" name="tipo" value="<?=$dados['status']?>">
  </article>
</div>