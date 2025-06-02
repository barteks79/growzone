import { updateAvatar } from '../../js/avatar.js';

/** @type {HTMLDivElement} */
const avatar = document.querySelector('#avatar');
/** @type {HTMLInputElement} */
const firstName = document.querySelector('#first-name');
/** @type {HTMLInputElement} */
const lastName = document.querySelector('#last-name');
/** @type {HTMLInputElement} */
const passwordInput = document.querySelector('#password');
/** @type {HTMLSpanElement} */
const passwordCapsWarning = document.querySelector('#password-caps-warning');
/** @type {HTMLButtonElement} */
const passwordToggle = document.querySelector('#toggle-password');
/** @type {HTMLSpanElement[]} */
const passwordStrengthBars = document.querySelectorAll('#password-strength-bars span');
/** @type {HTMLSpanElement} */
const passwordStrengthText = document.querySelector('#password-strength-text');

firstName.addEventListener('input', () =>
    updateAvatar(avatar, firstName.value, lastName.value),
);
lastName.addEventListener('input', () =>
    updateAvatar(avatar, firstName.value, lastName.value),
);
if (firstName.value || lastName.value) {
    updateAvatar(avatar, firstName.value, lastName.value);
}

passwordToggle.addEventListener('click', () => {
    passwordInput.type = passwordInput.type == 'text' ? 'password' : 'text';
    passwordInput.focus();
});

document.addEventListener('keydown', event => {
    if (event.key != 'CapsLock') return;

    passwordCapsWarning.dataset.active =
        passwordCapsWarning.dataset.active == 'true' ? 'false' : 'true';
});

passwordInput.addEventListener('input', updatePasswordStrength);
updatePasswordStrength();

function updatePasswordStrength() {
    const strength = evaluatePasswordStrength(passwordInput.value);

    for (const element of passwordStrengthBars) {
        element.dataset.strength = strength;
    }

    passwordStrengthText.textContent = getPasswordStrengthText(strength);
}

/** @param {number} strength */
function getPasswordStrengthText(strength) {
    switch (strength) {
        case 1:
            return 'Very Weak';
        case 2:
            return 'Weak';
        case 3:
            return 'Good';
        case 4:
            return 'Strong';
        default:
            return '';
    }
}

/** @param {string} password */
function evaluatePasswordStrength(password) {
    if (!password) return 0;

    const lengthCheck = password.length >= 8;
    const upperCaseCheck = /[A-Z]/.test(password);
    const lowerCaseCheck = /[a-z]/.test(password);
    const numberCheck = /[0-9]/.test(password);
    const symbolCheck = /[^A-Za-z0-9]/.test(password);

    let strength = 0;

    if (lengthCheck) {
        strength += 1;
    }

    if (upperCaseCheck) {
        strength += 1;
    }

    if (lowerCaseCheck) {
        strength += 1;
    }

    if (numberCheck || symbolCheck) {
        strength += 1;
    }

    return strength;
}
