@extends('theme.master')

@section('content')
    <div class="text-center p-5">
        <h2 class="text-danger">404</h2>
        <h3>Oops! Page Not Found</h3>
        <p>The page you are looking for doesn’t exist or has been moved.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Go to Home</a>
    </div>
@endsection
