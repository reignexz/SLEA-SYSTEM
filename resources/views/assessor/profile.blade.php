@extends('layouts.app')

@section('title', 'Assessor Dashboard')

@section('content')
<div class="container">
    @include('partials.assessor_sidebar')

    <main class="main-content">
        <div class="avatar-container">
            <img src="https://via.placeholder.com/120" class="avatar" id="avatarPreview">
            <button class="edit-icon" onclick="document.getElementById('avatarUpload').click()">
                <i class="fas fa-pencil-alt"></i>
            </button>
            <input type="file" id="avatarUpload" accept="image/*" style="display:none;" onchange="previewAvatar(event)">
        </div>

        <section class="profile-section">
            <div class="profile-info">
                <h3>Personal Information</h3>
                
                <!-- Display Mode -->
                <div id="displayMode" class="info-display">
                    <div class="info-item">
                        <div class="info-label">Name</div>
                        <div class="info-value" id="display-name">ASSESSOR, Sample A.</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Contact Number</div>
                        <div class="info-value" id="display-phone">09991234567</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Assessor ID</div>
                        <div class="info-value" id="display-assessor-id">2024-00123</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email Address</div>
                        <div class="info-value" id="display-email">assessor@usep.edu.ph</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Position</div>
                        <div class="info-value" id="display-position">Student Affairs Assessor</div>
                    </div>
                    <div class="info-actions">
                        <button type="button" class="btn btn-primary" onclick="toggleEditMode()">Update Information</button>
                    </div>
                </div>

                <!-- Edit Mode -->
                <div id="editMode" class="info-edit" style="display: none;">
                    <form id="updateForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="updateName">Name</label>
                                <input type="text" id="updateName" name="name" value="ASSESSOR, Sample A.">
                            </div>
                            <div class="form-group">
                                <label for="updatePhone">Contact Number</label>
                                <input type="tel" id="updatePhone" name="phone" value="09991234567">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="updateEmail">Email Address</label>
                                <input type="email" id="updateEmail" name="email" value="assessor@usep.edu.ph">
                            </div>
                            <div class="form-group">
                                <label for="updatePosition">Position</label>
                                <input type="text" id="updatePosition" name="position" value="Student Affairs Assessor">
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn btn-primary" onclick="updateProfile()">Save Changes</button>
                            <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="change-password">
                <h3>Change Password</h3>
                <input type="password" placeholder="Present Password" />
                <div class="requirements">
                    <p>A new password must contain the following:</p>
                    <ul id="passwordChecklist">
                        <li id="length" class="invalid">Minimum of 8 characters</li>
                        <li id="uppercase" class="invalid">An uppercase character</li>
                        <li id="lowercase" class="invalid">A lowercase character</li>
                        <li id="number" class="invalid">A number</li>
                        <li id="special" class="invalid">A special character</li>
                    </ul>
                </div>
                <input type="password" placeholder="New Password" id="newPassword" onkeyup="validatePassword()">
                <input type="password" placeholder="Confirm Password" id="confirmPassword">
                <label>
                    <input type="checkbox" onclick="togglePassword()"> Show Password
                </label>
                <button class="change-btn">Change Password</button>
            </div>
        </section>
    </main>
</div>

<!-- Success Modal -->
<div id="successModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Success</h3>
            <span class="close" onclick="closeSuccessModal()">&times;</span>
        </div>
        <div class="modal-body">
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                <p id="successMessage">Operation completed successfully!</p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="closeSuccessModal()">OK</button>
        </div>
    </div>
</div>

<script>
// Profile Picture Upload
function previewAvatar(event) {
    const file = event.target.files[0];
    if (file) {
        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('Please select a valid image file.');
            return;
        }
        
        // Validate file size (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Image size should be less than 5MB.');
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            // Update main profile picture
            document.getElementById('avatarPreview').src = e.target.result;
            
            // Update sidebar profile icon
            updateSidebarProfile(e.target.result);
            
            // Show success message
            showSuccessModal('Profile picture updated successfully!');
            
            // Here you would typically upload to server
            console.log('Profile picture updated:', file.name);
        };
        reader.readAsDataURL(file);
    }
}

// Update sidebar profile icon
function updateSidebarProfile(imageSrc) {
    const sidebarProfile = document.querySelector('#sidebarProfileIcon');
    if (sidebarProfile) {
        sidebarProfile.style.backgroundImage = `url('${imageSrc}')`;
        sidebarProfile.style.backgroundSize = 'cover';
        sidebarProfile.style.backgroundPosition = 'center';
        
        // Store in localStorage for persistence
        localStorage.setItem('profileImage', imageSrc);
        
        // Also update any other profile icons on the page
        const allProfileIcons = document.querySelectorAll('.profile-icon');
        allProfileIcons.forEach(icon => {
            if (icon.id !== 'sidebarProfileIcon') {
                icon.style.backgroundImage = `url('${imageSrc}')`;
                icon.style.backgroundSize = 'cover';
                icon.style.backgroundPosition = 'center';
            }
        });
    }
}

// Load profile image from localStorage on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedImage = localStorage.getItem('profileImage');
    if (savedImage) {
        document.getElementById('avatarPreview').src = savedImage;
        updateSidebarProfile(savedImage);
    }
    
    // Ensure sidebar profile icon is updated on page load
    setTimeout(function() {
        const mainAvatar = document.getElementById('avatarPreview');
        if (mainAvatar && mainAvatar.src && !mainAvatar.src.includes('placeholder')) {
            updateSidebarProfile(mainAvatar.src);
        }
    }, 100);
});

// Password Validation
function validatePassword() {
    const password = document.getElementById('newPassword').value;
    const requirements = {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /\d/.test(password),
        special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
    };
    
    Object.keys(requirements).forEach(req => {
        const element = document.getElementById(req);
        if (requirements[req]) {
            element.classList.remove('invalid');
            element.classList.add('valid');
        } else {
            element.classList.remove('valid');
            element.classList.add('invalid');
        }
    });
}

// Toggle Password Visibility
function togglePassword() {
    const inputs = document.querySelectorAll('.change-password input[type="password"]');
    inputs.forEach(input => {
        input.type = input.type === 'password' ? 'text' : 'password';
    });
}

// Toggle Edit Mode
function toggleEditMode() {
    document.getElementById('displayMode').style.display = 'none';
    document.getElementById('editMode').style.display = 'block';
}

// Cancel Edit
function cancelEdit() {
    document.getElementById('displayMode').style.display = 'block';
    document.getElementById('editMode').style.display = 'none';
    
    // Reset form to original values
    document.getElementById('updateName').value = document.getElementById('display-name').textContent;
    document.getElementById('updatePhone').value = document.getElementById('display-phone').textContent;
    document.getElementById('updateEmail').value = document.getElementById('display-email').textContent;
    document.getElementById('updatePosition').value = document.getElementById('display-position').textContent;
}

// Update Profile
function updateProfile() {
    const form = document.getElementById('updateForm');
    const formData = new FormData(form);
    
    // Here you would send the data to the server
    console.log('Updating assessor profile:', Object.fromEntries(formData));
    
    // Update the display values
    document.getElementById('display-name').textContent = document.getElementById('updateName').value;
    document.getElementById('display-phone').textContent = document.getElementById('updatePhone').value;
    document.getElementById('display-email').textContent = document.getElementById('updateEmail').value;
    document.getElementById('display-position').textContent = document.getElementById('updatePosition').value;
    
    // Switch back to display mode
    document.getElementById('displayMode').style.display = 'block';
    document.getElementById('editMode').style.display = 'none';
    
    // Show success message
    showSuccessModal('Personal information updated successfully!');
}

// Success Modal
function showSuccessModal(message) {
    document.getElementById('successMessage').textContent = message;
    document.getElementById('successModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeSuccessModal() {
    document.getElementById('successModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
window.addEventListener('click', function(e) {
    const modal = document.getElementById('successModal');
    if (e.target === modal) {
        closeSuccessModal();
    }
});
</script>
@endsection
