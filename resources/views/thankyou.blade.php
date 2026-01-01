@extends('theme.master')
@section('title', 'Thank you')
@section('content')

@php
 $or = session('details');
 $gen_thank = App\Order::where('id',$or[0])->first();

$total_amount = 0;
$rate=0;
$gst=0;
 
@endphp

<div class="thankyou-block">
    

    
<div class="success_thankyou" style="  background-color:white;
    border-radius:50px;
    width:45px;
    height:45px;
    margin:auto auto 50px;">
    <i class="fa fa-check thank_icon" style=" color:#309f52;
    font-size:40px !important;
    font-weight:bold !important;"></i>
</div> 



<h1> Thank you for purchasing </h1>
<h1>our course</h1>

<div class="container ">
<table class="table table-bordered text-white" style="margin:30px auto; width:80% !important;">

    <tbody>
    <tr>
        <th>Order placed on </th>
        <td>{{ $gen_thank['updated_at']}}</td>
    </tr>
    <tr style="color:#e8ed9b;">
             <th>Order ID  </th>
             <th>Course Details </th>
        </tr>
        @foreach($or as $thank)
        @php
            $gen = App\Order::where('id',$thank)->first();
            $total_amount =$total_amount+$gen['total_amount'];
           $rate +=  $gen['total_amount']/1.18 ;
           $gst =  $total_amount - $rate;
          
           
        @endphp
        
      
        <tr>
            
            <td>{{ $gen['id']}}</td>
            <td class="text-right">
                <table class="text-left  table table-striped">
                    <thead>
                        <tr>
                            <th>Course name</th>                            
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                                    
                      <tr>
                        @if($gen['course_id'] != Null)
                          <td> {{ $gen->courses['title']}}</td>
                        @elseif($gen['workshop_id'] != null)
                           <td> {{ $gen->workshops['title']}}</td>
                        @else
                          <td> {{ $gen->bundle['title']}}</td>
                        @endif
                       
                        <td><i class="fa {{ $gen['currency_icon'] }}"></i> {{  number_format($gen['total_amount'],2) }}</td>
                      </tr>
                        
                    </tbody>
                </table>
               
               
           </td>
                
            
        </tr>
        @endforeach
        @if($gen['currency_icon'] == 'fa fa-inr')
        <tr>
            <th>Price Breakup</th>
            <td> 
                
                      Subtotal : <i class="fa {{ $gen['currency_icon'] }}"></i> {{ number_format($rate,2) }} <br>
                      GST (18%) : <i class="fa {{ $gen['currency_icon'] }}"></i> {{ number_format($gst,2)}} <br>
                
                      Total : <i class="fa {{ $gen['currency_icon'] }}"></i> {{  number_format($total_amount,2) }} <br>
        	</td>
       </tr>
      @endif
        <tr>
            <th>Total amount paid for the course</th>
            <td><i class="fa {{ $gen['currency_icon'] }}"></i> {{ number_format($total_amount,2) }}</td>
        </tr>
       
    </tbody>
</table>
</div>





<h3>Happy Learning !</h3>

<p>If you have any queries, contact us at <a href="mailto:info@nihaws.com">info@nihaws.com</a></p>

</div>

@endsection



<script>


  gtag('event', 'conversion', {
      'send_to': 'AW-10784575539/DRGMCKWprvoCELOgvpYo',
      'value': '{{ $gen['total_amount'] }}',
      'currency': 'INR',
      'transaction_id': '{{ $gen['transaction_id'] }}'
  });

</script>



