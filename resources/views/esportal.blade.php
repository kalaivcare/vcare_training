@extends('theme.head')

<div class="container mt-5 mb-5">
   

<iframe src="https://portal.earlysalary.com/portal?utm_source=NIHAWS&sourceId=CHECKOUT&mId=3735" 
    height="700px" width="100%" style="border:none;" allow="camera; microphone; geolocation;" title="EMI"></iframe>

    <div class="row">
        <div class="col text-center mt-5">
        <form method="post" action="{{ asset('esstatuscheck') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
          @csrf
            <input type="hidden" value="{{ $esorderid['orderid'] }}" name="orderid">
        <button class="btn btn-primary" type="submit">Finish</button>
        </form>
        </div>
    </div>

</div>



