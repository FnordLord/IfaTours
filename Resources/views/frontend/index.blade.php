@extends('app')

@section('title', 'Available Tours')

@section('content')
  @if(isset($user))
    <div class="form-group float-right">
      <a href="{{ route('frontend.flights.bids') }}"
         class="btn btn-outline-primary">{{ trans_choice('flights.mybid', 2) }}</a>
    </div>
  @endif

  <div class="container">
    <h1>Tours & Charters</h1>
    <hr class="mb-5">

    @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <div class="tour-list">
      <div class="row">

        @forelse($tours as $tour)
          <div class="col-12 col-lg-4 mt-4">
            <div class="card h-100">
              @if($tour->teaser_img)
                <img src="{{ asset($tour->teaser_img) }}" alt="{{ $tour->name }} Teaser Image" class="card-img-top">
              @endif
              <div class="card-body">
                @if($tour->completed)
                  <span class="badge badge-success">Completed</span>
                @elseif($tour->in_progress)
                  <span class="badge badge-warning">In Progress</span>
                @else
                  <span class="badge badge-info">Available</span>
                @endif
                <h5 class="card-title"><strong>{{ $tour->name }}</strong></h5>
                <p class="card-text">
                  @if($tour->teaser_txt)
                    {{ $tour->teaser_txt }}
                  @endif
                </p>
                <a href="{{ route('ifatours.tours.show', $tour->id) }}" class="btn btn-primary">Show details</a>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12 col-md-4 col-lg-3">
            <p>No tours available at this time.</p>
          </div>
        @endforelse

      </div>
    </div>
  </div>
@endsection
