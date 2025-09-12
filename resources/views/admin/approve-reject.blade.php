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
<div id="confirmationModal" class="modal">
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
<div id="successModal" class="modal">
    <div class="modal-content success-modal">
        <div class="modal-header success-header">
            <h3 id="successTitle">Action Completed</h3>
            <span class="close" onclick="closeSuccessModal()">&times;</span>
        </div>
        <div class="modal-body">
            <div class="success-content">
                <div class="success-icon" id="successIcon">
                    <!-- Icon will be set dynamically -->
                </div>
                <p id="successMessage">The action has been completed successfully.</p>
                <div class="account-summary" id="accountSummary">
                    <!-- Account summary will be populated here -->
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="closeSuccessModal()">OK</button>
        </div>
    </div>
</div>

<script>
let currentAction = '';
let currentAccountId = '';

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
    document.getElementById('confirmationModal').style.display = 'block';
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
    const actionText = currentAction === 'approve' ? 'approved' : 'rejected';
    const actionTextPast = currentAction === 'approve' ? 'approved' : 'rejected';
    
    // Set modal content based on action
    document.getElementById('successTitle').textContent = 'Action Completed Successfully';
    document.getElementById('successMessage').textContent = `You have successfully ${actionTextPast} this account.`;
    
    // Set icon and styling based on action
    const successIcon = document.getElementById('successIcon');
    if (currentAction === 'approve') {
        successIcon.innerHTML = '<i class="fas fa-check-circle" style="color: #28a745; font-size: 48px;"></i>';
        document.querySelector('.success-header').style.background = '#d4edda';
        document.querySelector('.success-header h3').style.color = '#155724';
    } else {
        successIcon.innerHTML = '<i class="fas fa-times-circle" style="color: #dc3545; font-size: 48px;"></i>';
        document.querySelector('.success-header').style.background = '#f8d7da';
        document.querySelector('.success-header h3').style.color = '#721c24';
    }
    
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
    document.getElementById('successModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeSuccessModal() {
    document.getElementById('successModal').style.display = 'none';
    document.body.style.overflow = 'auto';
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

@endsection
