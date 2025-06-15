import { updateAvatar } from '../../js/avatar.js';

const avatars = document.querySelectorAll('.avatar');

for (const avatar of avatars) {
    const firstName = avatar.dataset.firstName;
    const lastName = avatar.dataset.lastName;

    updateAvatar(avatar, firstName, lastName);
    avatar.classList.remove('animate-pulse');
}
