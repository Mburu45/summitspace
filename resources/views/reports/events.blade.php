@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-2">Events Report</h1>
            <p class="text-muted">Event creation and booking statistics</p>
        </div>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">Back to Reports</a>
    </div>

    <!-- Date Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Generate Report</button>
                    <a href="{{ route('reports.events') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="text-primary">{{ $totalEvents }}</h2>
                    <p class="text-muted mb-0">Total Events Created</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="text-success">{{ $totalBookings }}</h2>
                    <p class="text-muted mb-0">Total Bookings</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="text-warning">KSH {{ number_format($totalRevenue, 0) }}</h2>
                    <p class="text-muted mb-0">Total Revenue</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Events Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Events Details</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Event Title</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Capacity</th>
                            <th>Price</th>
                            <th>Bookings</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                        <tr>
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->location }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->event_date)->format('M j, Y') }}</td>
                            <td>{{ $event->capacity }}</td>
                            <td>KSH {{ number_format($event->price, 0) }}</td>
                            <td>{{ $event->bookings_count }}</td>
                            <td>KSH {{ number_format($event->bookings_count * $event->price, 0) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No events found for the selected period.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Export Options -->
    <div class="mt-4 text-center">
        <button class="btn btn-outline-primary me-2" onclick="window.print()">
            <i class="fas fa-print"></i> Print Report
        </button>
        <button class="btn btn-outline-success" onclick="exportToCSV()">
            <i class="fas fa-download"></i> Export CSV
        </button>
    </div>
</div>

<script>
function exportToCSV() {
    const table = document.querySelector('table');
    let csv = [];

    // Get headers
    const headers = [];
    table.querySelectorAll('thead th').forEach(th => {
        headers.push(th.textContent);
    });
    csv.push(headers.join(','));

    // Get rows
    table.querySelectorAll('tbody tr').forEach(tr => {
        const row = [];
        tr.querySelectorAll('td').forEach(td => {
            row.push('"' + td.textContent.replace(/"/g, '""') + '"');
        });
        csv.push(row.join(','));
    });

    // Download
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'events-report-{{ $startDate }}-to-{{ $endDate }}.csv';
    a.click();
    window.URL.revokeObjectURL(url);
}
</script>
@endsection