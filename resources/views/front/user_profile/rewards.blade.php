@extends('theme.master')
@section('title', 'Rewards & Setting')
@section('content')

@include('admin.message')


<section id="blog-home" class="blog-home-main-block">
    <div class="container">
        <h1 class="blog-home-heading text-white">Rewards</h1>
    </div>
</section> 

<section id="profile-item" class="profile-item-block">
    <div class="container">
    
	        <div class="row">
	            <div class="col-xl-3 col-lg-4">
	                <div class="dashboard-author-block text-center">
	                    <div class="author-image">
						    <div class="avatar-upload">
						        <div class="avatar-edit">
						            <input type='file' id="imageUpload" name="user_img" accept=".png, .jpg, .jpeg" />
						            <label for="imageUpload"><i class="fa fa-pencil"></i></label>
						        </div>
						        <div class="avatar-preview">
						        	@if(Auth::User()->user_img != null || Auth::User()->user_img !='')
							            <div class="avatar-preview-img" id="imagePreview" style="background-image: url({{ url('/images/user_img/'.Auth::User()->user_img) }});">
							            </div>
							        @else
							        	<div class="avatar-preview-img" id="imagePreview" style="background-image: url({{ asset('images/default/user.jpg')}});">
							            </div>
							        @endif
						        </div>
						    </div>
	                    </div>
	                    <div class="author-name">{{ Auth::User()->fname }}&nbsp;{{ Auth::User()->lname }}</div>
	                </div>
	                <div class="dashboard-items">
	                    <ul>
	                        <li><i class="fa fa-bookmark"></i><a href="{{ route('mycourse.show') }}" title="Dashboard">{{ __('frontstaticword.MyCourses') }}</a></li>
	                        <li><i class="fa fa-heart"></i><a href="{{ route('wishlist.show') }}" title="Profile Update">{{ __('frontstaticword.MyWishlist') }}</a></li>
	                        <li><i class="fa fa-history"></i><a href="{{ route('purchase.show') }}" title="Followers">{{ __('frontstaticword.PurchaseHistory') }}</a></li>
	                        <li><i class="fa fa-user"></i><a href="{{route('profile.show',Auth::User()->id)}}" title="Upload Items">{{ __('frontstaticword.UserProfile') }}</a></li>
	                        @if(Auth::User()->role == "user")
	                        <li><i class="fas fa-chalkboard-teacher"></i><a href="#" data-toggle="modal" data-target="#myModalinstructor" title="Become An Instructor">{{ __('frontstaticword.BecomeAnInstructor') }}</a></li>
	                        @endif
						
							<li><i class="fa fa-gift"></i>
							<a href="{{route('rewards.show',Auth::user()->id)}}">Refer a friend</a>
						    </li>
	                    </ul>
	                </div>
	            </div>
			
	            <div class="col-xl-9 col-lg-8">
                <div class="profile-info-block">
				<div class="profile-heading">Rewards</div>
				<div class="mb-5">		
				<p>If you love our courses, why not recommend us to your friends?</p>

                <p>After successful completion of your course, we’ll give you a unique link to you. If your friend purchases a
                   course using the link, you will get 5% discount on your next course.</p>

                <p>You can refer as many friends as you like, and each time a new customer is successfully referred by 
					you, you’ll get 5% discount.</p>
               </div><br><br>
			<table class="table table-bordered mb-5">
			  <thead>
			    <tr>
	               <th>Referral name</th>
				   <th>Discount</th> 
			    </tr>
			  </thead>
			  <tbody>

			  @if(count(Auth::user()->referrals)>0) 
			  <?php $i=0;  $r=5; $s=0; ?>

			  @foreach($referral as $refer)
				@php
				$course = App\Order::where('user_id',$refer->id)->first();
				$order = App\Order::where('user_id',$refer->id)->get();

                $userid = $course['user_id'];
				$user = App\User::where('id',$userid)->first(); 
				
				@endphp	
				  <tr>
					  @if(isset($course))
					  <td>{{ $user->fname }} {{ $user->lname }}</td>
					  <td>{{ $r }}%</td>
					  <?php  $i=$i+1; ?>

					  @endif

                  </tr>

			 @endforeach
            @if(!empty($i))
			 <tr class="font-weight-bold">
				 <td>Total</td>
				 <td>{{ $i*$r }}%</td>
			</tr>
			@else
			<tr>
			 <td class="text-center" colspan="2">No referrals yet</td>
             </tr>
			 @endif
			 @else 
			 <tr>
			 <td class="text-center" colspan="2">No referrals yet</td>
             </tr>
			 @endif
              </tbody>
            </table>
			   <a href="{{ route('cart.show') }}" class="btn btn-primary">Get Rewards</a>

                 </div>
                </div>
	        </div>

    </div>
</section>



@endsection

