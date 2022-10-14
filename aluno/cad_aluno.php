<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Cadastrar Novo(a) Aluno(a)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  </head>
  <body>  
    <div class="container">
      <h1>Cadastrar Novo(a) Aluno(a)</h1>
      <form action="processa_aluno.php" method="post">
        <div class="col-4">
          <label for="nome">Nome Completo</label>
          <input type="text" name="nome" id="nome" class="form-control" required>
        </div>

        <div class="col-4">
          <label for="tipo_aluno">Ano curricular</label>
          <input type="number" name="tipo_aluno" id="tipo_aluno" class="form-control" required>
        </div>

        <div class="col-4">
          <label for="curso">Curso</label>
          <input type="text" name="curso" id="curso" class="form-control" required>
        </div>
        <br />
        
        <button type="submit" name="enviarDados" class="btn btn-primary" value="CAD">Cadastrar</button>
        <a href="aluno.php" class="btn btn-danger">Cancelar</a>
      </form>
    </div>
  </body>
</html>