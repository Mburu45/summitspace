@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2>Create Event</h2>

    <form action="{{ route('admin.events.store') }}" method="POST">
        @csrf

        @include('admin.events.form')

        <button class="btn btn-success mt-3">Save</button>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
