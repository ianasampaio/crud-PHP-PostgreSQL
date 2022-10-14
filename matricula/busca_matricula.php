<?php
require_once('../conexao/conectaBD.php');

session_start();

if (empty($_SESSION)) {
  header("Location: ../index.php?msgErro=Você precisa se autenticar no sistema.");
  die();
}

?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Buscar Matrícula</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  </head>
  <body>

    <div class="container"> 
      <h1>Buscar Matrícula</h1>
      <form action="lista_matricula.php" method="post">

        <div class="col-4">
          <label for="nome">Nome aluno(a)</label>
          <input type="text" name="nome" id="nome" class="form-control">
        </div>
        
        <br />

        <button type="submit" class="btn btn-primary">Buscar</button>
        <a href="matricula.php" class="btn btn-danger">Cancelar</a>

      </form>
    </div>
  </body>
</html>
