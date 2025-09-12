@extends('layouts.app')

@section('title', 'Manage Account')

@section('content')
<div class="page-with-back-button">
    <div class="page-content">
        <!-- Back Button -->
        <div class="rubric-header-nav">
            <a href="{{ route('admin.profile') }}" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <h2 class="manage-title">Manage Account</h2>

        {{-- Messages --}}
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="m-0 pl-4">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Controls: Filter / Sort / Search --}}
        <form class="controls" method="GET" action="{{ route('admin.manage') }}">
            <div class="controls-left">
                <div class="dropdowns">
                    <label>
                        <span>Filter</span>
                        <select name="filter" class="filter-select">
                            <option value="" @selected(request('filter')==='')>None</option>
                            <option value="active" @selected(request('filter')==='active')>Active</option>
                            <option value="disabled" @selected(request('filter')==='disabled')>Disabled</option>
                            <option value="new" @selected(request('filter')==='new')>New (Last 7 days)</option>
                        </select>
                    </label>

                    <label>
                        <span>Sort by</span>
                        <select name="sort" class="filter-select">
                            <option value="" @selected(request('sort')==='')>None</option>
                            <option value="name" @selected(request('sort')==='name')>Name</option>
                            <option value="date" @selected(request('sort')==='date')>Date Created</option>
                            <option value="status" @selected(request('sort')==='status')>Account Status</option>
                            <option value="last_login" @selected(request('sort')==='last_login')>Last Login</option>
                        </select>
                    </label>
                </div>
            </div>

            <div class="search-box">
                <input type="text" name="q" placeholder="Search by email or name..." value="{{ request('q') }}" class="search-input">
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        {{-- Account Management Table --}}
        <div class="table-container">
            <table class="manage-account-table">
                <thead>
                    <tr>
                        <th>
                            Email Address</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Account Status</th>
                        <th>Last Login</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->name ?? 'N/A' }}</td>
                            <td>{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</td>
                            <td>
                                <span class="status-badge {{ $user->is_disabled ? 'status-disabled' : 'status-active' }}">
                                    {{ $user->is_disabled ? 'Disabled' : 'Active' }}
                                </span>
                            </td>
                            <td>{{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}</td>
                            <td class="action-column">
                                <div class="action-buttons">
                                    <button class="action-btn disable-btn" 
                                            onclick="confirmToggleUser({{ $user->id }}, {{ $user->is_disabled ? 'false' : 'true' }}, '{{ $user->name }}')"
                                            title="{{ $user->is_disabled ? 'Enable' : 'Disable' }} User">
                                        <i class="fas {{ $user->is_disabled ? 'fa-user-check' : 'fa-user-slash' }}"></i>
                                    </button>
                                    <button class="action-btn delete-btn" 
                                            onclick="confirmDeleteUser({{ $user->id }}, '{{ $user->name }}')"
                                            title="Delete User">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="unified-pagination">
            <button class="btn-nav" disabled>Previous</button>
            <button class="btn-page active">1</button>
            <button class="btn-page">2</button>
            <button class="btn-page">3</button>
            <button class="btn-page">4</button>
            <button class="btn-nav">Next</button>
        </div>
    </div>
</div>

{{-- Confirmation Modal for Toggle User --}}
<div id="toggleModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="toggleModalTitle">Confirm Action</h3>
            <span class="close" onclick="closeToggleModal()">&times;</span>
        </div>
        <div class="modal-body">
            <p id="toggleModalMessage">Are you sure you want to perform this action?</p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeToggleModal()">Cancel</button>
            <form id="toggleForm" method="POST" style="display: inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-primary" id="toggleConfirmBtn">Confirm</button>
            </form>
        </div>
    </div>
</div>

{{-- Confirmation Modal for Delete User --}}
<div id="deleteModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Delete User</h3>
            <span class="close" onclick="closeDeleteModal()">&times;</span>
        </div>
        <div class="modal-body">
            <p id="deleteModalMessage">Are you sure you want to delete this user? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>

{{-- Success Modal --}}
<div id="successModal" class="modal" style="display: none;">
    <div class="modal-content success-modal">
        <div class="modal-header">
            <h3>Success</h3>
            <span class="close" onclick="closeSuccessModal()">&times;</span>
        </div>
        <div class="modal-body text-center">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3 id="successMessage">Action completed successfully!</h3>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" onclick="closeSuccessModal()">OK</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Toggle User Functions
function confirmToggleUser(userId, currentStatus, userName) {
    const action = currentStatus ? 'disable' : 'enable';
    const modal = document.getElementById('toggleModal');
    const title = document.getElementById('toggleModalTitle');
    const message = document.getElementById('toggleModalMessage');
    const form = document.getElementById('toggleForm');
    const confirmBtn = document.getElementById('toggleConfirmBtn');
    
    title.textContent = `${action.charAt(0).toUpperCase() + action.slice(1)} User`;
    message.textContent = `Are you sure you want to ${action} "${userName}"?`;
    form.action = `/admin/manage/${userId}/toggle`;
    confirmBtn.textContent = action.charAt(0).toUpperCase() + action.slice(1);
    confirmBtn.className = `btn ${action === 'disable' ? 'btn-warning' : 'btn-success'}`;
    
    modal.style.display = 'block';
}

function closeToggleModal() {
    document.getElementById('toggleModal').style.display = 'none';
}

// Delete User Functions
function confirmDeleteUser(userId, userName) {
    const modal = document.getElementById('deleteModal');
    const message = document.getElementById('deleteModalMessage');
    const form = document.getElementById('deleteForm');
    
    message.textContent = `Are you sure you want to delete "${userName}"? This action cannot be undone.`;
    form.action = `/admin/manage/${userId}`;
    
    modal.style.display = 'block';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

// Success Modal Functions
function showSuccessModal(message) {
    const modal = document.getElementById('successModal');
    const messageElement = document.getElementById('successMessage');
    
    messageElement.textContent = message;
    modal.style.display = 'block';
    
    // Auto close after 3 seconds
    setTimeout(() => {
        closeSuccessModal();
    }, 3000);
}

function closeSuccessModal() {
    const modal = document.getElementById('successModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Emergency function to close all modals
function closeAllModals() {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.style.display = 'none';
    });
}

// Add keyboard listener to close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeAllModals();
    }
});

// Close modals when clicking outside
window.onclick = function(event) {
    const toggleModal = document.getElementById('toggleModal');
    const deleteModal = document.getElementById('deleteModal');
    const successModal = document.getElementById('successModal');
    
    if (event.target === toggleModal) {
        closeToggleModal();
    }
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
    if (event.target === successModal) {
        closeSuccessModal();
    }
}

// Handle form submissions with success feedback
document.addEventListener('DOMContentLoaded', function() {
    // Check if there's a success message from the server
    @if(session('status'))
    showSuccessModal('{{ session('status') }}');
    @endif
    
    // Handle toggle form submission
    document.getElementById('toggleForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            closeToggleModal();
            showSuccessModal(data.message || 'User status updated successfully!');
            // Reload the page to show updated data
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        })
        .catch(error => {
            console.error('Error:', error);
            showSuccessModal('Error updating user status. Please try again.');
        });
    });
    
    // Handle delete form submission
    document.getElementById('deleteForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            closeDeleteModal();
            showSuccessModal(data.message || 'User deleted successfully!');
            // Reload the page to show updated data
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        })
        .catch(error => {
            console.error('Error:', error);
            showSuccessModal('Error deleting user. Please try again.');
        });
    });
});
</script>
@endsection
