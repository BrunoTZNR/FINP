<?php
  require './../../db/conexao.php';

  $css = './../../../assets/css/style.css';
  $js = './../../../assets/js/profile.js';
  $logout = './../../logout.php';
  $home = './../../home.php';
  $perfil = './profile.php';

  verifyLogin($logout);

  define('TITLE', 'PROFILE');

  include './../header.php';

  $dados = viewUser($_SESSION['id_user']);
?>

<main class="profile">
  <section class="profile_container">
    <div class="card dados">
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
      <a class="button" href="#update">editar</a>
      <a class="button" href="#delete">excluir usuário</a>
    </div>
  </section>
</main>

<?php
  include './../footer.php';
?>