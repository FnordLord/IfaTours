@extends('app')

@section('title', $tour->name)

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1>{{ $tour->name }}</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-lg-6 mt-4 mt-lg-0">
        @if($tour->teaser_img)
          <img src="{{ asset($tour->teaser_img) }}" alt="{{ $tour->name }} Teaser Image" class="img-fluid">
        @endif
      </div>
      <div class="col-12 col-lg-6 mt-4 mt-lg-0">
        <div id="map" class="w-100 d-block h-100 embed-responsive-1by1" style="min-height: 300px;"></div>
      </div>

      <div class="col-12">
        <p>{!! $tour->description !!}</p>
        <p>
          @if($tour->completed)
            <span class="badge badge-success">Completed</span> You have already completed this tour and aquired an award. But you can of course fly the tour again.
          @elseif($tour->in_progress)
            <span class="badge badge-warning">In Progress</span> You have completed one or more legs of this tour already. Keep going to receive your award!
          @else
            <span class="badge badge-info">Available</span> After completion of the tour you will automatically received an award.
          @endif
        </p>
        <h2>Tour legs</h2>

        @if($tour->legs->isNotEmpty())
          <ul class="list-group">
            @foreach($tour->legs as $leg)
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                  <strong>Flight No.</strong> {{ $leg->flight->flight_number ?? 'N/A' }}, Leg {{ $leg->order }} /
                  <strong>Route:</strong> {{ $leg->flight->location ?? 'N/A' }} {{ $leg->flight->dpt_airport_id ?? 'N/A' }}
                  to {{ $leg->flight->arr_airport_id ?? 'N/A' }} /
                  <strong>Distance:</strong> {{ $leg->flight->distance ?? 'N/A' }} nm /
                  <strong>Duration:</strong> {{ $leg->flight->flight_time ?? 'N/A' }} min
                </div>
                <div>
                  @if(in_array($leg->flight_id, $completedFlightIds))
                    <span class="badge badge-success">Completed</span>
                  @endif
                  @if(isset($user) && (!setting('pilots.only_flights_from_current') || $leg->flight->dpt_airport_id == $user->current_airport->icao))
                    <button class="btn save_flight {{ in_array($leg->flight->id, $saved) ? 'btn-info' : '' }}"
                            x-id="{{ $leg->flight->id }}"
                            x-saved-class="btn-info"
                            type="button"
                            title="{{ in_array($leg->flight->id, $saved) ? 'Remove bid' : 'Add bid' }}">
                      {{ in_array($leg->flight->id, $saved) ? 'Remove bid' : 'Add bid' }}
                    </button>
                  @endif
                </div>
              </li>
            @endforeach
          </ul>
        @else
          <p>No legs available.</p>
        @endif
      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const map = L.map('map').setView([0, 0], 2);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: 'Map data &copy; OpenStreetMap contributors'
      }).addTo(map);

      const routeCoords = [];
      const legs = [
          @foreach($tour->legs as $leg)
          @if($leg->flight->dpt_airport && $leg->flight->arr_airport)
        {
          dptCoords: [{{ $leg->flight->dpt_airport->lat }}, {{ $leg->flight->dpt_airport->lon }}],
          arrCoords: [{{ $leg->flight->arr_airport->lat }}, {{ $leg->flight->arr_airport->lon }}],
          dptName: "{{ $leg->flight->dpt_airport->name }}",
          dptIcao: "{{ $leg->flight->dpt_airport->icao }}",
          arrName: "{{ $leg->flight->arr_airport->name }}",
          arrIcao: "{{ $leg->flight->arr_airport->icao }}"
        },
        @endif
        @endforeach
      ];

      legs.forEach((leg) => {
        const {dptCoords, arrCoords, dptName, dptIcao, arrName, arrIcao} = leg;

        routeCoords.push(dptCoords, arrCoords);

        L.marker(dptCoords).addTo(map).bindPopup(`${dptName} (${dptIcao})`);
        L.marker(arrCoords).addTo(map).bindPopup(`${arrName} (${arrIcao})`);

        L.polyline([dptCoords, arrCoords], {color: 'blue'}).addTo(map);
      });

      if (routeCoords.length > 0) {
        const bounds = L.latLngBounds(routeCoords);
        map.fitBounds(bounds);
      }
    });
  </script>

  </div>

  @if (setting('bids.block_aircraft', false))
    @include('flights.bids_aircraft')
  @endif
@endsection
@include('flights.scripts')
