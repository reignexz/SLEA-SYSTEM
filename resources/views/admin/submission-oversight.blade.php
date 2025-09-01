@extends('layouts.app')

@section('title', 'Submission Oversight')

@section('content')
<div class="page-with-back-button">
    <div class="page-content">
        <!-- Back Button -->
        <div class="rubric-header-nav">
            <a href="{{ route('admin.profile') }}" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <h2 class="manage-title">Submission Oversight</h2>

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
        <form class="controls" method="GET" action="{{ route('admin.submission-oversight') }}">
            <div class="controls-left">
                <div class="dropdowns">
                    <label>
                        <span>Filter</span>
                        <select name="filter">
                            <option value="" @selected(request('filter')==='')>None</option>
                            <option value="pending" @selected(request('filter')==='pending')>Pending</option>
                            <option value="approved" @selected(request('filter')==='approved')>Approved</option>
                            <option value="rejected" @selected(request('filter')==='rejected')>Rejected</option>
                            <option value="flagged" @selected(request('filter')==='flagged')>Flagged</option>
                        </select>
                    </label>

                    <label>
                        <span>Sort by</span>
                        <select name="sort">
                            <option value="" @selected(request('sort')==='')>None</option>
                            <option value="title" @selected(request('sort')==='title')>Document Title</option>
                            <option value="student" @selected(request('sort')==='student')>Student Name</option>
                            <option value="category" @selected(request('sort')==='category')>Category</option>
                            <option value="status" @selected(request('sort')==='status')>Submission Status</option>
                            <option value="date" @selected(request('sort')==='date')>Submission Date</option>
                        </select>
                    </label>
                </div>
            </div>

            <div class="search-box">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Search...">
                <button class="search-btn" type="submit" aria-label="Search">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        {{-- Table --}}
        <div class="table-wrap">
            <table class="submission-table">
                <thead>
                    <tr>
                        <th class="col-title">Document Title</th>
                        <th class="col-student">Student Name</th>
                        <th class="col-category">Category</th>
                        <th class="col-status">Submission Status</th>
                        <th class="col-flag">Flag</th>
                        <th class="col-action text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $hasRows = isset($submissions) && (($submissions instanceof \Illuminate\Contracts\Pagination\Paginator && $submissions->count() > 0) || collect($submissions)->count() > 0);
                    @endphp

                    @if ($hasRows)
                        @foreach ($submissions ?? [] as $submission)
                            <tr>
                                <td>{{ $submission->document_title ?? 'Leadership Certificate' }}</td>
                                <td>{{ $submission->student_name ?? 'Edryan Manocay' }}</td>
                                <td>{{ $submission->category ?? 'I. Leadership' }}</td>
                                <td>
                                    <span class="badge {{ $submission->status === 'pending' ? 'badge--yellow' : ($submission->status === 'approved' ? 'badge--green' : 'badge--red') }}">
                                        {{ ucfirst($submission->status ?? 'pending') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($submission->is_flagged ?? false)
                                        <i class="fas fa-flag" style="color: #dc3545;"></i>
                                    @else
                                        <i class="fas fa-flag" style="color: #6c757d; opacity: 0.3;"></i>
                                    @endif
                                </td>
                                <td class="action-buttons">
                                    <button type="button" class="btn btn-view" onclick="openSubmissionModal('{{ $submission->id ?? '1' }}')">View</button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        {{-- Sample data for demonstration --}}
                        <tr>
                            <td>Leadership Certificate</td>
                            <td>Edryan Manocay</td>
                            <td>I. Leadership</td>
                            <td>
                                <span class="badge badge--yellow">Pending</span>
                            </td>
                            <td class="text-center">
                                <i class="fas fa-flag" style="color: #dc3545;"></i>
                            </td>
                            <td class="action-buttons">
                                <button type="button" class="btn btn-view" onclick="openSubmissionModal('sample-1')">View</button>
                            </td>
                        </tr>
                        {{-- Empty rows for demonstration --}}
                        @for ($i = 0; $i < 5; $i++)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center">
                                    <i class="fas fa-flag" style="color: #6c757d; opacity: 0.3;"></i>
                                </td>
                                <td class="action-buttons">
                                    <button type="button" class="btn btn-view" disabled>View</button>
                                </td>
                            </tr>
                        @endfor
                    @endif
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        @if (isset($submissions) && method_exists($submissions, 'links'))
            <div class="table-pagination">
                {{ $submissions->withQueryString()->links() }}
            </div>
        @else
            {{-- Sample pagination for demonstration --}}
            <div class="table-pagination">
                <nav>
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <span class="page-link">Previous</span>
                        </li>
                        <li class="page-item active">
                            <span class="page-link">1</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">4</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        @endif

        {{-- Export Button --}}
        <div class="export-section">
            <button type="button" class="btn btn-export">
                <i class="fas fa-file-pdf"></i> Export as PDF
            </button>
        </div>
        <!-- Submission Details Modal -->
        <div id="submissionModal" class="modal" style="display:none;">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Submission Details</h3>
                    <span class="close" onclick="closeSubmissionModal()">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="submission-details">
                        <div class="detail-section">
                            <h4>Document Information</h4>
                            <div class="detail-row"><span class="detail-label">Title:</span><span class="detail-value" id="md-title">Leadership Certificate</span></div>
                            <div class="detail-row"><span class="detail-label">Category:</span><span class="detail-value" id="md-category">I. Leadership</span></div>
                            <div class="detail-row"><span class="detail-label">Status:</span><span class="detail-value" id="md-status">Pending</span></div>
                        </div>

                        <div class="detail-section">
                            <h4>Student Information</h4>
                            <div class="detail-row"><span class="detail-label">Name:</span><span class="detail-value" id="md-student">Edryan Manocay</span></div>
                            <div class="detail-row"><span class="detail-label">Student ID:</span><span class="detail-value" id="md-student-id">2022-00216</span></div>
                        </div>

                        <div class="detail-section">
                            <h4>Document Content</h4>
                            <div class="document-preview" id="md-preview">No preview available.</div>
                            <button type="button" class="btn btn-download" id="md-download">Download</button>
                        </div>

                        <div class="detail-section">
                            <h4>Assessment Information</h4>
                            <div class="detail-row"><span class="detail-label">Reviewer:</span><span class="detail-value" id="md-reviewer">—</span></div>
                            <div class="detail-row"><span class="detail-label">Remarks:</span><span class="detail-value" id="md-remarks">—</span></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" onclick="closeSubmissionModal()">Close</button>
                </div>
            </div>
        </div>

        <script>
        function openSubmissionModal(submissionId) {
            // Example placeholder: populate fields. Replace with AJAX if needed
            document.getElementById('md-title').textContent = 'Leadership Certificate';
            document.getElementById('md-category').textContent = 'I. Leadership';
            document.getElementById('md-status').textContent = 'Pending';
            document.getElementById('md-student').textContent = 'Edryan Manocay';
            document.getElementById('md-student-id').textContent = '2022-00216';
            document.getElementById('md-reviewer').textContent = '—';
            document.getElementById('md-remarks').textContent = '—';

            const modal = document.getElementById('submissionModal');
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden'; // prevent background scroll
        }

        function closeSubmissionModal() {
            const modal = document.getElementById('submissionModal');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        window.addEventListener('click', function(e) {
            const modal = document.getElementById('submissionModal');
            if (e.target === modal) {
                closeSubmissionModal();
            }
        });
        </script>
    </div>
</div>
@endsection
