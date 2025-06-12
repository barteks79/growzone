import { Chart, registerables } from 'chart.js';
import { updateAvatar } from '../../js/avatar.js';

/** @type {HTMLDivElement} */
const mainContainer = document.querySelector('#main-container');
const tab = mainContainer.dataset.tab;

/** @type {HTMLButtonElement} */
const saveChangesButton = document.querySelector('#save-changes');

/** @type {{id: number, name: string, value?: string | number | boolean}[]} */
let changes = [];

/** @type {NodeListOf<HTMLInputElement>} */
const inputs = mainContainer.querySelectorAll('input');
inputs.forEach(input => {
    input.addEventListener('input', () => {
        const id = input.closest('.record').dataset.id;
        const name = input.name;
        const value = input.type == 'checkbox' ? input.checked : input.value;

        const changeIndex = changes.findIndex(
            change => change.id == id && change.name == name,
        );

        if (changeIndex < 0) {
            changes.push({ id, name, value });
        } else {
            changes[changeIndex].value = value;
        }

        saveChangesButton.disabled = false;
    });
});

/** @type {NodeListOf<HTMLButtonElement>} */
const deleteButtons = mainContainer.querySelectorAll('.delete');
deleteButtons.forEach(button => {
    button.addEventListener('click', () => {
        const record = button.closest('.record');
        const id = record.dataset.id;

        changes = changes.filter(change => change.id != id);
        changes.push({ id, name: 'delete' });

        record.remove();
        saveChangesButton.disabled = false;
    });
});

saveChangesButton.addEventListener('click', async () => {
    const url = `./save-${tab}.php`;

    await fetch(url, {
        method: 'POST',
        body: JSON.stringify(changes),
    });

    changes = [];

    location.reload();
});

window.addEventListener('beforeunload', event => {
    if (changes.length) {
        event.preventDefault();
    }
});

Chart.register(...registerables);

if (tab == 'users') {
    const canvas = document.querySelector('#users-chart');
    const users = Number(canvas.dataset.users);
    const admins = Number(canvas.dataset.admins);

    new Chart(canvas, {
        type: 'pie',
        data: {
            labels: ['Users', 'Admins'],
            datasets: [{ data: [users, admins] }],
        },
    });
}

if (tab == 'orders') {
    const canvas = document.querySelector('#orders-chart');
    const orders = JSON.parse(canvas.dataset.orders);

    new Chart(canvas, {
        type: 'line',
        data: {
            labels: orders.map(order => order.order_id),
            datasets: [
                {
                    label: 'Total order cost',
                    data: orders.map(order => order.cost),
                    tension: 0.1,
                },
                {
                    label: 'Average product cost',
                    data: orders.map(order => order.average_cost),
                    tension: 0.1,
                },
                {
                    label: 'Average order cost',
                    data: orders.map(order => order.average_order),
                    tension: 0.1,
                },
            ],
        },
    });
}

if (tab == 'products') {
    const canvas = document.querySelector('#products-chart');
    const products = JSON.parse(canvas.dataset.products);

    new Chart(canvas, {
        type: 'line',
        data: {
            labels: products.map(product => product.product_id),
            datasets: [
                {
                    label: 'Product rating',
                    data: products.map(product => product.rating),
                    tension: 0.1,
                },
                {
                    label: 'Average product rating',
                    data: products.map(product => product.average_rating),
                    tension: 0.1,
                },
            ],
        },
    });
}

const avatars = document.querySelectorAll('.avatar');

for (const avatar of avatars) {
    const firstName = avatar.dataset.firstName;
    const lastName = avatar.dataset.lastName;

    updateAvatar(avatar, firstName, lastName);
    avatar.classList.remove('animate-pulse');
}
