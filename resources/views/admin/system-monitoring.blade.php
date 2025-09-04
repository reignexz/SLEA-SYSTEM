@extends('layouts.app')

@section('title', 'System Monitoring and Logs')

@section('content')
<div class="page-with-back-button">
    <div class="page-content">
        <div class="rubric-header-nav">
            <a href="{{ route('admin.profile') }}" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <h2 class="manage-title">System Monitoring and Logs</h2>

        <div class="filter-section" style="margin-top:10px;">
            <form method="GET" action="#">
                <div class="filter-row">
                    <div class="filter-item">
                        <label for="level">Log Level</label>
                        <select id="level" class="filter-select">
                            <option value="">All</option>
                            <option>INFO</option>
                            <option>WARNING</option>
                            <option>ERROR</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <label for="date">Date</label>
                        <select id="date" class="filter-select">
                            <option value="">Any</option>
                            <option>Today</option>
                            <option>Last 7 days</option>
                            <option>Last 30 days</option>
                        </select>
                    </div>
                    <div class="filter-actions">
                        <button type="submit" class="btn-filter"><i class="fas fa-search"></i> Filter</button>
                        <a href="{{ route('admin.system-monitoring') }}" class="btn-clear"><i class="fas fa-times"></i> Clear</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-wrap">
            <table class="award-table">
                <thead>
                    <tr>
                        <th class="col-date">Timestamp</th>
                        <th class="col-status">Level</th>
                        <th class="col-name">Message</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2025-09-03 14:55:12</td>
                        <td><span class="badge badge--blue">INFO</span></td>
                        <td>Queue worker started.</td>
                    </tr>
                    <tr>
                        <td>2025-09-03 14:56:44</td>
                        <td><span class="badge badge--yellow">WARNING</span></td>
                        <td>High memory usage detected.</td>
                    </tr>
                    <tr>
                        <td>2025-09-03 14:57:05</td>
                        <td><span class="badge badge--green">ERROR</span></td>
                        <td>Failed job retry exceeded.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="action-section">
            <button type="button" class="btn-export-pdf" onclick="exportLogs()">
                <i class="fas fa-file-download"></i> Export Logs
            </button>
        </div>
    </div>
</div>

<script>
function exportLogs(){
    alert('Export logs functionality will be implemented.');
}
</script>
@endsection


