import { hashStringToUnitInterval } from './utils.js';

const backgroundColors = [
    '#f87171',
    '#fb923c',
    '#fbbf24',
    '#facc15',
    '#a3e635',
    '#4ade80',
    '#34d399',
    '#2dd4bf',
    '#22d3ee',
    '#38bdf8',
    '#60a5fa',
    '#818cf8',
    '#a78bfa',
    '#c084fc',
    '#e879f9',
    '#f472b6',
    '#fb7185',
];

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
