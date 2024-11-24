<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container bg-primary-subtle">
        <?php include '../drivers/menuPages.php'; ?>
        <section class="container my-5">
            <div class="row g-4">
                <!-- Left Form Section -->
                <div class="col-md-6">
                    <div id="form-container">
                        <h2 id="form-title" class="mb-3">Iniciar Sesión</h2>

                        <!-- Switch for Persona/Empresa -->
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="userTypeSwitch">
                            <label class="form-check-label" for="userTypeSwitch">Empresa</label>
                        </div>

                        <!-- Login Form -->
                        <form id="login-form">
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

                        <!-- Register Form -->
                        <form id="register-form" class="d-none">
                            <div class="mb-3" id="name-field">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="register-email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="register-email" required>
                            </div>
                            <div class="mb-3" id="dni-cuit-field">
                                <label for="dni-cuit" class="form-label">DNI</label>
                                <input type="text" class="form-control" id="dni-cuit" required>
                            </div>
                            <div class="mb-3">
                                <label for="register-password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="register-password" required>
                            </div>
                            <div class="mb-3 d-none" id="description-field">
                                <label for="description" class="form-label">Descripción de la Empresa</label>
                                <textarea class="form-control" id="description" rows="3"></textarea>
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
    <script>
        const userTypeSwitch = document.getElementById('userTypeSwitch');
        const registerLink = document.getElementById('register-link');
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        const formTitle = document.getElementById('form-title');
        const overlayText = document.getElementById('overlay-text');
        const nameField = document.getElementById('name-field');
        const dniCuitField = document.getElementById('dni-cuit-field');
        const descriptionField = document.getElementById('description-field');

        // Toggle Persona/Empresa Fields
        userTypeSwitch.addEventListener('change', () => {
            if (userTypeSwitch.checked) {
                dniCuitField.querySelector('label').innerText = 'CUIT';
                dniCuitField.querySelector('input').placeholder = 'Ingrese el CUIT';
                nameField.querySelector('label').innerText = 'Nombre o Razón Social';
                descriptionField.classList.remove('d-none');
            } else {
                dniCuitField.querySelector('label').innerText = 'DNI';
                dniCuitField.querySelector('input').placeholder = 'Ingrese el DNI';
                nameField.querySelector('label').innerText = 'Nombre';
                descriptionField.classList.add('d-none');
            }
        });

        // Toggle Between Login and Register Forms
        registerLink.addEventListener('click', (e) => {
            e.preventDefault();
            if (loginForm.classList.contains('d-none')) {
                loginForm.classList.remove('d-none');
                registerForm.classList.add('d-none');
                formTitle.innerText = 'Iniciar Sesión';
                overlayText.innerText = 'Bienvenido nuevamente';
            } else {
                loginForm.classList.add('d-none');
                registerForm.classList.remove('d-none');
                formTitle.innerText = 'Registrarse';
                overlayText.innerText = 'Gracias por confiar en nosotros';
            }
        });
    </script>
</body>
</html>
