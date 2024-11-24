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