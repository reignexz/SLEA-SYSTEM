<aside class="sidebar">
    <div class="menu-profile">
        <div class="menu-toggle"><i class="fas fa-bars"></i></div>
        <div class="profile-icon" id="sidebarProfileIcon" style="background-image: url('https://via.placeholder.com/40x40/667eea/ffffff?text=A'); background-size: cover; background-position: center;">
            <div class="profile-status"></div>
        </div>
    </div>

    <ul>
        <li class="{{ request()->routeIs('assessor.profile') ? 'active' : '' }}">
            <a href="{{ route('assessor.profile') }}" style="display: flex; align-items: center; gap: 10px; color: inherit; text-decoration: none;">
                <i class="fas fa-user"></i><span>Profile</span>
            </a>
        </li>
        
        <li class="{{ request()->routeIs('assessor.pending-submissions') ? 'active' : '' }}">
            <a href="{{ route('assessor.pending-submissions') }}" style="display: flex; align-items: center; gap: 10px; color: inherit; text-decoration: none;">
                <i class="fas fa-clock"></i><span>Pending Submissions</span>
            </a>
        </li>
        
        <li class="{{ request()->routeIs('assessor.submissions') ? 'active' : '' }}">
            <a href="{{ route('assessor.submissions') }}" style="display: flex; align-items: center; gap: 10px; color: inherit; text-decoration: none;">
                <i class="fas fa-file-alt"></i><span>Submissions</span>
            </a>
        </li>
        
        <li class="{{ request()->routeIs('assessor.final-review') ? 'active' : '' }}">
            <a href="{{ route('assessor.final-review') }}" style="display: flex; align-items: center; gap: 10px; color: inherit; text-decoration: none;">
                <i class="fas fa-clipboard-check"></i><span>Final Review</span>
            </a>
        </li>
    </ul>
</aside>
