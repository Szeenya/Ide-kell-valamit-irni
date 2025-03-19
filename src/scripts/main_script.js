// Kosár objektum a termékek tárolására
let cart = {};

// Megjeleníti a modális ablakot
function showModal(imageSrc, description, price, title) {
    const modal = document.getElementById('product-modal');
    const modalImage = document.getElementById('modal-image');
    const modalDescription = document.getElementById('modal-description');
    const modalPrice = document.getElementById('modal-price');
    const modalTitle = document.getElementById('modal-title');

    modalImage.src = imageSrc;
    modalDescription.textContent = description;
    modalPrice.textContent = `Ár: ${price}`;
    modalTitle.textContent = title;

    // Tároljuk a termék adatait a gombhoz
    modal.dataset.title = title;
    modal.dataset.price = price;

    modal.style.display = 'flex';
}

// Elrejti a modális ablakot
function hideModal() {
    const modal = document.getElementById('product-modal');
    modal.style.display = 'none';
}

// Hozzáadja a terméket a kosárhoz
function addToCart() {
    const modal = document.getElementById('product-modal');
    const title = modal.dataset.title;
    const price = parseInt(modal.dataset.price.replace(/[^\d]/g, '')); // Csak számokat hagyunk meg

    if (cart[title]) {
        cart[title].quantity += 1;
    } else {
        cart[title] = {
            price: price,
            quantity: 1
        };
    }

    updateCart();
    hideModal(); // Bezárjuk a modális ablakot
}

// Frissíti a kosár megjelenítését
function updateCart() {
    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
    cartItems.innerHTML = '';

    let total = 0;

    // Kosár elemek megjelenítése
    Object.entries(cart).forEach(([title, item]) => {
        const itemDiv = document.createElement('div');
        itemDiv.className = 'cart-item';
        
        const nameSpan = document.createElement('span');
        nameSpan.className = 'cart-item-name';
        nameSpan.textContent = title;
        
        const quantitySpan = document.createElement('span');
        quantitySpan.className = 'cart-item-quantity';
        quantitySpan.textContent = `×${item.quantity}`;
        
        const priceSpan = document.createElement('span');
        priceSpan.className = 'cart-item-price';
        priceSpan.textContent = `${(item.price * item.quantity).toLocaleString()} Ft`;
        
        itemDiv.appendChild(nameSpan);
        itemDiv.appendChild(quantitySpan);
        itemDiv.appendChild(priceSpan);
        
        cartItems.appendChild(itemDiv);
        total += item.price * item.quantity;
    });

    // Összesített ár megjelenítése
    cartTotal.textContent = `Összesen: ${total.toLocaleString()} Ft`;
}

// Bezárás kattintásra a modális ablakon kívül
window.onclick = function(event) {
    const modal = document.getElementById('product-modal');
    if (event.target === modal) {
        hideModal();
    }
}

function clearCart() {
    cart = [];
    totalPrice = 0;
    updateCart();
}

function showInfo(card) {
    const info = card.querySelector('.product-info');
}

// Kosár pozíciójának kezelése görgetéskor
document.addEventListener('DOMContentLoaded', function() {
    const cart = document.getElementById('cart');
    const cartWrapper = document.querySelector('.cart-wrapper');
    const originalOffset = cartWrapper.offsetTop;
    
    function handleScroll() {
        const scrollPosition = window.scrollY;
        
        if (scrollPosition > originalOffset) {
            cart.classList.add('fixed');
        } else {
            cart.classList.remove('fixed');
        }
    }

    // Görgetés esemény figyelése
    window.addEventListener('scroll', handleScroll);
});