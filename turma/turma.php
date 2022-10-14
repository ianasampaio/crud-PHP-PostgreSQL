<?php
require_once('../conexao/conectaBD.php');

session_start();

if (empty($_SESSION)) {
  // Significa que as variáveis de SESSAO não foram definidas.
  // Não poderia acessar aqui.
  header("Location: ../index.php?msgErro=Você precisa se autenticar no sistema.");
  die();
}

$turma = array();
$sql = "SELECT * FROM turma ORDER BY identificacao_turma ASC";
  try {
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute()) {
      // Execução da SQL Ok!!
      $turma = $stmt->fetchAll();

      /*
      echo '<pre>';
      print_r($turma);
      echo '</pre>';
      die();*/
      
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
    <title>turma</title>
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
        <h2 class="title">Turmas</h2>
      </div>
    </div>
    <div class="container">
      <a href="index_cad_turma.php" class="btn btn-primary">Nova turma</a>
      <a href="busca_turma.php" class="btn btn-primary">Pesquisar</a>
      <a href="../login/index_logado.php" class="btn btn-danger">Voltar</a>
    </div>  
    
    <?php if (!empty($turma)) { ?>
      <!-- Aqui que será montada a tabela com a relação de turma!! -->
      <div class="container">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Numero</th>
              <th scope="col">Disciplina</th>
              <th scope="col">Semestre</th>
              <th scope="col">Ano</th>
              <th scope="col">Professor</th>
            </tr>
          </thead>
          <tbody>
              <?php foreach ($turma as $d) { ?>
              <tr>
                <th scope="row"><?php echo $d['identificacao_turma']; ?></th>
                <td><?php echo ucwords($d['nome_disciplina']); ?></td>
                <td><?php echo ucwords($d['semestre']); ?></td>
                <td><?php echo $d['ano']; ?></td>
                <td><?php echo ucwords($d['professor']); ?></td>
                <td>
                    <a href="alt_turma.php?identificacao_turma=<?php echo $d['identificacao_turma']; ?>" class="btn btn-warning">Alterar</a>
                    <a href="del_turma.php?identificacao_turma=<?php echo $d['identificacao_turma']; ?>" class="btn btn-danger">Excluir</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    <?php } ?>



  </body>
</html>

