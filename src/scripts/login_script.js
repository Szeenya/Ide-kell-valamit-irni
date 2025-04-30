<<<<<<< Updated upstream
// Csak a form váltáshoz szükséges kód maradjon
document.getElementById('showRegister').addEventListener('click', function(event) {
    event.preventDefault();
    document.querySelector('.container').classList.add('show-register');
});

document.getElementById('showLogin').addEventListener('click', function(event) {
    event.preventDefault();
    document.querySelector('.container').classList.remove('show-register');
=======
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.container');
    
    // Csak akkor állítjuk be az alapértelmezett nézetet, ha nincs hibaüzenet
    if (!document.querySelector('.error-message')) {
        container.classList.add('show-login');
        container.classList.remove('show-register');
        document.title = 'Bejelentkezés';
    }
    
    // Regisztráció link kezelése
    document.getElementById('showRegister').addEventListener('click', function(event) {
        event.preventDefault();
        container.classList.remove('show-login');
        container.classList.add('show-register');
        document.getElementById('pageTitle').textContent = 'Regisztráció';
    });

    // Bejelentkezés link kezelése
    document.getElementById('showLogin').addEventListener('click', function(event) {
        event.preventDefault();
        container.classList.remove('show-register');
        container.classList.add('show-login');
        document.getElementById('pageTitle').textContent = 'Bejelentkezés';
    });
>>>>>>> Stashed changes
});