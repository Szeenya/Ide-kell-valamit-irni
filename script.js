let cart = [];
let totalPrice = 0;

function addToCart(product, price) {
    cart.push({ product, price });
    totalPrice += price;
    updateCart();
}

function updateCart() {
    const cartItems = document.getElementById('cart-items');
    const totalPriceElement = document.getElementById('total-price');
    cartItems.innerHTML = '';
    cart.forEach(item => {
        const li = document.createElement('li');
        li.textContent = `${item.product} - ${item.price} Ft`;
        cartItems.appendChild(li);
    });
    totalPriceElement.textContent = totalPrice;
}

function clearCart() {
    cart = [];
    totalPrice = 0;
    updateCart();
}