@section('title', 'Sign Up')
@include('theme.head')
@include('admin.message')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .is-invalid {
    border-color: #dc3545 !important;
      box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}
</style>
<body>
    <section id="nav-bar" class="nav-bar-main-block nav-bar-main-block-one">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="nav-bar-btn btm-20">
                        <a href="{{ url('/') }}" class="btn btn-sm btn-secondary" title="Home">
                            <i class="fa fa-chevron-left"></i>{{ __('frontstaticword.Backtohome') }}
                        </a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="logo text-center btm-10">
                        @php
                            $logo = App\Setting::first();
                        @endphp

                        @if ($logo->logo_type == 'L')
                            <a href="{{ url('/') }}" title="logo">
                                <img src="{{ asset('files/logo/' . $logo->logo) }}" class="img-fluid" alt="logo">
                            </a>
                        @else
                            <a href="{{ url('/') }}">
                                <b>
                                    <div class="logotext">{{ $logo->project_title }}</div>
                                </b>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="Login-btn txt-rgt">
                        <a href="{{ route('login') }}" class="btn btn-sm btn-secondary" title="login">
                            {{ __('frontstaticword.Login') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="signup" class="signup-block-main-block">
        <div class="container">
            <div class="col-lg-6 col-md-8 offset-md-3">
                <div class="signup-heading text-center">
                    {{ __('frontstaticword.StartLearning') }}!
                </div>

                <div class="signup-block">
                    @if ($gsetting->fb_login_enable == 1)
                        <div class="signin-link">
                            <a href="{{ url('/auth/facebook') }}" target="_blank" class="btn btn-sm btn-info btm-10">
                                <i class="fa fa-facebook"></i>{{ __('frontstaticword.ContinuewithFacebook') }}
                            </a>
                        </div>
                    @endif

                    @if ($gsetting->google_login_enable == 1)
                        <div class="signin-link google">
                            <a href="{{ url('/auth/google') }}" target="_blank" class="btn btn-sm btn-white btm-10">
                                <i class="fab fa-google-plus-g"></i>{{ __('frontstaticword.ContinuewithGoogle') }}
                            </a>
                        </div>
                    @endif

                    @if ($gsetting->amazon_enable == 1)
                        <div class="signin-link amazon-button">
                            <a href="{{ url('/auth/amazon') }}" target="_blank" class="btn btn-sm btn-info btm-10">
                                <i class="fab fa-amazon"></i>{{ __('frontstaticword.ContinuewithAmazon') }}
                            </a>
                        </div>
                    @endif

                    @if ($gsetting->linkedin_enable == 1)
                        <div class="signin-link linkedin-button">
                            <a href="{{ url('/auth/linkedin') }}" target="_blank" class="btn btn-sm btn-info btm-10">
                                <i class="fab fa-linkedin"></i>{{ __('frontstaticword.ContinuewithLinkedin') }}
                            </a>
                        </div>
                    @endif

                    @if ($gsetting->twitter_enable == 1)
                        <div class="signin-link twitter-button">
                            <a href="{{ url('/auth/twitter') }}" target="_blank" class="btn btn-sm btn-info btm-10">
                                <i class="fab fa-twitter"></i>{{ __('frontstaticword.ContinuewithTwitter') }}
                            </a>
                        </div>
                    @endif

                    {{-- GitLab disabled --}}
                    {{-- @if ($gsetting->gitlab_login_enable == 1)
                        <div class="signin-link btm-10">
                            <a href="{{ url('/auth/gitlab') }}" target="_blank" class="btn btn-white">
                                <i class="fab fa-gitlab"></i>{{ __('frontstaticword.ContinuewithGitLab') }}
                            </a>
                        </div>
                    @endif --}}

                    <form class="signup-form" method="POST" id="dynamic-form" action="{{ route('register') }}">
                        @csrf
                        {{-- First Name --}}
                        <div class="form-group">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <input type="text"
                                class="form-control form-control-sm{{ $errors->has('fname') ? ' is-invalid' : '' }}"
                                name="fname" value="{{ old('fname') }}" id="fname" placeholder="First Name">
                            @if ($errors->has('fname'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('fname') }}</strong>
                                </span>
                            @endif
                        </div>

                        {{-- Last Name --}}
                        <div class="form-group">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <input type="text"
                                class="form-control form-control-sm{{ $errors->has('lname') ? ' is-invalid' : '' }}"
                                name="lname" value="{{ old('lname') }}" id="lname" placeholder="Last Name">
                            @if ($errors->has('lname'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('lname') }}</strong>
                                </span>
                            @endif
                        </div>

                        {{-- Employee ID --}}
                        <div class="form-group">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <input type="text"
                                class="form-control form-control-sm{{ $errors->has('emp_id') ? ' is-invalid' : '' }}"
                                name="emp_id" value="{{ old('emp_id') }}" id="emp_id" placeholder="Employee Id">
                            @if ($errors->has('emp_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('emp_id') }}</strong>
                                </span>
                            @endif
                        </div>

                        {{-- Email --}}
                        <div class="form-group">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <input type="email"
                                class="form-control form-control-sm{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                name="email" value="{{ old('email') }}" id="email" placeholder="Email">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        {{-- Mobile --}}
                        @if ($gsetting->mobile_enable == 1)
                            <div class="form-group">
                                <span><i class="fa fa-phone" aria-hidden="true"></i></span>
                                <input type="text" maxlength="10" pattern="\d{10}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    class="form-control form-control-sm{{ $errors->has('mobile') ? ' is-invalid' : '' }}"
                                    name="mobile" value="{{ old('mobile') }}" id="mobile" placeholder="Mobile">
                                @if ($errors->has('mobile'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @endif
                            </div>
                        @endif

                        {{-- Role --}}
                        <div class="form-group">
                            <span><i class="fa fa-user" aria-hidden="true"></i></span>
                            <select class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}"
                                name="role">
                                <option value="" selected disabled hidden>Select Role</option>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                <option value="trainer" {{ old('role') == 'trainer' ? 'selected' : '' }}>Trainer
                                </option>
                            </select>
                            @if ($errors->has('role'))
                                <span id="error-role" class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('role') }}</strong>
                                </span>
                            @endif
                        </div>

                        {{-- Password --}}
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <span><i class="fa fa-lock" aria-hidden="true"></i></span>
                                <input type="password"
                                    class="form-control form-control-sm{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    name="password" id="password" value="{{ old('password') }}"
                                    placeholder="Password">
                                <div class="input-group-append">
                                    <span toggle="#password"
                                        class="fa fa-fw fa-eye-slash field_icon toggle-password1 input-group-text"
                                        style="padding: 14px; padding-right: 29px; background-color:#06193a;">
                                    </span>
                                </div>
                                <span id="pwd-match-error" class="invalid-feedback" style="display:none;"></span>
                            </div>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback d-block" role="alert"  >
                                    <strong id="password-error">{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        {{-- Confirm Password --}}
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <span><i class="fa fa-lock" aria-hidden="true"></i></span>
                                <input id="password-confirm" type="password" class="form-control form-control-sm"
                                    name="password_confirmation" value="{{ old('password_confirmation') }}"
                                    placeholder="Confirm Password">
                                <div class="input-group-append">
                                    <span toggle="#password-confirm"
                                        class="fa fa-fw fa-eye-slash field_icon toggle-password2 input-group-text"
                                        style="padding: 14px; padding-right: 29px; background-color:#06193a;">
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Terms --}}
                        <div class="signin-link text-center btm-20">
                            <div class="form-check d-inline-block">
                                <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror"
                                    id="termsCheck" name="terms">
                                <label class="form-check-label" for="termsCheck">
                                    {{ __('frontstaticword.Bysigningup') }}
                                    <a href="{{ url('/terms_condition') }}" target="_blank">
                                        {{ __('frontstaticword.Terms&Condition') }}
                                    </a>
                                </label>
                            </div>
                            @error('terms')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" id="signup-button" class="btn btn-sm btn-primary btm-20">
                            {{ __('frontstaticword.Signup') }}
                        </button>

                        <hr>
                        <div class="sign-up text-center">
                            {{ __('frontstaticword.Alreadyhaveanaccount') }}?
                            <a href="{{ route('login') }}">{{ __('frontstaticword.Login') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @include('theme.scripts')

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
                                up.append('<option value="">Please Choose</option>');
                                $.each(data, function(id, title) {
                                    up.append($('<option>', {
                                        value: id,
                                        text: title
                                    }));
                                });
                            }
                        });
                    }
                });
            });
        })(jQuery);
        
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('dynamic-form');
        const submitButton = document.getElementById('signup-button');

        form.addEventListener('submit', function (e) {
            
            submitButton.disabled = true;
        });
    });
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
                                up.append('<option value="">Please Choose</option>');
                                $.each(data, function(id, title) {
                                    up.append($('<option>', {
                                        value: id,
                                        text: title
                                    }));
                                });
                            }
                        });
                    }
                });
            });
        })(jQuery);
    </script>

    <script>
        $(document).on('click', '.toggle-password1, .toggle-password2', function() {
            const input = $($(this).attr("toggle"));
            const type = input.attr("type") === "password" ? "text" : "password";
            input.attr("type", type);
            $(this).toggleClass("fa-eye fa-eye-slash");
        });
    </script>

    <script>
        $(document).ready(function () {
    $('#password, #password-confirm').on('input', function () {
        $(this).removeClass('is-invalid');
        $('#password-error').hide();
        $('#pwd-match-error').hide().text('');
    });
});

        $(document).ready(function() {
            $('input, select').on('input change', function() {
                var $field = $(this);
                $field.siblings('.invalid-feedback').fadeOut();
                $field.closest('.form-group, .input-group').find('.invalid-feedback').fadeOut();
                $field.closest('.form-group').find('.invalid-feedback').fadeOut();
                $field.removeClass('is-invalid');
            });
        });
    </script>
</body>

</html>
