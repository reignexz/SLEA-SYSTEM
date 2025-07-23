// Sidebar toggle (desktop collapse/expand)
document.querySelector('.menu-toggle')?.addEventListener('click', () => {
    document.body.classList.toggle('collapsed');
});

// Dark mode toggle for sidebar
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
}

// Avatar preview
function previewAvatar(e) {
    const avatar = document.getElementById('avatarPreview');
    avatar.src = URL.createObjectURL(e.target.files[0]);
}

// Show/Hide Password
function togglePassword() {
    const newPassword = document.getElementById('newPassword');
    const confirmPassword = document.getElementById('confirmPassword');
    const type = newPassword.type === 'password' ? 'text' : 'password';
    newPassword.type = type;
    confirmPassword.type = type;
}

// Password validation
function validatePassword() {
    const p = document.getElementById('newPassword').value;
    document.getElementById('length').className    = p.length >= 8 ? 'valid' : 'invalid';
    document.getElementById('uppercase').className = /[A-Z]/.test(p) ? 'valid' : 'invalid';
    document.getElementById('lowercase').className = /[a-z]/.test(p) ? 'valid' : 'invalid';
    document.getElementById('number').className    = /\d/.test(p) ? 'valid' : 'invalid';
    document.getElementById('special').className   = /[^A-Za-z0-9]/.test(p) ? 'valid' : 'invalid';
}

// Expose functions globally (needed for inline onClick handlers in Blade)
window.toggleDarkMode = toggleDarkMode;
window.previewAvatar = previewAvatar;
window.togglePassword = togglePassword;
window.validatePassword = validatePassword;

// Mobile sidebar slide-in/out toggle
const hamburger = document.querySelector('.menu-toggle');
const overlay = document.querySelector('.sidebar-overlay');

// Open/close sidebar on hamburger click
hamburger?.addEventListener('click', function() {
    document.body.classList.toggle('sidebar-open');
});

// Close sidebar when clicking the overlay
overlay?.addEventListener('click', function() {
    document.body.classList.remove('sidebar-open');
});

// Close sidebar when a menu item is clicked
document.querySelectorAll('.sidebar ul li').forEach(item => {
    item.addEventListener('click', function() {
        document.body.classList.remove('sidebar-open');
    });
});
