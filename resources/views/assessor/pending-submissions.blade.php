@extends('layouts.app')

@section('title', 'Pending Submissions - Assessor Dashboard')

@section('content')
<div class="container">
    @include('partials.assessor_sidebar')

    <main class="main-content">
        <div class="page-header">
            <h1>Pending Submissions</h1>
        </div>

        <!-- Filter and Search Controls -->
        <div class="controls-section">
            <div class="filter-controls">
                <div class="filter-group">
                    <label for="filterSelect">Filter</label>
                    <select id="filterSelect" class="form-select">
                        <option value="">None</option>
                        <option value="recent">Recent</option>
                        <option value="overdue">Overdue</option>
                        <option value="priority">Priority</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="sortSelect">Sort by</label>
                    <select id="sortSelect" class="form-select">
                        <option value="">None</option>
                        <option value="date">Date Submitted</option>
                        <option value="name">Student Name</option>
                        <option value="title">Document Title</option>
                    </select>
                </div>
            </div>
            
            <div class="search-controls">
                <div class="search-group">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search submissions...">
                    <i class="fas fa-search search-icon"></i>
                </div>
            </div>
        </div>

        <!-- Submissions Table -->
        <div class="submissions-table-container">
            <table class="table submissions-table">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Document Title</th>
                        <th>Date Submitted</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2021-12345</td>
                        <td>DELA CRUZ, Juan M.</td>
                        <td>Leadership Portfolio</td>
                        <td>2024-01-15</td>
                        <td>
                            <button class="btn btn-view" onclick="openSubmissionModal(1)" title="View Submission">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2021-67890</td>
                        <td>SANTOS, Maria A.</td>
                        <td>Community Service Report</td>
                        <td>2024-01-14</td>
                        <td>
                            <button class="btn btn-view" onclick="openSubmissionModal(2)" title="View Submission">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2021-54321</td>
                        <td>GARCIA, Pedro L.</td>
                        <td>Academic Excellence Portfolio</td>
                        <td>2024-01-13</td>
                        <td>
                            <button class="btn btn-view" onclick="openSubmissionModal(3)" title="View Submission">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2021-98765</td>
                        <td>RODRIGUEZ, Ana S.</td>
                        <td>Leadership Development Plan</td>
                        <td>2024-01-12</td>
                        <td>
                            <button class="btn btn-view" onclick="openSubmissionModal(4)" title="View Submission">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>2021-11111</td>
                        <td>MARTINEZ, Carlos R.</td>
                        <td>Innovation Project Proposal</td>
                        <td>2024-01-11</td>
                        <td>
                            <button class="btn btn-view" onclick="openSubmissionModal(5)" title="View Submission">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            <div class="pagination-info">
                Showing <span id="showingStart">1</span>-<span id="showingEnd">5</span> of <span id="totalEntries">8</span> submissions
            </div>
            <div class="pagination-controls">
                <button class="pagination-btn" id="prevBtn" disabled>
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
                <span class="pagination-pages" id="paginationPages">
                    <!-- Dynamic pages will be generated here -->
                </span>
                <button class="pagination-btn" id="nextBtn">
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </main>
</div>

<!-- View Submission Modal -->
<div class="modal fade" id="submissionModal" tabindex="-1" aria-labelledby="submissionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submissionModalLabel">View Submission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="submission-content">
                    <!-- Student Information Card -->
                    <div class="info-card">
                        <div class="card-header">
                            <h6 class="card-title">Student Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="detail-row">
                                <span class="label">Name:</span>
                                <span class="value" id="modalStudentName">DELA CRUZ, Juan M.</span>
                            </div>
                            <div class="detail-row">
                                <span class="label">Student ID:</span>
                                <span class="value" id="modalStudentId">2021-12345</span>
                            </div>
                        </div>
                    </div>

                    <!-- Document Information Card -->
                    <div class="info-card">
                        <div class="card-header">
                            <h6 class="card-title">Document Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="detail-row">
                                <span class="label">Title:</span>
                                <span class="value" id="modalDocumentTitle">Leadership Portfolio</span>
                            </div>
                            <div class="detail-row">
                                <span class="label">Category:</span>
                                <span class="value" id="modalSleaSections">Leadership Excellence</span>
                            </div>
                            <div class="detail-row">
                                <span class="label">Submission Status:</span>
                                <span class="status-badge status-pending">PENDING</span>
                            </div>
                        </div>
                    </div>

                    <!-- Document Content Card -->
                    <div class="info-card">
                        <div class="card-header">
                            <h6 class="card-title">Document Content</h6>
                        </div>
                        <div class="card-body">
                            <div class="detail-row">
                                <span class="label">Subsection:</span>
                                <span class="value" id="modalSubsection">Student Leadership</span>
                            </div>
                            <div class="detail-row">
                                <span class="label">Role in Activity:</span>
                                <span class="value" id="modalRole">President</span>
                            </div>
                            <div class="detail-row">
                                <span class="label">Date of Activity:</span>
                                <span class="value" id="modalActivityDate">2024-01-10</span>
                            </div>
                            <div class="detail-row">
                                <span class="label">Organizing Body:</span>
                                <span class="value" id="modalOrganizingBody">Student Council</span>
                            </div>
                            <div class="detail-row">
                                <span class="label">Score:</span>
                                <span class="value" id="modalScore">85/100</span>
                            </div>
                        </div>
                    </div>

                    <!-- Assessor Remarks Card -->
                    <div class="info-card">
                        <div class="card-header">
                            <h6 class="card-title">Assessor Remarks</h6>
                        </div>
                        <div class="card-body">
                            <textarea id="assessorRemarks" class="form-control remarks-textarea" rows="4" placeholder="Enter your remarks and feedback..."></textarea>
                            <small class="remarks-note">Note: Remarks are required for Reject, Return, and Flag actions.</small>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="action-buttons-container">
                    <button type="button" class="btn btn-approve" onclick="handleSubmission('approve')" title="Approve">
                        <i class="fas fa-check"></i>
                    </button>
                    <button type="button" class="btn btn-reject" onclick="handleSubmission('reject')" title="Reject">
                        <i class="fas fa-times"></i>
                    </button>
                    <button type="button" class="btn btn-return" onclick="handleSubmission('return')" title="Return">
                        <i class="fas fa-undo"></i>
                    </button>
                    <button type="button" class="btn btn-flag" onclick="handleSubmission('flag')" title="Flag">
                        <i class="fas fa-flag"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-header {
    margin-bottom: 1.5rem;
}

.page-header h1 {
    color: #8B0000;
    font-size: 2rem;
    margin-bottom: 0;
    font-weight: 700;
}

/* Dark mode page header */
body.dark-mode .page-header h1 {
    color: #f9bd3d !important;
}

.controls-section {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 2rem;
    gap: 2rem;
}

.filter-controls {
    display: flex;
    gap: 1.5rem;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-group label {
    font-weight: 600;
    color: #333;
    font-size: 0.9rem;
}

.form-select {
    min-width: 150px;
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 0.5rem 0.75rem;
    font-size: 0.9rem;
}

.search-controls {
    flex: 1;
    max-width: 300px;
}

.search-group {
    position: relative;
}

.search-group input {
    width: 100%;
    padding: 0.5rem 2.5rem 0.5rem 0.75rem;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 0.9rem;
}

.search-icon {
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #666;
    pointer-events: none;
}

.submissions-table-container {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

.submissions-table {
    margin: 0;
    width: 100%;
    background: white;
}

.submissions-table thead {
    background-color: #8B0000 !important;
}

.submissions-table thead th {
    padding: 1rem;
    font-weight: 600;
    color: white !important;
    border-bottom: 1px solid white !important;
    border-right: 1px solid white !important;
    font-size: 0.9rem;
    background-color: #8B0000 !important;
}

.submissions-table thead th:last-child {
    border-right: none !important;
}

.submissions-table tbody td {
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
    border-right: 1px solid #e9ecef;
    color: #333;
    font-size: 0.9rem;
    background: white;
}

.submissions-table tbody td:last-child {
    border-right: none;
}

.submissions-table tbody tr:hover {
    background-color: #f8f9fa;
}

/* Dark mode table styling */
/* Dark mode form controls */
body.dark-mode .form-select {
    background-color: #2a2a2a !important;
    border-color: #555 !important;
    color: #f0f0f0 !important;
}

body.dark-mode .form-select:focus {
    background-color: #2a2a2a !important;
    border-color: #f9bd3d !important;
    color: #f0f0f0 !important;
    box-shadow: 0 0 0 0.2rem rgba(249, 189, 61, 0.25) !important;
}

body.dark-mode .search-group input {
    background-color: #2a2a2a !important;
    border-color: #555 !important;
    color: #f0f0f0 !important;
}

body.dark-mode .search-group input:focus {
    background-color: #2a2a2a !important;
    border-color: #f9bd3d !important;
    color: #f0f0f0 !important;
    box-shadow: 0 0 0 0.2rem rgba(249, 189, 61, 0.25) !important;
}

body.dark-mode .search-icon {
    color: #aaa !important;
}

body.dark-mode .filter-group label {
    color: #f0f0f0 !important;
}

/* Pagination Styles */
.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 2rem;
    padding: 1rem 0;
}

.pagination-info {
    color: #666;
    font-size: 0.9rem;
}

.pagination-controls {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.pagination-btn {
    padding: 0.5rem 1rem;
    border: 1px solid #ddd;
    background: white;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s ease;
    color: #333;
}

.pagination-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.pagination-btn:hover:not(:disabled) {
    background: #8B0000;
    color: white;
    border-color: #8B0000;
}

.pagination-pages {
    display: flex;
    gap: 0.25rem;
}

.pagination-page {
    padding: 0.5rem 0.75rem;
    border: 1px solid #ddd;
    background: white;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s ease;
    color: #333;
}

.pagination-page.active {
    background: #8B0000;
    color: white;
    border-color: #8B0000;
}

.pagination-page:hover:not(.active) {
    background: #8B0000;
    color: white;
    border-color: #8B0000;
}

/* Dark mode pagination */
body.dark-mode .pagination-info {
    color: #ccc !important;
}

body.dark-mode .pagination-btn {
    background: #2a2a2a !important;
    border-color: #555 !important;
    color: #f0f0f0 !important;
}

body.dark-mode .pagination-btn:hover:not(:disabled) {
    background: #8B0000 !important;
    color: white !important;
    border-color: #8B0000 !important;
}

body.dark-mode .pagination-page {
    background: #2a2a2a !important;
    border-color: #555 !important;
    color: #f0f0f0 !important;
}

body.dark-mode .pagination-page.active {
    background: #8B0000 !important;
    color: white !important;
    border-color: #8B0000 !important;
}

body.dark-mode .pagination-page:hover:not(.active) {
    background: #8B0000 !important;
    color: white !important;
    border-color: #8B0000 !important;
}

body.dark-mode .submissions-table-container {
    background: #2a2a2a !important;
    border: 1px solid #555 !important;
}

body.dark-mode .submissions-table {
    background: #2a2a2a !important;
}

body.dark-mode .submissions-table thead {
    background-color: #8B0000 !important;
}

body.dark-mode .submissions-table thead th {
    color: white !important;
    border-bottom: 1px solid white !important;
    border-right: 1px solid white !important;
    background-color: #8B0000 !important;
}

body.dark-mode .submissions-table thead th:last-child {
    border-right: none !important;
}

body.dark-mode .submissions-table tbody td {
    background: #363636 !important;
    color: #f0f0f0 !important;
    border-bottom: 1px solid #555 !important;
    border-right: 1px solid #555 !important;
}

body.dark-mode .submissions-table tbody td:last-child {
    border-right: none !important;
}

body.dark-mode .submissions-table tbody tr:hover {
    background-color: #404040 !important;
}

/* Additional specificity to override Bootstrap and other styles */
.submissions-table-container .submissions-table thead th {
    background-color: #8B0000 !important;
    color: white !important;
    border-bottom: 1px solid white !important;
    border-right: 1px solid white !important;
}

.submissions-table-container .submissions-table thead th:last-child {
    border-right: none !important;
}

body.dark-mode .submissions-table-container .submissions-table thead th {
    background-color: #8B0000 !important;
    color: white !important;
    border-bottom: 1px solid #555  !important;
    border-right: 1px solid #555  !important;
}

body.dark-mode .submissions-table-container .submissions-table thead th:last-child {
    border-right: none !important;
}

.btn-view {
    background-color: #8B0000;
    color: white;
    border: none;
    border-radius: 6px;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    cursor: pointer;
    padding: 0;
}

.btn-view:hover {
    background-color: #A52A2A;
    transform: translateY(-1px);
}

.btn-view i {
    font-size: 0.9rem;
}

/* Dark mode button styling */
body.dark-mode .btn-view {
    background-color: #8B0000 !important;
    color: white !important;
}

body.dark-mode .btn-view:hover {
    background-color: #A52A2A !important;
}

/* Success Modal Styles */
.success-modal-content {
    border: none !important;
    border-radius: 12px !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
}

.success-icon {
    animation: successPulse 0.6s ease-in-out;
}

.success-title {
    color: #333 !important;
    font-weight: 600 !important;
    font-size: 1.5rem !important;
}

.success-message {
    color: #666 !important;
    font-size: 1rem !important;
    line-height: 1.5 !important;
}

.success-modal-content .btn-success {
    background-color: #28a745 !important;
    border-color: #28a745 !important;
    padding: 0.75rem 2rem !important;
    border-radius: 6px !important;
    font-weight: 500 !important;
    transition: all 0.2s ease !important;
    color: white !important;
}

.success-modal-content .btn-success:hover {
    background-color: #218838 !important;
    border-color: #218838 !important;
    transform: translateY(-1px) !important;
    color: white !important;
}

/* Dark mode success modal */
body.dark-mode .success-modal-content {
    background-color: #2a2a2a !important;
    color: #f0f0f0 !important;
}

body.dark-mode .success-title {
    color: #f0f0f0 !important;
}

body.dark-mode .success-message {
    color: #ccc !important;
}

/* Success animation */
@keyframes successPulse {
    0% {
        transform: scale(0.8);
        opacity: 0;
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

/* Validation Modal Styles */
.validation-modal-content {
    border: none !important;
    border-radius: 12px !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
}

.validation-icon {
    animation: validationShake 0.6s ease-in-out;
}

.validation-title {
    color: #333 !important;
    font-weight: 600 !important;
    font-size: 1.5rem !important;
}

.validation-message {
    color: #666 !important;
    font-size: 1rem !important;
    line-height: 1.5 !important;
}

.validation-modal-content .btn-warning {
    background-color: #ffc107 !important;
    border-color: #ffc107 !important;
    padding: 0.75rem 2rem !important;
    border-radius: 6px !important;
    font-weight: 500 !important;
    transition: all 0.2s ease !important;
    color: #212529 !important;
}

.validation-modal-content .btn-warning:hover {
    background-color: #e0a800 !important;
    border-color: #e0a800 !important;
    transform: translateY(-1px) !important;
    color: #212529 !important;
}

/* Dark mode validation modal */
body.dark-mode .validation-modal-content {
    background-color: #2a2a2a !important;
    color: #f0f0f0 !important;
}

body.dark-mode .validation-title {
    color: #f0f0f0 !important;
}

body.dark-mode .validation-message {
    color: #ccc !important;
}

/* Validation animation */
@keyframes validationShake {
    0%, 100% {
        transform: translateX(0);
    }
    10%, 30%, 50%, 70%, 90% {
        transform: translateX(-5px);
    }
    20%, 40%, 60%, 80% {
        transform: translateX(5px);
    }
}

/* Modal Styles - Override Main CSS */
#submissionModal {
    display: none !important;
    position: fixed !important;
    z-index: 9999 !important;
    left: 0 !important;
    top: 0 !important;
    width: 100% !important;
    height: 100% !important;
    background-color: rgba(0, 0, 0, 0.5) !important;
    backdrop-filter: blur(5px);
}

#submissionModal.show {
    display: block !important;
}

#submissionModal .modal-dialog {
    max-width: 60vw !important;
    width: 60vw !important;
    margin: 1.75rem auto !important;
    display: flex !important;
    align-items: center !important;
    min-height: calc(100% - 3.5rem) !important;
    position: relative !important;
}

#submissionModal .modal-content {
    background-color: #fff !important;
    margin: 0 !important;
    padding: 0 !important;
    border-radius: 15px !important;
    width: 100% !important;
    max-width: none !important;
    max-height: 70vh !important;
    overflow-y: auto !important;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2) !important;
    display: flex !important;
    flex-direction: column !important;
    animation: modalSlideIn 0.3s ease-out !important;
}

body.dark-mode #submissionModal .modal-content {
    background-color: #2a2a2a !important;
    color: #f0f0f0 !important;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    padding: 1.5rem 2rem;
    text-align: left;
}

.modal-title {
    font-weight: 700;
    color: #333;
    font-size: 1.25rem;
    margin: 0;
}

.modal-body {
    padding: 2rem;
    flex: 1;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
}

.submission-content {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    flex: 1;
}

/* Info Card Styles */
.info-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    overflow: hidden;
    border: 1px solid #e9ecef;
}

.card-header {
    background-color: #f8f9fa;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #dee2e6;
}

.card-title {
    font-weight: 600;
    color: #8B0000;
    font-size: 1.25rem;
    margin: 0;
    border-bottom: 2px solid #8B0000;
    padding-bottom: 0.5rem;
    display: inline-block;
}

.card-body {
    padding: 2rem;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid #f1f3f4;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-row .label {
    font-weight: 600;
    color: #333;
    font-size: 1rem;
    min-width: 150px;
}

.detail-row .value {
    color: #666;
    font-size: 1rem;
    text-align: right;
    flex: 1;
}

/* Status Badge Styles */
.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: 1px solid;
}

.status-pending {
    background-color: #fff3cd;
    color: #856404;
    border-color: #ffc107;
}

.status-approve {
    background-color: #d4edda;
    color: #155724;
    border-color: #28a745;
}

.status-reject {
    background-color: #f8d7da;
    color: #721c24;
    border-color: #dc3545;
}

/* Dark mode status badges */
body.dark-mode .status-pending {
    background-color: #744210;
    color: #f6e05e;
    border-color: #f6e05e;
}

body.dark-mode .status-approve {
    background-color: #1e4d2b;
    color: #68d391;
    border-color: #68d391;
}

body.dark-mode .status-reject {
    background-color: #742a2a;
    color: #feb2b2;
    border-color: #feb2b2;
}

.remarks-textarea {
    border: 1px solid #ddd;
    border-radius: 8px;
    resize: vertical;
    min-height: 120px;
    width: 100%;
    padding: 1rem;
    font-size: 1rem;
    font-family: inherit;
}

.remarks-note {
    display: block;
    margin-top: 0.5rem;
    color: #666;
    font-size: 0.85rem;
    font-style: italic;
}

.action-buttons-container {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #dee2e6;
    width: 100%;
}

.action-buttons-container .btn {
    padding: 0.75rem;
    border-radius: 6px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    width: 50px;
    height: 50px;
    flex-shrink: 0;
}

.btn-approve {
    background-color: #28a745 !important;
    color: white !important;
    border: none !important;
}

.btn-approve:hover {
    background-color: #218838 !important;
    transform: translateY(-1px);
    color: white !important;
}

.btn-reject {
    background-color: #8B0000 !important;
    color: white !important;
    border: none !important;
}

.btn-reject:hover {
    background-color: #A52A2A !important;
    transform: translateY(-1px);
    color: white !important;
}

.btn-return {
    background-color: #FFD700 !important;
    color: #212529 !important;
    border: none !important;
}

.btn-return:hover {
    background-color: #FFA500 !important;
    transform: translateY(-1px);
    color: #212529 !important;
}

.btn-flag {
    background-color: #dc3545 !important;
    color: white !important;
    border: none !important;
}

.btn-flag:hover {
    background-color: #c82333 !important;
    transform: translateY(-1px);
    color: white !important;
}

/* Dark Mode Styles - Matching Admin Dashboard */
body.dark-mode .modal-content {
    background-color: #2a2a2a !important;
    color: #f0f0f0;
}

body.dark-mode #submissionModal .modal-body {
    background-color: #2a2a2a !important;
    color: #f0f0f0 !important;
}

body.dark-mode #submissionModal .submission-content {
    background-color: #2a2a2a !important;
    color: #f0f0f0 !important;
}

body.dark-mode .modal-header {
    background: #2a2a2a;
    border-color: #555;
    padding: 1.5rem 2rem;
}

body.dark-mode .modal-title {
    color: #F9BD3D;
}

body.dark-mode .info-card {
    background: #2a2a2a !important;
    border-color: #555 !important;
    box-shadow: 0 4px 16px rgba(0,0,0,0.3);
}

body.dark-mode .card-header {
    background: #2a2a2a !important;
    border-bottom-color: #555 !important;
}

body.dark-mode .card-title {
    color: #F9BD3D;
    border-bottom-color: #F9BD3D;
}

body.dark-mode .detail-row {
    border-bottom-color: #555;
}

body.dark-mode .detail-row .label {
    color: #f0f0f0;
}

body.dark-mode .detail-row .value {
    color: #f0f0f0;
}

body.dark-mode .status-pending {
    color: #f6e05e !important;
    background-color: #744210;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-weight: 600;
}

body.dark-mode .remarks-textarea {
    background-color: #2a2a2a !important;
    border-color: #555 !important;
    color: #f0f0f0;
}

body.dark-mode .remarks-textarea::placeholder {
    color: #aaa;
}

body.dark-mode .remarks-note {
    color: #aaa !important;
}

body.dark-mode .action-buttons-container {
    border-top-color: #555 !important;
}

#submissionModal .btn-close {
    background: #dc3545 !important;
    color: white !important;
    border-radius: 4px !important;
    width: 24px !important;
    height: 24px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 14px !important;
    border: none !important;
    transition: all 0.2s ease !important;
    opacity: 1 !important;
    background-image: none !important;
}

#submissionModal .btn-close::before {
    content: "×" !important;
    font-size: 18px !important;
    font-weight: bold !important;
    color: white !important;
    line-height: 1 !important;
}

#submissionModal .btn-close:hover {
    background: #c82333 !important;
    color: white !important;
    transform: translateY(-1px) !important;
    opacity: 1 !important;
}

#submissionModal .btn-close:focus {
    background: #dc3545 !important;
    color: white !important;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
}

body.dark-mode #submissionModal .btn-close {
    background: #dc3545 !important;
    color: white !important;
    opacity: 1 !important;
}

body.dark-mode #submissionModal .btn-close:hover {
    background: #c82333 !important;
    color: white !important;
    opacity: 1 !important;
}

/* Dark mode button hover effects */
body.dark-mode .btn-approve:hover {
    background-color: #2d5a2d !important;
}

body.dark-mode .btn-reject:hover {
    background-color: #8b0000 !important;
}

body.dark-mode .btn-return:hover {
    background-color: #b8860b !important;
}

body.dark-mode .btn-flag:hover {
    background-color: #8b0000 !important;
}

@media (max-width: 768px) {
    .controls-section {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }
    
    .filter-controls {
        flex-direction: column;
        gap: 1rem;
    }
    
    .search-controls {
        max-width: none;
    }
    
    .action-buttons-container {
        flex-direction: column;
        align-items: stretch;
    }
    
    .action-buttons-container .btn {
        width: 100%;
        justify-content: center;
    }
    
    .detail-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
    
    .detail-row span {
        text-align: left;
    }
}
</style>

<script>
// Sample data for different submissions
const submissionData = {
    1: {
        studentName: "DELA CRUZ, Juan M.",
        studentId: "2021-12345",
        documentTitle: "Leadership Portfolio",
        sleaSections: "Leadership Excellence",
        subsection: "Student Leadership",
        role: "President",
        activityDate: "2024-01-10",
        organizingBody: "Student Council",
        score: "85/100",
        status: "pending"
    },
    2: {
        studentName: "SANTOS, Maria A.",
        studentId: "2021-67890",
        documentTitle: "Community Service Report",
        sleaSections: "Community Engagement",
        subsection: "Volunteer Work",
        role: "Coordinator",
        activityDate: "2024-01-09",
        organizingBody: "Community Outreach",
        score: "92/100",
        status: "approve"
    },
    3: {
        studentName: "GARCIA, Pedro L.",
        studentId: "2021-54321",
        documentTitle: "Academic Excellence Portfolio",
        sleaSections: "Academic Excellence",
        subsection: "Research",
        role: "Lead Researcher",
        activityDate: "2024-01-08",
        organizingBody: "Research Department",
        score: "88/100",
        status: "reject"
    },
    4: {
        studentName: "RODRIGUEZ, Ana S.",
        studentId: "2021-98765",
        documentTitle: "Leadership Development Plan",
        sleaSections: "Leadership Excellence",
        subsection: "Leadership Training",
        role: "Facilitator",
        activityDate: "2024-01-07",
        organizingBody: "Leadership Institute",
        score: "90/100",
        status: "pending"
    },
    5: {
        studentName: "MARTINEZ, Carlos R.",
        studentId: "2021-11111",
        documentTitle: "Innovation Project Proposal",
        sleaSections: "Innovation & Creativity",
        subsection: "Project Development",
        role: "Project Lead",
        activityDate: "2024-01-06",
        organizingBody: "Innovation Lab",
        score: "87/100",
        status: "approve"
    }
};

function openSubmissionModal(submissionId) {
    const data = submissionData[submissionId];
    if (data) {
        document.getElementById('modalStudentName').textContent = data.studentName;
        document.getElementById('modalStudentId').textContent = data.studentId;
        document.getElementById('modalDocumentTitle').textContent = data.documentTitle;
        document.getElementById('modalSleaSections').textContent = data.sleaSections;
        document.getElementById('modalSubsection').textContent = data.subsection;
        document.getElementById('modalRole').textContent = data.role;
        document.getElementById('modalActivityDate').textContent = data.activityDate;
        document.getElementById('modalOrganizingBody').textContent = data.organizingBody;
        document.getElementById('modalScore').textContent = data.score;
        
        // Update status badge
        const statusBadge = document.querySelector('.status-badge');
        statusBadge.className = `status-badge status-${data.status}`;
        statusBadge.textContent = data.status.toUpperCase();
        
        // Clear previous remarks
        document.getElementById('assessorRemarks').value = '';
        
        // Store current submission ID for action handling
        document.getElementById('submissionModal').setAttribute('data-submission-id', submissionId);
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('submissionModal'));
        modal.show();
    }
}

function handleSubmission(action) {
    const submissionId = document.getElementById('submissionModal').getAttribute('data-submission-id');
    const remarks = document.getElementById('assessorRemarks').value.trim();
    
    // Validate remarks for reject, return, and flag actions
    if ((action === 'reject' || action === 'return' || action === 'flag') && !remarks) {
        showValidationError('Please provide remarks before performing this action.');
        return;
    }
    
    // Here you would typically send the data to your backend
    console.log(`Action: ${action}, Submission ID: ${submissionId}, Remarks: ${remarks}`);
    
    // Close the submission modal first
    const modal = bootstrap.Modal.getInstance(document.getElementById('submissionModal'));
    modal.hide();
    
    // Show appropriate success message based on action
    showSuccessMessage(action);
    
    // Here you would typically refresh the table or remove the row
}

function showValidationError(message) {
    // Create validation error modal
    const errorModal = document.createElement('div');
    errorModal.className = 'modal fade';
    errorModal.id = 'validationModal';
    errorModal.innerHTML = `
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content validation-modal-content">
                <div class="modal-body text-center p-4">
                    <div class="validation-icon mb-3">
                        <i class="fas fa-exclamation-triangle" style="color: #dc3545; font-size: 3rem;"></i>
                    </div>
                    <h5 class="validation-title mb-3">Validation Required</h5>
                    <p class="validation-message mb-4">${message}</p>
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                        OK
                    </button>
                </div>
            </div>
        </div>
    `;
    
    // Add to body
    document.body.appendChild(errorModal);
    
    // Show modal
    const modal = new bootstrap.Modal(errorModal);
    modal.show();
    
    // Remove modal from DOM when hidden
    errorModal.addEventListener('hidden.bs.modal', function() {
        document.body.removeChild(errorModal);
    });
}

function showSuccessMessage(action) {
    let message = '';
    let icon = '';
    let color = '';
    
    switch(action) {
        case 'approve':
            message = 'Submission has been successfully approved!';
            icon = 'fas fa-check-circle';
            color = '#28a745';
            break;
        case 'reject':
            message = 'Submission has been successfully rejected.';
            icon = 'fas fa-times-circle';
            color = '#8B0000';
            break;
        case 'return':
            message = 'Submission has been returned to the student for revision.';
            icon = 'fas fa-undo';
            color = '#FFD700';
            break;
        case 'flag':
            message = 'Submission has been flagged for further review.';
            icon = 'fas fa-flag';
            color = '#dc3545';
            break;
        default:
            message = 'Action completed successfully!';
            icon = 'fas fa-info-circle';
            color = '#007bff';
    }
    
    // Create success modal
    const successModal = document.createElement('div');
    successModal.className = 'modal fade';
    successModal.id = 'successModal';
    successModal.innerHTML = `
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content success-modal-content">
                <div class="modal-body text-center p-4">
                    <div class="success-icon mb-3">
                        <i class="${icon}" style="color: ${color}; font-size: 3rem;"></i>
                    </div>
                    <h5 class="success-title mb-3">Success!</h5>
                    <p class="success-message mb-4">${message}</p>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                        OK
                    </button>
                </div>
            </div>
        </div>
    `;
    
    // Add to body
    document.body.appendChild(successModal);
    
    // Show modal
    const modal = new bootstrap.Modal(successModal);
    modal.show();
    
    // Remove modal from DOM when hidden
    successModal.addEventListener('hidden.bs.modal', function() {
        document.body.removeChild(successModal);
    });
}

// Search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const tableRows = document.querySelectorAll('.submissions-table tbody tr');
    
    tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Filter functionality
document.getElementById('filterSelect').addEventListener('change', function(e) {
    // Implement filter logic here
    console.log('Filter changed:', e.target.value);
});

// Sort functionality
document.getElementById('sortSelect').addEventListener('change', function(e) {
    // Implement sort logic here
    console.log('Sort changed:', e.target.value);
});

// Dynamic Pagination
let currentPage = 1;
const entriesPerPage = 5;
let totalEntries = 0;
let totalPages = 0;

// Initialize pagination
function initializePagination() {
    // Count total entries (rows in table)
    const tableRows = document.querySelectorAll('.submissions-table tbody tr');
    totalEntries = tableRows.length;
    totalPages = Math.ceil(totalEntries / entriesPerPage);
    
    // Update pagination info
    updatePaginationInfo();
    
    // Generate page buttons
    generatePageButtons();
    
    // Show/hide entries based on current page
    showPageEntries();
}

// Update pagination info
function updatePaginationInfo() {
    const start = (currentPage - 1) * entriesPerPage + 1;
    const end = Math.min(currentPage * entriesPerPage, totalEntries);
    
    document.getElementById('showingStart').textContent = start;
    document.getElementById('showingEnd').textContent = end;
    document.getElementById('totalEntries').textContent = totalEntries;
}

// Generate page buttons
function generatePageButtons() {
    const paginationPages = document.getElementById('paginationPages');
    paginationPages.innerHTML = '';
    
    // Show max 5 page buttons
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, startPage + 4);
    
    // Adjust start page if we're near the end
    if (endPage - startPage < 4) {
        startPage = Math.max(1, endPage - 4);
    }
    
    for (let i = startPage; i <= endPage; i++) {
        const pageBtn = document.createElement('button');
        pageBtn.className = 'pagination-page';
        if (i === currentPage) {
            pageBtn.classList.add('active');
        }
        pageBtn.textContent = i;
        pageBtn.onclick = () => goToPage(i);
        paginationPages.appendChild(pageBtn);
    }
}

// Go to specific page
function goToPage(page) {
    currentPage = page;
    showPageEntries();
    updatePaginationInfo();
    generatePageButtons();
    updateNavigationButtons();
}

// Show entries for current page
function showPageEntries() {
    const tableRows = document.querySelectorAll('.submissions-table tbody tr');
    const start = (currentPage - 1) * entriesPerPage;
    const end = start + entriesPerPage;
    
    tableRows.forEach((row, index) => {
        if (index >= start && index < end) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Update navigation buttons
function updateNavigationButtons() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    prevBtn.disabled = currentPage === 1;
    nextBtn.disabled = currentPage === totalPages;
}

// Previous page
document.getElementById('prevBtn').addEventListener('click', function() {
    if (currentPage > 1) {
        goToPage(currentPage - 1);
    }
});

// Next page
document.getElementById('nextBtn').addEventListener('click', function() {
    if (currentPage < totalPages) {
        goToPage(currentPage + 1);
    }
});

// Initialize pagination when page loads
document.addEventListener('DOMContentLoaded', function() {
    initializePagination();
});
</script>
@endsection
