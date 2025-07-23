@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    @include('partials.sidebar')

    <main class="main-content">
        <div class="avatar-container">
            <img src="https://via.placeholder.com/120" class="avatar" id="avatarPreview">
            <button class="edit-icon" onclick="document.getElementById('avatarUpload').click()">
                <i class="fas fa-pencil-alt"></i>
            </button>
            <input type="file" id="avatarUpload" accept="image/*" style="display:none;" onchange="previewAvatar(event)">
        </div>

        <section class="profile-section">
            <div class="profile-info">
                <h3>Personal Information</h3>
                <p><strong>Name:</strong> <span id="user-name">MANOCAY, Edryan S.</span></p>
                <p><strong>Contact Number:</strong> <span id="user-phone">09991752790</span></p>
                <p><strong>Admin ID:</strong> <span id="user-admin-id">2022-00216</span></p>
                <p><strong>Email Address:</strong> <span id="user-email">esmanocay00216@usep.edu.ph</span></p>
                <p><strong>Position:</strong> <span id="user-position">OSAS Staff 1</span></p>
            </div>

            <div class="change-password">
                <h3>Change Password</h3>
                <input type="password" placeholder="Present Password" />
                <div class="requirements">
                    <p>A new password must contain the following:</p>
                    <ul id="passwordChecklist">
                        <li id="length" class="invalid">Minimum of 8 characters</li>
                        <li id="uppercase" class="invalid">An uppercase character</li>
                        <li id="lowercase" class="invalid">A lowercase character</li>
                        <li id="number" class="invalid">A number</li>
                        <li id="special" class="invalid">A special character</li>
                    </ul>
                </div>
                <input type="password" placeholder="New Password" id="newPassword" onkeyup="validatePassword()">
                <input type="password" placeholder="Confirm Password" id="confirmPassword">
                <label>
                    <input type="checkbox" onclick="togglePassword()"> Show Password
                </label>
                <button class="change-btn">Change Password</button>
            </div>
        </section>
    </main>
</div>
@endsection
