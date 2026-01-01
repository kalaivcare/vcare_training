@extends('admin.layouts.master')
@section('title', 'Currency - Admin')
@section('body')
 
<section class="content">
   @include('admin.message')
	<div class="row">
        <div class="col-xs-12">
        	<div class="box box-primary">
	           	<div class="box-header with-border">
              	<h3 class="box-title">{{ __('adminstaticword.Currency') }}</h3>
           		</div>
	          	<div class="panel-body">
	          		<form action="{{ url('currency/'.$show->id) }}" method="POST" enctype="multipart/form-data">
		                {{ csrf_field() }}
		                {{ method_field('PUT') }}
		                
		              	<div class="row">
		                  <div class="col-md-4">
		                    <label for="icon">{{ __('adminstaticword.Icon') }}<sup class="redstar">*</sup></label>
		                    <input value="{{ $show['icon'] }}" name="icon" type="text" class="form-control icp-auto icp" placeholder="Select Icon" autocomplete="off"/>

		                  </div>
		              	
		                  <div class="col-md-4">
		                    <label for="currency">{{ __('adminstaticword.Currency') }}<sup class="redstar">*</sup></label>
		                    <input value="{{ $show['currency'] }}" name="currency" type="text" class="form-control" placeholder="Ex:INR" autocomplete="off" />
		                  </div>
		                  
		                   <div class="col-md-4">
		                    <label for="currency">Amount<sup class="redstar">*</sup></label>
		                    <input value="{{ $show['amount'] }}" name="amount" type="text" class="form-control" placeholder="Enter equivalent of INR" autocomplete="off" />
		                  </div>
		                  
		                   
		              	</div>
		              	
		              		<div class="row">
		              	   <div class="col-md-4">
		                    <label for="amount">Country Name<sup class="redstar">*</sup></label>
		                    <input value="{{ $show['country'] }}" name="country" type="text" class="form-control" placeholder="Enter country name" autocomplete="off" />
		                  </div>
		              	    <div class="col-md-4">
		              	         <label for="country">Country Code<sup class="redstar">*</sup></label>
		                         <input value="{{ $show['countrycode'] }}" name="countrycode" type="text" class="form-control" placeholder="Enter country code" autocomplete="off" />
		              	    </div>
		              	</div>
		              	<br>
						<div class="box-footer">
		              		<button value="" type="submit"  class="btn btn-md col-md-1 btn-primary">{{ __('adminstaticword.Save') }}</button>
		              	</div>

		              	

		          	</form>
	          	</div>
	      	</div>
      	</div>
  	</div>
</section>
@endsection


@section('script')

<script>
(function($) {
"use strict";
   $('.icp-auto').iconpicker({

     icons: ['fa fa-inr', 'fa fa-bitcoin', 'fa fa-btc', 'fa fa-cny','fa fa-dollar', 'fa fa-eur','fa fa-gbp', 'fa fa-ngn', 'fa fa-cedi', 'fa fa-rial', 'fa fa-dinar', 'fa fa-tugrik', 'fa fa-brazilian-real'],
     selectedCustomClass: 'label label-success',
     mustAccept: true,
     hideOnSelect: true,
   });
})(jQuery);
</script>

@endsection


