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
if (isset($_GET['id'])) {
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
?>

</head>
<body>
  <?php
    include 'header.php';
  ?>
<main class="container mt-4 mb-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title"><?php echo $titulo; ?></h1>
                    <form action="candidatar.php?id_anuncio=<?php echo $id; ?>" method="post">
                        <div class="form-group">
                            <label for="quantidade_dias">Quantidade de dias para concluir o trabalho:</label>
                            <input type="number" class="form-control" id="quantidade_dias" name="quantidade_dias" required>
                        </div>

                        <div class="form-group">
                            <label for="preco">Preço desejado:</label>
                            <input type="number" class="form-control" id="preco" name="preco" step="0.01" required>
                        </div>

                        <div class="form-group">
                            <h2 class="card-subtitle mb-2" style="font-size: 1.5rem;">O anunciante pretende pagar:</h2>
                            <p class="card-text"><strong>Valor mínimo:</strong> R$<?php echo $valor_minimo; ?></p>
                            <p class="card-text"><strong>Valor máximo:</strong> R$<?php echo $valor_maximo; ?></p>
                        </div>

                        <?php
                        // verifica se existe uma sessão ativa
                        if (isset($_SESSION['usuario'])) {
                            echo '<button type="submit" class="btn btn-success">Dar proposta</button>';
                        } else {
                            echo '<a type="button" class="btn btn-primary" href="login/index.php">Faça login para se candidatar</a>';
                        }
                        ?>
                    </form>
                    <a type="button" class="btn btn-primary mt-3 mr-2" href="anuncio.php?id=<?php echo $id; ?>">Voltar</a>
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