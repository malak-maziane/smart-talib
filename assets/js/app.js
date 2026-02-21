// Confirmation avant action critique
document.addEventListener('DOMContentLoaded', function() {
    let buttons = document.querySelectorAll('button[data-confirm]');
    buttons.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            if (!confirm(btn.getAttribute('data-confirm'))) {
                e.preventDefault();
            }
        });
    });
});

// Animation simple au scroll (bonus)
window.addEventListener('scroll', function() {
    let nav = document.querySelector('.navbar');
    nav.classList.toggle('bg-dark', window.scrollY > 50);
});
