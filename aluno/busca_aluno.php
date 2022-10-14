<?php 
require_once('../conexao/conectaBD.php');

session_start();

if (empty($_SESSION)) {
  // Significa que as variáveis de SESSAO não foram definidas.
  // Não poderia acessar aqui.
  header("Location: ../index.php?msgErro=Você precisa se autenticar no sistema.");
  die();
}

/*echo "Estou logado";
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
die();
*/
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Buscar Alunos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  </head>
  <body>

    <div class="container">
      <h1>Buscar Aluno</h1>
      <form action="lista_aluno.php" method="post">

        <div class="col-4">
          <label for="nome">Nome</label>
          <input type="text" name="nome" id="nome" class="form-control" required>
        </div>

        <br />

        <button type="submit" name="enviarDados" class="btn btn-primary">Buscar</button>
        <a href="aluno.php" class="btn btn-danger">Cancelar</a>

      </form>
    </div>
  </body>
</html>
