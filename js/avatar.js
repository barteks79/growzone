import { hashStringToUnitInterval } from './utils.js';

/**
 * @param {HTMLElement} target
 * @param {string} firstName
 * @param {string} lastName
 */
export function updateAvatar(target, firstName, lastName) {
    const first = firstName.trim();
    const last = lastName.trim();

    const firstInitial = first.charAt(0).toUpperCase();
    const lastInitial = last.charAt(0).toUpperCase();
    target.textContent = `${firstInitial}${lastInitial}`;

    const colors = ['#FF3399', '#FFCC00', '#33CC33', '#3399FF', '#9933FF', '#FF6600'];
    const colorIndex = hashStringToUnitInterval(`${first} ${last}`);
    target.style.background = colors[Math.floor(colorIndex * colors.length)];
}
