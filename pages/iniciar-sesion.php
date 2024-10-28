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
        <h1>Formulario para guardar datos en la base de datos</h1>
        <form>
        <!-- Selector Persona o Empresa -->
        <div class="form-check form-switch mb-3">
            <input type="checkbox" class="form-check-input" id="isCompanySwitch" onchange="toggleForm()">
            <label class="form-check-label" for="isCompanySwitch">¿Es una empresa?</label>
        </div>

        <!-- Campos comunes: Nombre, Apellido, Correo -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" required>
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" required>
        </div>
        <div class="mb-3" id="dniField">
            <label for="dni" class="form-label">DNI</label>
            <input type="text" class="form-control" id="dni" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo" required>
        </div>

        <!-- Campos adicionales para Empresa: Razón Social y CUIT -->
        <div class="mb-3" id="razonSocialField" style="display: none;">
            <label for="razonSocial" class="form-label">Razón Social</label>
            <input type="text" class="form-control" id="razonSocial">
        </div>
        <div class="mb-3" id="cuitField" style="display: none;">
            <label for="cuit" class="form-label">CUIT</label>
            <input type="text" class="form-control" id="cuit">
        </div>

        <!-- Botón de Envío -->
        <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

        <script>
        function toggleForm() {
            const isCompany = document.getElementById('isCompanySwitch').checked;
            document.getElementById('dniField').style.display = isCompany ? 'none' : 'block';
            document.getElementById('razonSocialField').style.display = isCompany ? 'block' : 'none';
            document.getElementById('cuitField').style.display = isCompany ? 'block' : 'none';
        }
        </script>


    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
