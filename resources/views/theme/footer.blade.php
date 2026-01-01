<style>
    .logo-footer img {
        vertical-align: baseline;
        width: 60px;
        margin-top: -12px;
    }
</style>

<footer id="footer" class="footer-main-block">
    <div class="container">
        <div class="footer-block">
            <div class="row d-flex justify-content-between">
                @php
                    $widgets = App\WidgetSetting::first();
                @endphp
                @if (isset($widgets))

                    <div class="col-lg-3 col-md-6">
                        <div class="widget"><b>{{ $widgets->widget_one }}</b></div>
                        <div class="footer-link">
                            <ul>
                                @if ($gsetting->instructor_enable == 1)
                                    @if (Auth::check())
                                        @if (Auth::User()->role == 'user')
                                            <li><a href="#" data-toggle="modal" data-target="#myModalinstructor"
                                                    title="Become An Instructor">{{ __('frontstaticword.BecomeAnInstructor') }}</a>
                                            </li>
                                        @endif
                                    @else
                                        <li><a href="{{ route('login') }}"
                                                title="Become an instructor">{{ __('frontstaticword.BecomeAnInstructor') }}</a>
                                        </li>
                                    @endif
                                @endif
                                <li><a href="{{ route('about.show') }}"
                                        title="About">{{ __('frontstaticword.Aboutus') }}</a></li>

                                <li><a href="{{ url('user_contact') }}"
                                        title="About">{{ __('frontstaticword.Contactus') }}</a></li>
                                {{-- <li><a href="{{ route('careers.show') }}" title="Careers">{{ __('frontstaticword.Careers') }}</a></li> --}}
                                <li><a href="{{ route('help.show') }}"
                                        title="Help">{{ __('frontstaticword.Help&Support') }}</a></li>

                            </ul>
                        </div>
                    </div>
                    @if ($widgets->widget_two)
                        <div class="col-lg-3 col-md-6">
                            <div class="widget"><b>{{ $widgets->widget_two }}</b></div>
                            <div class="footer-link">
                                <ul>
                                    <!--<li><a href="{{ route('blog.all') }}" title="Blog">{{ __('frontstaticword.Blog') }}</a></li>-->
                                    @php
                                        $pages = App\Page::get();
                                    @endphp

                                    @if (isset($pages))
                                        @foreach ($pages as $page)
                                            @if ($page->status == 1)
                                                <li><a href="{{ route('page.show', $page->slug) }}"
                                                        title="Help">{{ $page->title }}</a></li>
                                            @endif
                                        @endforeach
                                    @endif

                                </ul>
                            </div>
                        </div>
                    @endif
                    <div class="col-lg-3 col-md-6">
                        <div class="widget"><b>{{ $widgets->widget_three }}</b></div>
                        <div class="footer-link">
                            <ul>
                                {{-- <li><a href="{{ route('help.show') }}"
                                        title="Help">{{ __('frontstaticword.Help&Support') }}</a></li> --}}
                                {{-- <li><a href="{{ asset('navigation-guide') }}"  title="Navigation Guide">Navigation Guide</a></li> --}}

                            </ul>
                        </div>
                    </div>
                @endif
                <div class="col-lg-3 col-md-6">
                    @php
                        $languages = App\Language::all();
                    @endphp
                    <div class="footer-social-list">
                        {{-- <div class="widget"><b>JOIN OUR NEWSLETTER</b></div>
                    <form action="{{ asset('chimpcurl') }}" method="post">
                      {{csrf_field()}}
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" name="email" placeholder="Enter your Email" aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                     <div class="input-group-append">
                        <button type="submit" class="input-group-text btn" id="basic-addon2">Subscribe</button>
                     </div>
                   </div>
                   </form> --}}

                        {{-- <ul>
                            <li><a href="#" target="_blank" title="facebook"><i class="fab fa-facebook-f"></i></a>
                            </li>
                            <li><a href="#" target="_blank" title="instagram"><i class="fab fa-instagram"
                                        aria-hidden="true"></i></a></li>
                            <li><a href="#" target="_blank" title="twitter"><i class="fab fa-twitter"
                                        aria-hidden="true"></i></a></li>
                            <li><a href="#" target="_blank" title="youtube"><i class="fab fa-youtube"
                                        aria-hidden="true"></i></a></li>
                        </ul> --}}

                        <ul>
                            <li><a target="_blank" title="facebook"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a target="_blank" title="instagram"><i class="fa fa-instagram"
                                        aria-hidden="true"></i></a></li>
                            <li><a target="_blank" title="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            </li>
                            <li><a target="_blank" title="youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                            </li>
                        </ul>
                    </div>
                    @if (isset($languages) && count($languages) > 0)
                        <div class="footer-dropdown txt-rgt">
                            {{-- <a href="#" class="a" data-toggle="dropdown"><i class="fa fa-globe rgt-15"></i>{{Session::has('changed_language') ? ucfirst(Session::get('changed_language')) : ''}}<i class="fa fa-angle-up lft-10"></i></a> --}}


                            <ul class="dropdown-menu">

                                @foreach ($languages as $language)
                                    <a href="{{ route('languageSwitch', $language->local) }}">
                                        <li>{{ $language->name }}</li>
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="tiny-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="logo-footer">
                        <ul>
                            @php
                                $logo = App\Setting::first();
                            @endphp
                            <li>
                                @if ($logo->logo_type == 'L')
                                    <a href="{{ url('/') }}" title="logo">
                                        <img src="{{ asset('files/logo/' . $logo->logo) }}" alt="Nihaws logo"
                                            class="img-fluid" width="100%" height="100%";>
                                        {{-- <img src="{{ env('AWS_URL').('Storage/images/logo/'.$logo->logo) }}" alt="Integrated Development Program logo" class="img-fluid" width="100%" height="100%";> --}}
                                    </a>
                                @else()
                                    <a href="{{ url('/') }}"><b>{{ $logo->project_title }}</b></a>
                                @endif
                            </li>

                            <li>{{ $cpy_txt }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="copyright-social">
                        <ul>
                            <li><a href="{{ url('terms_condition') }}"
                                    title="Terms">{{ __('frontstaticword.Terms&Condition') }}</a></li>
                            <li><a href="{{ url('privacy_policy') }}"
                                    title="Policy">{{ __('frontstaticword.PrivacyPolicy') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

@include('instructormodel')
