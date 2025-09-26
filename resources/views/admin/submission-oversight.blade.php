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
            <table class="submission-table" style="table-layout: fixed; width: 100%;">
                <thead>
                    <tr>
                        <th class="col-title" style="width:25%">Document Title</th>
                        <th class="col-student" style="width:20%">Student Name</th>
                        <th class="col-category" style="width:20%">Category</th>
                        <th class="col-status" style="width:15%">Submission Status</th>
                        <th class="col-flag" style="width:10%">Flag</th>
                        <th class="col-action text-center" style="width:10%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $hasRows = isset($submissions) && (($submissions instanceof \Illuminate\Contracts\Pagination\Paginator && $submissions->count() > 0) || collect($submissions)->count() > 0);
                    @endphp

                    @if ($hasRows)
                        @foreach ($submissions ?? [] as $submission)
                            <tr>
                                <td>{{ $submission->document_title ?? '—' }}</td>
                                <td>{{ optional($submission->student)->name ?? '—' }}</td>
                                <td>{{ $submission->slea_section ?? '—' }}</td>
                                <td>
                                    @php $st = strtolower($submission->status ?? 'pending'); @endphp
                                    <span class="badge {{ $st === 'pending' ? 'badge--yellow' : ($st === 'approved' ? 'badge--green' : 'badge--red') }}">
                                        {{ ucfirst($st) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @php $flagged = filled($submission->flag_reason ?? null); @endphp
                                    @if($flagged)
                                        <i class="fas fa-flag" style="color: #dc3545;"></i>
                                    @else
                                        <i class="fas fa-flag" style="color: #6c757d; opacity: 0.3;"></i>
                                    @endif
                                </td>
                                <td class="action-buttons">
                                    <button 
                                        type="button" 
                                        class="btn-action btn-view js-open-submission"
                                        title="View Submission"
                                        data-submission-id="{{ $submission->id ?? '' }}"
                                        data-title="{{ $submission->document_title ?? '' }}"
                                        data-category="{{ $submission->slea_section ?? '' }}"
                                        data-status="{{ $submission->status ?? '' }}"
                                        data-student="{{ optional($submission->student)->name ?? '' }}"
                                        data-student-id="{{ optional($submission->student)->student_id ?? '' }}"
                                        data-date="{{ optional($submission->submitted_at)->format('Y-m-d') ?? '' }}"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </button>
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
                                <button type="button" class="btn-action btn-view" onclick="openSubmissionModal('sample-1')" title="View Submission">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>Academic Excellence Award</td>
                            <td>Maria Santos</td>
                            <td>II. Academic</td>
                            <td>
                                <span class="badge badge--green">Approved</span>
                            </td>
                            <td class="text-center">
                                <i class="fas fa-flag" style="color: #6c757d; opacity: 0.3;"></i>
                            </td>
                            <td class="action-buttons">
                                <button type="button" class="btn-action btn-view" onclick="openSubmissionModal('sample-2')" title="View Submission">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>Community Service Certificate</td>
                            <td>John Dela Cruz</td>
                            <td>IV. Community</td>
                            <td>
                                <span class="badge badge--red">Rejected</span>
                            </td>
                            <td class="text-center">
                                <i class="fas fa-flag" style="color: #dc3545;"></i>
                            </td>
                            <td class="action-buttons">
                                <button type="button" class="btn-action btn-view" onclick="openSubmissionModal('sample-3')" title="View Submission">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>Dean's List Recognition</td>
                            <td>Sarah Johnson</td>
                            <td>II. Academic</td>
                            <td>
                                <span class="badge badge--yellow">Pending</span>
                            </td>
                            <td class="text-center">
                                <i class="fas fa-flag" style="color: #6c757d; opacity: 0.3;"></i>
                            </td>
                            <td class="action-buttons">
                                <button type="button" class="btn-action btn-view" onclick="openSubmissionModal('sample-4')" title="View Submission">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>Student Council President</td>
                            <td>Michael Rodriguez</td>
                            <td>I. Leadership</td>
                            <td>
                                <span class="badge badge--green">Approved</span>
                            </td>
                            <td class="text-center">
                                <i class="fas fa-flag" style="color: #6c757d; opacity: 0.3;"></i>
                            </td>
                            <td class="action-buttons">
                                <button type="button" class="btn-action btn-view" onclick="openSubmissionModal('sample-5')" title="View Submission">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>Volunteer Work Documentation</td>
                            <td>Anna Garcia</td>
                            <td>IV. Community</td>
                            <td>
                                <span class="badge badge--yellow">Pending</span>
                            </td>
                            <td class="text-center">
                                <i class="fas fa-flag" style="color: #dc3545;"></i>
                            </td>
                            <td class="action-buttons">
                                <button type="button" class="btn-action btn-view" onclick="openSubmissionModal('sample-6')" title="View Submission">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>Research Paper Publication</td>
                            <td>David Kim</td>
                            <td>II. Academic</td>
                            <td>
                                <span class="badge badge--green">Approved</span>
                            </td>
                            <td class="text-center">
                                <i class="fas fa-flag" style="color: #6c757d; opacity: 0.3;"></i>
                            </td>
                            <td class="action-buttons">
                                <button type="button" class="btn-action btn-view" onclick="openSubmissionModal('sample-7')" title="View Submission">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>Sports Achievement Award</td>
                            <td>Lisa Chen</td>
                            <td>III. Awards</td>
                            <td>
                                <span class="badge badge--red">Rejected</span>
                            </td>
                            <td class="text-center">
                                <i class="fas fa-flag" style="color: #dc3545;"></i>
                            </td>
                            <td class="action-buttons">
                                <button type="button" class="btn-action btn-view" onclick="openSubmissionModal('sample-8')" title="View Submission">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>Disciplinary Clearance</td>
                            <td>Robert Wilson</td>
                            <td>V. Good Conduct</td>
                            <td>
                                <span class="badge badge--yellow">Pending</span>
                            </td>
                            <td class="text-center">
                                <i class="fas fa-flag" style="color: #6c757d; opacity: 0.3;"></i>
                            </td>
                            <td class="action-buttons">
                                <button type="button" class="btn-action btn-view" onclick="openSubmissionModal('sample-9')" title="View Submission">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>International Conference Presentation</td>
                            <td>Jennifer Lee</td>
                            <td>II. Academic</td>
                            <td>
                                <span class="badge badge--green">Approved</span>
                            </td>
                            <td class="text-center">
                                <i class="fas fa-flag" style="color: #6c757d; opacity: 0.3;"></i>
                            </td>
                            <td class="action-buttons">
                                <button type="button" class="btn-action btn-view" onclick="openSubmissionModal('sample-10')" title="View Submission">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        @if (isset($submissions) && method_exists($submissions, 'links'))
            <div class="unified-pagination">
                {{ $submissions->withQueryString()->links() }}
            </div>
        @else
            {{-- Sample pagination for demonstration --}}
            <div class="unified-pagination">
                <button class="btn-nav" disabled>Previous</button>
                <button class="btn-page active">1</button>
                <button class="btn-page">2</button>
                <button class="btn-page">3</button>
                <button class="btn-page">4</button>
                <button class="btn-nav">Next</button>
            </div>
        @endif

        {{-- Export Button --}}
        <div class="export-section">
            <button type="button" class="btn btn-export" id="btnExportPdf">
                <i class="fas fa-file-pdf"></i> Export as PDF
            </button>
        </div>

        <!-- Export Modal: Shows list of students/details before PDF generation -->
        <div id="exportModal" class="modal" style="display:none;">
            <div class="modal-content" style="max-width: 900px; width: 95%;">
                <div class="modal-header">
                    <h3>Export Submissions to PDF</h3>
                    <span class="close" id="closeExportModal" style="cursor:pointer">&times;</span>
                </div>
                <div class="modal-body">
                    <p class="mb-3">Review the list below. You can proceed to export all shown items.</p>

                    <div class="table-wrap" style="max-height: 60vh; overflow:auto;">
                        <table class="submission-table">
                            <thead>
                                <tr>
                                    <th class="col-student">Student Name</th>
                                    <th class="col-title">Document Title</th>
                                    <th class="col-category">Category</th>
                                    <th class="col-date">Date</th>
                                    <th class="col-status">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $hasRows = isset($submissions) && (($submissions instanceof \Illuminate\Contracts\Pagination\Paginator && $submissions->count() > 0) || collect($submissions)->count() > 0);
                                @endphp

                                @if ($hasRows)
                                    @foreach ($submissions ?? [] as $submission)
                                        <tr>
                                            <td>{{ $submission->student->name ?? ($submission->student_name ?? '—') }}</td>
                                            <td>{{ $submission->document_title ?? '—' }}</td>
                                            <td>{{ $submission->slea_section ?? ($submission->category ?? '—') }}</td>
                                            <td>{{ optional($submission->submitted_at)->format('Y-m-d') ?? '—' }}</td>
                                            <td>
                                                <span class="badge {{ ($submission->status ?? 'pending') === 'pending' ? 'badge--yellow' : (($submission->status ?? '') === 'approved' ? 'badge--green' : 'badge--red') }}">
                                                    {{ ucfirst($submission->status ?? 'pending') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    {{-- Sample rows when there's no data from backend yet --}}
                                    <tr>
                                        <td>Edryan Manocay</td>
                                        <td>Leadership Certificate</td>
                                        <td>I. Leadership</td>
                                        <td>2025-09-01</td>
                                        <td><span class="badge badge--yellow">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td>Maria Santos</td>
                                        <td>Academic Excellence Award</td>
                                        <td>II. Academic</td>
                                        <td>2025-09-02</td>
                                        <td><span class="badge badge--green">Approved</span></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer" style="display:flex; gap:8px; justify-content:flex-end;">
                    <button type="button" class="btn" id="cancelExportBtn" style="background:#e5e7eb; color:#111827; border:1px solid #d1d5db;">Close</button>
                    <a id="exportPdfForm" href="{{ route('admin.submission-oversight.export', request()->query()) }}" class="btn btn-export">
                        <i class="fas fa-file-pdf"></i> Proceed Export
                    </a>
                </div>
            </div>
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
        // Export Modal open/close handlers
        (function() {
            // Delegate open of submission modal, populate from data attributes
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.js-open-submission');
                if (!btn) return;
                const title = btn.getAttribute('data-title') || '—';
                const category = btn.getAttribute('data-category') || '—';
                const status = btn.getAttribute('data-status') || '—';
                const student = btn.getAttribute('data-student') || '—';
                const studentId = btn.getAttribute('data-student-id') || '—';

                document.getElementById('md-title').textContent = title;
                document.getElementById('md-category').textContent = category;
                document.getElementById('md-status').textContent = status ? (status.charAt(0).toUpperCase()+status.slice(1)) : '—';
                document.getElementById('md-student').textContent = student;
                document.getElementById('md-student-id').textContent = studentId;
                document.getElementById('md-reviewer').textContent = '—';
                document.getElementById('md-remarks').textContent = '—';

                const modal = document.getElementById('submissionModal');
                modal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            });
            const exportBtn = document.getElementById('btnExportPdf');
            const exportModal = document.getElementById('exportModal');
            const closeExport = document.getElementById('closeExportModal');
            const cancelExport = document.getElementById('cancelExportBtn');

            function openExportModal() {
                exportModal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }

            function closeExportModal() {
                exportModal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }

            if (exportBtn) exportBtn.addEventListener('click', openExportModal);
            if (closeExport) closeExport.addEventListener('click', closeExportModal);
            if (cancelExport) cancelExport.addEventListener('click', closeExportModal);

            window.addEventListener('click', function(e) {
                if (e.target === exportModal) {
                    closeExportModal();
                }
            });
        })();

        // removed legacy openSubmissionModal; now populated via delegated click above
        
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
