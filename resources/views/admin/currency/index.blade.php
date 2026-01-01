@extends('admin/layouts.master')
@section('title', 'View Currency - Admin')
@section('body')

<section class="content">
  @include('admin.message')
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">{{ __('adminstaticword.Currency') }}</h3>
          <a data-toggle="modal" data-target="#myModaljjh" href="#" class="btn btn-info btn-sm">+ {{ __('adminstaticword.Add') }}</a>
        </div>
        <div class="box-body">
         
          <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>{{ __('adminstaticword.Icon') }}</th>
                  <th>{{ __('adminstaticword.Currency') }}</th>
                  <th>Equivalent</th>
                  <th>Country name</th>
                  <th>Country code</th>
                  <th>{{ __('adminstaticword.Edit') }}</th>
                  <th>{{ __('adminstaticword.Delete') }}</th>
                </tr>
                </thead>

                <tbody>
                  <?php $i=0;?>
                  @foreach($money as $curr) 
                    <?php $i++;?>
                    <tr>
                    <td><?php echo $i;?></td>
                      <td>{{$curr['icon']}}</td>
                      <td>{{ $curr['currency']}}</td>      
                      <td>{{ $curr['amount'] }}</td>
                      <td>{{ $curr['country'] }}</td>
                      <td>{{ $curr['countrycode'] }}</td>
                      <td><a class="btn btn-success btn-sm" href="{{url('currency/'.$curr->id.'/edit')}}">
                          <i class="glyphicon glyphicon-pencil"></i></a></td>

                      <td><form method="post" action="{{url('currency/'.$curr->id)}}
                            "data-parsley-validate class="form-horizontal form-label-left">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button  type="submit" class="btn btn-danger"><i class="fa fa-fw fa-trash-o"></i></button>
                          </form>
                      </td>

                    </tr>
                  @endforeach
                </tbody>
            </table>
          </div>
        </div>
        <!--Panel Body end-->
      </div>
      <!--Box Primary end-->

      <!--Model start-->
      <div class="modal fade" id="myModaljjh" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">{{ __('adminstaticword.Add') }} {{ __('adminstaticword.Currency') }}</h4>
            </div>
            <div class="box">
              <div class="panel panel-sum">
                <div class="modal-body">
                  <form id="demo-form2" method="post" action="{{ route('currency.store') }}" data-parsley-validate class="form-horizontal form-label-left">
                    {{ csrf_field() }}
                            
                    <div class="row">
        <div class="col-xs-12">
        	<div class="">
	           	
	          	        
		              	<div class="row">
		                  <div class="col-md-4">
		                    <label for="icon">{{ __('adminstaticword.Icon') }}<sup class="redstar">*</sup></label>
		                    <input value="" name="icon" type="text" class="form-control icp-auto icp" placeholder="Select Icon" autocomplete="off"/>

		                  </div>
		              	
		                  <div class="col-md-4">
		                    <label for="currency">{{ __('adminstaticword.Currency') }}<sup class="redstar">*</sup></label>
		                    <input value="" name="currency" type="text" class="form-control" placeholder="Ex:INR" autocomplete="off" />
		                  </div>
		                  
		                   <div class="col-md-4">
		                    <label for="amount">Exchange amount<sup class="redstar">*</sup></label>
		                    <input value="" name="amount" type="text" class="form-control" placeholder="Enter equivalent of INR" autocomplete="off" />
		                  </div>
		                  
		                  
		              	</div>
		              	<div class="row">
		              	     <div class="col-md-4">
		                    <label for="country">Country Name<sup class="redstar">*</sup></label>
		                    <input value="" name="country" type="text" class="form-control" placeholder="Enter country name" autocomplete="off" />
		                  </div>
		              	    <div class="col-md-4">
		              	         <label for="country">Country Code<sup class="redstar">*</sup></label>
		                         <input value="" name="countrycode" type="text" class="form-control" placeholder="Enter country code" autocomplete="off" />
		              	    </div>
		              	</div>
		              	<br>
						

		          
	      	</div>
      	</div>
  	</div>
                    <br>
                    <div class="box-footer">
                     <button type="submit" class="btn btn-lg col-md-3 btn-primary">{{ __('adminstaticword.Submit') }}</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div> 
      </div>
      <!--Model close -->
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

