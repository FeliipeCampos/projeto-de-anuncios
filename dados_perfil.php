<?php
  // seleciona o usuário correspondente ao id capturado
  $sql = "SELECT * FROM usuarios WHERE id = $id";
  $result = mysqli_query($conn, $sql);
  // verifica se o usuário foi encontrado
  if (mysqli_num_rows($result) == 0) {
    // redireciona o usuário para uma página de erro
    header('Location: erro.php');
    exit;
  }
  // recupera os dados do usuário e atribui a variáveis
  $row = mysqli_fetch_assoc($result);
  $nome = $row['nome'];
  $sobrenome = $row['sobrenome'];
  $data_nascimento = $row['data_nascimento'];
  $data_criacao = $row['data_criacao'];
  $descricao = $row['descricao'];
?>
<div class="card">
    <div class="card-body">
    <h1><?php echo ucfirst(strtolower($nome)) . ' ' . ucfirst(strtolower($sobrenome)); ?></h1>
    <p><strong>Data de nascimento:</strong> <?php echo date('d/m/Y', strtotime($data_nascimento)); ?></p>
    <p class="mt-3"><small class="text-muted">Usuário criado em: <?php echo date('d/m/Y', strtotime($data_criacao)); ?></small></p>
    </div>
</div>
<div class="mt-3">
    <a type="button" class="btn btn-primary" href="index.php">Voltar</a>
</div>