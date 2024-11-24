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

// Validacion de l contraseña con expresion regular
function validatePassword() {
    const passwordInput = document.getElementById('register-password');
    const helpText = document.getElementById('password-help');
  
    // Define las reglas
    const minLength = /.{10,}/; // Al menos 10 caracteres
    const hasUpperCase = /[A-Z]/; // Al menos una letra mayúscula
    const hasLowerCase = /[a-z]/; // Al menos una letra minúscula
    const hasNumber = /[0-9]/;    // Al menos un número
  
    // Toma el valor actual del input
    const password = passwordInput.value;
  
    // Verifica las condiciones
    const isValid =
      minLength.test(password) &&
      hasUpperCase.test(password) &&
      hasLowerCase.test(password) &&
      hasNumber.test(password);
  
    // Actualiza el mensaje dinámicamente
    if (isValid) {
      helpText.textContent = 'Contraseña válida ✅';
      helpText.classList.remove('text-danger');
      helpText.classList.add('text-success');
    } else {
      helpText.textContent = 'La contraseña debe tener 10 caracteres, incluyendo una mayúscula, una minúscula y un número.';
      helpText.classList.remove('text-success');
      helpText.classList.remove('d-none');
      helpText.classList.add('text-danger');
    }
  }
  