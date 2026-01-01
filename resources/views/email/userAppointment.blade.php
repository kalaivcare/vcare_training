@component('mail::message')
# Hi {{ $user->fname }} {{ $user->lname }}!!
<br><br>
{{ $x }}.
<br><br>
<b>Course Name : </b> {{ $maincourse->title }}<br>
<b>Date : </b> {{ $data->date }}<br>




Thanks,<br>
{{ config('app.name') }}
@endcomponent
