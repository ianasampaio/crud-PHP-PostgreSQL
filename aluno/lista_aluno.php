<?php
require_once('../conexao/conectaBD.php');
// Definir o BD (e a tabela)
// Conectar ao BD (com o PHP)

session_start();

if (empty($_SESSION)) {
  // Significa que as variáveis de SESSAO não foram definidas.
  // Não poderia acessar aqui.
  header("Location: ../index.php?msgErro=Você precisa se autenticar no sistema.");
  die();
}

if (!empty($_POST)) {
    $alunos = array();
        // Preparar as informações
          // Montar a SQL (pgsql)
          

          try {
            $nome_aluno = strtolower($_POST['nome']);
            $sql = "SELECT * FROM aluno WHERE nome LIKE '%$nome_aluno%'";

            $stmt = $pdo->prepare($sql);
            // var_dump($stmt);

            // $dados = array(':nome' => $_POST['nome']);
            // var_dump($dados);
            $stmt->execute();
            if ($stmt->rowCount() >= 1) {
                // Registro obtido no banco de dados
                 $result = $stmt->fetchAll();
                // $result = $result[0]; // Informações do registro a ser alterado
                // var_dump($result);
                
                // echo '<pre>';
                // print_r($result);
                // echo '</pre>';
                
                //die();
          
              }
            } catch (PDOException $e) {
              die($e->getMessage());
              header("Location: ../login/index_logado.php?msgErro=Falha ao BUSCAR aluno..");
          }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  </head>
  <body>
  <div class="container">
      <div class="col-md-11">
        <h2 class="title">Resultado</h2>
      </div>
    </div>
    <div class="container">
      <a href="aluno.php" class="btn btn-danger">Voltar</a>
    </div>  
    <?php if (!empty($result)) { ?>
      <!-- Aqui que será montada a tabela com a relação de aluno!! -->
      <div class="container">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Numero</th>
              <th scope="col">Nome</th>
              <th scope="col">Ano Curricular</th>
              <th scope="col">Curso</th>
            </tr>
          </thead>
          <tbody>
              <?php foreach ($result as $d) { ?>
                <tr>
                <th scope="row"><?php echo $d['numero_aluno']; ?></th>
                <td><?php echo ucwords($d['nome']); ?></td>
                <td><?php echo $d['tipo_aluno']; ?></td>
                <td><?php echo ucwords($d['curso']); ?></td>
                <td>
                    <a href="alt_aluno.php?numero_aluno=<?php echo $d['numero_aluno']; ?>" class="btn btn-warning">Alterar</a>
                    <a href="del_aluno.php?numero_aluno=<?php echo $d['numero_aluno']; ?>" class="btn btn-danger">Excluir</a>
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
