@section('title', 'Reset Password')
@include('theme.head')

@include('admin.message')

<!-- end head -->
<style>
    .invalid{
        color: red;
    }
    .is-invalid{
         box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
</style>
<!-- body start-->

<body>


    <section id="signup" class="signup-block-main-block">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('frontstaticword.ResetPassword') }}</div>

                        <div class="card-body">

                            {{-- @dd($errors) --}}
                                {{-- @if ($errors->any())
                                        <div class="alert alert-danger" id="myDiv">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif --}}
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group row">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-right">{{ __('frontstaticword.E-MailAddress') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                            {{-- <span class="invalid-feedback" role="alert"> --}}
                                                <span class="invalid">{{ $errors->first('email') }}</span>
                                            {{-- </span> --}}
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-right">{{ __('frontstaticword.Password') }}</label>

                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input id="password" type="password"
                                                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                name="password" required>
                                            <div class="input-group-append">
                                                <span toggle="#password-field"
                                                    style="padding: 14px;padding-right: 29px; background-color:#06193a;"
                                                    class="fa fa-fw fa-eye-slash field_icon toggle-password1 input-group-text"></span>
                                            </div>
                                        </div>
                                        @if ($errors->has('password'))
                                            <span class="invalid" >{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm"
                                        class="col-md-4 col-form-label text-md-right">{{ __('frontstaticword.ConfirmPassword') }}</label>

                                    <div class="col-md-6">
                                        {{-- <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required> --}}
                                        <div class="input-group mb-3">
                                            <input id="password-confirm" type="password" class="form-control"
                                                name="password_confirmation" required>
                                            <div class="input-group-append">
                                                <span toggle="#password-field"
                                                    style="padding: 14px;padding-right: 29px; background-color:#06193a;"
                                                    class="fa fa-fw fa-eye-slash field_icon toggle-password2 input-group-text"></span>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('frontstaticword.ResetPassword') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('theme.scripts')
    <script>
        $(document).on('click', '.toggle-password1', function() {

            $(this).toggleClass("fa-eye fa-eye");

            var input = $("#password");
            input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
        });
        $(document).on('click', '.toggle-password2', function() {

            $(this).toggleClass("fa-eye fa-eye");

            var input = $("#password-confirm");
            input.attr('type') === 'password' ? input.attr('type', 'text') : input.attr('type', 'password')
        });
      $(document).on('input', '#email, #password, #password-confirm', function () {
            $(this).removeClass('is-invalid');
            $('#myDiv').addClass('d-none');

            $('#myDiv').empty();
        });
    </script>
    <!-- end jquery -->
</body>
<!-- body end -->

</html>
