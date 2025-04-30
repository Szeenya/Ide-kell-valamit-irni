// Kosár objektum a termékek tárolására
let cart = {};

let currentSuitId = null;
let selectedDates = null;
let flatpickrInstance = null;
<<<<<<< Updated upstream

// Megjeleníti a modális ablakot
function showModal(suitId, image, description, price, title) {
    currentSuitId = suitId;  // Eltároljuk az ID-t
=======
let currentBasePrice = 0;

// Módosított showModal függvény, ami tartalmazza az addToCart funkcionalitást is
function showModal(suitId, image, description, price, title) {
    currentSuitId = suitId;
    currentBasePrice = parseInt(price.replace(/[^0-9]/g, '')); // Eltávolítjuk a Ft és szóköz karaktereket
    
>>>>>>> Stashed changes
    const modal = document.getElementById('product-modal');
    modal.style.display = "block";
    document.getElementById('modal-image').src = image;
    document.getElementById('modal-title').textContent = title;
    document.getElementById('modal-description').textContent = description;
<<<<<<< Updated upstream
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
=======
    document.getElementById('modal-base-price').textContent = `Alapár: ${price}`;
    document.getElementById('modal-total-price').textContent = `Teljes ár: ${price}`; // Kezdetben ugyanaz mint az alapár

    // Kosárba helyezés gomb eseménykezelőjének beállítása
    const addToCartButton = modal.querySelector('.modal-button');
    addToCartButton.onclick = function() {
        if (!selectedDates || selectedDates.length !== 2) {
            alert('Kérjük, válassza ki a bérlés időtartamát!');
            return;
        }

        const startDate = formatDate(selectedDates[0]);
        const endDate = formatDate(selectedDates[1]);
        const daysDiff = Math.ceil((new Date(endDate) - new Date(startDate)) / (1000 * 60 * 60 * 24)) + 1;
        const totalPrice = currentBasePrice + ((daysDiff - 1) * (currentBasePrice * 0.5));

        fetch('add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                suit_id: currentSuitId,
                start_date: startDate,
                end_date: endDate,
                total_price: Math.round(totalPrice)  // Kerekítjük az árat
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Sikeres foglalás!');
                hideModal();
                updateCart();
                
                // Termék eltüntetése és azonnali státusz frissítés
                const productCard = document.querySelector(`.product-card[data-suit-id="${currentSuitId}"]`);
                if (productCard) {
                    productCard.style.animation = 'fadeOut 0.5s';
                    setTimeout(() => {
                        productCard.remove();
                        
                        // Ha ez volt az utolsó termék
                        const remainingProducts = document.querySelectorAll('.product-card').length;
                        if (remainingProducts === 0) {
                            const productList = document.querySelector('.product-list');
                            productList.innerHTML = '<p class="no-products">Jelenleg nincs elérhető termék.</p>';
                        }
                        
                        // Azonnal frissítjük az összes többi termék státuszát
                        document.querySelectorAll('.product-card').forEach(card => {
                            const otherSuitId = card.getAttribute('data-suit-id');
                            if (otherSuitId) {
                                checkAvailability(otherSuitId);
                            }
                        });
                    }, 500);
                }
            } else {
                alert(data.message || 'Hiba történt a foglalás során!');
            }
        })
        .catch(error => console.error('Error:', error));
    };
    
    // Foglalások lekérése
    fetch(`get_reservations.php?suit_id=${suitId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const disabledDates = [];
                data.reservations.forEach(reservation => {
                    const start = new Date(reservation.rented_from);
                    const end = new Date(reservation.rented_until);
                    
                    while (start <= end) {
                        disabledDates.push(new Date(start));
                        start.setDate(start.getDate() + 1);
                    }
                });

                if (flatpickrInstance) {
                    flatpickrInstance.destroy();
                }

>>>>>>> Stashed changes
                flatpickrInstance = flatpickr("#rental-dates", {
                    mode: "range",
                    minDate: "today",
                    locale: "hu",
                    dateFormat: "Y-m-d",
                    disable: disabledDates,
                    onChange: function(dates) {
                        selectedDates = dates;
<<<<<<< Updated upstream
                    },
                    onDayCreate: function(dObj, dStr, fp, dayElem) {
                        // Add custom class to disabled dates
=======
                        updatePrice(dates);
                    },
                    onDayCreate: function(dObj, dStr, fp, dayElem) {
>>>>>>> Stashed changes
                        if (dayElem.classList.contains('flatpickr-disabled')) {
                            dayElem.classList.add('reserved-date');
                        }
                    },
<<<<<<< Updated upstream
                    // Hozzáadjuk ezt az opciót
                    enableTime: false,
                    time_24hr: true
                });
=======
                    enableTime: false,
                    time_24hr: true,
                    defaultDate: [] // Üres alapértelmezett érték
                });
                
                // Input mező értékének törlése
                document.getElementById('rental-dates').value = '';
>>>>>>> Stashed changes
            }
        })
        .catch(error => console.error('Error:', error));
}

// Módosítsd a hideModal függvényt:
function hideModal() {
    document.getElementById('product-modal').style.display = "none";
    currentSuitId = null;
    selectedDates = null;
<<<<<<< Updated upstream
}

// Hozzáadja a terméket a kosárhoz
=======
    
    // Flatpickr instance törlése és újrainicializálása
    if (flatpickrInstance) {
        flatpickrInstance.clear(); // Törli a kiválasztott dátumokat
        flatpickrInstance.destroy(); // Eltávolítja a jelenlegi instance-t
        flatpickrInstance = null;
    }
}

// Add this function before the addToCart function
function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

// Módosítsd a meglévő addToCart függvényt
>>>>>>> Stashed changes
function addToCart(suitId) {
    if (!selectedDates || selectedDates.length !== 2) {
        alert('Kérjük, válassza ki a bérlés időtartamát!');
        return;
    }

<<<<<<< Updated upstream
    // Formázzuk a dátumokat YYYY-MM-DD formátumra, időzóna korrekció nélkül
    const formatDate = (date) => {
        const d = new Date(date);
        const year = d.getFullYear();
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const day = String(d.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    };

=======
>>>>>>> Stashed changes
    const startDate = formatDate(selectedDates[0]);
    const endDate = formatDate(selectedDates[1]);

    fetch('add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
<<<<<<< Updated upstream
            suit_id: currentSuitId,
=======
            suit_id: suitId,
>>>>>>> Stashed changes
            start_date: startDate,
            end_date: endDate
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
<<<<<<< Updated upstream
=======
            // Flatpickr instance törlése
            if (flatpickrInstance) {
                flatpickrInstance.clear();
            }
            selectedDates = null;
            
>>>>>>> Stashed changes
            alert('Sikeresen hozzáadva a kosárhoz!');
            hideModal();
            updateCart();
            
<<<<<<< Updated upstream
            // Újra lekérjük és frissítjük a foglalásokat minden kártyán
=======
            // Új kód: termék eltüntetése
            const productCard = document.querySelector(`.product-card[data-suit-id="${suitId}"]`);
            if (productCard) {
                productCard.style.animation = 'fadeOut 0.5s';
                setTimeout(() => {
                    productCard.remove();
                    
                    // Ha ez volt az utolsó termék, jelenítünk meg egy üzenetet
                    const remainingProducts = document.querySelectorAll('.product-card').length;
                    if (remainingProducts === 0) {
                        const productList = document.querySelector('.product-list');
                        productList.innerHTML = '<p class="no-products">Jelenleg nincs elérhető termék.</p>';
                    }
                }, 500);
            }
            
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
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
=======
>>>>>>> Stashed changes
}

// Frissíti a kosár megjelenítését
function updateCart() {
    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
    cartItems.innerHTML = '';
    let total = 0;
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

    cartTotal.textContent = `Összesen: ${total.toLocaleString()} Ft`;
}

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
<<<<<<< Updated upstream
});
=======
});

function cancelReservation(reservationId) {
    if (confirm('Biztosan törölni szeretné ezt a foglalást?')) {
        const formData = new FormData();
        formData.append('reservation_id', reservationId);

        fetch('cancel_reservation.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Hiba történt a törlés során!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hiba történt a törlés során!');
        });
    }
}

function showUserProfile() {
    document.getElementById('userProfileModal').style.display = 'block';
}

function hideUserProfile() {
    document.getElementById('userProfileModal').style.display = 'none';
}

document.getElementById('userProfileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = {
        username: document.getElementById('username').value,
        email: document.getElementById('email').value,
        password: document.getElementById('password').value
    };

    fetch('update_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Profil sikeresen módosítva!');
            hideUserProfile();
            document.querySelector('.user-info span').textContent = formData.username;
        } else {
            alert(data.message || 'Hiba történt a módosítás során!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hiba történt a módosítás során!');
    });
});

window.onclick = function(event) {
    const modal = document.getElementById('userProfileModal');
    if (event.target === modal) {
        hideUserProfile();
    }
}

function updatePrice(dates) {
    if (dates.length === 2) {
        const startDate = new Date(dates[0]);
        const endDate = new Date(dates[1]);
        const daysDiff = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
        
        // Az ár számítása: alapár + (napok száma - 1) * (alapár * 0.5)
        // Így az első nap az alapár, minden további nap pedig +50%
        const totalPrice = currentBasePrice + ((daysDiff - 1) * (currentBasePrice * 0.5));
        
        document.getElementById('modal-total-price').textContent = 
            `Teljes ár: ${Math.round(totalPrice).toLocaleString()} Ft (${daysDiff} nap)`;
    } else {
        document.getElementById('modal-total-price').textContent = 
            `Teljes ár: ${currentBasePrice.toLocaleString()} Ft`;
    }
}
>>>>>>> Stashed changes
