/** @type {HTMLInputElement} */
const passwordInput = document.querySelector('#password');
/** @type {HTMLButtonElement} */
const passwordToggle = document.querySelector('#toggle-password');

passwordToggle.addEventListener('click', () => {
    passwordInput.type = passwordInput.type == 'text' ? 'password' : 'text';
    passwordInput.focus();
});
