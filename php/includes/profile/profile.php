<?php
  require './../../db/conexao.php';

  $css = './../../../assets/css/style.css';
  $js = '<script src="./../../../assets/js/profile.js" defer></script>';
  $logout = './../../logout.php';
  $home = './../../home.php';
  $perfil = './profile.php';

  verifyLogin($logout);

  define('ALERT', false);
  define('TITLE', 'PROFILE');

  include './../header.php';

  $dados = viewUser($_SESSION['id_user']);
?>

<section id="fade" class="hide"></section>
<section id="modal" class="hide">
  <article>
    <h5>Tem certeza que quer deletar seu usuário?</h5>
    <p><?=$dados[2]['nome']?></p>
  </article>

  <div>
    <button class="button" id="close">Não</button>
    <button class="button" id="delete">Sim</button>
  </div>
</section>

<main class="profile">
  <section class="profile_container">
    <div class="card dados">
      <h3 class="profile_card_title">Dados Pessoais</h3>

      <article>
        <h4 class="profile_title">Nome</h4>
        <p class="profile_text"><?=$dados[2]['nome']?></p>
      </article>

      <article>
        <h4 class="profile_title">Sobrenome</h4>
        <p class="profile_text"><?=$dados[2]['sobrenome']?></p>
      </article>

      <article>
        <h4 class="profile_title">Data de nascimento</h4>
        <p class="profile_text"><?=date('d/m/Y', strtotime($dados[2]['dt_nasc']))?></p>
      </article>

      <article>
        <h4 class="profile_title">Gênero</h4>
        <p class="profile_text"><?=$dados[2]['sexo']?></p>
      </article>

      <article style="display: <?=$dados[0]?>;">
        <h4 class="profile_title">CPF</h4>
        <p class="mascara profile_text"><?php if($dados[0] == 'flex'){echo $dados[2]['cpf'];}else{echo '';}?></p>
      </article>

      <article style="display: <?=$dados[1]?>;">
        <h4 class="profile_title">CNPJ</h4>
        <p class="mascara profile_text"><?php if($dados[1] == 'flex'){echo $dados[2]['cnpj'];}else{echo '';}?></p>
      </article>

      <article style="display: <?=$dados[1]?>;">
        <h4 class="profile_title">Nome da empresa</h4>
        <p class="profile_text"><?php if($dados[1] == 'flex'){echo $dados[2]['nm_empresa'];}else{echo '';}?></p>
      </article>

      <article>
        <h4 class="profile_title">Email</h4>
        <p class="profile_text"><?=$dados[2]['email']?></p>
      </article>

      <article>
        <h4 class="profile_title">Telefone</h4>
        <p class="mascara profile_text"><?=$dados[2]['ddd'].$dados[2]['telefone']?></p>
      </article>
    </div>

    <div class="card endereco">
      <h3 class="profile_card_title">Endereço</h3>

      <article>
        <h4 class="profile_title">Cep</h4>
        <p class="mascara profile_text"><?=$dados[2]['cep']?></p>
      </article>

      <article>
        <h4 class="profile_title">Cidade</h4>
        <p class="profile_text"><?=$dados[2]['cidade']?></p>
      </article>
      
      <article>
        <h4 class="profile_title">Estado</h4>
        <p class="profile_text"><?=$dados[2]['estado']?></p>
      </article>
      
      <article>
        <h4 class="profile_title">Rua</h4>
        <p class="profile_text"><?=$dados[2]['rua']?></p>
      </article>
      
      <article>
        <h4 class="profile_title">Bairro</h4>
        <p class="profile_text"><?=$dados[2]['bairro']?></p>
      </article>
      
      <article>
        <h4 class="profile_title">Número</h4>
        <p class="profile_text"><?=$dados[2]['numero']?></p>
      </article>
      
      <article>
        <h4 class="profile_title">Complemento</h4>
        <p class="profile_text"><?=$dados[2]['complemento']?></p>
      </article>
      
    </div>

    <div class="card acoes">
      <a class="button" href="./../../home.php">voltar</a>
      <a class="button" href="./profile_update.php">editar</a>
      <button class="button" id="confirm">excluir usuário</button>
    </div>
  </section>
</main>

<?php
  include './../footer.php';
?>