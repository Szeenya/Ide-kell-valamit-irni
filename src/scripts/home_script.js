document.addEventListener('DOMContentLoaded', function () {
    var carouselElement = document.querySelector('#carouselExampleIndicators');
    var carousel = new bootstrap.Carousel(carouselElement, {
        interval: 5000, // 5 másodpercenkénti automatikus lapozás
        ride: 'carousel'
    });
});