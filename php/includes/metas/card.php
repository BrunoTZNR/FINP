<div class="meta_card">
  <article class="meta_card_container nome">
    <h4 class="card_title_view">Nome</h4>
    <p class="card_text_view"><?=$dados[0]['nome']?></p>
  </article>

  <article class="meta_card_container status">
    <h4 class="card_title_view">Status</h4>
    <p class="card_text_view"><?=$dados[0]['status']?></p>
  </article>

  <article class="meta_card_container descricao">
    <h4 class="card_title_view">Descrição</h4>
    <textarea class="card_text_view" disabled><?=$dados[0]['descricao']?></textarea>
  </article>

  <article class="meta_card_container dt_inicio">
    <h4 class="card_title_view">Data início</h4>
    <p class="card_text_view"><?=$dados[0]['dt_inicio']?></p>
  </article>

  <article class="meta_card_container valor_inicial">
    <h4 class="card_title_view">Valor inicial</h4>
    <p class="card_text_view"><span>R$</span> <?=$dados[0]['valor_inicial']?></p>
  </article>

  <article class="meta_card_container valor_adicoes">
    <h4 class="card_title_view">Valor adições</h4>
    <p class="card_text_view"><span>R$</span> <?=$dados[0]['valor_adicoes']?></p>
  </article>

  <article class="meta_card_container dt_fim">
    <h4 class="card_title_view">Data fim</h4>
    <p class="card_text_view"><?=$dados[0]['dt_fim']?></p>
  </article>

  <article class="meta_card_container valor_pretendido">
    <h4 class="card_title_view">Valor pretendido</h4>
    <p class="card_text_view"><span>R$</span> <?=$dados[0]['valor_pretendido']?></p>
  </article>

  <article class="meta_card_container valor_atual">
    <h4 class="card_title_view">Valor Atual</h4>
    <p class="card_text_view"><span>R$</span> <?=$dados[0]['valor_atual']?></p>
  </article>

  <article class="meta_card_container add">
    <h4 class="card_title_view">Adições</h4>
    <?php
    if (isset($dados[1]['null'])) {
      echo '<a href="./includes/add_meta/create_add.php?id='. $id_card .'" class="card_text_view">Cadastrar adição</a>';
    } else {
      for($k = 0; $k < sizeof($dados[1]); $k++) {
        echo '<a href="./includes/add_meta/view_add.php?id='. $dados[1][$k]['id_add_meta'] .'" class="card_text_view add_meta">'. $dados[1][$k]['dt'] .' - '. $dados[1][$k]['valor'] .'</a>';
      }
    }
    ?>
  </article>
</div>