let password = document.getElementById('password');
let confirm_password = document.getElementById('confirm-password');

function validarContraseñas(password, confirm_password) {
    if (password.value !== confirm_password.value) {
        confirm_password.setCustomValidity('Las contraseñas no coinciden');
    } else {
        confirm_password.setCustomValidity(''); // Limpia el mensaje de error
    }
}

// Llama a la función cuando el valor de cualquiera de los dos campos cambie
password.onchange = function() {
    validarContraseñas(password, confirm_password);
};

confirm_password.onkeyup = function() {
    validarContraseñas(password, confirm_password);
};
