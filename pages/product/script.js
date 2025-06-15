import { animate } from 'motion';
import { updateAvatar } from '../../js/avatar.js';

const productPictureContainer = document.querySelector('#product-picture-container');
const productPicture = productPictureContainer?.querySelector('#product-picture');

let isMouseEntered = false;

productPictureContainer?.addEventListener('mouseenter', () => {
    isMouseEntered = true;
    animateItems();
});

productPictureContainer?.addEventListener('mousemove', e => {
    const rect = productPictureContainer.getBoundingClientRect();
    const x = (e.clientX - rect.left - rect.width / 2) / 25;
    const y = (e.clientY - rect.top - rect.height / 2) / 25;
    productPictureContainer.style.transform = `rotateY(${x}deg) rotateX(${y}deg)`;
});

productPictureContainer?.addEventListener('mouseleave', () => {
    isMouseEntered = false;
    productPictureContainer.style.transform = `rotateY(0deg) rotateX(0deg)`;
    animateItems();
});

function animateItems() {
    if (isMouseEntered) {
        productPicture.style.transform =
            'translateY(-10px) translateZ(30px) rotateX(5deg) rotateY(-5deg)';
    } else {
        productPicture.style.transform = '';
    }
}

const starResults = document.querySelectorAll('.star-result');

starResults.forEach((result, i) => {
    const count = Number(result.dataset.count);
    const bar = result.querySelector('.bar');
    const counter = result.querySelector('.counter');

    const transition = { duration: 2, delay: i * 0.1, ease: [0.25, 1, 0.5, 1] };

    animate(bar, { '--progress-num': count }, transition);
    animate(0, count, {
        ...transition,
        onUpdate: count => (counter.textContent = Math.round(count)),
    });
});

const starContainer = document.querySelector('#send-review-star-container');
const starButtons = starContainer?.querySelectorAll('.send-review-star') || [];

const sendReviewDescription = document.querySelector('#send-review-description');
const sendReviewButton = document.querySelector('#send-review-button');

let rating = 0;

starButtons.forEach((button, index) => {
    const starValue = index + 1;

    button.addEventListener('mouseenter', () => {
        starContainer.dataset.star = starValue;
    });

    button.addEventListener('click', () => {
        rating = starValue;
        sendReviewButton.disabled = false;
    });
});

starContainer?.addEventListener('mouseleave', () => {
    starContainer.dataset.star = rating;
});

sendReviewButton?.addEventListener('click', async () => {
    const description = sendReviewDescription.value;
    const user_id = sendReviewButton.dataset.userId;
    const product_id = sendReviewButton.dataset.productId;

    await fetch('./send-review.php', {
        method: 'POST',
        body: JSON.stringify({ rating, description, user_id, product_id }),
    });

    const searchParams = new URLSearchParams(window.location.search);
    searchParams.delete('tab');

    window.location.search = searchParams.toString();
});

const avatars = document.querySelectorAll('.avatar');

for (const avatar of avatars) {
    const firstName = avatar.dataset.firstName;
    const lastName = avatar.dataset.lastName;

    updateAvatar(avatar, firstName, lastName);
    avatar.classList.remove('animate-pulse');
}
