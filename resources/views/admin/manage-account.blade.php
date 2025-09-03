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
                        <select name="filter">
                            <option value="" @selected(request('filter')==='')>None</option>
                            <option value="active" @selected(request('filter')==='active')>Active</option>
                            <option value="disabled" @selected(request('filter')==='disabled')>Disabled</option>
                            <option value="new" @selected(request('filter')==='new')>New (last 7 days)</option>
                        </select>
                    </label>

                    <label>
                        <span>Sort by</span>
                        <select name="sort">
                            <option value="" @selected(request('sort')==='')>None</option>
                            <option value="name" @selected(request('sort')==='name')>Name</option>
                            <option value="date" @selected(request('sort')==='date')>Date</option>
                            <option value="status" @selected(request('sort')==='status')>Account Status</option>
                            <option value="last_login" @selected(request('sort')==='last_login')>Last Login</option>
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
            <table class="manage-table">
                <thead>
                    <tr>
                        <th class="col-email">Email Address</th>
                        <th class="col-name">Name</th>
                        <th class="col-date">Date</th>
                        <th class="col-status">Account Status</th>
                        <th class="col-last">Last Login</th>
                        <th class="col-action text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $hasRows = $users instanceof \Illuminate\Contracts\Pagination\Paginator
                                   ? $users->count() > 0
                                   : collect($users)->count() > 0;
                    @endphp

                    @if ($hasRows)
                        @foreach ($users as $user)
                            @php
                                $isDisabled     = (bool) ($user->is_disabled ?? false);
                                $statusText     = $isDisabled ? 'Disabled' : 'Active';
                                $toggleLabel    = $isDisabled ? 'Enable' : 'Disable';
                                $toggleIcon     = $isDisabled ? 'fa-check' : 'fa-ban';
                                $toggleClass    = $isDisabled ? 'btn-enable' : 'btn-disable';
                            @endphp
                            <tr>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->created_at?->format('Y-m-d') }}</td>
                                <td>
                                    <span class="badge {{ $isDisabled ? 'badge--red' : 'badge--green' }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td>{{ optional($user->last_login_at)->diffForHumans() ?? '—' }}</td>

                                <td class="action-buttons">
                                    <button type="button" 
                                            class="btn {{ $toggleClass }} btn-icon" 
                                            title="{{ $toggleLabel }}" aria-label="{{ $toggleLabel }}"
                                            onclick="openToggleModal('{{ $user->id }}', '{{ $user->email }}', '{{ $toggleLabel }}', '{{ $isDisabled ? 'enable' : 'disable' }}')"                                        
                                            <i class="fas {{ $toggleIcon }}"></i>
                                    </button>

                                    <button type="button" 
                                            class="btn btn-delete btn-icon" 
                                            title="Delete" aria-label="Delete"
                                            onclick="openDeleteModal('{{ $user->id }}', '{{ $user->email }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        {{-- Render the empty grid like the Figma (6 blank rows with actions visible) --}}
                        @for ($i = 0; $i < 6; $i++)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="action-buttons">
                                    <button type="button" class="btn btn-disable btn-icon" disabled title="Disable" aria-label="Disable">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                    <button type="button" class="btn btn-delete btn-icon" disabled title="Delete" aria-label="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endfor
                    @endif
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        @if (method_exists($users, 'links'))
            <div class="table-pagination">
                {{ $users->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Toggle Status Modal -->
<div id="toggleModal" class="modal">
    <div class="modal-content confirmation-modal">
        <div class="modal-header">
            <h3 id="toggleModalTitle">Toggle Account Status</h3>
            <span class="close" onclick="closeToggleModal()">&times;</span>
        </div>
        <div class="modal-body">
            <p id="toggleModalMessage"></p>
            <div class="account-details">
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value" id="toggleModalEmail"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Action:</span>
                    <span class="detail-value" id="toggleModalAction"></span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <form id="toggleForm" method="POST" style="display: inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i> Confirm
                </button>
            </form>
            <button type="button" class="btn btn-secondary" onclick="closeToggleModal()">
                <i class="fas fa-times"></i> Cancel
            </button>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content confirmation-modal">
        <div class="modal-header">
            <h3>Delete Account</h3>
            <span class="close" onclick="closeDeleteModal()">&times;</span>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this account? This action cannot be undone.</p>
            <div class="account-details">
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value" id="deleteModalEmail"></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Name:</span>
                    <span class="detail-value" id="deleteModalName"></span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
            <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i> Cancel
            </button>
        </div>
    </div>
</div>

<script>
let currentUserId = '';
let currentUserEmail = '';
let currentUserName = '';
let currentToggleAction = '';

function openToggleModal(userId, userEmail, toggleLabel, action) {
    currentUserId = userId;
    currentUserEmail = userEmail;
    currentToggleAction = action;
    
    // Update modal content
    document.getElementById('toggleModalTitle').textContent = toggleLabel + ' Account';
    document.getElementById('toggleModalMessage').textContent = `Are you sure you want to ${action} this account?`;
    document.getElementById('toggleModalEmail').textContent = userEmail;
    document.getElementById('toggleModalAction').textContent = toggleLabel;
    
    // Update form action
    document.getElementById('toggleForm').action = `{{ route('admin.manage.toggle', ':id') }}`.replace(':id', userId);
    
    // Show modal
    document.getElementById('toggleModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeToggleModal() {
    document.getElementById('toggleModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    currentUserId = '';
    currentUserEmail = '';
    currentToggleAction = '';
}

function openDeleteModal(userId, userEmail) {
    currentUserId = userId;
    currentUserEmail = userEmail;
    
    // Update modal content
    document.getElementById('deleteModalEmail').textContent = userEmail;
    
    // Update form action
    document.getElementById('deleteForm').action = `{{ route('admin.manage.destroy', ':id') }}`.replace(':id', userId);
    
    // Show modal
    document.getElementById('deleteModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    currentUserId = '';
    currentUserEmail = '';
}

// Close modals when clicking outside
window.onclick = function(event) {
    const toggleModal = document.getElementById('toggleModal');
    const deleteModal = document.getElementById('deleteModal');
    
    if (event.target === toggleModal) {
        closeToggleModal();
    }
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
}
</script>

@endsection
