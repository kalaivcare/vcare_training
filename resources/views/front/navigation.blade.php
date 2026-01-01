@extends('theme.master')
@section('title', "Navigation Guide")
@section('content')



<div class=" text-center pt-5 pb-5" style="background-color: #e3e6eb;">
    <div class="container">
    <div class="text-center">
         <h3 style="color:#6f0f11;padding-top:25px;">NAVIGATION GUIDE</h3>
         
    </div>
    
 {{--<video src="{{ asset('files/guide/navigation.mp4') }}" width="100%" height="100%" controls muted>
 </video>--}}
    <video src="{{ env('AWS_URL').('files/guide/navigation.mp4') }}" width="100%" height="100%" autoplay controls muted>
 </video>
      </div>                
</div>

@endsection