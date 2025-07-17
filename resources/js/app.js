import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// HTMX configuration
document.addEventListener('DOMContentLoaded', function() {
    // Add CSRF token to all HTMX requests
    document.body.addEventListener('htmx:configRequest', function(evt) {
        evt.detail.headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    });
});