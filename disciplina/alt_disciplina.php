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
$disciplina = array();

// Verificar se está chegando a informação (numero_disciplina) pelo $_GET
if (!empty($_GET['numero_disciplina'])) {

    // Buscar as informações do anúncio a ser alterado (no banco de dados)
  $sql = "SELECT * FROM disciplina WHERE numero_disciplina = :numero_disciplina";
  try {
    $stmt = $pdo->prepare($sql);

    $stmt->execute(array(':numero_disciplina' => $_GET['numero_disciplina']));
    
    if ($stmt->rowCount() == 1) {
        // Registro obtido no banco de dados
        $result = $stmt->fetchAll();
        $result = $result[0]; // Informações do registro a ser alterado
  
        /*
        echo '<pre>';
        print_r($result);
        echo '</pre>';
        */
        //die();
  
      }
      else {
        //die("Não foi encontrado nenhum registro para id_anuncio = " . $_GET['id_anuncio'] . " e e-mail = " . $_SESSION['email']);
        header("Location: ../login/index_logado.php?msgErro=Você não tem permissão para acessar esta página");
        die();
      }


  } catch (PDOException $e) {
    header("Location: ../login/index_logado.php?msgErro=Falha ao obter registro no banco de dados.");
    //die($e->getMessage());

  }
}
else {
  // Se entrar aqui, significa que $_GET['numero_disciplina'] está vazio
  header("Location: ../login/index_logado.php?msgErro=Você não tem permissão para acessar esta página");
  die();
}

?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Alterar Disciplina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  </head>
  <body>

    <div class="container">
      <h1>Alterar Disciplina</h1>
      <form action="processa_disciplina.php" method="post">
      <input type="hidden" name="numero_disciplina" id="numero_disciplina" value="<?php echo $result['numero_disciplina'];?>">


        <div class="col-4">
          <label for="nome_disciplina">Nome</label>
          <input type="text" name="nome_disciplina" id="nome_disciplina" class="form-control" value="<?php echo ucwords($result['nome_disciplina']);?>">
        </div>

        <div class="col-4">
          <label for="creditos">Créditos</label>
          <input type="number" name="creditos" id="creditos" class="form-control" value="<?php echo $result['creditos'];?>">
        </div>

        <div class="col-4">
          <label for="departamento">Departamento</label>
          <input type="text" name="departamento" id="departamento" class="form-control" value="<?php echo ucwords($result['departamento']);?>">
        </div>

        <br />

        <button type="submit" name="enviarDados" class="btn btn-primary" value="ALT">Alterar</button>
        <a href="disciplina.php" class="btn btn-danger">Cancelar</a>

      </form>
    </div>
  </body>
</html>
