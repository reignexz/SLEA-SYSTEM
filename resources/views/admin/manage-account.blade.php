@extends('layouts.app')

@section('title', 'Manage Account')

@section('content')
<div class="manage-container">
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
                            $statusText     = $isDisabled ? 'Disabled' : ($user->status ?? 'Active');
                            $toggleLabel    = $isDisabled ? 'Enable' : 'Disable';
                            $confirmToggle  = $toggleLabel.' '.($user->email).' ?';
                            $confirmDelete  = 'Delete '.($user->email).' ? This cannot be undone.';
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
                                <form method="POST"
                                      action="{{ route('admin.manage.toggle', $user) }}"
                                      onsubmit="return confirm('{{ e($confirmToggle) }}');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-disable">{{ $toggleLabel }}</button>
                                </form>

                                <form method="POST"
                                      action="{{ route('admin.manage.destroy', $user) }}"
                                      onsubmit="return confirm('{{ e($confirmDelete) }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">Delete</button>
                                </form>
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
                                <button type="button" class="btn btn-disable" disabled>Disable</button>
                                <button type="button" class="btn btn-delete" disabled>Delete</button>
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
@endsection
