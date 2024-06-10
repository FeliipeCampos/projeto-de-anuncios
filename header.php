<header>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Index</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mr-auto">
        <?php if(isset($_SESSION['usuario'])) { 
          $nome_usuario = ucfirst(strtolower($_SESSION['usuario']['nome'])) . ' ' . ucfirst(strtolower($_SESSION['usuario']['sobrenome'])); 
          $id_usuario = $_SESSION['usuario']['id']; // Armazena o ID do usuário na variável $id_usuario
        ?>
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Início</a> 
          </li>
          <li class="nav-item">
            <a class="nav-link" href="minhas_candidaturas.php?id=<?php echo $id_usuario; ?>">Candidaturas</a> 
          </li>
          <li class="nav-item">
            <a class="nav-link" href="criar_anuncio.php?id=<?php echo $id_usuario; ?>">Criar anúncio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="perfil.php?id=<?php echo $id_usuario; ?>">Perfil</a> 
          </li>
          <li class="nav-item">
            <a class="nav-link" href="gerenciar_anuncios.php?id=<?php echo $id_usuario; ?>">Gerenciar anúncios</a> 
          </li>
        <?php } ?>
      </ul>
      <ul class="navbar-nav ml-auto">
        <?php if(isset($_SESSION['usuario'])) { ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $nome_usuario; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="login/logout.php">Sair</a>
            </div>
          </li>
        <?php } else { ?>
          <li class="nav-item ml-auto">
            <a class="nav-link" href="login/">Entrar</a>
          </li>
        <?php } ?>
      </ul>
    </div>
  </nav>
</header>
