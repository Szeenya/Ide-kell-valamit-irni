// Csak a form váltáshoz szükséges kód maradjon
document.getElementById('showRegister').addEventListener('click', function(event) {
    event.preventDefault();
    document.querySelector('.container').classList.add('show-register');
});

document.getElementById('showLogin').addEventListener('click', function(event) {
    event.preventDefault();
    document.querySelector('.container').classList.remove('show-register');
});