<aside class="sidebar">
    <div class="menu-profile">
        <div class="menu-toggle"><i class="fas fa-bars"></i></div>
        <div class="profile-icon"></div>
    </div>

    <ul>
        <li class="active"><i class="fas fa-user"></i><span>Profile</span></li>
<li class="has-submenu">
    <i class="fas fa-users-cog"></i><span>User Account Management</span>
    <ul class="submenu">
        <li><a href="{{ route('admin.create_assessor') }}">Create Assessor’s Account</a></li>
        <li><a href="{{ route('admin.approve-reject') }}">Approve/Reject Account</a></li>
        <li><a href="{{ route('admin.manage') }}">Manage Account</a></li>
    </ul>
</li>
        <li><a href="{{ route('admin.rubrics.index') }}" style="display: flex; align-items: center; gap: 10px; color: inherit; text-decoration: none;"><i class="fas fa-tasks"></i><span>Scoring Rubric Configuration</span></a></li>
        <li><a href="{{ route('admin.submission-oversight') }}" style="display: flex; align-items: center; gap: 10px; color: inherit; text-decoration: none;"><i class="fas fa-file-alt"></i><span>Submission Oversight</span></a></li>
        <li><a href="{{ route('admin.final-review') }}" style="display: flex; align-items: center; gap: 10px; color: inherit; text-decoration: none;"><i class="fas fa-clipboard-check"></i><span>Final Review</span></a></li>
        <li><i class="fas fa-server"></i><span>System Monitoring and Logs</span></li>
        <li><i class="fas fa-sign-out-alt"></i><span>Log Out</span></li>
    </ul>

    </div>
</aside>
