@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Edit Event</h2>

    <form action="{{ route('admin.events.update', $event->id) }}" method="POST">
        @csrf
        @method('PUT')

        @include('admin.events.form', ['event' => $event])

        <button class="btn btn-primary mt-3">Update</button>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
