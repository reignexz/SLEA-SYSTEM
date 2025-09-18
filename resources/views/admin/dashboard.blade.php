@extends('layouts.app')

@section('title', 'Admin Dashboard - SLEA')

@section('content')
<div class="container">
    @include('partials.sidebar')

    <main class="main-content">
        <div class="page-header">
            <h1>Admin Dashboard</h1>
            <p>Welcome to the Student Leadership and Excellence Awards Admin Panel</p>
        </div>

        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3>25</h3>
                    <p>Total Assessors</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-content">
                    <h3>12</h3>
                    <p>Active Assessors</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-content">
                    <h3>48</h3>
                    <p>Pending Submissions</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="stat-content">
                    <h3>15</h3>
                    <p>Awards Given</p>
                </div>
            </div>
        </div>

        <div class="quick-actions">
            <h2>Quick Actions</h2>
            <div class="action-grid">
                <a href="{{ route('admin.create_assessor') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h3>Create Assessor</h3>
                    <p>Add new assessor accounts</p>
                </a>

                <a href="{{ route('admin.approve-reject') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <h3>Approve Accounts</h3>
                    <p>Review and approve user accounts</p>
                </a>

                <a href="{{ route('admin.manage') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-cog"></i>
                    </div>
                    <h3>Manage Accounts</h3>
                    <p>Manage existing user accounts</p>
                </a>

                <a href="{{ route('admin.rubrics.index') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-list-alt"></i>
                    </div>
                    <h3>Rubric Configuration</h3>
                    <p>Configure scoring rubrics</p>
                </a>
            </div>
        </div>
    </main>
</div>

<style>
.page-header {
    margin-bottom: 2rem;
}

.page-header h1 {
    color: #8B0000;
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    font-weight: 700;
}

.page-header p {
    color: #666;
    font-size: 1.1rem;
}

.dashboard-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.stat-card {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 1.5rem;
    transition: transform 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.stat-icon {
    width: 60px;
    height: 60px;
    background: #8B0000;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.stat-content h3 {
    font-size: 2rem;
    font-weight: 700;
    color: #8B0000;
    margin: 0;
}

.stat-content p {
    color: #666;
    margin: 0.25rem 0 0 0;
    font-size: 0.9rem;
}

.quick-actions h2 {
    color: #8B0000;
    font-size: 1.8rem;
    margin-bottom: 1.5rem;
    font-weight: 600;
}

.action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

.action-card {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-decoration: none;
    color: inherit;
    transition: all 0.2s ease;
    display: block;
}

.action-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    text-decoration: none;
    color: inherit;
}

.action-icon {
    width: 50px;
    height: 50px;
    background: #F9BD3D;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #8B0000;
    font-size: 1.2rem;
    margin-bottom: 1rem;
}

.action-card h3 {
    color: #8B0000;
    font-size: 1.3rem;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.action-card p {
    color: #666;
    margin: 0;
    font-size: 0.9rem;
}

/* Dark mode styles */
body.dark-mode .page-header h1 {
    color: #f9bd3d !important;
}

body.dark-mode .page-header p {
    color: #ccc !important;
}

body.dark-mode .stat-card {
    background: #2a2a2a;
    border: 1px solid #555;
}

body.dark-mode .stat-content h3 {
    color: #f9bd3d !important;
}

body.dark-mode .stat-content p {
    color: #ccc !important;
}

body.dark-mode .quick-actions h2 {
    color: #f9bd3d !important;
}

body.dark-mode .action-card {
    background: #2a2a2a;
    border: 1px solid #555;
}

body.dark-mode .action-card h3 {
    color: #f9bd3d !important;
}

body.dark-mode .action-card p {
    color: #ccc !important;
}
</style>
@endsection


