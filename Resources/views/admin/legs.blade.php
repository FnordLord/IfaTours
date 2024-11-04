@extends('ifatours::layouts.admin')

@section('title', 'Edit Tour Legs')

@section('content')
  <h1>Edit legs for tour "{{ $tour->name }}"</h1>

  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <h2>Current legs</h2>
  <table class="table">
    <thead>
    <tr>
      <th>Leg No.</th>
      <th>Flight</th>
      <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @forelse($legs as $leg)
      <tr>
        <td>{{ $leg->order }}</td>
        <td>{{ $leg->flight->flight_number }} / {{ $leg->flight->dpt_airport_id }} -> {{ $leg->flight->arr_airport_id }}</td>
        <td>
          <form action="{{ route('ifatours.admin.tours.legs.destroy', ['tour' => $tour->id, 'leg' => $leg->id]) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you really want to delete this leg?')">Delete</button>
          </form>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="3" class="text-center">No legs available.</td>
      </tr>
    @endforelse
    </tbody>
  </table>

  <h2>Add new leg</h2>
  <form action="{{ route('ifatours.admin.tours.legs.store', $tour->id) }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="flight_id">Search Flight</label>
      <select name="flight_id" id="flight_id" class="form-control select2" required>
        <option value="">Select flight</option>
        @foreach($flights as $flight)
          <option value="{{ $flight->id }}">
            No. {{ $flight->flight_number }} - Leg {{ $flight->route_leg }} / {{ $flight->dpt_airport_id }} -> {{ $flight->arr_airport_id }}
          </option>
        @endforeach
      </select>
    </div>

    <script>
      $(document).ready(function() {
        $('#flight_id').select2({
          placeholder: 'Type to search for flights...',
          allowClear: true
        });
      });
    </script>

    <div class="form-group">
      <label for="order">Order</label>
      <input type="number" name="order" id="order" class="form-control" placeholder="Reihenfolge festlegen">
    </div>

    <button type="submit" class="btn btn-primary">Save leg</button>
  </form>

  <a href="{{ route('ifatours.admin.tours.index') }}" class="btn btn-secondary mt-3">Back to tours overview</a>
@endsection
