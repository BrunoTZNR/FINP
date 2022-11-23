<?php
  require './../../db/conexao.php';

  $css = './../../../assets/css/style.css';
  $js = '<script src="./../../../assets/js/profile_update.js" defer></script>
        <script src="./../../../assets/js/viaCep_api.js" defer></script>';
  $logout = './../../logout.php';
  $home = './../../home.php';
  $perfil = './profile.php';

  verifyLogin($logout);

  define('TITLE', 'PROFILE - UPDATE');

  include './../header.php';

  $dados = viewUser($_SESSION['id_user']);
  $alert = '';

  if (isset($_POST['alterar'])) {
    if (empty($_POST['nome']) || empty($_POST['sobrenome']) || empty($_POST['dt_nasc']) || empty($_POST['sexo']) || empty($_POST['cpf'])
        || empty($_POST['email']) || empty($_POST['telefone']) || empty($_POST['cep']) || empty($_POST['cidade']) || empty($_POST['estado']) 
        || empty($_POST['rua']) || empty($_POST['bairro']) || empty($_POST['numero'])) {
      $alert = 'Todos os campos são obrigatórios!';
    } else {
      $nome = clean($_POST['nome']);
      $sobrenome = clean($_POST['sobrenome']);
      $dt_nasc = clean($_POST['dt_nasc']);
      $sexo = clean($_POST['sexo']);
      $email = clean($_POST['email']);
      $cep = clean(str_replace(['.','-'],'',$_POST['cep']));
      $cidade = clean($_POST['cidade']);
      $estado = clean($_POST['estado']);
      $rua = clean($_POST['rua']);
      $bairro = clean($_POST['bairro']);
      $numero = clean($_POST['numero']);
      $complemento = clean($_POST['complemento']);
  
      $telefone = clean(str_replace(['(',')','-',' '],'',$_POST['telefone']));
      $ddd = substr($telefone, -11, 2);
      $telefone = substr($telefone, 2);
  
      if($dados[0] == 'flex') {
        $cpf = clean(str_replace(['.','-'],'',$_POST['cpf']));
  
        $query = $conn->prepare("UPDATE tb_user u
                                JOIN tb_pessoa p ON p.id_pessoa=u.fk_pessoa
                                JOIN tb_endereco e ON e.id_endereco=u.fk_endereco
                                JOIN tb_cidade c ON c.id_cidade=e.fk_cidade
                                JOIN tb_estado es ON es.cod_estado=c.fk_estado
                                JOIN tb_pf pf ON pf.id_pf=p.fk_pf
                                SET u.email=?, u.ddd=?, u.telefone=?, 
                                p.nome=?, p.sobrenome=?, p.dt_nasc=?, p.sexo=?,
                                e.cep=?, e.rua=?, e.bairro=?, e.numero=?, e.complemento=?,
                                c.nm_cidade=?, c.fk_estado=?,
                                pf.cpf=?
                                WHERE id_user=?");
        $query->execute([$email, $ddd, $telefone, $nome, $sobrenome, $dt_nasc, $sexo, $cep, $rua, $bairro, $numero, $complemento, $cidade, $estado, $cpf, $_SESSION['id_user']]);
  
        header('Location: ./profile.php?update');
      } else {
        $cnpj = clean(str_replace(['.','-','/'],'',$_POST['cnpj']));;
        $nm_empresa = clean($_POST['nm_empresa']);
  
        $query = $conn->prepare("UPDATE tb_user u
                                JOIN tb_pessoa p ON p.id_pessoa=u.fk_pessoa
                                JOIN tb_endereco e ON e.id_endereco=u.fk_endereco
                                JOIN tb_cidade c ON c.id_cidade=e.fk_cidade
                                JOIN tb_estado es ON es.cod_estado=c.fk_estado
                                JOIN tb_pj pj ON pj.id_pj=p.fk_pj
                                SET u.email=?, u.ddd=?, u.telefone=?, 
                                p.nome=?, p.sobrenome=?, p.dt_nasc=?, p.sexo=?,
                                e.cep=?, e.rua=?, e.bairro=?, e.numero=?, e.complemento=?,
                                c.nm_cidade=?, c.fk_estado=?,
                                pj.cnpj=?, pj.nm_empresa=?
                                WHERE id_user=?");
        $query->execute([$email, $ddd, $telefone, $nome, $sobrenome, $dt_nasc, $sexo, $cep, $rua, $bairro, $numero, $complemento, $cidade, $estado, $cnpj, $nm_empresa, $_SESSION['id_user']]);
  
        header('Location: ./profile.php?update');
      }
    }
  }
?>

<section class="alert">
  <p class="alert_text"><?=$alert?></p>
</section>

<main class="profile">
  <form class="profile_container" method="post">
    <div class="card dados">
      <h3 class="profile_card_title">Dados Pessoais</h3>

      <article>
        <h4 class="profile_title">Nome</h4>
        <input type="text" name="nome" value="<?=$dados[2]['nome']?>">
      </article>

      <article>
        <h4 class="profile_title">Sobrenome</h4>
        <input type="text" name="sobrenome" value="<?=$dados[2]['sobrenome']?>">
      </article>

      <article>
        <h4 class="profile_title">Data de nascimento</h4>
        <input type="date" name="dt_nasc" value="<?=$dados[2]['dt_nasc']?>">
      </article>

      <article>
        <h4 class="profile_title">Gênero</h4>
        <select name="sexo">
          <option value="f" <?php if($dados[2]['sexo'] == 'Feminino') echo 'selected' ?>>Feminino</option>
          <option value="m" <?php if($dados[2]['sexo'] == 'Masculino') echo 'selected' ?>>Masculino</option>
          <option value="o" <?php if($dados[2]['sexo'] == 'Outro') echo 'selected' ?>>Outro</option>
          <option value="n" <?php if($dados[2]['sexo'] == 'Prefiro não informar') echo 'selected' ?>>Prefiro não informar</option>
        </select>
      </article>

      <article style="display: <?=$dados[0]?>;">
        <h4 class="profile_title">CPF</h4>
        <input class="mascara" type="text" name="cpf" maxlength="14" value="<?php if($dados[0] == 'flex'){echo $dados[2]['cpf'];}else{echo '';}?>">
      </article>

      <article style="display: <?=$dados[1]?>;">
        <h4 class="profile_title">CNPJ</h4>
        <input class="mascara" type="text" name="cnpj" maxlength="18" value="<?php if($dados[1] == 'flex'){echo $dados[2]['cnpj'];}else{echo '';}?>">
      </article>

      <article style="display: <?=$dados[1]?>;">
        <h4 class="profile_title">Nome da empresa</h4>
        <input type="text" name="nm_empresa" value="<?php if($dados[1] == 'flex'){echo $dados[2]['nm_empresa'];}else{echo '';}?>">
      </article>

      <article>
        <h4 class="profile_title">Email</h4>
        <input type="email" name="email" value="<?=$dados[2]['email']?>">
      </article>

      <article>
        <h4 class="profile_title">Telefone</h4>
        <input class="mascara" type="text" name="telefone" maxlength="16" value="<?=$dados[2]['ddd'].$dados[2]['telefone']?>">
      </article>
    </div>

    <div class="card endereco">
      <h3 class="profile_card_title">Endereço</h3>

      <article>
        <h4 class="profile_title">Cep</h4>
        <input class="mascara" type="text" name="cep" maxlength="9" onblur="pesquisacep(this.value);" value="<?=$dados[2]['cep']?>">
      </article>

      <article>
        <h4 class="profile_title">Cidade</h4>
        <input type="text" name="cidade" id="cidade" value="<?=$dados[2]['cidade']?>">
      </article>
      
      <article>
        <h4 class="profile_title">Estado</h4>
        <select name="estado" id="estado">
        <?php
          $query = $conn->prepare("SELECT * FROM tb_estado");
          $query->execute();
          
          // MOSTRA OS ESTADOS
          if($query->rowCount() > 0){
            while($estado = $query->fetch(PDO::FETCH_ASSOC)){
              if($estado['cod_estado'] == $dados[2]['cod_estado']) {
                echo '<option value="'.$estado['cod_estado'].'" selected>'.$estado['nm_estado'].'</option>';
              } else {
                echo '<option value="'.$estado['cod_estado'].'">'.$estado['nm_estado'].'</option>';
              }
            }
          }
        ?>
        </select>
      </article>
      
      <article>
        <h4 class="profile_title">Rua</h4>
        <input type="text" name="rua" id="rua" value="<?=$dados[2]['rua']?>">
      </article>
      
      <article>
        <h4 class="profile_title">Bairro</h4>
        <input type="text" name="bairro" id="bairro" value="<?=$dados[2]['bairro']?>">
      </article>
      
      <article>
        <h4 class="profile_title">Número</h4>
        <input type="text" name="numero" value="<?=$dados[2]['numero']?>">
      </article>
      
      <article>
        <h4 class="profile_title">Complemento</h4>
        <input type="text" name="complemento" value="<?=$dados[2]['complemento']?>">
      </article>
      
    </div>

    <div class="card acoes">
      <a class="button" href="./profile.php">voltar</a>
      <button class="button" type="submit" name="alterar">salvar</button>
    </div>
  </form>
</main>

<?php
  include './../footer.php';
?>