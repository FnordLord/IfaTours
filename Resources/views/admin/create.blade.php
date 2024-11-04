@extends('ifatours::layouts.admin')

@section('title', 'Tour Creation')
@section('actions')
@endsection

@section('content')
  <h1>Create Tour</h1>

  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <form action="{{ route('ifatours.admin.tours.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
      <label for="name">Tour Name</label>
      <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
    </div>

    <div class="form-group">
      <label for="teaser_img">Teaser Image</label>
      <input type="file" name="teaser_img" id="teaser_img" class="form-control" accept="image/*">
    </div>

    <div class="form-group">
      <label for="teaser_txt">Teaser Text</label>
      <textarea name="teaser_txt" id="teaser_txt" class="form-control">{{ old('teaser_txt') }}</textarea>
    </div>

    <div class="form-group">
      <label for="tour_description">Description</label>
      <textarea name="description" id="tour_description" class="form-control">{{ old('description') }}</textarea>
    </div>

    <div class="form-group">
      <label for="award_id">Award</label>
      <select name="award_id" id="award_id" class="form-control">
        <option value="">No Award</option>
        @foreach($awards as $award)
          <option value="{{ $award->id }}" {{ $tour->award_id == $award->id ? 'selected' : '' }}>
            {{ $award->name }}
          </option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Create Tour</button>
    <a href="{{ route('ifatours.admin.tours.index') }}" class="btn btn-secondary">Cancel</a>
  </form>

  <script src="{{ asset('vendor/ifatours/tinymce/tinymce.min.js') }}"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      tinymce.init({
        selector: 'textarea#tour_description', // ID des Textareas
        menubar: false,
        plugins: 'lists link image table code',
        toolbar: 'undo redo | styles bold italic | bullist numlist | link image',
        branding: false,
        license_key: 'gpl'
      });
    });
  </script>

@endsection
