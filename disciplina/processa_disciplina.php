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

/*
echo '<pre>';
print_r($_POST);
echo '</pre>';
die();
*/

if (!empty($_POST)) {
  // Está chegando dados por POST e então posso tentar inserir no banco
  // Obter as informações do formulário ($_POST)
  // Verificar se estou tentando INSERIR (CAD) / ALTERAR (ALT) / EXCLUIR (DEL)
  if ($_POST['enviarDados'] == 'CAD') { // CADASTRAR!!!
    try {
      // Preparar as informações
        // Montar a SQL (pgsql)
        $sql = "INSERT INTO disciplina
                  (nome_disciplina, creditos, departamento)
                VALUES
                  (:nome_disciplina, :creditos, :departamento)";

        // Preparar a SQL (pdo)
        $stmt = $pdo->prepare($sql);

        // Definir/organizar os dados p/ SQL
        $dados = array(
          ':nome_disciplina' => strtolower($_POST['nome_disciplina']),
          ':creditos' => $_POST['creditos'],
          ':departamento' => strtolower($_POST['departamento'])
        );

        // Tentar Executar a SQL (INSERT)
        // Realizar a inserção das informações no BD (com o PHP)
        if ($stmt->execute($dados)) {
          header("Location: disciplina.php?msgSucesso=Disciplina cadastrado com sucesso!");
        }
    } catch (PDOException $e) {
        die($e->getMessage());
        header("Location: disciplina.php?msgErro=Falha ao cadastrar Disciplina..");
    }
  }
  elseif ($_POST['enviarDados'] == 'ALT') { // ALTERAR!!!
    /* Implementação do update aqui.. */
    // Construir SQL para update
    try {
      $sql = "UPDATE
                disciplina
              SET
                nome_disciplina = :nome_disciplina,
                creditos = :creditos,
                departamento = :departamento
              WHERE
                numero_disciplina = :numero_disciplina";

      $stmt = $pdo->prepare($sql);

      // Definir dados para SQL
      $dados = array(
        ':numero_disciplina' => $_POST['numero_disciplina'],
        ':nome_disciplina' => strtolower($_POST['nome_disciplina']),
        ':creditos' => $_POST['creditos'],
        ':departamento' => strtolower($_POST['departamento'])
      );

      // Executar SQL
      if ($stmt->execute($dados)) {
        header("Location: disciplina.php?msgSucesso=Alteração realizada com sucesso!!");
      }
      else {
        header("Location: disciplina.php?msgErro=Falha ao ALTERAR disciplina..");
      }
    } catch (PDOException $e) {
      //die($e->getMessage());
      header("Location: disciplina.php?msgErro=Falha ao ALTERAR disciplina..");
    }

  }
  elseif ($_POST['enviarDados'] == 'DEL') { // EXCLUIR!!!
    /** Implementação do excluir aqui.. */
    // numero_disciplina ok
    // e-mail usuário logado ok
    try {
      $sql = "DELETE FROM disciplina WHERE numero_disciplina = :numero_disciplina";
      $stmt = $pdo->prepare($sql);

      $dados = array(':numero_disciplina' => $_POST['numero_disciplina']);

      if ($stmt->execute($dados)) {
        header("Location: disciplina.php?msgSucesso=Disciplina excluída com sucesso!!");
      }
      else {
        header("Location: disciplina.php?msgSucesso=Falha ao EXCLUIR disciplina..");
      }
    } catch (PDOException $e) {
      //die($e->getMessage());
      header("Location: disciplina.php?msgSucesso=Falha ao EXCLUIR disciplina..");
    }
  }
  else {
    header("Location: disciplina.php?msgErro=Erro de acesso (Operação não definida).");
  }
}
else {
  header("Location: ../login/index_logado.php?msgErro=Erro de acesso.");
}
die();

// Redirecionar para a página inicial (index_logado) c/ mensagem erro/sucesso
 ?>


