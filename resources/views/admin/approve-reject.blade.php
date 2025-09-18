@extends('layouts.app')

@section('title', 'Approval of Accounts')

@section('content')
<div class="page-with-back-button">
    <div class="page-content">
        <!-- Back Button -->
        <div class="rubric-header-nav">
            <a href="{{ route('admin.profile') }}" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <h2 class="approval-title">Approval of Accounts</h2>

    <div class="controls">
        <div class="dropdowns">
            <label>
                Filter
                <select>
                    <option>None</option>
                    <option>Admin</option>
                    <option>Student</option>
                    <option>Assessor</option>
                    <!-- Add options as needed -->
                </select>
            </label>

            <label>
                Sort by
                <select>
                    <option>None</option>
                    <option>Status</option>
                    <option>Last Login</option>
                    <!-- Add options as needed -->
                </select>
            </label>
        </div>

        <div class="search-box">
            <input type="text" placeholder="Search...">
            <button class="search-btn"><i class="fas fa-search"></i></button>
        </div>
    </div>

    <table class="approval-table">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Organization Name</th>
                <th>Organization Role</th>
                <th>Account Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>2022-00123</td>
                <td>Maria Santos</td>
                <td>Student Council</td>
                <td>President</td>
                <td><span class="status-badge status-pending">Pending</span></td>
                <td class="action-buttons">
                    <button type="button" class="btn-action btn-reject" onclick="rejectAccount('1')" title="Reject Account">
                        <i class="fas fa-times"></i>
                    </button>
                    <button type="button" class="btn-action btn-approve" onclick="approveAccount('1')" title="Approve Account">
                        <i class="fas fa-user-check"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>2022-00124</td>
                <td>John Dela Cruz</td>
                <td>Debate Society</td>
                <td>Vice President</td>
                <td><span class="status-badge status-pending">Pending</span></td>
                <td class="action-buttons">
                    <button type="button" class="btn-action btn-reject" onclick="rejectAccount('2')" title="Reject Account">
                        <i class="fas fa-times"></i>
                    </button>
                    <button type="button" class="btn-action btn-approve" onclick="approveAccount('2')" title="Approve Account">
                        <i class="fas fa-user-check"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>2022-00125</td>
                <td>Sarah Johnson</td>
                <td>Science Club</td>
                <td>Secretary</td>
                <td><span class="status-badge status-pending">Pending</span></td>
                <td class="action-buttons">
                    <button type="button" class="btn-action btn-reject" onclick="rejectAccount('3')" title="Reject Account">
                        <i class="fas fa-times"></i>
                    </button>
                    <button type="button" class="btn-action btn-approve" onclick="approveAccount('3')" title="Approve Account">
                        <i class="fas fa-user-check"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>2022-00126</td>
                <td>Michael Rodriguez</td>
                <td>Basketball Team</td>
                <td>Captain</td>
                <td><span class="status-badge status-pending">Pending</span></td>
                <td class="action-buttons">
                    <button type="button" class="btn-action btn-reject" onclick="rejectAccount('4')" title="Reject Account">
                        <i class="fas fa-times"></i>
                    </button>
                    <button type="button" class="btn-action btn-approve" onclick="approveAccount('4')" title="Approve Account">
                        <i class="fas fa-user-check"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>2022-00127</td>
                <td>Anna Garcia</td>
                <td>Art Society</td>
                <td>Treasurer</td>
                <td><span class="status-badge status-pending">Pending</span></td>
                <td class="action-buttons">
                    <button type="button" class="btn-action btn-reject" onclick="rejectAccount('5')" title="Reject Account">
                        <i class="fas fa-times"></i>
                    </button>
                    <button type="button" class="btn-action btn-approve" onclick="approveAccount('5')" title="Approve Account">
                        <i class="fas fa-user-check"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>2022-00128</td>
                <td>David Kim</td>
                <td>Computer Science Club</td>
                <td>President</td>
                <td><span class="status-badge status-pending">Pending</span></td>
                <td class="action-buttons">
                    <button type="button" class="btn-action btn-reject" onclick="rejectAccount('6')" title="Reject Account">
                        <i class="fas fa-times"></i>
                    </button>
                    <button type="button" class="btn-action btn-approve" onclick="approveAccount('6')" title="Approve Account">
                        <i class="fas fa-user-check"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>2022-00129</td>
                <td>Lisa Chen</td>
                <td>Music Society</td>
                <td>Vice President</td>
                <td><span class="status-badge status-pending">Pending</span></td>
                <td class="action-buttons">
                    <button type="button" class="btn-action btn-reject" onclick="rejectAccount('7')" title="Reject Account">
                        <i class="fas fa-times"></i>
                    </button>
                    <button type="button" class="btn-action btn-approve" onclick="approveAccount('7')" title="Approve Account">
                        <i class="fas fa-user-check"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>2022-00130</td>
                <td>Robert Wilson</td>
                <td>Environmental Club</td>
                <td>Secretary</td>
                <td><span class="status-badge status-pending">Pending</span></td>
                <td class="action-buttons">
                    <button type="button" class="btn-action btn-reject" onclick="rejectAccount('8')" title="Reject Account">
                        <i class="fas fa-times"></i>
                    </button>
                    <button type="button" class="btn-action btn-approve" onclick="approveAccount('8')" title="Approve Account">
                        <i class="fas fa-user-check"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>2022-00131</td>
                <td>Jennifer Lee</td>
                <td>Drama Club</td>
                <td>Director</td>
                <td><span class="status-badge status-pending">Pending</span></td>
                <td class="action-buttons">
                    <button type="button" class="btn-action btn-reject" onclick="rejectAccount('9')" title="Reject Account">
                        <i class="fas fa-times"></i>
                    </button>
                    <button type="button" class="btn-action btn-approve" onclick="approveAccount('9')" title="Approve Account">
                        <i class="fas fa-user-check"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>2022-00132</td>
                <td>Carlos Martinez</td>
                <td>Photography Club</td>
                <td>President</td>
                <td><span class="status-badge status-pending">Pending</span></td>
                <td class="action-buttons">
                    <button type="button" class="btn-action btn-reject" onclick="rejectAccount('10')" title="Reject Account">
                        <i class="fas fa-times"></i>
                    </button>
                    <button type="button" class="btn-action btn-approve" onclick="approveAccount('10')" title="Approve Account">
                        <i class="fas fa-user-check"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    
    <div class="pagination-info">
        Showing <span id="showingStart">1</span>-<span id="showingEnd">10</span> of <span id="totalEntries">0</span> entries
    </div>
    
    {{-- Pagination --}}
    <div class="unified-pagination">
        <button class="btn-nav" disabled>Previous</button>
        <button class="btn-page active">1</button>
        <button class="btn-page">2</button>
        <button class="btn-page">3</button>
        <button class="btn-nav">Next</button>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="modal" style="display: none;">
    <div class="modal-content confirmation-modal">
        <div class="modal-header">
            <h3 id="modalTitle">Confirm Action</h3>
            <span class="close" onclick="closeConfirmationModal()">&times;</span>
        </div>
        <div class="modal-body">
            <p id="modalMessage">Are you sure you want to perform this action?</p>
            <div class="account-details" id="accountDetails">
                <!-- Account details will be populated here -->
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeConfirmationModal()">Cancel</button>
            <button type="button" class="btn btn-primary" id="confirmButton" onclick="confirmAction()">Confirm</button>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="modal fade" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content success-modal-content">
            <div class="modal-body text-center p-4">
                <div class="success-icon mb-3">
                    <i class="fas fa-check-circle" style="color: #28a745; font-size: 3rem;"></i>
                </div>
                <h5 class="success-title mb-3">Success!</h5>
                <p class="success-message mb-4" id="successMessage">The action has been completed successfully.</p>
                <div class="account-summary mb-4" id="accountSummary">
                    <!-- Account summary will be populated here -->
                </div>
                <button type="button" class="btn btn-success" onclick="closeSuccessModal()">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentAction = '';
let currentAccountId = '';

// Ensure modals are hidden on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Approval page loaded - ensuring modals are hidden');
    
    // Force hide all modals on page load
    const confirmationModal = document.getElementById('confirmationModal');
    const successModal = document.getElementById('successModal');
    
    if (confirmationModal) {
        confirmationModal.style.display = 'none';
        console.log('Confirmation modal hidden');
    }
    
    if (successModal) {
        successModal.style.display = 'none';
        console.log('Success modal hidden');
    }
    
    // Restore body scroll
    document.body.style.overflow = 'auto';
    
    // Check for any session messages that might trigger modals
    @if(session('status'))
        console.log('Session status found:', '{{ session('status') }}');
        // Don't automatically show modals for session messages
    @endif
    
    @if(session('error'))
        console.log('Session error found:', '{{ session('error') }}');
        // Don't automatically show modals for session errors
    @endif
    
    console.log('All modals properly hidden on page load');
});

function approveAccount(accountId) {
    currentAction = 'approve';
    currentAccountId = accountId;
    
    document.getElementById('modalTitle').textContent = 'Approve Account';
    document.getElementById('modalMessage').textContent = 'Are you sure you want to approve this account?';
    document.getElementById('confirmButton').textContent = 'Approve';
    document.getElementById('confirmButton').className = 'btn btn-success';
    
    // Populate account details (in real app, fetch from server)
    document.getElementById('accountDetails').innerHTML = `
        <div class="detail-row">
            <span class="detail-label">Student ID:</span>
            <span class="detail-value">2021-00${accountId}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Student Name:</span>
            <span class="detail-value">Sample Student ${accountId}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Organization:</span>
            <span class="detail-value">Sample Organization</span>
        </div>
    `;
    
    openConfirmationModal();
}

function rejectAccount(accountId) {
    currentAction = 'reject';
    currentAccountId = accountId;
    
    document.getElementById('modalTitle').textContent = 'Reject Account';
    document.getElementById('modalMessage').textContent = 'Are you sure you want to reject this account?';
    document.getElementById('confirmButton').textContent = 'Reject';
    document.getElementById('confirmButton').className = 'btn btn-danger';
    
    // Populate account details (in real app, fetch from server)
    document.getElementById('accountDetails').innerHTML = `
        <div class="detail-row">
            <span class="detail-label">Student ID:</span>
            <span class="detail-value">2021-00${accountId}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Student Name:</span>
            <span class="detail-value">Sample Student ${accountId}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Organization:</span>
            <span class="detail-value">Sample Organization</span>
        </div>
    `;
    
    openConfirmationModal();
}

function openConfirmationModal() {
    console.log('openConfirmationModal called');
    document.getElementById('confirmationModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeConfirmationModal() {
    document.getElementById('confirmationModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    // Don't reset currentAction and currentAccountId here since they're needed for the success modal
}

function confirmAction() {
    // In a real application, you would send an AJAX request to the server
    console.log(`${currentAction} account ${currentAccountId}`);
    
    // Close confirmation modal
    closeConfirmationModal();
    
    // Show success modal
    showSuccessModal();
}

function showSuccessModal() {
    console.log('showSuccessModal called with action:', currentAction, 'accountId:', currentAccountId);
    const actionText = currentAction === 'approve' ? 'approved' : 'rejected';
    const actionTextPast = currentAction === 'approve' ? 'approved' : 'rejected';
    
    // Set modal content based on action
    document.getElementById('successMessage').textContent = `You have successfully ${actionTextPast} this account.`;
    
    // Populate account summary
    document.getElementById('accountSummary').innerHTML = `
        <div class="summary-item">
            <span class="summary-label">Student ID:</span>
            <span class="summary-value">2021-00${currentAccountId}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Student Name:</span>
            <span class="summary-value">Sample Student ${currentAccountId}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Action Taken:</span>
            <span class="summary-value" style="font-weight: 600; color: ${currentAction === 'approve' ? '#28a745' : '#dc3545'};">${actionText.charAt(0).toUpperCase() + actionText.slice(1)}</span>
        </div>
    `;
    
    // Show the success modal
    const modal = document.getElementById('successModal');
    modal.style.display = 'block';
    modal.classList.add('show');
    document.body.classList.add('modal-open');
}

function closeSuccessModal() {
    const modal = document.getElementById('successModal');
    modal.style.display = 'none';
    modal.classList.remove('show');
    document.body.classList.remove('modal-open');
    currentAction = '';
    currentAccountId = '';
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    const confirmationModal = document.getElementById('confirmationModal');
    const successModal = document.getElementById('successModal');
    
    if (event.target === confirmationModal) {
        closeConfirmationModal();
    }
    
    if (event.target === successModal) {
        closeSuccessModal();
    }
}
</script>

{{-- Include Admin Pagination Script --}}
<script src="{{ asset('js/admin_pagination.js') }}"></script>

@endsection
