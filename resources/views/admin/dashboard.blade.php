@extends('layouts.app') {{-- or admin layout if we create one later --}}

@section('content')
<div class="dashboard container mt-5">

    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row">
        
        <div class="col-md-4">
            <div class="card text-center p-4 shadow">
                <h3>{{ $totalEvents }}</h3>
                <p>Total Events</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center p-4 shadow">
                <h3>{{ $totalUsers }}</h3>
                <p>Registered Users</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center p-4 shadow">
                <h3>{{ $ticketsSold }}</h3>
                <p>Tickets Sold</p>
            </div>
        </div>

    </div>
</div>
@endsection
