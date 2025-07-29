@extends('layouts.app')

@section('title', 'Approval of Accounts')

@section('content')
<div class="approval-container">
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
            @for ($i = 0; $i < 6; $i++)
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="action-buttons">
                    <button class="reject"><i class="fas fa-times"></i></button>
                    <button class="approve"><i class="fas fa-user-check"></i></button>
                </td>
            </tr>
            @endfor
        </tbody>
    </table>
</div>
@endsection
