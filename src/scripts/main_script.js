// Kosár objektum a termékek tárolására
let cart = {};

let currentSuitId = null;
let selectedDates = null;
let flatpickrInstance = null;

// Megjeleníti a modális ablakot
function showModal(suitId, image, description, price, title) {
    currentSuitId = suitId;  // Eltároljuk az ID-t
    const modal = document.getElementById('product-modal');
    modal.style.display = "block";
    document.getElementById('modal-image').src = image;
    document.getElementById('modal-title').textContent = title;
    document.getElementById('modal-description').textContent = description;
    document.getElementById('modal-price').textContent = price;
    
    // Fetch reservations for this suit
    fetch(`get_reservations.php?suit_id=${suitId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Convert reservations to disabled dates
                const disabledDates = [];
                data.reservations.forEach(reservation => {
                    const start = new Date(reservation.rented_from);
                    const end = new Date(reservation.rented_until);
                    
                    // Add each day between start and end to disabled dates
                    while (start <= end) {
                        disabledDates.push(new Date(start));
                        start.setDate(start.getDate() + 1);
                    }
                });

                // Destroy existing flatpickr instance if it exists
                if (flatpickrInstance) {
                    flatpickrInstance.destroy();
                }

                // Initialize new flatpickr with disabled dates
                flatpickrInstance = flatpickr("#rental-dates", {
                    mode: "range",
                    minDate: "today",
                    locale: "hu",
                    dateFormat: "Y-m-d",
                    disable: disabledDates,
                    onChange: function(dates) {
                        selectedDates = dates;
                    },
                    onDayCreate: function(dObj, dStr, fp, dayElem) {
                        // Add custom class to disabled dates
                        if (dayElem.classList.contains('flatpickr-disabled')) {
                            dayElem.classList.add('reserved-date');
                        }
                    },
                    // Hozzáadjuk ezt az opciót
                    enableTime: false,
                    time_24hr: true
                });
            }
        })
        .catch(error => console.error('Error:', error));
}

// Elrejti a modális ablakot
function hideModal() {
    document.getElementById('product-modal').style.display = "none";
    currentSuitId = null;
    selectedDates = null;
}

// Hozzáadja a terméket a kosárhoz
function addToCart(suitId) {
    if (!selectedDates || selectedDates.length !== 2) {
        alert('Kérjük, válassza ki a bérlés időtartamát!');
        return;
    }

    // Formázzuk a dátumokat YYYY-MM-DD formátumra, időzóna korrekció nélkül
    const formatDate = (date) => {
        const d = new Date(date);
        const year = d.getFullYear();
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const day = String(d.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    };

    const startDate = formatDate(selectedDates[0]);
    const endDate = formatDate(selectedDates[1]);

    fetch('add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            suit_id: currentSuitId,
            start_date: startDate,
            end_date: endDate
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Sikeresen hozzáadva a kosárhoz!');
            hideModal();
            updateCart();
            
            // Újra lekérjük és frissítjük a foglalásokat minden kártyán
            updateAllReservations();
        } else {
            alert(data.message || 'Hiba történt a kosárhoz adás során!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hiba történt a kosárhoz adás során!');
    });
}

// Új függvény az összes foglalás frissítéséhez
function updateAllReservations() {
    // Minden termékkártyán frissítjük a foglalásokat
    document.querySelectorAll('.product-card').forEach(card => {
        const suitId = card.getAttribute('data-suit-id');
        if (suitId) {
            fetch(`get_reservations.php?suit_id=${suitId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Frissítjük a kártya státuszát
                        updateCardReservationStatus(card, data.reservations);
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });
}

// Új függvény a kártya státuszának frissítéséhez
function updateCardReservationStatus(card, reservations) {
    const today = new Date();
    let isCurrentlyReserved = false;

    reservations.forEach(reservation => {
        const startDate = new Date(reservation.rented_from);
        const endDate = new Date(reservation.rented_until);
        
        if (today >= startDate && today <= endDate) {
            isCurrentlyReserved = true;
        }
    });

    // Vizuálisan jelezzük a foglaltságot
    if (isCurrentlyReserved) {
        card.classList.add('reserved');
    } else {
        card.classList.remove('reserved');
    }
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

document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#rental-dates", {
        mode: "range",
        minDate: "today",
        locale: "hu",
        dateFormat: "Y-m-d",
        onChange: function(dates) {
            selectedDates = dates;
        }
    });
});