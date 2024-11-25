const userTypeSwitch = document.getElementById('userTypeSwitch');
const registerLink = document.getElementById('register-link');
const logeateLink = document.getElementById('logeate-link'); // Permutar logeo
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

logeateLink.addEventListener('click', (e) => {
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

// Validación de la contraseña con expresión regular
function validatePassword() {
    const passwordInput = document.getElementById('register-password');
    const helpText = document.getElementById('password-help');

    // Define las reglas
    const minLength = /.{10,}/; // Al menos 10 caracteres
    const hasUpperCase = /[A-Z]/; // Al menos una letra mayúscula
    const hasLowerCase = /[a-z]/; // Al menos una letra minúscula
    const hasNumber = /[0-9]/; // Al menos un número

    // Verifica si todas las reglas se cumplen
    if (minLength.test(passwordInput.value) && hasUpperCase.test(passwordInput.value) &&
        hasLowerCase.test(passwordInput.value) && hasNumber.test(passwordInput.value)) {
        helpText.classList.add('d-none');
    } else {
        helpText.classList.remove('d-none');
    }
}
