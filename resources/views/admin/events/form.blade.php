<div class="row">
    <div class="col-md-6">
        <label>Title</label>
        <input type="text" name="title" class="form-control"
               value="{{ old('title', $event->title ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label>Location</label>
        <input type="text" name="location" class="form-control"
               value="{{ old('location', $event->location ?? '') }}" required>
    </div>

    <div class="col-md-6 mt-2">
        <label>Date</label>
        <input type="date" name="event_date" class="form-control"
               value="{{ old('event_date', $event->event_date ?? '') }}" required>
    </div>

    <div class="col-md-6 mt-2">
        <label>Capacity</label>
        <input type="number" name="capacity" class="form-control"
               value="{{ old('capacity', $event->capacity ?? 0) }}" required>
    </div>

    <div class="col-md-6 mt-2">
        <label>Price</label>
        <input type="number" step="0.01" name="price" class="form-control"
               value="{{ old('price', $event->price ?? 0) }}" required>
    </div>

    <div class="col-md-12 mt-2">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ old('description', $event->description ?? '') }}</textarea>
    </div>
</div>
