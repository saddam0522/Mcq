@extends('templates.basic.layouts.auth')

@php
    $bg = getContent('login.content', true);
@endphp

@section('content')
    <section class="account-section section--bg bg-overlay-white bg_img" data-background="{{ frontendImage('login', @$bg->data_values->background_image) }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-6 col-xxl-5">
                    <div class="account-form-area">
                        <div class="account-logo-area text-center">
                            <div class="account-logo">
                                <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="logo"></a>
                            </div>
                        </div>

                        <div class="account-header text-center">
                            <h2 class="title">@lang('Login Your Account Now')</h2>
                            <h3 class="sub-title"> @lang('Don\'t Have An Account') ? <a href="{{ route('user.register') }}">@lang('Register Now')</a></h3>
                        </div>


                        @include($activeTemplate . 'partials.social_login')

                        <form method="POST" action="{{ route('user.login') }}" class="account-form verify-gcaptcha">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-sm-12">
                                    <label for="email" class="form-label form--label">@lang('Username or Email')</label>
                                    <input type="text" name="username" value="{{ old('username') }}" class="form-control form--control" required>
                                </div>
                                <div class="col-sm-12">
                                    <div class="d-flex flex-wrap justify-content-between mb-2">
                                        <label for="password" class="form-label form--label mb-0">@lang('Password')</label>
                                        <a class="fw-bold forgot-pass text--base fs-15" href="{{ route('user.password.request') }}">
                                            @lang('Forgot your password?')
                                        </a>
                                    </div>
                                    <input id="password" type="password" class="form-control form--control" name="password" required>
                                </div>
                                <div class="col-sm-12">
                                    <x-captcha />
                                    <div class="form-check form--check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">@lang('Remember Me')</label>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" id="recaptcha" class="submit-btn w-100">
                                        @lang('Login')
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
