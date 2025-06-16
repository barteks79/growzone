const modalOverlay = document.querySelector('#modal-overlay');

const showCategoryModal = document.querySelector('#show-category-modal');
const categoryModal = document.querySelector('#category-modal');

showCategoryModal?.addEventListener('click', () => {
    delete categoryModal.dataset.hidden;
    delete modalOverlay.dataset.hidden;
});

modalOverlay?.addEventListener('click', () => {
    categoryModal.dataset.hidden = true;
    modalOverlay.dataset.hidden = true;
});

const showProductModal = document.querySelector('#show-product-modal');
const productModal = document.querySelector('#product-modal');

showProductModal?.addEventListener('click', () => {
    delete productModal.dataset.hidden;
    delete modalOverlay.dataset.hidden;
});

modalOverlay?.addEventListener('click', () => {
    productModal.dataset.hidden = true;
    modalOverlay.dataset.hidden = true;
});
