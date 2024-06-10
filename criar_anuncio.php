<?php
session_start();
if (!isset($_SESSION['usuario'])) {
  header('Location: login/index.php');
  exit;
}
// Verifica se a variável 'id' está presente na URL
if (isset($_GET['id'])) {
  // Captura o valor da variável 'id' da URL
  $id = $_GET['id'];    
}
?>
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

</head>
<body>
  <?php include 'header.php'; ?>
  <main class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Criar anúncio</div>
        <div class="card-body">
          <!-- formulário de criação de anúncio -->
          <form action="insert_anuncio.php" method="POST">
            <div class="form-group">
              <label for="titulo">Título:</label>
              <input type="text" class="form-control" id="titulo" name="titulo" required>
              <input type="hidden" name="id_criador" value="<?php echo $id; ?>">
            </div>
            <div class="form-group">
              <label for="descricao">Descrição:</label>
              <textarea class="form-control" id="descricao" name="descricao" rows="5" minlength="50" maxlength="1000" required></textarea>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="valor-minimo">Valor Mínimo:</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">R$</span>
                  </div>
                  <input type="number" step="0.01" class="form-control" id="valor-minimo" name="valor_minimo" required>
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="valor-maximo">Valor Máximo:</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">R$</span>
                  </div>
                  <input type="number" step="0.01" class="form-control" id="valor-maximo" name="valor_maximo" required>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="categoria">Categoria:</label>
              <select class="form-control" id="categoria" name="categoria" required>
                <option value="" disabled selected>Selecione uma categoria</option>
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
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Criar</button>
              <a href="index.php" class="btn btn-secondary">Voltar</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>

</html>