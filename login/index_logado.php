<?php
require_once('../conexao/conectaBD.php');

session_start();

if (empty($_SESSION)) {
  // Significa que as variáveis de SESSAO não foram definidas.
  // Não poderia acessar aqui.
  header("Location: ../index.php?msgErro=Você precisa se autenticar no sistema.");
  die();
}

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Página Inicial - Ambiente Logado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <?php if (!empty($_GET['msgErro'])) { ?>
        <div class="alert alert-warning" role="alert">
          <?php echo $_GET['msgErro']; ?>
        </div>
      <?php } ?>

      <?php if (!empty($_GET['msgSucesso'])) { ?>
        <div class="alert alert-success" role="alert">
          <?php echo $_GET['msgSucesso']; ?>
        </div>
      <?php } ?>
    </div>

    <div class="container">
      <div class="col-md-11">
        <h2 class="title">Olá <i><?php echo ucwords($_SESSION['nome_usuario']); ?></i>, seja bem-vindo(a)!</h2>
      </div>
    </div>
    <div class="container">
      <a href="../aluno/aluno.php" class="btn btn-primary">Alunos</a>
      <a href="../disciplina/disciplina.php" class="btn btn-info">Disciplinas</a>
      <a href="../turma/turma.php" class="btn btn-info">Turmas</a>
      <a href="../pre_requisito/pre_requisito.php" class="btn btn-info">Pré-requisitos</a>
      <a href="../historico/historico.php" class="btn btn-info">Histórico</a>
      <a href="../matricula/matricula.php" class="btn btn-info">Matrículas</a>
      <a href="../login/logout.php" class="btn btn-dark">Sair</a>
    </div>

  </body>
</html>
