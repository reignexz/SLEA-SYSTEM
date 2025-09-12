<aside class="sidebar">
    <div class="menu-profile">
        <div class="menu-toggle"><i class="fas fa-bars"></i></div>
        <div class="profile-icon" id="sidebarProfileIcon" style="background-image: url('https://via.placeholder.com/40x40/667eea/ffffff?text=A'); background-size: cover; background-position: center;">
            <div class="profile-status"></div>
        </div>
    </div>

    <ul>
        <li class="active"><a href="{{ route('admin.profile') }}" style="display: flex; align-items: center; gap: 10px; color: inherit; text-decoration: none;"><i class="fas fa-user"></i><span>Profile</span></a></li>
        
        <li class="has-submenu">
            <i class="fas fa-users-cog"></i><span>User Account Management</span>
            <ul class="submenu">
                <li><a href="{{ route('admin.create_assessor') }}">Create Assessor's Account</a></li>
                <li><a href="{{ route('admin.approve-reject') }}">Approve/Reject Account</a></li>
                <li><a href="{{ route('admin.manage') }}">Manage Account</a></li>
            </ul>
        </li>
        
        <li><a href="{{ route('admin.rubrics.index') }}" style="display: flex; align-items: center; gap: 10px; color: inherit; text-decoration: none;"><i class="fas fa-tasks"></i><span>Scoring Rubric Configuration</span></a></li>
        
        <li><a href="{{ route('admin.submission-oversight') }}" style="display: flex; align-items: center; gap: 10px; color: inherit; text-decoration: none;"><i class="fas fa-file-alt"></i><span>Submission Oversight</span></a></li>
        
        <li><a href="{{ route('admin.final-review') }}" style="display: flex; align-items: center; gap: 10px; color: inherit; text-decoration: none;"><i class="fas fa-clipboard-check"></i><span>Final Review</span></a></li>
        
        <li><a href="{{ route('admin.award-report') }}" style="display: flex; align-items: center; gap: 10px; color: inherit; text-decoration: none;"><i class="fas fa-trophy"></i><span>Award Report</span></a></li>
        
        <li><a href="{{ route('admin.system-monitoring') }}" style="display: flex; align-items: center; gap: 10px; color: inherit; text-decoration: none;"><i class="fas fa-server"></i><span>System Monitoring and Logs</span></a></li>
        
        <li><a href="#" onclick="logout()" style="display: flex; align-items: center; gap: 10px; color: inherit; text-decoration: none;"><i class="fas fa-sign-out-alt"></i><span>Log Out</span></a></li>
    </ul>
</aside>

<script>
function logout() {
    if (confirm('Are you sure you want to log out?')) {
        // Add logout functionality here
        window.location.href = '/logout';
    }
}
</script>
