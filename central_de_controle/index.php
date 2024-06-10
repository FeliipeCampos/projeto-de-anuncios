<?php
include '../conexao.php';

session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['id'] !== 1) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Central de controle</title>
  <!-- Conexões para o Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>
    <?php include 'header.php';?>
    <main class="container mt-4">
        <div class="row">
            <div class="col-sm-12 mb-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="card-title text-center">Faturamento</h5>
                        <p class="card-text text-center">Valor bruto: <strong>R$ <?php echo number_format(50000, 2, ',', '.'); ?></strong></p>
                        <p class="card-text text-center">Lucro: <strong>R$ <?php echo number_format(15000, 2, ',', '.'); ?></strong></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mb-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="card-title text-center">Usuários</h5>
                        <p class="card-text text-center"><strong><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM usuarios")); ?></strong> usuários cadastrados</p>
                        <div class="text-center">
                            <a href="usuarios.php" class="btn btn-primary">Ver usuários</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mb-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="card-title text-center">Anúncios</h5>
                        <p class="card-text text-center"><strong><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM anuncios")); ?></strong> anúncios cadastrados</p>
                        <div class="text-center">
                            <a href="anuncios.php" class="btn btn-primary">Ver anúncios</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 mb-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="card-title text-center">Candidaturas</h5>
                        <p class="card-text text-center"><strong><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM candidaturas")); ?></strong> candidaturas recebidas</p>
                        <div class="text-center">
                            <a href="candidaturas.php" class="btn btn-primary">Ver candidaturas</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
