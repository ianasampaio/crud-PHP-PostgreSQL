<?php
require_once('../conexao/conectaBD.php');

session_start();

if (empty($_SESSION)) {
  header("Location: ../index.php?msgErro=Você precisa se autenticar no sistema.");
  die();
}

if (!empty($_POST)) {

    if($_POST['enviarDados'] == 'ALN'){
        try {
            $nome_aluno = strtolower($_POST['nome_aluno']);
            $sql = "SELECT * FROM historico_escolar
                    WHERE nome_aluno LIKE '%$nome_aluno%'
                    ORDER BY numero_aluno ASC";            
            $stmt = $pdo->prepare($sql);

            $stmt->execute();
            if ($stmt->rowCount() >= 1) {
                $result = $stmt->fetchAll();
            }
        } catch (PDOException $e) {
            die($e->getMessage());
            header("Location: ../login/index_logado.php?msgErro=Falha ao BUSCAR Disciplina..");
        }
    }
    elseif ($_POST['enviarDados'] == 'TUR'){
        try {
            $num_turma = $_POST['identificacao_turma'];
            $sql = "SELECT * FROM historico_escolar
                    WHERE identificacao_turma = $num_turma
                    ORDER BY identificacao_turma ASC";            
            $stmt = $pdo->prepare($sql);
    
            $stmt->execute();
            if ($stmt->rowCount() >= 1) {
                $result = $stmt->fetchAll();
            }
        } catch (PDOException $e) {
            die($e->getMessage());
            header("Location: ../login/index_logado.php?msgErro=Falha ao BUSCAR Disciplina..");
        }
    }   
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
        <h2 class="title">Histórico</h2>
      </div>
    </div>
    <div class="container">
      <a href="historico.php" class="btn btn-danger">Voltar</a>
    </div>  
    
    <?php if (!empty($result)) { ?>
      <!-- Aqui que será montada a tabela com a relação de result!! -->
      <div class="container">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Numero</th>
              <th scope="col">Nome</th>
              <th scope="col">Numero turma</th>
              <th scope="col">Disciplina</th>
              <th scope="col">Nota</th>
            </tr>
          </thead>
          <tbody>
              <?php foreach ($result as $r) { ?>
              <tr>
                <th scope="row"><?php echo $r['numero_aluno']; ?></th>
                <td><?php echo ucwords($r['nome_aluno']); ?></td>
                <td><?php echo ucwords($r['identificacao_turma']); ?></td>
                <td><?php echo ucwords($r['nome_disciplina']); ?></td>
                <td><?php echo $r['nota']; ?></td>
                <td>
                    <a href="alt_historico.php?numero_aluno=<?php echo $r['numero_aluno']; ?>&identificacao_turma=<?php echo $r['identificacao_turma']; ?>" class="btn btn-warning">Alterar</a>
                    <a href="del_historico.php?numero_aluno=<?php echo $r['numero_aluno']; ?>&identificacao_turma=<?php echo $r['identificacao_turma']; ?>" class="btn btn-danger">Excluir</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    <?php } ?>

    <?php if (empty($result)) {?>
        <div class="container">
            <div class="col-md-11">
                <br />
                <p class="title">Não há registros.</p>
            </div>
        </div>
    <?php } ?>



  </body>
</html>

