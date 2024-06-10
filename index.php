<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Anúncios</title>
  <!-- Conexões para o Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <?php
    include 'conexao.php';
    session_start();
  ?>
</head>
<body>
  <?php
    include 'header.php';
  ?>
  <main class="container mt-4">
    <div class="row">
      <div class="col-md-3">
        <form method="get" action="" class="mb-4">
          <div class="form-group">
            <label for="categoria">Filtrar por Categoria:</label>
            <select class="form-control" id="categoria" name="categoria">
              <option value="" disabled selected>Selecione uma categoria</option>
              <option value="" style="font-weight: bold;">Ver todos</option>
              <option value="Desenvolvimento">Desenvolvimento</option>
              <option value="Design">Design</option>
              <option value="Redação e Tradução">Redação e Tradução</option>
              <option value="Marketing Digital">Marketing Digital</option>
              <option value="Audiovisual">Audiovisual</option>
              <option value="Consultoria">Consultoria</option>
              <option value="Serviços Criativos">Serviços Criativos</option>
              <option value="Administração de Projetos">Administração de Projetos</option>
              <option value="Suporte Técnico">Suporte Técnico</option>
              <option value="Educação e Ensino">Educação e Ensino</option>
              <option value="Saúde e Bem-Estar">Saúde e Bem-Estar</option>
              <option value="Serviços de Tradução e Transcrição">Serviços de Tradução e Transcrição</option>
              <option value="Serviços de Assistência Virtual">Serviços de Assistência Virtual</option>
              <option value="Serviços de Design de Embalagens">Serviços de Design de Embalagens</option>
              <option value="Serviços de Pesquisa de Mercado">Serviços de Pesquisa de Mercado</option>
              <option value="Serviços de Contabilidade e Finanças">Serviços de Contabilidade e Finanças</option>
              <option value="Serviços Jurídicos">Serviços Jurídicos</option>
              <option value="Serviços de Tradução e Localização de Sites">Serviços de Tradução e Localização de Sites</option>
              <option value="Serviços de Gerenciamento de Redes Sociais">Serviços de Gerenciamento de Redes Sociais</option>
              <option value="Serviços de SEO e Marketing de Conteúdo">Serviços de SEO e Marketing de Conteúdo</option>
            </select>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
      <?php
        if (isset($_GET['categoria'])) {
          $categoria = $_GET['categoria'];
          if (!empty($categoria)) {
            // Categoria selecionada, inclui a categoria na consulta SQL
            $sql = "SELECT * FROM anuncios WHERE categoria = ? AND status = 'ativo'";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $categoria);
          } else {
            // Categoria vazia, selecionou "Ver todos", consulta todos os anúncios
            $sql = "SELECT * FROM anuncios WHERE status = 'ativo'";
            $stmt = mysqli_prepare($conn, $sql);
          }
        } else {
          // Se a categoria não estiver definida, consulta todos os anúncios
          $sql = "SELECT * FROM anuncios WHERE status = 'ativo'";
          $stmt = mysqli_prepare($conn, $sql);
        }
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // loop para exibir cada anúncio no formato de card
        while ($row = mysqli_fetch_assoc($result)) {
          $id = $row['id'];
          $titulo = $row['titulo'];
          $descricao = $row['descricao'];
          $valor_minimo = $row['valor_minimo'];
          $valor_maximo = $row['valor_maximo'];
          $data_criacao = $row['data_criacao'];
          $categoria = $row['categoria'];
      ?>
        <!-- Área do card -->
        <div class="col-sm-6 mb-4">
          <div class="card shadow-sm h-100">
            <div class="card-body">
              <h5 class="card-title"><?php echo $titulo; ?></h5>
              <p class="card-text"><?php echo substr($descricao, 0, 100); ?>...</p>
              <p class="card-text"><strong>Categoria:</strong> <?php echo $categoria; ?></p>
            </div>
            <div class="card-footer">
              <div class="d-flex justify-content-between align-items-center">
                <p class="card-text text-muted mb-0">Valor mínimo: R$ <?php echo number_format($valor_minimo, 2, ',', '.'); ?></p>
                <p class="card-text text-muted mb-0">Valor máximo: R$ <?php echo number_format($valor_maximo, 2, ',', '.'); ?></p>
              </div>
              <div class="d-flex justify-content-between align-items-center mt-2">
                <p class="card-text text-muted mb-0">Criado em: <?php echo date('d/m/Y', strtotime($data_criacao)); ?></p>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalCenter_<?php echo $row['id']; ?>">Ver mais detalhes</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Área do card end-->

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter_<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo $titulo; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p><strong>Descrição:</strong> <?php echo $descricao; ?></p>
                <p><strong>Data de criação:</strong> <?php echo date('d/m/Y', strtotime($data_criacao)); ?></p>
                <p><strong>Valor mínimo:</strong> R$ <?php echo number_format($valor_minimo, 2, ',', '.'); ?></p>
                <p><strong>Valor máximo:</strong> R$ <?php echo number_format($valor_maximo, 2, ',', '.'); ?></p>
                <p><strong>Categoria:</strong> <?php echo $categoria; ?></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <a type="button" class="btn btn-primary" href="anuncio.php?id=<?php echo $id; ?>">Ir para página do anúncio</a>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal end-->
        <?php }?>
    </div>
  </main>
  <script>
    // obter o elemento select de categoria
    var selectCategoria = document.getElementById('categoria');
    // adicionar evento de mudança
    selectCategoria.addEventListener('change', function() {
      // obter o valor selecionado
      var categoriaSelecionada = selectCategoria.value;
      // redirecionar para a página com a categoria selecionada como parâmetro de consulta
      window.location.href = '?categoria=' + categoriaSelecionada;
    });
  </script>
</body>
</html>