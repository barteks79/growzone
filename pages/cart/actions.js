function numberFormat(num, decimals = 2, decPoint = '.', thousandsSep = ',') {
	const fixed = num.toFixed(decimals);
	let [intPart, decPart] = fixed.split('.');

	intPart = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, thousandsSep);

	return intPart + decPoint + decPart;
}

async function increaseProductQuantity(e) {
	e.target.nextElementSibling.value++;

	const cartItemElement = e.target.closest('li');
	const price = Number(cartItemElement.dataset.productPrice);

	const currentPrice = +cartItemElement
		.querySelector('[data-price=true] span')
		.textContent.replace(',', '');

	cartItemElement.querySelector('[data-price=true] span').textContent =
		numberFormat(currentPrice + price);

	const productId = Number(e.target.closest('li').dataset.productId);

	const responseUser = await fetch('../../php/get-user-http.php');
	const { userId } = await responseUser.json();

	const response = await fetch('./add.php', {
		method: 'POST',
		'Content-Type': 'application/json',
		body: JSON.stringify({ product_id: productId, user_id: userId })
	});

	if (!response.ok) {
		e.target.nextElementSibling.value--;
		cartItemElement.querySelector('[data-price=true] span').textContent =
			numberFormat(currentPrice);
	}
}

document.addEventListener('DOMContentLoaded', () => {
	document
		.querySelectorAll('[data-action=increase]')
		.forEach(button =>
			button.addEventListener('click', increaseProductQuantity)
		);
});
