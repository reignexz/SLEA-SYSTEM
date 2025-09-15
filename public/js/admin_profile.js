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

// Logout function with custom confirmation modal
function logout() {
    showLogoutConfirmation();
}

function showLogoutConfirmation() {
    // Create confirmation modal overlay
    const overlay = document.createElement('div');
    overlay.id = 'logoutConfirmationOverlay';
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 10000;
        font-family: 'Quicksand', sans-serif;
        backdrop-filter: blur(3px);
    `;
    
    const modal = document.createElement('div');
    modal.style.cssText = `
        background: white;
        padding: 0;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        max-width: 450px;
        width: 90%;
        overflow: hidden;
        transform: scale(0.9);
        transition: transform 0.3s ease;
    `;
    
    modal.innerHTML = `
        <div style="background: linear-gradient(135deg, #dc3545, #c82333); padding: 25px; color: white;">
            <div style="font-size: 48px; margin-bottom: 15px;">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <h3 style="margin: 0; font-size: 22px; font-weight: 600;">Confirm Logout</h3>
        </div>
        <div style="padding: 30px;">
            <p style="color: #555; margin-bottom: 25px; font-size: 16px; line-height: 1.5;">
                Are you sure you want to log out?<br>
                <small style="color: #888; font-size: 14px;">You will be redirected to the login page.</small>
            </p>
            <div style="display: flex; gap: 12px; justify-content: center;">
                <button id="cancelLogout" style="
                    background: #6c757d;
                    color: white;
                    border: none;
                    padding: 12px 24px;
                    border-radius: 8px;
                    cursor: pointer;
                    font-size: 14px;
                    font-weight: 500;
                    transition: all 0.3s ease;
                    min-width: 100px;
                " onmouseover="this.style.background='#5a6268'" onmouseout="this.style.background='#6c757d'">
                    Cancel
                </button>
                <button id="confirmLogout" style="
                    background: #dc3545;
                    color: white;
                    border: none;
                    padding: 12px 24px;
                    border-radius: 8px;
                    cursor: pointer;
                    font-size: 14px;
                    font-weight: 500;
                    transition: all 0.3s ease;
                    min-width: 100px;
                " onmouseover="this.style.background='#c82333'" onmouseout="this.style.background='#dc3545'">
                    Log Out
                </button>
            </div>
        </div>
    `;
    
    overlay.appendChild(modal);
    document.body.appendChild(overlay);
    
    // Animate modal appearance
    setTimeout(() => {
        modal.style.transform = 'scale(1)';
    }, 10);
    
    // Add event listeners
    document.getElementById('cancelLogout').addEventListener('click', () => {
        closeLogoutConfirmation();
    });
    
    document.getElementById('confirmLogout').addEventListener('click', () => {
        closeLogoutConfirmation();
        showLogoutSuccess();
        
        // Auto logout after showing success message
        setTimeout(() => {
            window.location.href = '/logout';
        }, 2000);
    });
    
    // Close on overlay click
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            closeLogoutConfirmation();
        }
    });
    
    // Close on Escape key
    const handleEscape = (e) => {
        if (e.key === 'Escape') {
            closeLogoutConfirmation();
            document.removeEventListener('keydown', handleEscape);
        }
    };
    document.addEventListener('keydown', handleEscape);
}

function closeLogoutConfirmation() {
    const overlay = document.getElementById('logoutConfirmationOverlay');
    if (overlay) {
        const modal = overlay.querySelector('div');
        modal.style.transform = 'scale(0.9)';
        setTimeout(() => {
            if (overlay.parentNode) {
                overlay.parentNode.removeChild(overlay);
            }
        }, 300);
    }
}

function showLogoutSuccess() {
    // Create success message overlay
    const overlay = document.createElement('div');
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 10000;
        font-family: 'Quicksand', sans-serif;
    `;
    
    const messageBox = document.createElement('div');
    messageBox.style.cssText = `
        background: white;
        padding: 30px 40px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        max-width: 400px;
        width: 90%;
    `;
    
    messageBox.innerHTML = `
        <div style="color: #28a745; font-size: 48px; margin-bottom: 15px;">
            <i class="fas fa-check-circle"></i>
        </div>
        <h3 style="color: #333; margin-bottom: 10px; font-size: 20px;">Logout Successful!</h3>
        <p style="color: #666; margin-bottom: 20px; font-size: 14px;">You have been successfully logged out. Redirecting to login page...</p>
        <div style="display: flex; justify-content: center; align-items: center; gap: 10px;">
            <div style="width: 20px; height: 20px; border: 2px solid #28a745; border-top: 2px solid transparent; border-radius: 50%; animation: spin 1s linear infinite;"></div>
            <span style="color: #666; font-size: 12px;">Please wait...</span>
        </div>
    `;
    
    // Add CSS animation for spinner
    const style = document.createElement('style');
    style.textContent = `
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
    
    overlay.appendChild(messageBox);
    document.body.appendChild(overlay);
    
    // Remove overlay after 2 seconds (just before redirect)
    setTimeout(() => {
        if (overlay.parentNode) {
            overlay.parentNode.removeChild(overlay);
        }
        if (style.parentNode) {
            style.parentNode.removeChild(style);
        }
    }, 2000);
}

// Expose logout functions globally
window.logout = logout;
window.showLogoutConfirmation = showLogoutConfirmation;
window.closeLogoutConfirmation = closeLogoutConfirmation;
window.showLogoutSuccess = showLogoutSuccess;