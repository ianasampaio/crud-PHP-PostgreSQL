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

if (!empty($_GET) ) {
  // Está chegando dados por POST e então posso tentar inserir no banco
  // Obter as informações do formulário ($_GET)
  // Verificar se estou tentando INSERIR (CAD) / ALTERAR (ALT) / EXCLUIR (DEL)
  if ($_GET['enviarDados'] == 'CAD') { // CADASTRAR!!!
    
    
        $sql1 = "SELECT * FROM matricula 
                WHERE 
                identificacao_turma = :identificacao_turma
                AND
                numero_aluno = :numero_aluno";
        try {
            $stmt = $pdo->prepare($sql1);

            $stmt->execute(array(':identificacao_turma' => $_GET['identificacao_turma'],
                            ':numero_aluno' => $_GET['numero_aluno']));

            if ($stmt->rowCount() == 1) {
            header("Location: matricula.php?msgErro=Matrícula já existe");
            // echo '<pre>';
            // print_r($result);
            // echo '</pre>';
            
            // die();
            } else{
                try {
                // Preparar as informações
                    // Montar a SQL (pgsql)
                    $sql = "INSERT INTO matricula
                            (numero_aluno, identificacao_turma)
                            VALUES
                            (:numero_aluno, :identificacao_turma)";

                    // Preparar a SQL (pdo)
                    $stmt = $pdo->prepare($sql);

                    // Definir/organizar os dados p/ SQL
                    $dados = array(
                    ':numero_aluno' => $_GET['numero_aluno'],
                    ':identificacao_turma' => $_GET['identificacao_turma']
                    );

                // Tentar Executar a SQL (INSERT)
                // Realizar a inserção das informações no BD (com o PHP)
                    if ($stmt->execute($dados)) {
                        header("Location: matricula.php?msgSucesso=Matrícula cadastrada com sucesso!");
                    }
                    else {
                        header("Location: matricula.php?msgErro=Falha ao CADASTRAR matrícula..");
                    }
                } catch (PDOException $e) {
                    die($e->getMessage());
                    header("Location: matricula.php?msgErro=Falha ao cadastrar matrícula..");
                }
            }
        } catch (PDOException $e) {
            die($e->getMessage());
            header("Location: matricula.php?msgErro=Falha ao cadastrar matrícula..");
        }
    }
    elseif ($_GET['enviarDados'] == 'DEL') { // EXCLUIR!!!
        /** Implementação do excluir aqui.. */
        // identificacao_turma ok
        // e-mail usuário logado ok        
            try {
                $sql = "DELETE FROM matricula 
                        WHERE 
                            identificacao_turma = :identificacao_turma
                        AND
                            numero_aluno = :numero_aluno";
    
                $stmt = $pdo->prepare($sql);
    
                $dados = array(':numero_aluno' => $_GET['numero_aluno'],
                               ':identificacao_turma' => $_GET['identificacao_turma']);
    
                if ($stmt->execute($dados)) {
                    header("Location: matricula.php?msgSucesso=Matrícula excluída com sucesso!!");
                }
                else {
                    header("Location: matricula.php?msgSucesso=Falha ao EXCLUIR matricula..");
                }
            } catch (PDOException $e) {
            //die($e->getMessage());
            header("Location: matricula.php?msgSucesso=Falha ao EXCLUIR matricula..");
            }
      }
      else{
        header("Location: matricula.php?msgErro=Erro de acesso (Operação não definida)QUEEEE.");
      }
}
elseif (!empty($_POST)) {

  if ($_POST['enviarDados'] == 'ALT') { // ALTERAR!!!
    /* Implementação do update aqui.. */
    // Construir SQL para update
    // 
        $sql1 = "SELECT * FROM matricula 
                WHERE 
                identificacao_turma = :identificacao_turma
                AND
                numero_aluno = :numero_aluno";
        try {
          $stmt = $pdo->prepare($sql1);
      
          $stmt->execute(array(':identificacao_turma' => $_POST['identificacao_turma'],
                               ':numero_aluno' => $_POST['numero_aluno']));
          
          if ($stmt->rowCount() == 1) {
            header("Location: matricula.php?msgErro=Matrícula já cadastrada");
              // echo '<pre>';
              // print_r($result);
              // echo '</pre>';
              
              // die();
          }
          else {
        //   //die("Não foi encontrado nenhum registro para id_anuncio = " . $_GET['id_anuncio'] . " e e-mail = " . $_SESSION['email']);
        //   header("Location: ../login/index_logado.php?msgErro=Você não tem permissão para acessar esta página");
        //   die();
            $sql = "UPDATE
            matricula
            SET
            identificacao_turma = :identificacao_turma
            WHERE
            identificacao_turma= :numero_turma
            AND
            numero_aluno = :numero_aluno";

            try {
                $stmt = $pdo->prepare($sql);

                // Definir dados para SQL
                $dados = array(
                ':identificacao_turma' => $_POST['identificacao_turma'],
                ':numero_turma' => $_POST['numero_turma'],
                ':numero_aluno' => $_POST['numero_aluno']
                );

                // Executar SQL
                if ($stmt->execute($dados)) {
                header("Location: matricula.php?msgSucesso=Alteração realizada com sucesso!!");
                }
                else {
                header("Location: matricula.php?msgErro=Falha ao ALTERAR turma..");
                }
            } catch (PDOException $e) {
                //die($e->getMessage());
                header("Location: matricula.php?msgErro=Falha ao ALTERAR turma..");
            }
         }
        } catch (PDOException $e) {
          header("Location: ../login/index_logado.php?msgErro=Falha ao obter registro no banco de dados.");
          //die($e->getMessage());
        }
  }
  else {
    header("Location: matricula.php?msgErro=Erro de acesso (Operação não definida).");
  }
}
else {
  header("Location: ../login/index_logado.php?msgErro=Erro de acesso.");
}
die();

// Redirecionar para a página inicial (index_logado) c/ mensagem erro/sucesso
 ?>