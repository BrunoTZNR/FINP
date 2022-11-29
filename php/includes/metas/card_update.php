<div class="meta_card">
  <article class="meta_card_container nome">
    <h4 class="card_title_view">Nome</h4>
    <input type="text" name="nome" value="<?=$dados[0]['nome']?>">
  </article>

  <article class="meta_card_container status">
    <h4 class="card_title_view">Status</h4>
    <p class="card_text_view"><?=$dados[0]['status']?></p>
  </article>

  <article class="meta_card_container descricao">
    <h4 class="card_title_view">Descrição</h4>
    <textarea name="descricao" class="card_text_view"><?=$dados[0]['descricao']?></textarea>
  </article>

  <article class="meta_card_container dt_inicio">
    <h4 class="card_title_view">Data início</h4>
    <input type="date" name="dt_inicio" value="<?=date('Y-m-d', strtotime($dados[0]['dt_inicio']))?>">
  </article>

  <article class="meta_card_container valor_inicial">
    <h4 class="card_title_view">Valor inicial</h4>
    <span class="mascara_valor">R$</span>
    <input class="mascara_valor_text" type="text" name="valor_inicial" value="<?=$dados[0]['valor_inicial']?>">
  </article>

  <article class="meta_card_container valor_adicoes">
    <h4 class="card_title_view">Valor adições</h4>
    <p class="card_text_view"><span>R$</span> <?=$dados[0]['valor_adicoes']?></p>
  </article>

  <article class="meta_card_container dt_fim">
    <h4 class="card_title_view">Data fim</h4>
    <input type="date" name="dt_fim" value="<?=date('Y-m-d', strtotime($dados[0]['dt_fim']))?>">
  </article>

  <article class="meta_card_container valor_pretendido">
    <h4 class="card_title_view">Valor pretendido</h4>
    <span class="mascara_valor">R$</span>
    <input class="mascara_valor_text" type="text" name="valor_pretendido" value="<?=$dados[0]['valor_pretendido']?>">
  </article>

  <article class="meta_card_container valor_atual">
    <h4 class="card_title_view">Valor Atual</h4>
    <p class="card_text_view"><span>R$</span> <?=$dados[0]['valor_atual']?></p>
  </article>

  <article class="meta_card_container add">
    <h4 class="card_title_view">Adições</h4>
    <?php
    if (isset($dados[1]['null'])) {
      echo '<p class="card_text_view">Sem adições cadastradas</p>';
    } else {
      for($k = 0; $k < sizeof($dados[1]); $k++) {
        echo '<p class="card_text_view add_meta">'. $dados[1][$k]['dt'] .' - '. $dados[1][$k]['valor'] .'</p>';
      }
    }
    ?>
  </article>
</div>