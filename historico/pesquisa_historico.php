<?php
require_once('../conexao/conectaBD.php');

session_start();

if (empty($_SESSION)) {
  header("Location: ../index.php?msgErro=Você precisa se autenticar no sistema.");
  die();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Histórico</title>
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
        <h2 class="title">Pesquisar histórico</h2>
      </div>
    </div>

    <div class="container"> 
      <a href="historico.php" class="btn btn-danger">Voltar</a>
      <a href="busca_historico_aln.php"class="btn btn-primary" >Pesquisar por aluno</a>
      <a href="busca_historico_turma.php"class="btn btn-primary">Pesquisar por turma</a>
    </div>

  </body>
</html>

