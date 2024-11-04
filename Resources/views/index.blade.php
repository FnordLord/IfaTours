@extends('ifatours::layouts.frontend')

@section('content')
  <h1>Hello World</h1>

  <p>
    This view is loaded from module: {{ config('ifatours.name') }}
  </p>
@endsection
