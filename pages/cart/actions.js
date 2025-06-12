const nextPageBtnKoszyk = document.querySelector('#nextBtnKoszyk');

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

		if (isCartEmpty()) {
			nextPageBtnKoszyk.disabled = true;
			document.querySelector('#cart_text').dataset.shown = true;
		}
	}

	const prevFullPrice = document.querySelector('#cart_value_span').textContent;
	document.querySelector('#cart_value_span').textContent = numberFormat(
		+document.querySelector('#cart_value_span').textContent.replace(',', '') +
			priceDelta
	);

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
		document.querySelector('#cart_value_span').textContent = prevFullPrice;
		updatePrice(cartItemElement, -priceDelta);
		if (!isIncrease && qtyInput.value <= 0) {
			// Przywróć element jeśli został usunięty
			cartItemElement.parentNode.appendChild(cartItemElement);
		}
	}
}

async function clearCart(e) {
	const valueElement = e.target.previousElementSibling.querySelector('span');
	const cartProductsItems = document.querySelectorAll('li');

	const currentValue =
		e.target.previousElementSibling.querySelector('span').textContent;

	valueElement.textContent = '0.00';
	document.querySelectorAll('li').forEach(li => li.remove());
	nextPageBtnKoszyk.disabled = true;
	document.querySelector('#cart_text').dataset.shown = true;

	const userId = await getUserId();
	const response = await fetch('./clear.php', {
		method: 'DELETE',
		'Content-Type': 'application/json',
		body: JSON.stringify({ user_id: userId })
	});

	if (!response.ok) {
		const productsList = document.querySelector('ul');

		valueElement.textContent = currentValue;
		nextPageBtnKoszyk.disabled = false;
		cartProductsItems.forEach(item => productsList.append(item));
	}
}

function isCartEmpty() {
	if (document.querySelectorAll('li').length === 0) {
		return true;
	}
	return false;
}

function isDeliveryCompanySelected() {
	if (document.querySelector('[data-selected="true"]')) {
		return true;
	}
	return false;
}

function isNextPageButtonEnabled() {
	if (isDeliveryCompanySelected() && !isCartEmpty()) {
		return true;
	}
	return false;
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

	document
		.querySelectorAll('#clear_cart')
		.forEach(btn => btn.addEventListener('click', e => clearCart(e)));

	document.querySelectorAll('article').forEach(company =>
		company.addEventListener('click', e => {
			document
				.querySelectorAll('article')
				.forEach(company2 => company2.removeAttribute('data-selected'));

			if (!isCartEmpty()) {
				nextPageBtnKoszyk.disabled = false;
			}

			e.target.dataset.selected = true;
		})
	);

	nextPageBtnKoszyk?.addEventListener('click', () => {
		if (isNextPageButtonEnabled()) {
			const nextPage = nextPageBtnKoszyk.dataset.next;
			return (window.location.href = `./index.php?strona=${nextPage}`);
		}

		window.location.href = './index.php';
	});

	document.querySelector('#previousBtn')?.addEventListener('click', e => {
		const previousPage = e.target.dataset.previous;

		if (previousPage === 'index') {
			return (window.location.href = './index.php');
		}

		window.location.href = `./index.php?strona=${previousPage}`;
	});
});
