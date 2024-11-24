<?php
    // Iniciar sesión para acceder a mensajes
    session_start();

    // Mostrar mensajes si existen
    $message = "";
    if (isset($_SESSION['message'])) {
        // se agrego margen ingerior y superior"
        $message = "<div class='my-2 alert alert-" . ($_SESSION['message_type'] === "success" ? "success" : "danger") . "'>" 
                . $_SESSION['message'] . 
                "</div>";
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="container Fondo-principal">
        <?php include '../drivers/menuPages.php'; ?>
        <section class="container my-5">
            <div class="row g-4">
                <!-- Left Form Section -->
                <div class="col-md-6">
                    <div id="form-container">
                        <h2 id="form-title" class="mb-3">Iniciar Sesión</h2>

                        <!-- Switch for Persona/Empresa -->
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="userTypeSwitch" name="userTypeSwitch">
                            <label class="form-check-label" for="userTypeSwitch">Empresa</label>
                        </div>

                        <!-- Login Form -->
                        <form id="login-form" method="post" action="ingresar.php">
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="#" class="link-primary">Recuperar contraseña</a>
                                <a href="#" id="register-link" class="link-secondary">¿No tienes cuenta? Regístrate</a>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 w-100">Ingresar</button>
                        </form>

                        <!-- Mostrar mensaje -->
                        <?php echo $message; ?>
                        <!-- Register Form -->
                        <form id="register-form" class="d-none" method="post" action="registrar.php">
                            <div class="mb-3" id="name-field">
                                <label for="name" class="form-label">Nombre y Apellido</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="register-email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="register-email" name="register-email" required>
                            </div>
                            <div class="mb-3" id="dni-cuit-field">
                                <label for="dni-cuit" class="form-label">DNI</label>
                                <input type="text" class="form-control" id="dni-cuit" name="dni-cuit" required>
                            </div>
                            <div class="mb-3">
                                <label for="register-password" class="form-label">Contraseña</label>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="register-password" 
                                    name="register-password" 
                                    required 
                                    minlength="10"
                                    oninput="validatePassword()">
                                <small id="password-help" class="form-text text-danger d-none">
                                    La contraseña debe tener al menos 10 caracteres, incluyendo una mayúscula, una minúscula y un número.
                                </small>
                            </div>
                            <div class="mb-3 d-none" id="description-field">
                                <label for="description" class="form-label">Descripción de la Empresa</label>
                                <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                            </div>
                            <div class="d-flex justify-content-between">
                                <input type="hidden" id="userType" name="userType" value="persona">
                                <a href="#" id="logeate-link" class="text-primary ">¿Ya tienes cuenta? Logeate</a>
                            </div>
                            <button type="submit" class="btn btn-success mt-3 w-100">Registrarse</button>
                        </form>
                    </div>
                </div>

                <!-- Right Image Section -->
                <div class="col-md-6">
                    <div class="image-container">
                        <img src="../assets/fondo-login.avif" alt="Fondo">
                        <div class="overlay-text" id="overlay-text">Bienvenido nuevamente</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/login.js"></script>
</body>
</html>
