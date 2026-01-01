@component('mail::message')
# Original Certificate Requested !!

<b>Name : </b> {{ Auth::user()->fname }} {{ Auth::user()->lname }}<br>
<b>Course Name : </b> {{ $course }}<br>
<b>Certificate Price : </b> {{ $data['price'] }}<br>
<b>Payment Status : </b> {{ $order}}






Thanks,<br>
{{ config('app.name') }}
@endcomponent
