function numberFormat(num, decimals = 2, decPoint = '.', thousandsSep = ',') {
	const fixed = num.toFixed(decimals);
	let [intPart, decPart] = fixed.split('.');
	intPart = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, thousandsSep);
	return intPart + decPoint + decPart;
}

async function getUserId() {
	const res = await fetch('../../php/get-user-http.php');
	const { userId } = await res.json();
	return userId;
}

function updatePrice(cartItemElement, priceDelta) {
	const priceSpan = cartItemElement.querySelector('[data-price=true] span');
	const currentPrice = +priceSpan.textContent.replace(',', '');
	const newPrice = currentPrice + priceDelta;
	priceSpan.textContent = numberFormat(newPrice);
	return currentPrice;
}

function getCartItemData(e) {
	const cartItemElement = e.target.closest('li');
	return {
		cartItemElement,
		productId: Number(cartItemElement.dataset.productId),
		price: Number(cartItemElement.dataset.productPrice)
	};
}

async function changeProductQuantity(e, action) {
	const isIncrease = action === 'increase';
	const qtyInput = isIncrease
		? e.target.nextElementSibling
		: e.target.previousElementSibling;
	const { cartItemElement, productId, price } = getCartItemData(e);
	const priceDelta = isIncrease ? price : -price;

	// Zmień ilość
	qtyInput.value = Number(qtyInput.value) + (isIncrease ? 1 : -1);

	// Usuń produkt jeśli ilość <= 0
	if (!isIncrease && qtyInput.value <= 0) {
		cartItemElement.remove();
	}

	const prevPrice = updatePrice(cartItemElement, priceDelta);
	const userId = await getUserId();

	const fetchOptions = {
		method: isIncrease ? 'POST' : 'DELETE',
		headers: { 'Content-Type': 'application/json' },
		body: JSON.stringify({ product_id: productId, user_id: userId })
	};

	const endpoint = isIncrease ? './add.php' : './remove.php';
	const response = await fetch(endpoint, fetchOptions);

	if (!response.ok) {
		// Cofnij zmiany przy błędzie
		qtyInput.value = Number(qtyInput.value) + (isIncrease ? -1 : 1);
		updatePrice(cartItemElement, -priceDelta);
		if (!isIncrease && qtyInput.value <= 0) {
			// Przywróć element jeśli został usunięty
			cartItemElement.parentNode.appendChild(cartItemElement);
		}
	}
}

document.addEventListener('DOMContentLoaded', () => {
	document
		.querySelectorAll('[data-action=increase]')
		.forEach(btn =>
			btn.addEventListener('click', e => changeProductQuantity(e, 'increase'))
		);

	document
		.querySelectorAll('[data-action=decrease]')
		.forEach(btn =>
			btn.addEventListener('click', e => changeProductQuantity(e, 'decrease'))
		);
});
