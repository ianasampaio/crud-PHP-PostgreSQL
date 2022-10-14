<?php
session_start();

if (empty($_SESSION)) {
  // Significa que as variáveis de SESSAO não foram definidas.
  // Não poderia acessar aqui.
  header("Location: ../index.php?msgErro=Você precisa se autenticar no sistema.");
  die();
}

// echo '<pre>';
// print_r($_GET);
// echo '</pre>';
// die();

if (!empty($_GET)) {
    $result1 = $_GET['numero_disciplina']; 
    $result2 = $_GET['nome_disciplina']; 
}

// echo $result1,$result2;
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Cadastrar Nova turma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  </head>
  <body>

    <div class="container">
      <h1>Cadastrar Nova turma</h1>
      <form action="processa_turma.php" method="post">
        
        <input type="hidden" name="numero_disciplina" id="numero_disciplina" value="<?php echo $result1;?>">
        <input type="hidden" name="nome_disciplina" id="nome_disciplina" value="<?php echo $result2;?>">


        <div class="col-4">
          <label for="semestre">Semestre</label>
          <input type="text" name="semestre" id="semestre" class="form-control" required>
        </div>

        <div class="col-4">
          <label for="ano">Ano</label>
          <input type="number" name="ano" id="ano" class="form-control" required>
        </div>

        <div class="col-4">
          <label for="professor">Professor</label>
          <input type="text" name="professor" id="professor" class="form-control" required>
        </div>

        <br />

        <button type="submit" name="enviarDados" class="btn btn-primary" value="CAD">Cadastrar</button>
        <a href="turma.php" class="btn btn-danger">Cancelar</a>

      </form>
    </div>
  </body>
</html>
