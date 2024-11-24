<nav class="navbar navbar-expand-lg bg-body-tertiary">

  <div class="container-fluid">

    <a class="navbar-brand text-success Sinergia" href="#">
        Sinergia
        <span class="gif-ventilador"></span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse menu" id="navbarSupportedContent">

      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="./index.php">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="./pages/proyectos.php">Proyectos</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="./pages/proyeccion.php">Proyeccion</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="./pages/demanda.php">Demanda</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="./pages/generacion.php">Generacion</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="./pages/login.php">Login</a>
        </li>

          <!-- Avatar con nombre de usuario y logout -->
          <?php if (isset($_SESSION['id_usuario'])): ?>
          <!-- Si la sesión está activa, mostramos el dropdown con el nombre del usuario -->
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa-solid fa-user-tie text-dark"></i>
                  <!-- Mostrar el nombre del usuario almacenado en la sesión -->
                  <span class="ms-2 text-dark"><?php echo $_SESSION['nombre']; ?></span>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="#">Perfil</a></li>
                  <li><a class="dropdown-item" href="#">Ajustes</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <!-- Enlazar con el script que cierre la sesión -->
                  <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
              </ul>
          </li>
        <?php else: ?>
          <!-- Si no hay sesión, no mostramos el dropdown -->
          <!-- Aquí puedes poner algún enlace de login si lo deseas -->
        <?php endif; ?>


      </ul>


      <!-- Avatar con nombre de usuario y logout -->
      <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-user-tie text-dark"></i>
            <span class="ms-2 text-dark">Usuario</span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Perfil</a></li>
            <li><a class="dropdown-item" href="#">Ajustes</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Cerrar Sesion</a></li>
          </ul>
        </li> -->

      <!-- <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form> -->

    </div>
  </div>
</nav>