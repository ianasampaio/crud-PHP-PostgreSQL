<?php
require_once('../conexao/conectaBD.php');

session_start();

if (empty($_SESSION)) {
  // Significa que as variáveis de SESSAO não foram definidas.
  // Não poderia acessar aqui.
  header("Location: ../index.php?msgErro=Você precisa se autenticar no sistema.");
  die();
}

$pre_requisito = array();
$sql = "SELECT * FROM pre_requisito ORDER BY numero_pre_requisito ASC";
try {
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute()) {
        $pre_requisito = $stmt->fetchAll();
    }else {
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
    <title>Pré-requisitos</title>
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
        <h2 class="title">Pré-requisitos</h2>
      </div>
    </div>
    <div class="container">
      <a href="cad_pre_requisito_disciplina.php" class="btn btn-primary">Adicionar pré-requisito</a>
      <a href="busca_pre_requisito.php" class="btn btn-primary">Pesquisar</a>
      <a href="../login/index_logado.php" class="btn btn-danger">Voltar</a>
    </div>  
    
    <?php if (!empty($pre_requisito)) { ?>
      <!-- Aqui que será montada a tabela com a relação de matricula!! -->
      <div class="container">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Numero</th>
              <th scope="col">Disciplina</th>
              <th scope="col">Numero</th>
              <th scope="col">Pré-requisito</th>
            </tr>
          </thead>
          <tbody>
              <?php foreach ($pre_requisito as $pr) { ?>
              <tr>
                <td><?php echo $pr['numero_disciplina']; ?></td>
                <td><?php echo ucwords($pr['nome_disciplina']); ?></td>
                <th scope="row"><?php echo $pr['numero_pre_requisito']; ?></th>
                <td><?php echo ucwords($pr['nome_pre_requisito']); ?></td>
                <td>
                    <a href="alt_pre_requisito.php?numero_pre_requisito=<?php echo $pr['numero_pre_requisito']; ?>&numero_disciplina=<?php echo $pr['numero_disciplina']; ?>" class="btn btn-warning">Alterar</a>
                    <a href="del_pre_requisito.php?numero_pre_requisito=<?php echo $pr['numero_pre_requisito']; ?>&numero_disciplina=<?php echo $pr['numero_disciplina']; ?>" class="btn btn-danger">Excluir</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    <?php } ?>


  </body>
</html>

