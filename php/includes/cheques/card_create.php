<div class="cheque_card">
  <article class="cheque_card_container remetente">
    <h4 class="card_title_view">Remente</h4>
    <input type="text" name="remetente" <?php if (isset($alert) == 'null') echo 'value="'. $_POST['remetente'] .'"' ?>>
  </article>

  <article class="cheque_card_container instituicao">
    <h4 class="card_title_view">Instituição</h4>
    <select name="instituicao">
    <?php
      $query = $conn->prepare("SELECT * FROM tb_instituicao");
      $query->execute();
          
      // MOSTRA OS ESTADOS
      if($query->rowCount() > 0){
        while($x = $query->fetch(PDO::FETCH_ASSOC)){
          if (isset($alert) == 'null') {
            if ($_POST['instituicao'] == $x['id_instituicao']) {
              echo '<option value="'.$x['id_instituicao'].'" selected>'.$x['nm_instituicao'].'</option>';
            } else {
              echo '<option value="'.$x['id_instituicao'].'">'.$x['nm_instituicao'].'</option>';
            }
          } else {
            echo '<option value="'.$x['id_instituicao'].'">'.$x['nm_instituicao'].'</option>';
          }
        }
      }
    ?>
    </select>
  </article>

  <article class="cheque_card_container descricao">
    <h4 class="card_title_view">Descrição</h4>
    <textarea name="descricao"><?php if (isset($alert) == 'null') echo $_POST['descricao'] ?></textarea>
  </article>

  <article class="cheque_card_container tipo">
    <h4 class="card_title_view">Tipo</h4>
    <select name="fk_status">
      <option value="8" <?php if (isset($alert) == 'null' && $_POST['fk_status'] == '8') echo 'selected' ?>>Enviado</option>
      <option value="9" <?php if (isset($alert) == 'null' && $_POST['fk_status'] == '9') echo 'selected' ?>>Recebido</option>
    </select>
  </article>

  <article class="cheque_card_container data">
    <h4 class="card_title_view">Data</h4>
    <input type="date" name="dt" <?php if (isset($alert) == 'null') echo 'value="'. $_POST['dt'] .'"' ?>>
  </article>

  <article class="cheque_card_container valor">
    <h4 class="card_title_view">valor</h4>
    <span class="mascara_valor">R$</span>
    <input class="mascara_valor_text" type="text" name="valor" <?php if (isset($alert) == 'null') echo 'value="'. $_POST['valor'] .'"' ?>>
  </article>
</div>