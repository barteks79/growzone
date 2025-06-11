import { Chart, registerables } from 'chart.js';
import { updateAvatar } from '../../js/avatar.js';

const mainContainer = document.querySelector('#main-container');
const tab = mainContainer.dataset.tab;

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
