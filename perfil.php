<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil de usuário</title>
  <!-- Conexões para o Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <?php
    include 'conexao.php';
    
    session_start();

    // verifica se o parâmetro "id" está presente na URL
    if (isset($_GET['id'])) {
      // captura o valor do parâmetro "id" e atribui a uma variável
      $id = $_GET['id'];
    } else {
      // redireciona o usuário para uma página de erro
      header('Location: erro.php');
      exit;
    }
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
</head>
<body>
  <?php
    include 'header.php';
  ?>
<!-- Conteúdo da página -->
<main class="container mt-4">
  <div class="card">
    <div class="card-body">
      <h1><?php echo ucfirst(strtolower($nome)) . ' ' . ucfirst(strtolower($sobrenome)); ?></h1>
      <p><strong>Data de nascimento:</strong> <?php echo date('d/m/Y', strtotime($data_nascimento)); ?></p>
      <p class="mt-3"><small class="text-muted">Usuário criado em: <?php echo date('d/m/Y', strtotime($data_criacao)); ?></small></p>
    </div>
  </div>
</main>

</body>
</html>
