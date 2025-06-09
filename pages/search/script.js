import { updateAvatar } from '../../js/avatar.js';

/** @type {HTMLInputElement} */
const productName = document.querySelector('#product-name');
/** @type {HTMLDivElement} */
const productSuggestions = document.querySelector('#product-suggestions');
/** @type {HTMLButtonElement} */
const clearSearchButton = document.querySelector('#clear-search-button');
/** @type {HTMLInputElement} */
const inStock = document.querySelector('#in-stock');
/** @type {HTMLInputElement} */
const outOfStock = document.querySelector('#out-of-stock');
/** @type {HTMLInputElement} */
const price = document.querySelector('#price');
/** @type {NodeListOf<HTMLInputElement>} */
const categories = document.querySelectorAll('.category');
/** @type {HTMLDivElement} */
const productContainer = document.querySelector('#product-container');
/** @type {HTMLTemplateElement} */
const productTemplate = document.querySelector('#product-template');
/** @type {SVGElement} */
const starIcon = document.querySelector('#star-icon');
/** @type {SVGElement} */
const xIcon = document.querySelector('#x-icon');

applyURLFilters();

productName.addEventListener('input', submit);
productName.addEventListener('input', updateSuggestions);
clearSearchButton.addEventListener('click', clearSearch);
inStock.addEventListener('change', submit);
outOfStock.addEventListener('change', submit);
price.addEventListener('input', submit);
categories.forEach(category => category.addEventListener('change', submit));

submit();
updateSuggestions();

function applyURLFilters() {
    const searchParams = new URLSearchParams(window.location.search);

    if (searchParams.has('productName')) {
        productName.value = searchParams.get('productName');
    }

    if (searchParams.has('category')) {
        const activeCategories = searchParams.getAll('category');

        categories.forEach(category => {
            if (activeCategories.includes(category.value.toLowerCase())) {
                category.checked = true;
            }
        });
    }
}

function submit() {
    let availability = null;

    if (inStock.checked ^ outOfStock.checked) {
        availability = inStock.checked ? 'in-stock' : 'out-of-stock';
    }

    const activeCategories = [];

    categories.forEach(category => {
        if (category.checked) {
            activeCategories.push(category.id.split('-')[1]);
        }
    });

    updateProducts(
        productName.value || null,
        availability,
        Number(price.value),
        activeCategories.length ? activeCategories : null,
    );

    document.title = `${productName.value ? `"${productName.value}"` : 'Search'} | GrowZone`;
}

function clearSearch() {
    productName.value = '';
    productName.dispatchEvent(new Event('input'));
}

async function updateSuggestions() {
    const search = productName.value;

    const response = await fetch('./suggestions.php', {
        method: 'POST',
        body: JSON.stringify({ productName: search }),
    });

    const suggestions = await response.json();

    productSuggestions.innerHTML = '';

    for (const suggestionText of suggestions) {
        const suggestion = document.createElement('span');
        suggestion.textContent = suggestionText;
        suggestion.onclick = () => {
            productName.value = suggestionText;
            productName.dispatchEvent(new Event('input'));
        };
        productSuggestions.append(suggestion);
    }
}

/**
 * @param {string | null} productName
 * @param {'in-stock' | 'out-of-stock' | null} availability
 * @param {number | null} maxPrice
 * @param {number[] | null} categories
 */
async function updateProducts(productName, availability, maxPrice, categories) {
    const response = await fetch('./search.php', {
        method: 'POST',
        body: JSON.stringify({ productName, availability, maxPrice, categories }),
    });

    const result = await response.json();

    productContainer.innerHTML = '';

    for (const data of result) {
        const product = productTemplate.content.cloneNode(true);

        const productLink = product.querySelector('.product-link');
        productLink.href = `../product/index.php?id=${encodeURIComponent(data['uuid'])}`;

        const productCategory = product.querySelector('.product-category');
        productCategory.textContent = data['category'];

        const productAvailability = product.querySelector('.product-availability');
        if (!data['in_stock']) {
            const productXIcon = product.querySelector('.product-x-icon');
            const productXIconClone = xIcon.cloneNode(true);
            productXIconClone.setAttribute('class', productXIcon.className);
            productXIcon.append(productXIconClone);

            delete productAvailability.dataset.available;
        }

        const productTitle = product.querySelector('.product-title');
        productTitle.textContent = data['title'];

        const productPrice = product.querySelector('.product-price');
        productPrice.textContent = `$${data['price']}`;

        const productDescription = product.querySelector('.product-description');
        const description = data['description'];
        productDescription.textContent =
            description.length > 20 ? `${description.substring(0, 50)}...` : description;

        const productStarIcon = product.querySelector('.product-star-icon');
        const productStarIconClone = starIcon.cloneNode(true);
        productStarIconClone.setAttribute('class', productStarIcon.className);
        productStarIcon.append(productStarIconClone);

        const productRating = product.querySelector('.product-rating');
        productRating.textContent = data['rating'];

        productContainer.append(product);
    }
}

const avatars = document.querySelectorAll('.avatar');

for (const avatar of avatars) {
    const firstName = avatar.dataset.firstName;
    const lastName = avatar.dataset.lastName;

    updateAvatar(avatar, firstName, lastName);
    avatar.classList.remove('animate-pulse');
}
