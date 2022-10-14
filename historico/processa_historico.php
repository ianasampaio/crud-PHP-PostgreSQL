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


// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
// die();

if (!empty($_POST)) {

    if($_POST['enviarDados'] == 'CAD'){
        $sql1 = "SELECT * FROM historico_escolar 
            WHERE numero_aluno = :numero_aluno 
            AND identificacao_turma = :identificacao_turma";

        try {
            $stmt = $pdo->prepare($sql1);

            $stmt->execute(array(':numero_aluno' => $_GET['numero_aluno'],
                                ':identificacao_turma' => $_GET['identificacao_turma']));

            if ($stmt->rowCount() == 1) {
                header("Location: historico.php?msgErro=Relação inválida!");

            }else{ 
                try {
                    $sql = "INSERT INTO historico_escolar
                                (numero_aluno, identificacao_turma, nome_aluno, nota, nome_disciplina)
                            VALUES
                                (:numero_aluno, :identificacao_turma, :nome_aluno, :nota, :nome_disciplina)";
            
                    // Preparar a SQL (pdo)
                    $stmt = $pdo->prepare($sql);
            
                    // Definir/organizar os dados p/ SQL
                    $dados = array(
                        ':numero_aluno' => $_POST['numero_aluno'],
                        ':identificacao_turma' => $_POST['identificacao_turma'],
                        ':nome_aluno' => strtolower($_POST['nome']),
                        ':nota' => $_POST['nota'],
                        ':nome_disciplina' => strtolower($_POST['nome_disciplina'])
                    );
            
                    // Tentar Executar a SQL (INSERT)
                    // Realizar a inserção das informações no BD (com o PHP)
                    if ($stmt->execute($dados)) {
                        header("Location: historico.php?msgSucesso=Nota inserida com sucesso!");
                    }
                } catch (PDOException $e) {
                    die($e->getMessage());
                    header("Location: historico.php?msgErro=Falha ao inserir nota..");
                }
            }
        } catch (PDOException $e) {
            die($e->getMessage());
            header("Location: historico.php?msgErro=Falha ao inserir nota..");
        }
    }
    elseif ($_POST['enviarDados'] == 'ALT') {
        try {
        $sql = "UPDATE
                    historico_escolar
                SET
                    nota = :nota
                WHERE
                    numero_aluno = :numero_aluno
                AND
                    identificacao_turma = :identificacao_turma";

        $stmt = $pdo->prepare($sql);

        // Definir dados para SQL
        $dados = array(
            ':numero_aluno' => $_POST['numero_aluno'],
            ':identificacao_turma' => $_POST['identificacao_turma'],
            ':nota' => $_POST['nota']
        );

        // Executar SQL
        if ($stmt->execute($dados)) {
            header("Location: historico.php?msgSucesso=Alteração realizada com sucesso!!");
        }
        else {
            header("Location: historico.php?msgErro=Falha ao ALTERAR histórico..");
        }
        } catch (PDOException $e) {
        //die($e->getMessage());
        header("Location: historico.php?msgErro=Falha ao ALTERAR histórico..");
        }

    }
  elseif ($_POST['enviarDados'] == 'DEL') { // EXCLUIR!!!
    /** Implementação do excluir aqui.. */
    // identificacao_turma ok
    // e-mail usuário logado ok
    try {
      $sql = "DELETE FROM historico_escolar 
      WHERE
        numero_aluno = :numero_aluno
      AND
        identificacao_turma = :identificacao_turma";

      $stmt = $pdo->prepare($sql);

      $dados = array(
        ':numero_aluno' => $_POST['numero_aluno'],
        ':identificacao_turma' => $_POST['identificacao_turma']    
      );

      if ($stmt->execute($dados)) {
        header("Location: historico.php?msgSucesso=Histórico excluído com sucesso!!");
      }
      else {
        header("Location: historico.php?msgSucesso=Falha ao EXCLUIR histórico..");
      }
    } catch (PDOException $e) {
      //die($e->getMessage());
      header("Location: historico.php?msgSucesso=Falha ao EXCLUIR histórico..");
    }
  }
  else {
    header("Location: historico.php?msgErro=Erro de acesso (Operação não definida).");
  }
}
else {
  header("Location: ../login/index_logado.php?msgErro=Erro de acesso.");
}
die();

// Redirecionar para a página inicial (index_logado) c/ mensagem erro/sucesso
 ?>