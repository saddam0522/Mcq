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
                            <h2 class="title">@lang('Employer Login')</h2>
                            <h3 class="sub-title">@lang('Don\'t Have An Account')? <a href="{{ route('employer.register') }}">@lang('Register Now')</a></h3>
                        </div>

                        <form method="POST" action="{{ route('employer.login') }}" class="account-form verify-gcaptcha">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-sm-12">
                                    <label for="email" class="form-label form--label">@lang('Email')</label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control form--control" required>
                                </div>
                                <div class="col-sm-12">
                                    <label for="password" class="form-label form--label">@lang('Password')</label>
                                    <input id="password" type="password" class="form-control form--control" name="password" required>
                                </div>
                                <div class="col-sm-12">
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
