const userBtn = document.getElementById('userBtn');
const dropdownMenu = document.getElementById('dropdownMenu');

// Au clic sur le bouton
userBtn.addEventListener('click', (e) => {
    e.stopPropagation(); // Empêche la fermeture immédiate
    dropdownMenu.classList.toggle('show');
});

// Fermer le menu si on clique n'importe où ailleurs sur la page
window.addEventListener('click', () => {
    if (dropdownMenu.classList.contains('show')) {
        dropdownMenu.classList.remove('show');
    }
});