<?php
require_once('../conexao/conectaBD.php');

session_start();

if (empty($_SESSION)) {
  // Significa que as variáveis de SESSAO não foram definidas.
  // Não poderia acessar aqui.
  header("Location: ../index.php?msgErro=Você precisa se autenticar no sistema.");
  die();
}
$disciplinas = array();
$sql = "SELECT * FROM disciplina ORDER BY numero_disciplina ASC";
  try {
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute()) {
      // Execução da SQL Ok!!
      $disciplinas = $stmt->fetchAll();

      /*
      echo '<pre>';
      print_r($disciplinas);
      echo '</pre>';
      die();
      */
    }
    else {
      die("Falha ao executar a SQL.. #1");
    }

  } catch (PDOException $e) {
    die($e->getMessage());
  }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Disciplinas disponíveis</title>
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
        <h2 class="title">Disciplinas disponíveis</h2>
      </div>
    </div>
    <div class="container">
      <a href="turma.php" class="btn btn-danger">Voltar</a>
    </div>  
    
    <?php if (!empty($disciplinas)) { ?>
      <!-- Aqui que será montada a tabela com a relação de disciplina!! -->
      <div class="container">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Numero</th>
              <th scope="col">Nome</th>
              <th scope="col">Creditos</th>
              <th scope="col">Departamento</th>
            </tr>
          </thead>
          <tbody>
              <?php foreach ($disciplinas as $d) { ?>
              <tr>
                <th scope="row"><?php echo $d['numero_disciplina']; ?></th>
                <td><?php echo ucwords($d['nome_disciplina']); ?></td>
                <td><?php echo $d['creditos']; ?></td>
                <td><?php echo ucwords($d['departamento']); ?></td>
                <td>
                    <a href="cad_turma.php?numero_disciplina=<?php echo $d['numero_disciplina']; ?>&nome_disciplina=<?php echo $d['nome_disciplina'];?>" class="btn btn-warning">Criar Turma</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    <?php } ?>



  </body>
</html>

