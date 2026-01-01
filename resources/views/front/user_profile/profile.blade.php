@extends('theme.master')
@section('title', 'Profile & Setting')
@section('content')




    @include('admin.message')

    <!-- about-home start -->
    <section id="blog-home" class="blog-home-main-block">
        <div class="container">
            <h1 class="blog-home-heading text-white">{{ __('frontstaticword.UserProfile') }}</h1>
        </div>
    </section>

    <!-- profile update start -->
    <section id="profile-item" class="profile-item-block">
        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
        <div class="container">
            <form  id="UpdateProfile" action="{{ route('user.profile', $orders->id) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{-- {{ method_field('PUT') }} --}}

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
                                        @if (Auth::User()->user_img != null || Auth::User()->user_img != '')
                                            <div class="avatar-preview-img" id="imagePreview"
                                                style="background-image: url('{{ url('/images/user_img/' . Auth::user()->user_img) }}');">
                                            </div>
                                        @else
                                            <div class="avatar-preview-img" id="imagePreview"
                                                style="background-image: url({{ asset('images/default/user.jpg') }});">
                                            </div>
                                        @endif
                                    </div>
                                    @error('user_img')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="author-name">{{ Auth::User()->fname }}&nbsp;{{ Auth::User()->lname }}</div>
                        </div>
                        <div class="dashboard-items">
                            <ul>
                                {{-- <li><i class="fa fa-bookmark"></i><a href="{{ route('mycourse.show') }}" title="Dashboard">{{ __('frontstaticword.MyCourses') }}</a></li>
	                        <li><i class="fa fa-heart"></i><a href="{{ route('wishlist.show') }}" title="Profile Update">{{ __('frontstaticword.MyWishlist') }}</a></li>
	                        <li><i class="fa fa-history"></i><a href="{{ route('purchase.show') }}" title="Followers">{{ __('frontstaticword.PurchaseHistory') }}</a></li> --}}
                                <li><i class="fa fa-user"></i><a href="{{ route('profile.show', Auth::User()->id) }}"
                                        title="Upload Items">{{ __('frontstaticword.UserProfile') }}</a></li>
                                @if (Auth::User()->role == 'user')
                                    <!--<li><i class="fas fa-chalkboard-teacher"></i><a href="#" data-toggle="modal" data-target="#myModalinstructor" title="Become An Instructor">{{ __('frontstaticword.BecomeAnInstructor') }}</a></li>-->
                                @endif
                                <!--                  <li><i class="fa fa-gift"></i>-->
                                <!--<a href="{{ route('rewards.show', Auth::user()->id) }}">Refer a friend</a>-->
                                <!--   </li>-->
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-8">

                        <div class="profile-info-block">
                            <div class="profile-heading">{{ __('frontstaticword.PersonalInfo') }}</div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                         <label for="name">{{ __('frontstaticword.FirstName') }}</label>
                                                <input type="text" id="name_form" name="fname"
                                                    class="form-control form-control-sm @error('fname') is-invalid @enderror"
                                                    placeholder="Enter First Name"
                                                    value="{{ old('fname', $orders->fname) }}">

                                                @error('fname')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        {{-- <small class="text-danger">* Enter name as per your SSLC Certificate</small> --}}
                                    </div>
                                    <div class="form-group">
                                        <label for="email">{{ __('frontstaticword.Email') }}</label>
                                        <input type="email" id="email" name="email"
                                            class="form-control form-control-sm @error('email') is-invalid @enderror"
                                            placeholder="info@example.com"
                                            value="{{ old('email', $orders->email) }}">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email">{{ __('frontstaticword.DateofBirth') }}</label>
                                        <input type="date" id="date" name="dob"
                                            class="form-control form-control-sm" placeholder="Enter date of birth"
                                            value="{{ $orders->dob }}">
                                          

                                            <div class="text-danger" id="dateError"> </div>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="Username">{{ __('frontstaticword.LastName') }}</label>
                                        <input type="text" id="lname_form" name="lname"
                                              class="form-control form-control-sm @error('lname') is-invalid @enderror" placeholder="Enter Last Name"
                                           value="{{ old('lname', $orders->lname) }}">
                                           @error('lname')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">{{ __('frontstaticword.Mobile') }}</label>
                                        <input type="text" name="mobile" id="mobile"  value="{{ old('mobile' , $orders->mobile) }}" maxlength="10"
                                             class="form-control form-control-sm @error('mobile') is-invalid @enderror" placeholder="Enter Mobile No.">
                                            <div class="text-danger" id="mobileError"> </div>
                                             @error('mobile')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                    </div>
                                    <div class="form-group">
                                        <label for="gender">{{ __('frontstaticword.ChooseGender') }}:</label>
                                        <br>
                                        <input type="radio" name="gender" id="ch1" value="m"
                                            {{ $orders->gender == 'm' ? 'checked' : '' }}>
                                        {{ __('frontstaticword.Male') }}
                                        <br>
                                        <input type="radio" name="gender" id="ch2" value="f"
                                            {{ $orders->gender == 'f' ? 'checked' : '' }}>
                                        {{ __('frontstaticword.Female') }}
                                        <br>
                                        <input type="radio" name="gender" id="ch3" value="o"
                                            {{ $orders->gender == 'o' ? 'checked' : '' }}>
                                        {{ __('frontstaticword.Other') }}
                                    </div>
                                            <div class="text-danger" id="genderError"> </div>


                                </div>
                            </div>

                            <div class="form-group">
                                <label for="bio">{{ __('frontstaticword.address') }}</label>
                                <textarea id="address" name="address" class="form-control form-control-sm" placeholder="Enter your Address"
                                    value="">{{ $orders->address }}</textarea>
                            </div>
                            <br>

                            <div class="row">
                                {{-- <div class="col-lg-4">
	                        	<div class="form-group">
	                                <label for="city_id">{{ __('frontstaticword.Country') }}:</label>
					                <select id="country_id" class="form-control form-control-sm custom-select js-example-basic-single" name="country_id">
					                  	<option value="none" selected disabled hidden> 
					                      {{ __('frontstaticword.SelectanOption') }}
					                    </option>
					                  
					                  @foreach ($countries as $coun)
					                    <option value="{{ $coun->country_id }}" {{ $orders->country_id == $coun->country_id ? 'selected' : ''}}>{{ $coun->nicename }}
					                    </option>
					                  @endforeach
					                </select>
	                            </div>
	                        </div> --}}
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="city_id">{{ __('frontstaticword.State') }}:</label>
                                        <select id="upload_id"
                                            class="form-control form-control-sm js-example-basic-single" name="state_id">
                                            <option value="none" selected disabled hidden>
                                                {{ __('frontstaticword.SelectanOption') }}
                                            </option>
                                            @foreach ($states as $s)
                                                <option value="{{ $s->id }}"
                                                    {{ $orders->state_id == $s->id ? 'selected' : '' }}>{{ $s->name }}
                                                </option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="city_id">{{ __('frontstaticword.City') }}:</label>
                                        <select id="grand"
                                            class="form-control form-control-sm js-example-basic-single" name="city_id">
                                            <option value="none" selected disabled hidden>
                                                {{ __('frontstaticword.SelectanOption') }}
                                            </option>
                                            @foreach ($cities as $c)
                                                <option value="{{ $c->id }}"
                                                    {{ $orders->city_id == $c->id ? 'selected' : '' }}>{{ $c->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="form-group">-->
                            <!--    <label for="bio">{{ __('frontstaticword.AuthorBio') }}</label>-->
                            <!--    <textarea id="detail" name="detail" class="form-control form-control-sm" placeholder="Enter your details"
                                value="">{{ $orders->detail }}</textarea>-->
                            <!--</div>-->
                            <br>
                            <label for="">Education Details : </label>
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="qualification">Highest Qualification : </label>
                                    <input type="text" id="qualification" name="qualification" class="form-control"
                                        placeholder="Highest Qualification" value="{{ $orders->qualification }}">

                                </div>
                                <div class="col-lg-4">
                                    <label for="school_name">University/School Name : </label>
                                    <input type="text" id="school_name" name="school_name" class="form-control"
                                        placeholder="University/School Name" value="{{ $orders->school_name }}">

                                </div>
                                <div class="col-lg-4">
                                    <label for="education_city">City : </label>
                                    <input type="text" id="education_city" name="education_city" class="form-control"
                                        placeholder="University/School City" value="{{ $orders->education_city }}">

                                </div>
                            </div>
                            <br>
                            <label for="">Employment Details : </label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="organization">Organization : </label>
                                    <input type="text" id="organization" name="organization" class="form-control"
                                        placeholder="Organization name" value="{{ $orders->organization }}">
                                </div>
                                <div class="col-lg-6">
                                    <label for="designation">Designation : </label>
                                    <input type="text" id="designation" name="designation" class="form-control"
                                        placeholder="Designation" value="{{ $orders->designation }}">
                                </div>
                            </div>
                            <br>


                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="update-password">
                                        <label for="box1"><b>{{ __('frontstaticword.UpdatePassword') }}:</b></label>
                                        <input type="checkbox" name="update_pass" id="myCheck" onclick="myFunction()">
                                    </div>
                                </div>
                            </div>
                         <div class="password display-none" id="update-password">
                            <div class="row">
                                <!-- Password -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="password">{{ __('frontstaticword.Password') }}:</label>
                                        <div class="input-group">
                                            <input name="password" class="form-control form-control-sm" id="password"
                                                type="password" placeholder="Enter Password" onkeyup='check();' />
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="fa fa-eye-slash"></i>
                                            </button>
                                        </div>
                                        <div class="text-danger" id="passError"></div>
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>{{ __('frontstaticword.ConfirmPassword') }}:</label>
                                        <div class="input-group">
                                            <input type="password" name="confirm_password" id="confirm_password"
                                                class="form-control form-control-sm" placeholder="Confirm Password"
                                                onkeyup='check();' />
                                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                                <i class="fa fa-eye-slash"></i>
                                            </button>
                                        </div>
                                        <span id='message'></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                            <br>
                        </div>
                        <div class="social-profile-block">
                            <div class="social-profile-heading">{{ __('frontstaticword.SocialProfile') }}</div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="social-block">
                                        <div class="form-group">
                                            <label for="facebook">{{ __('frontstaticword.FacebookUrl') }}</label><br>
                                            <div class="row">
                                                <div class="col-lg-2 col-2">
                                                    <div class="profile-update-icon">
                                                        <div class="product-update-social-icons"><a
                                                                href="https://www.facebook.com/{{ $orders->fb_url }}"
                                                                target="_blank" title="facebook"><i
                                                                    class="fa fa-facebook facebook"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 col-10">
                                                    <input type="text" name="fb_url" value="{{ $orders->fb_url }}"
                                                        id="facebook" class="form-control form-control-sm"
                                                        placeholder="Facebook.com/">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="social-block">
                                        <div class="form-group">
                                            <label for="behance2">{{ __('frontstaticword.YoutubeUrl') }}</label><br>
                                            <div class="row">
                                                <div class="col-lg-2 col-2">
                                                    <div class="profile-update-icon">
                                                        <div class="product-update-social-icons"><a
                                                                href="https://www.youtube.com/
                                                                        {{ $orders->youtube_url }}"
                                                                target="_blank" title="googleplus"><i
                                                                    class="fab fa-youtube youtube"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 col-10">
                                                    <input type="text" name="youtube_url"
                                                        value="{{ $orders->youtube_url }}" id="behance2"
                                                        class="form-control form-control-sm" placeholder="youtube.com/">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="social-block">
                                        <div class="form-group">
                                            <label for="twitter">{{ __('frontstaticword.TwitterUrl') }}</label><br>
                                            <div class="row">
                                                <div class="col-lg-2 col-2">
                                                    <div class="profile-update-icon">
                                                        <div class="product-update-social-icons"><a
                                                                href="https://www.twitter.com/{{ $orders->twitter_url }}"
                                                                target="_blank" title="twitter"><i
                                                                    class="fab fa-twitter twitter"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 col-10">
                                                    <input type="text" name="twitter_url"
                                                        value="{{ $orders->twitter_url }}" id="twitter"
                                                        class="form-control form-control-sm" placeholder="Twitter.com/">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="social-block">
                                        <div class="form-group">
                                            <label for="dribbble2">{{ __('frontstaticword.LinkedInUrl') }}</label><br>
                                            <div class="row">
                                                <div class="col-lg-2 col-2">
                                                    <div class="profile-update-icon">
                                                        <div class="product-update-social-icons"><a
                                                                href="https://in.linkedin.com/{{ $orders->linkedin_url }}"
                                                                target="_blank" title="linkedin"><i
                                                                    class="fab fa-linkedin-in linkedin"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 col-10">
                                                    <input type="text" name="linkedin_url"
                                                        value="{{ $orders->linkedin_url }}" id="dribbble2"
                                                        class="form-control form-control-sm" placeholder="Linkedin.com/">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="upload-items text-right">
                            <button type="submit" class="btn btn-primary" 
                                title="upload items">{{ __('frontstaticword.UpdateProfile') }}</button>
                        </div>

                    </div>
                </div>

            </form>
        </div>
    </section>
    <!-- profile update end -->
@endsection

@section('custom-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        (function($) {
            "use strict";
            $(function() {
                var urlLike = '{{ url('country/dropdown') }}';
                $('#country_id').change(function() {
                    var up = $('#upload_id').empty();
                    var cat_id = $(this).val();
                    if (cat_id) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "GET",
                            url: urlLike,
                            data: {
                                catId: cat_id
                            },
                            success: function(data) {
                                console.log(data);
                                up.append('<option value="0">Please Choose</option>');
                                $.each(data, function(id, title) {
                                    up.append($('<option>', {
                                        value: id,
                                        text: title
                                    }));
                                });
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                console.log(XMLHttpRequest);
                            }
                        });
                    }
                });
            });
        })(jQuery);
    </script>

    <script>
        (function($) {
            "use strict";
            $(function() {
                var urlLike = '{{ url('country/gcity') }}';
                $('#upload_id').change(function() {
                    var up = $('#grand').empty();
                    var cat_id = $(this).val();
                    if (cat_id) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "GET",
                            url: urlLike,
                            data: {
                                catId: cat_id
                            },
                            success: function(data) {
                                console.log(data);
                                up.append('<option value="0">Please Choose</option>');
                                $.each(data, function(id, title) {
                                    up.append($('<option>', {
                                        value: id,
                                        text: title
                                    }));
                                });
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                console.log(XMLHttpRequest);
                            }
                        });
                    }
                });
            });
        })(jQuery);
    </script>

    <script>
        (function($) {
            "use strict";

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                        $('#imagePreview').hide();
                        $('#imagePreview').fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#imageUpload").change(function() {
                readURL(this);
            });
        })(jQuery);
    </script>

    <script>
document.getElementById("togglePassword").addEventListener("click", function () {
    let password = document.getElementById("password");
    let icon = this.querySelector("i");
    if (password.type === "password") {
        password.type = "text";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    } else {
        password.type = "password";
        
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }
});
document.getElementById("toggleConfirmPassword").addEventListener("click", function () {
    let password = document.getElementById("confirm_password");
    let icon = this.querySelector("i");
    if (password.type === "password") {
        password.type = "text";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    } else {
        password.type = "password";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");


    }
});

        function myFunction() {
            var checkBox = document.getElementById("myCheck");
            var text = document.getElementById("update-password");
            if (checkBox.checked == true) {
                text.style.display = "block";
            } else {
                text.style.display = "none";
            }
        }
            document.addEventListener('DOMContentLoaded', function() {
                flatpickr("#date", {
                    dateFormat: "Y-m-d", 
                    maxDate: "today",
                    allowInput: true,
                });
            });

(function($) {
    "use strict";

    $('#password, #confirm_password').on('keyup', function() {
                $('#passError').text('');
        const password = $('#password').val().trim();
        const confirm_password = $('#confirm_password').val().trim();

        if (password === "" && confirm_password === "") {
            $('#message').text('');
            return;
        }

        if (password === confirm_password) {
            $('#message').text('Passwords match').css('color', 'green');
        } else {
            $('#message').text('Passwords do not match').css('color', 'red');
        }
    });
    $('#UpdateProfile').on('submit', function(e) {
        e.preventDefault();
        let valid = true;

        const password = $('#password').val().trim();
        const confirm_password = $('#confirm_password').val().trim();

        const passwordRegex =
           /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

        const checkBox = document.getElementById("myCheck");
        if (checkBox && checkBox.checked) {
            if (!passwordRegex.test(password)) {
                $('#passError').text(
                    'Password must be 8+ characters with uppercase, lowercase, number, and special character.'
                );
                valid = false;
            } else if (password !== confirm_password) {
                $('#passError').text("Confirm password doesn't match");
                valid = false;
            } else {
                $('#passError').text('');
            }
        }

        if (valid) {
            this.submit();
        }
    });

})(jQuery);

    </script>

    <script>
        (function($) {
            "use strict";
            tinymce.init({
                selector: 'textarea#detail'
            });
        })(jQuery);



    
    </script>
{{-- @dd($errors) --}}
@endsection
