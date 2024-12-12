document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.querySelector('.menu-toggle');
    const menu = document.querySelector('.primary-menu');

    menuToggle.addEventListener('click', () => {
        menu.classList.toggle('active');
    });
});
