@extends('layouts.app')

@section('title', 'Create Assessor Account')

@section('content')
<div class="assessor-form-container">
    <h2 class="form-title">Create Assessor’s Account</h2>

    <form action="#" method="GET">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label for="last_name">Last Name <span class="required">*</span></label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="first_name">First Name <span class="required">*</span></label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="middle_name">Middle Name</label>
                <input type="text" id="middle_name" name="middle_name">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="position">Position <span class="required">*</span></label>
                <input type="text" id="position" name="position" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group full-width">
                <label for="default_password">Default Password</label>
                <input type="text" id="default_password" name="default_password" value="{{ $defaultPassword }}" disabled>
            </div>
        </div>

        <div class="button-group">
            <button type="submit" class="save-btn">Save</button>
            <button type="button" class="cancel-btn" onclick="window.history.back()">Cancel</button>
        </div>
    </form>
</div>
@endsection