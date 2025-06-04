import { hashStringToUnitInterval } from './utils.js';

const backgroundColors = ['#FF3399', '#FFCC00', '#33CC33', '#3399FF', '#9933FF', '#FF8400'];

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

    const unitIndex = hashStringToUnitInterval(`${first} ${last}`);
    const index = Math.floor(unitIndex * backgroundColors.length);
    target.style.setProperty('--primary', backgroundColors[index]);
}
