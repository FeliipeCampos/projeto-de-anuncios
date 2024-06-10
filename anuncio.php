<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meus Anúncios</title>
  <!-- Conexões para o Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <?php
    include 'conexao.php';
    session_start();
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
      $id = $_GET['id'];
    } else {
      header('Location: erro.php');
      exit;
    }
    $sql = "SELECT * FROM anuncios WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
      header('Location: erro.php');
      exit;
    }
    $row = mysqli_fetch_assoc($result);
    $titulo = $row['titulo'];
    $descricao = $row['descricao'];
    $valor_minimo = $row['valor_minimo'];
    $valor_maximo = $row['valor_maximo'];
    $data_criacao = $row['data_criacao'];
    $categoria = $row['categoria'];
  ?>
</head>
<body>
  <?php include 'header.php'; ?>

  <main class="container mt-4 mb-4">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h1 class="card-title"><?php echo $titulo; ?></h1>
            <h5 class="card-subtitle mb-2"><strong>Categoria:</strong> <?php echo $categoria; ?></h5>
            <p class="card-text"><?php echo $descricao; ?></p>
            <h5 class="card-subtitle mb-2"><strong>O anunciante pretende pagar:</strong></h5>
            <p class="card-text"><strong>Valor mínimo:</strong> R$<?php echo $valor_minimo; ?></p>
            <p class="card-text"><strong>Valor máximo:</strong> R$<?php echo $valor_maximo; ?></p>
            <p class="card-text"><small class="text-muted">Anúncio criado em: <?php echo date('d/m/Y', strtotime($data_criacao)); ?></small></p>

            <div class="mt-3">
              <?php
                // Consulta a tabela de anúncios para obter o ID do usuário que criou o anúncio
                $sql_anuncio = "SELECT * FROM anuncios WHERE id = $id";
                $result_anuncio = mysqli_query($conn, $sql_anuncio);
                $row_anuncio = mysqli_fetch_assoc($result_anuncio);
                $id_criador_anuncio = $row_anuncio['id_criador'];

                // Verifica se o usuário atual é o criador do anúncio
                if (isset($_SESSION['usuario'])) {
                    $id_criador = $_SESSION['usuario']['id'];
                    if ($id_criador == $id_criador_anuncio) {
                        // Se o usuário atual é o criador do anúncio, mostra o aviso
                        echo '<div class="alert alert-warning" role="alert">
                                Você não pode se candidatar a este anúncio, pois você o criou.
                              </div>';
                    } else {
                        // Se o usuário atual não é o criador do anúncio, continua a verificação de candidatura
                        $sql = "SELECT * FROM candidaturas WHERE id_anuncio = $id AND id_usuario = $id_criador";
                        $result = mysqli_query($conn, $sql);
                        if ($result && mysqli_num_rows($result) > 0) {
                            // se o usuário já se candidatou, mostra o aviso
                            echo '<div class="alert alert-warning" role="alert">
                                Você já se candidatou a este anúncio.
                              </div>';
                        } else {
                            // se o usuário ainda não se candidatou, mostra o link de candidatura
                            echo '<a class="btn btn-success" href="candidatar-se.php?id=' . $id . '">Candidatar-se</a>'; 
                            // Adicione o ID do anúncio como parâmetro na URL do link
                        }
                    }
                } else {
                    echo '<a type="button" class="btn btn-primary" href="login/index.php">Faça login para se candidatar</a>';
                }
              ?>
            </div>
            <div class="mt-3">
              <a type="button" class="btn btn-primary" href="index.php">Voltar</a>
            </div>
          </div>
        </div>
      </div>
        <!-- inicio relatorio -->
        <?php 
        $sql = "SELECT * FROM candidaturas WHERE id_anuncio = $id";
        $result = mysqli_query($conn, $sql);

        // Verifica se há resultados na consulta
        if (mysqli_num_rows($result) == 0) {
            // Preenche as variáveis com valores indicando que ainda não existem dados
            $numPessoasCandidatadas = 0;
            $totalPropostas = 0;
            $totalTempo = 0;
            $mediaPropostas = 0;
            $mediaTempo = 0;
        } else {
            // Conta a quantidade de candidaturas
            $numPessoasCandidatadas = mysqli_num_rows($result);

            // Calcula a média dos valores das propostas
            $totalPropostas = 0;
            $totalTempo = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $totalPropostas += $row['valor'];
                $totalTempo += $row['tempo'];
            }
            $mediaPropostas = $numPessoasCandidatadas > 0 ? $totalPropostas / $numPessoasCandidatadas : 0;
            $mediaTempo = $numPessoasCandidatadas > 0 ? $totalTempo / $numPessoasCandidatadas : 0;
        }

        // Inclui o arquivo relatorio.php
        include 'relatorio.php';
        ?>
        <!-- fim relatorio -->
    </div>
  </main>
</body>
</html>