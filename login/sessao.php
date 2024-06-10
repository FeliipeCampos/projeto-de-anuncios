<?php

include_once '../conexao.php';

// verifica se foi enviado um POST com os dados do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // recupera os dados do formulário
  $email = $_POST['email'];
  $senha = $_POST['senha'];

  // prepara a query SQL para buscar o usuário no banco de dados
  $sql = "SELECT * FROM usuarios WHERE email = ? LIMIT 1";
  $stmt = mysqli_prepare($conn, $sql);

  // bind do parâmetro
  mysqli_stmt_bind_param($stmt, "s", $email);

  // executa a query
  mysqli_stmt_execute($stmt);

  // recupera o resultado da query
  $result = mysqli_stmt_get_result($stmt);

  // verifica se o usuário existe
  if ($result->num_rows == 1) {
    $usuario = $result->fetch_assoc();

    // verifica se a senha está correta
    if (password_verify($senha, $usuario['senha'])) {
      // inicia a sessão
      session_start();

      // armazena os dados do usuário na sessão
      $_SESSION['usuario'] = $usuario;

      // redireciona para a página principal
      header('Location: ../index.php');
    } else {
      // exibe mensagem de erro
      echo 'Senha incorreta';
    }
  } else {
    // exibe mensagem de erro
    echo 'Usuário não encontrado';
  }

  // fecha o statement
  mysqli_stmt_close($stmt);
}

?>
