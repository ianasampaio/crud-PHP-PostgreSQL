<?php
require_once('../conexao/conectaBD.php');

session_start();

if (empty($_SESSION)) {
  // Significa que as variáveis de SESSAO não foram definidas.
  // Não poderia acessar aqui.
  header("Location: ../index.php?msgErro=Você precisa se autenticar no sistema.");
  die();
}
// echo "Estou logado";
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
// die();
if (!empty($_POST)) {

    try {
        $nome_disciplina = strtolower($_POST['nome_disciplina']);

        // $num_aluno = "SELECT numero_aluno from aluno LIKE nome = '%$nome_aluno%'";

        $sql = "SELECT * FROM pre_requisito 
                WHERE nome_disciplina LIKE '%$nome_disciplina%'
                ORDER BY numero_pre_requisito ASC";            
        $stmt = $pdo->prepare($sql);

        // $dados = array(':nome_disciplina' => $_POST['nome_disciplina']);
        // var_dump($dados);
        $stmt->execute();
        if ($stmt->rowCount() >= 1) {
            // Registro obtido no banco de dados
            $result = $stmt->fetchAll();
            //$result = $result[0]; // Informações do registro a ser alterado
            // var_dump($result);
            
            // echo '<pre>';
            // print_r($result);
            // echo '</pre>';
            // die();
            }
    } catch (PDOException $e) {
        die($e->getMessage());
        header("Location: ../login/index_logado.php?msgErro=Falha ao BUSCAR Disciplina..");
    }
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
      <a href="pre_requisito.php" class="btn btn-danger">Voltar</a>
    </div>  
    
    <?php if (!empty($result)) { ?>
      <!-- Aqui que será montada a tabela com a relação de pre_requisito!! -->
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
              <?php foreach ($result as $r) { ?>
              <tr>
                <td><?php echo $r['numero_disciplina']; ?></td>
                <td><?php echo ucwords($r['nome_disciplina']); ?></td>
                <th scope="row"><?php echo $r['numero_pre_requisito']; ?></th>
                <td><?php echo ucwords($r['nome_pre_requisito']); ?></td>
                <td>
                    <a href="alt_pre_requisito.php?numero_pre_requisito=<?php echo $r['numero_pre_requisito']; ?>&numero_disciplina=<?php echo $r['numero_disciplina']; ?>" class="btn btn-warning">Alterar</a>
                    <a href="del_pre_requisito.php?numero_pre_requisito=<?php echo $r['numero_pre_requisito']; ?>&numero_disciplina=<?php echo $r['numero_disciplina']; ?>" class="btn btn-danger">Excluir</a>
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

