@extends('ifatours::layouts.admin')

@section('title', 'IFA Tours')

@section('actions')
  <li>
    <a href="{{ url('/admin/ifatours/create') }}">
      <i class="ti-plus"></i>
      Add New Tour</a>
  </li>
@endsection

@section('content')
  @section('content')
    @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <h1>Tour Management</h1>

        <table class="table">
          <thead>
          <tr>
            <th>Name</th>
            <th>Actions</th>
          </tr>
          </thead>
          <tbody>
          @forelse($tours as $tour)
            <tr>
              <td>{{ $tour->name }}</td>
              <td>
                <a href="{{ route('ifatours.admin.tours.edit', $tour->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <a href="{{ route('ifatours.admin.tours.legs.index', $tour->id) }}" class="btn btn-info btn-sm">Legs</a>

                <form action="{{ route('ifatours.admin.tours.destroy', $tour->id) }}" method="POST"
                      style="display:inline-block;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm"
                          onclick="return confirm('Are you sure you want to delete this tour?')">Delete
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center">No tours available</td>
            </tr>
          @endforelse
          </tbody>
        </table>
  @endsection
@endsection
