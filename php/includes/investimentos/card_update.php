<div class="investimento_card">
  <article class="investimento_card_container nome">
    <h4 class="card_title_view">Nome</h4>
    <input type="text" name="nome" value="<?=$dados['nome']?>">
  </article>

  <article class="investimento_card_container nm_instituicao">
    <h4 class="card_title_view">Instituição</h4>
    <select name="instituicao">
    <?php
      $query = $conn->prepare("SELECT * FROM tb_instituicao");
      $query->execute();
          
      // MOSTRA OS ESTADOS
      if($query->rowCount() > 0){
        while($x = $query->fetch(PDO::FETCH_ASSOC)){
          if($dados['nm_instituicao'] == $x['nm_instituicao']) {
            echo '<option value="'.$x['id_instituicao'].'" selected>'.$x['nm_instituicao'].'</option>';
          } else {
            echo '<option value="'.$x['id_instituicao'].'">'.$x['nm_instituicao'].'</option>';
          }
        }
      }
    ?>
    </select>
  </article>

  <article class="investimento_card_container tipo">
    <h4 class="card_title_view">Tipo</h4>
    <select name="tipo">
      <option value="tesouro_direto" <?php if($dados['tipo'] == 'Tesouro Direto') echo 'selected' ?>>Tesouro Direto</option>
      <option value="fundos" <?php if($dados['tipo'] == 'Fundos') echo 'selected' ?>>Fundos</option>
      <option value="renda_fixa" <?php if($dados['tipo'] == 'Renda Fixa') echo 'selected' ?>>Renda Fixa</option>
      <option value="renda_variavel" <?php if($dados['tipo'] == 'Renda Variável') echo 'selected' ?>>Renda Variável</option>
      <option value="poupanca" <?php if($dados['tipo'] == 'Poupança') echo 'selected' ?>>Poupança</option>
      <option value="previdencia_privada" <?php if($dados['tipo'] == 'Previdência Privada') echo 'selected' ?>>Previdência Privada</option>
      <option value="coe" <?php if($dados['tipo'] == 'COE') echo 'selected' ?>>COE</option>
      <option value="oferta_publica" <?php if($dados['tipo'] == 'Oferta Pública') echo 'selected' ?>>Oferta Pública</option>
      <option value="produtos_estruturados" <?php if($dados['tipo'] == 'Produtos Estruturados') echo 'selected' ?>>Produtos Estruturados</option>
    </select>
  </article>

  <article class="investimento_card_container tipo_rentabilidade">
    <h4 class="card_title_view">Tipo rentabilidade</h4>
    <select name="tipo_rentabilidade">
      <option value="A.m." <?php if($dados['tipo_rentabilidade'] == 'A.m.') echo 'selected' ?>>Ao mês</option>
      <option value="A.s." <?php if($dados['tipo_rentabilidade'] == 'A.s.') echo 'selected' ?>>Semestral</option>
      <option value="A.t." <?php if($dados['tipo_rentabilidade'] == 'A.t.') echo 'selected' ?>>Trimestral</option>
      <option value="A.a." <?php if($dados['tipo_rentabilidade'] == 'A.a.') echo 'selected' ?>>Ao ano</option>
    </select>
  </article>

  <article class="investimento_card_container valor_rentabilidade">
    <h4 class="card_title_view">Rentabilidade</h4>
    <input type="text" name="valor_rentabilidade" value="<?=$dados['valor_rentabilidade']?>">
  </article>

  <article class="investimento_card_container dt_investimento">
    <h4 class="card_title_view">Data do investimento</h4>
    <input type="date" name="dt_investimento" value="<?=date('Y-m-d', strtotime($dados['dt_investimento']))?>">
  </article>

  <article class="investimento_card_container dt_vencimento">
    <h4 class="card_title_view">Data do vencimento</h4>
    <input type="date" name="dt_vencimento" value="<?=date('Y-m-d', strtotime($dados['dt_vencimento']))?>">
  </article>

  <article class="investimento_card_container status">
    <h4 class="card_title_view">Status</h4>
    <p class="card_text_view"><?=$dados['status']?></p>
  </article>

  <article class="investimento_card_container qtd_cota">
    <h4 class="card_title_view">Quantidade de cotas</h4>
    <input type="text" name="qtd_cota" value="<?=$dados['qtd_cota']?>">
  </article>

  <article class="investimento_card_container valor_cota">
    <h4 class="card_title_view">Valor unidade cota</h4>
    <span class="mascara_valor">R$</span>
    <input class="mascara_valor_text" type="text" name="valor_cota" value="<?=$dados['valor_cota']?>">
  </article>

  <article class="investimento_card_container valor_total">
    <h4 class="card_title_view">Valor investido</h4>
    <p class="card_text_view"><span>R$</span> <?=$dados['valor_total']?></p>
  </article>
</div>