@component('mail::message')
# Assignment !!

<b>Name : </b> {{ Auth::user()->fname }} {{ Auth::user()->lname }}<br>
<b>Course Name : </b> {{ $course->title }}<br>
<b>Assignment : </b>
<a href="{{asset('files/assignment/'.$assignment->assignment)}}" target="" title="Course"><i class="fas fa-file-pdf"></i>&nbsp;Assignment</a>







Thanks,<br>
{{ config('app.name') }}
@endcomponent
