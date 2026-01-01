@extends("admin/layouts.master")
@section('title','Add New Coupon')

@section('body')

<section class="content">
  <div class="row">
    <div class="col-md-8">
    <div class="box box-primary">
    
    <div class="box-header with-border">
      <div class="box-title">
            {{ __('adminstaticword.Add') }} {{ __('adminstaticword.Coupon') }}
      </div>
    </div>
    <form action="{{ route('coupon.store') }}" method="POST">
    @csrf
      <div class="box-body">
           
          <div class="form-group">
            <label>{{ __('adminstaticword.CouponCode') }}: <span class="redstar">*</span></label>
            <input required="" type="text" class="form-control" name="code">
          </div>
          <div class="form-group">
            <label>{{ __('adminstaticword.DiscountType') }}: <span class="redstar">*</span></label>
            
              <select required="" name="distype" id="distype" class="form-control">
                
                <option value="fix">{{ __('adminstaticword.FixAmount') }}</option>
                <option value="per">% {{ __('adminstaticword.Percentage') }}</option>
                
              </select>
            
          </div>
          <div class="form-group">
              <label>{{ __('adminstaticword.Amount') }}: <span class="redstar">*</span></label>
              <input required="" type="text"  class="form-control" name="amount">
            
          </div>
          <div class="form-group">
            <label>{{ __('adminstaticword.Linkedto') }}: <span class="redstar">*</span></label>
            
              <select required="" name="link_by" id="link_by" class="form-control js-example-basic-single">
                <option value="none" selected disabled hidden> 
                   {{ __('adminstaticword.SelectanOption') }}
                </option>
                <option value="course">{{ __('adminstaticword.LinktoCourse') }}</option>
                <option value="cart">{{ __('adminstaticword.LinktoCart') }}</option>
                <option value="category">{{ __('adminstaticword.LinktoCategory') }}</option>
                <option value="workshop">Link to Workshop</option>
                <option value="user">Link to User</option>
              </select>
            
          </div>

          
          <div id="probox" class="form-group display-none">
            <label>{{ __('adminstaticword.SelectCourse') }}: <span class="redstar">*</span> </label>
            <br>
            <select style="width: 100%" id="pro_id" name="course_id" class="js-example-basic-single form-control">
                <option value="none" selected disabled hidden> 
                   {{ __('adminstaticword.SelectanOption') }}
                </option>
                @foreach(App\Course::where('status','1')->get() as $product)
                  @if($product->type == 1)
                    <option value="{{ $product->id }}">{{ $product['title'] }}</option>
                  @endif
                @endforeach
            </select>
          </div>
          
           <div id="workbox" class="form-group display-none">
            <label>Select Workshop : <span class="redstar">*</span> </label>
            <br>
            <select style="width: 100%" id="work_id" name="workshop_id" class="js-example-basic-single form-control">
                <option value="none" selected disabled hidden> 
                   {{ __('adminstaticword.SelectanOption') }}
                </option>
                @foreach(App\Workshop::where('status','1')->get() as $product)
                  @if($product->type == 1)
                    <option value="{{ $product->id }}">{{ $product['title'] }}</option>
                  @endif
                @endforeach
            </select>
          </div>
          
           <div id="userbox" class="form-group display-none">
            <label>Select User : <span class="redstar">*</span> </label>
            <br>
            <select style="width: 100%" id="user_id" name="user_id" class="js-example-basic-single form-control">
                <option value="none" selected disabled hidden> 
                   {{ __('adminstaticword.SelectanOption') }}
                </option>
                @foreach(App\User::where('role','user')->get() as $product)
                    <option value="{{ $product->id }}">{{ $product['fname'] }}{{ $product['lname'] }}</option>
                @endforeach
            </select>
          </div>
       

          <div id="catbox" class="form-group display-none">
            <label>{{ __('adminstaticword.SelectCategories') }}: <span class="required">*</span> </label>
            <br>
            <select style="width: 100%" id="cat_id" name="category_id" class="js-example-basic-single form-control">
                <option value="none" selected disabled hidden> 
                   {{ __('adminstaticword.SelectanOption') }}
                </option>
                @foreach(App\Categories::where('status','1')->get() as $category)
                  <option value="{{ $category->id }}">{{ $category['title'] }}</option>
                @endforeach
            </select>
          </div>

          <div class="form-group">
            <label>{{ __('adminstaticword.MaxUsageLimit') }}: <span class="redstar">*</span></label>
            <input required="" type="number" min="1" class="form-control" name="maxusage">
          </div>
          <div id="minAmount" class="form-group">
            <label>{{ __('adminstaticword.MinAmount') }}: </label>
            <div class="input-group">
              @php 
                $currency = App\Currency::first();
              @endphp
              <span class="input-group-addon"><i class="{{ $currency->icon }}"></i></span>
              <input type="number" min="0.0" value="0.00" step="0.1" class="form-control" name="minamount">
            </div>
          </div>
           <div class="form-group">
            <label>{{ __('adminstaticword.ExpiryDate') }}: </label>
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input required="" id="expirydate" type="text" class="form-control" name="expirydate">
            </div>
          </div>
      </div>

    <div class="box-footer">
      <button type="submit" class="btn btn-md btn-primary">
        <i class="fa fa-plus-circle"></i> {{ __('adminstaticword.Save') }}
      </button>
    </form>
      <a href="{{ route('coupon.index') }}" title="Cancel and go back" class="btn btn-md btn-default btn-flat">
        <i class="fa fa-reply"></i> {{ __('adminstaticword.Back') }}
      </a>
    </div>
    </div>       
  </div>
</section>

@endsection

@section('scripts')
<script>
  (function($) {
  "use strict";
    
      $('#link_by').on('change',function(){
        var opt = $(this).val();
       
        if(opt == 'course'){
          $('#minAmount').hide();
          $('#probox').show();
          $('#minAmount').hide();
          $('#pro_id').attr('required','required');
        }else{
          $('#minAmount').show();
          $('#probox').hide();
          $('#pro_id').removeAttr('required');
        }
    });
    
      $('#link_by').on('change',function(){
        var opt = $(this).val();
       
        if(opt == 'workshop'){
          $('#minAmount').hide();
          $('#workbox').show();
          $('#minAmount').hide();
          $('#work_id').attr('required','required');
        }else{
          $('#minAmount').show();
          $('#workbox').hide();
          $('#work_id').removeAttr('required');
        }
    });
    
      $('#link_by').on('change',function(){
        var opt = $(this).val();
       
        if(opt == 'user'){
          $('#minAmount').hide();
          $('#userbox').show();
          $('#minAmount').hide();
          $('#user_id').attr('required','required');
        }else{
          $('#minAmount').show();
          $('#userbox').hide();
          $('#user_id').removeAttr('required');
        }
    });

      $('#link_by').on('change',function(){
        var opt = $(this).val();
       
        if(opt == 'category'){
          $('#catbox').show();
          $('#pro_id').attr('required','required');
        }else{
          $('#catbox').hide();
          $('#pro_id').removeAttr('required');
        }
    });

      $( function() {
        $( "#expirydate" ).datepicker({
          dateFormat : 'yy-m-d'
        });
      });

  })(jQuery);
    
</script>
 
@endsection
