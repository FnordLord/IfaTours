@extends('ifatours::layouts.admin')

@section('title', 'Edit Tour')
@section('actions')
@endsection

@section('content')
  <h1>Edit Tour</h1>

  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <form action="{{ route('ifatours.admin.tours.update', $tour->id) }}" enctype="multipart/form-data" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
      <label for="name">Tour Name</label>
      <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $tour->name) }}" required>
    </div>

    <div class="form-group">
      <label for="teaser_img">Teaser Image</label>
      <input type="file" name="teaser_img" id="teaser_img" class="form-control" accept="image/*">
      @if(isset($fileName))
        <p>Current Image: {{ $fileName }}</p>
        <img src="{{ asset($tour->teaser_img) }}" alt="Current Teaser Image" class="img-fluid" style="max-width: 200px;">
      @endif
    </div>

    <div class="form-group">
      <label for="teaser_txt">Teaser Text</label>
      <textarea name="teaser_txt" id="teaser_txt" class="form-control">{{ old('teaser_txt', $tour->teaser_txt) }}</textarea>
    </div>

    <div class="form-group">
      <label for="tour_description">Tour Description</label>
      <textarea id="tour_description" name="description" class="form-control">{{ old('description', $tour->description ?? '') }}</textarea>
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

    <button type="submit" class="btn btn-success">Save changes</button>
    <a href="{{ route('ifatours.admin.tours.index') }}" class="btn btn-secondary">Cancel</a>
  </form>

  <script src="{{ asset('vendor/ifatours/tinymce/tinymce.min.js') }}"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      tinymce.init({
        selector: 'textarea#tour_description',
        menubar: false,
        plugins: 'lists link image table code',
        toolbar: 'undo redo | styles bold italic | bullist numlist | link image',
        branding: false,
        license_key: 'gpl'
      });
    });
  </script>

@endsection
