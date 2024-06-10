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
  <style>
    .message-list {
        max-height: 500px;
        overflow-y: auto;
    }
  </style>
  <?php
    include 'conexao.php';
    session_start();
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    } else {
    header('Location: erro.php');
    exit;
    }
  ?>
</head>

<body>
  <?php include 'header.php'; ?>

    <?php
    // Consulta os dados do anúncio
    $sql = "SELECT titulo, id_criador FROM anuncios WHERE id = $id";
    $anuncio = mysqli_fetch_assoc(mysqli_query($conn, $sql));

    // Consulta os dados do candidato selecionado
    $sql = "SELECT id_usuario FROM candidaturas WHERE id_anuncio = $id AND status = 'selecionado'";
    $candidato = mysqli_fetch_assoc(mysqli_query($conn, $sql));

    // Armazena as informações do anúncio e do contratante
    $id_anuncio = $id;
    $id_contratante = $anuncio['id_criador'];
    $titulo = $anuncio['titulo'];
    $id_contratado =  $candidato['id_usuario'];

    // Verifica se o formulário foi enviado e insere a mensagem no banco de dados
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $mensagem = mysqli_real_escape_string($conn, $_POST['mensagem']);
    
        if (!empty($mensagem)) {
        $sql = "INSERT INTO chat (id_anuncio, id_contratante, id_contratado, data_hora, mensagem) VALUES ('$id_anuncio', '$id_contratante', '$id_contratado', NOW(), '$mensagem')";
        mysqli_query($conn, $sql);
        }
    }
    
    // Consulta as mensagens do chat somente se o formulário não tiver sido enviado
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $sql = "SELECT * FROM chat WHERE id_anuncio = $id AND ((id_contratante = $id_contratante AND id_contratado = $id_contratado) OR (id_contratante = $id_contratado AND id_contratado = $id_contratante)) ORDER BY data_hora ASC";
        $result = mysqli_query($conn, $sql);
    }
    

    // Consulta as mensagens do chat
    $sql = "SELECT * FROM chat WHERE id_anuncio = $id AND ((id_contratante = $id_contratante AND id_contratado = $id_contratado) OR (id_contratante = $id_contratado AND id_contratado = $id_contratante)) ORDER BY data_hora ASC";
    $result = mysqli_query($conn, $sql);
    ?>

    <main class="container mt-4 mb-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><?php echo $titulo; ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="message-list overflow-auto max-height-400">
                            <?php while ($row = mysqli_fetch_assoc($result)) {
                            $classe = ($row['id_contratante'] == $id_contratante) ? 'message-sent' : 'message-received';
                            ?>
                            <div class="message-item <?php echo $classe; ?> border rounded p-2 mb-2">
                                <div class="message-avatar"></div>
                                <div class="message-content">
                                <div class="message-text"><?php echo $row['mensagem']; ?></div>
                                <div class="text-muted"><?php echo date('d/m/Y H:i', strtotime($row['data_hora'])); ?></div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <form class="message-form" method="post">
                            <div class="input-group">
                                <input type="text" class="form-control" name="mensagem" placeholder="Digite sua mensagem">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>