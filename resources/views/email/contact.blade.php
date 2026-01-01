@component('mail::message')
# New User contacted !!

<b>Name : </b> {{ $data['fname'] }} <br>
<b>Email :</b> {{ $data['email'] }} <br>
<b>Phone No. :</b> {{ $data['mobile'] }} <br>
<b>Subject :</b> {{ $data['subject'] }} <br>
<b>Message :</b> {{ $data['message'] }}






@endcomponent
